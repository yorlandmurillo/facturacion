<? 
require("../admin/session.php"); // incluir motor de autentificación.

$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=3;// definir nivel de acceso para esta página.

if ($_SESSION['usuario_nivel']!=$nivel_acceso && $_SESSION['usuario_nivel']!=2){
echo '<div align="center"><h1>Usted no tiene pérmiso para acceder a esta página</h1></div>';
echo '<div align="center"><input type="button" value="Salir" onClick="Javascript:window.close(this)" style="border:double;background-color:#990000;text-align:center;color:#FFFFFF;" ></div>';
}else{
$obj= new manejadordb;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<HEAD>
<title>Traslados</title>
<link rel="stylesheet" href="../demos/css/demos.css" media="screen" type="text/css">
<link rel="stylesheet" href="../demos/css/demo-menu-item.css" media="screen" type="text/css">
<link rel="stylesheet" href="../demos/css/demo-menu-bar.css" media="screen" type="text/css">
<link href="../index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/menu-for-applications.js"></script>
<script type="text/javascript" src="../js/eventos_ventana.js"></script>
<script type="text/javascript"  language="javascript"  src="js/funciones.js"></script>
<style type="text/css">

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

.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix;
-moz-border-radius:6px;
}

.MultiPage {  background-color:White;
  border: 0px solid #919B9C;
  width:100%;
  position:relative;
  padding:10px;
  top:-3px;
  z-index:98;
  display:block;
}
	body{
	margin:0px;
	text-align:center;
	background-image: url();
	}
	
	#mainContentainer{
		width:760px;
		margin:0 auto;
		text-align:left;
	}
	#mainContent{
		border:1px solid #000;
	}
	
	#textContent{
		height:10px;
		overflow:auto;
		padding-left:5px;
		padding-right:5px;
word-spacing:inherit
	}
	#menuDiv{
		width:100%;
		overflow:hidden;
	}
	pre{
		color:#F00;
	}
	p,pre{

	}

.celda {
	font-weight: bold;
	font-size: 10px;
	
}
.celdal {
	BORDER-RIGHT: #990000 thin solid;
    BORDER-TOP: #990000 thin solid;
    BORDER-LEFT: #990000 thin solid;
    BORDER-BOTTOM: #990000 thin solid;
    PADDING-RIGHT: 0px;
    PADDING-LEFT: 0px;
    PADDING-TOP: 0px;
    PADDING-BOTTOM: 0px;
    FONT-FAMILY: Verdana, Arial;
    color: #000000;
    FONT-SIZE: 9pt;
    BACKGROUND-COLOR: #FFFFFF;
	
}

.celdac {
	color:  #990000;
	font-weight: bold;
	font-size: 12px;
	border:inherit;
}
.celdad {
	color:  #990000;
	font-weight: bold;
	font-size: 12px;

white-space:nowrap;
border-bottom:dotted;
background:#FFFFFF;
}

.bordes{
	text-decoration: none;
	background-color: #FFFFFF;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #990000;
	border-right-color: #990000;
	border-bottom-color: #990000;
	border-left-color: #990000;
	text-align:right;
}
.dir{
	text-decoration: none;
	background-color: #FFFFFF;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #990000;
	border-right-color: #990000;
	border-bottom-color: #990000;
	border-left-color: #990000;
	text-align:left;
}

    #Layer1 {
	position:absolute;
	left:328px;
	top:124px;
	width:274px;
	height:178px;
	z-index:1;
}
    #Layer2 {
	position:absolute;
	left:134px;
	top:144px;
	width:450px;
	height:188px;
	z-index:1;
}

.Style5{
color:#FFFFFF;
}


.selecionada:hover{
	background:#CCCCCC;
}

</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function mas(){
var cantidad
cantidad=parseInt(document.ventas.cantidad.value);
cantidad=cantidad+1
document.ventas.cantidad.value=cantidad;

}
function menos(){
var cantidad
cantidad=parseInt(document.ventas.cantidad.value);
cantidad=cantidad-1
if (cantidad>=1){
document.ventas.cantidad.value=cantidad;
}else document.ventas.cantidad.value=1;
}


