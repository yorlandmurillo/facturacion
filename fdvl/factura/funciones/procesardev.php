<? 
require("../admin/session.php");// // incluir motor de autentificación.

$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.

$obj=new manejadordb;

$codf=$_POST['codf'];
$user=$_SESSION['usuario_id'];
$suc=$_SESSION['usuario_sucursal'];

$lista= $obj->consultar("select * from tbl_itemfactura where cod_factura='codf' and sucursal=$suc and devuelto=15");

while($row = mysql_fetch_array($lista)){


$sql ="insert into tbl_inventario (cod_producto,descripcion,autor,precio,isbn,descuento,cod_barra,cantidad)values('$codp','$titulo','$autor',$precio,'$isbn',$descuento,'$cdb',0)";

$obj->query($sql);

echo "<tr ondblclick=\"borraritem('".$row['id_itemfactura']."','".$row['cod_producto']."','".$row['cantidad']."','".$suc."');return false\" class='selecionada' >";
echo "<td width='85' height='5' align='left' class='selecionada'>".$row['cod_producto']."</td>";
echo "<td width='389' height='5' align='left' class='selecionada'>".$row['descripcion']."</td>";
echo "<td width='141' height='5' align='center'class='selecionada'>".number_format($row['precio_unid'],2,',','.')."</td>";
echo "<td width='77'  height='5' align='center' class='selecionada'>".$row['cantidad']."</td>";
echo "<td width='72' height='5' align='center'  class='selecionada'>".$row['descuento']."</td>";
echo "	</tr>";
}

?>