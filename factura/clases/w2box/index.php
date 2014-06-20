<?php
/* w2box: web 2.0 File Repository v3.2
* (c) 2005-2006, Clément Beffa
* http://labs.beffa.org/w2box/
*
* Use it at your own risk ;)
*
*/

// you should edit config.php in order to configure this script.
require("../../admin/session.php");
require("config.php");


//authentication
$auth = !$config['admin_actived'];
authorize(true); //silent authorize first
if (isset($_GET["admin"])) {
	authorize();
	Header("Location: ".rooturl());
}

//bruteforce php ini, almost never work except on old php..
ini_set('post_max_size','500M') ;
ini_set('upload_max_filesize','500M');
ini_set('memory_limit','500M');
//find real max_filesize
$max_filesize = $config['max_filesize'] * pow(1024,2);

if (!$config['upload_progressbar']) //doesn't apply with the perl script
	$max_filesize = min(return_bytes(ini_get('post_max_size')),return_bytes(ini_get('upload_max_filesize')),return_bytes(ini_get('memory_limit')),$max_filesize);

// deleting
if (isset($_POST["delete"])) {
	if ($config['protect_delete']) authorize();
	deletefile($_POST["delete"]);
}

function deletefile($cell){
	global $config, $lang;

	//decode str
	$str=stripslashes(urldecode($cell));
	$str=substr($str, strpos($str,'href="?download=')+16);
	$str=substr($str,0, strpos($str,'"'));
	$file = $config['storage_path'].'/'.basename($str);

	if (!file_exists($file))
	echo $lang['delete_error_notfound']." ($file)";
	else {
		$return = @unlink($file);
		if ($config['log_delete']) logadm($lang['DELETE']." ".$file);
		if ($return) echo "successful"; else echo $lang['delete_error_cant'];
	}
	exit;
}

//progress bar notification
if (isset ($_POST['progress'])){
	//define filenames
	$sessionid = basename($_POST['progress']);
	$tmp_dir = $config['upload_tmpdir'];
	$error_file = $tmp_dir."/$sessionid"."_err";
	$signal_file = $tmp_dir."/$sessionid"."_signal";
	$info_file = $tmp_dir."/$sessionid"."_flength";
	$data_file = $tmp_dir."/$sessionid"."_postdata";

	if(!file_exists($tmp_dir)) {
		header("HTTP/1.1 500 Internal Server Error");
		echo "tmp directory is invalid!";
	} else if(file_exists($error_file)) {
		# Send error code if error file exists
		header("HTTP/1.1 500 Internal Server Error");
		echo file_get_contents($error_file);
		//clean the shit
		$files = array($info_file,$data_file,$error_file,$signal_file);
		foreach($files as $file) {
			if(file_exists($file)) {
				unlink($file);
			}
		}
	} else if (file_exists($signal_file)) {
		echo "FINISHED";
	} else if (file_exists($info_file)){
		$total = file_get_contents($info_file);
		$current = @filesize($data_file);
		echo intval(($current / $total) * 100);
	}
	else echo '0';
	exit;
}

//progressbar upload
if ($config['upload_progressbar']){
	if (isset($_GET['sid'])) {
		$sid = $_GET['sid'];
		$tmp_dir = $config['upload_tmpdir'];
		$sid = ereg_replace("[^a-zA-Z0-9]","",$sid);//clean sid
		$file = $tmp_dir.'/'.$sid.'_qstring';
		if(!file_exists($file)) {
			$errormsg = $lang['upload_error_sid'];
		} else {
			$qstr = join("",file($file));
			//parse_str($qstr);
			parse_str($qstr, $_POST);			

			//cleaning shit
			$exts = array("_flength","_postdata","_err","_signal","_qstring");
			foreach($exts as $ext) {
				if(file_exists("$tmp_dir/$sid$ext")) {
					@unlink("$tmp_dir/$sid$ext");
				}
			}
			
			//setting vars like without progressbar
			$_FILES['file']['name']=basename($_POST['file']['name']['0']);
			$_FILES['file']['size']=$_POST['file']['size']['0'];
			$_FILES['file']['tmp_name']=$_POST['file']['tmp_name']['0'];
		}
	} else if (isset($_POST['errormsg'])) {
		$errormsg = urldecode($_POST['errormsg']);
		if ($errormsg =="The maximum upload size has been exceeded")
		$errormsg = $lang['upload_error_sizelimit'].' ('.getfilesize($max_filesize).').';
	}
}

