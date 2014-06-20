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
<title>Registro de Libros</title>
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
<form id="titulos" name="titulos" action="">
<br>
<table width="596" align="center" class="tabla" id="table1">
  <tr>
    <th colspan="7" bgcolor="#990000" style="-moz-border-radius:6px;"><span class="style1">Datos del Libro </span></th>
  </tr>
  <tr>
    <td width="143"><div align="left"><strong>Proveedor:</strong></div></td>
    <td colspan="6" class="campo"><div align="left">
      <?
	  
	  $resul=$obj->consultar("select * from tbl_proveedor order by id ");
	  
	  echo "<select name='proveedor' id='proveedor' class='sinborde'>";
	  echo "<option value='0' selected='selected'>[Seleccione]</option>";
	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id'].">".$row['proveedor']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?>
      <input name="proveedores" type="button" class="boton" id="proveedores" onclick="abrirventana('addproveedor.php','proveedor',300,600)" value="[+]" />
    </div></td>
    </tr>
  <tr>
    <th> <div align="left">C&oacute;digo: *</div></th>
    <td width="88" class="campo"><div align="left">
      <input type="text" name="codigo" id="codigo" size="20" maxlengtd="15" value="" class="sinborde" />
    </div></td>
    <td width="75">&nbsp;</td>
    <td width="62" >&nbsp;</td>
    <td width="66" >&nbsp;</td>
    <th colspan="2" >&nbsp;</th>
  </tr>
  <tr>
    <th ><div align="left"><strong>Titulo: *</strong></div></th>
    <td colspan="3" class="campo" ><div align="left">
      <input type="text" name="titulo" id="titulo" size="50" maxlengtd="100" class="sinborde" />
    </div></td>
    <td >&nbsp;</td>
    <th width="81">&nbsp;</th>
    <td width="129">&nbsp;</td>
  </tr>
  <tr>
    <th ><div align="left">Autor: * </div></th>
    <td colspan="3" class="campo" ><input type="text" name="autor" id="autor" size="50" maxlengtd="100" class="sinborde" /></td>
    <td>&nbsp;</td>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th ><div align="left">Editorial:</div></th>
    <td colspan="6" class="campo" ><div align="left">
      <?
	  
	  $resul=$obj->consultar("select * from tbl_editorial order by editorial ");
	  
	  echo "<select name='editorial' id='editorial' class='sinborde'>";
	  echo "<option value='0' selected='selected'>[Seleccione]</option>";
	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id_editorial'].">".$row['editorial']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?>
      <input name="proveedores2" type="button" class="boton" id="proveedores2" onclick="abrirventana('addeditorial.php','editorial',200,600)" value="[+]" />
    </div></td>
    </tr>
  <tr>
    <th ><div align="left">Colecci&oacute;n: </div></th>
    <td colspan="6" class="campo" ><div align="left">
      <?
	  
	  $resul=$obj->consultar("select * from tbl_coleccion order by col_descripcion ");
	  
	  echo "<select name='coleccion' id='coleccion' class='sinborde'>";
	  echo "<option value='0' selected='selected'>[Seleccione]</option>";
	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id_coleccion'].">".$row['col_descripcion']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?>
      <input name="proveedores3" type="button" class="boton" id="proveedores3" onclick="abrirventana('addcoleccion.php','coleccion',200,600)" value="[+]" />
    </div></td>
    </tr>
  <tr>
    <th ><div align="left"><strong>Tema</strong>: </div></th>
    <td colspan="6" class="campo" ><div align="left">
      <?
	  
	  $resul=$obj->consultar("select * from tbl_tema order by tema ");
	  
	  echo "<select name='tema' id='tema' class='sinborde'>";
	  echo "<option value='0' selected='selected'>[Seleccione]</option>";
	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id_tema'].">".$row['tema']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?>
      <input name="proveedores4" type="button" class="boton" id="proveedores4" onclick="abrirventana('addtema.php','tema',200,600)" value="[+]" />
    </div></td>
    </tr>
  <tr>
    <th ><div align="left"><strong>Sub Tema</strong>: </div></th>
    <td colspan="4" class="campo" ><div align="left">
      <?
	  
	  $resul=$obj->consultar("select * from tbl_subtema order by subtema ");
	  
	  echo "<select name='subtema' id='subtema' class='sinborde'>";
	  echo "<option value='0' selected='selected'>[Seleccione]</option>";
	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id_subtema'].">".$row['subtema']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?>
      <input name="proveedores5" type="button" class="boton" id="proveedores5" onclick="abrirventana('addsubtema.php','subtema',200,600)" value="[+]" />
    </div></td>
    <td><div align="left"><strong>Existencia: </strong></div></td>
    <td class="campo"><div align="right">
      <input type="text" name="existencia" id="existencia" size="20" maxlengtd="15" value="0" class="montos" onkeyup="validarnum(this,1)" />
    </div></td>
  </tr>
  <tr>
    <th ><div align="left"><strong>ISBN</strong>: </div></th>
    <td colspan="4" class="campo" ><input type="text" name="isbn" id="isbn" size="50" maxlengtd="100" class="sinborde" /></td>
    <td><div align="left"><strong>Costo:</strong></div></td>
    <td class="campo"><div align="right">
      <input type="text" name="costo" id="costo" size="20" maxlengtd="100" class="montos" value="0" />
    </div></td>
  </tr>
  <tr>
    <th ><div align="left"><strong>COD. Barra </strong>: </div></th>
    <td colspan="4" class="campo" ><input type="text" name="codbarra" id="codbarra" size="50" maxlengtd="100" class="sinborde" /></td>
    <td><div align="left"><strong>PVP:</strong></div></td>
    <td class="campo"><div align="right">
      <input type="text" name="pvp" id="pvp" size="20" maxlengtd="100" class="montos" value="0" />
    </div></td>
  </tr>
  <tr>
    <th >&nbsp;</th>
    <td colspan="4" >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td widtd="83">&nbsp;</td>
    <td colspan="4" widtd="90">&nbsp;</td>
    <td widtd="209" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="9"> <input name="enviar" type="button" class="boton" id="enviar" onclick="agregartitulo()" value="Enviar" />
        <input name="salir" type="button" class="boton" id="salir" onclick="javascript:window.close(this)" value="Salir" /></th>
  </tr>
</table>
</form>
</body>
</html>
<? }?>
