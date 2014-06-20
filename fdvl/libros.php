
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<div id="navegador">
	<p>
		<a href="#">SIDVENLIB 2.0 | MANTENIMIENTO | LIBROS </a>  
		
	</p>
</div>
<style>
SELECT {
border: solid #000000 1px; FONT-SIZE: 11px; BACKGROUND: #FF3333; COLOR: #ffffff; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
</style>




	









	<script src="js/jquery-1.6.2.js"></script>
<script type="text/javascript" src="js/jquery.uniquefield.js"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" />
<link type="text/css" rel="stylesheet" href="css/jquery.uniquefield.css" />

<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>




<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<body onLoad="marcar()">


<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css" />
<body onLoad="document.forms['frmLibro'].titulo.focus();">



<body leftmargin="0" topmargin="0" rightmargin="0" marginwidth="0" marginheight="0">
<table border="1" width="100%" id="table1" style="border-width: 0px" height="0">





</div>							
	<tr>
	

	</div>
	</div>
	</div>
	</div>
	</div>
  </div>
	</div>
</table>
    
    <script>
$(document).ready(function(){
 $("#e_deporte").autocomplete("autocomplete_edicion.php", {
		selectFirst: true
	});
});
</script>


  
<script type="text/javascript">
$(function(){
	$('#titulo').uniqueField({
		url: 'verifica_libro.php',
		baseId: 'exam_y'
	});
	$('#titulo').uniqueField({
		url: 'verifica_libro.php',
		baseId: 'exam_z'
	});
});
</script>

<script type="text/javascript">
$(function(){
	$('#lib_codbarra').uniqueField({
		url: 'verifica_cbarra.php',
		baseId: 'exam_y'
	});
	$('#lib_codbarra').uniqueField({
		url: 'verifica_cbarra.php',
		baseId: 'exam_z'
	});
});
</script>



<script type="text/javascript">
$(function(){
	$('#cod_isbn').uniqueField({
		url: 'verifica_isbn.php',
		baseId: 'exam_y'
	});
	$('#cod_isbn').uniqueField({
		url: 'verifica_isbn.php',
		baseId: 'exam_z'
	});
});
</script>


    
<?php
include("includes/functions.php");

$valida = $_SESSION['root'];

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

$t_articulo = isset($_POST['t_articulo'])?$_POST['t_articulo']:'';
$iva = isset($_POST['iva'])?$_POST['iva']:'';
$novedad = isset($_POST['novedad'])?$_POST['novedad']:'';



$usuario=$_SESSION['Nusuario'];



//Limito la busqueda 
$TAMANO_PAGINA = 25; 

//examino la página a mostrar y el inicio del registro a mostrar 
$pagina = $_GET["pagina"];
$letra = $_GET["letra"];

$cod_isbn2 = isset($_GET['cod_isbn2'])?$_GET['cod_isbn2']:'';
$titulo2 = isset($_GET['titulo2'])?$_GET['titulo2']:'';
$autor2 = isset($_GET['autor2'])?$_GET['autor2']:'';
$editorial2 = isset($_GET['editorial2'])?$_GET['editorial2']:'';
$coleccion2 = isset($_GET['coleccion2'])?$_GET['coleccion2']:'';
$tema2 = isset($_GET['tema2'])?$_GET['tema2']:'';

//echo "editorial2=".$editorial2;




if ($cod_isbn2 == "") $cod_isbn2=$_POST['cod_isbn2'];
if ($titulo2 == "") $titulo2=$_POST['titulo2'];
if ($autor2 == "") $autor2=$_POST['autor2'];
if ($editorial2 == "") $editorial2=$_POST['editorial2'];
if ($coleccion2 == "") $coleccion2=$_POST['coleccion2'];
if ($tema2 == "") $tema2=$_POST['tema2'];

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
						$fch_compra2, $formato, $coleccion, $num_tomo, $num_libsur, $tema, $ano_pub, $cant_pag, $serie,$lib_codbarra, $iva,$t_articulo, $tema, $novedad);
} 

