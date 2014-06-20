<?
require("../admin/session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.
if ($_SESSION['usuario_nivel'] < $nivel_acceso){
Header ("Location: ../admin/login.php?error_login=5");
exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Facturas</title>
</head>
<style>
a{
	text-decoration:underline;
	cursor:pointer;
}
.imputbox {  font-size: 10pt; color: #000000; background-color: #FFFFFF; font-family: Verdana, Arial, Helvetica, sans-serif; border:solid; border-color:#990000; font-weight: normal;text-align:right;}
.botones {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #CCCCCC ; border-top-width: 1pix; border-right-width: 1pix; border-bottom-width: 1pix; border-left-width: 1pix}

.table {  font-size: 10pt; color: #990000; background-color: #FFFFFF; font-family: Verdana, Arial, Helvetica, sans-serif; border:double; border-color:#990000; font-weight: normal;text-align:left;}

.celda{  font-size: 10pt; color: #FFFFFF; background-color: #990000; font-family: Verdana, Arial, Helvetica, sans-serif; border:double; border-color:#990000; font-weight: normal;text-align:left;}

TABLE.Mtable TD {
        BORDER-RIGHT: #93bee2 1px solid;
        BORDER-BOTTOM: #c1cdd8 1px solid;
}
TABLE.Mtable TH {
        BORDER-RIGHT: #93bee2 1px solid;
}
TABLE.Mtable {
        border: 1px solid #336699;
}

.TRalter {
        background-color : #F0F0F0; 
}

</style>
<style type="text/css">
@import url(calendar/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
  <script language="JavaScript">

   function habilitafact()
   {
		document.facturas.codfactura.disabled = false;
		document.facturas.facturamanual.disabled = true;
		document.facturas.facturamanual.value = "";
		document.facturas.cedula.disabled = true;
		document.facturas.cedula.value = "";
		document.facturas.fecha1.disabled = true;
		document.facturas.fecha1.value = "";
		document.facturas.fecha2.disabled = true;
		document.facturas.fecha2.value = "";
		
   }

   function habilitatal()
   {
		document.facturas.facturamanual.disabled = false;
		document.facturas.codfactura.disabled  = true;
		document.facturas.codfactura.value = "";
		document.facturas.cedula.disabled = true;
		document.facturas.cedula.value = "";
		document.facturas.fecha1.disabled = true;
		document.facturas.fecha1.value = "";
		document.facturas.fecha2.disabled = true;
		document.facturas.fecha2.value = "";
   }

   function habilitaced()
   {
		document.facturas.cedula.disabled = false;
		document.facturas.codfactura.disabled  = true;
		document.facturas.codfactura.value = "";
		document.facturas.facturamanual.disabled = true;
		document.facturas.facturamanual.value = "";
		document.facturas.fecha1.disabled = true;
		document.facturas.fecha1.value = "";
		document.facturas.fecha2.disabled = true;
		document.facturas.fecha2.value = "";
   }

	function habilitafecha()
   {
		document.facturas.fecha1.disabled = false;
		document.facturas.fecha2.disabled = false;
		document.facturas.codfactura.disabled  = true;
		document.facturas.codfactura.value = "";
		document.facturas.facturamanual.disabled = true;
		document.facturas.facturamanual.value = "";
		document.facturas.cedula.disabled = true;
		document.facturas.cedula.value = "";
   }

  </script>
<body>
<table width="340" border="0" align="center" style="border:double;border-color:#990000;">
  <tr>
    <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">
	<form id="facturas" name="facturas" action="">
	
	<input type="hidden" name="vendedor" id="vendedor" value="<?= $_SESSION['usuario_id'];?>"> 
	<input type="hidden" name="sucursal" id="sucursal" value="<?= $_SESSION['usuario_sucursal'];?>"> 

      <table width="260" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
        <tr><td colspan="5"><strong>Busqueda de Facturas</strong></td></tr>
        <tr> <td colspan="5" class="botones">&nbsp;</td></tr>
        <tr><td colspan="5"><div align="center"></div></td></tr>
        <tr><td><input type="radio" name="rad" value="0" onclick="habilitafact()"></td>
          <td width="62" align="left">C&oacute;digo:</td>
          <td colspan="2" align="right"><input name="codfactura" type="text" size="20" style="text-align:right;"/></td>
          <td>&nbsp;</td><td>&nbsp;</td>
        </tr>
		<tr><td><input type="radio" name="rad" value="0" onclick="habilitatal()"></td>
           <td colspan="2" align="left">Cod o Num Talonario:</td>
          <td colspan="2" align="right"><input name="facturamanual" type="text" size="20" style="text-align:right;"  disabled/></td>
          <td>&nbsp;</td>
        </tr>
        <tr><td><input type="radio" name="rad" value="0" onclick="habilitaced()"></td>
          <td>C&eacute;dula:</td>
          <td colspan="2"><input name="cedula" id="cedula" type="text" size="20" style="text-align:right;"  disabled/></td>
          <td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <tr><td><input type="radio" name="rad" value="0" onclick="habilitafecha()"></td>
          <td>Fecha:</td>
          <td width="58">Desde:</td>
          <td width="60"><input name="fecha1" type="text" size="10" id="fecha1" readonly="true" disabled/></td>
          <td width="40">&nbsp;</td>
          <td width="32"><img src="../imagenes/cal.png" id="trigger1"
     style='cursor: pointer; border: 0px solid red;'
     title='Selector de fecha'
     onmouseover="this.style.background='red';"
     onmouseout="this.style.background=''"/></td>
        </tr>
        <tr><td></td><td>&nbsp;</td><td>Hasta:</td>
          <td><script type="text/javascript">
  Calendar.setup(
    {
      inputField  : 'fecha1',         // ID of the input field
      align          :    'Tr',
      singleClick    :    false,
      ifFormat    : '%d/%m/%Y',    // the date format
      button      : 'trigger1'       // ID of the button
    }
  );
      </script>
              <input name="fecha2" type="text"  size="10" id="fecha2" readonly="true" disabled/></td>
          <td>&nbsp;</td>
          <td><img src="../imagenes/cal.png" id="trigger2"
     style='cursor: pointer; border: 0px solid red;'
     title='Selector de fecha'
     onmouseover="this.style.background='red';"
     onmouseout="this.style.background=''" />
              <script type="text/javascript">
  Calendar.setup(
    {

	  inputField  : 'fecha2',         // ID of the input field
      align          :    'Tr',
      singleClick    :    false,
      ifFormat    : '%d/%m/%Y',    // the date format
      button      : 'trigger2'       // ID of the button
	  }
	
  );
        </script></td>
        </tr>
        <tr><td colspan="5" class="botones">&nbsp;</td></tr>
        <tr><td colspan="5">&nbsp;</td></tr>
        <tr><td colspan="5"><div align="right">
                <input name="buscar" type="button" class="botones" onclick="consultai()" value="Buscar" />
                <input name="hoy" type="button" class="botones" onclick="consultaa()" value="Hoy" />
                <input name="todos" type="button" class="botones" onclick="consultag()" value="Todas" />
	            <input name="salir" type="button" class="botones" onclick="esc()" value="Salir" />
                    </div></td>
          </tr>
      </table>
    </form></td>
    <td>&nbsp;</td>
  </tr>
  <tr><td>&nbsp;</td><td colspan="3"><div id="resultado"></div></td><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td><td colspan="3"><div id="cargando"></div></td><td>&nbsp;</td></tr>
</table>
</body>
</html>
