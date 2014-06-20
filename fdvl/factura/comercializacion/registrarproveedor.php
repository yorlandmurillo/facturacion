<? 
require("../admin/session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.

if ($_SESSION['usuario_nivel']<$nivel_acceso && $_SESSION['usuario_nivel']!=2){

echo utf8_encode("Usted no tiene permisos para realizar esta operación");

}else{
$obj=new manejadordb;

$tiporegistro=trim($_POST['tipor']);

if($tiporegistro==1){

$nombre=trim($_POST['nombre']);
$contacto=trim($_POST['contacto']);
$telefono=trim($_POST['telefono']);
$fax=trim($_POST['fax']);
$celular=trim($_POST['celular']);
$direccion=trim($_POST['direccion']);
$tipo=trim($_POST['tipo']);
$rif=trim($_POST['rif']);


if($nombre!="" && $contacto!="" && $direccion!="" && $tipo!=""){
		if($obj->query("insert into tbl_proveedor (proveedor,contacto,telf_oficina,telf_fax,telf_celular,direccion,tipo_proveedor,rif)values('$nombre','$contacto','$telefono','$fax','$celular','$direccion',$tipo,'$rif')")==true){
		echo utf8_encode("Operación realizada con éxito");
		}else echo utf8_encode("Este distribuidor ya fué incluido");

}else echo utf8_encode("Error al procesar la operación");

}elseif($tiporegistro==2){

$codigo=trim($_POST['codigo']);
$titulo=trim($_POST['titulo']);
$autor=trim($_POST['autor']);
$isbn=trim($_POST['isbn']);
$codbarra=trim($_POST['codbarra']);
$existencia=trim($_POST['existencia']);

if($codigo!="" && $titulo!="" && $autor!="" && $isbn!="" && $codbarra!=0){
$resul=$obj->consultar("select * from tbl_sucursal");
 
while($row=mysql_fetch_assoc($resul)){
$obj->query("insert into tbl_distinventario (cod_producto,descripcion,autor,isbn,cod_barra,sucursal,condicion,cantidad)values('$codigo','$titulo','$autor','$isbn','$codbarra',".$row['id_sucursal'].",1,0)");
$obj->query("insert into tbl_distinventario (cod_producto,descripcion,autor,isbn,cod_barra,sucursal,condicion,cantidad)values('$codigo','$titulo','$autor','$isbn','$codbarra',".$row['id_sucursal'].",2,0)");
$obj->query("insert into tbl_distinventario (cod_producto,descripcion,autor,isbn,cod_barra,sucursal,condicion,cantidad)values('$codigo','$titulo','$autor','$isbn','$codbarra',".$row['id_sucursal'].",3,0)");
}
echo utf8_encode("Libros distribuidos correctamente");

}else echo utf8_encode("Error al procesar la operación por favor verifique los datos");

}elseif($tiporegistro==3){
$cods=trim($_POST['cods']);
$codt=trim($_POST['codt']);
if($codt!=""){

	$query = "SELECT Sum(cantidad) AS cantidad, Sum(cantdist) AS cantdist FROM tbl_itemsolicitud where (((tbl_itemsolicitud.cod_sol)='$cods'));";
	$result = $obj->consultar($query);
	$row = mysql_fetch_assoc($result);
	$cantidad=$row['cantidad'];
	$cantdist=$row['cantdist'];
	
	if($cantidad==$cantdist){
		$obj->query("update tbl_solicitud set estatus=17 where codigo='$cods';");
	}

if(mysql_num_rows($obj->consultar("select * from tbl_itemtraslado where cod_t='$codt' and estatus=12;"))>0){
		if($obj->query("update tbl_traslados set estatus=18,cargadopor=".$_SESSION['usuario_id'].",fechacarga='".$obj->getfechamysql()."' where cod_traslado='$codt'")==true){
		if($obj->query("update tbl_itemtraslado set estatus=18 where cod_t='$codt'")==true){
			echo utf8_encode("Operación realizada con éxito");
		}
		}else echo utf8_encode("Error al conectar con la base de datos");
}else echo utf8_encode("No ha anexado registros al traslado");

}else echo utf8_encode("Error al procesar la operación por favor verifique los datos");
}

}
?>