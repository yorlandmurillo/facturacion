<? 
require("../admin/session.php");// // incluir motor de autentificaci�n.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma p�gina.
$nivel_acceso=1;// definir nivel de acceso para esta p�gina.

$uslogin=utf8_decode(trim($_POST['uslogin']));
$uspassword=utf8_decode(trim($_POST['uspassword']));
$uspasswordc=utf8_decode(trim($_POST['uspasswordc']));
$incluidopor=$_SESSION['usuario_login'];
$fecha=date("Y-n-j");

if ($_SESSION['usuario_nivel'] < $nivel_acceso){
echo 'Usted no tiene p�rmiso para acceder a esta p�gina';
}else{
$obj=new manejadordb;

$band=0;

if (!strcasecmp($uspassword,$uspasswordc))$band=1;
else $band=0;

if($band==1){

if ($obj->verificaruser($uslogin)>0){
	if ($obj->insertarcliente("update tbl_usuario set us_clave='$uspassword' where us_login='$uslogin' ")==true)
	{
	echo "<strong>Cambio de clave realizado</strong>";
		}else{echo utf8_encode("<strong>Error al cambiar la clave</strong>");}

}else {echo "<strong>El usuarios no existe</strong>";}
	
}else echo utf8_encode("<strong>Las contrase�as no son iguales</strong>");
}
?>