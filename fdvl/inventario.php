<?PHP
  ini_set('session.bug_compat_warn',0);   
  session_start();
  include("includes/sesiones.php");
  $_SESSION['server_name'] = 'inventario.php';
?>
<link rel="SHORTCUT ICON" href="bandera.ico">  
<html>
	<head>
		<title>SIDVENLIB</title>
		<script src="includes/validation.js" type="text/javascript"></script>
		<script type="text/javascript" src="includes/calendar.js"></script>
		<script type="text/javascript" src="lang/calendar-es.js"></script>
		<script type="text/javascript" src="includes/calendar-setup.js"></script>
		
		<link rel="stylesheet" type="text/css" media="all" href="includes/calendar-win2k-cold-2.css"/>
		<link rel="STYLESHEET" type="text/css" href="includes/estilos.css" media='screen'>
		<link rel="STYLESHEET" type="text/css" href="includes/estilos_imprimir.css" media="print">
	</head>
	<body>
	<div id="noMostrar" align="left">
	<table>
		<tr align="top">
			<td><img src="images/logolateral.jpg" border=0 width="100"></td>
		  <td><img src="imagenes/cabeceramia.jpg" border=0 width="550"></td>
	  </tr>
	</table>
	</div>
	<div id="borde">
	<div id="contenedor">
		 <div id="cabecera">
			<h1><span>Gobierno Bolivariano de Venezuela</span></h1>
		 </div>
		 <div id="logomenu">
         <?php if($conectado){?>	 
		     <div id="logolateral">
			     <h1><span>Ministerio del Poder popular para la Cultura</span></h1>
		     </div>
		     <?php include("includes/menu.htm") ?>
	  </div>
		 <div id="cuerpo">
		  	 <?php include("cuerpo.php") ?>
		 </div>
         		 <div id="footer">   	   
	    <? include("includes/footer.php"); ?>        
    </div>
		 <?php }else{?>
		    <div id="logolateral">
			     <h1><span>Ministerio del Poder popular para la Cultura</span></h1>
		     </div>
		  <?php  include("conectarse.php")
		 ?>
		 </div>
		 <?php } ?>
	</div>
	</div>
	</body>
</html>
