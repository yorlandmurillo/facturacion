<html>
<title>&Aacute;rea de Administraci&oacute;n </title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<head>

</head>
<style type="text/css">
<!--

.botones {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #000000 ; border-top-width: 1pix; border-right-width: 1pix; border-bottom-width: 1pix; border-left-width: 1pix;}


.button {

	border-color: #bd9494;
	background-color: #f0f0f0;
	color: #000;
	<!--background-image: url(imagenes/bgBtnGray.gif);-->
	vertical-align: middle;
	}

.buttonOn, .button:hover, .button:focus, .buttonOn:focus {
	background-color: #cc6666;
	border-color: #777777;
	}
.button[disabled] {
	border-color: #c1c1c1;
	background-color: #f0f0f0;
	color: #000;
	background-image: url(imagenes/bgBtnGray.gif);
}


input,select {
	border-color: #eac3c3;
	background-color: #ffffff;
	}

input:focus,textarea:focus, select:focus {
	background-color: #fff;
	border-color: #dd9e9e;
	 }



.imputbox {  font-size: 10pt; color: #000099; background-color: #CCFFCC; font-family: Verdana, Arial, Helvetica, sans-serif; border: 1pix #000000 solid; border-color: #000000 solid; font-weight: normal}
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
	background-color:#990000}
.Estilo2 {color: #990000}
-->
</style>
<body bgcolor="#FFFFFF" onLoad="nombreequipo()">
<span></span><span></span>
<table width="743" height="541" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 0.5px #990000;">
  <tr>
    <td valign="top">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td width="3548" height="64"><div align="center" class="Estilo1" id="name">
              <? 

function getRemoteInfo(){
   
    echo $_SERVER['HTTP_HOST'];
}

//getRemoteInfo(); 

?>
              <img src="imagenes/libsur.png" width="862" height="133"></div></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="202" border="0" cellspacing="0" cellpadding="0" align="center" >
              <tr>
                <td width="220"><table width=100% height="135" border=0 align="center" cellpadding="0" cellspacing="0" style="border:dashed 1px #990000;">
                    <form action="index.php" method="post">
                      <tr bgcolor="#990000">
                        <td  height="19" colspan="2" bgcolor="#FFFFFF"><div align="center" ><img src="imagenes/txt_sesion.png" width="100%" height="38"></div></td>
                      </tr>
                      <tr>
                        <td height="66" colspan="2" bgcolor="#E6E6E6">
						
						<div align="center">
                            <div align="center">
                              <?
                          // Mostrar error de Autentificaci&oacute;n.
                          include ("admin/aut_mensaje_error.inc.php");
                          if (isset($_GET['error_login'])){
                              $error=$_GET['error_login'];
                          echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1' color='#990000'>Error: $error_login_ms[$error]";
                          }
                         ?>
                            </div>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
                              <tr>
                                <td width="39%" align="left" bgcolor="#E6E6E6"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Usuario: </font></div></td>
                                <td width="61%" bgcolor="#E6E6E6"><div align="left">
                                    <input type="text" name="user" size="20" style="elevation:lower">
                                </div></td>
                              </tr>
                              <tr>
                                <td width="39%" bgcolor="#E6E6E6"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Contrase&ntilde;a: </font></div></td>
                                <td width="61%" bgcolor="#E6E6E6"><div align="left">
                                    <input type="password" name="pass" size="20" >
                                </div></td>
                              </tr>
                            </table>
                        </div></td>
                      </tr>
                      <tr valign="middle">
                        <td colspan="2" height="25" bgcolor="#E6E6E6"><div align="center"><font face="Arial" color=black size=2>
                            <input name=submit type=submit value="  Entrar  " class="botones">
                        </font></div></td>
                      </tr>
                      <tr valign="middle">
                        <td colspan="2" height="25" bgcolor="#E6E6E6">&nbsp;</td>
                      </tr>
                    </form>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    <p></p></td>
  </tr>
  <tr>
    <td align="right" valign="top" style="border-top:solid 0.5px #990000;"><p class="botones">Desarrollado por la Coordinaci&oacute;n de Tecnolog&iacute;a e Inform&aacute;tica</p>    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
