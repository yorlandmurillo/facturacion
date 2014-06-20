<?php
include_once("manejadordb.php");
//variables POST

function detalle($codigo){
$xml="<?xml version='1.0' encoding='ISO-8859-1'?>";
$xml.="<datos>";
$xml.="<titulo><![CDATA[".$libro[0]."]]></titulo>";
$xml.="<tomo><![CDATA[".$libro[1]."]]></tomo>";
$xml.="<formato><![CDATA[".$libro[2]."]]></formato>";
$xml.="<editorial><![CDATA[".$libro[3]."]]></editorial>";
$xml.="</datos>";
header("Content-type: text/xml");
echo $xml; 
}

$obj=new manejadordb;
$libro= array("Ninguno","2","Rústico","El Perro y la araña");





 
$cod=trim($_POST['codigo']);
$cant=trim($_POST['cantidad']);
$obj->query("insert into tbl_devolucionlibreria (cod_libro,cantidad)values('".addslashes($cod)."',".addslashes($cant).");");
//echo explode(",",$libro);

?>