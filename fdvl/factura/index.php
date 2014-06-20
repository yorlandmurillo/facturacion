<? 
require("admin/session.php");// // incluir motor de autentificación.
include_once('clases/fecha.php');
include_once('funciones/form.php');
include_once('clases/factura.php');
include_once("clases/directorio.php");


$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.


if ($_SESSION['usuario_nivel']!=$nivel_acceso && $_SESSION['usuario_nivel']!=2){
$pag=$_SESSION['usuario_nivel'];
Header ("Location: $redirec[$pag]");
exit;
}

$dir= new directorio();
$factura=new factura();
$factura->cerrardiaaut($_SESSION['usuario_sucursal']);
$factura->precierreaut($_SESSION['usuario_id'],$_SESSION['usuario_sucursal']);
$factura->nuevodia($_SESSION['usuario_sucursal'],$_SESSION['usuario_id']);
$dir->creardir($_SESSION['usuario_sucursal']);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd" >
<HTML>
<HEAD>
<title>Principal</title>
<link rel="stylesheet" href="demos/css/demos.css" media="screen" type="text/css">
<link rel="stylesheet" href="demos/css/demo-menu-item.css" media="screen" type="text/css">
<link rel="stylesheet" href="demos/css/demo-menu-bar.css" media="screen" type="text/css">
<script type="text/javascript" src="js/menu-for-applications.js"></script>
<script type="text/javascript" src="js/eventos_ventana.js"></script>
<script type="text/javascript"  language="javascript"  src="js/ajax.js"></script>
<script type="text/javascript"  language="javascript"  src="js/reload.js"></script>
<script type="text/javascript"  language="javascript"  src="js/shortcut.js"></script>
<script type="text/javascript"  language="javascript"  src="js/init.js"></script>
<script type="text/javascript"  language="javascript"  src="js/chat.js"></script>
<script type="text/javascript"  language="javascript"  src="js/dom.js"></script>
<script type="text/javascript"  language="javascript"  src="funciones/js/sha1.js"></script>
<style type="text/css">
	
