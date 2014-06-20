<? 
require("admin/session.php"); // incluir motor de autentificacin.
include_once('clases/fecha.php');
include_once('funciones/form.php');
include_once('funciones/form_manual.php');
include_once('clases/factura.php');
include_once('clases/reconversion.php');
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma pgina.
$nivel_acceso=1;// definir nivel de acceso para esta pgina.

if ($_SESSION['usuario_nivel'] < $nivel_acceso){
echo '<div align="center"><h1>Usted no tiene prmiso para acceder a esta pgina</h1></div>';
echo '<div align="center"><input type="button" value="Salir" onClick="Javascript:window.close(this)" style="border:double;background-color:#990000;text-align:center;color:#FFFFFF;" ></div>';
//Header ("Location: admin/login.php?error_login=5");
//exit;
}else{

@ $ventana = $_GET['ventana']; 
$tipo=$_GET['tipo']; 
$orden=$_GET['orden'];

$factura=new factura();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<HEAD>


<title>Facturaci&oacute;n</title>
<link rel="stylesheet" href="demos/css/demos.css" media="screen" type="text/css">
<link rel="stylesheet" href="demos/css/demo-menu-item.css" media="screen" type="text/css">
<link rel="stylesheet" href="demos/css/demo-menu-bar.css" media="screen" type="text/css">
<link href="index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/menu-for-applications.js"></script>
<script type="text/javascript" src="js/eventos_ventana.js"></script>
<script type="text/javascript"  language="javascript"  src="js/ajax.js"></script>
<script type="text/javascript"  language="javascript"  src="js/reload.js"></script>
<script type="text/javascript"  language="javascript"  src="js/shortcut.js"></script>
<script type="text/javascript"  language="javascript"  src="js/init.js"></script>
<script type="text/javascript"  language="javascript"  src="js/controls.js"></script>
<script type="text/javascript"  language="javascript"  src="js/custom.js"></script>
<script type="text/javascript"  language="javascript"  src="js/mootools.v1.00.js"></script>
<script type="text/javascript"  language="javascript"  src="js/index.js"></script>
<script type="text/javascript"  language="javascript"  src="js/scriptaculous.js"></script>
<script type="text/javascript"  language="javascript"  src="js/prototype.js"></script>
<script type="text/javascript" src="consultas/calendar/calendar.js"></script>
<script type="text/javascript" src="consultas/calendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="consultas/calendar/calendar-setup.js"></script>


<style type="text/css">
@import url(consultas/calendar/calendar-win2k-1.css);
</style>




<style type="text/css">

.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}
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
.campo{
	border:1px solid #990000;
	text-align:right;
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
    .bordes {
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

.style3 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 12px;
	
}
.style4 {
	font-size: 24px;
	font-weight: bold;
	font-family: Verdana;
	color: #990000;
}

.selecionada:hover{
	background:#CCCCCC;
}

</style>


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

function validarrif(obj,valores){
	if(valores==1)
		cadena="JGjg-0123456789"
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
function ventana(ventana,nombre){
   buscar=window.open(ventana,nombre,'width=600,height=400,top='+0+',left='+0+',toolbar=no,scrollbars=yes,resizable=no,menubar=no,status=no,directories=no,location=no')

}

function cerrarbuscar(){
return buscar.close();
}
function bonolibro(){
monto=eval(parseFloat(document.ventas.montobl.value));
}

  
document.onclick = openTargetBlank;

  
//--><!]]>


</script>


<script language="JavaScript">
function maximizar(){
window.moveTo(0,0);
window.resizeTo(screen.width,screen.height);
document.ventas.codproducto.focus();

revisatalonario();

}
</script>

</head>
<? $cliente=$_GET['cliente'];
if($pagina==false)
	$pagina=1;
else
	$pagina=$_GET['pagina'];
	//echo "orden en additemfactura: ".$orden."<br>";

?>
<body onLoad="llamarasincrono('consulta.php?tipo=<?echo $tipo;?>&cliente=<?echo $cliente;?>&pagina=<?echo $pagina;?>&orden=<?echo $orden;?>','contenidos');return maximizar();">
<!--<div align="center" ><a href="javascript:location.reload()">Actualizar</a></div>-->
<div class="bordes" align="left" ><? echo "Vendedor: ".$_SESSION["usuario_nombre"]."  "."C&oacute;digo: ".$_SESSION['usuario_id'];?></div>
<div id="talonariovacio" style="display:none;" align=center><table border="2"><tr align="center"><td  bgcolor="yellow"><font size=4 color="#610B0B"><b>NO SE HAN CARGADO LOS DATOS DEL TALONARIO</b></font></td></tr></table></div>
<table align="center" width= "84" height= "50" border="0" cellpadding="0" cellspacing="0" bordercolor= "#FFFFFF" bgcolor="#FFFFFF" name= "tabla1" class="celdad" style="border:double;">
<?
if($factura->verificardia()==false)
{
	if($tipo=="n")
		$body=form_ventas($_SESSION['usuario_id'],$_SESSION['usuario_sucursal'],$_GET['cliente'],$tipo);
	elseif($tipo=="m")
		$body=form_ventas_manual($_SESSION['usuario_id'],$_SESSION['usuario_sucursal'],$_GET['cliente'],$tipo);
	
	echo $body;
}
else
{
	$body="EL DIA ESTA CERRADO NO SE PUEDEN PROCESAR FACTURAS <input name='salir' type='button' value='Salir' onClick='window.close(this)' class='boton'>";
	echo "<tr><td>".$body."</td></tr>";
}
?>

</table>
<div class="bordes" align="left" ><? echo "Vendedor: ".$_SESSION["usuario_nombre"]."  "."C&oacute;digo: ".$_SESSION['usuario_id'];?></div>
</body>
</html>
<? }?>
