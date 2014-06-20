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

@ $codigol=$_GET['codigol'];
$origen=getenv("HTTP_REFERER"); 
$query = "SELECT * FROM tbl_inventario where cod_producto='$codigol';";
$result = $obj->consultar($query);
$reg = mysql_fetch_assoc($result);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Modificar Titulos</title>
<script type="text/javascript" src="js/titulos.js"></script>

<script language="javascript">
function validarnum(obj,valores){
	if(valores==1)
		cadena="0123456789."
	else if(valores==2)
	    	cadena=" abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.,"
	var val2=obj.value.length
	for(i=0;(i<obj.value.length)&&(val2==obj.value.length);i++){
		var car=obj.value.substr(i,1)
		val=0
		for(j=0;(j<cadena.length)&&(val==0);j++)
			if(car==cadena.substr(j,1)) val=1
		if(val==0)
			val2=i;
	}
	obj.value=obj.value.substr(0,val2)
}

</script>

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
<form id="ftitulos" name="ftitulos" action="">
<br>
<table width="651" align="center" class="tabla" id="table1">
  <tr>
    <th colspan="7" bgcolor="#990000" style="-moz-border-radius:6px;"><span class="style1">Modificar Libro </span></th>
  </tr>
  <tr>
    <td width="90"><div align="left"><strong>Proveedor:</strong></div></td>
    <td colspan="6" class="campo"><div align="left">
      <?
	  echo "<select name='proveedor' id='proveedor' class='sinborde'>";	 
	  echo '<option selected="selected" value='.$reg["proveedor"].' >'.$obj->setproveedor($reg["proveedor"]).'</option>';
 
	  $resul=$obj->consultar("select * from tbl_proveedor order by id ");

	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id'].">".$row['proveedor']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?>
      <input name="proveedores" type="button" class="boton" id="proveedores" onclick="abrirventana('addproveedor.php','proveedor',300,600)" value="[+]" />
    </div></td>
    </tr>
  <tr>
    <th> <div align="left">C&oacute;digo: </div></th>
    <td width="129" class="campo"><div align="left">
      <input type="text" name="codigo" id="codigo" size="20" maxlengtd="15" value="<? echo $reg["cod_producto"];?>" class="sinborde" readonly="true"/>
    </div></td>
    <td width="98">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <th ><div align="left"><strong>Titulo: *</strong></div></th>
    <td colspan="3" class="campo" ><div align="left">
      <input type="text" name="titulo" id="titulo" size="50" maxlengtd="100" class="sinborde"  value="<? echo $reg["descripcion"];?>"/>
    </div></td>
    <td width="64" >&nbsp;</td>
    <th width="73">&nbsp;</th>
    <td width="198">&nbsp;</td>
  </tr>
  <tr>
    <th ><div align="left">Autor: * </div></th>
    <td colspan="3" class="campo" ><input type="text" name="autor" id="autor" size="50" maxlengtd="100" class="sinborde" value="<? echo $reg["autor"];?>"/></td>
    <td>&nbsp;</td>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th ><div align="left">Editorial:</div></th>
    <td colspan="6" class="campo" ><div align="left">
      <?

	  echo "<select name='editorial' id='editorial' class='sinborde'>";
	  	  
	  echo '<option selected="selected" value='.$reg["editorial"].' >'.$obj->geteditorial($reg["editorial"]).'</option>';
	  
	  $resul=$obj->consultar("select * from tbl_editorial order by editorial ");
	  	  	  
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
	  echo "<select name='coleccion' id='coleccion' class='sinborde'>";	  
	  echo '<option selected="selected" value='.$reg["coleccion"].' >'.$obj->getcoleccion($reg["coleccion"]).'</option>';
	  
	  $resul=$obj->consultar("select * from tbl_coleccion order by col_descripcion ");
	  
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
	  echo "<select name='tema' id='tema' class='sinborde'>";	  
  	  echo '<option selected="selected" value='.$reg["tema"].' >'.$obj->gettema($reg["tema"]).'</option>';
	  
	  $resul=$obj->consultar("select * from tbl_tema order by tema ");
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
	  echo "<select name='subtema' id='subtema' class='sinborde'>";	  
  	  echo '<option selected="selected" value='.$reg["subtema"].' >'.$obj->getsubtema($reg["subtema"]).'</option>';
	  
	  $resul=$obj->consultar("select * from tbl_subtema order by subtema ");
	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id_subtema'].">".$row['subtema']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?>
      <input name="proveedores5" type="button" class="boton" id="proveedores5" onclick="abrirventana('addsubtema.php','subtema',200,600)" value="[+]" />
    </div></td>
    <td><div align="left"><strong>Existencia: </strong></div></td>
    <td class="campo"><div align="right">
      <input type="text" name="existencia" id="existencia" size="20" maxlengtd="15" class="montos" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)"  value="<? echo $obj->getexistencia($reg["cod_producto"],$_SESSION['usuario_sucursal']);?>"  readonly="true"/>
    </div></td>
  </tr>
  <tr>
    <th ><div align="left"><strong>ISBN</strong>: </div></th>
    <td colspan="4" class="campo" ><input type="text" name="isbn" id="isbn" size="50" maxlengtd="100" class="sinborde" value="<? echo $reg["isbn"];?>"/></td>
    <td><div align="left"><strong>Costo:</strong></div></td>
    <td class="campo"><div align="right">
      <input type="text" name="costo" id="costo" size="20" maxlengtd="100" class="montos" value="<? echo $reg["costo"];?>" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)"/>
    </div></td>
  </tr>
  <tr>
    <th ><div align="left"><strong>COD. Barra </strong>: </div></th>
    <td colspan="4" class="campo" ><input type="text" name="codbarra" id="codbarra" size="50" maxlengtd="100" class="sinborde" value="<? echo $reg["cod_barra"];?>"/></td>
    <td><div align="left"><strong>PVP:</strong></div></td>
    <td class="campo"><div align="right">
      <input type="text" name="pvp" id="pvp" size="20" maxlengtd="100" class="montos" value="<? echo $reg["precio"];?>" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)"/>
    </div></td>
  </tr>
  
