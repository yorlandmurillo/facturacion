
<?php

$e_deporte=$_GET['e_deporte'];


////$my_data=mysql_real_escape_string($q);
	$mysqli=mysqli_connect('localhost','inventa_fdvl','fdvl@master2012','inventa_fdvl') or die("Database Error");
	$sql="SELECT edicion_nombre FROM inv_edicion WHERE edicion_nombre LIKE '%$e_deporte%' ORDER BY edicion_nombre";
	
$result = mysqli_query($mysqli,$sql) or die(mysqli_error());
	
	if($result)
	{
		while($row=mysqli_fetch_array($result))
		{
		
			echo $row['edicion_nombre']."\n";

			
			
		}
	}
mysql_query ("SET NAMES 'utf8'");

///utf8_decode(htmlentities(
?>


