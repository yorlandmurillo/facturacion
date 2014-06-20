<html>
	<head>
		<title>Buscar Editorial</title>
		<script src="includes/validation.js" type="text/javascript"></script>
		<link rel="STYLESHEET" type="text/css" href="includes/estilos.css">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
	body {
	background-color: #FFF;
}
    </style>
	</head>
	<body> 
<?php
//Limito la busqueda 
$TAMANO_PAGINA = 50; 

//examino la página a mostrar y el inicio del registro a mostrar 
$pagina = $_GET["pagina"];
$letra = $_GET["letra"];
$editorial = $_GET["editorial"];
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
  <form method="get" action="buscaProveedorP.php">
  <input type="hidden" name="letra" value="busq">
<table>
		
  		<tr>
    		<td class="nuevaclase">Editorial: 
    		  <input type="text" id="editorial" name="editorial" size="50" maxlength="60">
    		  <input type="submit" value="Buscar"></td>
	  </tr>
	</table>
  </form>

<hr>

Listar

<form method="post">
	<table>
		<tr><td><a href="buscaProveedorP.php?letra=." style="cursor:pointer">Todo</a></td></tr>
		<tr><td>Comienza con:</td></tr>
		<tr>
			<td style="text-align:center">
				<a href="buscaProveedorP.php?letra=[0-9]" style="cursor:pointer">0-9</a> |
				<a href="buscaProveedorP.php?letra=A" style="cursor:pointer">A</a> | 
				<a href="buscaProveedorP.php?letra=B" style="cursor:pointer">B</a> | 
				<a href="buscaProveedorP.php?letra=C" style="cursor:pointer">C</a> | 
				<a href="buscaProveedorP.php?letra=D" style="cursor:pointer">D</a> | 
				<a href="buscaProveedorP.php?letra=E" style="cursor:pointer">E</a> | 
				<a href="buscaProveedorP.php?letra=F" style="cursor:pointer">F</a> | 
				<a href="buscaProveedorP.php?letra=G" style="cursor:pointer">G</a> | 
				<a href="buscaProveedorP.php?letra=H" style="cursor:pointer">H</a> | 
				<a href="buscaProveedorP.php?letra=I" style="cursor:pointer">I</a> | 
				<a href="buscaProveedorP.php?letra=J" style="cursor:pointer">J</a> | 
				<a href="buscaProveedorP.php?letra=K" style="cursor:pointer">K</a> | 
				<a href="buscaProveedorP.php?letra=L" style="cursor:pointer">L</a> | 
				<a href="buscaProveedorP.php?letra=M" style="cursor:pointer">M</a> | 
				<a href="buscaProveedorP.php?letra=N" style="cursor:pointer">N</a> |
				<a href="buscaProveedorP.php?letra=Ñ" style="cursor:pointer">Ñ</a> | 
				<a href="buscaProveedorP.php?letra=O" style="cursor:pointer">O</a> | 
				<a href="buscaProveedorP.php?letra=P" style="cursor:pointer">P</a> | 
				<a href="buscaProveedorP.php?letra=Q" style="cursor:pointer">Q</a> | 
				<a href="buscaProveedorP.php?letra=R" style="cursor:pointer">R</a> | 
				<a href="buscaProveedorP.php?letra=S" style="cursor:pointer">S</a> | 
				<a href="buscaProveedorP.php?letra=T" style="cursor:pointer">T</a> | 
				<a href="buscaProveedorP.php?letra=U" style="cursor:pointer">U</a> | 
				<a href="buscaProveedorP.php?letra=V" style="cursor:pointer">V</a> | 
				<a href="buscaProveedorP.php?letra=W" style="cursor:pointer">W</a> | 
				<a href="buscaProveedorP.php?letra=X" style="cursor:pointer">X</a> | 
				<a href="buscaProveedorP.php?letra=Y" style="cursor:pointer">Y</a> | 
				<a href="buscaProveedorP.php?letra=Z" style="cursor:pointer">Z</a> | 
				<a href="buscaProveedorP.php?letra=[^[:alnum:]]" style="cursor:pointer">Otro</a>
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
	
	$strSelect="SELECT count(*) FROM inv_provee p ";
	
	if ($letra == "busq")
	{
		$strWhere ="WHERE p.prv_nombre LIKE '%" . $editorial . "%' ";
	}else{
		$strWhere ="WHERE p.prv_nombre REGEXP '^" . utf8_encode($letra) . "+'";
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
	//$result=mysql_query("select * from inv_autor order by aut_nombre",$link);
	
	$strSelect="SELECT  * FROM inv_provee p ";
	
	if ($letra == "busq")
	{
		$strWhere ="WHERE p.prv_nombre LIKE '%" . $editorial . "%' ";
	}else{
		$strWhere ="WHERE p.prv_nombre REGEXP '^" . utf8_encode($letra) . "+' ";
	}
	
	$strOrder="ORDER BY p.prv_nombre LIMIT " . $inicio . "," . $TAMANO_PAGINA;
				
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
					<TD width='280'>Proveedor</TD>
					<TD width='220'>Contacto</TD> 
					<TD width='100'>Id Corta</TD> 
				</TR>
			");
		}
		if ($cont%2){
			printf("<tr class='celdapar' onClick=\"ponProveedorP('%s')\">",$row["prv_codpro"]);
		}else{
			printf("<tr onClick=\"ponProveedorP('%s')\">",$row["prv_codpro"]);
		}
		printf("<td>&nbsp;%s</td> ", strtoupper (utf8_decode($row["prv_nombre"])));
		printf("<td>&nbsp;%s</td> ", strtoupper (utf8_decode($row["prv_contac"])));
		printf("<td>&nbsp;%s</td> ", $row["prv_id"]);
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
          echo "<a href='buscaProveedorP.php?letra=" . $letra . "&editorial=" . $editorial . "&pagina=" . $i . "'>" . $i . "</a> "; 
    }
	echo ("</p>");
	} 
}
?>			 
	</div>			
	</body>
</html>