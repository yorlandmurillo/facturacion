<?php
include 'conec.php';
if($_POST["submit"] && !empty($_FILES['file']))
{

// obtenemos el archivo enviado por post
	$consulta=$_FILES['file'];

// leemos el contenido del archivo
	$archivo_nuevo = file_get_contents($consulta['tmp_name']);
// die($archivo_nuevo);
//Cargar nuevas tablas

//Se realizan las sustituciones de cadena una por una, en cada sustitucion se renombre el archivo pra guardar los cambios anteriores.

	$tablas1=str_replace("tbl_autor","tbl_autor2",$archivo_nuevo);
	$tablas2=str_replace("tbl_editorial","tbl_editorial2",$tablas1);
	$tablas3=str_replace("tbl_inventario","tbl_inventario2",$tablas2);

//$tablas3 contiene todas sustituciones realizadas a $archivo_nuevo.sql_editorial
//Borrar registos de bienes de la distribuidora en las tablas secundarias
	mysql_query("delete from tbl_autor2 WHERE id_autor not like 'A%' and id_autor not like 'B%'",$db);
	mysql_query("delete from tbl_editorial2 where id_editorial <> '5555' and id_editorial <> '4444' and id_editorial <> '3333' and id_editorial <> '2222' and id_editorial <> '1111'",$db);
	mysql_query("delete from tbl_inventario2 where editorial <> '5555' and editorial <> '4444' and editorial <> '3333' and editorial <> '2222' and editorial <> '1111'",$db);
	

$linea=1;
//se separan las sentencias de inserción
	foreach(explode(";",$tablas3) as $sql_index=>$query)
	{
		//mysql_query($query)or die($query."-*->".mysql_error());
		mysql_query($query);
		$linea++;
		
	}
//actualizacion de precio e iva en las tablas secundarias
	$modificaiva2 = @mysql_query("UPDATE tbl_inventario2 SET precio= '26.7857142857142976000000000000000' where precio between '26' and '27' and iva=2",$db);
	$modificaiva3 = @mysql_query("update tbl_inventario2 set iva=1 WHERE iva=0",$db);
	$modificaiva4 = @mysql_query("update tbl_inventario2 set iva=1 WHERE lib_articulo='L'",$db); 
	
	
	$sql_cuenta="SELECT count(*) FROM `tbl_inventario`";
	$result_cuenta=mysql_query($sql_cuenta, $db);
	while($row = mysql_fetch_row($result_cuenta))
	{
		$filas_inv=$row[0];
	}

	$sql_cuenta2="SELECT count(*) FROM `tbl_inventario2`";
	$result_cuenta2=mysql_query($sql_cuenta2, $db);
	while($row2 = mysql_fetch_row($result_cuenta2))
	{
		$filas_inv2=$row2[0];
	}
	
	$sql_fecha_inventario="select date(`fecha_creacion`) from tbl_inventario ORDER BY date(`fecha_creacion`) desc limit 0,1";
	$result_fecha_inventario = mysql_query($sql_fecha_inventario,$db) or die("Busca registro fecha inventario<br>".mysql_error());
	if ($row_fecha = mysql_fetch_array($result_fecha_inventario)) 
	{
		$fecha_vieja=$row_fecha[0];
	}
	
	$sql_fecha_inventario="select date(`fecha_creacion`) from tbl_inventario2 ORDER BY date(`fecha_creacion`) desc limit 0,1";
	$result_fecha_inventario = mysql_query($sql_fecha_inventario,$db) or die("Busca registro fecha inventario<br>".mysql_error());
	if ($row_fecha = mysql_fetch_array($result_fecha_inventario)) 
	{
		$fecha_nueva=$row_fecha[0];
	}



	date_default_timezone_set('America/Caracas');
	$fechaLarga = date("Y-m-d h:i:s",time());
	$fecha1=explode("/", $_POST["txtfecdes"]);
	$fecha4=explode("-", $fecha_vieja);
	$fecha_anterior=$fecha4[2]."/".$fecha4[1]."/".$fecha4[0]." 00:00:00";
	
	

	
	$fecha1=substr($fechaLarga, 0, 10);
	$fecha3=substr($fechaLarga, 10);
	$fecha2=explode("-", $fecha1);
	$fechahora=$fecha2[2]."/".$fecha2[1]."/".$fecha2[0].$fecha3;
	
	$file="actualizacion.html";
	$fp = fopen($file,"w");
	fclose($fp);
	$ar=fopen("actualizacion.html","a") or die("Problemas en la creacion"); 
	fputs($ar,"\n\n"); 	
	
	
	fputs($ar,"<div align=center>");
	fputs($ar,"<P><font size=5><b>LIBRERIAS DEL SUR</b></font></P>");
	fputs($ar,"<P><font size=5><b>ACTUALIZACION DEL INVENTARIO</b></font></P>");
	fputs($ar,"<P><font size=5><b>".$fecha_anterior." a ".$fechahora."</b></font></P>");
	
	
	if($fecha_nueva >= $fecha_vieja)
	{
		?>
	<!--	<P><font size=5><b>RECUERDE GUARDAR ESTE ARCHIVO</b></font></P>
		<P><font size=5><b>ARTICULOS CON PRECIOS NUEVOS</b></font></P>
		</div>-->
		<?
		fputs($ar,"<P><font size=5><b>RECUERDE GUARDAR ESTE ARCHIVO</b></font></P>");
		fputs($ar,"<P><font size=5><b>ARTICULOS CON PRECIOS NUEVOS</b></font></P>");
		fputs($ar,"</div>");
		
		$sql="SELECT tbl_inventario2.cod_producto, tbl_inventario2.descripcion,tbl_inventario2.editorial,
				tbl_inventario.precio as precio_anterior,tbl_inventario2.precio as precio_nuevo, tbl_inventario.iva,tbl_inventario2.iva
				FROM tbl_inventario,tbl_inventario2
				WHERE tbl_inventario.cod_producto=tbl_inventario2.cod_producto
				and (tbl_inventario.precio<>tbl_inventario2.precio or tbl_inventario.iva<>tbl_inventario2.iva)";

		$result = mysql_query($sql,$db) or die("Busca titulos con nuevos precios<br>".mysql_error());
		$nf=mysql_num_rows($result);

		if ($myrow = mysql_fetch_array($result)) 
		{
			$total_ARTICULOS=0;
			$Totalaumento=0;
			$Totaldisminuye=0;
			$i=0;
			?>
			<!--	<table border=1>
				<tr><th><b>N</b></th><th><b>CODIGO</b></th><th><b>TITULO</b></th><th><b>EDITORIAL</b></th><th><b>PRECIO ANTERIOR</b></th><th><b>PRECIO NUEVO</b></th><th><b>PORCENTAJE</th></tr>-->
			<?
			fputs($ar,"<table border=1>");
			fputs($ar,"<tr><th><b>N</b></th><th><b>CODIGO</b></th><th><b>TITULO</b></th><th><b>EDITORIAL</b></th><th><b>PRECIO ANTERIOR</b></th><th><b>PRECIO NUEVO</b></th><th><b>PORCENTAJE</th></tr>");
			do 
			{
				$s=$i+1;	

				$sql_editorial="select editorial from tbl_editorial2 where id_editorial='$myrow[2]'";
				$result_editorial = mysql_query($sql_editorial,$db) or die("Busca editorial<br>".mysql_error());
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
			//	echo "<tr><td><b>".$s."</b></td><td><b>".$myrow['0']."</b></td><td><b>".$myrow['1']."</b></td><td><b>".$editorial."</b></td><td><b>".number_format($myrow['3'],2,",",".").$iva1."</b></td><td><b>".number_format($myrow['4'],2,",",".").$iva2."</b></td><td><b>".$porcentaje."</b></td></tr>";
				fputs($ar,"<tr><td><b>".$s."</b></td><td><b>".$myrow['0']."</b></td><td><b>".$myrow['1']."</b></td><td><b>".$editorial."</b></td><td><b>".number_format($myrow['3'],2,",",".").$iva1."</b></td><td><b>".number_format($myrow['4'],2,",",".").$iva2."</b></td><td><b>".$porcentaje."</b></td></tr>");

				$la_data[$i]=array(' N'=>$s,'CODIGO'=>$myrow['0'],'TITULO'=>$myrow['1'],'EDITORIAL'=>$editorial,'PRECIO ACTUAL'=>number_format($myrow['3'],2,",",".").$iva1,'PRECIO NUEVO'=>number_format($myrow['4'],2,",",".").$iva2,' %'=>$porcentaje);
					
					$total_ARTICULOS=$total_ARTICULOS+$myrow['1'];
				
					
					$i++;
			} while ($myrow = mysql_fetch_array($result));

			?>
			<!--	</table>
				<div align=center>
				<P><font size=5><b>TOTAL ARTICULOS CON PRECIOS NUEVOS: <?echo $s;?></b></font></P>
				<P><font size=5><b><b>ARTICULOS QUE AUMENTARON DE PRECIO: <?echo $Totalaumento;?></b></font></P>
				<P><font size=5><b>ARTICULOS QUE BAJARON DE PRECIO: <?echo $Totaldisminuye;?></b></font></P>
				</div>
				<br><br>-->
			<?
			fputs($ar,"</table>");
			fputs($ar,"<div align=center>");
			fputs($ar,"<P><font size=5><b>TOTAL ARTICULOS CON PRECIOS NUEVOS: ".$s."</b></font></P>");	
			fputs($ar,"<P><font size=5><b><b>ARTICULOS QUE AUMENTARON DE PRECIO: ".$Totalaumento."</b></font></P>");
			fputs($ar,"<P><font size=5><b>ARTICULOS QUE BAJARON DE PRECIO: ".$Totaldisminuye."</b></font></P>");
			fputs($ar,"</div><br><br>");		
		}
		else
		{
			?>
			<!--	<div align="center"><font size='5' color=red><b>NO SE ENCONTRARON ARTICULOS CON PRECIOS NUEVOS PARA ACTUALIZAR</b></font></div>-->
				
			<?	
			fputs($ar,"<div align=center><font size=5 color=red><b>NO SE ENCONTRARON ARTICULOS CON PRECIOS NUEVOS PARA ACTUALIZAR</b></font></div><br><br>");	
		}
		?>
	<!--	<div align=center><P><font size=5><b>ARTICULOS NUEVOS EN EL INVENTARIO</b></font></P></div>-->
		<?
		fputs($ar,"<div align=center><P><font size=5><b>ARTICULOS NUEVOS EN EL INVENTARIO</b></font></P></div>");	
		$sql_ARTICULOS="SELECT tbl_inventario2.*
					FROM tbl_inventario2
					LEFT JOIN tbl_inventario
					USING (cod_producto)
					WHERE tbl_inventario.cod_producto IS NULL
					ORDER BY tbl_inventario2.editorial";
		$result_ARTICULOS = mysql_query($sql_ARTICULOS,$db) or die($sql_ARTICULOS."<br>Busca nuevos ARTICULOS<br>".mysql_error());
		$nf=mysql_num_rows($result_ARTICULOS);
		if ($myrow1 = mysql_fetch_array($result_ARTICULOS)) 
		{
		//	$total_ARTICULOS=0;
			$i=0;
				?>
			<!--	<table border=1>
				<tr><th><b>N</b></th><th><b>CODIGO</b></th><th><b>TITULO</b></th><th><b>EDITORIAL</b></th><th><b>PRECIO</b></th><th><b>FECHA_CREACION</b></th></tr>-->
			<?
			fputs($ar,"<table border=1>");
			fputs($ar,"<tr><th><b>N</b></th><th><b>CODIGO</b></th><th><b>TITULO</b></th><th><b>EDITORIAL</b></th><th><b>PRECIO</b></th><th><b>FECHA_CREACION</b></th></tr>");
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
				$result_editorial = mysql_query($sql_editorial,$db) or die("Busca editorial<br>".mysql_error());
				do {
					$editorial=$myrow_editorial[0];
			} while ($myrow_editorial = mysql_fetch_array($result_editorial));
			
		//	echo "<tr><td><b>".$s."</b></td><td><b>".$myrow1['0']."</b></td><td><b>".$myrow1['4']."</b></td><td><b>".$editorial."</b></td><td><b>".number_format($myrow1['7'],2,",",".").$iva."</b></td><td><b>".$fecha."</b></td></tr>";
				fputs($ar,"<tr><td><b>".$s."</b></td><td><b>".$myrow1['0']."</b></td><td><b>".$myrow1['4']."</b></td><td><b>".$editorial."</b></td><td><b>".number_format($myrow1['7'],2,",",".").$iva."</b></td><td><b>".$fecha."</b></td></tr>");
				
				$total_ARTICULOS=$total_ARTICULOS+$myrow1['1'];
				$i++;
			} while ($myrow1 = mysql_fetch_array($result_ARTICULOS));
			?>
			<!--	</table>
				<div align=center>
				<P><font size=5><b>TOTAL ARTICULOS NUEVOS: <?echo $s;?></b></font></P>
				</div><br><br>-->
	<?		
			
			fputs($ar,"</table>");
			fputs($ar,"<div align=center>");
			fputs($ar,"<P><font size=5><b>TOTAL ARTICULOS NUEVOS: ".$s."</b></font></P>");
			fputs($ar,"</div><br><br>");
			
		}
		else
		{
			?>
			<!--	<div align=center><font size=3><b>NO SE ENCONTRARON RESULTADOS EN EL PERÍODO DE CONSULTA</b></font></div>
						<br><br>-->
	<?		
		fputs($ar,"<div align=center><font size=5 color=red><b>NO SE ENCONTRARON ARTICULOS CON PRECIOS NUEVOS PARA ACTUALIZAR</b></font></div><br><br>");
		}
		fputs($ar,"<div align=center><font size=5><a href=actualiza_inventario.php>REGRESAR</a></font></div>");		
		fclose($ar); 
		
		
			//Reemplaza registros en tbl_inventario
			$sql_inventario="SELECT * FROM tbl_inventario2 where editorial <> '5555' and editorial <> '4444' and editorial <> '3333' and editorial <> '2222' and editorial <> '1111'";
			$result_inventario = mysql_query($sql_inventario,$db) or die("Busca registro inventario<br>".mysql_error());
			$nf=mysql_num_rows($result_inventario);
			$num=0;
			if ($myrow2 = mysql_fetch_array($result_inventario)) 
			{
				//Se vacia primero la tabla inventario
				mysql_query("delete from tbl_inventario where editorial <> '5555' and editorial <> '4444' and editorial <> '3333' and editorial <> '2222' and editorial <> '1111'",$db);
				do 
				{
					$cod_producto=$myrow2[0];
					$isbn=str_replace("'","",$myrow2[2]);
					$cod_barra=str_replace("'","",$myrow2[3]);
					$descripcion=str_replace("'","",$myrow2[4]);
					
					$sql_inventario_actual="SELECT * FROM tbl_inventario where cod_producto='$myrow2[0]'";
					$result_inventario_actual = mysql_query($sql_inventario_actual,$db) or die("Busca registro inventario_actual<br>".mysql_error());
					$nf_inventario_actual=mysql_num_rows($result_inventario_actual);
					if($nf_inventario_actual==0)
					{
						$num++;
						$sql_inserta_inventario="INSERT INTO `tbl_inventario` (`cod_producto`, `lib_articulo`, `isbn`, `cod_barra`, `descripcion`, `aut_codigo`, `editorial`, `precio`, `coleccion`, `iva`, `fecha_creacion`) VALUES
											('$myrow2[0]', '$myrow2[1]', '$isbn', '$cod_barra', '$descripcion', '$myrow2[5]', '$myrow2[6]', '$myrow2[7]', '$myrow2[8]', '$myrow2[9]','$myrow2[10]')";
					
						//echo $num."-*-".$sql_inserta_inventario."<br>";
						$status_inserta_inventario=mysql_query($sql_inserta_inventario,$db) or die($sql_inserta_inventario."<br>Insertando inventario<br>".mysql_error());
					}
					
				} while ($myrow2 = mysql_fetch_array($result_inventario));

			}
			
			//Reeemplaza registros en tbl_editorial
			$sql_editorial="SELECT id_editorial,editorial, direccion, prv_ptoref, telf_oficina1, telf_fax, prv_rif, prv_nit, pag_web, prv_contac, correo, prv_tipop FROM tbl_editorial2
				where id_editorial <> '5555' and id_editorial <> '4444' and id_editorial <> '3333' and id_editorial <> '2222' and id_editorial <> '1111'";
			$result_editorial = mysql_query($sql_editorial,$db) or die("Busca registro editorial<br>".mysql_error());
			$nf=mysql_num_rows($result_editorial);
			if ($myrow3 = mysql_fetch_array($result_editorial)) 
			{
				mysql_query("delete from tbl_editorial where id_editorial <> '5555' and id_editorial <> '4444' and id_editorial <> '3333' and id_editorial <> '2222' and id_editorial <> '1111'",$db);
				do 
				{
					$sql_editorial_actual="SELECT id_editorial,editorial, direccion, prv_ptoref, telf_oficina1, telf_fax, prv_rif, prv_nit, pag_web, prv_contac, correo, prv_tipop FROM tbl_editorial
									where id_editorial='$myrow3[0]'";
					$result_editorial_actual = mysql_query($sql_editorial_actual,$db) or die("Busca registro editorial<br>".mysql_error());
					$nf_editorial_actual=mysql_num_rows($result_editorial_actual);
					if($nf_editorial_actual==0)
					{
						//Se vacia primero la tabla editorial
						$sql_inserta_editorial="INSERT INTO `tbl_editorial` (`id_editorial`,`editorial`, `direccion`, `prv_ptoref`, `telf_oficina1`, `telf_fax`, `prv_rif`, `prv_nit`, `pag_web`, `prv_contac`, `correo`, `prv_tipop`) VALUES
												('$myrow3[0]', '$myrow3[1]', '$myrow3[2]', '$myrow3[3]', '$myrow3[4]', '$myrow3[5]', '$myrow3[6]', '$myrow3[7]', '$myrow3[18]', '$myrow3[9]', '$myrow3[10]', '$myrow3[11]')";
						$status_inserta_editorial=mysql_query($sql_inserta_editorial,$db) or die($sql_inserta_editorial."<br>Insertando editorial<br>".mysql_error());
					}
					
				} while ($myrow3 = mysql_fetch_array($result_editorial));
			}
			
			
			
			//Reeemplaza registros en tbl_autor
			$sql_autor="SELECT id_autor,aut_nombre,aut_pais FROM tbl_autor2 WHERE id_autor not like 'A%' and id_autor not like 'B%'";
			$result_autor = mysql_query($sql_autor,$db) or die("Busca registro autor<br>".mysql_error());
			$nf=mysql_num_rows($result_autor);
			if ($myrow4 = mysql_fetch_array($result_autor)) 
			{
				//Se vacia primero la tabla autor
				mysql_query("delete from tbl_autor WHERE id_autor not like 'A%' and id_autor not like 'B%'",$db);
				do 
				{
					$sql_autor_actual="SELECT id_autor,aut_nombre,aut_pais FROM tbl_autor where id_autor='$myrow4[0]'";
					$result_autor_actual = mysql_query($sql_autor,$db) or die("Busca registro autor actual<br>".mysql_error());
					$nf_autor_actual=mysql_num_rows($result_autor_actual);
					if($nf_editorial_actual==0)
					{
						$sql_inserta_autor="INSERT INTO `tbl_autor` (`id_autor`,`aut_nombre`, `aut_pais`) VALUES('$myrow4[0]', '$myrow4[1]', '$myrow4[2]')";
						$status__inserta_autor=mysql_query($sql_inserta_autor,$db) or die($sql_inserta_autor."<br>Insertando autor<br>".mysql_error());
					}	
				} while ($myrow4 = mysql_fetch_array($result_autor));
			}
	
	}
	else
	{
			echo "Fecha nueva:".$fecha_nueva." - Fecha anterior:".$fecha_vieja;
		?>
			<b><div align='center'><font  size='5'>NO FUE POSIBLE ACTUALIZAR EL INVENTARIO <BR>EL LISTADO A CARGAR ES MÁS ANTIGUO QUE EL EXISTENTE</font></div></b><BR>
		<?
	}
	?>
	<script >
					location.href="actualizacion.html";
				</script>
	<br><br>
	<div align="center"><font size='5'><a href="actualiza_inventario.php">REGRESAR</a></font></div>
	<?
	
		
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
<b><div align='center'><font color='blue' size='5'>ACTUALIZACION DE LIBROS</font></div></b><BR>
<b><div align='center'><font color='blue' size='5'>SELECCIONE EL ARCHIVO A CARGAR</font></div></b><BR>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <label>
 <b><div align='center'> <input type="file" name="file" />
  </label>
  <p>
    <label>
    <input type="submit" name="submit" value="Enviar" /></div>
    </label>
  </p>
</form>
<b><div align='center'><font color='red' size='7'>IMPORTANTE: RECUERDE GUARDAR EL REPORTE GENERADO</font></div></b><BR>
</body>
</html>

<?
}
