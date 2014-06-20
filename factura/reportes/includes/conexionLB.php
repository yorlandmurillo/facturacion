<?php
function Conectarse()
{
if (!($link2= @mysql_connect("localhost","inventa_bd","Valenta@04")))
{
echo "Error conectando a la base de datos.";
exit();
}
if (! @mysql_select_db("inventa_pglibreria",$link2))
{
echo "Error seleccionando la base de datos.";
exit();
}
set_time_limit(60);
return $link2;
}
//$link=Conectarse();
//echo "Conexión con la base de datos conseguida.<br>";
//@mysql_close($link); //cierra la conexion
?>