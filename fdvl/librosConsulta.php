 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<style type="text/css">
#navegador p .texto_original {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	color: #000;
}
#estiloFormaLarga form table {
	text-align: left;
}
</style><div id="navegador">
	<p>
    
    <style>
SELECT {
border: solid #000000 1px; FONT-SIZE: 11px; BACKGROUND: #FF3333; COLOR: #ffffff; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
</style>
<? $usuario=$_SESSION['Nusuario'];  ?> 
      

		<SPAN class='texto_original'>
					<a href="#"></a> SISTEMA DE INVENTARIO | CONSULTA DE LIBROS | <? echo "$usuario"; ?>
		<a href="#"></a></SPAN>

  </p>
</div>

<?php
include("includes/functions.php");

//////////////////////////////////////////////// INICIANDO VARIABLES
$cod_libro = isset($_POST['cod_libro'])?$_POST['cod_libro']:'';
$cod_isbn = isset($_POST['cod_isbn'])?$_POST['cod_isbn']:'';
$lib_codbarra = isset($_POST['lib_codbarra'])?$_POST['lib_codbarra']:'';
$autor = isset($_POST['autor'])?$_POST['autor']:'';
$empaque = isset($_POST['empaque'])?$_POST['empaque']:'';
$fch_creacion = isset($_POST['fch_creacion'])?cambiaf_a_mysql($_POST['fch_creacion']):'0000-00-00';
$stock_min = isset($_POST['stock_min'])?$_POST['stock_min']:'';
$stock_max = isset($_POST['stock_max'])?$_POST['stock_max']:'';
$observaciones = isset($_POST['observaciones'])?$_POST['observaciones']:'';
$titulo = isset($_POST['titulo'])?$_POST['titulo']:'';
$editorial = isset($_POST['editorial'])?$_POST['editorial']:'';
$cta_contable = isset($_POST['cta_contable'])?$_POST['cta_contable']:'';
$cta_presup = isset($_POST['cta_presup'])?$_POST['cta_presup']:'';
$ubi_almacen = isset($_POST['ubi_almacen'])?$_POST['ubi_almacen']:'';
$saldo_cierre = isset($_POST['saldo_cierre'])?$_POST['saldo_cierre']:'';
$exist1 = isset($_POST['exist1'])?$_POST['exist1']:'';
$costo1 = isset($_POST['costo1'])?$_POST['costo1']:'';
$costo_p1 = isset($_POST['costo_p1'])?$_POST['costo_p1']:'';
$precio1 = isset($_POST['precio1'])?$_POST['precio1']:'';
$precio_p1 = isset($_POST['precio_p1'])?$_POST['precio_p1']:'';
$fch_compra1 = isset($_POST['fch_compra1'])?cambiaf_a_mysql($_POST['fch_compra1']):'0000-00-00';
$exist2 = isset($_POST['exist2'])?$_POST['exist2']:'0';
$costo2 = isset($_POST['costo2'])?$_POST['costo2']:'';
$costo_p2 = isset($_POST['costo_p2'])?$_POST['costo_p2']:'';
$precio2 = isset($_POST['precio2'])?$_POST['precio2']:'';
$precio_p2 = isset($_POST['precio_p2'])?$_POST['precio_p2']:'';
$fch_compra2 = isset($_POST['fch_compra2'])?cambiaf_a_mysql($_POST['fch_compra2']):'0000-00-00';
$formato = isset($_POST['formato'])?$_POST['formato']:'';
$coleccion = isset($_POST['coleccion'])?$_POST['coleccion']:'';
$num_tomo = isset($_POST['num_tomo'])?$_POST['num_tomo']:'';
$num_libsur = isset($_POST['num_libsur'])?$_POST['num_libsur']:'';
$tema = isset($_POST['tema'])?$_POST['tema']:'';
$ano_pub = isset($_POST['ano_pub'])?$_POST['ano_pub']:'';
$cant_pag = isset($_POST['cant_pag'])?$_POST['cant_pag']:'';
$serie = isset($_POST['serie'])?$_POST['serie']:'';

//Limito la busqueda 
$TAMANO_PAGINA = 100; 

//examino la página a mostrar y el inicio del registro a mostrar 
$pagina = $_GET["pagina"];
$letra = $_GET["letra"];

$cod_isbn2 = isset($_GET['cod_isbn2'])?$_GET['cod_isbn2']:'';
$titulo2 = isset($_GET['titulo2'])?$_GET['titulo2']:'';
$autor2 = isset($_GET['autor2'])?$_GET['autor2']:'';
$editorial2 = isset($_GET['editorial2'])?$_GET['editorial2']:'';
$coleccion2 = isset($_GET['coleccion2'])?$_GET['coleccion2']:'';

//echo "editorial2=".$editorial2;

if ($cod_isbn2 == "") $cod_isbn2=$_POST['cod_isbn2'];
if ($titulo2 == "") $titulo2=$_POST['titulo2'];
if ($autor2 == "") $autor2=$_POST['autor2'];
if ($editorial2 == "") $editorial2=$_POST['editorial2'];
if ($coleccion2 == "") $coleccion2=$_POST['coleccion2'];

//echo "editorial2=".$editorial2;

$msg = $_GET["msg"]; 
if (!$pagina) { 
    $inicio = 0; 
    $pagina=1; 
} 
else { 
    $inicio = ($pagina - 1) * $TAMANO_PAGINA; 
} 

if ($_POST["var_busq"]!=""){
		$cod_libro = $_POST["var_busq"];
		f_select_libro( $cod_libro, $cod_isbn, $autor, $empaque, $fch_creacion, $stock_min, $stock_max, $observaciones, 
						$titulo, $editorial, $cta_contable, $cta_presup, $ubi_almacen, $saldo_cierre, $exist1, $costo1, 
						$costo_p1, $precio1, $precio_p1, $fch_compra1, $exist2, $costo2,$costo_p2, $precio2, $precio_p2, 
						$fch_compra2, $formato, $coleccion, $num_tomo, $num_libsur, $tema, $ano_pub, $cant_pag, $serie,$lib_codbarra);
} 

?>
<script>
	////////////////////////// CAMPOS QUE SE DEBEN VALIDAR
  var fieldsFormatForm = Array(new Array('cod_isbn', 'NO', 'VACIO', 'Cod. ISBN'),///
                               //new Array('cod_isbn', 'NO', 'ENTERO', 'Cod. ISBN'),
                               new Array('titulo', 'NO', 'VACIO', 'Titulo'),///
                               new Array('autor', 'NO', 'SELECTED_OPTION', 'Autor'),///
                               new Array('editorial', 'NO', 'SELECTED_OPTION', 'Editorial'),///	
                               new Array('formato', 'NO', 'SELECTED_OPTION', 'Formato'),///
							   new Array('coleccion', 'NO', 'SELECTED_OPTION', 'Colección'),///
							   //new Array('num_tomo', 'NO', 'VACIO', 'Número de tomo'),
							   new Array('num_tomo', 'SI', 'ENTERO', 'Número de tomo'),
							   //new Array('num_libsur', 'NO', 'VACIO', 'Número librerias del sur'),
							   new Array('num_libsur', 'SI', 'ENTERO', 'Número librerias del sur'),
							   //new Array('tema', 'NO', 'VACIO', 'Tema'),
							   //new Array('ano_pub', 'NO', 'VACIO', 'Año de publicación'),
							   new Array('ano_pub', 'SI', 'ENTERO', 'Año de publicación'),
							   //new Array('cant_pag', 'NO', 'VACIO', 'Cantidad de páginas'),
							   //new Array('serie', 'NO', 'VACIO', 'Serie'),
							   //new Array('empaque', 'NO', 'SELECTED_OPTION', 'Embalaje'),	
                               //new Array('cta_contable', 'NO', 'VACIO', 'Cuenta Contable'),	
                               new Array('fch_creacion', 'NO', 'FECHA', 'Fecha Creación'),///
                               //new Array('cta_presup', 'NO', 'VACIO', 'Cuenta Presupuestaria'),
                               //new Array('stock_min', 'NO', 'VACIO', 'Stock Min'),
                               new Array('stock_min', 'SI', 'ENTERO', 'Stock Min'),
                               //new Array('ubi_almacen', 'NO', 'SELECTED_OPTION', 'Ubic. Almacen'),
                               //new Array('stock_max', 'NO', 'VACIO', 'Stock Max'),
                               new Array('stock_max', 'SI', 'ENTERO', 'Stock Max'),
                               //new Array('saldo_cierre', 'NO', 'VACIO', 'Saldo Cierre Mes Ant'),
                               new Array('saldo_cierre', 'SI', 'ENTERO', 'Saldo Cierre Mes Ant'),
                               //new Array('observaciones', 'NO', 'VACIO', 'Observaciones'),	
                               //new Array('exist1', 'NO', 'VACIO', 'Existencia Anterior'),	
                               //new Array('exist1', 'SI', 'ENTERO', 'Existencia Anterior'),	
                               //new Array('exist2', 'NO', 'VACIO', 'Existencia Actual'),///	
                               new Array('exist2', 'SI', 'ENTERO', 'Existencia Actual'),///	
                               //new Array('costo1', 'NO', 'VACIO', 'Costo Anterior'),
                               //new Array('costo1', 'SI', 'DECIMAL', 'Costo Anterior'),
                               //new Array('costo2', 'NO', 'VACIO', 'Costo Actual'),
                               new Array('costo2', 'SI', 'DECIMAL', 'Costo Actual'),
                               //new Array('costo_p1', 'NO', 'VACIO', 'Costo Promedio Anterior'),
                               //new Array('costo_p1', 'SI', 'DECIMAL', 'Costo Promedio Anterior'),
                               //new Array('costo_p2', 'NO', 'VACIO', 'Costo Promedio Actual'),
                               new Array('costo_p2', 'SI', 'DECIMAL', 'Costo Promedio Actual'),
                               //new Array('precio1', 'NO', 'VACIO', 'Precio Anterior'),
                               //new Array('precio1', 'SI', 'DECIMAL', 'Precio Anterior'),
                               //new Array('precio2', 'NO', 'VACIO', 'Precio Actual'),///
                               new Array('precio2', 'SI', 'DECIMAL', 'Precio Actual'),///
                               //new Array('precio_p1', 'NO', 'VACIO', 'Precio Promedio Anterior'),	
                               //new Array('precio_p1', 'SI', 'DECIMAL', 'Precio Promedio Anterior'),	
                               //new Array('precio_p2', 'NO', 'VACIO', 'Precio Promedio Actual'),	
                               new Array('precio_p2', 'SI', 'DECIMAL', 'Precio Promedio Actual'))	
                               //new Array('fch_compra1', 'NO', 'FECHA', 'Fecha Compra Anterior'),	
                               //new Array('fch_compra2', 'NO', 'FECHA', 'Fecha Compra Actual'))
							   // modificar serie SELECTED_OPTION
							   
</script>


<div id="estiloFormaLarga">
	<form name="frmLibro" method="post" action="inventario.php?p=librosConsulta">
		<input type="hidden" name="accion">
		<input type="hidden" name="cod_libro" value="<?php echo($cod_libro); ?>">
		<table>
  		<tr><td colspan="2" class="mensajes"><?php echo($msg); ?></td></tr>
		<tr>
    		<td><div align="right"><font color="#990000">*</font> Cod. ISBN: <input name="cod_isbn" type="text" id="cod_isbn" value="<?php echo($cod_isbn); ?>" size="15" maxlength="14" readonly="readonly">
    		</div></td>
   			<td><div align="right"><font color="#990000">*</font> Titulo: <input name="titulo" type="text" id="titulo" value="<?php echo strtoupper ($titulo); ?>" size="40" maxlength="162" readonly="readonly">
   			</div></td>
		</tr>
  		<tr>
			<td><div align="right"><font color="#990000">*</font> Autor: 
              
									<?php
									$link=Conectarse();
			$resultx=mysql_query("select * from inv_autor where aut_codigo = '$autor' ",$link);
									
									$rowFacx=mysql_fetch_array($resultx); 
$imprimir22=$rowFacx["aut_nombre"];
									
									mysql_close($link);
									?>
              	  </select>
              	
			  <input name="autor" type="text" id="autor" value="<?php echo strtoupper ($imprimir22); ?>" size="35" maxlength="162" readonly="readonly" />
              
            </div></td>
    		<td><div align="right"><font color="#990000">*</font> Editorial: 
									<?php
									$link=Conectarse();
									$result=mysql_query("select prv_codpro, prv_nombre from inv_provee where prv_codpro = '$editorial' ",$link);
									
									$rowFac=mysql_fetch_array($result); 
$imprimir=$rowFac["prv_nombre"];
								
								mysql_close($link);
									?>
		  </select>
   		  <input name="editorial" type="text" id="editorial" value="<?php echo($imprimir); ?>" size="40" maxlength="162" readonly="readonly" />
          </div></td>		
    	</tr>
		<tr>
    		<td><div align="right"><font color="#990000">*</font> Formato:	
    		    <select id="formato"  name="formato" disabled="disabled">
    		      <option value="0" <?php if($formato==""){echo("selected");} ?> >--Seleccione--</option>
    		      <option value="E" <?php if($formato=="E"){echo("selected");} ?> >EMPASTADO</option>
    		      <option value="R" <?php if($formato=="R"){echo("selected");} ?> >RUSTICO</option>
    		      <option value="U" <?php if($formato=="U"){echo("selected");} ?> >UNICO</option>
  		      </select>
    		</div></td>
                                                       
<td><div align="right"><font color="#990000">*</font> Colección: 
  <select id="coleccion"  name="coleccion" disabled="disabled">
    <option value="0" <?php if($coleccion==""){echo("selected");} ?>>--Seleccione--</option>
    <?php
									if(($editorial!="")&&($editorial!="0")){
										$link=Conectarse();
										$result=mysql_query("select COL_COLECC, COL_DESCRI from inv_colecc where COL_PROV=".$editorial." order by COL_DESCRI",$link);
										while($row = mysql_fetch_array($result)) {
											if($row[0]==$coleccion){
												printf("<option value='%s' selected>%s</option>", $row[0], utf8_decode($row[1]));
											}else{
												printf("<option value='%s'>%s</option>", $row[0], utf8_decode($row[1]));
											}
										}
										mysql_free_result($result);
										mysql_close($link);
									}
									?>
  </select>
</div></td>  
		</tr>
		<tr>
			<td><div align="right">Número de tomo: <input name="num_tomo" type="text" id="num_tomo" value="<?php echo($num_tomo); ?>" size="12" maxlength="10" readonly="readonly">
		    </div></td>
			<td><div align="right">Número librerias del sur: <input name="num_libsur" type="text" id="num_libsur" value="<?php echo($num_libsur); ?>" size="12" maxlength="10" readonly="readonly">
		    </div></td>
		</tr>
  		<tr>
			<td><div align="right">Tema: 
			<input name="tema" type="text" id="tema" value="<?php echo($tema); ?>" size="35" maxlength="30" readonly="readonly">
			</div></td>
			<td><div align="right">Año de publicación: <input name="ano_pub" type="text" id="ano_pub" value="<?php echo($ano_pub); ?>" size="5" maxlength="4" readonly="readonly">
			</div></td>
		</tr>
  		<tr>
			<td><div align="right">Cantidad de páginas: <input name="cant_pag" type="text" id="cant_pag" value="<?php echo($cant_pag); ?>" size="22" maxlength="20" readonly="readonly">
		    </div></td>
			<td><div align="right">Serie: 
			<input name="serie" type="text" id="serie" value="<?php echo($serie); ?>" size="22" maxlength="20" readonly="readonly">
			</div></td>
		</tr>
  		<tr>
			<td><div align="right">Embalaje: 
			    <select id="empaque"  name="empaque">
			      <option value="0" <?php if($empaque==""){echo("selected");} ?>>--Seleccione--</option>
			      <?php
									$link=Conectarse();
									$result=mysql_query("select emp_codemp, emp_descrip from inv_empaque order by emp_descrip",$link);
									while($row = mysql_fetch_array($result)) {
										if($row[0]==$empaque){
											printf("<option value='%s' selected>%s</option>", $row[0], utf8_decode($row[1]));
										}else{
											printf("<option value='%s'>%s</option>", $row[0], utf8_decode($row[1]));
										}
									}
									mysql_free_result($result);
									mysql_close($link);
									?>
		      </select>
			</div></td>
			<td><div align="right">Precio:
            <input name="precio2" type="text" id="precio2" onkeypress="return esNumero(event,'f',this);" value="<?php echo($precio2); ?>" size="16" maxlength="15" readonly="readonly" />
			</div></td>    		
    	</tr>
  		<tr>
			<td><div align="right"><font color="#990000">*</font> Fecha Creaci&oacute;n: 
			  <input size="10" type="text" id="fch_creacion" name="fch_creacion" value="<? echo cambiaf_a_normal($fch_creacion);?>" readonly>
			  </div></td>
			<td><div align="right">Existencia:
            <input type="text" id="exist1" name="exist1" value="<?php echo($exist1); ?>" size="10" class="inputCodigo" readonly="readonly" />
			</div></td>
    	</tr>
  		<tr>
			<td><div align="right">Cod. Barra:
              <input name="lib_codbarra" type="text" id="lib_codbarra" value="<?php echo($lib_codbarra); ?>" size="15" maxlength="14" readonly="readonly" />
              <input name="txtContador2" type="hidden" id="txtContador2" value="65" size="5" />              
              <input name="txtContador" type="hidden" id="txtContador" value="65" size="5">
			</div></td>
		  <td><div align="right">Tema:
              <strong>
              <select class="selectLibros" id="tema2" name="tema2">
                <option value="0" <?php if($tema==""){echo("selected");} ?>>--Seleccione--</option>
                <?php
									$link=Conectarse();
									$result=mysql_query("select tema_nombre, UPPER(rtrim(tema_nombre)) from inv_tema order by tema_nombre",$link);
									while($row = mysql_fetch_array($result)) {
										if($row[0]==$tema){
											printf("<option value='%s' selected>%s</option> ", $row[0], utf8_decode($row[1]));
										}else{
											printf("<option value='%s'>%s</option> ", $row[0], utf8_decode($row[1]));
										}
									}
									mysql_free_result($result);
									mysql_close($link);
									?>
              </select>
          </strong></div></td>
			</tr>
		
		</tr>
		</table>
	</form>
<script type="text/javascript">
	////////////////////////////////////// FUNCIONES DEL CALENDARIO
	Calendar.setup(
	  {
		inputField : "fch_creacion", // ID of the input field
		ifFormat : "%d/%m/%Y", // the date format
		button : "f_trigger_c", // ID of the button
	  align : "Tl"           // alignment (defaults to "Bl")
    }
	);
</script>
</div>

<hr>

Busqueda por titulo

<div id="estiloFormaLarga">
<form method="post" name="frmBusqLibro" action="inventario.php?p=librosConsulta">
	<input type="hidden" name="accion">
	<table>
		<tr>
			<td>Cod. Libro/ISBN/Barra:  <input type="text" id="cod_isbn2" name="cod_isbn2" value="<?php echo ($cod_isbn2); ?>" size="15" maxlength="14"  onclick="this.value=''"></td>
    		<td>Titulo/Autor/Editorial:    		  <input type="text" id="titulo2" name="titulo2" value="<?php echo($titulo2); ?>" size="39" maxlength="162"></td>
		</tr>
		<tr>
			<td>Autor: <select class="selectLibros" id="autor2" name="autor2" value="<?php echo($autor2); ?>">
                	<option value="0" <?php if($autor2==""){echo("selected");} ?>>--Seleccione--</option>
									<?php
									$link=Conectarse();
									$result=mysql_query("select aut_codigo, UPPER(rtrim(aut_nombre)) from inv_autor order by aut_nombre",$link);
									while($row = mysql_fetch_array($result)) {
										if($row[0]==$autor2){
											printf("<option value='%s' selected>%s</option>", $row[0], utf8_decode($row[1]));
										}else{
											printf("<option value='%s'>%s</option>", $row[0], utf8_decode($row[1]));
										}
									}
									mysql_free_result($result);
									mysql_close($link);
									?>
              		</select></td>
    		<td>Editorial: <select class="selectLibros" id="editorial2" name="editorial2" value="<?php echo($editorial2); ?>" onchange="frmBusqLibro.submit();">
						<option value="0" <?php if($editorial2==""){echo("selected");} ?>>--Seleccione--</option>
									<?php
									$link=Conectarse();
									$result=mysql_query("select prv_codpro, prv_nombre from inv_provee order by prv_nombre",$link);
									while($row = mysql_fetch_array($result)) {
										if($row[0]==$editorial2){
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
		<tr>
			<td></td>		
			<td>Colección: <select id="coleccion2" name="coleccion2" value="<?php echo($coleccion2); ?>">
						<option value="0" <?php if($coleccion2==""){echo("selected");} ?>>--Seleccione--</option>
									<?php
									if(($editorial2!="")&&($editorial2!="0")){
										$link=Conectarse();
										$result=mysql_query("select COL_COLECC, COL_DESCRI from inv_colecc where COL_PROV=".$editorial2." order by COL_DESCRI",$link);
										while($row = mysql_fetch_array($result)) {
											if($row[0]==$coleccion){
												printf("<option value='%s' selected>%s</option>", $row[0], utf8_decode($row[1]));
											}else{
												printf("<option value='%s'>%s</option>", $row[0], utf8_decode($row[1]));
											}
										}
										mysql_free_result($result);
										mysql_close($link);
									}
									?>
						</select></td>  		
    	</tr>
  		<tr>
    		<td colspan="2" class="botones">
				<INPUT TYPE="button" VALUE="Buscar" onClick="f_process(this.form,'','E','inventario.php?p=librosConsulta&accion=Listar&letra=busq')">
			</td>			
		</tr>
		</table>
	</form>
</div>
<div id="estiloBusqueda">
  <form method="post">
</form>
</div>
<?php
///////////////////////////////////////////// CREACION DE TABLA

//$accion=$_POST['accion'];
//if ($accion == "")
	$accion=$_GET['accion'];
	
//echo "editorial2=".$editorial2;
if ($accion == "Listar")
{
	$link=Conectarse();
	
	$strSelect="
	
	
	SELECT count(l.lib_codart)
	FROM inv_libros l
INNER JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
JOIN inv_provee p ON l.prv_codpro = p.prv_codpro
	";
	
	if ($letra == "busq")
	{
		$strWhere ="WHERE l.aut_codigo = a.aut_codigo ";
		if ($titulo2 != "")
			$strWhere = $strWhere . "AND l.lib_descri LIKE '%" . $titulo2 . "%' OR p.prv_nombre LIKE '%" . $titulo2 . "%' OR a.aut_nombre LIKE '%" . $titulo2 . "%'";
		if ($cod_isbn2 != "")
			$strWhere = $strWhere . "AND l.lib_codsib = " . $cod_isbn2 . " OR l.lib_codbarra = " . $cod_isbn2 . "  OR l.lib_codart= " . $cod_isbn2 . "  ";
		if ($autor2 != "0")
			$strWhere = $strWhere . "AND l.aut_codigo = " . $autor2 . " ";
		if ($editorial2 != "0"){
			$strWhere = $strWhere . "AND l.prv_codpro = " . $editorial2 . " ";
			if ($coleccion2 != "0")
				$strWhere = $strWhere . "AND l.col_colecc = " . $coleccion2 . " ";
			}
	}else{
		$strWhere ="WHERE l.lib_descri REGEXP '^" . utf8_encode($letra) . "+'";
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
	
	echo "<p>";
	//construyo la sentencia SQL 
	
	$strSelect="
	
	SELECT  l.lib_codart,
						l.lib_codsib,
						UPPER(l.lib_descri),
						UPPER(a.aut_nombre),
						l.lib_present,
l.lib_preact,
lib_codbarra,
l.lib_exiact,
UPPER(p.prv_nombre) AS PROVEEDOR





FROM inv_libros l
INNER JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
JOIN inv_provee p ON l.prv_codpro = p.prv_codpro

	";
				
	if ($letra == "busq")
	{
		$strWhere ="WHERE l.aut_codigo = a.aut_codigo ";
		if ($titulo2 != "")
				$strWhere = $strWhere . "AND l.lib_descri LIKE '%" . $titulo2 . "%' OR p.prv_nombre LIKE '%" . $titulo2 . "%' OR a.aut_nombre LIKE '%" . $titulo2 . "%'";
		if ($cod_isbn2 != "")
			$strWhere = $strWhere . "AND l.lib_codsib = " . $cod_isbn2 . " OR l.lib_codbarra = " . $cod_isbn2 . " OR l.lib_codart= " . $cod_isbn2 . "  ";
		if ($autor2 != "0")
			$strWhere = $strWhere . "AND l.aut_codigo = " . $autor2 . " ";
		if ($editorial2 != "0"){
			$strWhere = $strWhere . "AND l.prv_codpro = " . $editorial2 . " ";
			if ($coleccion2 != "0")
				$strWhere = $strWhere . "AND l.col_colecc = " . $coleccion2 . " ";
			}
	}else{
		$strWhere ="WHERE l.aut_codigo = a.aut_codigo and l.lib_descri REGEXP '^" . utf8_encode($letra) . "+' ";
	}
	
	$strOrder="ORDER BY l.lib_descri LIMIT " . $inicio . "," . $TAMANO_PAGINA;
				
	$strQry = $strSelect . $strWhere . $strOrder;
	//echo $strQry;
	$result=mysql_query($strQry,$link);
	
	/*
	$result=mysql_query("SELECT l.lib_codart,
								l.lib_codsib,
								l.lib_descri,
								DATE_FORMAT(l.lib_fchlib,'%d/%m/%Y')
						 FROM inv_libros l 
						 WHERE l.lib_descri REGEXP '^" . utf8_encode($letra) . "+'
						 ORDER BY l.lib_descri
						 LIMIT " . $inicio . "," . $TAMANO_PAGINA,$link);
	*/	
	$cont=0;
	while($row = mysql_fetch_array($result)) {
		if ($cont==0){
			echo ("
			<div id='tabla'>
			<form name=\"frmListTable\" method=\"post\"> 
			<input type=\"hidden\" name=\"var_busq\">
			<TABLE CELLSPACING=0>
				<TR class='estilotitulo'>
					<TD width='12%'>CODIGO</TD> 
    				<TD width='25%'>TITULO</TD> 
					<TD width='40%'>EDITORIAL</TD>
					<TD width='20%'>AUTOR</TD> 
					<TD width='5%'>TIPO</TD> 
					<TD width='5%'>PRECIO</TD>  
					<TD width='5%'>EXIST</TD>  
				</TR>
			");
		}
		if ($cont%2){
			printf("<tr class='celdapar' onClick=\"v_select(frmListTable, '%s','inventario.php?p=librosConsulta')\">",$row[0]);
		}else{
			printf("<tr onClick=\"v_select(frmListTable, '%s','inventario.php?p=librosConsulta')\">",$row[0]);
		}
		printf("<td>&nbsp;%s</td> ", $row[0]);
		printf("<td>&nbsp;%s</td> ", strtoupper(addslashes($row[2])));
		printf("<td>&nbsp;%s</td> ", strtoupper(addslashes($row[8])));
		printf("<td>&nbsp;%s</td> ", strtoupper(addslashes($row[3])));
	

			
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
		printf("<td>&nbsp;%s</td> ", $row[5]);
				printf("<td>&nbsp;%s</td> ", strtoupper(addslashes($row[7])));
				
		echo("</tr>");
		$cont++;	
	}
	mysql_free_result($result);
	mysql_close($link);
	echo ("
	</table>
	</form>
	</div>
	");
	
/////////////muestro los distintos índices de las páginas, si es que hay varias páginas 
	 
}
?>
<p>&nbsp;</p>
