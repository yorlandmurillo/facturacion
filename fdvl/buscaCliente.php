<html>
	<head>
		<title>Buscar Cliente</title>
		<script src="includes/validation.js" type="text/javascript"></script>
		<link rel="STYLESHEET" type="text/css" href="includes/estilos.css">
	</head>
	<body> 
<?php
//Limito la busqueda 
$TAMANO_PAGINA = 50; 

//examino la página a mostrar y el inicio del registro a mostrar 
$pagina = $_GET["pagina"];
$letra = $_GET["letra"];
$cliente = $_GET["cliente"];
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

Busqueda

<form method="get" action="buscaCliente.php">
	<input type="hidden" name="letra" value="busq">
	<table>
		<tr><td></td><td></td></tr>
  		<tr>
    		<td>Cliente: <input type="text" id="cliente" name="cliente" size="50" maxlength="60"></td>
			<td>
				<INPUT TYPE="submit" VALUE="Buscar">
			</td>
		</tr>
	</table>
</form>

<hr>

Listar

<form method="post">
	<table>
		<tr><td><a href="buscaCliente.php?letra=." style="cursor:pointer">Todo</a></td></tr>
		<tr><td>Comienza con:</td></tr>
		<tr>
			<td style="text-align:center">
				<a href="buscaCliente.php?letra=[0-9]" style="cursor:pointer">0-9</a> |
				<a href="buscaCliente.php?letra=A" style="cursor:pointer">A</a> | 
				<a href="buscaCliente.php?letra=B" style="cursor:pointer">B</a> | 
				<a href="buscaCliente.php?letra=C" style="cursor:pointer">C</a> | 
				<a href="buscaCliente.php?letra=D" style="cursor:pointer">D</a> | 
				<a href="buscaCliente.php?letra=E" style="cursor:pointer">E</a> | 
				<a href="buscaCliente.php?letra=F" style="cursor:pointer">F</a> | 
				<a href="buscaCliente.php?letra=G" style="cursor:pointer">G</a> | 
				<a href="buscaCliente.php?letra=H" style="cursor:pointer">H</a> | 
				<a href="buscaCliente.php?letra=I" style="cursor:pointer">I</a> | 
				<a href="buscaCliente.php?letra=J" style="cursor:pointer">J</a> | 
				<a href="buscaCliente.php?letra=K" style="cursor:pointer">K</a> | 
				<a href="buscaCliente.php?letra=L" style="cursor:pointer">L</a> | 
				<a href="buscaCliente.php?letra=M" style="cursor:pointer">M</a> | 
				<a href="buscaCliente.php?letra=N" style="cursor:pointer">N</a> |
				<a href="buscaCliente.php?letra=Ñ" style="cursor:pointer">Ñ</a> | 
				<a href="buscaCliente.php?letra=O" style="cursor:pointer">O</a> | 
				<a href="buscaCliente.php?letra=P" style="cursor:pointer">P</a> | 
				<a href="buscaCliente.php?letra=Q" style="cursor:pointer">Q</a> | 
				<a href="buscaCliente.php?letra=R" style="cursor:pointer">R</a> | 
				<a href="buscaCliente.php?letra=S" style="cursor:pointer">S</a> | 
				<a href="buscaCliente.php?letra=T" style="cursor:pointer">T</a> | 
				<a href="buscaCliente.php?letra=U" style="cursor:pointer">U</a> <br>  
				<a href="buscaCliente.php?letra=V" style="cursor:pointer">V</a> | 
				<a href="buscaCliente.php?letra=W" style="cursor:pointer">W</a> | 
				<a href="buscaCliente.php?letra=X" style="cursor:pointer">X</a> | 
				<a href="buscaCliente.php?letra=Y" style="cursor:pointer">Y</a> | 
				<a href="buscaCliente.php?letra=Z" style="cursor:pointer">Z</a> |
				<a href="buscaCliente.php?letra=[^[:alnum:]]" style="cursor:pointer">Otro</a>
			</td>		
    	</tr>
	</table>
