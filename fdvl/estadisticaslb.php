<script src="/inventario/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="/inventario/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
<div id="navegador">
	<p>
		<SPAN class='noimprimir'>
		<a href="#">Sistema de Inventario</a> | 
		<a href="#">M&oacute;dulo de Operativo</a> | </SPAN>Monitoreo de Notas de Entrega</p>
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



include("conexion.php");
include("includes/functions.php");

$anio = isset($_POST['fechaz'])?$_POST['fechax']:'0000';

 
?>
<SPAN class='noimprimir Estilo1'>Busqueda de Nota de Entrega Enviadas</SPAN>
<form name="frmLibro" method="post" action="inventario.php?p=estadisticaslb2">   
   

<table width="100%" border="0">
  <tr>
    <td>
    
  <table width="608">
    <tr>
      <td width="9%" class="TextFiel">&nbsp;</td>
      <td width="11%" class="TextFiel">Desde:</td>
      <td width="80%" class="TextFiel"><span id="sprytextfield1">
        <input name="fecha" type="text" id="dateArrival" onclick="popUpCalendar(this, frmLibro.dateArrival, 'yyyy-mm-dd');" size="20" />
        <span class="textfieldRequiredMsg">..?</span></span></td>
    </tr>
    
       
      
      <?php
$NE= $row_Recordset1['NOT_NUMNOT'];
$VALORVENTA= $row_Recordset1['trs_descrip'];

?>
      <tr>  
        <td class="TextFiel">&nbsp;</td>
        <td class="TextFiel">Hasta:</td>
        <td class="TextFiel"><span id="sprytextfield2">
          <input name="fecha2" type="text" id="dateArrival2" onclick="popUpCalendar(this, frmLibro.dateArrival2, 'yyyy-mm-dd');" size="20" />
          <span class="textfieldRequiredMsg">..?</span></span></td>
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
</body>
</html>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
</script>
