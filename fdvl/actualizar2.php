<?php
include 'conec_local.php';
include 'conec_distribuidora.php';

	
	
	$buscasucursal="select sucursal from tbl_distinventario where cantidad > '0' limit 0,1";
	$resultsucursal=mysql_query($buscasucursal,$db_local) or die($buscasucursal."<br>Buscando libro<br>".mysql_error());
	//$nf_buscalibro=mysql_num_rows($result_buscalibro);
	 while($row = mysql_fetch_row($resultsucursal))
	  {
		$id_sucursal=$row[0];
	  }
	  //$id_sucursal='0000';

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
			$result_buscalibro=mysql_query($buscalibro,$db_local) or die($buscalibro."<br>Buscando libro<br>".mysql_error());
			$nf_buscalibro=mysql_num_rows($result_buscalibro);
			if($nf_buscalibro==0)
			{
				$myrow_12[4]=str_replace("'", "\'", $myrow_12[4]);
				$sql_inserta_distininventario="INSERT INTO `tbl_distinventario` (`cod_producto`, `isbn`, `cod_barra`, `autor`, `descripcion`, `editorial`, `tomo`, `presentacion`, `sucursal`, `condicion`, `cantidad`, `descuento`, `FECHA_NOTA_ENTREGA`) VALUES
				('$cod_producto', '$myrow_12[1]', '$myrow_12[2]', '$myrow_12[3]', '$myrow_12[4]', '$myrow_12[5]', '$myrow_12[6]', '$presentacion', '$id_sucursal', 0000000001, 0, 0, '$fechaLarga')";
				$status_inserta_distnventario=mysql_query($sql_inserta_distininventario,$db_local) or die($sql_inserta_distininventario."<br>Insertando distinventario<br>".mysql_error());
			}
		} while ($myrow_12 = mysql_fetch_array($result_inventario_distr));
		
	}
	
	
	
	
	
	//Reemplaza registros en tbl_inventario2
	$sql_inventario_distr="select lib_codart,lib_articulo,lib_codsib,lib_codbarra,lib_descri,aut_codigo,prv_codpro,lib_preact,col_colecc,lib_iva,lib_fecha,lib_hora from inv_libros";
	$result_inventario_distr = mysql_query($sql_inventario_distr) or die("Busca registro inventario<br>".mysql_error());
	$nf_inventario_distr=mysql_num_rows($result_inventario_distr);
	//die($nf_inventario_distr);
	if ($myrow_12 = mysql_fetch_array($result_inventario_distr)) 
	{
		//Se vacia primero la tabla inventario2
	//	mysql_query("TRUNCATE TABLE tbl_inventario2",$db_local);
		mysql_query("delete from tbl_inventario2",$db_local);
		
		do 
		{
			$fecha_creacion=$myrow_12[10]." ".$myrow_12[11];
			$myrow_12[4]=str_replace("'", "\'", $myrow_12[4]);
			$sql_inserta_inventario2="INSERT INTO `tbl_inventario2` (`cod_producto`, `lib_articulo`, `isbn`, `cod_barra`, `descripcion`, `aut_codigo`, `editorial`, `precio`, `coleccion`, `iva`, `fecha_creacion`) VALUES
									('$myrow_12[0]', '$myrow_12[1]', '$myrow_12[2]', '$myrow_12[3]', '$myrow_12[4]', '$myrow_12[5]', '$myrow_12[6]', '$myrow_12[7]', '$myrow_12[8]', '$myrow_12[9]', '$fecha_creacion')";
			$status_inserta_inventario2=mysql_query($sql_inserta_inventario2,$db_local) or die("<br>Insertando inventario2<br>".mysql_error());
		} while ($myrow_12 = mysql_fetch_array($result_inventario_distr));
		$modificaiva2 = @mysql_query("UPDATE tbl_inventario2 SET precio= '26.7857142857142976000000000000000' where precio between '26' and '27' and iva=2",$db_local);
		$modificaiva3 = @mysql_query("update tbl_inventario2 set iva=1 WHERE iva=0",$db_local);
		$modificaiva4 = @mysql_query("update tbl_inventario2 set iva=1 WHERE lib_articulo='L'",$db_local); 
	}


