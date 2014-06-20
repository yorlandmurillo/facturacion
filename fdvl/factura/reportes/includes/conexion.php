<?php
function Conectarse()
{
if (!($link= @mysql_connect("localhost","inventa_bd","Valenta@04")))
{
echo "Error conectando a la base de datos.";
exit();
}
if (! @mysql_select_db("inventa_fdvl",$link))
{
echo "Error seleccionando la base de datos.";
exit();
}
mysql_query ("SET NAMES 'utf8'"); 
set_time_limit(60);

return $link;
}
//$link=Conectarse();
//echo "Conexión con la base de datos conseguida.<br>";
//@mysql_close($link); //cierra la conexion
?>