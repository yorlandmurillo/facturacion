<?PHP
	 $link = mysql_connect("distribuidoradellibro.gob.ve","inventa_bd","Valenta@04") or die (mysql_error());  
    mysql_select_db("inventa_fdvl",$link);
	mysql_query ("SET NAMES 'utf8'");
?>	
