<?
require("../admin/session.php");
require("../clases/directorio.php");

$obj=new manejadordb();

class envios extends directorio{


var $carpeta;
var $sucursal;
var $fecha;


	function __envios(){
	
	}

	function getpreferencia($sucursal,$preferencia){
		$result=manejadordb::consultar("SELECT $preferencia FROM tbl_preferencias WHERE sucursal_id=$sucursal;");
		$row=mysql_fetch_assoc($result);
		return $row[$preferencia];
	}  

	function verificarfecha($archivo,$sucursal){
//	SELECT Max(fecha_factura) AS fecha FROM tbl_facturas;
	
	$result=manejadordb::consultar("SELECT * FROM tbl_envios where archivo='$archivo' and sucursal=$sucursal;");

	if(mysql_num_rows($result)>0){
	
	$row=mysql_fetch_assoc($result);
	$this->fecha=$row['fecha_envio'];
	
	}else{
	$this->fecha=manejadordb::getfechamysql();
	manejadordb::query("insert into tbl_envios (sucursal,archivo,fecha_envio)values($sucursal,'$archivo','".$this->fecha."');");
	}
	
	return $this->fecha;

	}
	
	function mover($origen,$destino){
	  copy($origen,$destino);
	  unlink($origen);
	}  

	function actualizarfecha($archivo,$sucursal){
	
	$result=manejadordb::consultar("SELECT * FROM tbl_envios where archivo='$archivo' and sucursal=$sucursal;");
	if(mysql_num_rows($result)>0){
		manejadordb::query("update tbl_envios set fecha_envio='".manejadordb::getfechamysql()."' where archivo='$archivo' and sucursal=$sucursal;");
	}else manejadordb::query("insert into tbl_envios (sucursal,archivo,fecha_envio)values($sucursal,'$archivo','".manejadordb::getfechamysql()."');");
	
	}
	

	function generarenvio($carpeta,$sucursal,$fecha){
	$this->carpeta=$carpeta;
	$this->sucursal=$sucursal;
	$this->fecha=$fecha;
	
	return "../".$this->dirs[0]."/".$this->carpeta."/".$this->sucursal."/".$this->fecha;

	}


	function subirarchivo($carpeta,$data,$sucursal,$uftp,$pftp,$sftp) {
      $rpta = "";
      	  $tmpfile = "../envios/".$carpeta."/".$sucursal."/".$data;
    	  $tmpname = "/".$carpeta."/".$sucursal."/".$data;
         
		 
          $ftpuser = $uftp;
          $ftppass = $pftp;
          $ftppath = $sftp;
          $ftpurl = "ftp://".$ftpuser.":".$ftppass."@".$ftppath;
          if ($tmpname != "") {
              $fp = fopen($tmpfile, 'r');
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $ftpurl.$tmpname);
              curl_setopt($ch, CURLOPT_UPLOAD, 1);
              curl_setopt($ch, CURLOPT_INFILE, $fp);
              curl_setopt($ch, CURLOPT_INFILESIZE, filesize($tmpfile));
              curl_exec($ch);
              $error = curl_errno($ch);
              curl_close ($ch);
              if ($error == 0) {
                  $rpta = true;//'Archivo subido correctamente.';
              } else {
                  $rpta = false;//'Error al subir el archivo.';
              }
          } else {
              $rpta = false;//'Seleccionar un archivo.';
          }
	return $rpta;
	}


	function subirarchivo1($carpeta,$data,$sucursal,$uftp,$pftp,$sftp) {

      	  $tmpfile = "../envios/".$carpeta."/".$sucursal."/".$data;
    	  $tmpname = "/".$carpeta."/".$sucursal."/".$data;
         
		  	$ftp_host = $sftp;
			$ftp_user = $uftp;
			$ftp_pass = $pftp;

			$ftp = new ftp();

			$ftp->debug = TRUE;

			if (!$ftp->ftp_connect($ftp_host)) {
			die("Cannot connect\n");
			}

			if (!$ftp->ftp_login($ftp_user, $ftp_pass)) {
				$ftp->ftp_quit();
				die("Login failed\n");
			}

			if ($pwd = $ftp->ftp_pwd()) {
				echo "Current directory is ".$pwd."\n";
			} else {
				$ftp->ftp_quit();
				die("Error!!\n");
			}

			if ($sys = $ftp->ftp_systype()) {
				echo "Remote system is ".$sys."\n";
			} else {	
				$ftp->ftp_quit();
				die("Error!!\n");
			}


			$local_filename  = $tmpfile;//"local.file";
			$remote_filename = $tmpname;//"remote.file";

			if ($ftp->ftp_file_exists($remote_filename) == 1) {
			$ftp->ftp_quit();
			die($remote_filename." already exists\n");
			}

			if ($ftp->ftp_put($remote_filename, $local_filename)) {
			echo $local_filename." has been uploaded as ".$remote_filename."\n";
			} else {
				$ftp->ftp_quit();
				die("Error!!\n");
			}
			$ftp->ftp_quit();

		  }
}
 
?>