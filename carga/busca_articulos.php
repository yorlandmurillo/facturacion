<?php
include 'conec.php';
include 'conec_distribuidora2.php';

?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
td1:hover{
	background:#CCCCCC;
	color:#990000;
	cursor:pointer;
}
.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}

a {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 15px;
		color: #990000;
        text-decoration: none;

}
a:hover {
	font-family: Tahoma, Arial, sans-serif;
	font-size: 15px;
	color: #5B27D5;
	text-decoration: none;
}
h1 {
        font-family: Tahoma, Arial, sans-serif;
        font-size: 16px;
        font-weight: bold;
}
table{
        padding: 5;
	 border: 1px solid;
	  
}
th {
        font-size : 15px;
        font-family : Tahoma, Arial, sans-serif;
        color : #FFFFFF;
        text-align : center;
        font-weight : bold;
        background-color : #990000;
}
tr:hover {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 15px;
		color:#FFFFFF;
        background-color :#990000; 

}
td {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 15px;
}
TABLE.Mtable TD {
        BORDER-RIGHT: #93bee2 1px solid;
        BORDER-BOTTOM: #c1cdd8 1px solid;
}
TABLE.Mtable TH {
        BORDER-RIGHT: #93bee2 1px solid;
}
TABLE.Mtable {
        border: 1px solid #336699;
}

.TRalter {
        background-color : #F0F0F0; 
		cursor:pointer;
}

TABLE.buscarTable {
        border: 1px solid #336699;
}
input {
        font-size: 15px;
        font-family: Tahoma, Arial, sans-serif;
		
}
</style>
<script language="JavaScript" type="text/javascript">

function redireccionar(codigo) 
{
var pagina="busca_articulos.php?codigo="+codigo
location.href=pagina
} 
//setTimeout ("redireccionar()", 2000);
</script>



<?
$totalvendidos=0;
if($_POST['submit'])
{ 
	$descripcion=$_POST['descripcion'];
	$busca_articulos="select cod_producto,descripcion,aut_nombre,tbl_editorial.editorial,precio,iva
	from tbl_inventario, tbl_editorial, tbl_autor
	where descripcion like '%$descripcion%'
	and tbl_inventario.aut_codigo=tbl_autor.id_autor
	and tbl_inventario.editorial=tbl_editorial.id_editorial
	order by descripcion";
	//die($busca_articulos);
	$result_bienes = mysql_query($busca_articulos,$db) or die("Busca bienes<br>".mysql_error());
	if ($myrow= mysql_fetch_array($result_bienes)) 
	{
		?>
		<h1><b><div align='center'><font size='5'>HAGA CLIC SOBRE EL ARTICULO A BUSCAR</font></div></b></h1><BR>
        <div align=center>
		<?
		echo "<table border=1>";
		echo "<tr class=\"TRalter\"><td><b>CODIGO</b></td><td><b>DESCRIPCION</b></td><td><b>AUTOR</b></td><td><b>EDITORIAL</b></td><td><b>PRECIO</td></tr>";
		do 
		{
			$precio=number_format($myrow[4],2,",",".");
			if($myrow[5]==2)
				$precio=$precio."<font color='red'><b> + IVA</b></font>";
				
			echo "<tr class=\"TRalter\" onclick=\"redireccionar('".$myrow[0]."')\">\n";
			?>
            <td><? echo $myrow[0]?></td><td><? echo $myrow[1]?></td><td><? echo $myrow[2]?></td><td><? echo $myrow[3]?></td><td><? echo $precio?></td></tr>
			<?
		} while ($myrow= mysql_fetch_array($result_bienes));
		echo "</table>";
		?>
        	</div>
        <?
	}
	else
	{
		echo "<b><div align='center'><font  size='5'>No se encontraron resultados para esta consulta</font></div></b><BR>";
	}
	?>
	<br><br>
	<div align="center"><font size='5'><a href="busca_articulos.php">Regresa al principio</a></font></div><br>
<?
}
elseif($_GET['codigo'])
{
	$codigo=$_GET['codigo'];
	$busca_venta="SELECT distinct(tbl_sucursal.sucursal) as libreria, max(date(fecha_factura)) as ultima_fecha, min(date(fecha_factura)),
					sum(cantidad) as total_vendidos,UCASE(descripcion)
					FROM tbl_facturas,tbl_itemfactura,tbl_sucursal
					WHERE tbl_itemfactura.cod_producto='$codigo'
					and tbl_facturas.cod_factura=tbl_itemfactura.cod_factura
					and tbl_facturas.sucursal=tbl_itemfactura.sucursal
					and tbl_sucursal.id_sucursal=tbl_facturas.sucursal
					and estatus_factura='3'
					group by libreria
					order by max(date(fecha_factura)) desc";
	//die($busca_venta);
	$result_venta = mysql_query($busca_venta,$db_distr) or die("Busca ventas<br>".mysql_error());
	if ($myrow= mysql_fetch_array($result_venta)) 
	{
		
		?>
		<h1><b><div align='center'><font size='5'><? echo $codigo." - ".$myrow[4]?></font></div></b></h1><BR>
		<b><div align='center'><font size='3'>LA CANTIDAD VENDIDA SE REFIERE A LOS EJEMPLARES VENDIDOS DESDE QUE SE INSTALO EL NUEVO SISTEMA</font></div></b><BR>
		<?
		echo "<div align='center'><table border=1>";
		echo "<tr><td><b>LIBRERIA</b></td><td><b>ULTIMA FECHA DE VENTA</b></td><td align='center'><b>CANTIDAD VENDIDA (GENERAL)</b></td></tr>";
		do 
		{
			$fecha1=explode("-", $myrow[1]);
			$fecha=$fecha1[2]."/".$fecha1[1]."/".$fecha1[0];
			$fecha2=explode("-", $myrow[2]);
			$fechain=$fecha2[2]."/".$fecha2[1]."/".$fecha2[0];
			$totalvendidos=$totalvendidos+$myrow[3];
			?>
			<tr><td><? echo $myrow[0]?></td><td><? echo $fecha?></td><td><? echo " <b>".$myrow[3]."</b> vendidos desde <b>".$fechain."</b> hasta <b>".$fecha."</b>"?></td></tr>
			<?
		} while ($myrow= mysql_fetch_array($result_venta));
		echo "</table></div>";
		?>
	<br><br>
	<div align='center'><h1><font size='5'><b>TOTAL VENDIDOS=<?echo $totalvendidos;?></b></font><h1></div><br>
		<?
	}
	else
	{
		echo "<b><div align='center'><font  size='5'>No se encontraron resultados para esta consulta</font></div></b><BR>";
	}
	?>
	<br><br>
	<div align='center'><font size='5'><a href="busca_articulos.php">Regresa al principio</a></font></div><br>
<?
}
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ultima vez que se vendio un articulo</title>
</head>

<body>
<h1><div align='center'><font  size='5'>FUNDACION LIBRERIAS DEL SUR</font></div></h1><BR>
<b><div align='center'><font color='blue' size='5'>BUSQUEDA DE ARTICULOS</font></div></b><BR>
<form action=""  method="post">  
 <font size=4><b><div align='center'><font size='5'>ESCRIBA PARTE DEL TITULO DEL ARTICULO A BUSCAR<br>
 <input type="text" name="descripcion" size="50" maxlength="50"><br>
  <input type="submit" name="submit" value="Buscar" />  </div></b></font>
 </form>
</body>
</html>
<?
}
?>
