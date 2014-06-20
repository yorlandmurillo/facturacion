<?php
//La conexión a su base de datos
include'conexion.php';

if (isset($_POST['field']) && isset($_POST['value'])){

$field = mysql_real_escape_string($_POST['field']);
$value = mysql_real_escape_string($_POST['value']);

//A partir de aqui es lo que cambia con respecto al código del ejemplo.

$cadbusca="SELECT * FROM censo_representante WHERE censo_ci  = '12'";

$result = mysql_query($cadbusca);
if (!$result) {
die('Query invalida: ' . mysql_error());
}

$cont=0;
while ($lin = mysql_fetch_array($result, MYSQL_ASSOC)) {
$cont++;}

if($cont==0) {
# Value esta disponible
echo 1;
} else {
# Value está en uso
echo 0;
}

}
# Close MySQL connection
mysql_close($link);
?>