//uploading
if (isset($_FILES['file'])) {
	if ($config['protect_upload']) authorize();
	uploadfile($_FILES['file']);
}

function uploadfile($file) {
	global $config, $lang, $max_filesize, $errormsg;

	if ($file['error']!=0) {
		$errormsg = $lang['upload_error'][$file['error']];
		return;
	}

	//determine filename
	$filename=$file['name'];
	if (isset($_POST['filename']) && $_POST['filename']!="") $filename=$_POST['filename'];
	//$filename=str_replace(" ","_",$filename);
	$filename=basename($filename);
	if (!in_array(strtolower(extname($filename)), $config['allowed_ext'])) $filename .= ".badext";

	$filesize=$file['size'];
	if ($filesize > $max_filesize) {
		@unlink($file['tmp_name']);
		$errormsg = $lang['upload_error_sizelimit'].' ('.getfilesize($max_filesize).').';
		return;
	}

	$filedest = $config['storage_path'].'/'.$filename;
	if (file_exists($filedest) && !$config['allow_overwrite']) {
		@unlink($file['tmp_name']);
		$errormsg = "$filename ".$lang['upload_error_fileexist'];
		return;
	}

	$filesource=$file['tmp_name'];
	if (!file_exists($filesource)) {
		$errormsg = "$filesource do no exist!";
		return;
	} else if (!move_uploaded_file($filesource,$filedest)) {
		if (!rename($filesource,$filedest)) {
			$errormsg = $lang['upload_error_nocopy'];
			return;
		}
	}

	if  ($errormsg=="") {
		chmod ($filedest, 0755);
		if ($config['log_upload']) logadm($lang['UPLOAD'].' '.$filedest);
		Header("Location: ".rooturl());
		exit;
	}
}

//downloading
if (isset($_GET['download']))
downloadfile($_GET['download']);

function downloadfile($file){
	global $config, $lang;
	$file = $config['storage_path'].'/'.basename($file);
	if (!is_file($file)) { return; }
	header("Content-Type: application/octet-stream");
	header("Content-Size: ".filesize($file));
	header("Content-Disposition: attachment; filename=\"".basename($file)."\"");
	header("Content-Length: ".filesize($file));
	header("Content-transfer-encoding: binary");
	@readfile($file);
	if ($config['log_download']) logadm($lang['DOWNLOAD'].' '.$file);
	exit;
}