.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}
.MultiPage {  
  background-color:White;
  border: 0px solid #919B9C;
  width:100%;
  position:relative;
  padding:10px;
  top:-3px;
  z-index:98;
  display:block;
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
		height:400px;
		overflow:auto;
		padding-left:5px;
		padding-right:5px;
		word-spacing:inherit;
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

.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 24px;
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
.style5 {color: #FFFFFF}

.tabla{
-moz-border-radius: 5px;
border : 5px solid #7F0000;

}

body {
	background-color: #EAEAEA;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
#Layer3 {
	position:absolute;
	left:679px;
	top:85px;
	width:184px;
	height:16px;
	z-index:1;
}
.Estilo3 {
	font-size: 12px;
	font-weight: bold;
}
.Estilo7 {
font-size: 12px;
font-weight: bold; 
color: #AA0000; 
}

#barra{
	display:table;
	width:400px;
	background-color:#990000;
	border:1px solid #0066CC;
}
.c_fecha{
	float:left;
	width:200px;
	text-align:center;
	color:#FFFFFF;
}
.c_usuario{	
	float:left;
	width:100px;
	text-align:center;
	color:#990000;
}
.c_mensaje{	
	float:left;
	width:100px;
	color:#990000;
}
.o_usuario{	
	float:left;
	width:100px;
	text-align:center;
	color:#990000;
}
.o_mensaje{	
	float:left;
	width:100px;
	color:#990000;
}
.caja{
	display:table;
	width:400px;
	background-color:#8F0E21;
	border:1px solid #999999;
	color:#FFFFFF;
}
.caja1{
	display:table;
	width:400px;
	background-color:#FFFFFF;
	border:1px solid #0066CC;
	
}


.Estilo8 {
	color: #990000;
	font-weight: bold;
}
.Estilo9 {color: #FFFFFF; font-weight: bold; }
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


//-->
</script>
</head>
<body onLoad="JavaScript:init()">
<table width="862" height="511" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
  <tr>
    <td height="36" colspan="7" align="left" valign="middle" bgcolor="#FFFFFF"><div align="center"><img src="imagenes/libsur.png" width="862" height="144" border="0" align="absmiddle" usemap="#Map"></div></td>
  </tr>
  <tr>
    <td height="2" colspan="7" align="left" valign="top" bgcolor="#FFFFFF"><div id="mainContentainer" style="width:100%;" >
      <div id="header" class="Custom_menuBar_sub1" ></div>
      <div id="mainContent">
        <!-- <ul><li> Lista de objetos de tipo menu -->
        <ul id="menuModel" style="display:none;" >
          <li id="50000" itemicon="imagenes/newventa.png"><a href="#" title="Ventas"><strong>Registro</strong></a>
                <ul width="150">
                  <li id="500002" itemicon="imagenes/neworden.png"><a href="JavaScript:ventas('consultas/clientes.php?facturando=1&tipo=n','clientes')"  target=formularios >Venta</a></li>
          
		          <li id="500003" itemicon="imagenes/neworden.png"><a href="JavaScript:ventas('consultas/clientes.php?facturando=1&tipo=m','clientes')"  target=formularios >Ventas Manuales</a></li>
                </ul>
		</li>
          <li id="50001" itemicon="imagenes/search.png"><a href="#"><strong>Consultas</strong></a>
                <ul width="380">
                  <li id="500011" itemicon="imagenes/buscarventa.png"><a href="JavaScript:consulta('consultas/facturas.php','facturas')">Venta</a></li>
				  <li id="500015" itemicon="imagenes/buscarcliente.png"><a href="JavaScript:consulta('consultas/clientes.php?consultando=1','clientes')">Cliente</a></li>
                  <li id="500012" itemicon="imagenes/info.png"><a href="JavaScript:consulta('consultas/inventario.php','libros')">Inventario</a></li>
                   <li id="500013" itemicon="imagenes/info.png"><a href="JavaScript:consulta('consultas/existencias_librerias.php','')">Inventarios Librerias</a></li>
                  <li id="500017" itemicon="imagenes/info.png"><a href="JavaScript:consulta('consultas/busca_articulos_librerias_inventariadas.php','')">Busqueda en librerias inventariadas</a></li>
				 <li id="500018" itemicon="imagenes/info.png"><a href="JavaScript:consulta('consultas/busca_articulos_sede_librerias.php','')">Ultima vez que se vendio el libro servidor Sede Librerias</a></li>
                </ul>
          </li>
          <li id="60001" itemicon="imagenes/operaciones.png"><a href="#"><strong>Operaciones</strong></a>
                <ul width="150">
                  <li id="600014" itemicon="imagenes/traslado.gif"><a href="JavaScript:ventas('consultas/traslados.php','traslados')">Traslado de Libros</a></li>
                  <li id="600012" itemicon="imagenes/calculate.gif"><a href="JavaScript:cerrardia()">Cierre de Ventas</a></li>
                  <li id="600013" itemicon="imagenes/calculate.gif"><a href="JavaScript:sincronizar()">Sincronizar</a></li>
				  <li id="600015" itemicon="imagenes/inventario.gif"><a href="JavaScript:consulta('inventario/new_inventario.php','inventario')">Inventario</a></li>

                </ul>
          </li>
          <?
		  
		    if ($_SESSION['usuario_nivel']==2){
			?>
		 <li id="70001" itemIcon="imagenes/adm.png"><a href="#"><strong>Administraci&oacute;n</strong></a>
              <ul width="130">
			  <li id="70101" itemIcon="imagenes/security.gif"><a href="#"><strong>Seguridad</strong></a>
			  <ul width="130">
				  <li id="700102" itemIcon="imagenes/usuarios.gif"><a href="JavaScript:ventas('consultas/usuarios.php','traslados')">Usuario</a></li>
				  <li id="700104" itemIcon="imagenes/usuarios.gif"><a href="JavaScript:ventas('consultas/usuarios.php','traslados')">Permisos</a></li>
				  <li id="700103" itemIcon="imagenes/keys.png"><a href="JavaScript:clave('admin/clave.php','clave')">Contrase&ntilde;a</a></li>
              </ul>
			  </li>
           </ul>
          </li>

	<?
	
			}
			?>
			<li id="170001" itemIcon="imagenes/reportes.png"><a href="#"><strong>Reportes</strong></a>
			<ul width="320">
				<li id="1700012" itemIcon="imagenes/reportes.png"><a href="JavaScript:ventas('reportes/ventasdetalle.php','precierre')">Ventas Detalladas por Facturas</a> </li>
				<li id="1700013" itemIcon="imagenes/reportes.png"><a href="JavaScript:ventas('reportes/ventasdetalle2.php','precierre')">Resumen de Ventas</a> </li>
				<li id="1700014" itemIcon="imagenes/reportes.png"><a href="JavaScript:ventas('reportes/ventasdetalle3.php','precierre')">Ventas, Clientes Atendidos y Bienes Culturales</a> </li>	
				<li id="1700015" itemIcon="imagenes/reportes.png"><a href="JavaScript:ventas('reportes/librosmasvendidos.php','precierre')">Libros mas Vendidos por Autor y Editorial</a> </li>
				<li id="1700016" itemIcon="imagenes/reportes.png"><a href="JavaScript:ventas('reportes/cierrecaja.php','cierre')">Cierre Ventas</a></li>
				<li id="1700017" itemIcon="imagenes/reportes.png"><a href="JavaScript:ventas('reportes/precierrecaja.php','traslados')" >Pre Cierre</a></li>	
				<li id="1700018" itemIcon="imagenes/reportes.png"><a href="JavaScript:ventas('reportes/ventasporeditorial.php','precierre')">Ventas por Editorial</a> </li>
				<li id="1700019" itemIcon="imagenes/reportes.png"><a href="JavaScript:ventas('reportes/monitoreo.php','notas')">Monitoreo Notas de Entrega y Control Perceptivo</a> </li>	
			</ul>
			</li>
		  <?
	
	

          ?>
          <li id="50004" itemtype="separator"></li>
          <li id="50005" itemicon="imagenes/exit.png"><a href="admin/aut_logout.php"><strong>Salir</strong></a></li>
          <li id="50006" itemtype="separator"></li>
          <li id="50007" itemicon="imagenes/help.png"><a href="#"><strong>Ayuda</strong></a>
          <ul width="320">
			<li id="500071" itemIcon="imagenes/reportes.png"><a href="JavaScript:ventas('ayuda/formas_de_pago/ayuda_forma_de_pago.php','ayuda')">Procesar las formas de pago</a> </li>
		 </ul>
          </li>
        </ul>
        <!-- End data source for the menu -->
        <div id="menuDiv"></div>
      </div>
    </div></td>
  </tr>
  <tr>
    <td height="26" colspan="7" align="right" valign="top" bgcolor="#FFFFFF"><table align="right">
      <tr>
        <td align="center" valign="middle"><span class="Estilo7">M&Oacute;DULO DE VENTA Y FACTURACÓN </span> &nbsp; </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="13" colspan="7" align="left" valign="top" bgcolor="#FFFFFF">
	<script type="text/javascript">
	var menuModel = new DHTMLSuite.menuModel();
	DHTMLSuite.configObj.setCssPath('demos/css/');
	menuModel.addItemsFromMarkup('menuModel');
	menuModel.setMainMenuGroupWidth(00);	
	menuModel.init();
	var menuBar = new DHTMLSuite.menuBar();
	menuBar.addMenuItems(menuModel);
	menuBar.setTarget('menuDiv');
	menuBar.init();	
	  </script></td>
  </tr>
  <tr bgcolor="#990000">
    <td height="20" colspan="7" align="left" bordercolor="#000000" bgcolor="#FFFFFF"><script type="text/javascript" src="js/reloj.js"></script></td>
  </tr>
  <tr class="boton">
    <td height="30" colspan="7" align="center" valign="middle" bgcolor="#990000" style="border-top:double;border-color:#990000;"><font  color="#FFFFFF">&nbsp; </font>
        <table align="left">
          <tr>
            <td align="center" valign="middle"><span class="Estilo3"><font  color="#FFFFFF">Usuario</font><font  color="#FFFFFF">:
              <?= $_SESSION['usuario_nombre']." ".$_SESSION['usuario_apellido'];?>
            </font></span> &nbsp; <div id="progreso"></div></td>
          </tr>
        </table>
      <table align="right">
          <tr>
            <td align="center" valign="middle"><img src="imagenes/dg8.gif" name="hr1" width="12" height="16"><img src="imagenes/dg8.gif" name="hr2" width="12" height="16"><img src="imagenes/dgc.gif" name="c" width="12" height="16"><img src="imagenes/dg8.gif" name="mn1" width="12" height="16"><img src="imagenes/dg8.gif" name="mn2" width="12" height="16"><img src="imagenes/dgc.gif" name="c" width="12" height="16"><img src="imagenes/dg8.gif" name="se1" width="12" height="16"><img src="imagenes/dg8.gif" name="se2" width="12" height="16">&nbsp;<img src="imagenes/dgpm.gif" name="ampm" width="38" height="16"> </td>
          </tr>
      </table></td>
  </tr>
</table>
<?
//echo "-*->".$_SESSION['iva']."-*-".$_SESSION['usuario_sucursal'];
?>
</body>
</html>
