<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<style type="text/css">
<!--
body {
	background-image: url();
	background-repeat: repeat;
	text-align: center;
}
.Estilo2 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
}
.Estilo3 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.style1 {
	color: #333
}
.style2 {
	font-size: 9px;
	font-weight: bold;
	color: #FFFFFF;
	text-align: center;
}
.style3 {
	font-size: 9px;
	font-weight: bold;
}
-->
</style>


<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script>
<!--
function validarLogin(){
  // primera comprobación
  if(UserLogin.login.value == ''){
    // informamos del error
    alert('Inserta tu nombre de usuario');
    // seleccionamos el campo incorrecto
    UserLogin.login.focus();
    return false;
  }
  // segunda comprobacion
  if(UserLogin.password.value == ''){
    alert('Inserta tu contraseña');
     UserLogin.password.focus();
    return false;
  }
  return true;
}
//-->
</script>



<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
</head>
<body topmargin="5">
<table width="860" border="0" align="center"   background="imagenes/centro2.png">
  <tr>
    <td width="150" height="296" align="right" valign="middle"><a href="https://host.ids4.com:2096/"></a></td>
    
    
    <td width="342"><table width="300" border="0" align="left" cellpadding="0" >
        
        
        
        
        <form name="UserLogin" method="post" action="ValidarLogin.php" onSubmit="return validarLogin();">
	 
	  <tr>
	    <td width="85%" height="38" align="right" class="Negro"><span class="Estilo26 Estilo3"> Usuario: </span><span id="sprytextfield1">
	      <label>
	        <input type="text" name="login" id="login">
	        </label>
	      <span class="textfieldRequiredMsg"></span></span>&nbsp;&nbsp;</td>
	  </tr>
	  <tr>
		<td width="85%" height="38" align="right" class="Negro"><div align="right"><span class="Estilo26 Estilo3">Contrase&ntilde;a: </span><span id="sprypassword1">
		  <label>
		    <input type="password" name="password" id="password">
		    </label>
		  <span class="passwordRequiredMsg"></span></span>&nbsp;&nbsp;</div></td>
	  </tr>
	  <tr>
		<td height="35" colspan="2" align="center" ><div align="right">
		  <input type="submit" class="mybutton" name="SubLogin" value="Entrar">
		  <input type="reset" class="mybutton" name="SubLogin2" value="Limpiar" />
		  </div></td>
        
       
	  </tr>
      </form> 
	  </table>
    </td>
    <td width="150" align="left" valign="top">&nbsp;</td>
  </tr>
</table>


<table width="860" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="860" height="100"  background="imagenes/footer_bg.png"><div align="center" class="Estilo2 style1"></div></td>

    </td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
//-->
</script>
</body>
</html>
