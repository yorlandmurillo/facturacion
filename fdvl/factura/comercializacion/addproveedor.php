<?
require("../admin/session.php"); // incluir motor de autentificación.
$nivel_acceso=1;// definir nivel de acceso para esta página.

if ($_SESSION['usuario_nivel']<$nivel_acceso && $_SESSION['usuario_nivel']!=2){

echo '<div align="center"><h1>Usted no tiene pérmiso para acceder a esta página</h1></div>';
echo '<div align="center"><input type="button" value="Salir" onClick="Javascript:window.close(this)" style="border:double;background-color:#990000;text-align:center;color:#FFFFFF;" ></div>';
/*echo '<script language="javascript">window.close(this)</script>';*/
//Header ("Location: ../admin/login.php?error_login=5");
//exit;
}else{
$obj=new manejadordb;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registro de Proveedores</title>
<script type="text/javascript" src="js/proveedor.js"></script>
</head>

<style>
.tabla{
-moz-border-radius: 10px;
background-color : #F5F5F5;
border : 2px solid #990000;
font-family : Arial, Verdana, Helvetica, sans-serif;
font-size : 12px;
padding-left : 0px;
padding-right : 0px;
border-color:#990000;
}
.campo{
    border:double;
	border-color:#CCCCCC;
	background-color:#FFFFFF;

}
.sinborde{
    border:none;
	font-size:9px;
	
}
.montos{
    border:none;
	font-size:9px;
	text-align:right;
}

.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix;
-moz-border-radius:6px;
}
input, select,textarea    { border: 1px solid red; }
input.error {padding-right: 16px; border: 1px solid red; background-image: url(imagenes/warning_obj.gif); background-position: right; background-repeat: no-repeat;}
input:focus {border: 1px solid red; background-color:#EFEFEF;}
td.activetab {
    background-color: silver;
}

.style1 {color: #FFFFFF}
</style>

<body>
<div align="center" id="resultado"></div>
<form id="proveedor" name="proveedor" action="">
<br>
<table width="491" align="center" class="tabla" id="table1">
  <tr>
    <th colspan="5" bgcolor="#990000" style="-moz-border-radius:6px;"><span class="style1">Datos del Proveedor </span></th>
  </tr>
  <tr>
    <td width="143"><div align="left"><strong>Proveedor:</strong></div></td>
    <td class="campo"><input type="text" name="nombre" id="nombre" size="50" maxlengtd="100" class="sinborde" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td widtd="83"><div align="left"><strong>RIF</strong>: </div></td>
    <td class="campo" widtd="90"><input type="text" name="rif" id="rif" size="50" maxlengtd="100" class="sinborde" /></td>
    <td widtd="90">&nbsp;</td>
    <td colspan="2" widtd="209">&nbsp;</td>
    </tr>
  <tr>
    <th> <div align="left">Contacto:</div></th>
    <td class="campo"><div align="left">
      <input type="text" name="contacto" id="contacto" size="50" maxlengtd="15" value="" class="sinborde"/>
    </div></td>
    <td width="66" >&nbsp;</td>
    <th >&nbsp;</th>
    <th >&nbsp;</th>
  </tr>
  <tr>
    <th ><div align="left"><strong>Telefono: </strong></div></th>
    <td class="campo" ><div align="left">
      <input type="text" name="telefono" id="telefono" size="50" maxlengtd="100" class="sinborde" />
    </div></td>
    <td >&nbsp;</td>
    <th width="81">&nbsp;</th>
    <td width="129">&nbsp;</td>
  </tr>
  <tr>
    <th ><div align="left">Fax : </div></th>
    <td class="campo" ><input type="text" name="fax" id="fax" size="50" maxlengtd="100" class="sinborde" /></td>
    <td>&nbsp;</td>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th ><div align="left">Celular : </div></th>
    <td class="campo" ><div align="left">
      <input type="text" name="cel" id="cel" size="50" maxlengtd="100" class="sinborde" />
    </div></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th ><div align="left">Direcci&oacute;n: </div></th>
    <td colspan="4" class="campo" ><div align="left">
      <input type="text" name="direccion" id="direccion" size="90" maxlengtd="100" class="sinborde" />
    </div></td>
    </tr>
  <tr>
    <th ><div align="left"><strong>Tipo</strong>: </div></th>
    <td colspan="4" class="campo" ><div align="left">
      <?
	  
	  $resul=$obj->consultar("select * from tbl_tipoproveedor order by id ");
	  
	  echo "<select name='tipo' id='tipo' class='sinborde'>";
	  echo "<option value='0' selected='selected'>[Seleccione]</option>";
	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id'].">".$row['tipoproveedor']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?>
    </div></td>
    </tr>
  <tr>
    <th colspan="7"> <input name="enviar" type="button" class="boton" id="enviar" onclick="agregarproveedor()" value="Enviar" />
        <input name="salir" type="button" class="boton" id="salir" onclick="javascript:window.close(this)" value="Salir" /></th>
  </tr>
</table>
</form>
</body>
</html>
<? }?>