<?
require ('acurl.class.php'); 
require("../clases/class.xml.php");
require("../clases/class.mysql_xml.php");
require("envios.php");
require("ftp.class.php");
$envios=new envios();
$conv = new mysql2xml();
$ftp = new ftp();
$acurl = new acurl();
$uftp="libsur".$_SESSION['usuario_sucursal'];
$pftp="sigal".$_SESSION['usuario_sucursal'];
$sftp=$envios->getpreferencia($_SESSION['usuario_sucursal'],"ipservidor");
$carpetas=array("traslados","itemtraslado","usuarios","clientes","")
$archivos= array("tbl_traslados","tbl_itemtraslado","tbl_usuarios","tbl_clientes","")

$acurl->ftp_download('103-16-07-10-14-02.sql.bz2', '190.202.87.5/database/103/103-16-07-10-14-02.sql.bz2', 21,$uftp,$pftp);



/***Archivo de datos de facturas***/
$datos=date('Ymd').(date('h')-1).date('i');
//die($envios->carpetas[1]);

$conv->convertToXML("SELECT * FROM tbl_facturas WHERE (((tbl_facturas.sucursal)=".$_SESSION['usuario_sucursal'].") AND  ((tbl_facturas.fecha_factura) Between '".$envios->verificarfecha($envios->carpetas[0],$_SESSION['usuario_sucursal'])."' And '".manejadordb::getfechamysql()."'));","".$envios->generarenvio($envios->carpetas[0],$_SESSION['usuario_sucursal'],$datos).".xml");

if($envios->subirarchivo($envios->carpetas[0],$datos.".xml",$_SESSION['usuario_sucursal'],$uftp,$pftp,$sftp)==true){
$envios->actualizarfecha($envios->carpetas[0],$_SESSION['usuario_sucursal']);
$respuesta=1;

}else $respuesta=0;
/**********FIN***********/


/************ITEM_FACTURAS*********/
$conv->convertToXML("SELECT tbl_itemfactura.cod_factura, tbl_itemfactura.cod_producto, tbl_itemfactura.descripcion,tbl_itemfactura.precio_unid,tbl_itemfactura.cantidad, tbl_itemfactura.existencia, tbl_itemfactura.descuento,tbl_itemfactura.estatus_cancelacion, tbl_itemfactura.sucursal, tbl_itemfactura.vendedor, tbl_itemfactura.isbn,tbl_itemfactura.cif, tbl_itemfactura.cic, tbl_itemfactura.cicdn, tbl_itemfactura.devuelto, tbl_itemfactura.precio_sd,tbl_itemfactura.iva FROM tbl_facturas INNER JOIN tbl_itemfactura ON (tbl_facturas.sucursal =tbl_itemfactura.sucursal) AND (tbl_facturas.cod_factura = tbl_itemfactura.cod_factura) WHERE (((tbl_facturas.fecha_factura) Between '".$envios->verificarfecha($envios->carpetas[1],$_SESSION['usuario_sucursal'])."' And '".manejadordb::getfechamysql()."') AND ((tbl_facturas.sucursal)=".$_SESSION['usuario_sucursal']."));","".$envios->generarenvio($envios->carpetas[1],$_SESSION['usuario_sucursal'],$datos).".xml");

if($envios->subirarchivo($envios->carpetas[1],$datos.".xml",$_SESSION['usuario_sucursal'],$uftp,$pftp,$sftp)==true){
$envios->actualizarfecha($envios->carpetas[1],$_SESSION['usuario_sucursal']);
$respuesta=1;
}else $respuesta=0;
/*********FIN************/

if ($respuesta==1){
echo utf8_encode("Datos Eviados Satisfactoriamente.");
}else if($respuesta==0){
echo utf8_encode("¡Datos no Eviados!, por favor consulte con el Administrador de Sistemas.");
}

?>