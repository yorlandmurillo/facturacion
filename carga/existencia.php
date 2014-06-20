<?php
include 'conec.php';
//include 'conec_distribuidora2.php';
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
var pagina="existencia.php?codigo="+codigo
location.href=pagina
} 
//setTimeout ("redireccionar()", 2000);
</script>

<script language="javascript">
var agregar
function abrirventana(ventana,nombre,alto,ancho,valor){
   agregar=window.open(ventana+"?codigol="+valor,nombre,'width='+ancho+',height='+alto+',top='+((screen.height/2)-(180.5))+',left='+((screen.width/2)-(310.5))+',toolbar=no,scrollbars=yes,resizable=no,menubar=no,status=no,directories=no,location=no')
  
}

</script>


<?
$totalvendidos=0;
if($_POST['submit']||$_GET['busqueda'])
{ 

	if($_POST['buscar'])
	{
		$buscar=addslashes($_POST['buscar']);
	}
	elseif($_GET['busqueda'])
	{
		$buscar=str_replace(' ','*',$_GET['busqueda']);
	}
	$buscar2=str_replace(' ','*',$buscar);
	
//	$descripcion=$_POST['descripcion'];
	$existencia="select tbl_distinventario.cod_producto,tbl_distinventario.descripcion,tbl_distinventario.autor,tbl_distinventario.editorial,precio,iva,tbl_distinventario.cantidad
	from tbl_inventario, tbl_distinventario
	where ((tbl_distinventario.cod_producto = '".$buscar."') 
	OR (tbl_distinventario.descripcion LIKE '%".$buscar."%') 
	OR (tbl_distinventario.autor LIKE '%".$buscar."%') 
	OR (tbl_distinventario.isbn = '".$buscar."') 
	OR (tbl_distinventario.cod_barra = '".$buscar."'))
	and tbl_inventario.cod_producto=tbl_distinventario.cod_producto
	order by tbl_distinventario.descripcion";
	//die($existencia);
	$result_bienes = mysql_query($existencia,$db) or die("Busca bienes<br>".mysql_error());
	if ($myrow= mysql_fetch_array($result_bienes)) 
	{
		?>
		<h1><b><div align='center'><font size='5'>HAGA CLIC SOBRE EL ARTICULO A BUSCAR</font></div></b></h1><BR>
        <div align=center>
		<?
		echo "<table border=1>";
		echo "<tr class=\"TRalter\"><td><b>CODIGO</b></td><td><b>DESCRIPCION</b></td><td><b>AUTOR</b></td><td><b>EDITORIAL</b></td><td><b>PRECIO</b></td><td><b>CANTIDAD</b></td><td></td></tr>";
		do 
		{
			$precio=number_format($myrow[4],2,",",".");
			if($myrow[5]==2)
				$precio=$precio."<font color='red'><b> + IVA</b></font>";
				
			//echo "<tr class=\"TRalter\" onclick=\"redireccionar('".$myrow[0]."')\">\n";
			?>
            <tr><td><? echo $myrow[0]?></td><td><? echo $myrow[1]?></td><td><? echo $myrow[2]?></td><td><? echo $myrow[3]?></td><td><? echo $precio?></td><td><? echo $myrow[6]?></td>
		
			
			<td align='center'><b><a href="existencia.php?codigol=<? echo $myrow[0]?>&buscar=<? echo $buscar2?>">EDITAR</a></b></td>
			
			
			</tr>
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
	<div align="center"><font size='5'><a href="existencia.php">Regresa al principio</a></font></div><br>
<?
}
elseif($_GET['codigol'])
{
	if($_POST['actualiza'])
	{ 
		$codigo=$_POST['codigo'];
		$cantidad=$_POST['cantidad'];
		$sql_actualiza="update tbl_distinventario set cantidad='$cantidad'where cod_producto='$codigo'";
		if(mysql_query($sql_actualiza))
		{
		?>
		<div align=center>
			<font size=5><b>El registro <? echo $codigo?> ha sido actualizado</b></font>

	<br><br>
	<div align="center"><font size='5'><a href="existencia.php?busqueda=<? echo $_GET['codigol']?>">Regresa al articulo</a></font></div><br>
<?
		}
	}
	else
	{

		$codigol=$_GET['codigol'];
		$origen=getenv("HTTP_REFERER"); 
		$query = "SELECT * FROM tbl_distinventario where cod_producto='$codigol'";
		//die($query);
		$result = mysql_query($query);
		if ($myrow = mysql_fetch_array($result)) 
		{
		?>
			<font size=5><b> <? echo $myrow["cod_producto"] ?></b><br>
			<font size=5><b> <? echo $myrow["descripcion"] ?></b><br>
			<? echo $myrow["autor"] ?><br>
			<? echo $myrow["editorial"] ?><br>
			<form action=""  method="post"> 
			<input type="hidden" name="codigo" value="<?echo $myrow["cod_producto"]?>">
		 <font size=4><font size='5'>CANTIDAD
		 <input type="text" name="cantidad" size="4" maxlength="50" value="<?echo $myrow["cantidad"]?>"><br><br>
		  <b><div align='center'><input type="submit" name="actualiza" value="ACTUALIZAR" />  </div></b>
		 </form>
		 <?
		}
}
	?>
	<br><br>
	<div align='center'><font size='5'><a href="existencia.php">Regresa al principio</a></font></div><br>
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
 <input type="text" name="buscar" size="50" maxlength="50"><br>
  <input type="submit" name="submit" value="Buscar" />  </div></b></font>
 </form>
</body>
</html>
<?
}
?>
