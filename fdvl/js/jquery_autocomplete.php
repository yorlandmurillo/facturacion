<?php
	$tag=$_GET['tag'];
	////$my_data=mysql_real_escape_string($q);
	$mysqli=mysqli_connect('localhost','inventa_bd','Valenta@04','inventa_vicepresidencia') or die("Database Error");
	$sql="SELECT texto FROM censo_estado WHERE texto LIKE '%$tag%' ORDER BY texto";
	$result = mysqli_query($mysqli,$sql) or die(mysqli_error());
	
	if($result)
	{
		while($row=mysqli_fetch_array($result))
		{
			echo $row['texto']."\n";
		}
	}
?>


<?php
	$tag2=$_GET['tag2'];
	////$my_data=mysql_real_escape_string($q);
	$mysqli2=mysqli_connect('localhost','inventa_bd','Valenta@04','inventa_vicepresidencia') or die("Database Error");
	$sql2="
	
	SELECT censo_municipio.texto 
FROM censo_estado 
INNER JOIN censo_municipio
ON censo_estado.id =  censo_municipio.id_geo_estado
WHERE censo_municipio.texto LIKE '%$tag2%' 
GROUP BY censo_municipio.texto
ORDER BY censo_municipio.texto
	
	
	";
	$result2 = mysqli_query($mysqli2,$sql2) or die(mysqli_error());
	
	if($result2)
	{
		while($row=mysqli_fetch_array($result2))
		{
			echo $row['censo_municipio.texto']."\n";
		}
	}
?>
