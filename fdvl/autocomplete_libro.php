
<?php

$libro_busca=$_GET['libro_busca'];


////$my_data=mysql_real_escape_string($q);
	$mysqli=mysqli_connect('localhost','inventa_fdvl','fdvl@master2012','inventa_fdvl') or die("Database Error");
	$sql="
	
	SELECT  lib_descri
	from inv_libros
	
	WHERE lib_descri LIKE '%$libro_busca%' 
	

	";
	
$result = mysqli_query($mysqli,$sql) or die(mysqli_error());
	
	if($result)
	{
		while($row=mysqli_fetch_array($result))
		{
		
			echo $row['lib_descri']."\n";

				
			
		}
	}
mysql_query ("SET NAMES 'utf8'");


?>


