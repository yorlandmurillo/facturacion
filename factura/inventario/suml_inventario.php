<?
require("../admin/session.php");
//variables POST
$obj=new manejadordb;

function consultarlibro($codinv,$codp,$suc,$cond){
$obj=new manejadordb;

$query="SELECT tbl_inventario.cod_producto  AS codigo FROM tbl_inventario INNER JOIN tbl_detalleinventario ON 
tbl_inventario.cod_producto = tbl_detalleinventario.cod_producto
WHERE (((tbl_inventario.cod_producto)='$codp') AND ((tbl_inventario.estatus)=1) AND ((tbl_detalleinventario.sucursal)=$suc) 
AND ((tbl_detalleinventario.condicion)=$cond) AND ((tbl_detalleinventario.estatus)=6) AND ((tbl_detalleinventario.cod_invent)='$codinv')) 
OR (((tbl_inventario.isbn)='$codp')) OR (((tbl_inventario.cod_barra)='$codp'));";

$lista=$obj->consultar($query);
$row =mysql_fetch_assoc($lista);	  
return $row['codigo'];

}


$cod=trim(str_replace("\n","",$_POST['codigo']));
$cant=trim($_POST['cant']);
$cond=trim($_POST['cond']);
$codinv=trim($_POST['codinv']);
$suc=trim($_POST['suc']);
$nota=trim($_POST['notaent']);


$codigo=consultarlibro($codinv,$cod,$suc,$cond);

if($obj->query("update tbl_detalleinventario set cant_fisc=cant_fisc+$cant where cod_invent='$codinv' and cod_producto='$codigo' and sucursal=$suc and condicion=$cond and estatus=6 and notaentrega='$nota';")==true){
		
		echo "El libro fue sumado al inventario ";
		
}else echo "Error al intentar sumar el libro al inventario";




?>