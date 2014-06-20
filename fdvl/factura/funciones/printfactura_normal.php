<?
require("../admin/session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.

if ($_SESSION['usuario_nivel'] < $nivel_acceso){
Header ("Location: ../admin/login.php?error_login=5");
exit;
}

@ $factura= $_GET['codf'];
@ $vend= $_GET['vend'];
@ $suc= $_GET['suc'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Impresi&oacute;n de Facturas</title>
<style type="text/css" media="print">
<!--
.noimprime { 
display:none;

}
-->
</style> 

<style type="text/css">
<!--
.style2 {
	font-size: 14px;
	font-family: Helvetica;
}
body {
	margin-left: 1px;
	margin-right: 1px;
}
.style3 {font-size: 14px; font-family: Helvetica: bold; }
.style4 {font-size: 14px; font-family: Helvetica: bold; }
.style6 {font-size: 16px; font-family: Helvetica: bold; }
.style5 {
font-size: 13px; 
font-family: Arial, Helvetica, sans-serif; 
color: #FFFFFF; 
background-color:#999999;
border: 1px solid #333333;
}

th {
        font-size : 11px;
        font-family : Arial, Helvetica, sans-serif;
        color : #FFFFFF;
        text-align : center;
        font-weight : bold;
        background-color:#990000;
}
tr {
        font-family: Arial, Helvetica, sans-serif; 
        font-size: 11px;
        background-color : #FFFFFF;
}
td {
        font-family: Arial, Helvetica, sans-serif; 
        font-size: 14px;
}

TABLE.Mtable TD {
        BORDER-RIGHT: #93bee2 1px;
        BORDER-BOTTOM: #c1cdd8 1px;
}

TABLE.Mtable TH {
        BORDER-RIGHT: #93bee2 1px ;
}
TABLE.Mtable {
        border: 1px;
}

.TRalter {
        background-color : #F0F0F0; 
}

.boton{
font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix;
-moz-border-radius:6px;

}

-->
</style>
<script type="text/javascript"  language="javascript"  src="js/shortcut.js"></script>
<script type="text/javascript"  language="javascript"  src="js/init.js"></script>
<script type="text/javascript"  language="javascript"  src="js/imprimir.js"></script>
<script language="javascript">
//function printPage() { print(document); }
//function mensaje() { 
//alert("Presione [F10] para Imprimir la factura o [ESC] para Salir"); }

</script>

</head>
<body>
<?

$obj=new manejadordb;

$query="SELECT tbl_itemfactura.cod_factura AS factura, 
tbl_facturas.fecha_factura AS fecha, 
tbl_facturas.mto_total AS monto, 
tbl_facturas.efectivo AS efec, 
tbl_facturas.cheque AS cheque, 
tbl_facturas.tdb AS tdb, 
tbl_facturas.tdc AS tdc, 
tbl_facturas.bl AS bl, 
tbl_facturas.cesta_ticket AS cesta, 
tbl_facturas.pago_especial AS esp, 
tbl_facturas.otra_moneda AS omoneda, 
tbl_facturas.cambio AS cambio, 
tbl_facturas.mto_iva,
tbl_itemfactura.cod_producto AS producto, 
tbl_itemfactura.descripcion AS descripcion, 
tbl_itemfactura.cantidad AS cant, 
tbl_itemfactura.precio_unid AS precio, 
tbl_itemfactura.descuento AS descuento, 
cod_cliente AS cedula, 
tbl_usuario.us_login AS vendedor, 
tbl_sucursal.sucursal AS sucursal,tbl_sucursal.telefono AS telefono
From tbl_facturas,tbl_itemfactura,tbl_usuario,tbl_sucursal
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_facturas.vendedor = tbl_usuario.id_usuario
and tbl_facturas.sucursal = tbl_sucursal.id_sucursal
and tbl_facturas.cod_factura='$factura' AND tbl_facturas.sucursal='$suc'
AND tbl_facturas.estatus_factura=3";

 //die($query);
 $result = $obj->consultar($query);
 // result of count query
 $head = mysql_fetch_assoc($result);
?>
<table width="430" border="0"  cellspacing="0" align="center" class="Mtable">
  <tr>
    <td colspan="4" class="style4"><div align="center">
      <p class="style3">Fundaci&oacute;n Librer&iacute;as del Sur      
      <p class="style3">&nbsp;&nbsp;
        Calle H&iacute;pica con Av. La Guairita, Edif. Fundaci&oacute;n Librer&iacute;as del Sur PB Apto. U, Las Mercedes, Caracas/Venezuela        
    </div></td>
  </tr>
<? 
$cedula=$head["cedula"];
$query_cliente="select cli_nombre from tbl_cliente where cli_cedula='$cedula' limit 0,1";
$result_cliente = $obj->consultar_remoto($query_cliente);
 // result of count query
 $head_cliente = mysql_fetch_assoc($result_cliente);
 $nombre=$head_cliente["cli_nombre"];
 echo '
  <tr>
    <td colspan="4" class="style4"><span class="style4">RIF: G-20007995-9 </span></td>
  </tr>
  <tr>
    <td colspan="4" class="style4"><span class="style2">Sucursal: ';echo $head["sucursal"];   echo '</span></td>
  </tr>
  <tr>
    <td colspan="4" class="style4"><span class="style2">Teléfono: ';echo $head["telefono"];   echo '</span></td>
  </tr>
  <tr>
    <td colspan="4" class="style4"><span class="style2">Vendedor: ';echo $head["vendedor"];   echo '</span></td>
  </tr>
  <tr>
    <td colspan="4" class="style4"><span class="style2">Cliente: ';echo $nombre;   echo '</span></td>
  </tr>
  <tr>
    <td colspan="4" class="style4"><span class="style2">C.I/RIF: ';echo $head["cedula"];   echo '</span></td>
  </tr>
  <tr>
    <td colspan="4" class="style4"><span class="style2">Factura: ';echo $head["factura"];   echo '</span></td>
  </tr>
  <tr>
    <td colspan="4"><div align="center"><span class="style2">&quot;Contribuyente Formal&quot;</span></div></td>
  </tr>
  <tr>
    <td colspan="4"><span class="style4">Fecha: ';echo $head["fecha"]; echo '</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center" class="style5">C&oacute;digo</div></td>
    <td><div align="center" class="style5">Descripci&oacute;n</div></td>
    <td><div align="center" class="style5">Cant.</div></td>
    <td><div align="center" class="style5">Precio</div></td>
    <td><div align="center" class="style5">%Des</div></td>	
  </tr>';

 $result2 = $obj->consultar($query);

  $i = 0;
  $pts="";
     while ($row = mysql_fetch_assoc($result2)) 
     {         
        $totallibros+=$row["cant"];
		//alternate color
        if($i%2 == 0)  
               echo "<tr class=\"TRalter\">\n";
        else
        echo "<tr>\n";
  	
		 if(strlen($row['descripcion'])>6){
		 $pts="...";
		 }else $pts="";
  		
		 echo "<td><div align='left' >".$row["producto"]."</div></td>\n";
         echo "<td><div align='left'>".substr($row["descripcion"],0,6).$pts."</div></td>\n";
         echo "<td><div align='center' >".$row["cant"]."</div></td>\n";
         echo "<td align='center'><div align='right' >".number_format($row["precio"],2,',','.')."</div></td>\n";
		 echo "<td align='center'><div align='center' >".($row["descuento"]*100)."</div></td>\n";

echo "</tr>\n";
        $i++;    
     }   
  
echo'

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style6" colspan="5" align="right" ><strong>Total Cancelar:&nbsp;&nbsp;'.number_format($head["monto"],2,',','.').'</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style4" colspan="3">FORMA DE PAGO</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
';

if($head["efec"]>0){

echo'<tr>
    <td>Efectivo:</td>
    <td align="right">'.number_format($head["efec"],2,',','.').'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
}
if($head['cheque']>0){

echo'<tr>
    <td>Cheque:</td>
    <td align="right">'.number_format($head["cheque"],2,',','.').'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
}
if($head["tdb"]>0){

echo'<tr>
    <td>TDB:</td>
    <td align="right">'.number_format($head["tdb"],2,',','.').'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
}
if($head["tdc"]>0){

echo'<tr>
    <td>TDC:</td>
    <td align="right">'.number_format($head["tdc"],2,',','.').'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
}
if($head["bl"]>0){

echo'<tr>
    <td>Bonolibro:</td>
    <td align="right">'.number_format($head["bl"],2,',','.').'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
}
if($head["cesta"]>0){
echo'<tr>
    <td>C. Ticket:</td>
    <td align="right">'.number_format($head["cesta"],2,',','.').'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
}
if($head["esp"]>0){
echo'<tr>
    <td>Especial:</td>
    <td align="right">'.number_format($head["esp"],2,',','.').'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
}
if($head["omoneda"]>0){
echo'<tr>
    <td>O.Moneda:</td>
    <td align="right">'.number_format($head["omoneda"],2,',','.').'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
}
echo'<tr>
    <td>Cambio:</td>
    <td align="right">'.number_format($head["cambio"],2,',','.').'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
echo'<tr>
    <td>Monto iva:</td>
    <td align="right"><b>'.number_format($head["mto_iva"],2,',','.').'</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';

echo'<tr>
    <td colspan="5" align="center">&nbsp;</td>
    </tr>';

echo'<tr>
    <td colspan="5" align="center">Libros Vendidos: '.$totallibros.'</td>
    </tr>';

echo'<tr>
    <td colspan="5" align="center">&nbsp;</td>
    </tr>';

echo'<tr>
    <td colspan="5" align="center">Depues de (3) d&iacute;as no se aceptan devoluciones</td>
    </tr>';
echo'
</table>';
?>
<p>&nbsp;</p>

<input name="lineas" type="hidden" value="<?php echo ($totallibros); ?>" />




<form id="print" name="print" method="post" action="">
  <div align="center">
  <input type="button" id="imprimir" name="imprimir" value="Imprimir" onclick="<? echo "printfactura('$factura','$vend','$suc')";?>" class="boton noimprime"/>
  <!--  <input type="button" name="salir" value="Regresar" onclick="javascript:window.location.href='../additemfactura.php'" class="boton noimprime"/>-->
  </div>

</form>
<p>&nbsp;</p>
</body>
</html>


<?php

///////////////////////////////// ACTUALIZA LA FACTURACION

if (!($link= @mysql_connect("localhost","inventa_bd","Valenta@04")))
{

// Inicializa de la sesion

exit();
}



if (! @mysql_select_db("inventa_pglibreria",$link))
{
echo "Error seleccionando la base de datos.";
exit();
}

/*
if (!($link2= @mysql_connect("190.202.94.42","libsur","L#ibsur*")))
{

// Inicializa de la sesion

exit();
}
if (! @mysql_select_db("pglibreria_facturacion",$link2))
{
echo "Error seleccionando la base de datos.";
exit();
}
*/

if (!($link2= @mysql_connect("10.0.0.20","inventa_bd","Valenta@04")))
{

// Inicializa de la sesion

exit();
}
if (! @mysql_select_db("inventa_pglibreria",$link2))
{
echo "Error seleccionando la base de datos.";
exit();
}


$resultFac = @mysql_query("
SELECT * FROM tbl_facturas WHERE tbl_facturas.enviado = 'N' AND estatus_factura = '3'",$link); 

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

SELECT * FROM tbl_itemfactura WHERE tbl_itemfactura.enviado = 'N' AND estatus_cancelacion = '3'",$link); 



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




	mysql_close($link);
		mysql_close($link2);





///////////////////////////////// ACTUALIZA LA FACTURACION


?>
