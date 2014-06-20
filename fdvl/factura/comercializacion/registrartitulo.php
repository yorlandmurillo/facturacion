<?
require("../admin/session.php");
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.

function arreglo_libros(){
$usuarios_sesion="libros";				$local["arreglo"] =array();			$obj= new  manejadordb();				$query = "SELECT tbl_inventario.cod_producto as codigo, tbl_inventario.descripcion as titulo, tbl_inventario.autor as autornom, tbl_inventario.precio as pvp, Sum(tbl_distinventario.cantidad) AS existencia, tbl_inventario.isbn as isbnl, tbl_inventario.cod_barra as barras, tbl_editorial.editorial as edit, tbl_formato.descripcion as formato, tbl_inventario.n_coleccion as nrocoleccion, tbl_coleccion.col_descripcion as coleccion, tbl_edicion.descripcion as edicion, tbl_tomo.descripcion as tomo
FROM (((((tbl_inventario INNER JOIN tbl_distinventario ON tbl_inventario.cod_producto = tbl_distinventario.cod_producto) INNER JOIN tbl_editorial ON tbl_inventario.editorial = tbl_editorial.id_editorial) INNER JOIN tbl_formato ON tbl_inventario.formato = tbl_formato.id) INNER JOIN tbl_coleccion ON tbl_inventario.coleccion = tbl_coleccion.id_coleccion) INNER JOIN tbl_edicion ON tbl_inventario.n_edicion = tbl_edicion.edicion_id) INNER JOIN tbl_tomo ON tbl_inventario.tomo = tbl_tomo.tomo_id
WHERE (((tbl_distinventario.sucursal)=".$_SESSION['usuario_sucursal'].") AND ((tbl_inventario.estatus)=1))
GROUP BY tbl_inventario.cod_producto, tbl_inventario.descripcion, tbl_inventario.autor, tbl_inventario.precio, tbl_inventario.isbn, tbl_inventario.cod_barra, tbl_editorial.editorial, tbl_formato.descripcion, tbl_inventario.n_coleccion, tbl_coleccion.col_descripcion, tbl_edicion.descripcion, tbl_tomo.descripcion
HAVING (((Sum(tbl_distinventario.cantidad))>0));
";		$result = $obj->consultar_remoto($query);		$j=0;			$libros="";				while ($lib = mysql_fetch_array($result)){
		$libros.=$lib['codigo']."|".$lib['titulo']."|".$lib['autornom']."|".$lib['edit']."|".$lib['coleccion']."|".$lib['nrocoleccion']."|".$lib['formato']."|".$lib['edicion']."|".$lib['tomo']."|".$lib['pvp']."|".$lib['existencia']."|".$lib['isbnl']."|".$lib['barras']."\n";				$j++;		}
		$fh = fopen("../consultas/libros.txt", "w");		fwrite($fh, $libros);		fclose($fh);		shell_exec("chmod 777 -R /var/www/html/sigeslib/consultas/");
}




$fechamod=date("Y-m-d H:i:s"); 
$usuario=$_SESSION['usuario_id'];

