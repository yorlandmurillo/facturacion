<?php
//include_once("manejadordb.php");
require("admin/session.php");// // incluir motor de autentificación.
//variable POST
$codf=trim($_POST['codf']);
$vend=$_POST['vend'];
$suc=$_POST['suc'];

//creamos el objeto $objempleados
//y usamos su método eliminar
$obj=new manejadordb;

if(isset($codf) && !empty($codf) && isset($suc) && !empty($suc) && isset($vend) && !empty($vend))  
{

if ($obj->delitems($codf,$vend,$suc)==true){
	echo "Registros eliminados correctamente";
}else{
	echo "Ocurrio un error";
}

if ($obj->delfactura($codf,$vend,$suc)==true){
	echo "Factura eliminada correctamente";
}else{
	echo "Ocurrio un error";
}

}
?>