<?
include_once("manejadordb.php");
//variables POST

$id=$_POST['usid'];
$nom=utf8_decode($_POST['usnombre']);
$apell=utf8_decode($_POST['usapellido']);
$suc=$_POST['sucursal'];
$nivel=$_POST['usnivel'];
$estatus=$_POST['usestatus'];

//creamos el objeto 
//y usamos su método crear

$obj=new manejadordb;


if(trim($apell)!="" && trim($nom)!=""){

				
if ($obj->query("update tbl_usuario set us_nombre='$nom',us_apellido='$apell',us_sucursal=$suc,us_nivel=$nivel,us_estatus=$estatus where id_usuario=$id ")==true){

		echo "<strong>Usuario modificado correctamente</strong>";
		
}else{echo utf8_encode("<strong>Error de grabación</strong>");}
		

}else {echo "<strong>Los campos con (*) son obligatorios</strong>";}

?>