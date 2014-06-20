<?php
$host="distribuidoradellibro.gob.ve";
$user="inventa_bd";
$passwd="Valenta@04";
$link = mysql_connect($host,$user,$passwd);
if (!$link)
{
	echo "<script>alert('Por favor verifique la Conexiodfgfn de Internet');location.href='index.php';</script>";
	// Inicializa de la sesion
	session_start();
	// Destruye todas las variables de la sesion
	session_unset();
	// Finalmente, destruye la sesion
	session_destroy();
	exit();
}
if (! @mysql_select_db("inventa_fdvl",$link))
{
echo "Error seleccionando la base de datos.";
exit();
}

