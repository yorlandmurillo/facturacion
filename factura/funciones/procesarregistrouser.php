<?
require("../admin/session.php"); // incluir motor de autentificación.
//variables POST

$uscedula=trim($_POST['uscedula']);
$usnombre=utf8_decode(trim($_POST['usnombre']));
$usapellido=utf8_decode(trim($_POST['usapellido']));
$sucursal=$_POST['sucursal'];
$uslogin=utf8_decode(trim($_POST['uslogin']));
$usnivel=$_POST['usnivel'];
$uspassword=utf8_decode(trim($_POST['uspassword']));
$uspasswordc=utf8_decode(trim($_POST['uspasswordc']));
$incluidopor=$_SESSION['usuario_login'];
$fecha=date("Y-n-j");

//creamos el objeto 
//y usamos su método crear

$obj=new manejadordb;

$band=0;

if (!strcasecmp($uspassword,$uspasswordc))$band=1;
else $band=0;

if($band==1){

if ($obj->verificaruser($uslogin)==0){
	if ($obj->insertarcliente("INSERT INTO tbl_usuario (us_login,us_clave,us_nombre,us_apellido,us_sucursal,us_nivel,us_fechaingreso,us_incluidopor,cedula) VALUES ('$uslogin','$uspassword','$usnombre','$usapellido',$sucursal,$usnivel,'$fecha','$incluidopor',$uscedula)")==true)
	{
	echo "<strong>Usuario grabado correctamente</strong>";
		}else{echo utf8_encode("<strong>Error de grabación</strong>");}

}else {echo "<strong>Ya existe un usuarios con ese nombre</strong>";}
	
}else echo utf8_encode("<strong>Las contraseñas no son iguales</strong>");

?>