</form>

<hr>
 
<?php

if ($letra != "")
{
	include("includes/conexion.php");
	$link=Conectarse();
	
	$strSelect="SELECT count(*) FROM inv_cliente c ";
	
	if ($letra == "busq")
	{
		$strWhere ="WHERE c.clt_nombre LIKE '%" . $cliente . "%' ";
	}else{
		$strWhere ="WHERE c.clt_nombre REGEXP '^" . utf8_encode($letra) . "+'";
	}
	
	$strQry = $strSelect . $strWhere;
	//echo $strQry;
	$result=mysql_query($strQry,$link);
	
	//miro a ver el número total de campos que hay en la tabla con esa búsqueda 
	if($row = mysql_fetch_array($result))
		 {
		 	$num_total_registros=$row[0];
		 } 
	mysql_free_result($result);
	//calculo el total de páginas 
	$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA); 

	//pongo el número de registros total, el tamaño de página y la página que se muestra 
	echo "Número de registros encontrados: " . $num_total_registros . "<br>"; 
	if ( $TAMANO_PAGINA < $num_total_registros ){
		echo "Se muestran páginas de máximo " . $TAMANO_PAGINA . " registros cada una<br>"; 
		echo "Mostrando la página " . $pagina . " de " . $total_paginas; 
	}
	echo "<p>";
	
	//construyo la sentencia SQL 
	
	$strSelect="SELECT  * FROM inv_cliente c ";
	
	if ($letra == "busq")
	{
		$strWhere ="WHERE c.clt_nombre LIKE '%" . $cliente . "%' ";
	}else{
		$strWhere ="WHERE c.clt_nombre REGEXP '^" . utf8_encode($letra) . "+' ";
	}
	
	$strOrder="ORDER BY c.clt_nombre LIMIT " . $inicio . "," . $TAMANO_PAGINA;
				
	$strQry = $strSelect . $strWhere . $strOrder;
	//echo $strQry;
	$result=mysql_query($strQry,$link);
	
	$cont=0;
	while($row = mysql_fetch_array($result)) {
		if ($cont==0){
			echo ("
			<div id='tabla'>
			<form name=\"frmUserTable\" method=\"post\"> 
			<input type=\"hidden\" name=\"var_busq\">
			<TABLE CELLSPACING=0>
				<TR class='estilotitulo'>
				<TD width='70'>Codigo</TD>
				<TD width='380'>Cliente</TD> 
			</TR>
			");
		}
		if ($cont%2){
			printf("<tr class='celdapar' onClick=\"ponCliente('%s')\">",$row["clt_codcli"]);
		}else{
			printf("<tr onClick=\"ponCliente('%s')\">",$row["clt_codcli"]);
		}
		printf("<td>&nbsp;%s</td> ", utf8_decode($row["clt_codcli"]));
		printf("<td>&nbsp;%s</td> ", utf8_decode($row["clt_nombre"]));
		echo("</tr>");
		$cont++;
		if ($cont==mysql_num_rows($result)){
			echo ("
				</table>
				</form>
				</div>
				");
		}
	}
	if ($cont==0){
		echo ("No se encontraron Datos");
	}
	mysql_free_result($result);
	mysql_close($link);
	
/////////////muestro los distintos índices de las páginas, si es que hay varias páginas 
	if ($total_paginas > 1){ 
	echo ("<p align='center'>");
    for ($i=1;$i<=$total_paginas;$i++){ 
       if ($pagina == $i) 
          //si muestro el índice de la página actual, no coloco enlace 
          echo $pagina . " "; 
       else 
          //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página 
          echo "<a href='buscaCliente.php?letra=" . $letra . "&cliente=" . $cliente . "&pagina=" . $i . "'>" . $i . "</a> "; 
    }
	echo ("</p>");
	}
	echo ("<hr>");
}
?>
	</div>			
	</body>
</html>