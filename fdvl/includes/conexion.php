<?php
function Conectarse()
{
	if (!($link= @mysql_connect("distribuidoradellibro.gob.ve","inventa_bd","Valenta@04")))
	///if (!($link= @mysql_connect("localhost","inventa_bd","Valenta@04")))
	{
		echo "<script>alert('Por favor verifique la Conexión de Internet');location.href='index.php';</script>";
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
	set_time_limit(20000);
	return $link;
}

function Conectarse_local()
{
	if (!($link= @mysql_connect("localhost","inventa_bd","Valenta@04")))
	{
		echo "<script>alert('Por favor verifique la Conexión de Internet');location.href='index.php';</script>";
		session_start();
		// Destruye todas las variables de la sesion
		session_unset();
		// Finalmente, destruye la sesion
		session_destroy();
		exit();
	}
	if (! @mysql_select_db("inventa_pglibreria",$link))
	{
		echo "Error seleccionando la base de datos.";
		exit();
	}
	set_time_limit(20000);
	return $link;
}



?>