if ($_SESSION['usuario_nivel']<$nivel_acceso && $_SESSION['usuario_nivel']!=2){

echo utf8_encode("Usted no tiene permisos para realizar esta operación");

}else{
$obj=new manejadordb;

$tiporegistro=trim($_POST['tipor']);

if($tiporegistro==1){

$codigo=trim($_POST['codigo']);
$titulo=utf8_decode(trim($_POST['titulo']));
$autor=utf8_decode(trim($_POST['autor']));
$proveedor=trim($_POST['proveedor']);
$editorial=trim($_POST['editorial']);
$tema=trim($_POST['tema']);
$subtema=trim($_POST['subtema']);
$isbn=trim($_POST['isbn']);
$codbarra=trim($_POST['codbarra']);
$coleccion=$_POST['coleccion'];
$costo=$_POST['costo'];
$pvp=$_POST['pvp'];
$existencia=$_POST['existencia'];


if($codigo!="" && $titulo!="" && $autor!="" && $costo > 0 && $pvp > 0 && $isbn!="" && $codbarra!=""){
		if($obj->query_remoto("insert into tbl_inventario (cod_producto,descripcion,autor,coleccion,editorial,precio,isbn,tema,subtema,cod_barra,proveedor,cantidad,costo)values('$codigo','$titulo','$autor',$coleccion,$editorial,$pvp,'$isbn',$tema,$subtema,'$codbarra',$proveedor,$existencia,$costo)")==true){
		echo utf8_encode("Operación realizada con éxito");
		}else echo utf8_encode("Este libro ya fué incluido");

}else echo utf8_encode("Error al procesar la operación");

}elseif($tiporegistro==2){

$codigo=trim($_POST['codigo']);
$titulo=utf8_decode(trim($_POST['titulo']));
$autor=utf8_decode(trim($_POST['autor']));
$isbn=trim($_POST['isbn']);
$codbarra=trim($_POST['codbarra']);
$existencia=trim($_POST['existencia']);

if($codigo!="" && $titulo!="" && $autor!="" && $isbn!="" && $codbarra!=""){
$resul=$obj->consultar("select * from tbl_sucursal");
 
while($row=mysql_fetch_assoc($resul)){
$obj->query("insert into tbl_distinventario (cod_producto,descripcion,autor,isbn,cod_barra,sucursal,condicion,cantidad)values('$codigo','$titulo','$autor','$isbn','$codbarra',".$row['id_sucursal'].",1,0)");
$obj->query("insert into tbl_distinventario (cod_producto,descripcion,autor,isbn,cod_barra,sucursal,condicion,cantidad)values('$codigo','$titulo','$autor','$isbn','$codbarra',".$row['id_sucursal'].",2,0)");
$obj->query("insert into tbl_distinventario (cod_producto,descripcion,autor,isbn,cod_barra,sucursal,condicion,cantidad)values('$codigo','$titulo','$autor','$isbn','$codbarra',".$row['id_sucursal'].",3,0)");
}
echo utf8_encode("Libros distribuidos correctamente");

}else echo utf8_encode("Error al procesar la operación por favor verifique los datos");

}elseif($tiporegistro==3){
$editorial=trim($_POST['editorial']);

if($editorial!=""){

	$query = "SELECT * FROM tbl_editorial where (((editorial)='$editorial'));";
	$result = $obj->consultar($query);
	$num = mysql_num_rows($result);
	if($num==0){
		if($obj->query("insert into tbl_editorial (editorial)values('$editorial')")==true){
			echo utf8_encode("Operación realizada con éxito");
		}
		
	}else echo utf8_encode("Ya existe esta editorial");

}else echo utf8_encode("Error al procesar la operación por favor verifique los datos");

}elseif($tiporegistro==4){
$coleccion=trim($_POST['coleccion']);

if($coleccion!=""){

	$query = "SELECT * FROM tbl_coleccion where (((col_descripcion)='$coleccion'));";
	$result = $obj->consultar($query);
	$num = mysql_num_rows($result);
	if($num==0){
		if($obj->query("insert into tbl_coleccion (col_descripcion)values('$coleccion')")==true){
			echo utf8_encode("Operación realizada con éxito");
		}
		
	}else echo utf8_encode("Ya existe esta colección");

}else echo utf8_encode("Error al procesar la operación por favor verifique los datos");

}elseif($tiporegistro==5){
$tema=trim($_POST['tema']);

if($tema!=""){

	$query = "SELECT * FROM tbl_tema where (((tema)='$tema'));";
	$result = $obj->consultar($query);
	$num = mysql_num_rows($result);
	if($num==0){
		if($obj->query("insert into tbl_tema (tema)values('$tema')")==true){
			echo utf8_encode("Operación realizada con éxito");
		}
		
	}else echo utf8_encode("Ya existe este tema");

}else echo utf8_encode("Error al procesar la operación por favor verifique los datos");

}elseif($tiporegistro==6){

$tema=trim($_POST['tema']);
$subtema=trim($_POST['subtema']);


if($tema!="" && $subtema!="" && $tema!=0){

	$query = "SELECT * FROM tbl_subtema where subtema='$subtema' and id_tema=$tema;";
	$result = $obj->consultar($query);
	$num = mysql_num_rows($result);
	if($num==0){
		if($obj->query("insert into tbl_subtema (id_tema,subtema)values($tema,'$subtema')")==true){
			echo utf8_encode("Operación realizada con éxito");
		}
		
	}else echo utf8_encode("Ya existe este subtema");

}else echo utf8_encode("Error al procesar la operación por favor verifique los datos");

}elseif($tiporegistro==7){

$codigo=trim($_POST['codigo']);
$titulo=utf8_decode(trim($_POST['titulo']));
$autor=utf8_decode(trim($_POST['autor']));
$proveedor=trim($_POST['proveedor']);
$editorial=trim($_POST['editorial']);
$tema=trim($_POST['tema']);
$subtema=trim($_POST['subtema']);
$isbn=trim($_POST['isbn']);
$codbarra=trim($_POST['codbarra']);
$coleccion=$_POST['coleccion'];
$costo=$_POST['costo'];
$pvp=$_POST['pvp'];
$existencia=$_POST['existencia'];
$condicion=$_POST['condicion'];
$sucursal=$_POST['sucursal'];
$masl=$_POST['masl'];
$menosl=$_POST['menosl'];
$deplegal=$_POST['deplegal'];
$formato=$_POST['formato'];
$volumen=$_POST['volumen'];
$nedicion=$_POST['nedicion'];
$ncoleccion=$_POST['ncoleccion'];
$tomo=$_POST['tomo'];
	
	
if($codigo!="" && $titulo!="" && $autor!="" && $costo > 0 && $pvp > 0 && $condicion!=""){
	if(($obj->query_remoto("update tbl_inventario set descripcion='$titulo',autor='$autor',coleccion=$coleccion,editorial=$editorial,precio=$pvp,isbn='$isbn',tema=$tema,subtema=$subtema,cod_barra='$codbarra',proveedor=$proveedor,cantidad=cantidad+$masl,cantidad=cantidad-$menosl,costo=$costo,nd_legal='$deplegal',formato=$formato,volumen=$volumen,n_edicion=$nedicion,n_coleccion=$ncoleccion,tomo=$tomo,f_ult_mod='$fechamod',modificado_por=$usuario where cod_producto='$codigo';")==true)&&($obj->query("update tbl_distinventario set descripcion='$titulo',autor='$autor',isbn='$isbn',cod_barra='$codbarra',cantidad=cantidad+$masl,cantidad=cantidad-$menosl where cod_producto='$codigo' and condicion=$condicion and sucursal=$sucursal;"))==true){
	
	$obj->query_remoto("update tbl_distinventario set descripcion='$titulo',autor='$autor',isbn='$isbn',cod_barra='$codbarra' where cod_producto='$codigo' and sucursal=$sucursal;");
	
	arreglo_libros();

	echo utf8_encode("Operación realizada con éxito");
	}else echo utf8_encode("No se pudo modificar el libro");

}else echo utf8_encode("Error al procesar la operación");

}elseif($tiporegistro==8){

$codigo=trim($_POST['codigo']);
$sucursal=$_POST['sucursal'];
$desc=$_POST['desc']/100;

if($codigo!="" && $sucursal!="" && $desc>=0 && $desc<=1){
	if(($obj->query("update tbl_distinventario set descuento=$desc where cod_producto='$codigo' and sucursal=$sucursal;"))==true){
		echo utf8_encode("El Descuento fué aplicado");
	}else echo utf8_encode("No se pudo aplicar el descuento");

}else echo utf8_encode("Error al procesar la operación");

}

}
?>
