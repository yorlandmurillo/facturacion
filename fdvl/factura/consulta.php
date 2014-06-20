<? 
require("admin/session.php");// // incluir motor de autentificación.
include_once('clases/fecha.php');
include_once('funciones/form.php');
include_once('clases/factura.php');
$tipo = $_GET['tipo'];
$cliente = $_GET['cliente'];
$pagina=$_GET['pagina'];

$ordenar=$_GET['orden'];
if($ordenar=="precio")
	$orden="precio_unid desc";
elseif($ordenar=="id")
	$orden="id_itemfactura desc";
elseif($ordenar=="descripcion")
	$orden="descripcion";
else
	$orden="id_itemfactura desc";
	
//echo "-*->".$ordenar."-*-".$orden;

	
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.
if ($_SESSION['usuario_nivel'] < $nivel_acceso){
	Header ("Location: PATH_TO_ERRO_PAG?error_login=5");
	exit;
}
?>
<?
//Configuracion de la conexion a base de datos
//include_once("manejadordb.php");
//creamos el objeto $obj
$obj=new manejadordb;
$modo=$obj->getmodo($maquina);
//die("-*->".$modo."<-*-");
//consulta todos los empleados
$factura=$_SESSION['factura'];
$suc=$_SESSION['usuario_sucursal'];
$vend=$_SESSION['usuario_id'];

$max_titulo=10;

if($tipo=="n")
	$limit=$max_titulo;
elseif($tipo=="m")
	$limit=$max_titulo-2;
//Cantidad de títulos por página
//$limit=8;
$cuenta= $obj->consultar("select * from tbl_itemfactura where cod_factura='$factura' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=0");
$nf_items=mysql_num_rows($cuenta);
//Determinar cantidad de paginas
if($nf_items <= $limit)
{
	$pages=1;
}
else
{
	$cociente = floor($nf_items / $limit);
    $resto = $nf_items % $limit;
    if($resto > 0)
		$add=1;
	else $add=0;
	$pages=$cociente+$add;
}
//Comienzo de la pagina
$comienzo=$limit*($pagina-1);
//echo "select * from tbl_itemfactura where cod_factura='$factura' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=0 order by ".$orden." limit $comienzo,$limit<br>";
$lista= $obj->consultar("select * from tbl_itemfactura where cod_factura='$factura' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=0 order by ".$orden." limit $comienzo,$limit");
//muestra los datos consultados
//haremos uso de tabla para tabular los resultados
?>
<script>
new Ajax.InPlaceEditor($('myText'), 'javascript:saveText("myText")', {
ajaxOptions: {method: 'get'}
});
</script>

<div align=center><font size=4><?echo $nf_items." ";?>t&iacute;tulos a facturar - Paginas:<?

for($i=1;$i<=$pages;$i++)
{
	echo " ";
	if($pagina==$i)
	{
		echo $i;
	}
	else
	{
		?>
		<a href='additemfactura.php?tipo=<?echo $tipo;?>&cliente=<?echo $cliente;?>&pagina=<?echo $i;?>&orden=<?echo $ordenar;?>'><strong><?echo $i;?></strong></a>
		<?
	}
}
?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ordenar por:
<a href='additemfactura.php?tipo=<?echo $tipo;?>&cliente=<?echo $cliente;?>&pagina=<?echo $pagina;?>&orden=id'><strong>Ingreso a la lista</strong></a>&nbsp;
<a href='additemfactura.php?tipo=<?echo $tipo;?>&cliente=<?echo $cliente;?>&pagina=<?echo $pagina;?>&orden=descripcion'><strong>T&iacute;tulo</strong></a>&nbsp;
<a href='additemfactura.php?tipo=<?echo $tipo;?>&cliente=<?echo $cliente;?>&pagina=<?echo $pagina;?>&orden=precio'><strong>Precio</strong></a>

</font></div>

<table align="left" width="584" height="0" border="0" cellpadding="0" id="textContent" name="tabla1">
<tr>
<td width="85" height="5" align="center" bgcolor="#990000" class="celda"><span class="style3">C&oacute;digo</span></td>
<td width="369" height="5" align="center" bgcolor="#990000" class="celda"><span class="style3">Descripci&oacute;n</span></td>
<td width="138" height="5" align="center" bgcolor="#990000" class="celda"><span class="style3">Precio Unid. </span></td>
<td width="77" height="5" align="center" bgcolor="#990000" class="celda"><span class="style3">Cant.</span></td>
<td width="72" height="5" align="center" bgcolor="#990000" class="celda"><span class="style3">% Desc.</span></td>
<td width="72" height="5" align="center" bgcolor="#990000" class="celda"><span class="style3">IVA.</span></td>
</tr>
<?
$i=0;
$mostrariva=0;
$monto_iva_total=0;
while($row = mysql_fetch_array($lista))
{
	$monto_iva_total+=($row['precio_unid']*$row['cantidad'])*$row['iva'];

	if($row['iva']==0){
	$mostrariva="(E)";
	}else $mostrariva=($row['iva']*100)."%";


	echo "<tr ondblclick=\"borraritem('".$row['id_itemfactura']."','".$row['cod_producto']."','".$row['cantidad']."','".$suc."');return false\" class='selecionada' >";
	echo "<td width='85' height='5' align='left' class='selecionada'>".$row['cod_producto']."</td>";
	echo "<td width='389' height='5' align='left' class='selecionada'>".$row['descripcion']."</td>";
	if($modo==1||$tipo=="m")
		$editprecio="<img src='imagenes/paper&pencil_48.png' width=15 height=15 border=0 title='Editar Precio'  onclick=\"actualizarpvp('".$row['id_itemfactura']."','".$row['cod_producto']."','".$row['cantidad']."','".$suc."','".$factura."','".$_SESSION['usuario_id']."');return false\" style='cursor:pointer'></td>";
	else
		$editprecio="";
		
	echo "<td width='141' height='5' align='center'class='selecionada' >".number_format($row['precio_unid'],2,',','.').$editprecio;
	echo "<td width='77'  height='5' align='center' class='selecionada'>".$row['cantidad']."</td>";
	echo "<td width='72' height='5' align='center'  class='selecionada'>".($row['descuento']*100)."</td>";
	echo "<td width='72' height='5' align='center'  class='selecionada'>".$mostrariva."</td>";
	echo "	</tr>";

	$i++;
}
?>
</table>
