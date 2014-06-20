<?php
include 'conec.php';
include 'conec_distribuidora.php';
require_once("ezpdf/class.ezpdf.php");
$io_pdf=new Cezpdf('LETTER','landscape');
$io_pdf =& new Cezpdf();

if($_POST['submit'])
{ 
	    
	$buscasucursal="select sucursal from tbl_distinventario where cantidad > '0' limit 0,1";
	$resultsucursal=mysql_query($buscasucursal,$db) or die($buscasucursal."<br>Buscando libro<br>".mysql_error());
	//$nf_buscalibro=mysql_num_rows($result_buscalibro);
	 while($row = mysql_fetch_row($resultsucursal))
	  {
		$id_sucursal=$row[0];
	  }

	//Reemplaza registros en tbl_inventario2
	$sql_inventario_distr="select lib_codart,lib_codsib,lib_codbarra,UCASE(aut_nombre),lib_descri,UCASE(prv_nombre),lib_numedit,lib_present 
							from inv_libros,inv_autor, inv_provee
							WHERE inv_libros.aut_codigo=inv_autor.aut_codigo
							and inv_libros.prv_codpro=inv_provee.prv_codpro";
	$result_inventario_distr = mysql_query($sql_inventario_distr) or die("Busca registro distribuidora<br>".mysql_error());
	$nf_inventario_distr=mysql_num_rows($result_inventario_distr);
	//die($nf_inventario_distr);
	if ($myrow_12 = mysql_fetch_array($result_inventario_distr)) 
	{
		//Se vacia primero la tbl_distinventario
	//	mysql_query("TRUNCATE TABLE tbl_distinventario",$db);
		if($myrow_12[7]=='R')
			$presentacion="RUSTICA";
		elseif($myrow_12[7]=='E')
			$presentacion="EMPASTADO";
		elseif($myrow_12[7]=='N')
			$presentacion="N";
		elseif($myrow_12[7]=='U')
			$presentacion="UNICO";
		
		
		do 
		{
			$cod_producto=$myrow_12[0];
			$fechaLarga = date("Y-m-d",time());
			$buscalibro="select * from tbl_distinventario where cod_producto='$cod_producto'";
			$result_buscalibro=mysql_query($buscalibro,$db) or die($buscalibro."<br>Buscando libro<br>".mysql_error());
			$nf_buscalibro=mysql_num_rows($result_buscalibro);
			if($nf_buscalibro==0)
			{
				$myrow_12[4]=str_replace("'", "\'", $myrow_12[4]);
				$sql_inserta_distininventario="INSERT INTO `tbl_distinventario` (`cod_producto`, `isbn`, `cod_barra`, `autor`, `descripcion`, `editorial`, `tomo`, `presentacion`, `sucursal`, `condicion`, `cantidad`, `descuento`, `FECHA_NOTA_ENTREGA`) VALUES
				('$cod_producto', '$myrow_12[1]', '$myrow_12[2]', '$myrow_12[3]', '$myrow_12[4]', '$myrow_12[5]', '$myrow_12[6]', '$presentacion', '$id_sucursal', 0000000001, 0, 0, '$fechaLarga')";
				$status_inserta_distnventario=mysql_query($sql_inserta_distininventario,$db) or die($sql_inserta_distininventario."<br>Insertando distinventario<br>".mysql_error());
			}
		} while ($myrow_12 = mysql_fetch_array($result_inventario_distr));
		
	}



	

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Actualización de Inventario</title>
</head>

<body>
<b><div align='center'><font  size='5'>FUNDACION LIBRERIAS DEL SUR</font></div></b><BR>
<b><div align='center'><font color='blue' size='5'>ACTUALIZACION DE ARTICULOS</font></div></b><BR>
<form action="" method="post">  
 <font size=4><b><div align='center'><font size='5'>HAGA CLIC AQUI PARA ACTUALIZAR EL CATALOGO DE LIBROS
  <input type="submit" name="submit" value="Actualizar" />  </div></b></font>
 </form>
 <BR><BR><BR><BR><BR><BR><BR>
<b><div align='center'><font color='red' size='7'>IMPORTANTE: RECUERDE GUARDAR EL REPORTE GENERADO</font></div></b><BR>
</body>
</html>
