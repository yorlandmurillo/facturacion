<?php
include 'conec.php';
include 'conec_distribuidora.php';
require_once("ezpdf/class.ezpdf.php");
$io_pdf=new Cezpdf('LETTER','landscape');
$io_pdf =& new Cezpdf();

if($_POST['submit'])
{ 
	//Reemplaza registros en tbl_inventario2
	$sql_inventario_distr="select lib_codsib, lib_codbarra,prv_codpro,lib_codart,lib_descri,lib_preact,aut_codigo,col_colecc,lib_iva,lib_articulo,lib_fecha from inv_libros";
	$result_inventario_distr = mysql_query($sql_inventario_distr) or die("Busca registro inventario<br>".mysql_error());
	$nf_inventario_distr=mysql_num_rows($result_inventario_distr);
	//die($nf_inventario_distr);
	if ($myrow_12 = mysql_fetch_array($result_inventario_distr)) 
	{
		//Se vacia primero la tabla inventario2
		mysql_query("TRUNCATE TABLE tbl_inventario2",$db);
		
		do 
		{
			$myrow_12[4]=str_replace("'", "\'", $myrow_12[4]);
			$sql_inserta_inventario2="INSERT INTO tbl_inventario2 (isbn, cod_barra,editorial, cod_producto,descripcion, precio,aut_codigo,coleccion,iva,lib_articulo,fecha_creacion) VALUES
									('$myrow_12[0]', '$myrow_12[1]', '$myrow_12[2]', '$myrow_12[3]', '$myrow_12[4]', '$myrow_12[5]', '$myrow_12[6]', '$myrow_12[7]', '$myrow_12[8]', '$myrow_12[9]', '$myrow_12[10]')";
			$status_inserta_inventario2=mysql_query($sql_inserta_inventario2,$db) or die("<br>Insertando inventario2<br>".mysql_error());
		} while ($myrow_12 = mysql_fetch_array($result_inventario_distr));
		$modificaiva2 = @mysql_query("UPDATE tbl_inventario2 SET precio= '26.7857142857142976000000000000000' where precio between '26' and '27' and iva=2",$db); 
	}


//Editorial
	$sql_editorial_distr="select prv_codpro, prv_nombre,prv_direc, prv_ptoref, prv_telef, prv_fax, prv_rif, prv_nit, prv_web, prv_contac, prv_mail, prv_tipop from inv_provee";
	$result_editorial_distr = mysql_query($sql_editorial_distr,$db_distr) or die("Busca registro editorial<br>".mysql_error());
	//$nf_distr=mysql_num_rows($result_editorial_distr);
	//die("-*->".$nf_distr);
	if ($myrow_13 = mysql_fetch_array($result_editorial_distr)) 
	{
		//Se vacia primero la tabla editorial2
		mysql_query("TRUNCATE TABLE tbl_editorial2",$db);
		do 
		{
			$sql_inserta_editorial2="INSERT INTO tbl_editorial2 (id_editorial,editorial, direccion, prv_ptoref, telf_oficina1, telf_fax, prv_rif, prv_nit, pag_web, prv_contac, correo, prv_tipop) VALUES
									('$myrow_13[0]', '$myrow_13[1]', '$myrow_13[2]', '$myrow_13[3]','$myrow_13[4]', '$myrow_13[5]', '$myrow_13[6]', '$myrow_13[7]', '$myrow_13[8]', '$myrow_13[9]', '$myrow_13[10]', '$myrow_13[11]')";
			$status_inserta_editorial2=mysql_query($sql_inserta_editorial2,$db) or die("$sql_inserta_editorial".mysql_error());
		} while ($myrow_13 = mysql_fetch_array($result_editorial_distr));
	}


//Autor
	
	$sql_autor_distr="select aut_codigo,aut_nombre,aut_pais from inv_autor";
	$result_autor_distr = mysql_query($sql_autor_distr,$db_distr) or die("Busca registro autor en la distribuidora<br>".mysql_error());
	$nf=mysql_num_rows($result_autor_distr);
	if ($myrow_14 = mysql_fetch_array($result_autor_distr)) 
	{
		//Se vacia primero la tabla autor
		mysql_query("TRUNCATE TABLE tbl_autor2",$db);
		do 
		{
			$myrow_14[1]=str_replace("'", "\'", $myrow_14[1]);
			$sql_inserta_autor2="INSERT INTO tbl_autor2 (id_autor,aut_nombre,aut_pais) VALUES
								('$myrow_14[0]', '$myrow_14[1]', '$myrow_14[2]')";
			$status_inserta_autor2=mysql_query($sql_inserta_autor2,$db) or die("<br>Insertando autor2<br>".mysql_error());
			
		} while ($myrow_14 = mysql_fetch_array($result_autor_distr));
	}
	
	
	
	
	
	
	$sql_cuenta2="SELECT count(*) FROM `tbl_inventario2`";
	$result_cuenta2=mysql_query($sql_cuenta2, $db);
	while($row2 = mysql_fetch_row($result_cuenta2))
	{
		$filas_inv2=$row2[0];
	}

//	die("-*->filas_inventario=".$filas_inv."  filas_inventario2=.$filas_inv2.<br>");

	//die("-*->filas_inventario=".$filas_inv."<br>");

	date_default_timezone_set('America/Caracas');
	$fechaLarga = date("Y-m-d h:i:s",time());
	$fecha1=explode("/", $_POST["txtfecdes"]);

	
	$fecha1=substr($fechaLarga, 0, 10);
	$fecha3=substr($fechaLarga, 10);
	$fecha2=explode("-", $fecha1);
	//die($fecha2[2]."/".$fecha2[2]."/".$fecha2[0].$fecha3);
	$fechahora=$fecha2[2]."/".$fecha2[1]."/".$fecha2[0].$fecha3;
	//die($fecha3);
	
	//$io_pdf->addJpegFromFile('librerias_del_sur.jpg',500,830,60,0);
	$io_pdf->ezStartPageNumbers(550,21,10,'','{PAGENUM} of {TOTALPAGENUM}',1);
	$io_pdf->selectFont('ezpdf/fonts/Helvetica-BoldOblique.afm');
	$io_pdf->addText(225,820,13,"<b>LIBRERIAS DEL SUR</b>");
	
	


	//Se buscan titulos con nuevos precios
	$io_pdf->addText(200,806,13,"<b>ACTUALIZACION DEL INVENTARIO</b>");
	$io_pdf->addText(225,792,13,"<b>(".$fechahora.")</b>");
	$io_pdf->addText(170,778,15,"<b>RECUERDE GUARDAR ESTE ARCHIVO</b>");
	$io_pdf->addText(200,760,13,"<b>ARTICULOS CON PRECIOS NUEVOS</b>");
	$io_pdf->ezSetDy(-60);
	$io_pdf->selectFont('ezpdf/fonts/Helvetica-BoldOblique.afm');
	
	
	
	$sql="SELECT tbl_inventario2.cod_producto, tbl_inventario2.descripcion,tbl_inventario2.editorial,
			tbl_inventario.precio as precio_anterior,tbl_inventario2.precio as precio_nuevo, tbl_inventario.iva,tbl_inventario2.iva
			FROM tbl_inventario,tbl_inventario2
			WHERE tbl_inventario.cod_producto=tbl_inventario2.cod_producto
			and tbl_inventario.precio<>tbl_inventario2.precio";
//	die($sql);
	$result = mysql_query($sql,$db) or die("Busca titulos con nuevos precios<br>".mysql_error());
	$nf=mysql_num_rows($result);
//	die($nf);
	if ($myrow = mysql_fetch_array($result)) 
	{
		$total_ARTICULOS=0;
		$Totalaumento=0;
		$Totaldisminuye=0;
		$i=0;
		do 
		{
			$s=$i+1;	

			$sql_editorial="select editorial from tbl_editorial2 where id_editorial='$myrow[2]'";
			$result_editorial = mysql_query($sql_editorial,$db) or die("Busca editorial<br>".mysql_error());
			do {
				$editorial=$myrow_editorial[0];
			} while ($myrow_editorial = mysql_fetch_array($result_editorial));
			$diferencia=$myrow['4']-$myrow['3'];
			
			if($myrow['3'] !=0)
			{
				$porcent1=($diferencia*100)/($myrow['3']);
				$porcentaje=number_format($porcent1,2,",",".");
				$simb100='%';
			}
			else
			{
				$porcentaje="";
				$simb100='';
			}
			
			if($myrow['5']==2)
				$iva1=" + IVA";
			else
				$iva1="";
				
			if($myrow['6']==2)
				$iva2=" + IVA";
			else
				$iva2="";
				
			if($porcentaje!='0,00')
			{
				if($diferencia > 0)
					$Totalaumento++;
				elseif($diferencia < 0)
					$Totaldisminuye++;


				$la_data[$i]=array(' N'=>$s,'CODIGO'=>$myrow['0'],'TITULO'=>$myrow['1'],'EDITORIAL'=>$editorial,'PRECIO ACTUAL'=>number_format($myrow['3'],2,",",".").$iva1,'PRECIO NUEVO'=>number_format($myrow['4'],2,",",".").$iva2,' %'=>$porcentaje.$simb100);
				$total_ARTICULOS=$total_ARTICULOS+$myrow['1'];
	
				$i++;
			}
		} while ($myrow = mysql_fetch_array($result));

		$la_columna=array('direccion'=>'<b>Direccion</b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 7, // Tamaño de Letras
						 'titleFontSize' => 12,  // Tamaño de Letras de los títulos
						 'showLines'=>1, // Mostrar Líneas
						 'shaded'=>0, // Sombra entre líneas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho Máximo de la tabla
						 'xOrientation'=>'center', // Orientación de la tabla
						'cols'=>array('N'=>array('justification'=>'left','width'=>10), // Justificación y ancho de la columna
						'CODIGO'=>array('justification'=>'left','width'=>50),
						'TITULO'=>array('justification'=>'left','width'=>140),
						'EDITORIAL'=>array('justification'=>'left','width'=>230),
						'PRECIO ACTUAL'=>array('justification'=>'left','width'=>40),
						'PRECIO NUEVO'=>array('justification'=>'left','width'=>40),
						'%'=>array('justification'=>'left','width'=>12),
									
									)); // Justificación y ancho de la columna
		$io_pdf->ezTable($la_data,'','',$la_config);
		$io_pdf->addText(140,$io_pdf->y-20,13,"<b>TOTAL ARTICULOS CON PRECIOS NUEVOS: ".$s."</b>");
		$io_pdf->addText(140,$io_pdf->y-35,13,"<b>ARTICULOS QUE AUMENTARON DE PRECIO: ".$Totalaumento."</b>");
		$io_pdf->addText(140,$io_pdf->y-50,13,"<b>ARTICULOS QUE BAJARON DE PRECIO: ".$Totaldisminuye."</b>");
	}
	else
	{
			$io_pdf->addText(80,600,10,"<b>NO SE ENCONTRARON ARTICULOS CON PRECIOS NUEVOS PARA ACTUALIZAR</b>");
			$io_pdf->ezStream();
	}
		
		
	
	$io_pdf->ezNewPage();
	
	//Se buscan titulos nuevos
	$io_pdf->addText(200,808,13,"<b>ARTICULOS NUEVOS EN EL INVENTARIO</b>");
	$io_pdf->ezSetDy(-30);
	//TABLA DE NOVEDADES
	
	$sql_ARTICULOS="SELECT tbl_inventario2.*
				FROM tbl_inventario2
				LEFT JOIN tbl_inventario
				USING (cod_producto)
				WHERE tbl_inventario.cod_producto IS NULL
				ORDER BY tbl_inventario2.fecha_creacion asc";
//	die($sql_ARTICULOS);
	$result_ARTICULOS = mysql_query($sql_ARTICULOS,$db) or die("Busca nuevos ARTICULOS<br>".mysql_error());
	$nf=mysql_num_rows($result_ARTICULOS);
//	die($nf);
	if ($myrow1 = mysql_fetch_array($result_ARTICULOS)) 
	{
	//	$total_ARTICULOS=0;
		$i=0;
		do 
		{
			$s=$i+1;
			if($myrow1['9']==2)
					$iva=" + IVA";
			else
				$iva="";
			
			
		//	$fecha2=substr($myrow1['10'], 0, 10);
			$fecha1=explode("-",substr($myrow1['10'], 0, 10));
			$fecha1[0]=substr($fecha1[0],-2);
			$fecha=$fecha1[2]."/".$fecha1[1]."/".$fecha1[0];
			//die($myrow1['0']." -*- ".$fecha);
			$sql_editorial="select editorial from tbl_editorial2 where id_editorial='$myrow1[6]'";
			$result_editorial = mysql_query($sql_editorial,$db) or die("Busca editorial<br>".mysql_error());
			do {
				$editorial=$myrow_editorial[0];
		} while ($myrow_editorial = mysql_fetch_array($result_editorial));

		$la_data1[$i]=array('  '=>$s,'CODIGO'=>$myrow1['0'],'TITULO'=>$myrow1['4'],'EDITORIAL'=>$editorial,'PRECIO'=>number_format($myrow1['7'],2,",",".").$iva,'FECHA CREACION'=>$fecha);
			$total_ARTICULOS=$total_ARTICULOS+$myrow1['1'];
			


			$i++;
		} while ($myrow1 = mysql_fetch_array($result_ARTICULOS));
			$la_columna=array('direccion'=>'<b>Direccion</b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 8, // Tamaño de Letras
						 'titleFontSize' => 12,  // Tamaño de Letras de los títulos
						 'showLines'=>1, // Mostrar Líneas
						 'shaded'=>0, // Sombra entre líneas
						 'width'=>510, // Ancho de la tabla
						 'maxWidth'=>510, // Ancho Máximo de la tabla
						 'xOrientation'=>'center', // Orientación de la tabla
						 'cols'=>array('N'=>array('justification'=>'left','width'=>13), // Justificación y ancho de la columna
						 			  'CODIGO'=>array('justification'=>'left','width'=>55),
									'TITULO'=>array('justification'=>'left','width'=>140),
						 			   'EDITORIAL'=>array('justification'=>'left','width'=>200),
									'PRECIO'=>array('justification'=>'left','width'=>45),
									'FECHA CREACION'=>array('justification'=>'left','width'=>45)
)); // Justificación y ancho de la columna
		$io_pdf->ezTable($la_data1,'','',$la_config);
		$io_pdf->addText(140,$io_pdf->y-20,13,"<b>TOTAL ARTICULOS NUEVOS: ".$s."</b>");

	}
	else
	{
			$io_pdf->addText(80,600,14,"<b>NO SE ENCONTRARON ARTICULOS NUEVOS PARA AGREGAR</b>");
			$io_pdf->ezStream();
		?>
						<div align=center><font size=3><b>NO SE ENCONTRARON RESULTADOS EN EL PERÍODO DE CONSULTA</b></font></div>
					<?
	}
	
//die($archivo_nuevo);

		if($filas_inv2 > $filas_inv)
		{
		
			//Reemplaza registros en tbl_inventario
			$sql_inventario="SELECT * FROM tbl_inventario2";
			$result_inventario = mysql_query($sql_inventario,$db) or die("Busca registro inventario<br>".mysql_error());
			$nf=mysql_num_rows($result_inventario);
		//	die($nf);
			if ($myrow2 = mysql_fetch_array($result_inventario)) 
			{
				//Se vacia primero la tabla inventario
				mysql_query("TRUNCATE TABLE tbl_inventario",$db);
				
				do 
				{
					$sql_inserta_inventario="INSERT INTO `tbl_inventario` (`cod_producto`, `lib_articulo`, `isbn`, `cod_barra`, `descripcion`, `aut_codigo`, `editorial`, `precio`, `coleccion`, `iva`,fecha_creacion) VALUES
											('$myrow2[0]', '$myrow2[1]', '$myrow2[2]', '$myrow2[3]', '$myrow2[4]', '$myrow2[5]', '$myrow2[6]', '$myrow2[7]', '$myrow2[8]', '$myrow2[9]', '$myrow2[10]')";
					$status__inserta_inventario=mysql_query($sql_inserta_inventario,$db) or die($sql_inserta_inventario."<br>Insertando inventario<br>".mysql_error());
				} while ($myrow2 = mysql_fetch_array($result_inventario));
				$modificaiva = @mysql_query("UPDATE tbl_inventario SET precio= '26.7857142857142976000000000000000' where precio between '26' and '27' and iva=2",$db); 
			}
			
			
			//Reeemplaza registros en tbl_editorial
			$sql_editorial="SELECT id_editorial,editorial, direccion, prv_ptoref, telf_oficina1, telf_fax, prv_rif, prv_nit, pag_web, prv_contac, correo, prv_tipop FROM tbl_editorial2";
			$result_editorial = mysql_query($sql_editorial,$db) or die("Busca registro editorial<br>".mysql_error());
			$nf=mysql_num_rows($result_editorial);
			//die($nf);
			if ($myrow3 = mysql_fetch_array($result_editorial)) 
			{
				//Se vacia primero la tabla editorial
					mysql_query("TRUNCATE TABLE tbl_editorial",$db);
				do 
				{
					$sql_inserta_editorial="INSERT INTO `tbl_editorial` (`id_editorial`,`editorial`, `direccion`, `prv_ptoref`, `telf_oficina1`, `telf_fax`, `prv_rif`, `prv_nit`, `pag_web`, `prv_contac`, `correo`, `prv_tipop`) VALUES
											('$myrow3[0]', '$myrow3[1]', '$myrow3[2]', '$myrow3[3]', '$myrow3[4]', '$myrow3[5]', '$myrow3[6]', '$myrow3[7]', '$myrow3[8]', '$myrow3[9]', '$myrow3[10]', '$myrow3[11]')";
					$status_inserta_editorial=mysql_query($sql_inserta_editorial,$db) or die("$sql_inserta_editorial".mysql_error());
				} while ($myrow3 = mysql_fetch_array($result_editorial));
			}
			
			
			
			//Reeemplaza registros en tbl_autor
			$sql_autor="SELECT id_autor,aut_nombre,aut_pais FROM tbl_autor2";
			$result_autor = mysql_query($sql_autor,$db) or die("Busca registro autor<br>".mysql_error());
			$nf=mysql_num_rows($result_autor);
			if ($myrow4 = mysql_fetch_array($result_autor)) 
			{
				//Se vacia primero la tabla autor
				mysql_query("TRUNCATE TABLE `tbl_autor`",$db);
				do 
				{
					$sql_inserta_autor="INSERT INTO `tbl_autor` (`id_autor`,`aut_nombre`, `aut_pais`) VALUES
										('$myrow4[0]', '$myrow4[1]', '$myrow4[2]')";
					$status__inserta_autor=mysql_query($sql_inserta_autor,$db) or die("<br>Insertando autor<br>".mysql_error());
					
				} while ($myrow4 = mysql_fetch_array($result_autor));
			}
			
			
		}
		else
		{
			$io_pdf->ezNewPage();
			$io_pdf->addText(80,800,14,"<b>NO SE ACTUALIZO EL INVENTARIO</b>");
			$io_pdf->addText(80,786,14,"<b>EL ARCHIVO DE ACTUALIZACION TIENE MENOS O IGUAL FILAS QUE EL ACTUAL</b>");
			$io_pdf->ezStream();
		}

		
		//Se imprime el pdf
		$io_pdf->ezStream();
		unset($io_pdf);

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
