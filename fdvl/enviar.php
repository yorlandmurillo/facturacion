<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enviar Datos</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>


<html>
<title>&Aacute;rea de Administraci&oacute;n </title>
<head>

</head>
<style type="text/css">
<!--

.botones {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #000000 ; border-top-width: 1pix; border-right-width: 1pix; border-bottom-width: 1pix; border-left-width: 1pix;}


.button {

	border-color: #bd9494;
	background-color: #f0f0f0;
	color: #000;
	<!--background-image: url(imagenes/bgBtnGray.gif);-->
	vertical-align: middle;
	}

.buttonOn, .button:hover, .button:focus, .buttonOn:focus {
	background-color: #cc6666;
	border-color: #777777;
	}
.button[disabled] {
	border-color: #c1c1c1;
	background-color: #f0f0f0;
	color: #000;
	background-image: url(imagenes/bgBtnGray.gif);
}


input,select {
	border-color: #eac3c3;
	background-color: #ffffff;
	}

input:focus,textarea:focus, select:focus {
	background-color: #fff;
	border-color: #dd9e9e;
	 }



.imputbox {  font-size: 10pt; color: #000099; background-color: #CCFFCC; font-family: Verdana, Arial, Helvetica, sans-serif; border: 1pix #000000 solid; border-color: #000000 solid; font-weight: normal}
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
	background-color:#990000}
.Estilo2 {color: #990000}
-->
</style>
<body bgcolor="#FFFFFF" onLoad="nombreequipo()">
<span></span><span></span>
<table width="743" height="541" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 0.5px #990000;">
  <tr>
    <td valign="top">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td width="3548" height="64"><div align="center" class="Estilo1" id="name">
  
              <img src="factura/imagenes/libsur.png" width="862" height="144"></div></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="202" border="0" cellspacing="0" cellpadding="0" align="center" >
              <tr>
                <td width="220"><table width=100% height="135" border=0 align="center" cellpadding="0" cellspacing="0" style="border:dashed 1px #990000;">
                    <form action="index.php" method="post">
                      <tr bgcolor="#990000">
                        <td  height="19" colspan="2" bgcolor="#FFFFFF"><div align="center" ><img src="factura/imagenes/txt_sesion.png" width="227" height="38"></div></td>
                      </tr>
                      <tr>
                        <td height="66" colspan="2" bgcolor="#E6E6E6">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
                              <tr>
                                <td width="39%" align="left" bgcolor="#E6E6E6"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Usuario: </font></div></td>
                                <td width="61%" bgcolor="#E6E6E6"><div align="left">
                                    <input type="text" name="user" size="20" style="elevation:lower">
                                </div></td>
                              </tr>
                              <tr>
                                <td width="39%" bgcolor="#E6E6E6"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Contrase&ntilde;a: </font></div></td>
                                <td width="61%" bgcolor="#E6E6E6"><div align="left">
                                    <input type="password" name="pass" size="20" >
                                </div></td>
                              </tr>
                            </table>
                        </div></td>
                      </tr>
                      <tr valign="middle">
                        <td colspan="2" height="25" bgcolor="#E6E6E6"><div align="center"><font face="Arial" color=black size=2>
                            <input name=submit type=submit value="  Entrar  " class="botones">
                        </font></div></td>
                      </tr>
                      <tr valign="middle">
                        <td colspan="2" height="25" bgcolor="#E6E6E6">&nbsp;</td>
                      </tr>
                    </form>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    <p></p></td>
  </tr>
  <tr>
    <td align="right" valign="top" style="border-top:solid 0.5px #990000;"><p class="botones">Desarrollado por la Coordinaci&oacute;n de Tecnolog&iacute;a e Inform&aacute;tica</p>    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>


<?php

///////////////////////////////// ACTUALIZA LA FACTURACION

if (!($link= @mysql_connect("localhost","inventa_bd","Valenta@04")))
{
echo "<script>alert('NO SE PUEDE ENVIAR LOS DATOS, POR FAVOR VERIFIQUE SU CONEXIÓN A INTERNET');location.href='/fdvl/factura/login.php';</script>";
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


if (!($link2= @mysql_connect("190.202.94.42","libsur","L#ibsur*")))
{
echo "<script>alert('NO SE PUEDE ENVIAR LOS DATOS, POR FAVOR VERIFIQUE SU CONEXIÓN A INTERNET');location.href='/fdvl/factura/login.php';</script>";
// Inicializa de la sesion
session_start();
// Destruye todas las variables de la sesion
session_unset();
// Finalmente, destruye la sesion
session_destroy();
exit();
}
if (! @mysql_select_db("pglibreria_facturacion",$link2))
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



	mysql_close($link);
		mysql_close($link2);





///////////////////////////////// ACTUALIZA LA FACTURACION


?>
<body> 
<script type="text/javascript"> 
window.location="http://localhost/fdvl/factura/index.php"; 
</script> 
</body>