
	$estatus=0;

	//$archivo=fopen("archivo",w);	
	
	while ($row = mysql_fetch_assoc($res)){

	if(!strcasecmp($row["condicion"],"Firme"))$condicion=1;
	if(!strcasecmp($row["condicion"],"Consignacion"))$condicion=2;
	if(!strcasecmp($row["condicion"],"Consignacion DN"))$condicion=3;
	$estatus=0;

//$cadena=trim($row["codigo_traslado"])."|***|".trim($row["codigo"])."|***|".$row["sucursal"]."|***|".$row["cantidad"]."|***|".$condicion."|***|".trim($row["titulo"])."|***|".trim($row["autor"])."|***|".trim($row["coleccion"])."|***|".trim($row["editorial"])."|***|".trim($row["tema"])."|***|".trim($row["subtema"])."|***|".$row["precio"]."|***|".$row["descuento"]."|***|".trim($row["isbn"])."|***|".trim($row["barras"])."|***|".trim($row["soliorden"])."|***|".$estatus."|***|".trim($row["responsable"])."|***|".strftime("%Y-%m-%d",strtotime($row["fecha"]))."\n";

//	fputs($archivo,$cadena);

//	$i++;
	}
//	fclose($archivo);	
	
	//$query = "LOAD DATA LOCAL INFILE 'C:/xampp/htdocs/sigal/traslados/archivo' INTO TABLE tbl_traslados(cod_traslado,cod_libro,sucursal,cantidad,condicion,titulo,autor,coleccion,editorial,tema,subtema,precio,descuento,isbn,cod_barra,solicitud,estatus,incluidopor,fechainclusion) FIELDS TERMINATED BY ','  LINES TERMINATED BY '\n';";
	//$obj->query($query);
	
	
	
	function comprimir ($nom_arxiu)
{
$fptr = fopen($nom_arxiu, "rb");
$dump = fread($fptr, filesize($nom_arxiu));
fclose($fptr);

//Comprime al máximo nivel, 9
$gzbackupData = gzencode($dump,9);

$fptr = fopen($nom_arxiu . ".gz", "wb");
fwrite($fptr, $gzbackupData);
fclose($fptr);
//Devuelve el nombre del archivo comprimido
return $nom_arxiu.".gz";
} 

//Modo de utilización:

// Llamamos la función pasandole el
// nombre del archivo a comprimir

//$ok=comprimir("".$_SESSION['usuario_sucursal'].".xml");

//if ($ok)
//echo "Archivo comprimido correctamente con el nombre ".$ok;
