<?php
//include_once("manejadordb.php");
require("admin/session.php");// // incluir motor de autentificación.
//variable POST
$codf=$_POST['codf'];
$codp=$_POST['codp'];
$cod=$_POST['cod'];
$cant=$_POST['cant'];
$vend=$_POST['vend'];
$suc=$_POST['suc'];
//die("Estoy borraritem.php ".$cant);
//creamos el objeto $objempleados
//y usamos su método eliminar
$obj=new manejadordb;

if(isset($codf) && !empty($codf) && isset($suc) && !empty($suc) && isset($vend) && !empty($vend))  
{

	if ($obj->delitems($codf,$vend,$suc)==true){
		echo "Registro eliminado correctamente_1";
	}else{
		echo "Ocurrio un error";
	}
	if ($obj->delfactura($codf,$vend,$suc)==true){
		echo "Registro eliminado correctamente_2";
	}else{
		echo "Ocurrio un error";
	}

}


if( isset($codp) && !empty($codp))  
{
	if ($obj->borraritem($codp,$cod,$cant,$suc)==true){
		echo "Registro eliminado correctamente_3";
	}else{
		echo "Ocurrio un error";
	}
}
//include('consulta.php');
?>