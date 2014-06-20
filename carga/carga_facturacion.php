<?php
include 'conec.php';
if($_POST["submit"] && !empty($_FILES['file']))
{

// obtenemos el archivo enviado por post
	$consulta=$_FILES['file'];

// leemos el contenido del archivo
	$archivo_nuevo = file_get_contents($consulta['tmp_name']);
	$tex1=explode("\n", $archivo_nuevo);
	$id_suc_nuevo=$_POST["id_suc_nuevo"];
//	echo $id_suc_nuevo."<br>";
	
	$i=0;
	for($i=0;$i<count($tex1);$i++)
	{
		if(strpos($tex1[$i], 'TO `tbl_sucursal`'))
		{
			//echo $tex1[$i]."<br>";
			$id_suc_actual= substr($tex1[$i], 36, 4);
		}
	}
	
	for($i=0;$i<count($tex1);$i++)
	{
		if(strpos($tex1[$i], 'TO `tbl_facturas`'))
		{
			$text2=str_replace(",".$id_suc_actual.",",",".$id_suc_nuevo.",",$tex1[$i]);
			echo $text2."<br>";
		}
		
		if(strpos($tex1[$i], 'TO `tbl_itemfactura`'))
		{
			$text3=str_replace(",".$id_suc_actual.",",",".$id_suc_nuevo.",",$tex1[$i]);
			echo $text3."<br>";
		}
		
		if(strpos($tex1[$i], 'TO `tbl_sucursal`'))
		{
			$text4=str_replace("'".$id_suc_actual."'","'".$id_suc_nuevo."'",$tex1[$i]);
			echo $text4."<br>";
		}
	}
		
}
else
{

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Actualización de Inventario</title>
</head>

<body>
<b><div align='center'><font  size='5'>FUNDACION LIBRERIAS DEL SUR</font></div></b><BR>
<b><div align='center'><font color='blue' size='5'>FACTURACION DE FERIAS Y EXPOVENTAS</font></div></b><BR>
<b><div align='center'><font color='blue' size='5'>SELECCIONE EL ARCHIVO A CARGAR</font></div></b><BR>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<div align='center'>
<table border=2>
	<tr><td align=center><b>NUEVO_ID_SUCURSAL</b></td><td align=center><b>SELECCIONE EL ARCHIVO SQL</b></td></tr>
 <tr><td align=center><input type="text" name="id_suc_nuevo" size="4" maxlength="4"></td><td align=center><input type="file" name="file" /></td></tr>
  <tr><td align=center colspan=2> <input type="submit" name="submit" value="Enviar" /></td></tr>
</table>
</div>
</form>

</body>
</html>

<?
}
