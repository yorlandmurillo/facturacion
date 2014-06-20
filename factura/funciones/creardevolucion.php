<?
include_once("manejadordb.php");
include_once("../clases/factura.php");


$factura=new factura();
$obj=new manejadordb;
$fecha=$factura->getfechamysql();

//variables POST
$suc=$_POST['suc'];
$codf=$_POST['codf'];
$cliente=$_POST['cliente'];
$vend=$_POST['vend'];
$total=$_POST['total'];
$subt=$_POST['subt'];
$mtoiva=$_POST['mtoiva'];
$iva=$_POST['iva']*100;
$efec=$_POST['efec'];
$tdb=$_POST['tdb'];
$tdc=$_POST['tdc'];
$bl=$_POST['bl'];
$esp=$_POST['esp'];
$mtocheque=$_POST['mtocheque'];
$nrocheque=$_POST['nrocheque'];
$cambio=$_POST['cambio'];
$cesta=$_POST['cesta'];
$omoneda=$_POST['omoneda'];
$nrocta=$_POST['nrocta'];
$banco=$_POST['banco'];
$nroconf=$_POST['nroconf'];
//
if(!empty($codf) && !empty($suc) && !empty($vend) && $cliente!=0){

if($obj->query("UPDATE tbl_facturas SET cod_cliente=$cliente,efectivo=$efec,cheque=$mtocheque,tdb=$tdb,tdc=$tdc,bl=$bl,cesta_ticket=$cesta,cta_bancaria='$nrocta',num_cheque='$nrocheque',banco=$banco,nro_conformacion=$nroconf,pago_especial=$esp,otra_moneda=$omoneda,iva=$iva,mto_iva=$mtoiva,sub_total=$subt,mto_total=$total,cambio=$cambio,estatus_factura=3 where cod_factura='$codf' and sucursal=$suc and vendedor=$vend")==true){

$obj->query("UPDATE tbl_itemfactura t SET estatus_cancelacion=3 where cod_factura='$codf' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=0;");
echo "Factura Procesada Con Exito";

}else echo "Factura no Procesada";

}else echo "Campos Vacios";

?>