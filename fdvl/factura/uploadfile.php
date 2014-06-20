<? 
require("admin/session.php");// // incluir motor de autentificación.
include_once('clases/fecha.php');
include_once('funciones/form.php');
include_once('clases/factura.php');
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=7;// definir nivel de acceso para esta página.
if ($_SESSION['usuario_nivel']!=$nivel_acceso && $_SESSION['usuario_nivel']!=2){
Header ("Location: login.php?error_login=5");
exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd" >
<HTML>
<HEAD>
<title>Subir Archivos al Servidor</title>
<link rel="stylesheet" href="demos/css/demos.css" media="screen" type="text/css">
<link rel="stylesheet" href="demos/css/demo-menu-item.css" media="screen" type="text/css">
<link rel="stylesheet" href="demos/css/demo-menu-bar.css" media="screen" type="text/css">
<script type="text/javascript" src="js/menu-for-applications.js"></script>
<script type="text/javascript" src="js/eventos_ventana.js"></script>
<script type="text/javascript"  language="javascript"  src="js/ajax.js"></script>
<script type="text/javascript"  language="javascript"  src="js/reload.js"></script>
<script type="text/javascript"  language="javascript"  src="js/shortcut.js"></script>
<script type="text/javascript"  language="javascript"  src="js/init.js"></script>
<script type="text/javascript"  language="javascript"  src="funciones/js/sha1.js"></script>
<style type="text/css">
	
.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #C2382B; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}
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
		height:400px;
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
.Estilo1 {color: #990000}
.style3 {font-size: 12px}
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


<body>
<table width="760" height="658" border="0" align="center" cellpadding="0" cellspacing="0" style="border-color:#990000;border:double; ">
  <tr>
    <td height="36" colspan="7" align="center" valign="middle" bgcolor="#990000"><img src="imagenes/libsur.jpg" width="770" height="150" border="0" usemap="#Map"></td>
  </tr>
  
  <tr>
    <td height="2" colspan="7" align="left" valign="top" bgcolor="#990000"><div id="mainContentainer">
      <div id="header" class="Custom_menuBar_sub1"></div>
      <div id="mainContent">
        <!-- <ul><li> Lista de objetos de tipo menu -->
        <ul id="menuModel" style="display:none">
          <li id="50000" itemIcon="imagenes/venta.png"><a href="#" title="Ventas"><strong>Archivos</strong></a>
              <ul width="150">
                <li id="500002" itemIcon="imagenes/venta.png"><a href="JavaScript:ventas('clases/w2box/index.php','archivos')"  target=formularios >Subir Archivo</a></li>
              </ul>
          </li>
          <li id="50002" itemType="separator"></li>
          <li id="50003" itemIcon="imagenes/salir.png"><a href="admin/aut_logout.php"><strong>Salir</strong></a></li>
        </ul>
        <!-- End data source for the menu -->
        <div id="menuDiv"></div>
      </div>
    </div></td>
  </tr>
  <tr>
    <td height="25" colspan="7" align="right" valign="top" bgcolor="#990000"><span class="style3"><font  color="#FFFFFF">Usuario:</font></span><font  color="#FFFFFF" size="+1">
    <?= strtoupper($_SESSION['usuario_nombre']);?>
    </font></td>
  </tr>
  <tr>
    <td height="25" colspan="7" align="center" valign="top" bgcolor="#990000"><table>
      <tr>
        <td align="center" valign="middle"><img src="imagenes/dg8.gif" name="hr1" width="19" height="24"><img src="imagenes/dg8.gif" name="hr2" width="19" height="24"><img src="imagenes/dgc.gif" name="c" width="19" height="24"><img src="imagenes/dg8.gif" name="mn1" width="19" height="24"><img src="imagenes/dg8.gif" name="mn2" width="19" height="24"><img src="imagenes/dgc.gif" name="c" width="19" height="24"><img src="imagenes/dg8.gif" name="se1" width="19" height="24"><img src="imagenes/dg8.gif" name="se2" width="19" height="24">&nbsp;<img src="imagenes/dgpm.gif" name="ampm" width="58" height="23"> </td>
      </tr>
    </table>
      <font  color="#FFFFFF">
      <? 
	$fecha=new fecha(); $fecha->fechaa();
	?>
      </font>
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
    <td height="20" colspan="7" align="left" valign="top" bordercolor="#000000"><script type="text/javascript" src="js/reloj.js"></script><div align="center"><span  id="progreso" style="text-decoration:blink;color:#FFFFFF;font-size:24px; "></span>
      <div align="left"></div>
    </div></td>
  </tr>
  <tr bgcolor="#990000">
    <td width="32" height="435" align="center" valign="top" >&nbsp;</td>
    <td width="19" align="center" valign="top" >&nbsp;</td>
    <td width="31" align="center" valign="top" >&nbsp;</td>
    <td width="35" align="center" valign="top" >&nbsp;</td>
    <td width="35" align="center" valign="top" >&nbsp;</td>
    <td width="173" align="center" valign="top" >&nbsp;</td>
    <td width="506" align="center" valign="middle" >&nbsp;</td>
  </tr>
  
  <tr class="boton">
    <td colspan="7" align="center" valign="middle" style="border-top:double;border-color:#990000;"><dfn></dfn><dfn></dfn><dfn></dfn><dfn></dfn><dfn></dfn><dfn><img src="imagenes/foot.png" width="763" height="28"></dfn></td>
  </tr>
</table>

<map name="Map">
  <area shape="rect" coords="1,75,109,148" href="http://www.libreriasdelsur.gob.ve" target="_blank" title="Página de la Fundación">
</map></body>
</html>