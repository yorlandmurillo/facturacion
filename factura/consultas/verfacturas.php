<?
include("../admin/manejadordb.php");// // incluir motor de autentificación.

function cambiaf_a_normal($fechaval){
  	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fechaval, $mifecha);
   	$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
   	return $lafecha;
} 
function cambiaf_a_mysql($fecha){
  	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
  	$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
   	return $lafecha;
} 

//variables POST
$codf=trim($_POST['codf']);
$facturamanual=$_POST['facturamanual'];
$findme   = '0';
while (strpos($facturamanual, $findme) === 0) {
    $facturamanual=substr ($facturamanual,1);
}


$cedula=trim($_POST['ced']);
if(isset($_POST['fecha1']) && !empty($_POST['fecha1'])){
$fecha1=cambiaf_a_mysql(trim($_POST['fecha1']))." "."00:00:00";
}
if(isset($_POST['fecha2']) && !empty($_POST['fecha2'])){
$fecha2=cambiaf_a_mysql(trim($_POST['fecha2']))." "."23:59:59";
}

$vend=$_POST['vend'];
$suc=$_POST['suc'];
$todas=$_POST['todas'];
$hoy=$_POST['hoy'];


$obj=new manejadordb;

$query_user="select * from tbl_usuario where id_usuario='$vend'";
$result_user=$obj->consultar($query_user);

if(mysql_num_rows($result_user)>0){
	while($row_user = mysql_fetch_assoc($result_user)){
		$us_nivel=$row_user["us_nivel"];
	}

}else echo "No Encontro el usuario";




