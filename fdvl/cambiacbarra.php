<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<div id="navegador">
	<p>
		<SPAN class='noimprimir'>
		<a href="#">Sistema de Inventario</a> | 
  <a href="#">Módulo de Operativo</a> | </SPAN>Modificar el Código de Barra de los Artículos</p>
</div>


<script type="text/javascript">
function upperCase(obj,e) {
if (e.keyCode==37 || e.keyCode==39)
return;
obj.value = obj.value.toUpperCase();
}


</script>

<form name="frmLibro" method="post" action="inventario.php?p=cambiacbarra">




<?php


//////////////////////////////////////////////// INICIANDO VARIABLES

$editorial = isset($_POST['editorial'])?$_POST['editorial']:'';


include("conexion.php");
include("includes/functions.php");



//////////////////////////////////////////////// INICIANDO VARIABLES
$cod_entrega = isset($_POST['cod_entrega'])?$_POST['cod_entrega']:'';
$cod_cliente = isset($_POST['cod_cliente'])?$_POST['cod_cliente']:'';
$cliente = isset($_POST['cliente'])?$_POST['cliente']:'';
$fecha = isset($_POST['fecha'])?$_POST['fecha']:'';
$direccion = isset($_POST['direccion'])?$_POST['direccion']:'';
$rif = isset($_POST['rif'])?$_POST['rif']:'';
$tlf = isset($_POST['tlf'])?$_POST['tlf']:'';
$contac = isset($_POST['contac'])?$_POST['contac']:'';
$obserCli = isset($_POST['obserCli'])?$_POST['obserCli']:'';
$vende = isset($_POST['vende'])?$_POST['vende']:'';
$trans = isset($_POST['trans'])?$_POST['trans']:'';
$pago = isset($_POST['pago'])?$_POST['pago']:'';
$recibido = isset($_POST['recibido'])?$_POST['recibido']:'';
$autorizado = isset($_POST['autorizado'])?$_POST['autorizado']:'';
$observ = isset($_POST['observ'])?$_POST['observ']:'';
$desc = isset($_POST['desc'])?$_POST['desc']:'0,0';
$moneda = isset($_POST['moneda'])?$_POST['moneda']:'';

$nota_entrega = isset($_POST['nota_entrega'])?$_POST['nota_entrega']:'';

$cant = isset($_POST['cant_n'])?$_POST['cant_n']:'';

$msg = $_GET["msg"]; 
$moneda = isset($_POST['moneda'])?$_POST['moneda']:'';
$articulo = isset($_POST['articulo'])?$_POST['articulo']:'';
$usuario=$_SESSION['Nusuario'];






if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 100000;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($link2, $link);


$Texto = $_GET ["Texto"]; 
$Titulo = $_GET ["Titulo"]; 


function cambiarFormatoFecha($fecha){ 
    list($anio,$mes,$dia)=explode("-",$fecha); 
    return $dia."/".$mes."/".$anio; 


}
if ($nota_entrega == "")
{



}

else
{

$resultFac = @mysql_query("
SELECT lib_codart,lib_descri,aut_nombre,prv_nombre
FROM inv_libros
JOIN inv_provee ON inv_libros.prv_codpro = inv_provee.prv_codpro
JOIN inv_autor ON inv_libros.aut_codigo = inv_autor.aut_codigo
WHERE inv_libros.lib_codart = '$nota_entrega' ",$link); 
$rowFac=mysql_fetch_array($resultFac); 

if (mysql_num_rows($resultFac) == 0) 
{
echo "<script>alert('LA INFORMACIÓN SUMINISTRADA ES INCORRECTA O NO EXISTE ');
document.location=('inventario.php?p=cambiacbarra');
</script>"; 

}


$query_Recordset1=
"
SELECT lib_codart,lib_descri,aut_nombre,prv_nombre,lib_codbarra
FROM inv_libros
JOIN inv_provee ON inv_libros.prv_codpro = inv_provee.prv_codpro
JOIN inv_autor ON inv_libros.aut_codigo = inv_autor.aut_codigo
WHERE inv_libros.lib_codart = '$nota_entrega'
";
$lib_descri = $row_Recordset1['lib_descri'];


///'NE2007080001'


$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $link) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

$res=mysql_query($query_Recordset1) or die("Query: $query_Recordset1 ".mysql_error());







if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
























}











