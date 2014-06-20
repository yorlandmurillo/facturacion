<? 
require("admin/session.php");
$obj=new manejadordb;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Historico de Mensajes</title>
</head>
<style type="text/css">
<!--
.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix;-moz-border-radius: 10px;}

.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo2 {
	color: #990000;
	font-weight: bold;
}
.mensajes{
background-color:#CCCCCC;
color:#990000;
border:solid 1px;
}
-->
</style>

<body>
<table width="558" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px;border-color:#990000;display:block;-moz-border-radius: 10px;">
  <tr>
    <td width="554" colspan="15" align="center" bgcolor="#990000"><span class="Estilo1">HISTORICO DE MENSAJES</span></td>
  </tr>
  <tr>
    <td colspan="15" align="right"><table width="550" border="0" cellpadding="0" cellspacing="0" align="center"  id="t_chat" name="t_chat">

      <tbody id="mensajes">
	<?
	$sucursal=$_GET['sucursal'];
	$usuario=$_GET['usuario'];
	$query = "SELECT * FROM tbl_chat where sucursal=$sucursal ORDER BY iduser ASC";
	$lista = $obj->consultar($query);
	$i=1;
	for($i=0;$row=mysql_fetch_assoc($lista);$i++){

	$usact=$row['usuario'];
	echo '<tr>
        <td width="33"><span class="Estilo2">Usuario:</span></td>
        <td colspan="6">'.$usact.'</td>
        </tr><tr>
        <td colspan="7" align="center" bgcolor="#990000"><span class="Estilo1">Mensajes</span></td>
        </tr>';
		
	
		while($row=mysql_fetch_assoc($lista)){

		if($usact!=$row['usuario']){
		$usact=$row['usuario'];
	echo '<tr>
        <td width="33"><span class="Estilo2">Usuario:</span></td>
        <td colspan="6">'.$usact.'</td>
        </tr><tr>
        <td colspan="7" align="center" bgcolor="#990000"><span class="Estilo1">Mensajes</span></td>
        </tr>';
		
		}

		echo '
	    <tr>
        <td colspan="7" class="mensajes"><font size="2">'.$row['fecha'].': </font>'.utf8_decode($row['mensaje']).'</td>
        </tr>';
		}
		


	}

	?>

      
	  </tbody>
    </table>
    <input name="salir" type="button" class="boton" id="salir" onclick="javascript:window.close('this')" value="Salir" /></td>
  </tr>
</table>


</body>
</html>