//Editorial
	$sql_editorial_distr="select prv_codpro, prv_nombre,prv_direc, prv_ptoref, prv_telef, prv_fax, prv_rif, prv_nit, prv_web, prv_contac, prv_mail, prv_tipop from inv_provee";
	$result_editorial_distr = mysql_query($sql_editorial_distr,$db_distr) or die("Busca registro editorial<br>".mysql_error());
	//$nf_distr=mysql_num_rows($result_editorial_distr);
	//die("-*->".$nf_distr);
	if ($myrow_13 = mysql_fetch_array($result_editorial_distr)) 
	{
		//Se vacia primero la tabla editorial2
		//mysql_query("TRUNCATE TABLE tbl_editorial2",$db_local);
		mysql_query("delete from tbl_editorial2",$db_local);
		do 
		{
			$sql_inserta_editorial2="INSERT INTO tbl_editorial2 (id_editorial,editorial, direccion, prv_ptoref, telf_oficina1, telf_fax, prv_rif, prv_nit, pag_web, prv_contac, correo, prv_tipop) VALUES
									('$myrow_13[0]', '$myrow_13[1]', '$myrow_13[2]', '$myrow_13[3]','$myrow_13[4]', '$myrow_13[5]', '$myrow_13[6]', '$myrow_13[7]', '$myrow_13[8]', '$myrow_13[9]', '$myrow_13[10]', '$myrow_13[11]')";
			$status_inserta_editorial2=mysql_query($sql_inserta_editorial2,$db_local) or die("$sql_inserta_editorial".mysql_error());
		} while ($myrow_13 = mysql_fetch_array($result_editorial_distr));
	}