<TR>
<td><div align="left"><strong>Dep. Legal:</strong></div></td>
    <td colspan="4" class="campo" align="right"><input type="text" name="deplegal" id="deplegal" size="50" maxlengtd="100" class="sinborde" value="<? echo $reg["nd_legal"];?>"/></td>
<td><div align="left"><strong>Presentaci&oacute;n:</strong>*</div></td>
    <td class="campo" align="right">


<?
	  echo "<select name='formato' id='formato' class='sinborde'>";	  
  	  echo '<option selected="selected" value='.$reg["formato"].' >'.$obj->getformato($reg["formato"]).'</option>';
	  
	  $resul=$obj->consultar("select * from tbl_formato order by id ");
	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id'].">".$row['descripcion']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?>

</td>

</TR>  


<TR>

<td ><div align="left"><strong>Tomo:</strong></div></td>
    <td colspan="4" class="campo" align="left">
<div align="left">
	  <?
	  echo "<select name='tomo' id='tomo' class='sinborde'>";	  
  	  echo '<option selected="selected" value='.$reg["tomo"].' >'.$obj->gettomo($reg["tomo"]).'</option>';
	  
	  $resul=$obj->consultar("select * from tbl_tomo order by tomo_id; ");
	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['tomo_id'].">".$row['descripcion']."</option>";
	  }	
	  echo "</select>";	  
	  
	  ?>

</div >
</td>
<td><div align="left"><strong>Volumen:</strong></div></td>
    <td class="campo" align="right">

	  <?
	  echo "<select name='volumen' id='volumen' class='sinborde'>";	  
  	  echo '<option selected="selected" value='.$reg["volumen"].' >'.$obj->getvolumen($reg["volumen"]).'</option>';
	  
	  $resul=$obj->consultar("select * from tbl_volumen order by volumen_id; ");
	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['volumen_id'].">".$row['descripcion']."</option>";
	  }	
	  echo "</select>";	  
	  
	  ?>