//consulta de facturas
if(!empty($facturamanual)){
$query="SELECT tbl_facturas.cod_factura as factura, tbl_facturas.fecha_factura as fecha,tbl_facturas.cod_cliente as cliente, 
tbl_facturas.mto_total as monto, estatus_factura,tbl_usuario.us_login as vendedor, tbl_sucursal.sucursal as sucursal, 
tbl_estatus.estatus as estatus
FROM ((tbl_facturas INNER JOIN tbl_sucursal ON tbl_facturas.sucursal = tbl_sucursal.id_sucursal) 
INNER JOIN tbl_usuario ON tbl_facturas.vendedor = tbl_usuario.id_usuario) 
INNER JOIN tbl_estatus ON tbl_facturas.estatus_factura = tbl_estatus.id_estatus
WHERE ((codfacturamanual like '%$facturamanual') OR (numtalonario like '%$facturamanual')) AND ((tbl_sucursal.id_sucursal)=$suc) AND ((tbl_facturas.tipofactura) in (1,3))";
} elseif(!empty($codf) && empty($fecha1) && empty($fecha2)){
$query="SELECT tbl_facturas.cod_factura as factura, tbl_facturas.fecha_factura as fecha,tbl_facturas.cod_cliente as cliente, tbl_facturas.mto_total as monto, estatus_factura,tbl_usuario.us_login as vendedor, tbl_sucursal.sucursal as sucursal, tbl_estatus.estatus as estatus
FROM ((tbl_facturas INNER JOIN tbl_sucursal ON tbl_facturas.sucursal = tbl_sucursal.id_sucursal) INNER JOIN tbl_usuario ON tbl_facturas.vendedor = tbl_usuario.id_usuario) INNER JOIN tbl_estatus ON tbl_facturas.estatus_factura = tbl_estatus.id_estatus
WHERE (((tbl_facturas.cod_factura)='$codf') AND ((tbl_sucursal.id_sucursal)=$suc) AND ((tbl_facturas.tipofactura) in (1,3)))";
} elseif(!empty($codf) && !empty($fecha1) && !empty($fecha2)){
$query="SELECT tbl_facturas.cod_factura as factura, tbl_facturas.fecha_factura as fecha,tbl_facturas.cod_cliente as cliente, tbl_facturas.mto_total as monto, estatus_factura, tbl_usuario.us_login as vendedor, tbl_sucursal.sucursal as sucursal, tbl_estatus.estatus as estatus
FROM ((tbl_facturas INNER JOIN tbl_sucursal ON tbl_facturas.sucursal = tbl_sucursal.id_sucursal) INNER JOIN tbl_usuario ON tbl_facturas.vendedor = tbl_usuario.id_usuario) INNER JOIN tbl_estatus ON tbl_facturas.estatus_factura = tbl_estatus.id_estatus
WHERE (((tbl_facturas.cod_factura)='$codf') AND ((tbl_sucursal.id_sucursal)=$suc) and ((tbl_facturas.tipofactura)in (1,3)))";
}elseif(empty($codf) && !empty($fecha1) && !empty($fecha2)){
$query="SELECT tbl_facturas.cod_factura as factura, tbl_facturas.fecha_factura as fecha,tbl_facturas.cod_cliente as cliente, tbl_facturas.mto_total as monto, estatus_factura, tbl_usuario.us_login as vendedor, tbl_sucursal.sucursal as sucursal, tbl_estatus.estatus as estatus
FROM ((tbl_facturas INNER JOIN tbl_sucursal ON tbl_facturas.sucursal = tbl_sucursal.id_sucursal) INNER JOIN tbl_usuario ON tbl_facturas.vendedor = tbl_usuario.id_usuario) INNER JOIN tbl_estatus ON tbl_facturas.estatus_factura = tbl_estatus.id_estatus
WHERE (((tbl_sucursal.id_sucursal)=$suc) AND ((tbl_facturas.tipofactura)in (1,3)) AND ((tbl_facturas.fecha_factura) Between '$fecha1' And '$fecha2' ))";
}
if(!empty($todas) && $todas==1){
$query="SELECT tbl_facturas.cod_factura AS factura, tbl_facturas.fecha_factura AS fecha,tbl_facturas.cod_cliente as cliente, tbl_facturas.mto_total AS monto, estatus_factura, tbl_usuario.us_login AS vendedor, tbl_sucursal.sucursal AS sucursal, tbl_estatus.estatus AS estatus
FROM ((tbl_facturas INNER JOIN tbl_sucursal ON tbl_facturas.sucursal = tbl_sucursal.id_sucursal) INNER JOIN tbl_usuario ON tbl_facturas.vendedor = tbl_usuario.id_usuario) INNER JOIN tbl_estatus ON tbl_facturas.estatus_factura = tbl_estatus.id_estatus
WHERE (((tbl_facturas.sucursal)=$suc) and ((tbl_facturas.tipofactura)in (1,3)))";
}elseif(!empty($hoy) && $hoy==1){
$fecha1=date('Y-m-d')." "."00:00:00";
$fecha2=date('Y-m-d')." "."23:59:59";
$query="SELECT tbl_facturas.cod_factura as factura, tbl_facturas.fecha_factura as fecha,tbl_facturas.cod_cliente as cliente, tbl_facturas.mto_total as monto, estatus_factura, tbl_usuario.us_login as vendedor, tbl_sucursal.sucursal as sucursal, tbl_estatus.estatus as estatus
FROM ((tbl_facturas INNER JOIN tbl_sucursal ON tbl_facturas.sucursal = tbl_sucursal.id_sucursal) INNER JOIN tbl_usuario ON tbl_facturas.vendedor = tbl_usuario.id_usuario) INNER JOIN tbl_estatus ON tbl_facturas.estatus_factura = tbl_estatus.id_estatus
WHERE (((tbl_sucursal.id_sucursal)=$suc) AND ((tbl_facturas.tipofactura)in (1,3)) AND ((tbl_facturas.fecha_factura) Between '$fecha1' And '$fecha2' ))";
}elseif(!empty($cedula) && empty($codf) && empty($fecha1) && empty($fecha2)){
$query="SELECT tbl_facturas.cod_factura as factura, tbl_facturas.fecha_factura as fecha,tbl_facturas.cod_cliente as cliente, tbl_facturas.mto_total as monto, estatus_factura, tbl_usuario.us_login as vendedor, tbl_sucursal.sucursal as sucursal, tbl_estatus.estatus as estatus
FROM ((tbl_facturas INNER JOIN tbl_sucursal ON tbl_facturas.sucursal = tbl_sucursal.id_sucursal) INNER JOIN tbl_usuario ON tbl_facturas.vendedor = tbl_usuario.id_usuario) INNER JOIN tbl_estatus ON tbl_facturas.estatus_factura = tbl_estatus.id_estatus
WHERE (((tbl_facturas.cod_cliente)='$cedula') AND ((tbl_sucursal.id_sucursal)=$suc) AND ((tbl_facturas.tipofactura)in (1,3)));";
}
?>
<table align="center" width="700" height="0" border="0" cellpadding="0" id="textContent" name="tabla" class="Mtable"> 
<tr>
<th height="5" align="center" bgcolor="#990000" class="celda"><strong>C&oacute;digo</strong></th>
<th height="5" align="center" bgcolor="#990000" class="celda"><strong>Fecha Emici&oacute;n</strong></th>
<th height="5" align="center" bgcolor="#990000" class="celda"><strong>Monto Bs.</strong></th>
<th height="5" align="center" bgcolor="#990000" class="celda"><strong>Vendedor</strong></th>
<th height="5" align="center" bgcolor="#990000" class="celda"><strong>Sucursal</strong></th>
<th height="5" align="center" bgcolor="#990000" class="celda"><strong>Estatus</strong></th>
<th height="5" align="center" bgcolor="#990000" class="celda"><div align="center"><strong>Imprimir</strong></div></th>
<?
if ($us_nivel==2){
?>
<th height="5" align="center" bgcolor="#990000" class="celda"><div align="center"><strong>Editar</strong></div></th>
<?
}
?>
</tr>
<?
//die($query);
$result=$obj->consultar($query);

