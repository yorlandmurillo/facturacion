<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registro de Clientes</title>
<script type="text/javascript" src="js/ajax.js"></script>

</head>
<? $origen=getenv("HTTP_REFERER"); ?>
<a href="../consultas/clientes.php?facturando=1&tipo=<?echo $_GET["tipo"];?>" style="border:double;background-color:#FFFFFF;text-decoration:inherit;border-bottom-style:double"><img src='../imagenes/salir.png' border="0"> Regresar</a>
<style>
.campo{
    border:double;
	border-color:#CCCCCC;
	background-color:#FFFFFF;

}
.sinborde{
    border:none;
}

input, select,textarea    { border: 1px solid silver; }
input.error {padding-right: 16px; border: 1px solid red; background-image: url(imagenes/warning_obj.gif); background-position: right; background-repeat: no-repeat;}
input:focus {border: 1px solid red; background-color:#EFEFEF;}
td.activetab {
    background-color: silver;
}

</style>
<body>
<div align="center" id="resultado"></div>
<form id="clientes" name="clientes" action="">
<?php
$buscar = $_GET["buscar"]; 

?>

<br>
<table width="506" align="center" id="table1" widtd="398" style="border:double;border-color:#990000;border-bottom-style:groove;">
  <tr>
    <th colspan="4">Datos Personales </th>
  </tr>
  <tr>
    <td width="106">&nbsp;</td>
    <td width="120">&nbsp;</td>
    <td width="144">&nbsp;</td>
    <td width="120">&nbsp;</td>
  </tr>
  <tr>
    <th> <div align="left">C&eacute;dula/NIF: *</div></th>
    <td class="campo"><div align="right">
      <input type="text" name="clicedula" id="clicedula" size="20" maxlengtd="15" value="<?php echo $buscar; ?>" >
    </div></td>
    <th><div align="left">Nombre: *</div></th>
    <td class="campo" ><div align="right">
      <input type="text" name="clinombre" id="clinombre" input style="text-transform: uppercase"   onClick=this.value="" size="20" maxlengtd="100" class="sinborde" />
    </div></td>
  </tr>
  <tr>
    <th ><div align="left">Posee Bono L.: </div></th>
    <td class="campo" ><select name="pbl" id="pbl" class="sinborde">
      <option value="0" selected="selected">No</option>
      <option value="1">Si</option>
    </select></td>
    <th><div align="left">Sexo:</div></th>
    <td class="campo" ><div align="right">
      <select name="sexo" id="sexo" class="sinborde">
        <option value="F" selected="selected">Femenino</option>
        <option value="M">Masculino</option>
      </select>
    </div></td>
  </tr>
  <tr>
    <th ><div align="left">Tarj. Bono Libro: </div></th>
    <td class="campo" ><div align="right">
        <input type="text" name="clibl" id="clibl" size="20" onClick=this.value=""  value="0" class="sinborde" onkeyup="validarnum(this,1)" />
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th colspan="4" >Datos de Hubicaci&oacute;n </th>
  </tr>
  <tr>
    <th><div align="left">Direcci&oacute;n:</div></th>
    <td class="campo" ><input name="clidireccion" type="text" class="sinborde" id="clidireccion" style="text-transform: uppercase" onClick=this.value="" value="Caracas Dtto. Capital " size="20" input /></td>
    <th><div align="left">Telf. Habitaci&oacute;n: </div></th>
    <td class="campo" ><div align="right">
      <input type="text" name="clitelefono" id="clitelefono" size="20" onClick=this.value="" maxlengtd="15" value="0" class="sinborde" onkeyup="validarnum(this,1)" />
    </div></td>
  </tr>
  <tr>
    <th><div align="left">Celular:</div></th>
    <td class="campo" ><div align="right">
      <input type="text" name="clicelular" id="clicelular" size="20" onClick=this.value="" maxlengtd="15" value="0"  class="sinborde" onkeyup="validarnum(this,1)" />
    </div></td>
    <th><div align="left">Empresa:</div></th>
    <td class="campo" ><div align="right">
      <input type="text" name="cliempresa" id="cliempresa" size="20" onClick=this.value="" maxlengtd="100" class="sinborde" />
    </div></td>
  </tr>
  <tr>
    <th> <div align="left">Correo:</div></th>
    <td class="campo" ><input type="text" name="clicorreo" id="clicorreo" onClick=this.value="" size="20" class="sinborde" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td widtd="83">&nbsp;</td>
    <td widtd="90">&nbsp;</td>
    <td widtd="209" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="6"> <input type="submit" name="enviar" id="enviar" value="Guardar" onclick="nuevocliente(); return false"></th>
  </tr>
</table>
</form>
</body>
</html>
