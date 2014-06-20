<?
require("../admin/session.php");// // incluir motor de autentificación.
//require("../../includes/conexion.php");
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.
date_default_timezone_set('America/Caracas');
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
<title>Edici&oacute;n de Facturas</title>
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
<!--<script type="text/javascript"  language="javascript"  src="js/init.js"></script>-->
<script type="text/javascript"  language="javascript"  src="js/imprimir.js"></script>
<script type="text/javascript"  language="javascri<!pt"  src="js/ajax.js"></script>
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script language="javascript">
function esc(){
	window.close(this);
}



</script>

</head>
<body>
<?

$obj=new manejadordb;

$query="SELECT cod_factura,fecha_factura,vendedor,efectivo,cheque,tdb,tdc,cesta_ticket,bl,mto_iva,sub_total,mto_total,estatus_factura,tbl_sucursal.sucursal
FROM tbl_facturas,tbl_sucursal
WHERE tbl_facturas.cod_factura='$factura' 
AND tbl_facturas.sucursal=$suc
AND tbl_sucursal.id_sucursal=tbl_facturas.sucursal
";
//die($query);
 $result = $obj->consultar($query);
 // result of count query
 //$head = mysql_fetch_array($result);
?>
<table width="430" border="0"  cellspacing="0" align="center" class="Mtable">
<form method="POST" action="editfacturalp.php" name="muestrafactura">
  <?
     while ($row = mysql_fetch_array($result)) 
     {  
		$vendedor=$row["vendedor"];
		$fechacorta=substr($row["fecha_factura"],0,10);
		$estatus_factura=$row["estatus_factura"];
	?>
	  <tr><td colspan="4" class="style4"><span class="style2"><b>Libreria: <? echo $row["sucursal"] ?></b></span></td></tr>
	  <tr><td colspan="4" class="style4"><span class="style2"><b>Codigo de la factura: <? echo $row["cod_factura"] ?></b></span></td></tr>
	  <tr><td colspan="4" class="style4"><span class="style2">Fecha de la factura:<input type="text" name="fecha_factura" value="<? echo $row["fecha_factura"] ?>"
	  <?
		if($estatus_factura=='5')
		{
			echo "disabled=true";
		}
	?>
	  /></span></td></tr>
	  <tr><td colspan="4" class="style4"><span class="style2">Pago en efectivo:<input type="text" name="efectivo" value="<? echo $row["efectivo"] ?>"
	   <?
		if($estatus_factura=='5')
		{
			echo "disabled=true";
		}
	?>
	  /></span></td></tr>
	  <tr><td colspan="4" class="style4"><span class="style2">Pago en cheque:<input type="text" name="cheque" value="<? echo $row["cheque"] ?>"
	   <?
		if($estatus_factura=='5')
		{
			echo "disabled=true";
		}
	?>
	  /></span></td></tr>
	  <tr><td colspan="4" class="style4"><span class="style2">Pago en tarjeta de debito: <input type="text" name="tdb" value="<? echo $row["tdb"] ?>"
	   <?
		if($estatus_factura=='5')
		{
			echo "disabled=true";
		}
	?>
	  /></span></td></tr>
	  <tr><td colspan="4" class="style4"><span class="style2">Pago en tarjeta de credito: <input type="text" name="tdc" value="<? echo $row["tdc"] ?>"
	   <?
		if($estatus_factura=='5')
		{
			echo "disabled=true";
		}
	?>
	  /></span></td></tr>
	  <tr><td colspan="4" class="style4"><span class="style2">Pago en cesta ticket: <input type="text" name="cesta_ticket" value="<? echo $row["cesta_ticket"] ?>"
	   <?
		if($estatus_factura=='5')
		{
			echo "disabled=true";
		}
	?>
	  /></span></td></tr>
	  <tr><td colspan="4" class="style4"><span class="style2">Pago en bono libro: <input type="text" name="bl" value="<? echo $row["bl"] ?>"
	   <?
		if($estatus_factura=='5')
		{
			echo "disabled=true";
		}
	?>
	  /></span></td></tr>
	  <tr><td colspan="4" class="style4"><span class="style2">Monto IVA: <input type="text" name="mto_iva" value="<? echo $row["mto_iva"] ?>"
	   <?
		if($estatus_factura=='5')
		{
			echo "disabled=true";
		}
	?>
	  /></span></td></tr>
	  <tr><td colspan="4" class="style4"><span class="style2"><b>Sub total: <? echo $row["sub_total"] ?></b></span></td></tr>
	  <tr><td colspan="4" class="style4"><span class="style2"><b>Monto Total: <? echo $row["mto_total"] ?></b></span></td></tr>
	 <?
     }   

?>
</table>
<input type="hidden" name="cod_factura" value="<? echo $factura ?>">
<input type="hidden" name="sucursal" value="<? echo $suc ?>">

<div id="resultado"></div>
 <div align="center">
<?
if($estatus_factura=='3')
{
?>
 
  <input type="submit" id="Actualizar" name="Actualizar" value="Actualizar"/>

<?
}
else
{
?>
	<div align="center"><b>LA FACTURA ESTA ANULADA</b></div>
  <?
}
?>

<input name="salir" type="button" class="botones" onclick="esc()" value="Salir" />
  </div>


</form>
<?
if($estatus_factura=='3')
{
?>
	<div align='center' id="anula">
	<br><br>
	<table border="2"><tr><td  bgcolor="#00FFFF">
	<h1><b><font size='5' color=red>HAGA CLICK AQUI PARA ANULAR LA FACTURA</font></b></h1>
	
	<!--<form method="POST" action="../anulafactura.php">-->
	<form method="POST" onsubmit="anulafact(this)" name="anulafactura">
	<input type="hidden" name="fecha" value="<? echo $fechacorta ?>">
	<input type="hidden" name="vend" value="<? echo $vendedor ?>">
	<input type="hidden" name="codf" value="<? echo $factura ?>">
	<input type="hidden" name="suc" value="<? echo $suc ?>">
	<div align='center'>
	<input id="button" onclick="anulafact()" id="Anular" name="Anular" value="Anular" type="button">
	</form>
	</td></tr></table>
		</div>
<?
}
?>
</body>
</html>
