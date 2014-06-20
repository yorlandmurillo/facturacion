<?php
	session_start();
	include 'conec4.php';
	


	header("Content-type: application/force-download");
	header("Content-Disposition: attachment; filename=libros_firmes".'_'.date("d").'-'.date("m").'-'.date("Y").'_'.date("h").'-'.date("i").'-'.date("s").'_'.date("a").'.sql');

	$sql_editorial="SELECT *
	FROM tbl_editorial
	WHERE id_editorial='5555'";
	//die($sql_editorial);
	$result = mysql_query($sql_editorial) or die($sql_editorial."\n".mysql_error());
	$nf=mysql_num_rows($result);
	if($nf>0)
	{
		$i=0;
		do
		{
			if($i>0)
			{
			echo "INSERT INTO `tbl_editorial` (`id_editorial`, `editorial`, `direccion`, `prv_ptoref`, `telf_oficina1`, `telf_fax`, `prv_rif`, `prv_nit`, `pag_web`, `prv_contac`, `correo`, `prv_tipop`) VALUES('".trim($myrow["id_editorial"])."','".trim($myrow["editorial"])."','".trim($myrow["direccion"])."','".trim($myrow["prv_ptoref"])."','".trim($myrow["telf_oficina1"])."','".trim($myrow["correo"])."','".trim($myrow["prv_tipop"])."','".trim($myrow["prv_nit"])."','".trim($myrow["pag_web"])."','".trim($myrow["prv_contac"])."','".trim($myrow["prv_rif"])."','".trim($myrow["prv_nit"])."');\n";
			}
			$i++;
		}
		while ($myrow = mysql_fetch_array($result));

	}
	else
	{
		echo "NO SE ENCONTRARON RESULTADOS PARA ESTA CONSULTA";
	}

	//Respaldo de la tabla tbl_autor
	$sql_autor="SELECT distinct(id_autor), aut_nombre, aut_pais
	FROM tbl_autor
	WHERE id_autor like 'a%'
	order by id_autor";
	//die($sql_autor);
	$result = mysql_query($sql_autor) or die("\n".mysql_error());
	$nf=mysql_num_rows($result);
	if($nf>0)
	{
		$i=0;
		do
		{
			if($i>0)
			{
				echo "INSERT INTO `tbl_autor` (`id_autor`, `aut_nombre`, `aut_pais`) VALUES('".trim($myrow["id_autor"])."','".trim($myrow["aut_nombre"])."','".trim($myrow["aut_pais"])."');\n";
			}
			$i++;
		}
		while ($myrow = mysql_fetch_array($result));

	}
	else
	{
		echo "NO SE ENCONTRARON RESULTADOS PARA ESTA CONSULTA";
	}
	//Respaldo de la tabla tbl_inventario
	$sql_inventario="SELECT * FROM tbl_inventario WHERE editorial='5555' order by fecha_creacion,cod_producto";
	//die($sql_autor);
	$result = mysql_query($sql_inventario) or die("\n".mysql_error());
	$nf=mysql_num_rows($result);
	if($nf>0)
	{
		$i=0;
		do
		{
			if($i>0)
			{
				echo "INSERT INTO `tbl_inventario` (`cod_producto`, `lib_articulo`, `isbn`, `cod_barra`, `descripcion`, `aut_codigo`, `editorial`, `precio`, `coleccion`, `iva`, `fecha_creacion`) VALUES('".trim($myrow["cod_producto"])."','".trim($myrow["lib_articulo"])."','".trim($myrow["isbn"])."','".$myrow["cod_barra"]."','".$myrow["descripcion"]."','".$myrow["aut_codigo"]."','".$myrow["editorial"]."','".$myrow["precio"]."','".trim($myrow["coleccion"])."','".trim($myrow["iva"])."','".trim($myrow["fecha_creacion"])."');\n";
			}
			$i++;
		}
		while ($myrow = mysql_fetch_array($result));

	}
	else
	{
		echo "NO SE ENCONTRARON RESULTADOS PARA ESTA CONSULTA";
	}

?> 

