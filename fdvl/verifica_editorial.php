<?php

$link = mysql_connect('localhost', 'inventa_fdvl', 'fdvl@master2012');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

# Select a MySQL database
$db_selected = mysql_select_db('inventa_fdvl', $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}

if (isset($_POST['field']) && isset($_POST['value'])){

$field = mysql_real_escape_string($_POST['field']);
$value = mysql_real_escape_string($_POST['value']);

	


//A partir de aqui es lo que cambia con respecto al código del ejemplo.

$cadbusca="SELECT * FROM inv_provee WHERE prv_nombre like '%$value%'";


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
