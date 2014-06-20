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

@ $usuario=$_GET['usuario'];
$origen=getenv("HTTP_REFERER"); 

$query = "SELECT * FROM tbl_usuario where id_usuario=$usuario ";
$result = $obj->consultar($query);
$row = mysql_fetch_assoc($result);

if($row["us_nivel"]==1){
$nivel="<option value='1' selected='selected'>Usuario</option>";
}else $nivel="<option value='2' selected='selected'>Administrador</option>";

if($row["us_estatus"]==1){
$estatus="<option value='1' selected='selected'>Activo</option>";
}else $estatus="<option value='2' selected='selected'>Inactivo</option>";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Modificar de Clientes</title>
<script type="text/javascript" src="js/ajax.js"></script>
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

input, select,textarea    { border: 1px solid silver; }
input.error {padding-right: 16px; border: 1px solid red; background-image: url(imagenes/warning_obj.gif); background-position: right; background-repeat: no-repeat;}
input:focus {border: 1px solid red; background-color:#EFEFEF;}
td.activetab {
    background-color: silver;
}


</style>

<body>
<div align="center" id="resultado"></div>
<form id="usuario" name="usuario" action="">
<input type="hidden" name="usid" id="usid" value="<?= $row["id_usuario"];?>">
<br>
<table width="580" align="center" id="table1" widtd="398" style="border:double;border-color:#990000;border-bottom-style:groove;">
  <tr>
    <th height="32" colspan="4">Datos Personales </th>
  </tr>
  <tr>
    <th width="127" height="32"> <div align="left">C&eacute;dula/NIF:</div></th>
    <td width="136" class="campo"><div align="right">
      <input type="text" name="uscedula" id="uscedula" size="22" maxlengtd="15" value="<?= $row["cedula"];?>"  class="sinborde" readonly="true">
    </div></td>
    <th width="112"><div align="left">Nombre:</div></th>
    <td width="179" class="campo" ><div align="right">
      <input type="text" name="usnombre" id="usnombre" size="33" value="<?= utf8_encode($row["us_nombre"]);?>" class="sinborde" />
    </div></td>
  </tr>
  <tr>
    <th ><div align="left">Apellido:</div></th>
    <td class="campo" >
	<div align="right">
      <input type="text" name="usapellido" id="usapellido" size="22" value="<?= utf8_encode($row["us_apellido"]);?>" class="sinborde" >
    </div>	</td>
    <th><div align="left">Sucursal: </div></th>
    <td class="campo" >
    <select name="sucursal" id="sucursal">

	<?	  
	
	echo '<option selected="selected" value='.$row["us_sucursal"].' >'.utf8_encode($obj->setsucursal($row["us_sucursal"])).'</option>';
	
	  $sql="SELECT * FROM tbl_sucursal where id_sucursal<>0 "; 
	   	 $sql.=" order by id_sucursal 	"; 
        	$r = $obj->consultar($sql);
			 	
     	while ($suc = mysql_fetch_assoc($r)) 
     	{    
			echo '<option value='.$suc["id_sucursal"].' >'.utf8_encode($suc["sucursal"]).'</option>';
		
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
      <input type="text" name="uslogin" id="uslogin" size="22" class="sinborde" value="<?= $row["us_login"];?>" readonly="true" >
    </div></td>
    <th><div align="left">Nivel: </div></th>
    <td class="campo" >
      <div align="left">
        <select name="nivel" id="nivel">
		<? echo $nivel;?>
          <option value="1">Usuario</option>
          <option value="2">Administrador</option>
        </select>
        </div></td>
  </tr>
  
  <tr>
    <th><div align="left">Estatus: </div></th>
    <td class="campo" ><div align="left">
        <select name="estatus" id="estatus">
		<? echo $estatus;?>
          <option value="1">Activo</option>
          <option value="2">Inactivo</option>
        </select>
    </div></td>
    <td widtd="209" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="6"> <input type="submit" name="enviar" id="enviar" value="Enviar" onclick="modusuario(); return false"></th>
  </tr>
</table>
</form>
</body>
</html>
<? }?>