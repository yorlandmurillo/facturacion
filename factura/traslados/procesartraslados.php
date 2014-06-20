<?
require("../admin/session.php"); // incluir motor de autentificación.

$year=date(Y);
$month=date(m);
$day=date(d);
$hour=date(H)-1;
$minute=date(i);
$second=date(s);
$fecha=$year."-".$month."-".$day." ".$hour.":".$minute.":".$second;

$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=2;// definir nivel de acceso para esta página.

$codt=trim($_POST['codt']);
$user=$_SESSION['usuario_id'];

if ($_SESSION['usuario_nivel'] == $nivel_acceso){

$obj=new manejadordb;

$query="SELECT tbl_itemtraslado.* FROM tbl_traslados INNER JOIN tbl_itemtraslado ON tbl_traslados.cod_traslado = tbl_itemtraslado.cod_t WHERE (((tbl_traslados.cod_traslado)='$codt'));";		
		
$result=$obj->consultar($query);

while($row = mysql_fetch_assoc($result)){	
	$codp=$row['cod_l'];
	$suc=$row['sucursal'];
	$cant=$row['cantidad'];
	$cond=$row['condicion'];
	$titulo=$row['titulo'];
	$autor=$row['autor'];
	$precio=$row['precio'];
	$costo=$row['costo'];
	$descuento=$row['descuento'];
	$isbn=$row['isbn'];
	$cdb=$row['cod_barra'];

$sql1 ="insert into tbl_distinventario (cod_producto,descripcion,autor,isbn,cod_barra,sucursal,condicion,cantidad)values('$codp','$titulo','$autor','$isbn','$cdb',$suc,1,0)";
$sql2 ="insert into tbl_distinventario (cod_producto,descripcion,autor,isbn,cod_barra,sucursal,condicion,cantidad)values('$codp','$titulo','$autor','$isbn','$cdb',$suc,2,0)";
$sql3 ="insert into tbl_distinventario (cod_producto,descripcion,autor,isbn,cod_barra,sucursal,condicion,cantidad)values('$codp','$titulo','$autor','$isbn','$cdb',$suc,3,0)";
$sql4 ="insert into tbl_inventario (cod_producto,descripcion,autor,cantidad,precio,isbn,cod_barra)values('$codp','$titulo','$autor',0,$precio,'$isbn','$cdb');";
$sql5 ="update tbl_inventario set precio=$precio,descuento=$descuento,cantidad=cantidad+$cant,costo=$costo where cod_producto='$codp' ";

$obj->query($sql1);
$obj->query($sql2);
$obj->query($sql3);
$obj->query($sql4);
$obj->query($sql5);

if($obj->verificart($codp,$cond,$suc)>0){

$sql ="update tbl_distinventario set cantidad=cantidad+$cant WHERE cod_producto='$codp' and sucursal=$suc and condicion=$cond ";
	$obj->procesartraslado($codt,$fecha,$user);
	}elseif($obj->verificart($codp,$cond,$suc)==0){
	$sql ="insert into tbl_distinventario (cod_producto,descripcion,autor,isbn,cod_barra,sucursal,condicion,cantidad)values('$codp','$titulo','$autor','$isbn','$cdb',$suc,$cond,$cant)";
	$obj->procesartraslado($codt,$fecha,$user);
	}
	$obj->query($sql);
}

echo utf8_encode("Traslado procesado con éxito");

}else echo utf8_encode("Ud. no tiene permisos para realizar esta operación");

?>