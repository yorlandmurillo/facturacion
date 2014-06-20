<?php
require("../admin/session.php");// // incluir motor de autentificación.
require("class.xml.php");
require("class.mysql_xml.php");

$conv = new mysql2xml;
$conv->convertToXML("SELECT tbl_itemfactura.cod_factura, tbl_itemfactura.cod_producto, tbl_itemfactura.descripcion, tbl_itemfactura.precio_unid, tbl_itemfactura.cantidad, tbl_itemfactura.existencia, tbl_itemfactura.descuento, tbl_itemfactura.estatus_cancelacion, tbl_itemfactura.sucursal, tbl_itemfactura.vendedor, tbl_itemfactura.isbn, tbl_itemfactura.cif, tbl_itemfactura.cic, tbl_itemfactura.cicdn, tbl_itemfactura.devuelto FROM tbl_facturas INNER JOIN tbl_itemfactura ON tbl_facturas.cod_factura = tbl_itemfactura.cod_factura WHERE (((tbl_facturas.fecha_factura) Between '2007-11-01 01:00:00' And '2007-12-05 23:00:00'))limit 2000;", "".$_SESSION['usuario_sucursal'].".xml");

function comprimir ($nom_arxiu)
{
$fptr = fopen($nom_arxiu, "rb");
$dump = fread($fptr, filesize($nom_arxiu));
fclose($fptr);

//Comprime al máximo nivel, 9
$gzbackupData = gzencode($dump,9);

$fptr = fopen($nom_arxiu . ".gz", "wb");
fwrite($fptr, $gzbackupData);
fclose($fptr);
//Devuelve el nombre del archivo comprimido
return $nom_arxiu.".gz";
} 

//Modo de utilización:

// Llamamos la función pasandole el
// nombre del archivo a comprimir

$ok=comprimir("".$_SESSION['usuario_sucursal'].".xml");

if ($ok)
echo "Archivo comprimido correctamente con el nombre ".$ok;


?>