//Limito la busqueda 
$TAMANO_PAGINA = 10000; 

//examino la página a mostrar y el inicio del registro a mostrar 
$pagina = $_GET["pagina"];

if ($editorial == "") $editorial = isset($_GET['editorial'])?$_GET['editorial']:'';

if (!$pagina) { 
    $inicio = 0; 
    $pagina=1; 
} 
else { 
    $inicio = ($pagina - 1) * $TAMANO_PAGINA; 
} 





?>
<SPAN class='noimprimir'>Búsqueda del Artículo</SPAN>
<div id="">
	
  <input name="enviar2" type="submit" id="enviar2" value="Modificar" onclick="return confirm('¿Desea Cambiar el Cod. de Barra de este Prod?');" />
  </input>
  
  </label>

<table width="100%" border="0">
  <tr>
    <td><table width="729">
    <tr>
      <td width="20%" class="TextFiel">Cod. Libro/CD/DVD:</td>
      <td width="15%"><span id="sprytextfield3">
        <input name="nota_entrega" type="text" onkeyup = "upperCase(this,event)"  class="inputCodigoP" id="nota_entrega" style="border-color:#BFDBFF;border-width:1px;border-style:solid;text-align:left "value="<?php echo ($nota_entrega); ?>" size="30" maxlength="12" />
        <span class="textfieldRequiredMsg"></span></span></td>
      <td width="60%" align="left"><input type="submit" name="enviar" id="enviar" value="Buscar"   />        <input type="reset" name="Limpiar" id="Limpiar" value="Limpiar" /></td>
    </tr>
    <tr>
      <td width="20%" class="TextFiel">Responsable:</td>
      <td colspan="2"><input name="usuario" type="text" id="usuario" value="<?php echo($usuario); ?>" size="38" readonly="readonly" />
         <input type="hidden" input name="pedido"  type="text" id="pedido"  value="<?php echo $row_Recordset1['ped_numped']; ?>" size="6" maxlength="6" align="center" text-align:="text-align:" "center"  div /></td>
    </tr>
  </table>
    
    
    </td>
  </tr>
</table>


<table width="100%" border="0">
  <tr>
    <td>
    
  <hr>





<?PHP
if ($nota_entrega == "")
{
	
	}