if(mysql_num_rows($result)>0){

$i=0;

while($row = mysql_fetch_assoc($result)){
if($row['estatus_factura']==3)
{
	$monto=$monto+$row['monto'];
}


  if($i%2 == 0)  
         echo "<tr class='TRalter'>\n";
      else
       echo "<tr>\n";

echo "<td height='5' align='right' class='celdad'>".$row['factura']."</td>";
echo "<td height='5' align='right' class='celdad'>".$row['fecha']."</td>";
echo "<td height='5' align='right' class='celdad'>".number_format($row['monto'],2,',','.')."</td>";
echo "<td height='5' align='center' class='celdad'>".$row['vendedor']."</td>";
echo "<td height='5' align='center' class='celdad'>".utf8_encode($row['sucursal'])."</td>";
echo "<td height='5' align='center' class='celdad'>".$row['estatus']."</td>";


echo "<td class='celdad' height='5' align='center'><img src=\"../imagenes/printer.png\" title=\"Imprimir Factura\" style=\"cursor:pointer;\" onclick=\"imprimirf('".$row['factura']."');return false\" />&nbsp;&nbsp;&nbsp;&nbsp;";

  if ($us_nivel==2){
			
	echo "<td class='celdad' height='5' align='center'><img src=\"../imagenes/paper&pencil_48.png\" title=\"Editar Factura\" style=\"cursor:pointer;\" onclick=\"editarf('".$row['factura']."');return false\" />&nbsp;&nbsp;&nbsp;&nbsp;";
}

echo "	</tr>";
 $i++;    
}
echo "<tr class='TRalter'>\n";
if ($us_nivel==2)
{			
	echo "<td colspan='8' height='5' align='right' class='celdad'>...</td>";
}
else
{
echo "<td colspan='7' height='5' align='right' class='celdad'>...</td>";
}
echo "</td>";
echo "</tr>";

echo "<tr class='TRalter'>\n";
if ($us_nivel==2)
{			
	echo "<td colspan='8' height='5' align='right' class='celdad'>Total Bs.: ".number_format($monto,2,',','.')."</td>";
}
else
{
	echo "<td colspan='7' height='5' align='right' class='celdad'>Total Bs.: ".number_format($monto,2,',','.')."</td>";
}
echo "</td>";
echo "</tr>";

}else echo "No Existen Resultados";
?>

</table>
