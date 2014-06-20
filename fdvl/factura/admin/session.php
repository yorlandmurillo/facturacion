<?
// Motor autentificación usuarios.
require("aut_config.inc.php");
include_once("manejadordb.php");
include ("aut_mensaje_error.inc.php");

function calendario($idimg,$idtxt){
 echo "<script type=\"text/javascript\">
  Calendar.setup(
    {
	  inputField  : '$idtxt',         
      align          :    'Tr',
      singleClick    :    false,
      ifFormat    : '%d/%m/%Y',    
      button      : '$idimg'       
	  }
  );
	   </script>";
}

function conversionmont($valor){
		return $valor/1000;
}

function cambiafanormal($fechaval){
  	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fechaval, $mifecha);
    	$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
    	return $lafecha;
} 

function cambiahraanormal($hora){
	$nhora=0;
 	if($hora-12>0){
	$nhora=$hora-12;
	}else $nhora=$hora;
	return $nhora;
} 

function cambiafamysql($fecha){
  	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    	$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    	return $lafecha;
} 

$obj=new manejadordb;
// chequear página que lo llama para devolver errores a dicha página.
$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$pagina=$parts[count($parts) - 1];

$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$red=$_SERVER['HTTP_HOST'];
$redir='login.php';


/*if ($_SERVER['HTTP_REFERER']=="" && !isset($_SESSION["usuario_login"]) && !isset($_SESSION["usuario_password"])){
Header ("Location: $redir?error_login=7");
exit;
}*/

if(isset($_POST['user']) && isset($_POST['pass']) && empty($_POST['user']) && empty($_POST['pass'])){
       	Header ("Location: $redir?error_login=10");
		exit;
}


// Chequeamos si se está autentificandose un usuario por medio del formulario

  
if (isset($_POST['user']) && isset($_POST['pass'])) {
// redireccionamos a la pagina de error.
// realizamos la consulta a la BD para chequear datos del Usuario.
$query="SELECT * FROM tbl_usuario WHERE us_login='".$_POST['user']."'";
$result=$obj->consultar($query);

 // miramos el total de resultado de la consulta (si es distinto de 0 es que existe el usuario)
 if (mysql_num_rows($result)>0) {
    // eliminamos barras invertidas y dobles en sencillas
    $login = stripslashes($_POST['user']);
    // encriptamos el password en formato md5 irreversible.
    $password = sha1($_POST['pass']);
    // almacenamos datos del Usuario en un array para empezar a chequear.
 	$datos=mysql_fetch_assoc($result);
    // chequeamos el nombre del usuario otra vez contrastandolo con la BD
    // esta vez sin barras invertidas, etc ...
    // si no es correcto, salimos del script con error 4 y redireccionamos a la
    // página de error.



    if ($login!=$datos["us_login"]) {
       	Header ("Location: $redir?error_login=4");
		exit;}

	if ($datos["us_estatus"]!=1) {
       	Header ("Location: $redir?error_login=9");
		exit;}
    // si el password no es correcto ..
    // salimos del script con error 3 y redireccinamos hacia la página de error
    if ($password!=$datos["us_clave"]) {
       	Header ("Location: $redir?error_login=3");
		exit;
    }

    // si la cuenta esta desactivada ..
    // salimos del script con error 9 y redireccinamos hacia la página de error

    if ($datos["us_estatus"]==2) {
     
	   	Header ("Location: $redir?error_login=9");
		exit;
    }


    // Paranoia: destruimos las variables login y password usadas
    unset($login);
    unset($password);

    session_name($usuarios_sesion);
     // incia sessiones
    session_start();
    // Paranoia: decimos al navegador que no "cachee" esta página.
    session_cache_limiter('nocache,private');

    $_SESSION['usuario_id']=$datos["id_usuario"];
    $_SESSION['usuario_nivel']=$datos["us_nivel"];
    $_SESSION['usuario_login']=$datos["us_login"];
    $_SESSION['usuario_password']=$datos["us_clave"];
	$_SESSION['usuario_apellido']=$datos["us_apellido"];
	$_SESSION['usuario_nombre']=$datos["us_nombre"];	
   	$_SESSION['usuario_sucursal']=$datos["us_sucursal"];	

	$_SESSION['hora_acceso']= date("Y-n-j H-1:i:s");
	$_SESSION['iva']= 0.12;

	$userid=$datos['id_usuario'];
	$loginuser=$datos["us_login"];
	$idsucursal=$datos["us_sucursal"];
	$hora=date("H")-1;
	$min=date("i");
	$seg=date("s");
	$fechaa=date("Y-n-j");
	$hra=$fechaa." ".$hora.":".$min.":".$seg;

	$obj->query("delete from tbl_sesiones where id_user=$userid and id_sucursal=$idsucursal and estatus=19;");
	$obj->query("INSERT INTO tbl_sesiones (sesiones_us_nom,sesiones_us_ha,sesiones_us_ex,id_user,id_sucursal,estatus)VALUES('$loginuser','$hra','$hra',$userid,$idsucursal,9)");
	$obj->query("INSERT INTO log_sesiones (sesiones_us_nom,sesiones_us_ha,sesiones_us_ex,id_user,id_sucursal)VALUES('$loginuser','$hra','$hra',$userid,$idsucursal)");
	 // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.
   // mysql_free_result($usuario_consulta);
    // cerramos la Base de dtos.

	 // Hacemos una llamada a si mismo (scritp) para que queden disponibles
    // las variables de session en el array asociado $HTTP_...
    $pag=$_SERVER['PHP_SELF'];
    Header ("Location: $pag");
    exit;
    }else{
      // si no esta el nombre de usuario en la BD o el password ..
      // se devuelve a pagina q lo llamo con error
      Header ("Location: $redir?error_login=2");
      exit;}
}else{
// -------- Chequear sesión existe -------
// usamos la sesion de nombre definido.
session_name($usuarios_sesion);
// Iniciamos el uso de sesiones
session_start();
// Chequeamos si estan creadas las variables de sesión de identificación del usuario,
// El caso mas comun es el de una vez "matado" la sesion se intenta volver hacia atras
// con el navegador.
if (!isset($_SESSION["usuario_login"]) && !isset($_SESSION["usuario_password"])){
// Borramos la sesion creada por el inicio de session anterior
session_destroy();
Header ("Location: $redir?error_login=7");
exit;
}
}
?>