function validarnum(obj,valores){
	if(valores==1)
		cadena="0123456789-Jj"
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
var clientes="consultas/clientes.php";
function calcularcambio(){
var efectivo
var cheque
var tdb
var tdc
var bl
var esp
var totalcancelado
var totalfactura
//Monto de la Factura
//location.reload();
montofact=parseFloat(document.ventas.totalcancelar1.value);

//Desgloce del pago de la Factura
efectivo=eval(parseFloat(document.ventas.montoefectivo.value));
tdb=eval(parseFloat(document.ventas.montotdb.value));
tdc=eval(parseFloat(document.ventas.montotdc.value));
bl=eval(parseFloat(document.ventas.montobl.value));
esp=eval(parseFloat(document.ventas.montoesp.value));
cheque=eval(parseFloat(document.ventas.montocheque.value));
cestaticket=eval(parseFloat(document.ventas.cestaticket.value));
otramoneda=eval(parseFloat(document.ventas.otromonto.value));
totalcancelado=eval(efectivo+tdb+tdc+bl+esp+cheque+cestaticket+otramoneda);

if((totalcancelado)>0){
document.ventas.montocambio.value=Math.round(eval(totalcancelado-montofact)*100)/100;
}else document.ventas.montocambio.value=0;

}

//-->
</script>
<script type="text/javascript"><!--//--><![CDATA[//><!--
   
function openTargetBlank(e){
   
   var className = 'external';
   var classcerrar = 'cerrar';
   
   if (!e) var e = window.event;
   var clickedObj = e.target ? e.target : e.srcElement;
   
   if(clickedObj.nodeName == 'A' )
    {
      r=new RegExp("(^| )"+className+"($| )");
      if(r.test(clickedObj.className)){
         window.open(clickedObj.href,100,300,resizable=0);
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

var buscar
function ventana(ventana,nombre,tipo){
 
   buscar=window.open(ventana+"?tipo="+tipo,nombre,'width=600,height=500,top='+((screen.height/2)-(180.5))+',left='+((screen.width/2)-(310.5))+',toolbar=no,scrollbars=yes,resizable=no,menubar=no,status=no,directories=no,location=no')
  
}

function cerrarventana(){
window.blur()
//window.close()
window.close(this)
return buscarsol.close();
}
function cerrarbuscarsol(){
return buscar.close();
}

function bonolibro(){
monto=eval(parseFloat(document.ventas.montobl.value));
}
document.onclick = openTargetBlank;

function mensaje(){
alert("mensaje");
}

document.onkeydown = function evento(event){
     var iAscii;
     if (event.keyCode)
         iAscii = event.keyCode;
     else if (event.which)
         iAscii = event.which;
     else
         return false;
     if (iAscii == 116){ 
			return false;
	 }
}

/*document.onkeydown = function(){
if(window.event && window.event.keyCode == 116)
{
window.event.keyCode = 505;
}
if(window.event && window.event.keyCode == 505)
{
return false;
}
} */

//--><!]]></script>
</head>
<body onload="cargardetalle(document.forms[0].codigo.value)">
<form name="traslado" id="traslado" action="">
  <table width="448" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
    <tr>
      <td colspan="2"><div align="center"><strong><img src="../imagenes/logosolrlk.png" alt="" width="750" height="82" /></strong></div></td>
    </tr>
    <tr>
      <td colspan="2" align="right"><strong>Traslado:&nbsp;</strong>
        <input name="codigot" type="text" class="bordes" id="codigot" size="15" value="<?= $_GET['codigol'] ?>" readonly="true" /></td>
    </tr>
    <tr>
      <td colspan="2" align="left"><strong>Sucursal:&nbsp;</strong>
      <?
	  
  
	  $resul1=$obj->consultar("SELECT tbl_itemtraslado.sucursal AS sucursal, tbl_traslados.observaciones, tbl_itemtraslado.solicitud FROM tbl_traslados INNER JOIN tbl_itemtraslado ON tbl_traslados.cod_traslado = tbl_itemtraslado.cod_t WHERE (((tbl_traslados.cod_traslado)='".$_GET['codigol']."')) ORDER BY tbl_itemtraslado.sucursal;");
	  $row1=mysql_fetch_assoc($resul1);
	  $solicitud=$row1['solicitud'];
	  $sucursal=$row1['sucursal'];
	  $obs=$row1['observaciones'];
	  
	  $resul=$obj->consultar("select * from tbl_sucursal where id_sucursal >0 order by id_sucursal");
	  
	  echo "<select name='sucursal' id='sucursal' disabled='true'>";
	  
	  echo "<option value='".$sucursal."' selected='selected'>".$obj->setsucursal($sucursal)."</option>";
	  
	  
	  while($row=mysql_fetch_assoc($resul)){

 	  echo "<option value=".$row['id_sucursal'].">".$row['sucursal']."</option>";
	  }
	  echo "</select>";	  
	  
	  ?></td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td width="369" rowspan="2" align="left" valign="top"><div align="left"><strong>Observaciones:</strong> </div>
        <label>
        <textarea name="observaciones" id="observaciones" cols="50"><?= $obs; ?></textarea>
      </label></td>
    </tr>
    <tr>
      <td width="381" align="left"><strong>Codigo:&nbsp;</strong>
		  <input name="codigo" type="text" class="bordes" id="codigo" size="15" value="<?= $solicitud; ?>" readonly="true" />
          <input name="cargar" type="button" class="boton" onclick="cargardetalle(document.forms[0].codigo.value)" value="Cargar" /></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><div id="resultado"></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><div  align="center" id="cantidad"></div></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input name="asignar" type="button" class="boton" onclick="asignartraslado()" value="Asignar a Traslado   " style="background-image:url(../imagenes/traslados.png);background-repeat:no-repeat;background-position:right;"/>
      <input name="asignar2" type="button" class="boton" onclick="asignartodo()" value="Procesar Todo   " style="background-image:url(../imagenes/traslados.png);background-repeat:no-repeat;background-position:right;"/></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><div id="detallet"></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="right"><input name="aceptar" type="button" class="boton" onclick="modificartraslado()" value="Aceptar" />
          <input name="cancelar" type="button" class="boton" onclick="borraritemt()" value="Cancelar" />
          <input name="salir" type="button" class="boton" onclick="javascript:window.close(this)" value="Salir" /></td>
    </tr>
  </table>
</form>
</body>
</html>
<? }?>