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
<script type="text/javascript" src="js/titulos.js"></script>
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
<form id="fcoleccion" name="fcoleccion" action="">
<br>
<table width="491" align="center" class="tabla" id="table1">
  <tr>
    <th colspan="5" bgcolor="#990000" style="-moz-border-radius:6px;"><span class="style1">Datos de la Colecci&oacute;n </span></th>
  </tr>
  
  <tr>
    <th width="143" ><div align="left">Colecci&oacute;n: </div></th>
    <td colspan="4" class="campo" ><div align="left">
      <input type="text" name="coleccion" id="coleccion" size="90" maxlengtd="100" class="sinborde" />
    </div></td>
    </tr>
  
  

  
  <tr>
    <td widtd="83">&nbsp;</td>
    <td width="66" colspan="2" widtd="90">&nbsp;</td>
    <td width="210" colspan="2" widtd="209">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="7"> <input name="enviar" type="button" class="boton" id="enviar" onclick="agregarcoleccion()" value="Enviar" />
        <input name="salir" type="button" class="boton" id="salir" onclick="javascript:window.close(this)" value="Salir" /></th>
  </tr>
</table>
</form>
</body>
</html>
<? }?>