<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="es-es" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>eGroupWare 1.4 demo [Preferencias para la notificación]</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="eGroupWare" />
		<meta name="description" content="eGroupWare" />
		<meta name="keywords" content="eGroupWare" />
		<meta name="copyright" content="eGroupWare http://www.egroupware.org (c) 2006" />

		<meta name="language" content="es-es" />
		<meta name="author" content="eGroupWare http://www.egroupware.org" />
		<meta name="robots" content="none" />
		<link rel="icon" href="/egw-1.4/phpgwapi/templates/idots/images/favicon.ico" type="image/x-ico" />
		<link rel="shortcut icon" href="/egw-1.4/phpgwapi/templates/idots/images/favicon.ico" />
		<link href="/egw-1.4/phpgwapi/templates/idots/css/idots.css?1213976569" type="text/css" rel="StyleSheet" />
		<link href="/egw-1.4/phpgwapi/templates/idots/print.css?1213976569" type="text/css" media="print" rel="StyleSheet" />
		<script src="/egw-1.4/phpgwapi/templates/idots/js/slidereffects.js" type="text/javascript">
			</script>

		
		<!-- This solves the Internet Explorer PNG-transparency bug, but only for IE 5.5 and higher --> 
			<!--[if gte IE 5.5000]>
			<script src="/egw-1.4/phpgwapi/templates/idots/js/pngfix.js" type="text/javascript">
			</script>
			<![endif]-->
		<style type="text/css">
			
		</style>
		<link href="/egw-1.4/etemplate/templates/default/app.css?1196414535" type="text/css" rel="StyleSheet" />
		<style>
			
		</style>
		
			<script type="text/javascript">
var xajaxRequestUri="/egw-1.4/xajax.php";
var xajaxDebug=false;
var xajaxStatusMessages=false;
var xajaxWaitCursor=false;
var xajaxDefinedGet=0;
var xajaxDefinedPost=1;
var xajaxLoaded=false;
function xajax_doXMLHTTP(){return xajax.call("doXMLHTTP", arguments, 1);}
	</script>
	<script type="text/javascript" src="/egw-1.4/phpgwapi/js/xajax_js/xajax.js"></script>

	<script type="text/javascript">
window.setTimeout(function () { if (!xajaxLoaded) { alert('Error: the xajax Javascript file could not be included. Perhaps the URL is incorrect?\nURL: /egw-1.4/phpgwapi/js/xajax_js/xajax.js'); } }, 6000);
	</script>
<!--JS Imports from phpGW javascript class -->
<script type="text/javascript" src="/egw-1.4/phpgwapi/js/jsapi/jsapi.js?1213977908"></script>
<script type="text/javascript" src="/egw-1.4/etemplate/js/etemplate.js?1190343918"></script>


	</head>
	<!-- we don't need body tags anymore, do we?) we do!!! onload!! LK -->
	<body ><script language="JavaScript" type="text/javascript">
   function opacity(id, opacStart, opacEnd, millisec) {
		 //speed for each frame
		 var speed = Math.round(millisec / 100);
		 var timer = 0;

		 //determine the direction for the blending, if start and end are the same nothing happens
		 if(opacStart > opacEnd) {
			   for(i = opacStart; i >= opacEnd; i--) {
					 setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
					 timer++;
			   }
		 } 
		 else if(opacStart < opacEnd) {
			   for(i = opacStart; i <= opacEnd; i++)
			   {
					 setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
					 timer++;
			   }
		 }
   }

   //change the opacity for different browsers
   function changeOpac(opacity, id) {
		 var object = document.getElementById(id).style;
		 object.opacity = (opacity / 100);
		 object.MozOpacity = (opacity / 100);
		 object.KhtmlOpacity = (opacity / 100);
		 object.filter = "alpha(opacity=" + opacity + ")";
   } 
   function shiftOpacity(id, millisec) {
		 //if an element is invisible, make it visible, else make it ivisible
		 if(document.getElementById(id).style.opacity == 0) {
			   opacity(id, 0, 100, millisec);
			} else {
			   opacity(id, 100, 0, millisec);
		 }
   } 