</td>

</TR>  



<tr>
    <td widtd="83"><div align="left"><strong># Edicion:</strong></div></td>
    <td colspan="4" widtd="90"><?
	  echo "<select name='nedicion' id='nedicion' class='sinborde'>";	  
  	  echo '<option selected="selected" value='.$reg["n_edicion"].' >'.$obj->getedicion($reg["n_edicion"]).'</option>';
	  
	  $resul=$obj->consultar("select * from tbl_edicion order by edicion_id; ");
	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['edicion_id'].">".$row['descripcion']."</option>";
	  }	
	  echo "</select>";	  
	  
	  ?>
</td>
    <td widtd="209"><div align="left"><strong>(+) Libros :</strong></div></td>
    <td class="campo" widtd="209"><div align="right">
      <input type="text" name="masl" id="masl" size="20" maxlengtd="15" class="montos" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)"  value="0"/>
    </div></td>
  </tr>
  <tr>
     <td widtd="83"><div align="left"><strong># Colecci&oacute;n:</strong></div></td>
    <td colspan="4" widtd="90"><input type="text" name="ncoleccion" id="ncoleccion" size="10" maxlengtd="15" class="montos" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)"  value="<? echo $obj->getncoleccion_remoto($reg["cod_producto"]);?>" />
 
</td>
    <td widtd="209"><div align="left"><strong>(-) &nbsp;Libros :</strong></div></td>
    <td class="campo" widtd="209"><div align="right">
      <input type="text" name="menosl" id="menosl" size="20" maxlengtd="15" class="montos" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)"  value="0" />
    </div></td>
  </tr>
  <tr>
    <td widtd="83">&nbsp;</td>
    <td colspan="4" widtd="90">&nbsp;</td>
    <td widtd="209"><div align="left"><strong>(%) Desc.:</strong></div></td>
    <td class="campo" widtd="209"><div align="right">
      <input type="text" name="descuent" id="descuent" size="10" maxlengtd="15" class="montos" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)"  value="<? echo $obj->getdescuento($reg["cod_producto"],$_SESSION['usuario_sucursal']);?>" />
      <input name="aplicar" type="button" class="boton" id="aplicar" onclick="aplicardesc()" value="Aplicar" />
    </div></td>
  </tr>
  
  
<tr>
    <th ><div align="left"><strong>Sucursal: </strong></div></th>
    <td colspan="4" ><span class="campo">
      <?
	  echo "<select name='sucursal' id='sucursal' class='sinborde'>";	 
	   
  	  echo '<option selected="selected" value='.$_SESSION['usuario_sucursal'].' >'.$obj->setsucursal($_SESSION['usuario_sucursal']).'</option>'; 

	  $resul=$obj->consultar("select * from tbl_sucursal order by sucursal ");

	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id_sucursal'].">".$row['sucursal']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?></span></td>
    <td><div align="left"><strong>Condici&oacute;n:</strong>*</div></td>
    <td class="campo" align="right"><?
	  echo "<select name='condicion' id='condicion' class='sinborde'>";	  
  	    
	  $resul=$obj->consultar("select * from tbl_condicion order by id_condicion ");
  	  echo "<option value='3' selected='selected'>Consignacion DN</option>";
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id_condicion'].">".$row['cond_descripcion']."</option>";
	  }

	  echo "</select>";	  
	  
	  ?></td>

  </tr>

  <tr>
    <th colspan="9"> <input name="enviar" type="button" class="boton" id="enviar" onclick="modificartitulo()" value="Modificar" />
      <input name="salir" type="button" class="boton" id="salir" onclick="javascript:window.close(this)" value="Cancelar" /></th>
  </tr>
</table>
</form>
</body>
</html>
<? }?>
