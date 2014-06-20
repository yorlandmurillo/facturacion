<?
require("../admin/session.php");
//variables POST
$obj=new manejadordb;

function verificar($codinv,$codp,$suc,$cond,$nota=""){
$obj=new manejadordb;

$query="SELECT * FROM tbl_detalleinventario where cod_invent='$codinv' and cod_producto='$codp' and sucursal=$suc and condicion=$cond and estatus=6 and notaentrega='$nota';"; 
	
	$lista=$obj->consultar($query);
		if(mysql_num_rows($lista)==0){
			return false;
		}elseif(mysql_num_rows($lista)>0){
		 return true;
		}
}

$cod=trim(str_replace("\n","",$_POST['codigo']));
$suc=trim($_POST['sucursal']);
$codinv=trim($_POST['codinv']);
$cond=trim($_POST['cond']);
$notae=trim($_POST['notaent']);

$usuario=$_SESSION['usuario_id'];

$sql="SELECT tbl_inventario.cod_producto AS codigo, tbl_distinventario.descripcion AS titulo,tbl_inventario.tomo AS tm, tbl_formato.id_letra AS formato, tbl_editorial.editorial AS edit, Sum(tbl_distinventario.cantidad) AS cants FROM ((tbl_inventario INNER JOIN tbl_distinventario ON tbl_inventario.cod_producto = tbl_distinventario.cod_producto) INNER JOIN tbl_editorial ON tbl_inventario.editorial = tbl_editorial.id_editorial) INNER JOIN tbl_formato ON tbl_inventario.formato = tbl_formato.id GROUP BY tbl_inventario.cod_producto, tbl_distinventario.descripcion, tbl_inventario.tomo, tbl_formato.id_letra, tbl_editorial.editorial, tbl_distinventario.sucursal, tbl_inventario.isbn, tbl_inventario.cod_barra HAVING (((tbl_inventario.cod_producto)='$cod') AND ((tbl_distinventario.sucursal)=$suc)) OR (((tbl_inventario.isbn)='$cod')) OR (((tbl_inventario.cod_barra)='$cod'));"; 
$libro=$obj->consultar_remoto($sql);

$row = mysql_fetch_assoc($libro);
$codigo=$row['codigo'];

if(!empty($codigo) && !empty($suc) && !empty($codinv) && !empty($cond) && $suc!="0"){

if(verificar($codinv,$codigo,$suc,$cond,$notae)==false){

if($obj->query("INSERT INTO tbl_detalleinventario (cod_invent,cod_producto,sucursal,condicion,cant_sist,cant_fisc,estatus,notaentrega,usuario)VALUES('$codinv','$codigo',$suc,$cond,0,0,6,'$notae',$usuario);")==true){
$error="true";
$xml="<?xml version='1.0' encoding='UTF-8'?>";
$xml.="<datos>";
$xml.="<codigo><![CDATA[".$row['codigo']."]]></codigo>";
$xml.="<titulo><![CDATA[".$row['titulo']."]]></titulo>";
$xml.="<tomo><![CDATA[".$row['tm']."]]></tomo>";
$xml.="<formato><![CDATA[".$row['formato']."]]></formato>";
$xml.="<editorial><![CDATA[".$row['edit']."]]></editorial>";
$xml.="<cantidad><![CDATA[".$row['cants']."]]></cantidad>";
$xml.="<sucursal><![CDATA[$suc]]></sucursal>";
$xml.="<codinv><![CDATA[$codinv]]></codinv>";
$xml.="<condicion><![CDATA[$cond]]></condicion>";
$xml.="<respuesta><![CDATA[$error]]></respuesta>";
$xml.="</datos>";
header("Content-type: text/xml");

echo $xml; 

}else echo 'Error al registrar el libro';

}else{
$error="false";
$xml2="<?xml version='1.0' encoding='UTF-8'?>";
$xml2.="<error>";
$xml2.="<codigo><![CDATA[".$row['codigo']."]]></codigo>";
$xml2.="<sucursal><![CDATA[$suc]]></sucursal>";
$xml2.="<codinv><![CDATA[$codinv]]></codinv>";
$xml2.="<condicion><![CDATA[$cond]]></condicion>";
$xml2.="<respuesta><![CDATA[$error]]></respuesta>";
$xml2.="</error>";
header("Content-type: text/xml");

echo $xml2; 
}
}
?>
