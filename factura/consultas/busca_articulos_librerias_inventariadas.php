<?php
include 'conec.php';
include 'conec_sede.php';

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
var pagina="busca_articulos_librerias_inventariadas.php?codigo="+codigo
location.href=pagina
} 
//setTimeout ("redireccionar()", 2000);

function esc(){
	window.close(this);
}
</script>



<?
$totalvendidos=0;
if($_POST['submit'])
{ 
	$buscar=$_POST['descripcion'];
	$busca_articulos="select cod_producto,descripcion,aut_nombre,tbl_editorial.editorial,precio,iva
	from tbl_inventario, tbl_editorial, tbl_autor
	where ((cod_producto = '".addslashes($buscar)."') 
	OR (descripcion LIKE '%".addslashes($buscar)."%') 
	OR (isbn = '".addslashes($buscar)."') 
	OR (cod_barra = '".addslashes($buscar)."'))
	and tbl_inventario.aut_codigo=tbl_autor.id_autor
	and tbl_inventario.editorial=tbl_editorial.id_editorial
	order by descripcion";
	//die($busca_articulos);
	$result_bienes = mysql_query($busca_articulos,$db) or die($busca_articulos."<br>Busca bienes<br>".mysql_error());
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
	<div align="center"><font size='5'><a href="busca_articulos_librerias_inventariadas.php">Regresa al principio</a>
	<br><br>
		<input name="salir" type="button" class="botones" onclick="esc()" value="Salir" /></font></div><br>
		
<?
}
elseif($_GET['codigo'])
{
	$codigo=$_GET['codigo'];
	$busca_venta="SELECT distinct(tbl_sucursal.sucursal) as libreria, cantidad,descripcion
					FROM tbl_existencia,tbl_sucursal,tbl_inventario
					WHERE tbl_existencia.cod_producto='$codigo'
					and tbl_sucursal.id_sucursal=tbl_existencia.sucursal
					and tbl_inventario.cod_producto=tbl_existencia.cod_producto
					group by libreria
					order by libreria";
	//die($busca_venta);
	$result_venta = mysql_query($busca_venta,$db_sede) or die($busca_venta."<br>Busca ventas<br>".mysql_error());
	if ($myrow= mysql_fetch_array($result_venta)) 
	{
		
		?>
		<b><div align='center'><font size='3'>EXISTENCIA DEL ARTÍCULO EN LAS LIBRERIAS INVENTARIADAS</font></div></b><BR>
		<h1><b><div align='center'><font size='5'><? echo $codigo." - ".$myrow[2]?></font></div></b></h1><BR>
		
		<?
		echo "<div align='center'><table border=1>";
		echo "<tr><td><b>LIBRERIA</b></td><td align='center'><b>CANTIDAD</b></td></tr>";
		do 
		{
			$totalvendidos=$totalvendidos+$myrow[1];
			?>
			<tr><td><? echo $myrow[0]?></td><td><? echo $myrow[1]?></td></tr>
			<?
		} while ($myrow= mysql_fetch_array($result_venta));
		echo "</table></div>";
		?>
	<br><br>
	<div align='center'><h1><font size='5'><b>TOTAL CANTIDAD=<?echo $totalvendidos;?></b></font><h1></div><br>
		<?
	}
	else
	{
		echo "<b><div align='center'><font  size='5'>No se encontraron resultados para esta consulta</font></div></b><BR>";
	}
	?>
	<br><br>
	<div align='center'><font size='5'><a href="busca_articulos_librerias_inventariadas.php">Regresa al principio</a>
	<br><br>
		<input name="salir" type="button" class="botones" onclick="esc()" value="Salir" /></font></div><br>
<?
}
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BUSQUEDA DE ARTICULOS EN LAS LIBRERIAS INVENTARIADAS</title>
</head>

<body>
<h1><div align='center'><font  size='5'>FUNDACION LIBRERIAS DEL SUR</font></div></h1><BR>
<b><div align='center'><font color='blue' size='5'>BUSQUEDA DE ARTICULOS</font></div></b><BR>
<b><div align='center'><font color='blue' size='5'>EN LIBRERIAS INVENTARIADAS</font></div></b><BR>
<form action=""  method="post">  
 <font size=4><b><div align='center'><font size='5'>ESCRIBA PARTE DEL TITULO DEL ARTICULO A BUSCAR<br>
 <input type="text" name="descripcion" size="50" maxlength="50"><br>
  <input type="submit" name="submit" value="Buscar" /><input name="salir" type="button" class="botones" onclick="esc()" value="Salir" />
	  </div></b></font>
 </form>
</body>
</html>
<?
}
?>
