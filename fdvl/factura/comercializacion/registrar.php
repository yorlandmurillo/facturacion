<? 
require("../admin/session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.

if ($_SESSION['usuario_nivel']<$nivel_acceso && $_SESSION['usuario_nivel']!=2){

echo utf8_encode("Usted no tiene permisos para realizar esta operación");

}else{
$obj=new manejadordb;
/*Tipo de Registro
1= Registrar un item de una solicitud
2= Registrar una solicitud
3= Registrar un traslado
4= Modificar un traslado
*/

$tiporegistro=trim($_POST['tipor']);

if($tiporegistro==1){
$solicitud=trim($_POST['solicitud']);
$codigo=trim($_POST['codigo']);
$titulo=trim($_POST['titulo']);
$cantidad=$_POST['cantidad'];
$costo=$_POST['costo'];
$monto=$_POST['montosol'];
if($solicitud!="" && $codigo!="" && $titulo!="" && $cantidad > 0){
		if($obj->query("insert into tbl_itemsolicitud (cod_sol,cod_libro,titulo,cantidad,costo,total)values('$solicitud','$codigo','$titulo',$cantidad,$costo,$monto)")==true){
$_SESSION['cantidadtotal']+=$cantidad;		
echo utf8_encode("Operación realizada con éxito");
		}else echo utf8_encode("Este libro ya fué incluido");

}else echo utf8_encode("Error al procesar la operación");

}elseif($tiporegistro==2){

$solicitud=trim($_POST['solicitud']);
$proveedor=trim($_POST['proveedor']);
$cond=trim($_POST['cond']);
$formap=trim($_POST['formap']);
$fechae=cambiafamysql(trim($_POST['fechae']));
$fechav=cambiafamysql(trim($_POST['fechav']));
$fechavc=cambiafamysql($_POST['fechavc']);
$monto=$_POST['monto'];
$cantidad=$_SESSION['cantidadtotal'];
if($solicitud!="" && $fechae!="" && $fechav!="" && $monto > 0 && $proveedor!=0){
		if($obj->query("update tbl_solicitud set fecha_entrega='$fechae',fecha_venc='$fechav',fecha_vencconsig='$fechavc',proveedor=$proveedor,canttotal=$cantidad,totalcancelar=$monto,condicion=$cond,formapago=$formap,estatus=19 where codigo='$solicitud'")==true){
echo utf8_encode("Operación realizada con éxito");
unset($_SESSION['cantidadtotal']);
		}else echo utf8_encode("Error al conectar con la base de datos");

}else echo utf8_encode("Error al procesar la operación por favor verifique los datos");

}elseif($tiporegistro==3){
$cods=trim($_POST['cods']);
$codt=trim($_POST['codt']);
$ob=trim($_POST['ob']);

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
		if($obj->query("update tbl_traslados set estatus=18,cargadopor=".$_SESSION['usuario_id'].",fechacarga='".$obj->getfechamysql()."',observaciones='$ob' where cod_traslado='$codt'")==true){
		if($obj->query("update tbl_itemtraslado set estatus=18 where cod_t='$codt'")==true){
			echo utf8_encode("Operación realizada con éxito");
		}
		}else echo utf8_encode("Error al conectar con la base de datos");
}else echo utf8_encode("No ha anexado registros al traslado");

}else echo utf8_encode("Error al procesar la operación por favor verifique los datos");

}elseif($tiporegistro==4){
$cods=trim($_POST['cods']);
$codt=trim($_POST['codt']);
$ob=trim($_POST['ob']);

if($codt!=""){

/*	$query = "SELECT Sum(cantidad) AS cantidad, Sum(cantdist) AS cantdist FROM tbl_itemsolicitud where (((tbl_itemsolicitud.cod_sol)='$cods'));";
	$result = $obj->consultar($query);
	$row = mysql_fetch_assoc($result);
	$cantidad=$row['cantidad'];
	$cantdist=$row['cantdist'];
	
	if($cantidad==$cantdist){
		$obj->query("update tbl_solicitud set estatus=17 where codigo='$cods';");
	}*/

if(mysql_num_rows($obj->consultar("select * from tbl_itemtraslado where cod_t='$codt';"))>0){
		if($obj->query("update tbl_traslados set estatus=0,cargadopor=".$_SESSION['usuario_id'].",fechacarga='".$obj->getfechamysql()."',observaciones='$ob' where cod_traslado='$codt'")==true){
		if($obj->query("update tbl_itemtraslado set estatus=0 where cod_t='$codt'")==true){
			echo utf8_encode("Traslado modificado con éxito");
		}
		}else echo utf8_encode("Error al conectar con la base de datos");
}else echo utf8_encode("Error al procesar la operación");

}else echo utf8_encode("Error al procesar la operación por favor verifique los datos");
}
}
?>