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
	    <td width="61" height="0" style="color: #000">Codigo: </td>
	    <td><input type="text" id="cod_isbn" name="cod_isbn" onClick="this.value=''" 
            
            
      size="30" maxlength="30"></td>
	    <td><span style="color: #000">Colecci&oacute;n:</span></td>
	    <td><span style="color: #F00">
	      <select id="coleccion" name="coleccion" value="<?php echo($coleccion ); ?>">
	        <option value="0" <?php if($coleccion ==""){echo("selected");} ?>>--Seleccione--</option>
	        <?php
									$link=Conectarse();
									$result=mysql_query("SELECT  DISTINCT C.COL_COLECC,UPPER(C.COL_DESCRI)
FROM inv_libros l
INNER JOIN inv_colecc C ON l.col_colecc = C.COL_COLECC
WHERE C.COL_PROV = " . $editorial . "
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
          </select>
	      </span></td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      <tr>
	      <td width="61" height="0" style="color: #000">Titulo: </td>
      <td width="121"><input type="text" id="titulo"   onkeypress="submitEnter(event)" name="titulo" value="<?php echo($titulo); ?>" size="30" maxlength="162"></td>
	      <td width="61"><span style="color: #000">Autor:</span></td>
	      <td width="553"><select id="autor" name="autor" value="<?php echo($autor); ?>">
	        <option value="0" <?php if($autor==""){echo("selected");} ?>>--Seleccione--</option>
	        <?php
									$link=Conectarse();
									$result=mysql_query("SELECT  DISTINCT C.aut_codigo,UPPER(C.aut_nombre) 
FROM inv_libros l
INNER JOIN inv_autor C ON l.aut_codigo = C.aut_codigo
WHERE l.prv_codpro = " . $editorial . "
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
	      <td width="11" colspan="2" rowspan="3">&nbsp;</td>
      </tr>
	  <tr>
	    <td style="color: #F00">&nbsp;</td>
	    <td><input type="submit"  class="mybutton" value="Buscar"></td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      <tr>
	   
    </table>
</form>







<form method="post">
	
</form>

<hr>


 
<?php
//echo "prueba=".$editorial;
if ($letra != "")
{
	$link=Conectarse();
	
	$strSelect="SELECT count(DISTINCT l.lib_codart) FROM inv_libros l 
	JOIN inv_provee p ON l.prv_codpro = p.prv_codpro
	
	";
	
	if ($letra == "busq")
	{
		$strWhere ="WHERE l.lib_descri LIKE '%" . $titulo . "%' AND l.lib_preact >=0.1 ";
		if ($cod_isbn != "")
			$strWhere = $strWhere . "AND l.lib_codart = " . $cod_isbn . " OR l.lib_codbarra = " . $cod_isbn . " AND l.lib_preact >=0.1 ";
		if ($autor != "0")
			$strWhere = $strWhere . "AND l.aut_codigo = " . $autor . "  AND l.lib_preact >=0.1";
		if ($editorial != "0")
			$strWhere = $strWhere . "AND l.prv_codpro  >=0001 AND l.lib_preact >=0 ";

         if ($coleccion != "0")
			$strWhere = $strWhere . "AND l.col_colecc  >=0001 AND  l.lib_preact >=0 ";


}else{
		$strWhere ="WHERE l.prv_codpro  >=0001  AND l.lib_preact >=0.1 AND l.lib_descri REGEXP '^" . utf8_encode($letra) . "+'";
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
	///echo "Numero de registros encontrados: " . $num_total_registros . "<br>"; 
	if ( $TAMANO_PAGINA < $num_total_registros ){
		//echo "Se muestran paginas de maximo " . $TAMANO_PAGINA . " registros cada una<br>"; 
		//echo "Mostrando la pagina " . $pagina . " de " . $total_paginas; 
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
						  C.COL_DESCRI,
						  p.prv_nombre
				FROM inv_libros l 
				LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
				LEFT JOIN inv_provee p ON l.prv_codpro = p.prv_codpro 
				LEFT JOIN inv_colecc C ON l.col_colecc = C.COL_COLECC ";
				
				
				
	if ($letra == "busq")
	{
		$strWhere ="WHERE l.lib_descri LIKE '%" . $titulo . "%' AND C.COL_PROV  >=0001 and l.lib_preact >=0 " ;
		if ($cod_isbn != "")
			$strWhere = $strWhere . "AND l.lib_codart = " . $cod_isbn . " OR l.lib_codbarra = " . $cod_isbn . " AND C.COL_PROV  >=0001 and l.lib_preact >=0  " ;
		if ($autor != "0")
			$strWhere = $strWhere . "AND l.aut_codigo = " . $autor . " AND C.COL_PROV  >=0001 and l.lib_preact >=0   " ;
		if ($editorial != "0")
			$strWhere = $strWhere . "AND l.prv_codpro >=0001  and l.lib_preact >=0  ";
			  if ($coleccion != "0")
			$strWhere = $strWhere . "AND C.COL_COLECC  = " . $coleccion . " AND C.COL_PROV  >=0001 and l.lib_preact >=0  " ;
			
	}else{
		$strWhere ="WHERE l.prv_codpro  >=0001  AND C.COL_PROV  >=0001 and l.lib_preact >=0   AND l.lib_descri REGEXP '^" . utf8_encode($letra) . "+' ";
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
					<TD width='10%'>Cod. Articulo</TD> 
					<TD width='40%'>Titulo</TD>
					<TD width='20%'>Editorial</TD> 
			<TD width='13%'>Autor</TD> 
			
					<TD width='8%'>Precio</TD>
                     <TD width='8%'>Pres</TD>
					  <TD width='35%'>Coleccion</TD>

</TR>
			");
		}
		$precio=number_format($row[5],2,",",".");
	
		if ($cont%2){
		
printf("<tr class='celdapar' onClick=\"ponArticulo('%s','%s','%s','%s','%s','%s','%s')\">",$row[0],utf8_decode($row[1]),utf8_decode($row[2]),$row[3],$row[4],$precio,$row[7],$row[5],$row[9]);
			//printf("<tr class='celdapar' onClick=\"v_select(frmListTable, '%s','inventario.php?p=libros')\">",$row[0]);
		}else{
		printf("<tr onClick=\"ponArticulo('%s','%s','%s','%s','%s','%s','%s')\">",$row[0],utf8_decode($row[1]),utf8_decode($row[2]),$row[3],$row[4],$precio,$row[7],$row[5],$row[9]);


/////////////////// envia automaticamente 
	if ($cod_isbn == "")
	{

}
	else
	{
	echo "<script>
ponArticulo('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$precio','$row[7]','$row[5]','$row[9]');
</script>"; 
}
/////////////////// envia automaticamente


		}
		printf("<td>&nbsp;%s</td> ", $row[0]);
		
		printf("<td>&nbsp;%s</td> ", strtoupper(utf8_decode($row[1])));
		printf("<td>&nbsp;%s</td> ", strtoupper(utf8_decode($row[10])));
	printf("<td>&nbsp;%s</td> ", strtoupper(utf8_decode($row[2])));
	
		printf("<td>&nbsp;%s</td> ", strtoupper(utf8_decode($row[5])));
		
		
		
		switch($row[4]){
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
          echo "<a href='buscaArticulo4.php?letra=".$letra. "&autor=".$autor. "&editorial=".$editorial. "&titulo=".urlencode($titulo). "&cod_isbn=".$cod_isbn. "&pagina=".$i. "'>" . $i . "</a> "; 
    }
	echo ("</p>");
	}
}
?>


	</div>			
</body>
</html>





