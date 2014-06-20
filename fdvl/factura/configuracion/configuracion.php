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
$query = "SELECT * FROM tbl_preferencias;";
$result = $obj->consultar($query);
$reg = mysql_fetch_assoc($result);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Modificar Titulos</title>
<script type="text/javascript" src="js/configuracion.js"></script>

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
<form id="configuracion" name="configuracion" action="">
<br>
<table width="457" align="center" class="tabla" id="table1">
  <tr>
    <th colspan="2" bgcolor="#990000" style="-moz-border-radius:6px;"><span class="style1">Configuraci&oacute;n del Sistema  </span></th>
  </tr>
  <tr>
    <td width="187"><div align="left"><strong>Sucursal:</strong></div></td>
    <td width="256" class="campo">
      
        <div align="left">
          <?
	  echo "<select name='sucursal_id' id='sucursal_id' class='sinborde'>";	 
	   
  	  echo '<option selected="selected" value='.$_SESSION['usuario_sucursal'].' >'.$obj->setsucursal($_SESSION['usuario_sucursal']).'</option>'; 

	  $resul=$obj->consultar("select * from tbl_sucursal where  id_sucursal>0 ");

	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id_sucursal'].">".$row['sucursal']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?>
      </div></td>
    </tr>
  <tr>
    <th> <div align="left">IP Servidor Remoto : </div></th>
    <td class="campo">
      
        <div align="left">
          <input type="text" name="ipservidor" id="ipservidor" size="15" maxlengtd="15" value="<? echo $reg["ipservidor"];?>" class="sinborde"  onchange="javascript:validateIp('ipservidor')" />
      </div></td>
    </tr>
  <tr>
    <th ><div align="left"><strong>IP Servidor Local : *</strong></div></th>
    <td class="campo" >
      
        <div align="left">
          <input type="text" name="iplocal" id="iplocal" size="15" maxlengtd="15" class="sinborde"  value="<? echo $reg["iplocal"];?>"/>
      </div></td>
    </tr>
  
  <tr>
    <th ><div align="left">Puerto de Impresi&oacute;n:</div></th>
    <td class="campo" >
      
        <div align="left">
          <?
		
	  echo "<select name='ptoimpresora' id='ptoimpresora' class='sinborde'>";
	  
	  
	  if(getpreferencia($_SESSION['usuario_sucursal'],"ptoimpresora")=="/dev/lp0"){
	  $puerto ="Paralelo";
	  }elseif(getpreferencia($_SESSION['usuario_sucursal'],"ptoimpresora")=="/dev/usb/lp0"){
	  $puerto ="USB";
	  }
	  	  
	  echo '<option selected="selected" value='.getpreferencia($_SESSION['usuario_sucursal'],"ptoimpresora").' >'.$puerto.'</option>';
	  
	  $resul=$obj->consultar("select * from tbl_portprint;");
	  	  	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['puerto'].">".$row['dispositivo']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?>
      </div></td>
    </tr>
  <tr>
    <th ><div align="left">Tiempo de Sincronizaci&oacute;n: </div></th>
    <td class="campo" >
      
        <div align="left">
          <?
	  echo "<select name='tiemposincro' id='tiemposincro' class='sinborde'>";	  
	  echo '<option selected="selected" value='.getpreferencia($_SESSION['usuario_sucursal'],"tiemposincro").' >'.getpreferencia($_SESSION['usuario_sucursal'],"tiemposincro")/(60000).' Minutos</option>';
	  
	  $resul=$obj->consultar("select * from tbl_minutos order by minutos;");

	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['milisegundos'].">".$row['minutos']." Minutos</option>";
	  }
	  echo "</select>";	  
	  
	  ?>
      </div></td>
    </tr>
  
  <tr>
    <th ><div align="left"><strong>Libros por Factura Sistema </strong>: </div></th>
    <td class="campo" >
      <div align="left">
        <input type="text" name="libros_pf" id="libros_pf" size="10" maxlengtd="10" class="sinborde" value="<? echo $reg["libros_pf"];?>"/>
        &quot;0&quot; Ilimitado</div></td>
    </tr>
  <tr>
    <th ><div align="left"><strong>Libros por Factura Manual </strong>: </div></th>
    <td class="campo" >
      <div align="left">
        <input type="text" name="libros_pfm" id="libros_pfm" size="10" maxlengtd="10" class="sinborde" value="<? echo $reg["libros_pfm"];?>"/>
       &quot;0&quot; Ilimitado </div></td>
    </tr>
  
  

  
  <tr>
    <th ><div align="left"><strong>Facturas a Imprimir </strong>: </div></th>
    <td class="campo" ><div align="left">
        <input type="text" name="cant_facturas" id="cant_facturas" size="10" maxlengtd="10" class="sinborde" value="<? echo $reg["cant_facturas"];?>"/>
        1 =&gt; Original , 2 =&gt; Original y Copia </div></td>
    </tr>
  <tr>
    <th ><div align="left"><strong>Version del Sistema </strong>: </div></th>
    <td class="campo" ><div align="left">
        <input type="text" name="version" id="version" size="10" maxlengtd="10" class="sinborde" value="<? echo $reg["version"];?>"/>
    </div></td>
    </tr>
  
  
  <tr>
    <th colspan="4"> <input name="agregar" type="button" class="boton" id="agregar" onclick="agregarconfiguracion()" value="Agregar" />
      <input name="enviar" type="button" class="boton" id="enviar" onclick="modificarconfiguracion()" value="Modificar" />
      <input name="salir" type="button" class="boton" id="salir" onclick="javascript:window.close(this)" value="Cancelar" /></th>
  </tr>
</table>
</form>
</body>
</html>
<? }?>
