<?php
include 'conec.php';
require_once("ezpdf/class.ezpdf.php");
$io_pdf=new Cezpdf('LETTER','landscape');
$io_pdf =& new Cezpdf();

if(!empty($_FILES['file'])){

// obtenemos el archivo enviado por post
	$consulta=$_FILES['file'];

// leemos el contenido del archivo
	$archivo_nuevo = file_get_contents($consulta['tmp_name']);
//die($archivo_nuevo);
//Cargar nuevas tablas

	$tablas1=str_replace("tbl_autor","tbl_autor2",$archivo_nuevo);
	$tablas2=str_replace("tbl_editorial","tbl_editorial2",$tablas1);
	$tablas3=str_replace("tbl_inventario","tbl_inventario2",$tablas2);
	foreach(explode(";",$tablas3) as $sql_index=>$query)
	{
	//	die($query);
		mysql_query($query);
	}

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
	$io_pdf->addText(200,760,13,"<b>LIBROS CON PRECIOS NUEVOS</b>");
	$io_pdf->ezSetDy(-60);
	$io_pdf->selectFont('ezpdf/fonts/Helvetica-BoldOblique.afm');
	
	
	
	$sql="SELECT tbl_inventario2.cod_producto, tbl_inventario2.descripcion,tbl_inventario2.editorial,
			tbl_inventario.precio as precio_anterior,tbl_inventario2.precio as precio_nuevo
			FROM tbl_inventario,tbl_inventario2
			WHERE tbl_inventario.cod_producto=tbl_inventario2.cod_producto
			and tbl_inventario.precio<>tbl_inventario2.precio";
//	die($sql);
	$result = mysql_query($sql,$db) or die("Busca titulos con nuevos precios<br>".mysql_error());
	$nf=mysql_num_rows($result);
//	die($nf);
	if ($myrow = mysql_fetch_array($result)) {
	$total_libros=0;
	$i=0;
	do {
		$s=$i+1;	

		$sql_editorial="select editorial from tbl_editorial2 where id_editorial='$myrow[2]'";
		$result_editorial = mysql_query($sql_editorial,$db) or die("Busca editorial<br>".mysql_error());
		do {
			$editorial=$myrow_editorial[0];
		} while ($myrow_editorial = mysql_fetch_array($result_editorial));

		$la_data[$i]=array(' N'=>$s,'CODIGO'=>$myrow['0'],'TITULO'=>$myrow['1'],'EDITORIAL'=>$editorial,'PRECIO ACTUAL'=>number_format($myrow['3'],2,",","."),'PRECIO NUEVO'=>number_format($myrow['4'],2,",","."));
			$total_libros=$total_libros+$myrow['1'];
			
	//number_format($myrow['4'],2,",",".")


		//die($sql_actualiza);
			$i++;
		} while ($myrow = mysql_fetch_array($result));


		$la_columna=array('direccion'=>'<b>Direccion</b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 8, // Tamaño de Letras
						 'titleFontSize' => 12,  // Tamaño de Letras de los títulos
						 'showLines'=>1, // Mostrar Líneas
						 'shaded'=>0, // Sombra entre líneas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho Máximo de la tabla
						 'xOrientation'=>'center', // Orientación de la tabla
						'cols'=>array('N'=>array('justification'=>'left','width'=>11), // Justificación y ancho de la columna
						 			  'CODIGO'=>array('justification'=>'left','width'=>55),
									'TITULO'=>array('justification'=>'left','width'=>190),
						 			   'EDITORIAL'=>array('justification'=>'left','width'=>200),
									'PRECIO ACTUAL'=>array('justification'=>'left','width'=>45),
						 			  'PRECIO NUEVO'=>array('justification'=>'left','width'=>45)
									
)); // Justificación y ancho de la columna
		$io_pdf->ezTable($la_data,'','',$la_config);
		$io_pdf->addText(140,$io_pdf->y-20,13,"<b>TOTAL LIBROS CON PRECIOS NUEVOS: ".$s."</b>");
		//$io_pdf->ezSetDy(-40);
	}
	else
	{
			$io_pdf->addText(80,600,14,"<b>NO SE ENCONTRARON LIBROS CON PRECIOS NUEVOS PARA ACTUALIZAR</b>");
			$io_pdf->ezStream();
	}
		
		
	
		$io_pdf->ezNewPage();
		
		//Se buscan titulos nuevos
		$io_pdf->addText(200,808,13,"<b>LIBROS NUEVOS EN EL INVENTARIO</b>");
		$io_pdf->ezSetDy(-30);
		//TABLA DE NOVEDADES
		
		$sql_libros="SELECT tbl_inventario2.*
					FROM tbl_inventario2
					LEFT JOIN tbl_inventario
					USING (cod_producto)
					WHERE tbl_inventario.cod_producto IS NULL
					ORDER BY tbl_inventario2.editorial";
//	die($sql_libros);
	$result_libros = mysql_query($sql_libros,$db) or die("Busca nuevos libros<br>".mysql_error());
	$nf=mysql_num_rows($result_libros);
//	die($nf);
	if ($myrow1 = mysql_fetch_array($result_libros)) {
//	$total_libros=0;
	$i=0;
	do {
		$s=$i+1;
			
			$sql_editorial="select editorial from tbl_editorial2 where id_editorial='$myrow1[6]'";
			$result_editorial = mysql_query($sql_editorial,$db) or die("Busca editorial<br>".mysql_error());
			do {
				$editorial=$myrow_editorial[0];
		} while ($myrow_editorial = mysql_fetch_array($result_editorial));

			$la_data1[$i]=array('  '=>$s,'CODIGO'=>$myrow1['0'],'TITULO'=>$myrow1['4'],'EDITORIAL'=>$editorial,'PRECIO'=>number_format($myrow1['7'],2,",","."));
			$total_libros=$total_libros+$myrow1['1'];
			


			$i++;
		} while ($myrow1 = mysql_fetch_array($result_libros));
			$la_columna=array('direccion'=>'<b>Direccion</b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 8, // Tamaño de Letras
						 'titleFontSize' => 12,  // Tamaño de Letras de los títulos
						 'showLines'=>1, // Mostrar Líneas
						 'shaded'=>0, // Sombra entre líneas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho Máximo de la tabla
						 'xOrientation'=>'center', // Orientación de la tabla
						 'cols'=>array('N'=>array('justification'=>'left','width'=>11), // Justificación y ancho de la columna
						 			  'CODIGO'=>array('justification'=>'left','width'=>55),
									'TITULO'=>array('justification'=>'left','width'=>190),
						 			   'EDITORIAL'=>array('justification'=>'left','width'=>200),
									'PRECIO'=>array('justification'=>'left','width'=>45)
)); // Justificación y ancho de la columna
		$io_pdf->ezTable($la_data1,'','',$la_config);
		$io_pdf->addText(140,$io_pdf->y-20,13,"<b>TOTAL LIBROS NUEVOS: ".$s."</b>");

	}
	else
	{
			$io_pdf->addText(80,600,14,"<b>NO SE ENCONTRARON LIBROS NUEVOS PARA AGREGAR</b>");
			$io_pdf->ezStream();
		?>
						<div align=center><font size=3><b>NO SE ENCONTRARON RESULTADOS EN EL PERÍODO DE CONSULTA</b></font></div>
					<?
	}
	
//die($archivo_nuevo);

		if($filas_inv2 > $filas_inv)
		{
		
			//Se reemplazan las tablas actuales de inventario
			foreach(explode(";",$archivo_nuevo) as $sql_index=>$query1)
			{
				mysql_query($query1);
			}
		}
		else
		{
			//die("-*->AQUI ESTOY<-*-");
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
<b><div align='center'><font color='blue' size='5'>ACTUALIZACION DE LIBROS</font></div></b><BR>
<b><div align='center'><font color='blue' size='5'>SELECCIONE EL ARCHIVO A CARGAR</font></div></b><BR>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <label>
 <b><div align='center'> <input type="file" name="file" />
  </label>
  <p>
    <label>
    <input type="submit" name="Submit" value="Enviar" /></div>
    </label>
  </p>
</form>
<b><div align='center'><font color='red' size='7'>IMPORTANTE: RECUERDE GUARDAR EL REPORTE GENERADO</font></div></b><BR>
</body>
</html>
