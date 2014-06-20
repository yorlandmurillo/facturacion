<html>
	<head>
		<title>Buscar Articulo</title>
		<script src="includes/validation.js" type="text/javascript"></script>
		<link rel="STYLESHEET" type="text/css" href="includes/estilos.css">
	</head>
	<body> 





<script language='javascript'>
function getKey(e){
	if(!e)
		e=window.event;
	if(e.keyCode)
		code=e.keyCode;
	else
		code=e.which;
	if(code===13){
                document.forms['codbar'].cbarras2.value=document.forms['codbar'].cod_isbn.value;
		document.forms['codbar'].cod_isbn.value='';
		document.forms['codbar'].cod_isbn.focus();
	}
}
</script>
<body onLoad="document.forms['codbar'].cod_isbn.focus();">





<?php
include("includes/conexion.php");
//Limito la busqueda 
$TAMANO_PAGINA = 400; 










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

Busqueda



















<form method="get" action="buscaArticulo_traslado.php" name="codbar">
	<input type="hidden" name="letra" value="busq">
	<input type="hidden" name="editorial" value="<?php echo($editorial); ?>">
	<table>



		<tr>
			<td>Cod. Articulo/Barra: </td>
			<td><input type="text" id="cod_isbn" name="cod_isbn" onClick="this.value=''"  value=""<?php echo($cod_isbn); ?>" size="50" maxlength="20"></td>
    	</tr>
		<tr>
			<td>Titulo: </td>
			<td><input type="text" id="titulo" name="titulo" value="<?php echo($titulo); ?>" size="50" maxlength="162"></td>
		</tr>
		<tr>
			<td>Autor: </td>
			<td><select id="autor" name="autor" value="<?php echo($autor); ?>">
                	<option value="0" <?php if($autor==""){echo("selected");} ?>>--Seleccione--</option>
									<?php
									$link=Conectarse();
									$result=mysql_query("SELECT  DISTINCT C.aut_codigo,UPPER(C.aut_nombre) 
FROM inv_libros l
INNER JOIN inv_autor C ON l.aut_codigo = C.aut_codigo
GROUP BY l.lib_codart
ORDER BY C.aut_nombre",$link);
									while($row = mysql_fetch_array($result)) {
										if($row[0]==$autor){
											printf("<option value='%s' selected>%s</option>", $row[0], utf8_decode($row[1]));
										}else{
											printf("<option value='%s'>%s</option>", $row[0], utf8_decode($row[1]));
										}
									}
									mysql_free_result($result);
									mysql_close($link);
									?>
              		</select></td>
                    
    	</tr>
        <td>Colección: </td>
			<td><select id="coleccion" name="coleccion" value="<?php echo($coleccion ); ?>">
                	<option value="0" <?php if($coleccion ==""){echo("selected");} ?>>--Seleccione--</option>
									<?php
									$link=Conectarse();
									$result=mysql_query("SELECT  DISTINCT C.COL_COLECC,UPPER(C.COL_DESCRI)
FROM inv_libros l
INNER JOIN inv_colecc C ON l.col_colecc = C.COL_COLECC
GROUP BY l.lib_codart
ORDER BY C.COL_DESCRI",$link);
									while($row = mysql_fetch_array($result)) {
										if($row[0]==$coleccion){
											printf("<option value='%s' selected>%s</option>", $row[0], utf8_decode($row[1]));
										}else{
											printf("<option value='%s'>%s</option>", $row[0], utf8_decode($row[1]));
										}
									}
									mysql_free_result($result);
									mysql_close($link);
									?>
   		  </select></td>
		<tr>
    		<td colspan="2">



				<INPUT TYPE="submit" VALUE="Buscar">
			</td>			
		</tr>
		</table>
	</form>

<hr>

Listar



<form method="post">
	<table>
		<tr><td><a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=." style="cursor:pointer">Todo</a></td></tr>
		<tr><td>Comienza con:</td></tr>
		<tr>
			<td style="text-align:center">
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=[0-9]" style="cursor:pointer">0-9</a> |
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=A" style="cursor:pointer">A</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=B" style="cursor:pointer">B</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=C" style="cursor:pointer">C</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=D" style="cursor:pointer">D</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=E" style="cursor:pointer">E</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=F" style="cursor:pointer">F</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=G" style="cursor:pointer">G</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=H" style="cursor:pointer">H</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=I" style="cursor:pointer">I</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=J" style="cursor:pointer">J</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=K" style="cursor:pointer">K</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=L" style="cursor:pointer">L</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=M" style="cursor:pointer">M</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=N" style="cursor:pointer">N</a> |
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=Ñ" style="cursor:pointer">Ñ</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=O" style="cursor:pointer">O</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=P" style="cursor:pointer">P</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=Q" style="cursor:pointer">Q</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=R" style="cursor:pointer">R</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=S" style="cursor:pointer">S</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=T" style="cursor:pointer">T</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=U" style="cursor:pointer">U</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=V" style="cursor:pointer">V</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=W" style="cursor:pointer">W</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=X" style="cursor:pointer">X</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=Y" style="cursor:pointer">Y</a> | 
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=Z" style="cursor:pointer">Z</a> |
				<a href="buscaArticulo.php?editorial=<?php echo $editorial."&"; ?>letra=[^[:alnum:]]" style="cursor:pointer">Otro</a>
			</td>		
    	</tr>
	</table>
</form>

<hr>


 
<?php
//echo "prueba=".$editorial;
if ($letra != "")
{
	$link=Conectarse();
	
	$strSelect="SELECT count(DISTINCT l.lib_codart) FROM inv_libros l ";
	
	if ($letra == "busq")
	{
		$strWhere ="WHERE l.lib_descri LIKE '%" . $titulo . "%' ";
		if ($cod_isbn != "")
			$strWhere = $strWhere . "AND l.lib_codart = " . $cod_isbn . " OR l.lib_codbarra = " . $cod_isbn . " ";
		if ($autor != "0")
			$strWhere = $strWhere . "AND l.aut_codigo = " . $autor . " ";
		if ($editorial != "0")
			$strWhere = $strWhere . "AND l.prv_codpro = " . $editorial . " ";

         if ($coleccion != "0")
			$strWhere = $strWhere . "AND l.col_colecc = " . $coleccion . " ";


}else{
	///	$strWhere ="WHERE l.prv_codpro = " . $editorial . " AND l.lib_descri REGEXP '^" . utf8_encode($letra) . "+'";
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
	
	$strSelect="SELECT  l.lib_codart,
						l.lib_descri,
						UPPER(a.aut_nombre),
						l.lib_numedit,
						l.lib_present,
						l.lib_preact,
						l.lib_exiact ,
						p.prv_tipop,
						  C.COL_COLECC,
						  C.COL_DESCRI
				FROM inv_libros l 
				LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
				LEFT JOIN inv_provee p ON l.prv_codpro = p.prv_codpro 
				LEFT JOIN inv_colecc C ON l.col_colecc = C.COL_COLECC ";
				
				
	if ($letra == "busq")
	{
		$strWhere ="WHERE l.lib_descri LIKE '%" . $titulo . "%' AND C.COL_PROV = " . $editorial . " " ;
		if ($cod_isbn != "")
			$strWhere = $strWhere . "AND l.lib_codart = " . $cod_isbn . " OR l.lib_codbarra = " . $cod_isbn . " AND C.COL_PROV = " . $editorial . " " ;
		if ($autor != "0")
			$strWhere = $strWhere . "AND l.aut_codigo = " . $autor . " AND C.COL_PROV = " . $editorial . " " ;
		if ($editorial != "0")
			$strWhere = $strWhere . "AND l.prv_codpro = " . $editorial . " ";
			  if ($coleccion != "0")
			$strWhere = $strWhere . "AND C.COL_COLECC  = " . $coleccion . " AND C.COL_PROV = " . $editorial . " " ;
			
	}else{
		///$strWhere ="WHERE l.prv_codpro = " . $editorial . " AND C.COL_PROV = " . $editorial . " AND l.lib_descri REGEXP '^" . utf8_encode($letra) . "+' ";
	}
	
	$strOrder="GROUP BY l.lib_codart ORDER BY l.lib_descri LIMIT " . $inicio . "," . $TAMANO_PAGINA;
				
	$strQry = $strSelect . $strWhere . $strOrder;
	
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
					<TD width='5%'>Cod. Articulo</TD> 
					<TD width='31%'>Titulo</TD>
					<TD width='13%'>Autor</TD> 
					<TD width='5%'>Existencia</TD>
                     <TD width='5%'>Presentación</TD>
					  <TD width='30%'>Colección</TD>

</TR>
			");
		}
		$precio=number_format($row[5],2,",",".");
	
		if ($cont%2){
			printf("<tr class='celdapar' onClick=\"ponArticulo('%s','%s','%s','%s','%s','%s','%s')\">",$row[0],utf8_decode($row[1]),utf8_decode($row[2]),$row[3],$row[4],$precio,$row[6],$row[7],$row[9]);
			//printf("<tr class='celdapar' onClick=\"v_select(frmListTable, '%s','inventario.php?p=libros')\">",$row[0]);
		}else{
			printf("<tr onClick=\"ponArticulo('%s','%s','%s','%s','%s','%s','%s')\">",$row[0],utf8_decode($row[1]),utf8_decode($row[2]),$row[3],$row[4],$precio,$row[6],$row[7],$row[9]);
		}
		printf("<td>&nbsp;%s</td> ", $row[0]);
		printf("<td>&nbsp;%s</td> ", utf8_decode($row[1]));
		printf("<td>&nbsp;%s</td> ", utf8_decode($row[2]));
		printf("<td>&nbsp;%s</td> ", utf8_decode($row[6]));
		switch($row[4]){
   			case 'E':
      			printf("<td>&nbsp;EMPASTADO</td> ");
      			break;
   			case 'R':
      			printf("<td>&nbsp;RUSTICO</td> ");
     			break;
   			case 'U':
      			printf("<td>&nbsp;UNICO</td> ");
      			break;
			default:
      			printf("<td>&nbsp;</td> ");
      			break;
		}  
printf("<td>&nbsp;%s</td> ", utf8_decode($row[9]));
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
          echo "<a href='buscaArticulo.php?letra=".$letra. "&autor=".$autor. "&editorial=".$editorial. "&titulo=".urlencode($titulo). "&cod_isbn=".$cod_isbn. "&pagina=".$i. "'>" . $i . "</a> "; 
    }
	echo ("</p>");
	}
}
?>


	</div>			
</body>
</html>





