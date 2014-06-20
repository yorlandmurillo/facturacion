<?php
	ini_set('session.bug_compat_warn',0);  
	session_start();
	include("includes/sesiones.php");
	include("funciones.php");
	include("conexion.php");
	$login = "";
	$password = "";
	$mensaje  = "";
  
	if(isset($_REQUEST['login'])) 
		$login=$_REQUEST["login"];
	
	if(isset($_REQUEST['password'])) 
		$password=$_REQUEST["password"];
	
	
	$user_sql  = "select usr_passwd,usr_user,usr_login,usr_cedula from  inv_user where usr_login = '$login' And   usr_passwd= '$password'";
	$user_rs    = mysql_query($user_sql) or die (mysql_error());
	$user_rows  = mysql_num_rows($user_rs); 
	$row = mysql_fetch_array($user_rs);
	if($login != ""  && $user_rows != 0)
    {
		if(is_null($row[2]))
		{
			$mensaje = "PERMISO";
		}    
		else
		{
			if(strtoupper($password) != $row[0])  	
			{
				$mensaje = "CLAVE";
			}
			else
			{
				$login_usuario = $row[2];                         
				$_SESSION['datos_usuario'] =  $login_usuario;
				$_SESSION['login_usuario'] =  $login_usuario;                    
				$_SESSION['Nusuario'] = $row[1]; 
				$_SESSION['sucursal'] = $password; 
				$mensaje = "OK";
			}  
       }   
    }
	else  
    {
		$mensaje = "NOT_OK";
	}
?>
<HTML>
  <HEAD>
    <SCRIPT type="text/javascript" language="JavaScript">
		function Inicio()
		{
			var w=true;
			if((document.getElementById("mensaje").value == "NOT_OK")&&(w))
			{
				alert("No hay ningun usuario registrado con ese login");
				w=false;
			}
			else if((document.getElementById("mensaje").value == "CLAVE")&&(w))
			{
				alert("El password es incorrecto");
				w=false;
			}
			else if((document.getElementById("mensaje").value == "PERMISO")&&(w))
			{
				alert("El usuario que indica no tinene permiso para ingresar\nSi necesita acceso contacte al admisitrador");
				w=false;
			}
			
			if(!w)
			{
			//	alert("ALGO SALIO MAL");
			   frmRedirec.action="inventario.php";
			   frmRedirec.submit();
			}
			else if(document.getElementById("mensaje").value == "OK")
			{
				//alert("TODO BIEN");
				frmRedirec.submit();
			}
       }
    </SCRIPT>
  </HEAD>   
  <BODY onLoad="Inicio();">
    <FORM name="frmRedirec"  id="frmRedirec" action="inventario.php"  method="post">
      <INPUT type="hidden" name="mensaje"    id="mensaje"    Value="<?PHP echo $mensaje;?>">
      <INPUT type="hidden" name="opcion"    id="opcion"    Value="principal">
    </FORM>
  </BODY>
</HTML>
<?PHP
  mysql_close($link);
?>
