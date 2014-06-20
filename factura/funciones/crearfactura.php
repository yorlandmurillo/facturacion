<?
include_once("manejadordb.php");
include_once("../clases/factura.php");
//include_once("DBManager.php");

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
$tipofactura=$_POST['tipofactura'];
$fecfacturamanual=$_POST['fecfacturamanual']." ".date('H').":".date('i').":".date('s');
$codfacturamanual=$_POST['codfacturamanual'];
$ncontrol=$_POST['ncontrol'];
$fechaActual = date("Y-m-d h:i:s",time());
//
if(!empty($codf) && !empty($suc) && !empty($vend) && $total>0 && $cliente!="0")
{
	if($obj->query("UPDATE tbl_facturas SET cod_cliente='".$cliente."',efectivo=$efec,cheque=$mtocheque,tdb=$tdb,tdc=$tdc,bl=$bl,cesta_ticket=$cesta,cta_bancaria='$nrocta',num_cheque='$nrocheque',banco=$banco,nro_conformacion=$nroconf,pago_especial=$esp,otra_moneda=$omoneda,iva=$iva,mto_iva=$mtoiva,sub_total=$subt,mto_total=$total,cambio=$cambio,estatus_factura=3,tipofactura=$tipofactura,codfacturamanual='$codfacturamanual',numtalonario='$ncontrol',fec_facmanual='$fecfacturamanual' where cod_factura='".$codf."' and sucursal=$suc and vendedor=$vend")==true){

		if($tipofactura==3)
		{
			$obj->query("UPDATE tbl_facturas SET fecha_factura='$fecfacturamanual',fec_facmanual='$fechaActual' where cod_factura='".$codf."' and sucursal=$suc and vendedor=$vend");
		}

		$obj->query("UPDATE tbl_itemfactura SET estatus_cancelacion=3 where cod_factura='".$codf."' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=0;");
		
		if($tipofactura==3)
		{
			$obj->query("UPDATE tbl_facturas SET correlativo=correlativo-1 where cod_factura='".$codf."' and sucursal=$suc and vendedor=$vend");
			$obj->query("UPDATE tbl_facturas SET cod_factura='".$codfacturamanual."' where cod_factura='".$codf."' and sucursal=$suc and vendedor=$vend");
			$obj->query("UPDATE tbl_itemfactura SET cod_factura='".$codfacturamanual."' where cod_factura='".$codf."' and sucursal=$suc and vendedor=$vend");
			
		}
		echo "<font size=4>Factura procesada con  &eacute;xito. Si aún ve esta ventana, cierrela, desconecte el internet y busque la factura por Consultas -> Venta e imprimala<br><b>NO VUELVA A HACER LA MISMA FACTURA</b></font>";

	}else echo "Factura no Procesada";

}else echo "Campos Vacios";

?>
