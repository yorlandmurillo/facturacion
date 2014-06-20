<?php
require("../admin/session.php");// // incluir motor de autentificación.
require("class.xml.php");
require("class.mysql_xml.php");

# Clear table only for example
$table = new recordset;
//$table->exec("Delete From users");
# Clear table only for example

$conv = new mysql2xml;
$conv->insertIntoMySQL("".$_SESSION['usuario_sucursal'].".xml", "tbl_itemfactura");

?>