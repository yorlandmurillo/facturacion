<? 
require("../admin/session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=3;// definir nivel de acceso para esta página.

if ($_SESSION['usuario_nivel']!=$nivel_acceso && $_SESSION['usuario_nivel']!=2){

echo utf8_encode("Usted no tiene permisos para realizar esta operación");

}else{
$obj=new manejadordb;

$codt=trim($_POST['codt']);
$cods=trim($_POST['cods']);
$suc=$_POST['suc'];
$cant=$_POST['cant'];
$iditem=$_POST['iditem'];
$cond=$_POST['cond'];
$todos=$_POST['todos'];

if(!empty($codt) && !empty($cods) && !empty($cond) && $suc>0 && $cant>0){

		$result=$obj->consultar("select * from tbl_itemsolicitud where id=$iditem;");
		$row=mysql_fetch_assoc($result);
		$codigo=$row['cod_libro'];
		$result=$obj->consultar_remoto("select * from tbl_inventario where cod_producto='$codigo';");
		$row=mysql_fetch_assoc($result);

if(mysql_num_rows($obj->consultar("select * from tbl_itemtraslado where cod_t='$codt' and cod_l='$codigo' and sucursal=$suc and condicion=$cond and estatus=12;"))==0){
		$obj->query("insert into tbl_itemtraslado (cod_t,cod_l,sucursal,cantidad,condicion,titulo,autor,coleccion,editorial,tema,subtema,precio,costo,descuento,isbn,cod_barra,solicitud,estatus,idorigen)values('$codt','".$row['cod_producto']."',$suc,$cant,".$obj->setcondicionsol($cods).",'".$row['descripcion']."','".$row['autor']."',".$row['coleccion'].",".$row['editorial'].",".$row['tema'].",".$row['subtema'].",".$row['precio'].",".$row['costo'].",".$row['descuento'].",'".$row['isbn']."','".$row['cod_barra']."','$cods',12,$iditem);");
	$obj->query("update tbl_itemsolicitud set cantdist=cantdist+$cant where id=$iditem");
}elseif(mysql_num_rows($obj->consultar("select * from tbl_itemtraslado where cod_t='$codt' and cod_l='$codigo' and sucursal=$suc and condicion=$cond and estatus=12;"))>0){
	$obj->query("update tbl_itemtraslado set cantidad=cantidad+$cant where cod_t='$codt' and cod_l='$codigo' and sucursal=$suc and estatus=12;");
	$obj->query("update tbl_itemsolicitud set cantdist=cantdist+$cant where id=$iditem");
}

}elseif(!empty($codt) && !empty($cods) && !empty($cond) && $suc>0 && $todos==1){

		$result=$obj->consultar("select * from tbl_itemsolicitud where cod_sol='$cods' and cantdist<cantidad;");

	while($row1=mysql_fetch_assoc($result)){

		$codigo=$row1['cod_libro'];
		$idit=$row1['id'];
		$cantidad=$row1['cantidad']-$row1['cantdist'];
		
		$result1=$obj->consultar_remoto("select * from tbl_inventario where cod_producto='$codigo';");

		$row=mysql_fetch_assoc($result1);

		if(mysql_num_rows($obj->consultar("select * from tbl_itemtraslado where cod_t='$codt' and cod_l='$codigo' and sucursal=$suc and condicion=$cond and estatus=12;"))==0){
		$obj->query("insert into tbl_itemtraslado (cod_t,cod_l,sucursal,cantidad,condicion,titulo,autor,coleccion,editorial,tema,subtema,precio,costo,descuento,isbn,cod_barra,solicitud,estatus,idorigen)values('$codt','".$row['cod_producto']."',$suc,$cantidad,".$obj->setcondicionsol($cods).",'".$row['descripcion']."','".$row['autor']."',".$row['coleccion'].",".$row['editorial'].",".$row['tema'].",".$row['subtema'].",".$row['precio'].",".$row['costo'].",".$row['descuento'].",'".$row['isbn']."','".$row['cod_barra']."','$cods',12,$idit);");
		$obj->query("update tbl_itemsolicitud set cantdist=cantdist+$cantidad where id=$idit");
		}elseif(mysql_num_rows($obj->consultar("select * from tbl_itemtraslado where cod_t='$codt' and cod_l='$codigo' and sucursal=$suc and condicion=$cond and estatus=12;"))>0){

		$obj->query("update tbl_itemtraslado set cantidad=cantidad+$cantidad where cod_t='$codt' and cod_l='$codigo' and sucursal=$suc and estatus=12;");
		
		$obj->query("update tbl_itemsolicitud set cantdist=cantdist+$cantidad where id=$idit");

		}
	
	}
}

if(!empty($codt)){
		$obj->traslados($_POST['codt']);
}

}
?>