<html>
	<head>
		<title>Buscar Articulo</title>
		<script src="includes/validation.js" type="text/javascript"></script>
	<link rel="STYLESHEET" type="text/css" href="includes/estilos.css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
	body {
	background-color: #FFF;
}
    #estiloBusqueda form table {
	font-weight: bold;
}
    </style>
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 

<style>
SELECT {
border: solid #000000 1px; FONT-SIZE: 11px; BACKGROUND: #FF3333; COLOR: #ffffff; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
</style>










<?php
include("includes/conexion.php");
//Limito la busqueda 
$TAMANO_PAGINA = 500; 










//examino la página a mostrar y el inicio del registro a mostrar 
$pagina = $_GET["pagina"];
$letra = $_GET["letra"];
$autor = $_GET["autor"];
$editorial = $_GET["editorial"];
$titulo = $_GET["titulo"];
$cod_isbn = $_GET["cod_isbn"];
$coleccion = $_GET["coleccion"];

//$prueba = $_GET["prueba"];


//echo $letra;
$msg = $_GET["msg"]; 
if (!$pagina) { 
    $inicio = 0; 
    $pagina=1; 
} 
else { 
    $inicio = ($pagina - 1) * $TAMANO_PAGINA; 
} 
?>

<div id="estiloBusqueda">

Busqueda de todos los Bienes Culturales 




<script>
function getKey(e){
	if(!e)
		e=window.event;
	if(e.keyCode)
		code=e.keyCode;
	else
		code=e.which;
	if(code===13){
       	 
		document.forms['codbar'].titulo.value='';
		document.forms['codbar'].titulo.focus();
		ponArticulo('document.codbar.titulo.value=titulo');
		
	}
}

</script>
















<form method="get" action="buscaArticulo3.php" name="codbar">

<body onLoad="document.forms['codbar'].titulo.focus();">

	<input type="hidden" name="letra" value="busq">
	<input type="hidden" name="editorial" value="<?php echo($editorial); ?>">
	<table width="100%" cellspacing="0">
	  <tr>
	      <td width="77" height="0" style="color: #000">Titulo: </td>
      <td width="201"><input type="text" id="titulo"   onkeypress="submitEnter(event)" name="titulo" value="<?php echo($titulo); ?>" size="60" maxlength="162"></td>
	      <td width="29">&nbsp;</td>
	      <td width="697">&nbsp;</td>
	      <td width="16" colspan="2" rowspan="3">&nbsp;</td>
      </tr>
	  <tr>
	    <td style="color: #F00">&nbsp;</td>
	    <td><input type="submit"  class="mybutton" value="Buscar"></td>
	  
      <tr>
	   
    </table>
</form>







<form method="post">
	
</form>




 
<?php
//echo "prueba=".$editorial;
if ($letra != "")
{
	///$link=Conectarse();
	
	$link=Conectarse_local();
	
	//construyo la sentencia SQL 
	
	$strSelect="			
				SELECT tbl_distinventario.cod_producto,
				tbl_distinventario.descripcion,
				tbl_distinventario.editorial,
				tbl_distinventario.tomo,
				tbl_distinventario.autor,
				tbl_distinventario.cantidad,
				tbl_inventario.precio,
				tbl_distinventario.presentacion
		        FROM tbl_inventario
				INNER JOIN tbl_distinventario
				ON tbl_distinventario.cod_producto = tbl_inventario.cod_producto
WHERE tbl_distinventario.descripcion  LIKE '%" . $titulo . "%'

				GROUP BY tbl_inventario.cod_producto
LIMIT 0 , 30
				
				";
				
				
				

				
	$strQry = $strSelect ;
	
	//echo $strQry;
	$result=mysql_query($strQry,$link);
	
	$cont=0;
	$precio="0,00";
	while($row = mysql_fetch_array($result)) {
		if ($cont==0){
			echo ("
			<div id='tabla'>
			<form name=\"frmListTable\" method=\"post\"> 
			<input type=\"hidden\" name=\"var_busq\">
			<TABLE CELLSPACING=0>
				<TR class='estilotitulo'>
					<TD width='10%'>Cod. Articulo</TD> 
					<TD width='30%'>Titulo</TD>
					<TD width='20%'>Editorial</TD> 
			<TD width='20%'>Autor</TD> 
			
					<TD width='5%'>Precio</TD>
					         <TD width='5%'>Pres</TD>
							     <TD width='3%'>Tomo</TD>
                     <TD width='3%'>Exist</TD>

</TR>
			");
		}
		$precio=number_format($row[6],2,",",".");
	
		if ($cont%2){
		
printf("<tr class='celdapar' onClick=\"ponArticulo('%s','%s','%s','%s','%s','%s','%s')\">",$row[0],utf8_decode($row[1]),utf8_decode($row[4]),$row[3],$row[7],$precio,$row[5],$row[9]);
			//printf("<tr class='celdapar' onClick=\"v_select(frmListTable, '%s','inventario.php?p=libros')\">",$row[0]);
		}else{
		printf("<tr onClick=\"ponArticulo('%s','%s','%s','%s','%s','%s','%s')\">",$row[0],utf8_decode($row[1]),utf8_decode($row[4]),$row[3],$row[7],$precio,$row[5],$row[6],$row[6],$row[6]);


/////////////////// envia automaticamente 
	if ($cod_isbn == "")
	{

}
	else
	{
	echo "<script>
ponArticulo('$row[0]','$row[1]','$row[4]','$row[3]','$row[7]',$precio,'$row[5]');
</script>"; 
}
/////////////////// envia automaticamente


		}
		printf("<td>&nbsp;%s</td> ", $row[0]);
		
		printf("<td>&nbsp;%s</td> ", strtoupper(utf8_decode($row[1])));
		printf("<td>&nbsp;%s</td> ", strtoupper(utf8_decode($row[2])));
	printf("<td>&nbsp;%s</td> ", strtoupper(utf8_decode($row[4])));
	printf("<td>&nbsp;%s</td> ", $precio);

		
		
		
		
		switch($row[7]){
   			case 'E':
      			printf("<td>&nbsp;EMP</td> ");
      			break;
   			case 'R':
      			printf("<td>&nbsp;RUS</td> ");
     			break;
   			case 'U':
      			printf("<td>&nbsp;UNI</td> ");
      			break;
			default:
      			printf("<td>&nbsp;</td> ");
      			break;
		}  
printf("<td>&nbsp;%s</td> ", utf8_decode($row[3]));
		printf("<td>&nbsp;%s</td> ", strtoupper(utf8_decode($row[5])));

echo("</tr>");
		$cont++;	
	}
	if ($cont==0){
		echo ("No se encontraron Datos");
	}
	mysql_free_result($result);
	mysql_close($link);
	echo ("
	</table>
	</form>
	</div>
	");
	
/////////////muestro los distintos índices de las páginas, si es que hay varias páginas 
	if ($total_paginas > 1){ 
	echo ("<p align='center'>");
    for ($i=1;$i<=$total_paginas;$i++){ 
       if ($pagina == $i) 
          //si muestro el índice de la página actual, no coloco enlace 
          echo $pagina . " "; 
       else 
          //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página 
          echo "<a href='buscaArticulo4.php?letra=".$letra. "&autor=".$autor. "&editorial=".$editorial. "&titulo=".urlencode($titulo). "&cod_isbn=".$cod_isbn. "&pagina=".$i. "'>" . $i . "</a> "; 
    }
	echo ("</p>");
	}
}
?>


	</div>			
</body>
</html>





