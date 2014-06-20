<?
require("../admin/session.php");
//variables POST
$obj=new manejadordb;

$year=date('Y');
$month=date('m');
$day=date('d');
$hour=date('H')-1;
$minute=date('i');
$second=date('s');
$fecha=$year."-".$month."-".$day." ".$hour.":".$minute.":".$second;

$cod=trim(str_replace("\n","",$_POST['codigo']));
$titulo=trim($_POST['titulo']);
$tomo=trim($_POST['tomo']);
$formato=trim($_POST['formato']);
$edit=trim($_POST['edit']);
$cants=trim($_POST['cants']);
$cantf=trim($_POST['cantf']);
$cond=trim($_POST['cond']);
$codinv=trim($_POST['codinv']);
$suc=trim($_POST['sucursal']);
$nota=trim($_POST['notaent']);

//		if($obj->query("update tbl_audinventario set estatus=7,f_culminacion='$fecha' where cod_invent='$codinv' and sucursal=$suc and estatus=6;")==true){


if($obj->query("update tbl_detalleinventario set cant_sist=$cants,cant_fisc=$cantf,notaentrega='$nota' where cod_invent='$codinv' and cod_producto='$cod' and sucursal=$suc and condicion=$cond and estatus=6 and notaentrega='$nota';")==true){
		
		echo "1";
		//echo '<img src="../imagenes/ok.png">';
		
}else echo "0"; //echo '<img src="../imagenes/cancelar.png">';


?>