//Autor
	
	$sql_autor_distr="select aut_codigo,aut_nombre,aut_pais from inv_autor";
	$result_autor_distr = mysql_query($sql_autor_distr,$db_distr) or die("Busca registro autor en la distribuidora<br>".mysql_error());
	$nf=mysql_num_rows($result_autor_distr);
	if ($myrow_14 = mysql_fetch_array($result_autor_distr)) 
	{
		//Se vacia primero la tabla autor
	//	mysql_query("TRUNCATE TABLE tbl_autor2",$db_local);
		mysql_query("delete from tbl_autor2",$db_local);
		do 
		{
			$myrow_14[1]=str_replace("'", "\'", $myrow_14[1]);
			$sql_inserta_autor2="INSERT INTO tbl_autor2 (id_autor,aut_nombre,aut_pais) VALUES
								('$myrow_14[0]', '$myrow_14[1]', '$myrow_14[2]')";
			$status_inserta_autor2=mysql_query($sql_inserta_autor2,$db_local) or die("<br>Insertando autor2<br>".mysql_error());
			
		} while ($myrow_14 = mysql_fetch_array($result_autor_distr));
	}
	
	
	
	//Se procede a llenar las tablas de trabajo de la base de datos
	
	$sql_cuenta2="SELECT count(*) FROM `tbl_inventario2`";
	$result_cuenta2=mysql_query($sql_cuenta2, $db_local);
	while($row2 = mysql_fetch_row($result_cuenta2))
	{
		$filas_inv2=$row2[0];
	}
	
	$sql_fecha_inventario="select date(`fecha_creacion`) from tbl_inventario ORDER BY date(`fecha_creacion`) desc limit 0,1";
	$result_fecha_inventario = mysql_query($sql_fecha_inventario,$db_local) or die("Busca registro fecha inventario<br>".mysql_error());
	if ($row_fecha = mysql_fetch_array($result_fecha_inventario)) 
	{
		$fecha_vieja=$row_fecha[0];
	}

	date_default_timezone_set('America/Caracas');
	$fechaLarga = date("Y-m-d h:i:s",time());
	$fecha1=explode("/", $_POST["txtfecdes"]);
	
	$fecha4=explode("-", $fecha_vieja);
	$fecha_anterior=$fecha4[2]."/".$fecha4[1]."/".$fecha4[0]." 00:00:00";
	
	

	
	$fecha1=substr($fechaLarga, 0, 10);
	$fecha3=substr($fechaLarga, 10);
	$fecha2=explode("-", $fecha1);
	//die($fecha2[2]."/".$fecha2[2]."/".$fecha2[0].$fecha3);
	$fechahora=$fecha2[2]."/".$fecha2[1]."/".$fecha2[0].$fecha3;
	//die($fecha3);
	
	?>
	<div align=center>
	<P><font size=5><b>LIBRERIAS DEL SUR</b></font></P>
	<P><font size=5><b>ACTUALIZACION DEL INVENTARIO</b></font></P>
	<P><font size=5><b><?echo $fecha_anterior." a ".$fechahora;?></b></font></P>
	<P><font size=5><b>RECUERDE GUARDAR ESTE ARCHIVO</b></font></P>
	<P><font size=5><b>ARTICULOS CON PRECIOS NUEVOS</b></font></P>
	</div>
	
	<?
	
	
	
	$sql="SELECT tbl_inventario2.cod_producto, tbl_inventario2.descripcion,tbl_inventario2.editorial,
			tbl_inventario.precio as precio_anterior,tbl_inventario2.precio as precio_nuevo, tbl_inventario.iva,tbl_inventario2.iva
			FROM tbl_inventario,tbl_inventario2
			WHERE tbl_inventario.cod_producto=tbl_inventario2.cod_producto
			and (tbl_inventario.precio<>tbl_inventario2.precio or tbl_inventario.iva<>tbl_inventario2.iva)";

	$result = mysql_query($sql,$db_local) or die("Busca titulos con nuevos precios<br>".mysql_error());
	$nf=mysql_num_rows($result);

	if ($myrow = mysql_fetch_array($result)) 
	{
		$total_ARTICULOS=0;
		$Totalaumento=0;
		$Totaldisminuye=0;
		$i=0;
		?>
			<table border=1>
			<tr><th><b>N</b></th><th><b>CODIGO</b></th><th><b>TITULO</b></th><th><b>EDITORIAL</b></th><th><b>PRECIO ANTERIOR</b></th><th><b>PRECIO NUEVO</b></th><th><b>PORCENTAJE</th></tr>
		<?
		do 
		{
			$s=$i+1;	

			$sql_editorial="select editorial from tbl_editorial2 where id_editorial='$myrow[2]'";
			$result_editorial = mysql_query($sql_editorial,$db_local) or die("Busca editorial<br>".mysql_error());
			do {
				$editorial=$myrow_editorial[0];
			} while ($myrow_editorial = mysql_fetch_array($result_editorial));
			$diferencia=$myrow['4']-$myrow['3'];
			if($diferencia > 0)
			{
				$Totalaumento++;
				$flecha="<IMG SRC=imagenes/flechaarriba.jpg>";
			}
			elseif($diferencia < 0)
			{
				$Totaldisminuye++;
				$flecha="<IMG SRC='imagenes/flechaabajo.jpg'>";
			}
			if($myrow['3'] !=0)
			{
				$porcent1=($diferencia*100)/($myrow['3']);
				$porcentaje=number_format($porcent1,2,",",".")."% ".$flecha;
			}
			else
			{
				$porcentaje="-";
			}
			
			if($myrow['5']==2)
				$iva1=" + IVA";
			else
				$iva1="";
				
			if($myrow['6']==2)
				$iva2=" + IVA";
			else
				$iva2="";
			echo "<tr><td><b>".$s."</b></td><td><b>".$myrow['0']."</b></td><td><b>".$myrow['1']."</b></td><td><b>".$editorial."</b></td><td><b>".number_format($myrow['3'],2,",",".").$iva1."</b></td><td><b>".number_format($myrow['4'],2,",",".").$iva2."</b></td><td><b>".$porcentaje."</b></td></tr>";

			$la_data[$i]=array(' N'=>$s,'CODIGO'=>$myrow['0'],'TITULO'=>$myrow['1'],'EDITORIAL'=>$editorial,'PRECIO ACTUAL'=>number_format($myrow['3'],2,",",".").$iva1,'PRECIO NUEVO'=>number_format($myrow['4'],2,",",".").$iva2,' %'=>$porcentaje);
				
				$total_ARTICULOS=$total_ARTICULOS+$myrow['1'];
			
				
				$i++;
		} while ($myrow = mysql_fetch_array($result));

		?>
			</table>
			<div align=center>
			<P><font size=5><b>TOTAL ARTICULOS CON PRECIOS NUEVOS: <?echo $s;?></b></font></P>
			<P><font size=5><b><b>ARTICULOS QUE AUMENTARON DE PRECIO: <?echo $Totalaumento;?></b></font></P>
			<P><font size=5><b>ARTICULOS QUE BAJARON DE PRECIO: <?echo $Totaldisminuye;?></b></font></P>
			</div>
			<br><br>
		<?		
	}
	else
	{
		?>
			<div align="center"><font size='5' color=red><b>NO SE ENCONTRARON ARTICULOS CON PRECIOS NUEVOS PARA ACTUALIZAR</b></font></div>
			<br><br>
			<div align="center"><font size='5'><a href="inventario.php?p=operativo">REGRESAR</a></font></div>
		<?		
	}
	?>
	<div align=center><P><font size=5><b>ARTICULOS NUEVOS EN EL INVENTARIO</b></font></P></div>
		<?
	$sql_ARTICULOS="SELECT tbl_inventario2.*
				FROM tbl_inventario2
				LEFT JOIN tbl_inventario
				USING (cod_producto)
				WHERE tbl_inventario.cod_producto IS NULL
				ORDER BY tbl_inventario2.editorial";