</script>

<div id="topmenu">
   <div id="topmenu_items">
	  	  	  <div style="padding:0px 0px 0px 10px;position:relative;float:left;"><img src="/egw-1.4/phpgwapi/templates/idots/images/orange-ball.png" />&nbsp;<a href="/egw-1.4/home/index.php">Inicio</a></div>
	  	  	  	  <div style="padding:0px 0px 0px 10px;position:relative;float:left;"><img src="/egw-1.4/phpgwapi/templates/idots/images/orange-ball.png" />&nbsp;<a href="/egw-1.4/preferences/index.php">Preferencias</a></div>
	  	  	  	  <div style="padding:0px 0px 0px 10px;position:relative;float:left;"><img src="/egw-1.4/phpgwapi/templates/idots/images/orange-ball.png" />&nbsp;<a href="/egw-1.4/manual/index.php" target="manual" onClick="if (this != '') { window.open(this+'?referer='+encodeURIComponent(location),this.target,'width=800,height=600,scrollbars=yes,resizable=yes'); return false; } else { return true; }">Manual / Ayuda</a></div>
	  	  	  	  <div style="padding:0px 0px 0px 10px;position:relative;float:left;"><img src="/egw-1.4/phpgwapi/templates/idots/images/orange-ball.png" />&nbsp;<a href="/egw-1.4/logout.php">Salir</a></div>
	  	     </div>

   <div id="topmenu_info">
	  
	  	  <div style="padding:0px 10px 0px 0px;position:relative;float:left;"><b>Account, Demo</b> - Martes 14/10/2008</div>
	  	  <div style="padding:0px 10px 0px 0px;position:relative;float:left;"></div>
	  	  <div style="padding:0px 10px 0px 0px;position:relative;float:left;"><select name="quick_add"  onchange="eval(this.value); this.value=0; return false;">
<option value="0">Añadir ...</option>
<option value="location.href = '/egw-1.4/index.php?menuaction=projectmanager.uiprojectmanager.edit';">Administrador de proyectos</option>
<option value="window.open('/egw-1.4/index.php?menuaction=calendar.uiforms.edit','_blank','width=750,height=400,location=no,menubar=no,toolbar=no,scrollbars=yes,status=yes');">Calendario</option>

<option value="window.open('/egw-1.4/index.php?menuaction=felamimail.uicompose.compose','_blank','width=700,height=750,location=no,menubar=no,toolbar=no,scrollbars=yes,status=yes');">FelaMiMail</option>
<option value="window.open('/egw-1.4/index.php?menuaction=timesheet.uitimesheet.edit','_blank','width=600,height=400,location=no,menubar=no,toolbar=no,scrollbars=yes,status=yes');">Hoja de presencia</option>
<option value="window.open('/egw-1.4/index.php?menuaction=addressbook.uicontacts.edit','_blank','width=850,height=440,location=no,menubar=no,toolbar=no,scrollbars=yes,status=yes');">Libreta de direcciones</option>
<option value="window.open('/egw-1.4/index.php?menuaction=resources.ui_resources.edit','_blank','width=800,height=600,location=no,menubar=no,toolbar=no,scrollbars=yes,status=yes');">Recursos</option>
<option value="window.open('/egw-1.4/index.php?menuaction=infolog.uiinfolog.edit&amp;type=task','_blank','width=750,height=550,location=no,menubar=no,toolbar=no,scrollbars=yes,status=yes');">Registro de notas y tareas</option>
<option value="window.open('/egw-1.4/index.php?menuaction=tracker.uitracker.edit','_blank','width=700,height=480,location=no,menubar=no,toolbar=no,scrollbars=yes,status=yes');">Sistema de seguimiento</option>
</select>
</div>
	     </div>
   <div style="clear:both;"></div>

</div>

<script language="JavaScript" type="text/javascript">
	  </script>

<div style="position:relative"><div id="divLogo"><a href="http://www.eGroupWare.org" target="_blank"><img src="/egw-1.4/phpgwapi/templates/idots/images/logo.png" border="0" title="www.eGroupWare.org" alt="eGroupWare"/></a></div></div>



