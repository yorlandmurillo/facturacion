<? 
require("../admin/session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=2;// definir nivel de acceso para esta página.
$origen=getenv("HTTP_REFERER"); 
if ($_SESSION['usuario_nivel'] < $nivel_acceso){
echo '<div align="center"><h1>Usted no tiene pérmiso para acceder a esta página</h1></div>';
echo '<div align="center"><input type="button" value="Salir" onClick="Javascript:location.reload(true)" style="border:double;background-color:#990000;text-align:center;color:#FFFFFF;" ></div>';
/*echo '<script language="javascript">window.close(this)</script>';*/
//Header ("Location: ../admin/login.php?error_login=5");
//exit;
}else{
$obj=new manejadordb;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registro de Clientes</title>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/sha1.js"></script>
</head>
<a href="<?= $origen; ?>" style="border:double;background-color:#FFFFFF;text-decoration:inherit;border-bottom-style:double"><img src='../imagenes/salir.png' border="0"> Regresar</a>
<style>
.campo{
    border:double;
	border-color:#CCCCCC;
	background-color:#FFFFFF;

}
.sinborde{
    border:none;
}

input,textarea { border: 1px solid silver;text-align:right; }
input.error {padding-right: 16px; border: 1px solid red; background-image: url(imagenes/warning_obj.gif); background-position: right; background-repeat: no-repeat;}
input:focus {border: 1px solid red; background-color:#EFEFEF;}

td.activetab {
    background-color: silver;
}

</style>

<body>
<div align="center" id="resultado"></div>
<form id="usuario" name="usuario" action="">
<br>
<table width="580" align="center" id="table1" widtd="398" style="border:double;border-color:#990000;border-bottom-style:groove;">
  <tr>
    <th height="32" colspan="4">Datos Personales </th>
  </tr>
  <tr>
    <th width="127" height="32"> <div align="left">C&eacute;dula/NIF:</div></th>
    <td width="136" class="campo"><div align="right">
      <input type="text" name="uscedula" id="uscedula" size="22" maxlengtd="15" value="0" onkeyup="validarnum(this,1)" class="sinborde"/>
    </div></td>
    <th width="112"><div align="left">Nombre:</div></th>
    <td width="179" class="campo" ><div align="right">
      <input type="text" name="usnombre" id="usnombre" size="33" maxlengtd="100" class="sinborde" />
    </div></td>
  </tr>
  <tr>
    <th ><div align="left">Apellido:</div></th>
    <td class="campo" >
	<div align="right">
      <input type="text" name="usapellido" id="usapellido" size="22" maxlengtd="100" class="sinborde" />
    </div>	</td>
    <th><div align="left">Sucursal: </div></th>
    <td class="campo" >
    <select name="sucursal" id="sucursal">
	<?	  
	  $sql="SELECT * FROM tbl_sucursal"; 
	   	 $sql.=" order by id_sucursal 	"; 
        	$r = $obj->consultar($sql);
			 	
     	while ($row = mysql_fetch_assoc($r)) 
     	{    
			echo '<option value='.$row["id_sucursal"].' >'.utf8_encode($row["sucursal"]).'</option>';
		
		}	 
	   
	  ?>
      </select>	</td>
  </tr>
  <tr>
    <th height="32" colspan="4" >Datos de Seguridad </th>
  </tr>
  <tr>
    <th><div align="left">Usuario:</div></th>
    <td class="campo" ><div align="right">
      <input type="text" name="uslogin" id="uslogin" size="22" class="sinborde" />
    </div></td>
    <th><div align="left">Nivel: </div></th>
    <td class="campo" >
      <div align="left">
        <select name="nivel" id="nivel">
	<?	  
	  $sql="SELECT * FROM tbl_nivel "; 
	   	 $sql.=" order by id_nivel 	"; 
        	$r = $obj->consultar($sql);
			 	
     	while ($row = mysql_fetch_assoc($r)) 
     	{    
			echo '<option value='.$row["id_nivel"].' >'.utf8_encode($row["nivel"]).'</option>';
		
		}	 
	   
	  ?>
        </select>
        </div></td>
  </tr>
  <tr>
    <th><div align="left">Contrase&ntilde;ar: </div></th>
    <td class="campo" ><div align="right">
      <input type="password" name="uspassword" id="uspassword" size="22" class="sinborde" >
    </div></td>
    <th colspan="2" rowspan="2">Todos los campos son obligatorios</th>
    </tr>
  <tr>
    <th> <div align="left">Confirmar: </div></th>
    <td class="campo" ><div align="right">
      <input type="password" name="uspasswordc" id="uspasswordc" size="22" class="sinborde" />
    </div></td>
    </tr>
  <tr>
    <td widtd="83">&nbsp;</td>
    <td widtd="90">&nbsp;</td>
    <td widtd="209" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="6"> <input type="submit" name="enviar" id="enviar" value="Enviar" onclick="nuevousuario(); return false"></th>
  </tr>
</table>
</form>
</body>
</html>
<? }?>