?>
<script>
	////////////////////////// CAMPOS QUE SE DEBEN VALIDAR
  var fieldsFormatForm =  Array(new Array('titulo', 'NO', 'VACIO', 'Titulo'),///
                               //new Array('cod_isbn', 'NO', 'ENTERO', 'Cod. ISBN'),
     						   new Array('cod_isbn', 'NO', 'VACIO', 'Cod. ISBN'),///
                               new Array('aut_codigo2', 'NO', 'VACIO', 'Autor'),///
							   new Array('prv_codpro2', 'NO', 'VACIO', 'Editorial'),///
							   ///   new Array('autor', 'NO', 'SELECTED_OPTION', 'Autor'),///
                              /// new Array('editorial', 'NO', 'SELECTED_OPTION', 'Editorial'),///	
                               new Array('formato', 'NO', 'SELECTED_OPTION', 'Formato'),///
							   new Array('coleccion', 'NO', 'SELECTED_OPTION', 'Colección'),///
							    /// new Array('fch_creacion', 'NO', 'FECHA', 'Fecha Creación'),///
    						   new Array('tema','NO','SELECTED_OPTION', 'Tema'),///
							  new Array('iva', 'NO', 'SELECTED_OPTION','IVA'),///
							   new Array('t_articulo','NO','SELECTED_OPTION', 'Tipo de Articulo'),///
							  
							   new Array('costo2', 'SI', 'DECIMAL', 'Costo Actual'), 
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

</head>


<style>
SELECT {
border: solid #000000 1px; FONT-SIZE: 11px; BACKGROUND: #FF3333; COLOR: #ffffff; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
</style>



<div id="estiloFormaLarga">
  

  <form name="frmLibro" method="post" action="inventario.php?p=libros"  accept-charset="UTF-8">
	<input type="hidden" name="accion">
	
        
  
  <div id="TabbedPanels2" class="TabbedPanels">
        <ul class="TabbedPanelsTabGroup">
          <li class="TabbedPanelsTab" tabindex="0">FICHA BASICA</li>
          <li class="TabbedPanelsTab" tabindex="0">FICHA DETALLADA</li>
          
        </ul>
        <div class="TabbedPanelsContentGroup">
          <div class="TabbedPanelsContent">
          





      <!--INICIA CONTENIDO #1 ---<!-->                
    <td align="left"><table width="100%" border="0">
      <tr>
        <td colspan="4" align="center"><span class="mensajes"><?php echo($msg); ?></span></td>
        </tr>
      <tr>
        <td align="left">Cod: </td>
        <td colspan="3" align="left"><input name="cod_libro" type="text" class="inputCodigo" value="<?php echo($cod_libro); ?>" size="20" maxlength="20" readonly="readonly" /></td>
      </tr>
      <tr>
        <td width="9%" align="left"> Titulo: </td>
        <td colspan="3" align="left"><input type="text"    id="titulo" name="titulo" value="<?php echo strtoupper ($titulo); ?>" size="60" maxlength="162" />
          <img src="imagenes/iconoBuscar.png" alt="" width="15" height="15" /></td>
        
        
        
        
        
      </tr>
      <tr>
        <td align="left"> ISBN: </td>
        <td align="left"><input type="text"   id="cod_isbn" name="cod_isbn" value="<?php echo($cod_isbn); ?>" size="30" maxlength="14" />
          <img src="imagenes/iconoBuscar.png" alt="" width="15" height="15" /></td>
        <td align="left" class="textareaValidState"><strong style="color: #C00">Es una Novedad?</strong></td>
        <td align="left">
        
            
    


 <!--- <input id="tags" size="30" maxlength="30" />
---->

        
        
        <input name="novedad" type="checkbox" id="novedad"  value="SI" <?php if($novedad=="SI") echo 'checked="checked"' ?> /></td>
        </tr>
      <tr>
        <td align="left">Cod. Barra:</td>
        <td align="left"><input type="text" id="lib_codbarra"   name="lib_codbarra" value="<?php echo($lib_codbarra); ?>" size="30" maxlength="14" />
          <img src="imagenes/iconoBuscar.png" alt="" width="15" height="15" /></td>
        <td width="28%" align="left">Fecha Creaci&oacute;n: </td>
        <td width="17%" align="left"><input size="10" type="text"  id="fch_creacion" name="fch_creacion" value="<? echo cambiaf_a_normal($fch_creacion);?>" readonly="readonly" /></td>
      </tr>
      <tr>
        <td align="left">Autor: </td>
        
        <?php 
		
			
			$link=Conectarse();
			
 
$resultFac = @mysql_query("
select aut_codigo, aut_nombre 
FROM inv_autor  
WHERE aut_codigo ='$autor' ",$link); 
$rowFac=mysql_fetch_array($resultFac); 
$aut_codigo=$rowFac["aut_codigo"];
$aut_codigo2=$rowFac["aut_nombre"];

	mysql_free_result($resultFac);
									mysql_close($link);

$link=Conectarse();
			
 
$resultFac2 = @mysql_query("
select prv_codpro, prv_nombre from inv_provee 
WHERE prv_codpro ='$editorial' ",$link); 

$rowFac2=mysql_fetch_array($resultFac2); 
$prv_codpro=$rowFac2["prv_codpro"];
$prv_codpro2=$rowFac2["prv_nombre"];

	mysql_free_result($resultFac2);
									mysql_close($link);
			
		
		?>
        <td align="left">
          
          
          <input   name="aut_codigo2" type="text" id="aut_codigo2"   value="<?php echo($aut_codigo2); ?>" size="35" maxlength="60" readonly="readonly" />
          <input type="hidden" name="autor" id="autor" value="<?php echo($autor); ?>"  />
          <img src="imagenes/iconoBuscar.png" alt="" onclick="buscaAutor()" width="15" height="15" /></td>
        
        <td align="left">Tema:</td>
        <td align="left"><strong><select class="selectLibros" id="tema" name="tema">
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
        </select></strong></td>
      </tr>
      <tr>
        <td align="left">Editorial: </td>
        <td align="left"><input name="prv_codpro2" type="text" id="prv_codpro2"  onClick="this.value=''"  value="<?php echo($prv_codpro2); ?>" size="35" maxlength="60" readonly="readonly" />
          <input type="hidden" name="editorial" id="editorial" value="<?php echo($editorial); ?>"  />
          <img src="imagenes/iconoBuscar.png" alt="" onclick="buscaProveedor();" width="15" height="15" /></td>
        <td align="left"> I.V.A?</td>
        <td align="left"><input name="iva" type="checkbox" id="iva"  value="2" <?php if($iva=="2") echo 'checked="checked"' ?> /></td>
      </tr>
      <tr>
        <td align="left">Formato: </td>
        <td align="left"><select id="formato" name="formato">
          <option value="0" <?php if($formato==""){echo("selected");} ?> >--Seleccione--</option>
          <option value="E" <?php if($formato=="E"){echo("selected");} ?> >EMPASTADO</option>
          <option value="R" <?php if($formato=="R"){echo("selected");} ?> >RUSTICO</option>
          <option value="U" <?php if($formato=="U"){echo("selected");} ?> >UNICO</option>
        </select></td>
        <td align="left">Tipo de Articulo:</td>
        <td align="left"><select id="t_articulo" name="t_articulo">
          <option value="0" <?php if($t_articulo==""){echo("selected");} ?> >--Seleccione--</option>
          <option value="L" <?php if($t_articulo=="L"){echo("selected");} ?> >LIBRO</option>
          <option value="R" <?php if($t_articulo=="R"){echo("selected");} ?> >REVISTA</option>
          <option value="P" <?php if($t_articulo=="P"){echo("selected");} ?> >PERIODICO</option>
          <option value="F" <?php if($t_articulo=="F"){echo("selected");} ?> >FOLLETO</option>
          <option value="C" <?php if($t_articulo=="C"){echo("selected");} ?> >CD</option>
          <option value="D" <?php if($t_articulo=="D"){echo("selected");} ?> >DVD</option>
          <option value="A" <?php if($t_articulo=="A"){echo("selected");} ?> >ARTESANIA</option>
          <option value="G" <?php if($t_articulo=="G"){echo("selected");} ?> >GUIA TURISTICA</option>
          <option value="POS" <?php if($t_articulo=="POS"){echo("selected");} ?> >POSTALES</option>
          
          <option value="AF" <?php if($t_articulo=="AF"){echo("selected");} ?> >AFICHE</option>
           <option value="JU" <?php if($t_articulo=="JU"){echo("selected");} ?> >JUEGOS</option>
            <option value="PA" <?php if($t_articulo=="PA"){echo("selected");} ?> >PAPELERIA</option>
        </select></td>
      </tr>
      <tr>
        <td align="left">Nº de tomo: </td>
        <td align="left"><input type="text" id="num_tomo" onclick="this.value=''"   name="num_tomo" value="<?php echo($num_tomo); ?>" size="12" maxlength="4" />
          <img src="imagenes/iconoBuscar.png" alt="" width="15" height="15" /></td>
        <td align="left">Precio: </td>
        <td align="left"><input type="text" id="precio2" name="precio2" value="<?php echo($precio2); ?>" size="30" maxlength="6" onkeypress="return esNumero(event,'f',this);" /></td>
      </tr>
      <tr>
        <td align="left">Colecci&oacute;n: </td>
        <td align="left"><select id="coleccion" name="coleccion">
          <option value="0" <?php if($coleccion==""){echo("selected");} ?>>--Seleccione--</option>
            <?php
									if(($editorial!="")&&($editorial!="0")){
										$link=Conectarse();
										$result=mysql_query("select COL_COLECC, UPPER(COL_DESCRI) from inv_colecc where COL_PROV=".$editorial." order by COL_DESCRI",$link);
										while($row = mysql_fetch_array($result)) {
											if($row[0]==$coleccion){
												printf("<option value='%s' selected>%s</option>", $row[0], $row[1]);
											}else{
												printf("<option value='%s'>%s</option>", $row[0], $row[1]);
											}
										}
										mysql_free_result($result);
										mysql_close($link);
									}
									?>
          </select></td>
        <td align="left">Existencia:</td>
        <td align="left"><input type="text" id="exist2" name="exist2" onkeyup = "puntitos(this,this.value.charAt(this.value.length-1))" value="<?php echo($exist2); ?>" size="10" class="inputCodigo" readonly="readonly" /></td>
      </tr>
      <tr>
        <td bgcolor="#EEEEEE">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="left">
        
        
        
        
  
        
        
        
        
        
        
        
        
        </td>
      </tr>
      <tr>
        <td bgcolor="#EEEEEE"><span style="border-style: none; border-width: medium"><img src="" width="100" height="1" alt="" /></span></td>
        <td align="left"><input name="txtContador" type="hidden" id="txtContador" value="65" size="5" />
          <span style="border-style: none; border-width: medium"><img src="" width="330" height="1" alt="" /></span></td>
        <td align="right"><span style="border-style: none; border-width: medium"><img src="" width="125" height="1" alt="" /></span></td>
        <td align="left"><span style="border-style: none; border-width: medium"><img src="" width="200" height="1" alt="" /></span></td>
      </tr>
      </table>
              
          
    
    
    
    
    </div>
      <div class="TabbedPanelsContent">
        <table width="100%" border="0">
          <tr>
            <td align="left">&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">Cantidad de p&aacute;ginas: </td>
            <td colspan="2" align="left"><input type="text" id="cant_pag" name="cant_pag" value="<?php echo($cant_pag); ?>" size="30" maxlength="20" /></td>
            <td align="left">N&uacute;mero librerias del sur: </td>
            <td align="left"><input type="text" id="num_libsur" name="num_libsur" value="<?php echo($num_libsur); ?>" size="30" maxlength="10" /></td>
          </tr>
          <tr>
            <td align="left">Saldo Cierre Mes Ant: </td>
            <td colspan="2" align="left"><input type="text" id="saldo_cierre" name="saldo_cierre" value="<?php echo($saldo_cierre); ?>" size="10" maxlength="8" /></td>
            <td align="left">A&ntilde;o de publicaci&oacute;n: </td>
            <td align="left"><input type="text" id="ano_pub" name="ano_pub" value="<?php echo($ano_pub); ?>" size="30" maxlength="4" /></td>
          </tr>
          <tr>
            <td align="left">Embalaje: </td>
            <td colspan="2" align="left"><select id="empaque" name="empaque">
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
            </select></td>
            <td align="left">Serie: </td>
            <td align="left"><input type="text" id="serie" name="serie" value="<?php echo($serie); ?>" size="30" maxlength="20" /></td>
          </tr>
          <tr>
            <td align="left">Stock Min: </td>
            <td colspan="2" align="left"><input type="text" id="stock_min" name="stock_min" value="<?php echo($stock_min); ?>" size="30" maxlength="8" /></td>
            <td align="left">Cuenta Contable: </td>
            <td align="left"><input type="text" id="cta_contable" name="cta_contable" value="<?php echo($cta_contable); ?>" size="30" maxlength="10" /></td>
          </tr>
          <tr>
            <td align="left">Stock Max: </td>
            <td colspan="2" align="left"><input type="text" id="stock_max" name="stock_max" value="<?php echo($stock_max); ?>" size="30" maxlength="8" /></td>
            <td align="left">Cuenta Presupuestaria: </td>
            <td align="left"><input type="text" id="cta_presup" name="cta_presup" value="<?php echo($cta_presup); ?>" size="12" maxlength="10" /></td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
            <td align="left">Ubic. Almacen: </td>
            <td align="left"><select id="ubi_almacen" name="ubi_almacen">
              <option value="0" <?php if($ubi_almacen==""){echo("selected");} ?>>--Seleccione--</option>
              <?php
									$link=Conectarse();
									$result=mysql_query("select ubi_codigo from inv_ubicac",$link);
									while($row = mysql_fetch_array($result)) {
										if($row[0]==$ubi_almacen){
											printf("<option value='%s' selected>%s</option>", $row[0], $row[0]);
										}else{
											printf("<option value='%s'>%s</option>", $row[0], $row[0]);
										}
									}					
									mysql_free_result($result);
									mysql_close($link);
									?>
            </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
            <td>Observaciones: </td>
            <td align="left"><textarea id="observaciones" name="observaciones"
    																onkeydown="textCounter(this.form.observaciones,this.form.txtContador,65);"
																		onkeyup="textCounter(this.form.observaciones,this.form.txtContador,65);"
																		><?php echo($observaciones); ?></textarea></td>
          </tr>
          <tr>
            <td><div class="titfila"></div></td>
            <td colspan="2" align="left">&nbsp;</td>
            <td></td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="left"><span class="titfila">Anterior</span></td>
            <td colspan="2" align="left">&nbsp;</td>
            <td align="left"><div class="titfila">Actual</div></td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">Existencia: </td>
            <td colspan="2" align="left"><input type="text" id="exist1" name="exist1" value="<?php echo($exist1); ?>" size="10" class="inputCodigo" readonly="readonly" /></td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">Costo: </td>
            <td colspan="2" align="left"><input type="text" id="costo1" name="costo1" value="<?php echo($costo1); ?>" size="16" class="inputCodigo" readonly="readonly" /></td>
            <td align="left">Costo: </td>
            <td align="left"><input type="text"  id="costo2" name="costo2" value="<?php echo($costo2); ?>" size="16" maxlength="6" onkeypress="return esNumero(event,'f',this) ;" /></td>
          </tr>
          <tr>
            <td align="left">Costo Promedio: </td>
            <td colspan="2" align="left"><input type="text" id="costo_p1" name="costo_p1" value="<?php echo($costo_p1); ?>" size="16" class="inputCodigo" readonly="readonly" /></td>
            <td align="left">Costo Promedio: </td>
            <td align="left"><input type="text" id="costo_p2" name="costo_p2" value="<?php echo($costo_p2); ?>" size="16" maxlength="15" onkeypress="return esNumero(event,'f',this);" /></td>
          </tr>
          <tr>
            <td align="left">Precio: </td>
            <td colspan="2" align="left"><input type="text" id="precio1" name="precio1" value="<?php echo($precio1); ?>" size="16" class="inputCodigo" readonly="readonly" /></td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">Precio Promedio: </td>
            <td colspan="2" align="left"><input type="text" id="precio_p1" name="precio_p1" value="<?php echo($precio_p1); ?>" size="16" class="inputCodigo" readonly="readonly" /></td>
            <td align="left">Precio Promedio: </td>
            <td align="left"><input type="text" id="precio_p2" name="precio_p2" value="<?php echo($precio_p2); ?>" size="16" maxlength="15" onkeypress="return esNumero(event,'f',this);" /></td>
          </tr>
          <tr>
            <td align="left">Fecha Compra: </td>
            <td colspan="2" align="left"><input size="10" type="text" id="fch_compra1" name="fch_compra1" value="<? echo cambiaf_a_normal($fch_compra1);?>" readonly="readonly" /></td>
            <td align="left">Fecha Compra: </td>
            <td align="left"><input size="10" type="text" id="fch_compra2" name="fch_compra2" value="<? echo cambiaf_a_normal($fch_compra2);?>" readonly="readonly" /></td>
          </tr>
          <tr>
            <td align="left" class="botones">Responsable: </td>
            <td colspan="2" align="left"><span class="botones">
              <input type="text" id="usuario" name="usuario" value="<?php echo($usuario); ?>" size="22" class="inputCodigo" readonly="readonly" />
            </span></td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" class="botones">&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
        </table>
      </div>
    </div>
 

    </div>
    </div>
          <!--FINALIZA INICIO CONTENIDO #1 ---<!-->        
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
        

 
<table align="center" bgcolor="#FFFFFF">
		<tr>
		<tr>
	
    

   		  <td colspan="9" class="botones">

	<INPUT TYPE="button" class="mybutton" VALUE="Guardar" <?php if($valida==""){echo("disabled");} ?>  onClick="f_process(this.form,fieldsFormatForm,'G','process_libros.php')">
    
      			<INPUT TYPE="button" class="mybutton" VALUE="Limpiar" onClick="location='inventario.php?p=libros'">
   			 <INPUT TYPE="button" class="mybutton" VALUE="Buscar" onClick="v_buscar(this.form,'inventario.php?p=libros')">
			<INPUT TYPE="button" class="mybutton"  VALUE="Modificar" <?php if($valida==""){echo("disabled");} ?>  onClick="f_process(this.form,fieldsFormatForm,'A','process_libros.php')">
			   <INPUT TYPE="button" class="mybutton" VALUE="Eliminar" <?php if($valida==""){echo("disabled");} ?>   onClick="f_process(this.form,fieldsFormatForm,'E','inventario.php?p=libros')">

	
		  </td>
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







<?php

	
$accion=$_POST['accion'];
if ($accion == "Buscar")
{
	


$titulo=$_POST['titulo'];
$cod_isbn=$_POST['cod_isbn'];
$lib_codbarra=$_POST['lib_codbarra'];
$autor=$_POST['autor'];
$editorial=$_POST['editorial'];

	
	
 
	$link=Conectarse();
	$result=mysql_query("
						
						
SELECT inv_libros.lib_codart as CODIGO,UPPER(inv_libros.lib_descri) AS TITULO,
inv_libros.lib_present AS PRESENTACION,
UPPER(inv_provee.prv_nombre) AS PROVEEDOR,
UPPER(inv_autor.aut_nombre) AS AUTOR,
lib_preact AS PRECIO,
inv_libros.lib_numedit AS TOMO, inv_libros.lib_codsib as ISBN, inv_libros.aut_codigo, inv_libros.prv_codpro,  inv_libros.lib_exiact AS EXISTENCIA

FROM inv_libros
LEFT JOIN inv_provee 
ON inv_libros.prv_codpro = inv_provee.prv_codpro
LEFT JOIN inv_autor 
ON inv_autor.aut_codigo = inv_libros.aut_codigo

where (lib_descri like '%$titulo%' OR '$titulo' = '' )
and (lib_codsib = '$cod_isbn' or '$cod_isbn' ='') 
and (lib_codbarra  = '$lib_codbarra' or '$lib_codbarra' ='') 
and (lib_numedit  = '$num_tomo' or '$num_tomo' ='') 
and (inv_libros.aut_codigo  = '$autor' or '$autor' ='') 
and (inv_libros.prv_codpro  = '$editorial' or '$editorial' ='') 
and (inv_libros.lib_tema  = '$tema' or '$tema' ='0') 
GROUP BY inv_libros.lib_codart

	LIMIT 0 , 500
"
						,$link);
	

	
	
	
	$cont=0;
	while($row = mysql_fetch_array($result)) {
		if ($cont==0){
			echo ("
			<div id='tabla'>
			<form name=\"frmUserTable\" method=\"post\"> 
			<input type=\"hidden\" name=\"var_busq\">
			<TABLE CELLSPACING=0>
				<TR class='estilotitulo'>
					<TD width='12%'>CODIGO</TD> 
    				<TD width='25%'>TITULO</TD> 
					<TD width='40%'>EDITORIAL</TD>
					<TD width='20%'>AUTOR</TD> 
					<TD width='5%'>TIPO</TD> 
					<TD width='5%'>TOMO</TD> 
					<TD width='5%'>PRECIO</TD>  
					<TD width='5%'>EXIST</TD>  
				</TR>

				</TR>
			");
		}
		if ($cont%2){
			printf("<tr class='celdapar' onClick=\"v_select(frmUserTable, '%s','inventario.php?p=libros')\">",$row["CODIGO"]);
		}else{
			printf("<tr onClick=\"v_select(frmUserTable, '%s','inventario.php?p=libros')\">",$row["CODIGO"]);
		}
		printf("<td>&nbsp;%s</td> ", strtoupper($row["CODIGO"]));
		printf("<td>&nbsp;%s</td> ", strtoupper($row["TITULO"]));
		printf("<td>&nbsp;%s</td> ", strtoupper($row["PROVEEDOR"]));
        printf("<td>&nbsp;%s</td> ", strtoupper($row["AUTOR"]));
		
     //  	printf("<td>&nbsp;%s</td> ", strtoupper(substr($row["ESTADO"],0,15).$pts));
    //	printf("<td>&nbsp;%s</td> ", strtoupper(substr($row["LOCALIDAD"],0,30).$pts));
switch($row["PRESENTACION"]){
   			case 'E':
      			printf("<td>&nbsp;EMPA</td> ");
      			break;
   			case 'R':
      			printf("<td>&nbsp;RUST</td> ");
     			break;
   			case 'U':
      			printf("<td>&nbsp;UNIC</td> ");
      			break;
			default:
      			printf("<td>&nbsp;</td> ");
      			break;
		}  
		printf("<td>&nbsp;%s</td> ", strtoupper(utf8_decode($row["TOMO"])));
			printf("<td>&nbsp;%s</td> ", strtoupper(utf8_decode($row["PRECIO"])));
			printf("<td>&nbsp;%s</td> ", strtoupper(utf8_decode($row["EXISTENCIA"])));
			

echo("</tr>");
		$cont++;	
	}
	if ($cont==0){
		echo ("
		<div align='center'> 		
		No se encontraron Datos
	</div>		
		");
	}
	mysql_free_result($result);
	mysql_close($link);
	echo ("
	</table>
	</form>
	
	");
}


?>







 
<script type="text/javascript">
<!--
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2");
//-->
</script>