else
{
?>

  <span class="TituloTabla">Detalle del Pedido </span></td>
</table>


<table width="100%" border="0">
  <tr>
    <td>
    
 <div id='tabla'>
	<TABLE width="100%" border="1" CELLSPACING=0 id="tabDet" name="tabDet">
	
		<TR class='estilotitulo'>
		  <td width='10%' align="center">Cod. Articulo.</td>
		  <TD width='40%' align="center">Descripción</TD>
		  <TD width='15%' align="center">Autor</TD>
		  <TD width='20%' align="center">Editorial</TD>
		  <TD width='15%' align="center">Cod. Barra</TD>		
			</TR>

     <?php 



	  if ($nota_entrega == "")
{


}

else

{





	 
	 do { ?>
       <tr>
         <td class="Estilo3"><div align="center"><?php echo $row_Recordset1['lib_codart']; ?></div></td>
		    <td class="Estilo3"><div align="center"><?php echo $row_Recordset1['lib_descri']; ?></div></td>
		    <td class="Estilo3"><div align="center"><?php echo $row_Recordset1['aut_nombre']; ?></div></td>
		    <td class="Estilo3"><div align="center"><?php echo $row_Recordset1['prv_nombre']; ?></div></td>
       

		 
         <td class="Estilo60"><span id="sprytextfield2"><div align="center">
           <label>
		   
		   
		   <script>
function limpia(elemento)
{
elemento.value = "";
}
</script>
<script type="text/javascript">
function validar(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
	patron =/[A-Za-zñÑ\s/\w/]/; // 4
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
} 
</script>             
			 
			 
			 <input name="cant_n"  type="text" id="cant_n" onkeypress="return validar(event)" onclick="javascript: limpia(this);"  value="<?php echo $row_Recordset1['lib_codbarra']; ?>" size="20" maxlength="17" align="center" text-align: "center"  div />
             <br />
             </label>
           <span class="textfieldRequiredMsg"></span></span></td> 
           
         <?php } 
	
		
		 while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
		 
		 
		

		 }

		 
		 ?>


       </table>

    </td>
  </tr>
</table>

<tr><td width="35%"></td></tr>
	<tr>
		<td colspan="4" class="botones">


  
  



</div>

  
<?PHP
function guardar(){

$nota_entrega = isset($_POST['nota_entrega'])?$_POST['nota_entrega']:'';
$cant = isset($_POST['cant_n'])?$_POST['cant_n']:'';
$usuario=$_SESSION['Nusuario'];
$pedido = isset($_POST['pedido'])?$_POST['pedido']:'';

////////////////////////////////////////////////// valida si no existe o esta procesada 




$link2 = mysql_connect("localhost","inventa_bd","Valenta@04") or die (mysql_error());  
mysql_select_db("inventa_pglibreria",$link2);
$result2 = @mysql_query("
UPDATE  tbl_inventario
SET cod_barra = '$cant'
WHERE cod_producto = '$nota_entrega'
",$link2); 

$link3 = mysql_connect("localhost","inventa_bd","Valenta@04") or die (mysql_error());  
mysql_select_db("inventa_pglibreria",$link2);
$result2 = @mysql_query("
UPDATE  tbl_distinventario
SET cod_barra = '$cant'
WHERE cod_producto = '$nota_entrega'
",$link3); 



////////////////////////////////////////////// PARA GUARDAR REGISTRO DE LOS HECHOS ////////////////////////
$hora = date("H:i:s");  
$usuario=$_POST['usuario'];
$fecha = date("Y-m-d H:i:s"); 

if (!($linkFuera= @mysql_connect("distribuidoradellibro.gob.ve","inventa_bd","Valenta@04"))) 
/////if (!($link= @mysql_connect("localhost","inventa_bd","Valenta@04")))
{
echo "<script>alert('Por favor verifique la Conexion de Internet');location.href='index.php';</script>";
// Inicializa de la sesion
session_start();
// Destruye todas las variables de la sesion
session_unset();
// Finalmente, destruye la sesion
session_destroy();
exit();
}
if (! @mysql_select_db("inventa_fdvl",$linkFuera))
{
echo "Error seleccionando la base de datos.";
exit();
}
//$link=Conectarse();
//echo "Conexión con la base de datos conseguida.<br>";
//@mysql_close($link); //cierra la conexion


		  $sql_mov = "INSERT INTO inv_movimit (mov_fecha, mov_hora,mov_doc,mov_usuario, mov_tipo)
    VALUES  ('$fecha','$hora','$cant','$usuario', 'CAMBIO DE COD. DE BARRA')";
mysql_query($sql_mov, $linkFuera) or die(mysql_error($linkFuera));
mysql_close($linkFuera);




if (!($linkFuera= @mysql_connect("distribuidoradellibro.gob.ve","inventa_bd","Valenta@04"))) 
/////if (!($link= @mysql_connect("localhost","inventa_bd","Valenta@04")))
{
echo "<script>alert('Por favor verifique la Conexion de Internet');location.href='index.php';</script>";
// Inicializa de la sesion
session_start();
// Destruye todas las variables de la sesion
session_unset();
// Finalmente, destruye la sesion
session_destroy();
exit();
}
if (! @mysql_select_db("inventa_fdvl",$linkFuera))
{
echo "Error seleccionando la base de datos.";
exit();
}
//$link=Conectarse();
//echo "Conexión con la base de datos conseguida.<br>";
//@mysql_close($link); //cierra la conexion


$result = @mysql_query("
UPDATE  inv_libros
SET lib_codbarra = '$cant'
WHERE lib_codart = '$nota_entrega'


",$linkFuera); 


////////////////////////////////////////////// PARA GUARDAR REGISTRO DE LOS HECHOS ////////////////////////

echo "FUE MODIFICADO EL COD. DE BARRA $cant DEL ARTICULO Nº$nota_entrega, RECUERDE QUE NO ES NECESARIO ACTUALIZAR SU BASE DE DATOS DE LIBROS YA QUE EL SISTEMA REALIZO TODOS CAMBIOS.";

mysql_close($link2);
mysql_close($link3);
mysql_close($linkFuera);


/////////CIERRA LA FUNCION
}


if(isset($_POST['enviar2']))
{
guardar();
}//fin if post


/////////////////// DEL CAMPO VACIO 
	}
?>





<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {isRequired:false});
//-->
</script>
</form>
