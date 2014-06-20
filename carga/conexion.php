<?php
 
// datos para la coneccion a mysql
define('DB_SERVER','localhost');
define('DB_NAME','inventa_pglibreria');
define('DB_USER','inventa_bd');
define('DB_PASS','Valenta@04');
 
    $con = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
    mysql_select_db(DB_NAME,$con);
 
?>
