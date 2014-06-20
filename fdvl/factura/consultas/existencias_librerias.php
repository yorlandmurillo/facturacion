<?
//include 'conec_distribuidora.php';
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
<?

$l=0;
if($_POST["Conectate"]) 
{
	$arreglosuc=explode("-", $_POST["sucursal"]);
	$id_suc=$arreglosuc[0];
	$suc=$arreglosuc[1];
	$l=1;
	$libreria=str_replace(" ","_",$suc);
	?>
		<div align=center><font size=5><b>EXISTENCIA DE BIENES <?echo $libreria;?><br>Ctrl+F para buscar
		</b></font></div>
	<?
	
	if($id_suc==0)
		$condicion1="";
	else
		$condicion1="and tbl_existencia.sucursal='$id_suc'";

	$sql_inventario="SELECT tbl_existencia.cod_producto, tbl_inventario.descripcion as descripcion, tbl_autor.aut_nombre, tbl_editorial.editorial,cantidad,precio,
					iva,cod_barra
					FROM tbl_existencia,tbl_inventario,tbl_autor,tbl_editorial
					where cantidad > 0  ".$condicion1."
					and tbl_existencia.cod_producto=tbl_inventario.cod_producto
					and tbl_inventario.editorial=tbl_editorial.id_editorial
					and tbl_inventario.aut_codigo=tbl_autor.id_autor
					order by descripcion";
		//$result_inventario=$obj->consultar($sql_inventario);
		$result_inventario = mysql_query($sql_inventario,$db_sede) or die("Busca bienes<br>".mysql_error());
		$nf_inventario=mysql_num_rows($result_inventario);
		
		if ($myrow = mysql_fetch_array($result_inventario)) 
		{	
			$n=1;
			?>
				<table class="Mtable" border=1>
				<tr><td></td><td><b>CODIGO</b></td><td><b>TITULO</b></td><td><b>AUTOR</b></td><td><b>EDITORIAL</b></td><td><b>CANT</b></td><td><b>PRECIO</b></td><td><b>CODIGO DE BARRAS</b></td></tr>
			<?
			do 
			{
				$cantidad=$myrow[4];
				$precio=number_format($myrow[5],2,",",".");
				if($myrow[6]==1)
				{
					$iva=0;
				}
				if($myrow[6]==2)
				{
					//$iva=$myrow[5]*0.12;
					$precio=$precio."+ IVA";
				}
				$monto=$cantidad*$myrow[5]*(1+$iva);
				$cod_barra=$myrow[7];
				?>
				<tr class="TRalter"><td><? echo $n;?></td><td><? echo $myrow[0];?></td><td><? echo $myrow[1];?></td><td><? echo $myrow[2];?></td><td><? echo $myrow[3];?></td><td><? echo $myrow[4];?></td><td><? echo $precio;?></td><td><? echo $cod_barra;?></td></tr>
				
				<?$total_monto=$total_monto+$monto;
				$total_cantidad=$total_cantidad+$cantidad;
				
				$n++;
			} while ($myrow = mysql_fetch_array($result_inventario));
			?>
			</table>
			<?
		}
		else
		{
			echo "No se encontraron resultados para esta consulta";
		}
		echo "<br><br><br>";
		?>
		<br><br>
		<div align="center"><a href="existencias_librerias.php"><font size=5 color=blue><b>Regresa al principio</b></font></a></div><br>
	<?
}
if($l==0)
{
	$select="SELECT DISTINCT (tbl_existencia.sucursal) AS existencia_sucursal, tbl_sucursal.sucursal
	FROM tbl_existencia, tbl_sucursal
	WHERE tbl_existencia.sucursal = tbl_sucursal.id_sucursal
	ORDER BY tbl_sucursal.sucursal";
	$result=mysql_query($select) or die($select."<br>".mysql_error());
	?>
	<html>
	<head>
	<link href="js/css_intra/datepickercontrol.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="js/js_intra/datepickercontrol.js"></script>

	</head>
	<body>
	<form name="formu" method="post" action="<?echo $_SERVER['PHP_SELF'];?>" onSubmit="return Validar('txtfecdes','txtfechas')">
	<div align=center><font size=5 color=blue><b>INVENTARIOS</b></font></div>
	<div align=center><font size=3 color=blue><b>FUNDACION LIBRERIAS DEL SUR</b></font></div>

	<div align=center><font size=3><b>SELECCIONE LA SUCURSAL</b></font></div>
	 <select name="sucursal">
	 <option value="0-Todas"selected>Todas</option>
	  <?php
	  while($row = mysql_fetch_row($result))
	   {
	   ?>
	   <option value="<?php echo $row[0]."-".$row[1]; ?>"><?php echo $row[1]; ?></option>
	   <?php
	   }    
	  ?>
	  </select>
	
	 <input type="submit" name="Conectate" value="Consultar" />
	 </form>
	</body>
	</html>
	<?
}
?>
