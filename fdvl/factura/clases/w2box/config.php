<?php
//session_start();
/* w2box: web 2.0 File Repository
 * (c) 2005-2006, Clément Beffa
 * http://labs.beffa.org/w2box/
 *
 * configuration & language file
 *
 */
//session_start();

$config = Array();

// --- basic ---
// title of your w2box
$config['w2box_title'] = "Sistema de Archivos";
// path to the storage directory
$config['storage_path'] = "archivos";
// maximum allowed file size in megabytes.
$config['max_filesize'] = 50; // MBytes
// allowed file type
$config['allowed_ext'] = array("zip","rar");
// if bigger then 0, automatically delete file after X days
$config['delete_after'] = 0;
// if true, do not direct link to files
$config['disable_directlink'] = false;
// if true, allow upload to overwrite file that exist
$config['allow_overwrite'] = false;
// if true, ask confirmation before deletion
$config['confirm_delete'] = true;
// if true, show a warning msg at the top
// you can edit the warning msg at the end 
// of this file ($lang['warning_msg'])
$config['show_warning'] = false;
// if true, utf8 encode the direct link, 
// turn this on if you're directlink doesn't work 
// with international characters
$config['utf8encode_directlink'] = false;

//activate upload progress bar (in dev)
$config['upload_progressbar']=false;
//path to the cgi script
$config['upload_cgiscript']="include/w2box/upload.cgi";
//path to the tmp dir, if this one doesn't work, use a full path
$config['upload_tmpdir']="include/w2box/tmp";
//$config['upload_tmpdir']="/home/username/tmp";
//$config['upload_tmpdir']="~tmp";
//$config['upload_tmpdir']="C:/wamp/tmp";

//--- admin ---
// To log-in as an admin when every feature is
// hidden, click on "Powered" (hidden link) at
// the bottom of the page.
// 
// if true, activate admin authentication
$config['admin_actived'] = true;
// admin username
$config['admin_username'] = $_SESSION["usuario_id"];
// admin password
$config['admin_password'] = $_SESSION["usuario_password"];
// if true, allow upload only for admin
$config['protect_upload'] = true;
// if true, show upload feature only for admin
$config['hide_upload'] = true;
// if true, allow delete only for admin
$config['protect_delete'] = true;
// if true, show delete feature only for admin
$config['hide_delete'] = true;

//--- activity logging --
// if true, log activity to file
$config['log'] = false;
// log filename
$config['log_filename'] = "w2box.log";
// if true, log upload activity
$config['log_upload'] = true;
// if true, log delete activity
$config['log_delete'] = true;
// if true, log download activity (you should disable 
// direct link if you want to track every download
$config['log_download'] = false;

// *** langague setting behind that line *** //

$lang = Array();
//msg
$lang['warning_msg'] = "I'm not responsible of any file here. Download them at your own risk!";
$lang['delete_confirm_msg'] = "Estas seguro de eliminar ese archio?";
//upload form
$lang['upload'] = 'Subir';
$lang['file'] = 'Buscar';
$lang['renameto'] = 'Renombrar Archivo';
$lang['filetypesallowed'] = 'Tipos de archivos permitidos';
$lang['filesizelimit'] = 'Limite de tama&ntilde;o de archivo';
$lang['filedeleteafter'] = 'files will be deleted automatically {D} days after being uploaded';
//listing heading
$lang['filename'] = 'Archivos';
$lang['date'] = 'Fecha';
$lang['date_format'] = 'Y-m-d H:i';
$lang['type'] = 'Tipo';
$lang['size'] = 'Tama&ntilde;o';
$lang['delete'] = 'Eliminar';
$lang['download'] = 'Descargar';
$lang['delete_link'] = 'Borrar';
$lang['download_link'] = 'Descarga ahora!';
$lang['nofiles'] = 'el directorio esta vacio...';


//logging
$lang['DELETE'] = 'DELETE';
$lang['UPLOAD'] = 'UPLOAD';
$lang['DOWNLOAD'] = 'DOWNLD';
//delete error
$lang['delete_error_notfound'] = "Error: Archivo no encontrado.";
$lang['delete_error_cant'] = "Error: No se puede eliminar este archivo.";
//upload error
$lang['upload_error'] = array(1 => "El archivo se excedio de lo establecido en upload_max_filesize directiva en su php.ini",
							  2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
						 	  3 => "The uploaded file was only partially uploaded.",
						 	  4 => "No file was uploaded.",
						 	  6 => "Missing a temporary folder.");

						 	  
$lang['upload_error_sizelimit'] = "File size is greater than the file size limit";
$lang['upload_error_fileexist'] = "El archivo ya existe en el directorio.";
$lang['upload_error_nocopy'] = "Unable to copy the file into the storage directory.";
$lang['upload_error_sid'] = "Unable to found the specified file.";
?>
