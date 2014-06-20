<?
require("../admin/session.php"); // incluir motor de autentificación.

$year=date(Y);
$month=date(m);
$day=date(d);
$hour=date(H)-1;
$minute=date(i);
$second=date(s);
$fecha=$year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
$mensaje="";
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


	if($obj->verificart($codp,$cond,$suc)>0){

	$sql ="update tbl_distinventario set cantidad=cantidad-$cant WHERE cod_producto='$codp' and sucursal=$suc and condicion=$cond;";
		if($obj->anulartraslado($codt,$fecha,$user)==true){
			$obj->anularitemtraslado($id,$fecha,$usuario);
			$mensaje="Traslado anulado con éxito";
		}
	}else{
	$mensaje="No existe Traslado con ese codigo";
	}
	$obj->query($sql);
	}

echo utf8_encode($mensaje);

}else echo utf8_encode("Ud. no tiene permisos para realizar esta operación");

?>