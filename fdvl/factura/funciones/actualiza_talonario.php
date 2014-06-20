<?
include_once("manejadordb.php");
include_once("../clases/factura.php");

$factura=new factura();
$obj=new manejadordb;
//$fecha=$factura->getfechamysql();

//variables POST
$suc=$_POST['suc'];
$codf=$_POST['codf'];
$fecfacturamanual=$_POST['fecfacturamanual']." ".date('H').":".date('i').":".date('s');
$codfacturamanual=$_POST['codfacturamanual'];
$ncontrol=$_POST['ncontrol'];
$cliente=$_POST['ncontrol'];
$tipo=$_POST['tipo'];
$pagina=$_POST['pagina'];
//die("<tr><td colspan=6>UPDATE tbl_facturas SET fecha_factura='$fecfacturamanual',codfacturamanual='$codfacturamanual',numtalonario='$ncontrol',fec_facmanual='$fecfacturamanual' where cod_factura='".$codf."' and sucursal='$suc'</td></tr>");

if(!empty($codf) && !empty($suc) && !empty($fecfacturamanual)  && !empty($codfacturamanual) && !empty($ncontrol))
{
	$actualiza_talon="UPDATE tbl_facturas SET fecha_factura='$fecfacturamanual',codfacturamanual='$codfacturamanual',numtalonario='$ncontrol',fec_facmanual='$fecfacturamanual' where cod_factura='".$codf."' and sucursal=$suc";
	
	$obj->consultar($actualiza_talon);

}else echo "Campos Vacios";

?>
