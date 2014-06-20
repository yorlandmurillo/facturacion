<?php

	include 'conec.php';
	$cod_producto=array();
	$isbn=array();
	$cod_barra=array();
	$autor=array();
	$descripcion=array();
	$editorial=array();
	$tomo=array();
	$presentacion=array();
	$cant_enviada=array();
	$cant_entregada=array();
	$nuevos=array();
	$actualizados=array();
	$fecha_envio=$_POST["fecha_envio"];
	$fecha_carga=$_POST["fecha_carga"];
	$insertar_existencia=array();
	$actualizar_existencia=array();
	$condicion='0000000001';
	$sucursal_envio=$_POST["sucursal_envio"];
	$sucursal=$_POST["id_sucursal"];
	$nota_entrega=$_POST["nota_entrega"];
	$observaciones=$_POST["observaciones"];
	$pedido=$_POST["pedido"];
	$fecha1=explode("/", $_POST["txtfecdes"]);
	
	$codigo_enviado=explode("*", $_POST["codigo_enviado"]);
	$titulo_enviado=explode("*", $_POST["titulo_enviado"]);
	$autor_enviado=explode("*", $_POST["autor_enviado"]);
	$editorial_enviada=explode("*", $_POST["editorial_enviada"]);
	$isbn_enviado=explode("*", $_POST["isbn_enviado"]);
	$codigodebarra_enviado=explode("*", $_POST["codigodebarra_enviado"]);
	$tomo_enviado=explode("*", $_POST["tomo_enviado"]);
	$presentacion_enviada=explode("*", $_POST["presentacion_enviada"]);
	$precio_unitario_enviado=explode("*", $_POST["precio_unitario_enviado"]);
	$cantidad_enviada=explode("*", $_POST["cantidad_enviada"]);
		
	/*
	echo "Valores POST<br>";
$num2=count($_POST);
$tags2 = array_keys($_POST); // obtiene los nombres de las variables
$valores2 = array_values($_POST);// obtiene los valores de las variables
print_r($tags2);
echo "<br><br>";
print_r($valores2);
echo "<br><br>";
die();*/
	
	$sql_notaentrega="SELECT DISTINCT (nota_entrega), tbl_sucursal.sucursal FROM `tbl_controlperceptivo` , tbl_sucursal
	WHERE nota_entrega ='$nota_entrega' AND tbl_controlperceptivo.sucursal_carga = tbl_sucursal.id_sucursal";
	//die($sql_notaentrega);
	$result_notaentrega = mysql_query($sql_notaentrega, $db);
	$nf_notaentrega=mysql_num_rows($result_notaentrega);
	if($nf_notaentrega==0)
	{
	
	$sql_nota="INSERT INTO `tbl_controlperceptivo` (`nota_entrega`, `pedido`, `sucursal_envio`, `sucursal_carga`, `fecha_creada`, `fecha_carga`, `observaciones`) VALUES
	('$nota_entrega', '$pedido', '$sucursal_envio', '$sucursal', '$fecha_envio', '$fecha_carga', '$observaciones')";
	//die($sql_nota);
		$status_nota=mysql_query($sql_nota) or die("<br>Insertando el control perceptivo<br>".mysql_error());
		
		
		$file="nota_cargada.html";
		$fp = fopen($file,"w");
		fclose($fp);
		$ar=fopen("nota_cargada.html","a") or die("Problemas en la creacion"); 
		fputs($ar,"\n\n"); 	
		
		
		fputs($ar,"<div align=center>");
		fputs($ar,"<P><font size=5><b>LIBRERIAS DEL SUR</b></font></P>");
		fputs($ar,"<b><div align='center'><font color=red size=5>CARGA DE LA NOTA DE ENTREGA ".$nota_entrega."</font></div></b>\n\n");
		

	for ($i=0;$i<$_POST["filas"];$i++)
	{
		
		$cod_producto[$i]=$codigo_enviado[$i];
		$descripcion[$i]=$titulo_enviado[$i];
		$autor[$i]=$autor_enviado[$i];
		$editorial[$i]=$editorial_enviada[$i];
		$isbn[$i]=$isbn_enviado[$i];
		$cod_barra[$i]=$codigodebarra_enviado[$i];
		$tomo[$i]=$tomo_enviado[$i];
		$presentacion[$i]=$presentacion_enviada[$i];
		$precio_unitario[$i]=$precio_unitario_enviado[$i];
		$cant_enviada[$i]=$cantidad_enviada[$i];
		$cant_entregada[$i]=$_POST["cant_entregada"][$i];
		
		
		//Se reemplaza los apostrofes que puedan haber en el nombre del autor
		$autor[$i]=str_replace("'", "\'", $autor[$i]);
		$descripcion[$i]=str_replace("'", "\'", $descripcion[$i]);
		
		if($cant_entregada[$i]=='')
		{
			$cant_entregada[$i]=0;
		}
		$fecha_carga[$i]=$_POST["fecha_carga"][$i];
	
		
		//Se inserta el detallado del control perceptivo
		$sql_itemcontrolperceptivo="INSERT INTO `tbl_itemcontroperceptivo` (`notaentrega`, `cod_producto`, `precio_unitario`, `cantidad_enviada`, `cantidad_cargada`, `isbn`, `codigobarra`) VALUES
									('$nota_entrega', '$cod_producto[$i]', '$precio_unitario[$i]', '$cant_enviada[$i]', '$cant_entregada[$i]', '$isbn[$i]', '$cod_barra[$i]');";
		mysql_query($sql_itemcontrolperceptivo) or die("<br>Insertando el detallado del control perceptivo<br>".mysql_error());
			

		//Se revisa si el libro esta en la existencia de la libreriaq
		$sql_existencia="SELECT *	 
					FROM `tbl_distinventario`
					WHERE  cod_producto='$cod_producto[$i]'
					and sucursal='$sucursal'";
		$status_existencia=mysql_query($sql_existencia) or die("<br>".mysql_error());
		$nf_existencia=mysql_num_rows($status_existencia);
		
		
		
		if($nf_existencia>0)
		{

			while($row = mysql_fetch_row($status_existencia))
			{
				$cantidad_existente=$row['10'];
			}
			
			$nueva_cantidad=$cantidad_existente+$cant_entregada[$i];
			$actualizados[]="<b><font color=blue>El libro ".$cod_producto[$i]." ".$descripcion[$i] ." ya existe, hay ".$cantidad_existente." y será incrementada la candidad a ".$nueva_cantidad;
			
			$actualizar_existencia[$i]="update tbl_distinventario set cantidad='$nueva_cantidad' where cod_producto='$cod_producto[$i]'";
			mysql_query($actualizar_existencia[$i]) or die("<br>Actualizando la cantidad del libro en tbl_distinventario<br>".mysql_error());
		}
		else
		{
			$nuevos[]= "El libro ".$cod_producto[$i]."   ".$descripcion[$i]." no existe y agregaran ".$cant_entregada[$i];
			//Se inserta el libro en distinventario
			$insertar_existencia[$i]="INSERT INTO `tbl_distinventario` (`cod_producto`, `isbn`, `cod_barra`, `autor`, `descripcion`, `editorial`, `tomo`, `presentacion`, `sucursal`, `condicion`, `cantidad`, 
			`descuento`, `FECHA_NOTA_ENTREGA`) VALUES
			('$cod_producto[$i]','$isbn[$i]','$cod_barra[$i]','$autor[$i]','$descripcion[$i]','$editorial[$i]','$tomo[$i]','$presentacion[$i]','$sucursal','0000000001','$cant_entregada[$i]',0,'$fecha_carga')";
			mysql_query($insertar_existencia[$i]) or die("<br>Insertando el libro en tbl_distinventario<br>".mysql_error());
		}

	}
	if(sizeof($nuevos)>0)
	{

		fputs($ar,"<b><div align=center><font size=3 color=blue>LIBROS NUEVOS</font></div></b><br><br>");
		$num=0;
		fputs($ar,"<table>");
		for($i=0;$i<sizeof($nuevos);$i++)
		{
			fputs($ar,$nuevos[$i]."<br>\n");
			$num++;
		}
		fputs($ar,"<table>");
		fputs($ar,"<br>\n\n");
		//fputs($ar,$nuevos[$i]."<br><br>");
		fputs($ar,"<b><div align=center><font size=3 color=blue>TOTAL LIBROS NUEVOS: ".$num."</font></div></b><br><br>");
	}
	if(sizeof($actualizados)>0)
	{
		fputs($ar,"<b><div align=center><font size=3 color=blue>LIBROS CON CANTIDAD ACTUALIZADA</font></div></b><br><br>");
		
		$num2=0;
		fputs($ar,"<table>");
		for($i=0;$i<sizeof($actualizados);$i++)
		{
			fputs($ar,"<tr><td>".$actualizados[$i]."</td></tr>");
			$num2++;
		}
		fputs($ar,"</table>");
		fputs($ar,"<br>\n\n");
		fputs($ar,"<b><div align=center><font size=3 color=blue>TOTAL LIBROS CON CANTIDAD ACTUALIZADA: ".$num2."</font></div></b><br><br>\n\n");
	}

		fputs($ar,"<div align=center><font size=5><a href=lee_notas.php>REGRESAR</a></font></div>");		
			fclose($ar);
			
	?>
		<script >
			location.href="nota_cargada.html"; 
		</script>
	<?

}
else
{
?>
	<div align=center><font size=5 color=blue><b>LA NOTA DE ENTREGA <?echo " ".$nota_entrega;?> YA HA SIDO CARGADA</b></font></div><br><br>
	<div align="center"><font size=5><a href="lee_notas.php">REGRESAR</a></font></div>
<?
}