//	die($sql_ARTICULOS);
	$result_ARTICULOS = mysql_query($sql_ARTICULOS,$db_local) or die("Busca nuevos ARTICULOS<br>".mysql_error());
	$nf=mysql_num_rows($result_ARTICULOS);
//	die($nf);
	if ($myrow1 = mysql_fetch_array($result_ARTICULOS)) 
	{
	//	$total_ARTICULOS=0;
		$i=0;
			?>
			<table border=1>
			<tr><th><b>N</b></th><th><b>CODIGO</b></th><th><b>TITULO</b></th><th><b>EDITORIAL</b></th><th><b>PRECIO</b></th><th><b>FECHA_CREACION</b></th></tr>
		<?
		do 
		{
			$s=$i+1;
			$fecha1=substr($myrow1['10'], 0, 10);
			$fecha2=explode("-", $fecha1);
			$fecha=$fecha2[2]."/".$fecha2[1]."/".$fecha2[0];
			
			if($myrow['9']==2)
					$iva=" + IVA";
			else
				$iva="";	
				
			$sql_editorial="select editorial from tbl_editorial2 where id_editorial='$myrow1[6]'";
			$result_editorial = mysql_query($sql_editorial,$db_local) or die("Busca editorial<br>".mysql_error());
			do {
				$editorial=$myrow_editorial[0];
		} while ($myrow_editorial = mysql_fetch_array($result_editorial));
		
		echo "<tr><td><b>".$s."</b></td><td><b>".$myrow1['0']."</b></td><td><b>".$myrow1['4']."</b></td><td><b>".$editorial."</b></td><td><b>".number_format($myrow1['7'],2,",",".").$iva."</b></td><td><b>".$fecha."</b></td></tr>";
			$total_ARTICULOS=$total_ARTICULOS+$myrow1['1'];
			$i++;
		} while ($myrow1 = mysql_fetch_array($result_ARTICULOS));
		?>
			</table>
			<div align=center>
			<P><font size=5><b>TOTAL ARTICULOS NUEVOS: <?echo $s;?></b></font></P>
			</div>
			

	<br><br>
	<div align="center"><font size='5'><a href="inventario.php?p=operativo">REGRESAR</a></font></div>
<?		
		
	}
	else
	{
		?>
						<div align=center><font size=3><b>NO SE ENCONTRARON RESULTADOS EN EL PERÍODO DE CONSULTA</b></font></div>
					<br><br>
	<div align="center"><font size='5'><a href="inventario.php?p=operativo">REGRESAR</a></font></div>
<?		
	}


	/*	if($filas_inv2 > $filas_inv)
		{*/
		
			//Reemplaza registros en tbl_inventario
			$sql_inventario="SELECT * FROM tbl_inventario2";
			$result_inventario = mysql_query($sql_inventario,$db_local) or die("Busca registro inventario<br>".mysql_error());
			$nf=mysql_num_rows($result_inventario);
		//	die($nf);
			if ($myrow2 = mysql_fetch_array($result_inventario)) 
			{
				//Se vacia primero la tabla inventario
				//mysql_query("TRUNCATE TABLE tbl_inventario",$db_local);
				mysql_query("delete from tbl_inventario where editorial <> '5555' and editorial <> '4444' and editorial <> '3333' and editorial <> '2222' and editorial <> '1111'",$db_local);
				
				do 
				{
					$sql_inserta_inventario="INSERT INTO `tbl_inventario` (`cod_producto`, `lib_articulo`, `isbn`, `cod_barra`, `descripcion`, `aut_codigo`, `editorial`, `precio`, `coleccion`, `iva`, `fecha_creacion`) VALUES
											('$myrow2[0]', '$myrow2[1]', '$myrow2[2]', '$myrow2[3]', '$myrow2[4]', '$myrow2[5]', '$myrow2[6]', '$myrow2[7]', '$myrow2[8]', '$myrow2[9]','$myrow2[10]')";
					$status__inserta_inventario=mysql_query($sql_inserta_inventario,$db_local) or die("<br>Insertando inventario<br>".mysql_error());
				} while ($myrow2 = mysql_fetch_array($result_inventario));

			}
			
			
			//Reeemplaza registros en tbl_editorial
			$sql_editorial="SELECT id_editorial,editorial, direccion, prv_ptoref, telf_oficina1, telf_fax, prv_rif, prv_nit, pag_web, prv_contac, correo, prv_tipop FROM tbl_editorial2";
			$result_editorial = mysql_query($sql_editorial,$db_local) or die("Busca registro editorial<br>".mysql_error());
			$nf=mysql_num_rows($result_editorial);
		//	die($nf);
			if ($myrow3 = mysql_fetch_array($result_editorial)) 
			{
				//mysql_query("TRUNCATE TABLE tbl_editorial",$db_local);
				mysql_query("delete from tbl_editorial where id_editorial <> '5555' and id_editorial <> '4444' and id_editorial <> '3333' and id_editorial <> '2222' and id_editorial <> '1111'",$db_local);
				do 
				{
					//Se vacia primero la tabla editorial
					$sql_inserta_editorial="INSERT INTO `tbl_editorial` (`id_editorial`,`editorial`, `direccion`, `prv_ptoref`, `telf_oficina1`, `telf_fax`, `prv_rif`, `prv_nit`, `pag_web`, `prv_contac`, `correo`, `prv_tipop`) VALUES
											('$myrow3[0]', '$myrow3[1]', '$myrow3[2]', '$myrow3[3]', '$myrow3[4]', '$myrow3[5]', '$myrow3[6]', '$myrow3[7]', '$myrow3[18]', '$myrow3[9]', '$myrow3[10]', '$myrow3[11]')";
					//die($sql_inserta_editorial);
					$status_inserta_editorial=mysql_query($sql_inserta_editorial,$db_local) or die("$sql_inserta_editorial".mysql_error());
					//die($sql_inserta_editorial);
				} while ($myrow3 = mysql_fetch_array($result_editorial));
			}
			
			
			
			//Reeemplaza registros en tbl_autor
			$sql_autor="SELECT id_autor,aut_nombre,aut_pais FROM tbl_autor2";
			$result_autor = mysql_query($sql_autor,$db_local) or die("Busca registro autor<br>".mysql_error());
			$nf=mysql_num_rows($result_autor);
			if ($myrow4 = mysql_fetch_array($result_autor)) 
			{
				//Se vacia primero la tabla autor
		//		mysql_query("TRUNCATE TABLE `tbl_autor`",$db_local);
				mysql_query("delete from tbl_autor WHERE id_autor not like 'A%' and id_autor not like 'B%'",$db_local);
				do 
				{
					$sql_inserta_autor="INSERT INTO `tbl_autor` (`id_autor`,`aut_nombre`, `aut_pais`) VALUES
										('$myrow4[0]', '$myrow4[1]', '$myrow4[2]')";
					$status__inserta_autor=mysql_query($sql_inserta_autor,$db_local) or die("<br>Insertando autor<br>".mysql_error());
					
				} while ($myrow4 = mysql_fetch_array($result_autor));
			}
			
			
	/*	}
		else
		{
		?>
			<div align=center><font size=3><b>NO SE ACTUALIZO EL INVENTARIO</b></font></div>
			<div align=center><font size=3><b><b>EL ARCHIVO DE ACTUALIZACION TIENE MENOS O IGUAL FILAS QUE EL ACTUAL</b></b></font></div>
			<br><br>
			<div align="center"><font size='5'><a href="inventario.php?p=operativo">REGRESAR</a></font></div>
		<?		
		
		}*/
	
	/*	
		mysql_close($link2A);
		mysql_free_result($resultA);
		mysql_close($linkA);
	*/

?>
