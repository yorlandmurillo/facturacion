<? 
require("session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.
if ($_SESSION['usuario_nivel'] < $nivel_acceso){
Header ("Location: PATH_TO_ERRO_PAG?error_login=5");
exit;
}else{
?>
<?
//Configuracion de la conexion a base de datos
//include_once("manejadordb.php");
//creamos el objeto $objempleados de la clase cEmpleado
$obj=new manejadordb;
//consulta todos los empleados
$factura=$_SESSION['factura'];
$suc=$_SESSION['usuario_sucursal'];
$userid=$_SESSION['usuario_id'];
$lista= $obj->consultar("select * from tbl_usuario where id_usuario=$userid and sucursal=$suc ");
//muestra los datos consultados
//haremos uso de tabla para tabular los resultados
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd" >
<html>
<head>
<title>Cambio de Clave</title>
<style type="text/css">
<!--
.style1 {
	font-size: 24px;
	font-weight: bold;
	color: #990000;
}
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}

.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}

th{
    background-color: silver;
}
input:focus {border: 1px solid red; background-color:#EFEFEF;}

-->
</style>
<script type="text/javascript"  language="javascript"  src="../funciones/js/sha1.js"></script>
<script type="text/javascript"  language="javascript"  src="../funciones/js/ajax.js"></script>

</head>
<body>

<table width="213" height="0" border="0" align="center" cellpadding="0" cellspacing="0" style="border:double;border-color:#990000;"> 
<form name="usuarios" id="usuarios" action="">

<tr>
<td colspan="2"><div align="center" class="style1" style="border:double;">Cambio de Clave 
</div></td>
</tr>

<tr>
<td width="92" bgcolor="#990000"><span class="style2">Usuario:</span></td>
<th width="177"><div align="right"><strong>
  <?= $_SESSION['usuario_login']; ?>
</strong></div>
<input type="hidden" name="uslogin" id="uslogin" value="<?= $_SESSION['usuario_login']; ?>">
</th>
</tr>
<tr>
  <td bgcolor="#990000"><span class="style2"> Contrase&ntilde;a:</span></td>
  <th align="right"><input type="password" name="pwd" id="pwd" size="20"></th>
</tr>
<tr>
  <td bgcolor="#990000"><span class="style2">Confirmar:</span></td>
  <th align="right"><input type="password" name="pwd2" id="pwd2" size="20"></th>
</tr>

<tr>
  <td height="28" colspan="2"><div id="respuesta" align="center" ></div></td>
  </tr>
<tr>
  <td height="19" colspan="2" align="center"><input name="cambiar" type="button" class="boton" value="Cambiar" onClick="cambiarclave()">
    <input name="cancelar" type="button" class="boton" value="Cancelar" onClick="javascript:window.close(this)"></td>
</tr>
</form>
</table>

</body>
</html>
<? }?>