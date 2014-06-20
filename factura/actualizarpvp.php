<?php
//include_once("manejadordb.php");
require("admin/session.php");// // incluir motor de autentificación.
//variable POST
$codf=$_POST['fact'];
$codp=$_POST['codp'];
$cod=$_POST['cod'];
$cant=$_POST['cant'];
$vend=$_POST['vend'];
$suc=$_POST['suc'];
$npvp=str_replace(",",".",$_POST['npvp']);

//creamos el objeto $objempleados
//y usamos su método eliminar
$obj=new manejadordb;

if(is_numeric('0'.$npvp) && $npvp!=0){

	if(!empty($codf) && !empty($codp) && !empty($cod) && !empty($suc) && !empty($vend)){

	
		if ($obj->query("update tbl_itemfactura set precio_unid='$npvp',precio_sd='$npvp' WHERE id_itemfactura=$codp and cod_factura='$codf' and cod_producto='$cod' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=0;")==true){
			echo "Precio Actualizado Correctamente";
		}else{
			echo "Ocurrio un error";
		}

	}


}else{
	echo "Ha introducido un valor incorrecto";
}
?>
