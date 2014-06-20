<?php

///////////////////////////////// ACTUALIZA LA FACTURACION

if (!($link= @mysql_connect("localhost","inventa_bd","Valenta@04")))
{

// Inicializa de la sesion
session_start();
// Destruye todas las variables de la sesion
session_unset();
// Finalmente, destruye la sesion
session_destroy();
exit();
}
if (! @mysql_select_db("inventa_pglibreria",$link))
{
echo "Error seleccionando la base de datos.";
exit();
}
//$link=Conectarse();
//echo "Conexión con la base de datos conseguida.<br>";
//@mysql_close($link); //cierra la conexion


if (!($link2= @mysql_connect("distribuidoradellibro.gob.ve","inventa_bd","Valenta@04")))
{

// Inicializa de la sesion
session_start();
// Destruye todas las variables de la sesion
session_unset();
// Finalmente, destruye la sesion
session_destroy();
exit();
}
if (! @mysql_select_db("inventa_pglibreria",$link2))
{
echo "Error seleccionando la base de datos.";
exit();
}
//$link=Conectarse();
//echo "Conexión con la base de datos conseguida.<br>";
//@mysql_close($link); //cierra la conexion

 
$resultFac = @mysql_query("
SELECT * FROM tbl_facturas WHERE tbl_facturas.enviado = 'N'",$link); 

while($row = mysql_fetch_array($resultFac))
{
$cod_factura= $row['cod_factura'];
$fecha_factura= $row['fecha_factura'];
$cod_cliente= $row['cod_cliente'];
$vendedor= $row['vendedor'];
$sucursal= $row['sucursal'];
$efectivo= $row['efectivo'];
$cheque= $row['cheque'];
$tdb= $row['tdb'];
$tdc= $row['tdc'];
$bl= $row['bl'];
$cesta_ticket= $row['cesta_ticket'];

$cta_bancaria= $row['cta_bancaria'];
$num_cheque= $row['num_cheque'];
$banco= $row['banco'];
$nro_conformacion= $row['nro_conformacion'];
$pago_especial= $row['pago_especial'];
$otra_moneda= $row['otra_moneda'];
$iva= $row['iva'];
$mto_iva= $row['mto_iva'];
$sub_total= $row['sub_total'];
$mto_total= $row['mto_total'];

$cambio= $row['cambio'];
$estatus_factura= $row['estatus_factura'];
$correlativo= $row['correlativo'];
$descuento= $row['descuento'];
$tipofactura= $row['tipofactura'];
$codfacturamanual= $row['codfacturamanual'];

$numtalonario= $row['numtalonario'];
$fec_facmanual= $row['fec_facmanual'];


	   $fecha = date("Y-m-d H:i:s"); 




$sql_desc = "INSERT INTO tbl_facturas (
			  cod_factura,fecha_factura,cod_cliente,vendedor,sucursal,efectivo,cheque,tdb,tdc,bl,cesta_ticket,cta_bancaria,num_cheque,banco,nro_conformacion,pago_especial,otra_moneda,iva,mto_iva,sub_total,mto_total,cambio,estatus_factura,correlativo,descuento,tipofactura,codfacturamanual,numtalonario,fec_facmanual,enviado,fecha_envio )
    VALUES  ('$cod_factura','$fecha_factura','$cod_cliente','$vendedor','$sucursal','$efectivo','$cheque','$tdb','$tdc','$bl','cesta_ticket','$cta_bancaria','$num_cheque','$banco','$nro_conformacion','$pago_especial','$otra_moneda','$iva','$mto_iva','$sub_total','$mto_total','$cambio','$estatus_factura','$correlativo','$descuento','$tipofactura','$codfacturamanual','$numtalonario','$fec_facmanual','S','$fecha')";
mysql_query($sql_desc, $link2) or die(mysql_error($link2));


$sqlActualiza ="UPDATE tbl_facturas Set enviado='S' WHERE cod_factura ='$cod_factura'";
mysql_query($sqlActualiza, $link) or die(mysql_error($link));

}




/////////////////////////////////// el detalle de la factura


$resultFac = @mysql_query("

SELECT * FROM tbl_itemfactura WHERE tbl_itemfactura.enviado = 'N'",$link); 



while($row = mysql_fetch_array($resultFac))
{


$id_itemfactura= $row['id_itemfactura'];
$cod_factura= $row['cod_factura'];
$cod_producto= $row['cod_producto'];
$descripcion= $row['descripcion'];
$precio_unid= $row['precio_unid'];
$cantidad= $row['cantidad'];
$existencia= $row['existencia'];
$descuento= $row['descuento'];
$estatus_cancelacion= $row['estatus_cancelacion'];
$sucursal= $row['sucursal'];
$vendedor= $row['vendedor'];
$isbn= $row['isbn'];
$cif= $row['cif'];
$cic= $row['cic'];
$cicdn= $row['cicdn'];
$devuelto= $row['devuelto'];
$precio_sd= $row['precio_sd'];
$iva= $row['iva'];
$fecha = date("Y-m-d H:i:s"); 




$sql_desc = "INSERT INTO tbl_itemfactura (
			  id_itemfactura,cod_factura,cod_producto,descripcion,precio_unid,cantidad,existencia,descuento,estatus_cancelacion,sucursal,vendedor,isbn,cif,cic,cicdn,devuelto,precio_sd,iva,enviado,fecha_envio )
    VALUES  ('id_itemfactura','$cod_factura','$cod_producto','$descripcion','$precio_unid','$cantidad','$existencia','$descuento','$estatus_cancelacion','$sucursal','$vendedor','$isbn','$cif','$cic','$cicdn','$devuelto','$precio_sd','$iva','S','$fecha')";
mysql_query($sql_desc, $link2) or die(mysql_error($link2));

$sqlActualiza ="UPDATE tbl_itemfactura Set enviado='S' WHERE cod_factura ='$cod_factura' and cod_producto= '$cod_producto'";
mysql_query($sqlActualiza, $link) or die(mysql_error($link));




}

$sqlActualiza2 ="DELETE FROM tbl_distinventario WHERE cantidad ='0' ";
mysql_query($sqlActualiza2, $link) or die(mysql_error($link));

$sqlActualiza25 ="DELETE FROM tbl_inventario WHERE precio <='0' ";
mysql_query($sqlActualiza25, $link) or die(mysql_error($link));




	mysql_close($link);
		mysql_close($link2);





///////////////////////////////// ACTUALIZA LA FACTURACION


?>