function authorize($silent=false){
	global $config, $lang, $auth;
	//authentication
	if (!$auth){
		if ((isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_password'])) &&
		($_SESSION['usuario_id'] == $config['admin_username'] && $_SESSION['usuario_password']==$config['admin_password'])) {
			$auth = true; // user is authenticated
		} else {
			if (!$silent) {
				header( 'WWW-Authenticate: Basic realm="w2box admin"' );
				header( 'HTTP/1.0 401 Unauthorized' );
				echo 'Your are not allowed to access this function!';
				exit;
			}
		}
	}

}

function extname($file) {
	$file = explode(".",basename($file));
	return $file[count($file)-1];
}

function getfilesize($size) {
	//if ($size < 2) return "$size byte";
	$units = array(' B', ' KiB', ' MiB', ' GiB', ' TiB');
	for ($i = 0; $size > 1024; $i++) { $size /= 1024; }
	return round($size, 2).$units[$i];
}

function return_bytes($val) {
	$val = trim($val);
	if (empty($val)) return pow(1024,3);
	$last = strtolower($val{(strlen($val)-1)});
	switch($last) {
		// The 'G' modifier is available since PHP 5.1.0
		case 'g':
		$val *= 1024;
		case 'm':
		$val *= 1024;
		case 'k':
		$val *= 1024;
	}
	return $val;
}

function rooturl(){
	$dir = dirname($_SERVER['PHP_SELF']);
	if (strlen($dir) > 1) $dir.="/";

	return "http://".$_SERVER['HTTP_HOST'].$dir;
}

function logadm($str) {
	global $config, $lang;
	if (!$config['log']) return;

	$file_handle = fopen($config['log_filename'],"a+");
	fwrite($file_handle, date("Y-m-d\TH:i:s").' '.sprintf("%15s",$_SERVER["REMOTE_ADDR"]).' '. $str."\n");
	fclose($file_handle);
}

function ls($dir) {
	global $config, $lang, $auth, $demo;
	if ($demo){
		// demo code -- deleteme file
		$file = "data/deleteme.txt";
		if (!$file_handle = fopen($file,"a")) { echo "Cannot open file"; }
		if (!fwrite($file_handle, "Delete me or I'll become fat!!!\n")) { echo "Cannot write to file"; }
		fclose($file_handle);
	}

	$files = Array();
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".."  && $file != "index.html") {
				$size=filesize($dir."/".$file);
				$date=filemtime($dir."/".$file);
				$ext=strtolower(extname($file));
				if ($config['delete_after'] && ($date < mktime(0, 0, 0, date("m"), date("d")-$config['delete_after'], date("Y")))){
					@unlink($dir."/".$file);
				} else
					$files[] = Array('file'=>$file,'date'=>$date, 'size'=>$size, 'ext'=>$ext);
			}
		}
		closedir($handle);

	}
	if (is_array($files) && !empty($files)) {
		foreach ($files as $key => $row) {
   			$fn[$key]  = strtolower($row['file']);
		}
		array_multisort($fn, SORT_ASC, SORT_STRING, $files);
	}
	return $files;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
  <title><?php echo $config['w2box_title']; ?> | Administraci&oacute;n [POC-CMS]</title>
  <link rel="stylesheet" type="text/css" href="w2box.css" />
  <script type="text/javascript">
  <!--//<![CDATA[
  var ALLOWED_TYPES = '.<?php echo join(".",$config['allowed_ext']); ?>.';
  var MAX_FILESIZE = <?php echo $max_filesize; ?>;
  var UPLOAD_SCRIPT = '<?php echo $config['upload_cgiscript']; ?>';
  //]]>-->
  </script>
  <script type="text/javascript" src="pt.ajax.js"></script>
  <script type="text/javascript" src="sorttable.js"></script>  
  <script type="text/javascript" src="w2box.js"></script>

<style type="text/css">
h1 {
FONT-FAMILY: Arial, Helvetica, sans-serif;
FONT-SIZE: 20px;
color:#666666;
}
.caja1 {
PADDING-RIGHT: 3px;
PADDING-LEFT: 3px;
FONT-FAMILY: Arial, Helvetica, sans-serif;
FONT-SIZE: 12px;
PADDING-BOTTOM: 1px;
MARGIN: 0px 0px 0px 0px;
PADDING-TOP: 1px;
color: #666666;
background-color: #ffffff;
border: 1px solid #666666;
}
</style>

</head>

<body onload="filetypeCheck();">


<table width='82%' border='1' align="center" cellpadding="1" cellspacing="1">
<TR>
<TD align="center" class='caja1'>


<h1><br> 
Subir Archivos al Servidor </h1>


<br>

<?php
$modo = $_GET["modo"];
if($modo=="cerrarnoti"){
 echo '<center>[ <a href="javascript:opener.location.reload(true); self.close();">Cerrar Ventana</a> ]</center>'; 

}
else{
echo '<center>[ <a href="javascript:window.close();">Cerrar esta ventana</a> ]</center>';
}
?>

<br>


<div id="content">
<p>
  <?php 
if ($config['show_warning']) echo '<div id="warningmsg"><p>'.$lang['warning_msg'].'</p></div>'."\n";
if (isset($errormsg)) echo '<div id="errormsg"><p>'.$errormsg.'</p></div>'."\n";

if (!($config['hide_upload']) || $auth) { ?>
  <?php } ?>
