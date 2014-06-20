<?php
	$tag=$_GET['tag'];
	////$my_data=mysql_real_escape_string($q);
	$mysqli=mysqli_connect('localhost','inventa_Master','Presidencia@20212@','inventa_vicepresidencia') or die("Database Error");
	$sql="SELECT id,Especialidad FROM censo_profesion WHERE Especialidad LIKE '%$tag%' ORDER BY usr_cedula";
	$result = mysqli_query($mysqli,$sql) or die(mysqli_error());
	
	if($result)
	{
		while($row=mysqli_fetch_array($result))
		{
			echo $row['Especialidad']."\n";
		}
	}
?>


