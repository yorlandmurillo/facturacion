<?php
$host="distribuidoradellibro.gob.ve";
$user="inventa_bd";
$passwd="Valenta@04";
$db_distr = mysql_connect($host,$user,$passwd);
mysql_select_db("inventa_fdvl", $db_distr);
if (!@mysql_connect($host,$user,$passwd))
{
	echo "<script>alert('Por favor verifique la Conexion de Internet');location.href='index.php';</script>";
exit();
}





?>