</p>
<table width="786" border="1">
  
  <tr>
    <td><div id="uploadform">
      <?php $sid = md5(uniqid(rand())); //unique file id ?>
      <form method="post" enctype="multipart/form-data" action="">
        <p>
          <label for="file"><?php echo $lang['file'] ?> :</label>
          <input type="file" id="file" name="file" size="40" onchange="renameSync();" />
          <input name="submit" type="submit" class="button" id="upload" value="<?php echo $lang['upload'] ?>" <?php if ($config['upload_progressbar']) echo 'onclick="beginUpload(\''.$sid.'\');return false;" '; ?>/>
        </p>
        <p>
          <label for="filename"><?php echo $lang['renameto'] ?> :</label>
          <input type="text" id="filename" name="filename" onkeyup="filetypeCheck();" size="40" />
        </p>
        <font size="2"><span id="allowed"><?php echo $lang['filetypesallowed'] ?>: <?php echo join(",",$config['allowed_ext']); ?></span> - <?php echo $lang['filesizelimit'] ?>: <?php echo getfilesize($max_filesize); ?>
        <?php if ($config['delete_after']) echo   '<br />'.str_replace("{D}",$config['delete_after'],$lang['filedeleteafter']); ?>
        </font>
      </form>
      <?php if ($config['upload_progressbar']){ ?>
      <div id="upload_pb" style="display: none;">
        <p>Uploading <span id="upload_filename"></span> ...</p>
        <div id="upload_border">
          <div id="upload_progress"></div>
        </div>
      </div>
      <iframe name="upload_iframe" id="upload_iframe" style="border: 0;width: 0px;height: 0px;display:none;"></iframe>
      <?php } ?>
    </div></td>
    </tr>
</table>
<p>&nbsp;</p>
<div id="filelisting">
 <img src="images/arrow-up.gif" alt="" style="display:none;" /><img src="images/arrow-down.gif" alt="" style="display:none;" />
 <table id="t1" class="sortable">
  <tr>
  <th id="th1" class="lefted"><?php echo $lang['filename']; ?></th>
 <th class="lefted">Ubicaci&oacute;n</th>
  <th id="th2"><?php echo $lang['date']; ?></th>
  <th id="th3"><?php echo $lang['size']; ?></th>
  <th id="th4"><?php echo $lang['type']; ?></th>
  <?php if (!$config['hide_delete'] || $auth) echo '<th id="th5" class="unsortable">'.$lang['delete'].'</th>'; ?>
  </tr>
<?php 
$files = ls($config['storage_path']);
if (empty($files)){
	echo '  <tr><td class="lefted">'.$lang['nofiles'].'</td></tr>';
} else {
	foreach ($files as $file) {
		echo '  <tr class="off" onmouseover="if (this.className!=\'delete\') {this.className=\'on\'};" onmouseout="if (this.className!=\'delete\') {this.className=\'off\'};">';
		echo '<td class="lefted"><img src="images/icons/'.$file['ext'].'.gif" alt="" /> ';
		if ($config['disable_directlink'])
		echo $file['file'];
		else {
			$dlink = $file['file'];
			if ($config['utf8encode_directlink'])
				$dlink = utf8_encode($file['file']);
			echo '<a href="'.$config['storage_path'].'/'.rawurlencode($dlink).'">';
			$maxlen=29;
			if (strlen($file['file'])>$maxlen)
				echo substr($file['file'],0,$maxlen-3)."...";
			else 
				echo $file['file'];
			echo '</a>';
		}
		echo '&nbsp;';
		echo '<a href="?download='.urlencode($file['file']).'"><img src="images/download_arrow.gif" alt="('.$lang['download'].')" title="'.$lang['download_link'].'" /></a></td>';

$direccion = substr (''.$config['storage_path'].'/'.rawurlencode($dlink).'', 0);

echo '<td>'.$direccion.'</td>';

		echo '<td>'.date ($lang['date_format'], $file['date']).'</td>';
		echo '<td>'.getfilesize($file['size']).'</td>';
		echo '<td><img src="images/icons/'.$file['ext'].'.gif" alt="" /> <span>'.$file['ext'].'</span></td>';
		if (!$config['hide_delete'] || $auth){
			echo '<td><a onclick="';
			if ($config['confirm_delete'])
			echo 'if(confirm(\''.$lang['delete_confirm_msg'].'\'))';
			echo 'deletefile(this.parentNode.parentNode); return false;" ';
			echo 'href=""><img src="images/delete.gif" alt="'.$lang['delete'].'" title="'.$lang['delete_link'].'" /></a></td>';
		}
		echo '</tr>'."\n";
	}
}
?>
 </table>
</div>
</div>
<br><br></TD>
</TR>
<TR>
  <TD align="center" class='caja1'>* Debe renombrar el archivo agregandole el nombre de la sucursal * </TD>
</TR>
</table>
</body>
</html>
