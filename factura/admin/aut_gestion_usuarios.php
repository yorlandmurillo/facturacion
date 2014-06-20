<?php
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
require("aut_verifica.inc.php");// // incluir motor de autentificación.
$nivel_acceso=0;// definir nivel de acceso para esta página.

if ($nivel_acceso != $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
require ("aut_config.inc.php"); // incluir configuracion.
require("timeout.php");
timeout();
function cabeceraHTML(){
include "cabecera.php";

echo <<< HTML

<html>
<head>
<script>
contenido_textarea = ""
num_caracteres_permitidos = 254
function valida_longitud(){
	num_caracteres = document.forms[0].direccion.value.length
	
	if (num_caracteres <= num_caracteres_permitidos){
		contenido_textarea = document.forms[0].direccion.value	
	}else{
		document.forms[0].direccion.value = contenido_textarea
	}
	
	if (num_caracteres >= num_caracteres_permitidos){
		document.forms[0].caracteres.style.color="#ff0000";
	}else{
		document.forms[0].caracteres.style.color="#000000";
	}
	
	cuenta()
}
function cuenta(){
	document.forms[0].caracteres1.value=num_caracteres_permitidos 
	document.forms[0].caracteres.value=document.forms[0].direccion.value.length
	document.forms[0].caracteres1.value=document.forms[0].caracteres1.value-document.forms[0].direccion.value.length

}
function validar(obj,valores){
	if(valores=="numeros")
		cadena="0123456789- "
	else if(valores=="letras")
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

<title>Gestión Usuarios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
 .botones {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #C2382B; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}
 .imputbox {  font-size: 10pt; color: #000099; background-color: #FFFFFF; font-family: Verdana, Arial, Helvetica, sans-serif; border: 1pix #000000 solid; border-color: #000000 solid; font-weight: normal}
 A:VISITED  { font-weight: normal; color: #0000CC; TEXT-DECORATION:none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt}
 A:LINK     { font-weight: normal; color: #0000CC; TEXT-DECORATION:none; font-family: Verdana, Arial, Helvetica, sans-serif; border-color: #33FF33 #66FF66; clip:  rect(   ); font-size: 10pt}
 A:ACTIVE   { font-weight: normal; color: #FF3333; TEXT-DECORATION:none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt}
 A:HOVER    { font-weight: normal; color: #0000CC; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: normal; text-decoration: underline; font-size: 10pt}
-->
</style>
</head>

<body bgcolor="#FFFFFF">


HTML;
}


if (isset($_GET['error'])){

$error_accion_ms[0]= "No se puede borrar el Usuario, debe existir por lo menos uno.<br>Si desea borrarlo, primero cree uno nuevo.";
$error_accion_ms[1]= "Faltan Datos.";
$error_accion_ms[2]= "Passwords no coinciden.";
$error_accion_ms[3]= "El Nivel de Acceso ha de ser numérico.";
$error_accion_ms[4]= "El Usuario ya está registrado.";

$error_cod = $_GET['error'];
echo "<div align='center'>$error_accion_ms[$error_cod]</div><br>";

}

$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
mysql_select_db("$sql_db") or die(mysql_error());

$registros = 10;

if (@!$pagina=$_GET[pagina]) { 
    $inicio = 0; 
    $pagina = 1; 
} 
else { 
    $inicio = ($pagina - 1) * $registros; 
} 

if (!isset($_GET['accion'])){
$usuario_consulta = mysql_query("SELECT * FROM $sql_tabla") or die("No se pudo realizar la consulta a la Base de datos");
$total_registros = mysql_num_rows($usuario_consulta); 
$usuario_consulta = mysql_query("SELECT * FROM $sql_tabla ORDER BY us_id ASC LIMIT $inicio, $registros") or die("No se pudo realizar la consulta a la Base de datos");
$total_paginas = ceil($total_registros / $registros);            

cabeceraHTML();

echo <<< HTML

<table width="500" border="1" cellspacing="5" cellpadding="4" bordercolor="#C2382B" align="center">
  <tr>
    <th colspan="4" bgcolor="#C2382B">
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><font color="#FFFFFF">
        Gesti&oacute;n de Usuarios</font></b></font><br>
        <a href="index.php"><font color="#FFFFFF"><strong>[Regresar]</strong></font></a>
        </div> 
    </th>
	
	<th colspan="4" bgcolor="#FFFFFF">
      <div align="center"><img src="../imgs/iconos/usuarios.png">
        </div> 
    </th>
  </tr>
  <tr bgcolor="#C2382B">
    <td width="8%">
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">N°
        </font></b></div>
    </td>
    <td width="30%">
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">Usuario
        </font></b></div>
    </td>
    <td width="24%">
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">Nivel
        </font></b></div>
    </td>
	<td width="24%">
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">Estatus
        </font></b></div>
    </td>
    <td width="32%" bgcolor="#C2382B">
    <div align="center"><font color="#C2382B"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">Opciones</font></b></div></td>
  </tr>

HTML;

while($resultados = mysql_fetch_array($usuario_consulta)) {
if($resultados[us_tipo]==0){
$tipouser="Administrador";}
if($resultados[us_tipo]==1){
$tipouser="Usuario";}
if($resultados[us_estatus]==1){
$userestatus="Activo";}
if($resultados[us_estatus]==2){
$userestatus="Inactivo";}
$numero=$numero+1;
echo <<< HTML
<tr>
    <td width="8%" bgcolor="#C2382B"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">$numero</font></div></td>
    <td width="30%" bgcolor="#FFFFEA"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">$resultados[us_login]</font></div></td>
    <td width="24%" bgcolor="#FFFFEA"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">$tipouser</font></div></td>
    <td width="24%" bgcolor="#FFFFEA"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">$userestatus</font></div></td>
	<td width="32%" bgcolor="#FFFFFF"> 
      <div align="center"><a title="Eliminar" onclick="return confirm('Desea Borrar el Registro');" href="$pag?accion=borrar&id=$resultados[us_id]"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#C2382B"><img src="../imgs/iconos/eliminar.png" width="15" height="15" border="0" ></font></a>
       <font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#C2382B">|</font><a title="Modificar" href="$pag?accion=nivel&id=$resultados[us_id]"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#C2382B"><img src="../imgs/iconos/documentacion.gif" width="15" height="15" border="0" ></font></a><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#C2382B">|</font><a title="Restablecer Cuenta" href="$pag?accion=cambiarpws&id=$resultados[us_id]"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#C2382B"><img src="../imgs/iconos/seguridad.gif" width="15" height="15" border="0" ></font></a></div>
    </td>
  </tr>
HTML;

}
	

mysql_free_result($usuario_consulta);


echo "<tr bgcolor='#C2382B'>";
 echo "<td width='32%' bgcolor='#FFFFFF' align='center' colspan='6'>";
  echo "<div>";

if(($pagina) > 1) {

echo "<a title='Anterior' href='$pag?pagina=".($pagina-1)."'><img src='../imgs/iconos/prev.gif' width='20' height='20' border='0'></a>";

}

echo "<a title='Agregar Usuario' href='$pag?accion=nuevo'><img src='../imgs/iconos/addusuarios.gif' width='30' height='30' border='0'></a>";
$total=$pagina;

if(($pagina) < $total_paginas ) { 

echo "<a title='Siguiente' href='$pag?pagina=".($pagina+1)."'><img src='../imgs/iconos/next.gif' width='20' height='20' border='0'></a>";

}		

   
echo"</div></td></tr>";
echo"<tr>";
echo "<td width='32%' bgcolor='#FFFFFF' align='center' colspan='6'>";
echo "<div>";
  
	echo "<b>Pagina: ".$pagina."</b> "; 

echo"</div></td></tr>";
echo "</table>";

mysql_close();
}
if (isset($_GET['id'])){

if ($_GET['accion']=="borrar"){
$usuarios_consulta = mysql_query("SELECT us_id FROM $sql_tabla") or die(mysql_error());
$total_registros = mysql_num_rows ($usuarios_consulta);
mysql_free_result($usuarios_consulta);

if ($total_registros == 1){
header ("Location: $pag?error=0");
exit;
}

$id_borrar= $_GET['id'];
mysql_query("DELETE FROM $sql_tabla WHERE us_id=$id_borrar") or die(mysql_error());
mysql_close();

header ("Location: $pag");
exit;

}

if ($_GET['accion']=="nivel"){
include "cabecera.php";
cabeceraHTML();
$anio=date("Y");
$mese=date("m");
$dia=date("d");
$hora=date("H")-1;
$minuto=date("i");
$fecha=$anio."-".$mese."-".$dia." ".$hora.":".$minuto;
$id_mod_nivel= $_GET['id'];
$usuario_consulta = mysql_query("SELECT * FROM $sql_tabla WHERE us_id=$id_mod_nivel") or die("No se pudo realizar la consulta a la Base de datos");

while($resultados = mysql_fetch_array($usuario_consulta)) {
if($resultados[us_tipo]==0){
$tipouser="Administrador";}
if($resultados[us_tipo]==1){
$tipouser="Usuario";}
if($resultados[us_estatus]==1){
$userestatus="Activo";}
if($resultados[us_estatus]==2){
$userestatus="Inactivo";}

echo <<< HTML
<form method="post" action="$pag?accion=editarnivel">

<input type="hidden" name="id" value="$resultados[us_id]">


<table width="350" border="0" cellspacing="2" cellpadding="2" align="center" bordercolor="#C2382B">
    <tr>
      <th colspan="2" height="30" bgcolor="#C2382B">
        <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">
          Modificar Usuarios</font></b></div>
		  <a href="$pag"><font color="#FFFFFF">[Cancelar]</font></a>
      </th>
    </tr>
    <tr bgcolor="#FFFFEA">
      <td >
        <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Usuario
          </font></div>
      </td>
      <td width="192" align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#0000CC">$resultados[us_login]</font>
        </font></b></td>
    </tr>
    <tr bgcolor="#FFFFEA">
      <td>
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nombre : </font></div>
      </td>
      <td width="192" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="nombre" class="imputbox" size="25" maxlength="30" value="$resultados[us_nombre]">
        </font></b></td>
    </tr>
<tr bgcolor="#FFFFEA">
      <td >
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Apellido : </font></div>
      </td>
      <td width="192" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="apellido" class="imputbox" size="25" maxlength="30" value="$resultados[us_apellido]">
        </font></b></td>
    </tr>
	<tr bgcolor="#FFFFEA">
      <td >
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">C&eacute;dula : </font></div>
      </td>
      <td width="192" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="cedula" class="imputbox" size="25" maxlength="30" value="$resultados[us_cedula]">
        </font></b></td>
    </tr>
	<tr bgcolor="#FFFFEA">
      <td >
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Direcci&oacute;n : </font></div>
      </td>
      <td width="192" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <textarea name="direccion" cols="22" class="imputbox">$resultados[us_direccion]</textarea>
		
        </font></b></td>
    </tr>
	<tr bgcolor="#FFFFEA">
      <td >
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Télefono Hab.
          : </font></div>
      </td>
      <td width="192" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="telefono" class="imputbox" size="25" maxlength="30" value="$resultados[us_telefono]">
		</font></b></td>
    </tr>
	<tr bgcolor="#FFFFEA">
      <td >
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Télefono Cel.
          : </font></div>
      </td>
      <td width="192" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="celular" class="imputbox" size="25" maxlength="30" value="$resultados[us_celular]">
		</font></b></td>
    </tr>
	
    
    <tr bgcolor="#FFFFEA">
      <td width="135">
        <div  align="left" ><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nivel de Acceso : </font></div>
      </td>
      <td width="192" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <select name="nuevonivelacceso">
		<option value="$resultados[us_tipo]" selected>$tipouser</option>
		<option value="0">Administrador</option>
		<option value="1">Usuario</option>
		</select>
		
        </font></b></td>
    </tr>
	<tr bgcolor="#FFFFEA">
      <td >
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nuevo
          Estatus : </font></div>
      </td>
      <td width="192" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <select name="estatus">
		<option value="$resultados[us_estatus]" selected>$userestatus</option>
		<option value="1">Activo</option>
		<option value="2">Inactivo</option>
		</select>
		
        </font></b></td>
    </tr>
    <tr bgcolor="#FFFFEA">
      <td colspan="2" height="40">
        <div align="center">
          <input type="submit" name="Submit" value="  Actualizar  " class="botones" >
        </div>
      </td>
    </tr>
  </table>
</form>
HTML;
}
mysql_free_result($usuario_consulta);
mysql_close();
}

}

if ($_GET['accion']=="editarnivel"){
$id=$_POST['id'];
$nivelnuevo=$_POST['nuevonivelacceso'];
$us_cedula=$_POST['cedula'];
$us_nombre=$_POST['nombre'];
$us_apellido=$_POST['apellido'];
$us_telefono=$_POST['telefono'];
$us_celular=$_POST['celular'];
$us_direccion=$_POST['direccion'];
$us_estatus=$_POST['estatus'];
if ($nivelnuevo==""){
header ("Location: $pag?accion=nivel&id=$id&error=1");
exit;
}

mysql_query("UPDATE $sql_tabla SET us_nombre='$us_nombre',us_apellido='$us_apellido',us_cedula='$us_cedula',
us_direccion='$us_direccion',us_telefono='$us_telefono',us_celular='$us_celular',
us_tipo='$nivelnuevo',us_fmodificacion='$fecha',us_estatus='$us_estatus' WHERE us_id=$id") or die(mysql_error());
mysql_close ();
header ("Location: $pag");
exit;
}

if ($_GET['accion']=="cambiarpws"){
include "cabecera.php";
cabeceraHTML();
$anio=date("Y");
$mese=date("m");
$dia=date("d");
$hora=date("H");
$minuto=date("i");
$fecha=$anio."-".$mese."-".$dia." ".$hora.":".$minuto;
$id_mod_nivel=$_GET['id'];
if($id_mod_nivel==""){
$id_mod_nivel= $_SESSION['usuario_id'];
}
$usuario_consulta = mysql_query("SELECT * FROM $sql_tabla WHERE us_id=$id_mod_nivel") or die("No se pudo realizar la consulta a la Base de datos");
while($resultados = mysql_fetch_array($usuario_consulta)) {
if($resultados[us_tipo]==0){
$tipouser="Administrador";}
if($resultados[us_tipo]==1){
$tipouser="Usuario";}
if($resultados[us_estatus]==1){
$userestatus="Activo";}
if($resultados[us_estatus]==2){
$userestatus="Inactivo";}

echo <<< HTML
<form method="post" action="$pag?accion=editarcuenta">

<input type="hidden" name="id" value="$resultados[us_id]">


<table width="360" border="0" cellspacing="2" cellpadding="2" align="center" bordercolor="#C2382B">
    <tr>
      <th colspan="2" height="30" bgcolor="#C2382B">
        <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">
          Restablecer Cuenta</font></b></div>
		  <a href="$pag"><font color="#FFFFFF">[Cancelar]</font></a>
      </th>
    </tr>
    <tr bgcolor="#FFFFEA">
      <td width="185">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Usuario
          : </font></div>
      </td>
      <td width="192"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#0000CC">$resultados[us_login]</font>
        </font></b></td>
    </tr>
    <tr bgcolor="#FFFFEA">
      <td width="185">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password anterior
          : </font></div>
      </td>
      <td width="192"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="password" name="nombre" class="imputbox" size="25" maxlength="30" value="md5($resultados[us_password])" readonly="true">
        </font></b></td>
    </tr>
<tr bgcolor="#FFFFEA">
      <td width="185">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password Nuevo
          : </font></div>
      </td>
      <td width="192" ><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="password" name="password1" class="imputbox" size="25" maxlength="30" value="" >
        </font></b></td>
    </tr>
<tr bgcolor="#FFFFEA">
      <td width="185">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Confirmar Password
          : </font></div>
      </td>
      <td width="192"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="password" name="password2" class="imputbox" size="25" maxlength="30" value="" >
        </font></b></td>
    </tr>

    <tr bgcolor="#FFFFEA">
      <td width="185">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
          Nivel de Acceso : </font></div>
      </td>
      <td width="192"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <select name="nuevonivelacceso">
		<option value="$resultados[us_tipo]" selected>$tipouser</option>
		<option value="0">Administrador</option>
		<option value="1">Usuario</option>
		</select>
		
        </font></b></td>
    </tr>
	<tr bgcolor="#FFFFEA">
      <td width="185">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nuevo
          Estatus : </font></div>
      </td>
      <td width="192"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <select name="estatus">
		<option value="$resultados[us_estatus]" selected>$userestatus</option>
		<option value="1">Activo</option>
		<option value="2">Inactivo</option>
		</select>
		
        </font></b></td>
    </tr>
    <tr bgcolor="#FFFFEA">
      <td colspan="2" height="40">
        <div align="center">
          <input type="submit" name="Submit" value="  Actualizar  " class="botones" >
        </div>
      </td>
    </tr>
  </table>
</form>
HTML;
}
mysql_free_result($usuario_consulta);
mysql_close();
}

if ($_GET['accion']=="editarcuenta"){

$id=$_POST['id'];
if($id==""){
$id= $_SESSION['usuario_id'];
}
$nivelnuevo=$_POST['nuevonivelacceso'];
$pass1=$_POST['password1'];
$pass2=$_POST['password2'];
$us_estatus=$_POST['estatus'];
if ($nivelnuevo==""){
header ("Location: $pag?accion=cambiarpws&id=$id&error=1");
exit;
}

if ($pass1=="" or $pass2=="") {
header ("Location: $pag?accion=cambiarpws&error=1");
exit;
}

if ($pass1 != $pass2){
header ("Location: $pag?accion=cambiarpws&error=2");
exit;
}

$usuario=stripslashes($usuario);
$pass1 = md5($pass1);


mysql_query("UPDATE $sql_tabla SET us_password='$pass1',us_tipo='$nivelnuevo',us_estatus='$us_estatus' WHERE us_id=$id") or die(mysql_error());
mysql_close ();
header ("Location: index.php");
exit;
}



if ($_GET['accion']=="nuevo"){
include "cabecera.php";
cabeceraHTML();

echo <<< HTML

<form method="post" action="$PHP_SELF?accion=hacernuevo">

  <table width="350" border="1" cellspacing="2" cellpadding="2" align="center" bordercolor="#C2382B">
    <tr>
      <th colspan="2" height="30" bgcolor="#C2382B">
        <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">
          Registro de Usuarios</font></b></div>
      <a href="index.php"><font color="#FFFFFF">[Cancelar]</font></a>
	  </th>
	  
    </tr>
    <tr bgcolor="#FFFFCC">
      <td width="40%">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Usuario
          : </font></div>
      </td>
      <td width="60%" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="usuarionombre" class="imputbox" maxlength="20" size="26">
        </font></b></td>
    </tr>
	<tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nombres
          : </font></div>
      </td>
      <td width="170" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="nombre" class="imputbox" maxlength="25" size="26">
        </font></b></td>
    </tr>
		<tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Apellidos
          : </font></div>
      </td>
      <td width="170" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="apellido" class="imputbox" maxlength="25" size="26">
        </font></b></td>
    </tr>
</tr>
	<tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Cédula
          : </font></div>
      </td>
      <td width="170" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="cedula" class="imputbox" maxlength="11" size="26" onKeyUp="validar(this,'numeros')">
        </font></b></td>
    </tr>
	<tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Télefono
          : </font></div>
      </td>
      <td width="170" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="telefono" class="imputbox" maxlength="11" size="26" onKeyUp="validar(this,'numeros')">
        </font></b></td>
    </tr>
	<tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Celular
          : </font></div>
      </td>
      <td width="170" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="celular" class="imputbox" maxlength="11" size="26" onKeyUp="validar(this,'numeros')">
        </font></b></td>
    </tr>
	<tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Dirección
          : </font></div>
      </td>
      
	  <td width="170" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <textarea name="direccion" cols="23"  rows="3" wrap="on" onKeyDown="valida_longitud()" onKeyUp="valida_longitud()"></textarea>
		 <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#990000">Restan :<input type="text" name="caracteres1"  value="254" maxlength="3" size="1" readonly="true"></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#990000"><input type="hidden" name="caracteres"  maxlength="3" size="1" readonly="true">
        </font></b></td>
    </tr>
	
    <tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password
          : </font></div>
      </td>
      <td width="170" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="password" name="password1" class="imputbox" maxlength="15" size="26">
        </font></b></td>
    </tr>
    <tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Confirmar : </font></div>
      </td>
      <td width="170" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="password" name="password2" class="imputbox" maxlength="15" size="26">
        </font></b></td>
    </tr>
    <tr bgcolor="#FFFFCC" >
      <td width="130" >
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nivel
          de Acceso : </font></div>
      </td>
      <td width="170" align="right"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <select name="nivelacceso">
		<option value="0">Administrador</option>
		<option value="1">Usuario</option>
		</select>
		</font></b></td>
    </tr>
    <tr bgcolor="#FFFFCC">
      <td colspan="2" height="40">
        <div align="center">
          <input type="submit" name="Submit" value="  Registrar  " class="botones" >
        </div>
      </td>
    </tr>
  </table>
</form>
HTML;
}

if ($_GET['accion']=="hacernuevo"){

$anio=date("Y");
$mese=date("m");
$dia=date("d");
$hora=date("H");
$minuto=date("i");
$fecha=$anio."-".$mese."-".$dia." ".$hora.":".$minuto;

$us_nombre=$_POST['nombre'];
$us_apellido=$_POST['apellido'];
$us_cedula=$_POST['cedula'];
$us_direccion=$_POST['direccion'];
$usuario=$_POST['usuarionombre'];
$pass1=$_POST['password1'];
$pass2=$_POST['password2'];
$nivel=$_POST['nivelacceso'];
$us_creadopor=$_SESSION['usuario_login'];
$us_telefono=$_POST['telefono'];
$us_celular=$_POST['celular'];

if ($pass1=="" or $pass2=="" or $usuario=="" or $nivel=="" or $us_cedula=="" or $us_nombre=="" or $us_apellido=="") {
header ("Location: $pag?accion=nuevo&error=1");
exit;
}

if ($pass1 != $pass2){
header ("Location: $pag?accion=nuevo&error=2");
exit;
}

if (!eregi("[0-9]",$nivel)){
header ("Location: $pag?accion=nuevo&error=3");
exit;
}

$usuarios_consulta = mysql_query("SELECT us_id FROM $sql_tabla WHERE us_login='$usuario'") or die(mysql_error());
$total_encontrados = mysql_num_rows ($usuarios_consulta);
mysql_free_result($usuarios_consulta);

if ($total_encontrados != 0) {
header ("Location: $pag?accion=nuevo&error=4");
exit;
}

$usuario=stripslashes($usuario);
$pass1 = md5($pass1);

mysql_query("INSERT INTO tbl_usuario (us_login,us_password,us_nombre,us_apellido,us_cedula,us_direccion,us_telefono,us_celular,us_tipo,us_creadopor,us_fcreacion)values('$usuario','$pass1','$us_nombre','$us_apellido','$us_cedula','$us_direccion','$us_telefono','$us_celular','$nivel','$us_creadopor','$fecha')") or die(mysql_error());
mysql_close();

header ("Location: $pag");
exit;

}

?>
</BODY>
</HTML>

