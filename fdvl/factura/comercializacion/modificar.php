<? 
require("../admin/session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.

if ($_SESSION['usuario_nivel']!=$nivel_acceso && $_SESSION['usuario_nivel']!=2){

echo utf8_encode("Usted no tiene permisos para realizar esta operación");

}else{
$obj=new manejadordb;
/*
op=opciones
1=Eliminar un item de la solicitud
2=Eliminar una solicitud
3=Eliminar un item de un traslado
4=Eliminar un un traslado
*/

$id=$_POST['id'];
$cods=trim($_POST['cods']);
$codt=trim($_POST['codt']);
$op=$_POST['op'];

if(isset($id) && !empty($id) && $op==1){

		if($obj->query("delete from tbl_itemsolicitud where id=$id ")==true){
			echo utf8_encode("Item eliminado con éxito");
		}else echo utf8_encode("Error al conectar con la base de datos");

}elseif(isset($cods) && !empty($cods) && $op==2){
		
		if($obj->query("delete from tbl_solicitud where codigo='$cods' ")==true){
			$obj->query("delete from tbl_itemsolicitud where cod_sol='$cods' ");
			echo utf8_encode("Operación realizada con éxito");
		}else echo utf8_encode("Error al conectar con la base de datos");

}elseif(!empty($id) && !empty($codt) && $op==3){
		
		$query = "SELECT * FROM tbl_itemtraslado where id=$id ";
		$result = $obj->consultar($query);
		$row = mysql_fetch_assoc($result);
		$idorigen=$row['idorigen'];
		$cantdist=$row['cantidad'];

		if($obj->query("update tbl_itemsolicitud set cantdist=cantdist-$cantdist where id=$idorigen;")==true){
			if($obj->query("delete from tbl_itemtraslado where id=$id;")==true){
			echo utf8_encode("item eliminado con éxito");
			}
		}else echo utf8_encode("Error al conectar con la base de datos");
}else echo utf8_encode("Error al procesar la operación");
}
?>