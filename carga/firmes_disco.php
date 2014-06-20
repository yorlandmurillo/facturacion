<?php
include 'conec.php';

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
var pagina="firmes_disco.php?codigo="+codigo
location.href=pagina
} 
//setTimeout ("redireccionar()", 2000);

function pulsar(e) {
  tecla = (document.all) ? e.keyCode :e.which;
  return (tecla!=13);
}

var agregar

function abreventana() {
 popupWin = window.open('listado_disco.php',"V1","menubar=no,titlebar=no,toolbar=no,location=no,status=no,directories=no,fullscreen") 
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
	where ((tbl_distinventario.cod_producto = '".addslashes($buscar)."') 
	OR (tbl_distinventario.descripcion LIKE '%".addslashes($buscar)."%') 
	OR (tbl_distinventario.autor LIKE '%".addslashes($buscar)."%') 
	OR (tbl_distinventario.isbn = '".addslashes($buscar)."') 
	OR (tbl_distinventario.cod_barra = '".addslashes($buscar)."'))
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
		echo "<tr class=\"TRalter\"><td><b>CODIGO</b></td><td><b>DESCRIPCION</b></td><td><b>AUTOR</b></td><td><b>EDITORIAL</b></td><td><b>PRECIO</b></td><td><b>CANTIDAD</b></td><td></td><td></td></tr>";
		do 
		{
			$precio=number_format($myrow[4],2,",",".");
			if($myrow[5]==2)
				$precio=$precio."<font color='red'><b> + IVA</b></font>";
				
			//echo "<tr class=\"TRalter\" onclick=\"redireccionar('".$myrow[0]."')\">\n";
			$cod_producto=$myrow[0];
			$editorial=$myrow[3];
			if(substr($cod_producto,0,4)=='1111'||substr($cod_producto,0,4)=='0404')
			{
				$cod_producto="<font color=blue><b>".$cod_producto."</b></font>";
				$editorial="<font color=blue><b>".$editorial."</b></font>";
				$firme=1;
			}
			else
			{
				$firme=0;
			}
			
			?>
			
            <tr><td><? echo $cod_producto?></td><td><? echo $myrow[1]?></td><td><? echo $myrow[2]?></td><td><? echo $editorial?></td><td><? echo $precio?></td><td><? echo $myrow[6]?></td>
		
			
			<td align='center'><b><a href="firmes_disco.php?codigol=<? echo $myrow[0]?>&buscar=<? echo $buscar2?>">EDITAR</a></b></td>
			<?
				if($firme==0)
				{
					?>
					<td align='center'><b><a href="firmes_disco.php?codigo2=<? echo $myrow[0]?>"><font color='479211'>CREAR FIRME</font></a></b></td>
						
					<?
				}
				else
				{
					?>
						<td></td>
					<?
				}
			?>
			
			
			
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
	?>
		<b><div align='center'><font  size='5'>NO EXISTE EL LIBRO FIRME</font></div></b>;
		<form action=""  method="post">  
		 <font size=4><b><div align='center'><font size='5'>BUSCAR AUTOR EN LA BASE DE DATOS<br>
		 <input type="text" name="busca_autor" size="50" maxlength="50"><br>
		  <input type="submit" name="buscaautor" value="Buscar" />  </div></b></font>
		 </form>
		
		<?
	}
	?>
	<br><br>
	<div align="center"><font size='5'><a href="firmes_disco.php">Regresa al principio</a></font></div><br>
<?
}
elseif($_POST['buscaautor'])
{ 
	$busca_autor=$_POST['busca_autor'];
	
	$sql_autor="select * 
				from tbl_autor 
				where aut_nombre LIKE '%".addslashes($busca_autor)."%'
				order by id_autor";
	//die($sql_autor);
	$result_autor = mysql_query($sql_autor,$db) or die("Busca autor<br>".mysql_error());
	if ($rowautor= mysql_fetch_array($result_autor)) 
	{
		do 
		{
		?>
			<a href="firmes_disco.php?id_autor=<? echo $rowautor["id_autor"]?>"><? echo $rowautor["id_autor"]?></a>
			<?
			echo "-*->".$rowautor["aut_nombre"]."<br>";
		} while ($rowautor= mysql_fetch_array($result_autor));
	}
	else
	{
		$sql_autor="select * 
				from tbl_cod_autor
				where ocupado= '0'
				order by id
				limit 0,1";
		//die($sql_autor);
		$result_autor = mysql_query($sql_autor,$db) or die("Busca autor<br>".mysql_error());
		if ($rowautor= mysql_fetch_array($result_autor)) 
		{
			$id_autor=$rowautor["codigo_autor"];
			
		}
		else
		{
			die("<div align=center><font=5 color=red><b>NO HAY CODIGOS DE AUTOR DISPONIBLE HAY QUE CREAR NUEVOS</b></font></div>");
		}
		
	?>
		<b><div align='center'><font  size='5'>NO EXISTE AUTOR</font></div></b>
		<form action=""  method="post"> 
		<font size=3>
		ID_AUTOR
		 <input type="text" onkeypress="return pulsar(event)"  name="id_autor" size="50" maxlength="50" value="<?echo $id_autor?>"><br>
		NOMBRE AUTOR
		 <input type="text" onkeypress="return pulsar(event)"  name="nombre" size="50" maxlength="50" value=""><br>
		 PAIS
		 <input type="text" onkeypress="return pulsar(event)"  name="pais" size="30" maxlength="50" value=""><br>
		</font><br>
		  <b><div align='center'><input type="submit" name="creaautor" value="AGREGAR AUTOR" />  </div></b>
		 </form>
		
		<?
	}

	

	
}
elseif($_POST['creaautor'])
{ 
	
	$id_autor=$_POST['id_autor'];
	$nombre=$_POST['nombre'];
	$pais=$_POST['pais'];
	
	$agrega_autor="INSERT INTO `tbl_autor` (`id_autor`, `aut_nombre`, `aut_pais`) VALUES('$id_autor', '$nombre', '$pais')";
	echo $agrega_autor;
	if(mysql_query($agrega_autor))
	{	
		$act_cod_autor="update tbl_cod_autor set ocupado='1' where codigo_autor='$id_autor'";
		mysql_query($act_cod_autor);
		?>
			<script >
				location.href="firmes_disco.php?id_autor=<? echo $id_autor?>";
			</script>
			
		<?
	}
	else
	{
		die("NO SE PUDO AGREGAR EL AUTOR<br>".mysql_error());
	}
}
elseif($_GET['id_autor']||$_GET['codigo2'])
{ 
	if($_GET['id_autor'])
	{
		$id_autor=$_GET['id_autor'];
		$sql_autor="select * 
					from tbl_autor 
					where id_autor= '$id_autor'
					order by id_autor";
		//die($sql_autor);
		$result_autor = mysql_query($sql_autor,$db) or die("Busca autor<br>".mysql_error());
		if ($rowautor= mysql_fetch_array($result_autor)) 
		{
			$nombreautor=$rowautor["aut_nombre"];
		}
		$descripcion="";
		$tomo=0;
		$precio="0.00";
		$isbn="";
		$codbarra="";
	}
	if($_GET['codigo2'])
	{
		$codigod=$_GET['codigo2'];
		$buscalibrod="select * from tbl_inventario where cod_producto='$codigod'";
		$resultbuscalibro = mysql_query($buscalibrod) or die($buscalibrod."<br>".mysql_error());
		if ($rowlibro1= mysql_fetch_array($resultbuscalibro)) 
		{
			
			$busca_distinventario="select * from tbl_distinventario where cod_producto='$codigod'";
			$resultbuscalibro2 = mysql_query($busca_distinventario) or die($busca_distinventario."<br>".mysql_error());
			if($rowlibro2= mysql_fetch_array($resultbuscalibro2)) 
			{
				$nombreautor=$rowlibro2["autor"];
				$presentacion=$rowlibro2["presentacion"];
				$tomo=$rowlibro2["tomo"];
			}
			
			$id_editorial='1111';
			$sql_editorial="select editorial from tbl_editorial where id_editorial='$id_editorial'";
			$resul_editorial = mysql_query($sql_editorial) or die($sql_editorial."<br>".mysql_error());
			if($row_editorial= mysql_fetch_array($resul_editorial)) 
			{
				$editorial=$row_editorial['0'];
			}
			$fechaLarga = date("Y-m-d h:i:s",time());
			
			
			$descripcion=$rowlibro1['descripcion'];
			$id_autor=$rowlibro1['aut_codigo'];
			$tipoarticulo=$rowlibro1['lib_articulo'];
			$precio=$rowlibro1['precio'];
			$iva=$rowlibro1['iva'];
			$isbn=$rowlibro1['isbn'];
			$codbarra=$rowlibro1['cod_barra'];
			$coleccion=$rowlibro1['coleccion'];
			
		}
	}
	elseif($_GET['id_autor'])
	{
		$id_autor=$_GET['id_autor'];
		$sql_autor="select * 
					from tbl_autor 
					where id_autor= '$id_autor'
					order by id_autor";
		//die($sql_autor);
		$result_autor = mysql_query($sql_autor,$db) or die("Busca autor<br>".mysql_error());
		if ($rowautor= mysql_fetch_array($result_autor)) 
		{
			$nombreautor=$rowautor["aut_nombre"];
		}
		$descripcion="";
		$tomo=0;
		$precio="0.00";
		$isbn="";
		$codbarra="";
	}
	
	
	//se busca el codigo del libro
	$sql_libro="select * 
			from tbl_cod_disco
			where ocupado= '0'
			order by id
			limit 0,1";
	//die($sql_libro);
	$result_libro = mysql_query($sql_libro,$db) or die("Busca libro<br>".mysql_error());
	if ($rowlibro= mysql_fetch_array($result_libro)) 
	{
		$codigo=$rowlibro["cod_libro"];
		
	}
	else
	{
		die("<div align=center><font=5 color=red><b>NO HAy CODIGOS DE LIBROS DISPONIBLE HAY QUE CREAR NUEVOS</b></font></div>");
	}
	
	
	
	?>
		<font size=4><b><div align='center'><font size='5'>CREA EL LIBRO FIRME<br>
		 <form action="firmes_disco.php"  method="post">
		 
		 <font size=3>
		 CODIGO
		 <input type="text" onkeypress="return pulsar(event)" name="codigo" size="10" maxlength="50" value="<?echo $codigo?>" readonly="readonly" ><br>
		  <p> <strong>TIPO ARTICULO</strong> 
		<select name="tipoarticulo">
     <option selected>LIBRO</option>
      <option>REVISTA</option>
      <option>DVD</option>
	  <option>CD</option>
	  <option>PERIODICO</option>
	  <option>GUIA</option>
	  <option>ARTESANIA</option>
	<option>OTRO</option>
		</select><br>
		 TITULO
		 <input type="text" onkeypress="return pulsar(event)" name="descripcion" size="80" maxlength="100" value="<?echo $descripcion?>"><br>
		 AUTOR
		 <input type="text" onkeypress="return pulsar(event)"  name="id_autor" size="4" maxlength="50" value="<?echo $id_autor?>"><?echo $nombreautor?>
		 <input type="text" onkeypress="return pulsar(event)"  name="nombreautor" size="50" maxlength="100" value="<?echo $nombreautor?>">
		 
		 <br>
		 TOMO
		 <input type="text" onkeypress="return pulsar(event)"  name="tomo" size="4" maxlength="50" value="<?echo $tomo?>"><br>
		 PRECIO 0.00
		 <input type="text" onkeypress="return pulsar(event)" name="precio" size="10" maxlength="10" value="<?echo $precio?>"><br>
		 <p> <strong>PRESENTACION</strong> 
    <select name="presentacion">
      <option selected>UNICO</option>
      <option>RUSTICO</option>
      <option>EMPASTADO</option>
		</select><br>
		 ISBN
		 <input type="text" onkeypress="return pulsar(event)" name="isbn" size="20" maxlength="50" value="<?echo $isbn?>"></font><br>
		CODIGO DE BARRAS
		 <input type="text" onkeypress="return pulsar(event)"  name="codbarra" size="20" maxlength="50" value="<?echo $codbarra?>"></font><br>
		  <b><div align='center'><input type="submit" name="agregalibro" value="AGREGAR LIBRO" />  </div></b>
		 </form>
		
		<?
}
elseif($_POST['agregalibro'])
{ 
	$fechaLarga = date("Y-m-d h:i:s",time());
	$id_editorial='1111';
	$sql_editorial="select editorial from tbl_editorial where id_editorial='$id_editorial'";
	$resul_editorial = mysql_query($sql_editorial) or die($sql_editorial."<br>".mysql_error());
	if($row_editorial= mysql_fetch_array($resul_editorial)) 
	{
		$editorial=$row_editorial['0'];
	}
	$coleccion=1;
	$iva=1;
	
	$codigo=$_POST['codigo'];
	$descripcion=$_POST['descripcion'];
	$id_autor=$_POST['id_autor'];
	$nombreautor=$_POST['nombreautor'];
	$tomo=$_POST['tomo'];
	$precio=$_POST['precio'];
	$presentacion=$_POST['presentacion'];
	$isbn=$_POST['isbn'];
	$cod_barra=$_POST['codbarra'];
	$libarticulo=$_POST['tipoarticulo'];
	
	
	
		if($libarticulo=="LIBRO")
		$tipoarticulo="L";
	elseif($libarticulo=="REVISTA")
		$tipoarticulo="R";
	elseif($libarticulo=="DVD")
		$tipoarticulo="D";
	elseif($libarticulo=="CD")
		$tipoarticulo="C";
	elseif($libarticulo=="PERIODICO")
		$tipoarticulo="P";
	elseif($libarticulo=="GUIA")
		$tipoarticulo="G";	
	elseif($libarticulo=="ARTESANIA")
		$tipoarticulo="A";	
	elseif($libarticulo=="OTRO")
		$tipoarticulo="OT";

	
	$agrega_distinventario="INSERT INTO `tbl_distinventario` (`cod_producto`, `isbn`, `cod_barra`, `autor`, `descripcion`, `editorial`, `tomo`, `presentacion`, `sucursal`, `condicion`, `cantidad`, `descuento`, `FECHA_NOTA_ENTREGA`) VALUES
	('$codigo', '$isbn', '$cod_barra', '$nombreautor', '$descripcion', '$editorial', '$tomo', '$presentacion', '0000', '0000000001', '0', '0', '$fechaLarga')";
	$result_agrega_distin=mysql_query($agrega_distinventario,$db) or die ("error al insertar distinventario"."<br>".$agrega_distinventario."<br>".mysql_error());

	$agrega_inventario="INSERT INTO `tbl_inventario` (`cod_producto`, `lib_articulo`, `isbn`, `cod_barra`, `descripcion`, `aut_codigo`, `editorial`, `precio`, `coleccion`, `iva`, `fecha_creacion`) VALUES
	('$codigo', '$tipoarticulo', '$isbn', '$cod_barra', '$descripcion', '$id_autor', '$id_editorial', '$precio', 1, '$iva', '$fechaLarga')";
	$result_agrega_inventario=mysql_query($agrega_inventario,$db) or die ("error al insertar distinventario<br>".$agrega_inventario."<br>".mysql_error());
	
	$act_cod_libro="update tbl_cod_disco set ocupado=1 where cod_libro='$codigo'";
	mysql_query($act_cod_libro,$db);

	
	echo "<B>SE AGREGO CORRECTAMENTE EL LIBRO:</B><br>";
		
		echo "<B>CODIGO: </B>".$codigo."<br>";
		echo "<B>TITULO: </B>".$descripcion."<br>";
		echo "<B>AUTOR: </B>".$nombreautor."<br>";
		echo "<B>PRECIO: </B>".$precio."<br>";
	
	//echo $agrega_distinventario."<BR><br>".$agrega_inventario."<BR><br>".$act_cod_libro;
	?>
			<br><br>
			<div align='center'><font size='5'><a href="firmes_disco.php">Regresa al principio</a></font></div><br>
		<?
	
	
	
	
	
	

}
elseif($_GET['codigol'])
{
	if($_POST['actualiza'])
	{ 
		$codigo=$_POST['codigo'];
		$precio=$_POST['precio'];
		$cod_barra=$_POST['cod_barra2'];
		$cantidad=$_POST['cantidad'];
		

		
		$sql_act_inventario="update tbl_inventario set precio='$precio', cod_barra='$cod_barra' where cod_producto='$codigo'";
		if(mysql_query($sql_act_inventario))
		{
		//	die($sql_act_inventario);
			$sql_actualiza="update tbl_distinventario set cantidad='$cantidad', cod_barra='$cod_barra' where cod_producto='$codigo'";
			//die($sql_actualiza);
			if(mysql_query($sql_actualiza))
			{
				?>
				<script >
					location.href="firmes_disco.php";
				</script>
			<?
			}	
		}
	}
	else
	{

		$codigol=$_GET['codigol'];
		$origen=getenv("HTTP_REFERER"); 
		$busca_distinventario = "SELECT * FROM tbl_distinventario where cod_producto='$codigol'";
		//die($query);
		$result_distinventario = mysql_query($busca_distinventario);
		if ($myrow = mysql_fetch_array($result_distinventario)) 
		{
			$cod_producto=$myrow["cod_producto"];
			$isbn=$myrow["isbn"];
			$descripcion=$myrow["descripcion"];
			$autor=$myrow["autor"];
			$editorial=$myrow["editorial"];
			$cod_barra=$myrow["cod_barra"];
			$cantidad=$myrow["cantidad"];
		}
		
		$buscalibrod="select * from tbl_inventario where cod_producto='$codigol'";
		$resultbuscalibro = mysql_query($buscalibrod) or die($buscalibrod."<br>".mysql_error());
		if ($rowlibro1= mysql_fetch_array($resultbuscalibro)) 
		{
			$precio=$rowlibro1['precio'];
		}
			?>
			<div align=center><img src="imagenes/libreria2.gif" alt="Banner"></div>
			<div align='right'><font size='5'><? echo $_SESSION['name']." ".$_SESSION['apellido']." "?><a href="logout.php">SALIR</a></font></div><br><br>
			<font size=5><b> <? echo $cod_producto ?></b><br>
			<font size=5><b> <? echo $descripcion ?></b><br>
			<? echo $autor ?><br>
			<? echo $editorial ?><br>
			<form action=""  method="post">
				 CODIGO
		 <input type="text" onkeypress="return pulsar(event)" name="codigo" size="10" maxlength="50" value="<?echo $codigol?>" readonly="readonly" ><br>
				 ISBN
		 <input type="text" onkeypress="return pulsar(event)" name="isbn" size="20" maxlength="50" value="<?echo $isbn?>" readonly="readonly" ><br>
				PRECIO
		 <input type="text" onkeypress="return pulsar(event)" name="precio" size="4" maxlength="4" value="<?echo $precio?>"></font><br><br>
			 <font size=4>CODIGO DE BARRAS
		 <input type="text" onkeypress="return pulsar(event)" name="cod_barra2" size="20" maxlength="50" value="<?echo $cod_barra?>"><br>
			
			CANTIDAD
		 <input type="text" onkeypress="return pulsar(event)" name="cantidad" size="4" maxlength="50" value="<?echo $cantidad?>"></font><br><br>
		  <b><div align='center'><input type="submit" name="actualiza" value="ACTUALIZAR" />  </div></b>
		 </form>
		 <?
}
	?>
	<br><br>
	<div align='center'><font size='5'><a href="firmes_disco.php">Regresa al principio</a></font></div><br>
<?
}
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Creacion de libros firmes</title>
</head>

<body onload="document.getElementById('txt').focus()">
<h1><div align='center'><font  size='5'>FUNDACION LIBRERIAS DEL SUR</font></div></h1><BR>
<div align='center'><font  size='5'color='red'><b>CENTRO NACIONAL DEL DISCO<b></font></div><BR>
<b><div align='center'><font color='blue' size='5'>BUSQUEDA DE ARTICULOS</font></div></b><BR>
<form action=""  method="post">  
 <font size=4><b><div align='center'><font size='5'>ESCRIBA PARTE DEL TITULO DEL ARTICULO A BUSCAR<br>
 <input type="text" name="buscar" size="50" maxlength="50" id="txt"><br>
  <input type="submit" name="submit" value="Buscar" />  </div></b></font>
 </form>
<br><br>
	<div align="center"><font size='5'><a href="javascript: abreventana();">Reporte bienes contados</a></font></div><br>
</body>
</html>
<?
}
?>
