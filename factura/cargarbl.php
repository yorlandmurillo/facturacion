<?
require("admin/session.php");// // incluir motor de autentificación.
include_once("funciones.in");
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.
if ($_SESSION['usuario_nivel'] < $nivel_acceso){
Header ("Location: $pag_error?error_login=5");
exit;
}
@ $cedula = $_GET['cedula']; 
@ $factura = $_GET['fact'];
@ $sucursal = $_SESSION['usuario_sucursal'];
@ $monto = $_GET['monto'];
$vend=$_SESSION['usuario_id'];
$obj=new manejadordb;
//consulta todos los empleados

$afiliado= $obj->consultar("select * from tbl_sucursal where id_sucursal=$sucursal ");


$lista= $obj->consultar("select * from tbl_itemfactura where cod_factura='$factura' and sucursal=$sucursal and vendedor=$vend and estatus_cancelacion=0");

$codigos="";
while($row = mysql_fetch_assoc($lista)){
$codigos.=$row['isbn'];
$codigos.="\n";
}

$tarjetabl= $obj->gettarjetabl_remoto($cedula);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Ejemplo con método común</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript"  language="javascript"  src="js/funciones.js"></script>

<script type="text/javascript"><!--//--><![CDATA[//><!--

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
  
function openTargetBlank(e){
   
   var className = 'external';
   var classcerrar = 'cerrar';
   
   if (!e) var e = window.event;
   var clickedObj = e.target ? e.target : e.srcElement;
   
   if(clickedObj.nodeName == 'A' )
    {
      r=new RegExp("(^| )"+className+"($| )");
      if(r.test(clickedObj.className)){
         window.open(clickedObj.href,100,100,resizable=0);
         return false;
   
      }
    }

   if (!e) var e = window.event;
   var clickedObj = e.target ? e.target : e.srcElement;
   
   if(clickedObj.nodeName == 'A' )
    {
      r=new RegExp("(^| )"+classcerrar+"($| )");
      if(r.test(clickedObj.classcerrar)){
         window.close(this);
         return false;
   
      }
    }

}
   
document.onclick = openTargetBlank;
   
//--><!]]></script>
</head>
<style>
.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}

.celda{
background-color:#990000;
color:#FFFFFF;
font-size: 14pt;
}
.campo{
text-align:right;
background-color:#FFFFFF;
color:#990000;
}


</style>   
<body>
   
     
<p>&nbsp;</p>
<form name="bonolibro" id="bonolibro" method="post" action="">
<table width="304" height="107" border="0" align="center" cellpadding="0" cellspacing="0" style="border-color:#990000;border:double;">
  <tr>
    <td height="23" colspan="2"><div align="center" class="boton"><strong>Cargar Venta Bono Libro
    </strong></div></td>
  </tr>

  <tr>
    <td class="celda">Factura:</td>
    <td class="celda"><?= $factura;?></td>
  </tr>
  <tr>
    <td class="celda">Sucursal:</td>
    <td class="celda">
	<div align="right">
      <input name="codsuc" type="hidden" class="campo" id="suc" style="text-align:right;" value="<?= $obj->setcodsuc($sucursal);?>" readonly="true"/>
	  <input name="clavesuc" type="hidden" class="campo" id="suc" style="text-align:right;" value="<?= $obj->setclavesuc($sucursal);?>" readonly="true"/>
	  <input name="suc" type="text" class="campo" id="suc" style="text-align:right;" value="<?= $obj->setsucursal($sucursal);?>" readonly="true"/>
	</div>	</td>
    </tr>
  <tr>
    <td class="celda">C&eacute;dula:</td>
    <td class="celda"><div align="right">
	  <input name="cedula" type="text" class="campo" id="cedula" style="text-align:right;" value="<?= $cedula;?>" readonly="true"/>
	</div></td>
  </tr>
  <tr>
    <td width="64" class="celda">Tarjeta:</td>
    <td width="77" class="celda">
	<div align="right">
	  <input name="tarjetabl" type="text" class="campo" id="tarjetabl" style="text-align:right;" value="<?= $tarjetabl;?>" readonly="true"/>
	</div></td>
	</tr>
  
  <tr>
    <td class="celda">ISBN(S):</td>
    <td class="celda"><div align="right">
      <textarea name="isbn" cols="15" rows="1" class="campo" readonly="true"><?= trim($codigos,"\n");?></textarea>
	</div></td>
    </tr>
  <tr>
    <td class="celda">Monto:</td>
    <td class="celda"><div align="right">
      <input name="monto1" type="text"  class="campo" id="monto1" value="" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)">
    </div></td>
    </tr>
  
  <tr>
    <td colspan="2" align="center">
        <input name="aceptar" type="button" class="boton" value="Aceptar" onclick="cargarbl()">
        <input name="cancelar" type="button" class="boton" value="Cancelar" onclick="javascript:window.close(this)">
     </td>
    </tr>
</table>
</form>
<p>&nbsp;</p>
<div align="center"><iframe id="bl" frameborder="0" scrolling="yes" width="800" height="400"></iframe></div> 
</body>
</html>