<div id="divMain">
	<div id="divUpperTabs">
		<ul>

		</ul>

	</div>
	<div id="divAppIconBar">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top: 7px">
			<tr>
				<td width="180"></td>
				<td valign="bottom">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>

							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/home/index.php" ><img src="/egw-1.4/home/templates/default/images/navbar.png" alt="Inicio" title="Inicio" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/felamimail/index.php" ><img src="/egw-1.4/felamimail/templates/default/images/navbar.png" alt="FelaMiMail" title="FelaMiMail" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/calendar/index.php" ><img src="/egw-1.4/calendar/templates/default/images/navbar.png" alt="Calendario" title="Calendario" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/addressbook/index.php" ><img src="/egw-1.4/addressbook/templates/default/images/navbar.png" alt="Libreta de direcciones" title="Libreta de direcciones" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/mydms/index.php" ><img src="/egw-1.4/mydms/templates/default/images/navbar.png" alt="Sistema de gestión de documentos" title="Sistema de gestión de documentos" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/tracker/index.php" ><img src="/egw-1.4/tracker/templates/default/images/navbar.png" alt="Sistema de seguimiento" title="Sistema de seguimiento" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/infolog/index.php" ><img src="/egw-1.4/infolog/templates/default/images/navbar.png" alt="Registro de notas y tareas" title="Registro de notas y tareas" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/projectmanager/index.php" ><img src="/egw-1.4/projectmanager/templates/default/images/navbar.png" alt="Administrador de proyectos" title="Administrador de proyectos" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/resources/index.php" ><img src="/egw-1.4/resources/templates/default/images/navbar.png" alt="Recursos" title="Recursos" border="0" /></a></td>

							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/timesheet/index.php" ><img src="/egw-1.4/timesheet/templates/default/images/navbar.png" alt="Hoja de presencia" title="Hoja de presencia" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/filemanager/index.php" ><img src="/egw-1.4/filemanager/templates/default/images/navbar.png" alt="Administrador de archivos" title="Administrador de archivos" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/wiki/index.php" ><img src="/egw-1.4/wiki/templates/default/images/navbar.png" alt="Wiki" title="Wiki" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/bookmarks/index.php" ><img src="/egw-1.4/bookmarks/templates/default/images/navbar.png" alt="Marcadores" title="Marcadores" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/sitemgr/index.php" ><img src="/egw-1.4/sitemgr/templates/default/images/navbar.png" alt="Administrador de sitios web" title="Administrador de sitios web" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/news_admin/index.php" ><img src="/egw-1.4/news_admin/templates/default/images/navbar.png" alt="Administrador de noticias" title="Administrador de noticias" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/polls/index.php" ><img src="/egw-1.4/polls/templates/default/images/navbar.png" alt="Sondeos" title="Sondeos" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/phpbrain/index.php" ><img src="/egw-1.4/phpbrain/templates/default/images/navbar.png" alt="Base de conocimiento" title="Base de conocimiento" border="0" /></a></td>
							<td width="5%" align="center" style="text-align:center"><a href="/egw-1.4/logout.php" ><img src="/egw-1.4/phpgwapi/templates/default/images/logout.png" alt="Salir" title="Salir" border="0" /></a></td>

						</tr>
						<tr>

							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/home/index.php" >Inicio</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/felamimail/index.php" >FelaMiMail</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/calendar/index.php" >Calendario</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/addressbook/index.php" >Libreta de direcciones</a></td>

							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/mydms/index.php" >Sistema de gestión de documentos</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/tracker/index.php" >Sistema de seguimiento</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/infolog/index.php" >Registro de notas y tareas</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/projectmanager/index.php" >Administrador de proyectos</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/resources/index.php" >Recursos</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/timesheet/index.php" >Hoja de presencia</a></td>

							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/filemanager/index.php" >Administrador de archivos</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/wiki/index.php" >Wiki</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/bookmarks/index.php" >Marcadores</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/sitemgr/index.php" >Administrador de sitios web</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/news_admin/index.php" >Administrador de noticias</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/polls/index.php" >Sondeos</a></td>

							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/phpbrain/index.php" >Base de conocimiento</a></td>
							<td align="center" valign="top" class="appTitles" style="text-align:center"><a href="/egw-1.4/logout.php" >Salir</a></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<div id="divStatusBar"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
		<td width="33%" align="left" id="user_info"></td>
		<td align="center" id="admin_info"></td>
		<td width="33%"  align="right" id="quick_add"></td>
	</tr></table></div>	

		<!-- End Sidebox Column -->

		<!-- Applicationbox Column -->
		<td id="tdAppbox" valign="top" {remove_padding}>
			<div id="divAppboxHeader">Preferencias para la notificación</div>

			<div id="divAppbox">
				<table width="100%" cellpadding="0" cellspacing="0">
				<tr><td><script src="/egw-1.4/notifications/js/notificationajaxpopup.js" type="text/javascript"></script><script type="text/javascript">notificationwindow_init();</script>
		<div id="notificationwindow" style="display: none; z-index: 999;">
			<div id="divAppboxHeader">Notificaciones</div>
				<div id="divAppbox">
				<div id="notificationwindow_message"></div>

				<center><input type="submit" value="Aceptar" onClick="notificationwindow_button_ok();"></center>
			</div>
		</div>
	<form method="POST" name="eTemplate" action="/egw-1.4/etemplate/process_exec.php?menuaction=notifications.uinotificationprefs.index"  onsubmit="this.innerWidth.value=window.innerWidth ? window.innerWidth : document.body.clientWidth;">
