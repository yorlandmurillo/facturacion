<script type="text/javascript" src="includes/calendar.js"></script>
		<script type="text/javascript" src="lang/calendar-es.js"></script>
		<script type="text/javascript" src="includes/calendar-setup.js"></script>
		
		<link rel="stylesheet" type="text/css" media="all" href="includes/calendar-win2k-cold-2.css"/>
		<link rel="STYLESHEET" type="text/css" href="includes/estilos.css" media='screen'>
		<link rel="STYLESHEET" type="text/css" href="includes/estilos_imprimir.css" media="print">
		
		
		<script src="/inventario/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="/inventario/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {
	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
	FONT-WEIGHT:normal;
	FONT-SIZE: 8pt;
	text-align: left;
	height:20px;
	color: #666;
text-align:left;
background: #fff;
border: 0px;
padding: 1px 0px 0px 5px;

}
-->
</style>
<?
 	
$link_Busca = mysql_connect("localhost","inventa_bd","Valenta@04") or die (mysql_error());  
mysql_select_db("inventa_pglibreria",$link_Busca);

$select="SELECT DISTINCT (
	tbl_itemfactura.sucursal
	) AS factura_sucursal, tbl_sucursal.sucursal
	FROM tbl_itemfactura, tbl_sucursal
	WHERE tbl_itemfactura.sucursal = tbl_sucursal.id_sucursal
	ORDER BY tbl_sucursal.sucursal";
	$result=mysql_query($select,$link_Busca) or die("<br>".mysql_error());

?> 
<div id="navegador">
	<p><img src="../../imagenes/banner.png" width="760" height="148" /></p>
</div>
<script language='javascript' src="popcalendar.js"></script> 

<script language="javascript" type="text/javascript">
//Validacion de campos de texto no vacios by Mauricio Escobar
//
//Iván Nieto Pérez
//Este script y otros muchos pueden
//descarse on-line de forma gratuita
//en El Código: www.elcodigo.com


//*********************************************************************************
// Function que valida que un campo contenga un string y no solamente un " "
// Es tipico que al validar un string se diga
//    if(campo == "") ? alert(Error)
// Si el campo contiene " " entonces la validacion anterior no funciona
//*********************************************************************************

//busca caracteres que no sean espacio en blanco en una cadena
function vacio(q) {
        for ( i = 0; i < q.length; i++ ) {
                if ( q.charAt(i) != " " ) {
                        return true
                }
        }
        return false
}
</script>


<?php

//////////////////////////////////////////////// INICIANDO VARIABLES



//include("conexion.php");
//include("includes/functions.php");

$anio = isset($_POST['fechaz'])?$_POST['fechax']:'0000';

 
?>
<form name="frmLibro" method="post" action="estadisticaslb2.php">   
  
  
  <table width="100%" border="0">
  <tr>
    <td>
    
  <table width="100%" align="center">
    <tr>
      <td width="15%" class="TextFiel">&nbsp;</td>
      <td colspan="2" class="TextFiel"><span class="Estilo1">Movimientos de Notas de Entrega y Control Perceptivo de la Distribuidora de la Cultura</span></td>
      </tr>
    <tr>
      <td width="15%" class="TextFiel">&nbsp;</td>
      <td width="12%" class="TextFiel">Desde:</td>
      <td width="73%" class="TextFiel"><span id="sprytextfield1">
        <input name="fecha" type="text" id="dateArrival" onclick="popUpCalendar(this, frmLibro.dateArrival, 'yyyy-mm-dd');" size="20" />
        <span class="textfieldRequiredMsg"></span></span></td>
    </tr>
    
       
      
  
      <tr>  
        <td width="15%" class="TextFiel">&nbsp;</td>
        <td class="TextFiel">Hasta:</td>
        <td class="TextFiel"><span id="sprytextfield2">
          <input name="fecha2" type="text" id="dateArrival2" onclick="popUpCalendar(this, frmLibro.dateArrival2, 'yyyy-mm-dd');" size="20" />
          <span class="textfieldRequiredMsg"></span></span></td>
        </tr>
      <tr>
        <td class="TextFiel">&nbsp;</td>
        <td class="TextFiel">Numero Sucursal:</td>
        <td class="TextFiel"><span id="sprytextfield3"><span class="textfieldRequiredMsg"></span></span>
          <select name="sucursal">
	 <option value="0-Todas"selected>Todas</option>
	  <?php
	  while($row = mysql_fetch_row($result))
	   {
	   ?>
	   <option value="<?php echo $row[0]."-".$row[1]; ?>"><?php echo $row[1]; ?></option>
	   <?php
	   }    
	  ?>
	  </select></td>
      </tr>  
      <tr>
        <td colspan="2" class="TextFiel">&nbsp;</td>
        <td class="TextFiel"><input type="submit" name="enviar" id="enviar" value="Buscar"   />          <input type="reset" name="Limpiar" id="Limpiar" value="Limpiar" /></td>
        </tr>
  </table>

    </td>
  </tr>
</table>
  
  </label>

<Br>

<hr class='noimprimir'>

</form>
<script type="text/javascript">
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
</script>
</body>
</html>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
</script>