<input type="hidden" name="etemplate_exec_id" value="notifications:122400622595" />
<script language="javascript">
document.write('<input type="hidden" name="java_script" value="1" />');
if (document.getElementById) {
	document.write('<input type="hidden" name="dom_enabled" value="1" />');
}
</script>
<input type="hidden" name="submit_button" value="" />
<input type="hidden" name="innerWidth" value="" />


<!-- BEGIN eTemplate notifications.prefsindex -->




<!-- BEGIN grid  -->
<table >
	<tr >
		<td  align="left">&nbsp;</td>
		<td  align="left">&nbsp;</td>
	</tr>
	<tr >
		<td  align="left"><input type="checkbox" name="exec[disable_ajaxpopup]" value="1" id="exec[disable_ajaxpopup]"  />

</td>
		<td  align="left">No notificarme usando ventanas emergentes en eGroupWare </td>
	</tr>
	<tr >
		<td  align="left">&nbsp;</td>
		<td  align="left">&nbsp;</td>
	</tr>
	<tr >
		<td  align="left">&nbsp;</td>

		<td  align="left">&nbsp;</td>
	</tr>
	<tr >
		<td  colspan="2" align="left">

<!-- BEGIN hbox -->

<table  width="100%">
	<tr >
		<td >

<!-- BEGIN hbox -->

<table >
	<tr >
		<td ><input type="submit" name="exec[button][save]" value="Grabar" id="exec[button][save]"  />
</td>
		<td ><input type="submit" name="exec[button][apply]" value="Aplicar" id="exec[button][apply]"  />
</td>
	</tr>
</table>


<!-- END hbox -->

</td>
		<td  align="right"><input type="submit" name="exec[button][cancel]" value="Cancelar" id="exec[button][cancel]"  />
</td>
	</tr>
</table>


<!-- END hbox -->

</td>
	</tr>
</table>
<!-- END grid  -->

<!-- END eTemplate notifications.prefsindex -->

</form>
		 							</td></tr></table>
									</div>
		  <!-- Applicationbox Column -->
		  </td>
		  </tr>
  </table>
</div>

</div>
	
<div id="divPoweredBy">Proporcionado por <a href="/egw-1.4/about.php">eGroupWare</a> Versión 1.4.004</div>	
<!-- enable wz_tooltips -->
<script src="/egw-1.4/phpgwapi/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
</body>
</html>
