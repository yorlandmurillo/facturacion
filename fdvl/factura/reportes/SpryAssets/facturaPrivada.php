<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<div id="navegador">
	<p>
		<SPAN class='noimprimir'>
		<a href="#">Sistema de Inventario</a> | 
		<a href="#">Módulo de Operativo</a> | </SPAN>Facturar Empresas Privadas
	</p>
</div>


<script type="text/javascript">
function upperCase(obj,e) {
if (e.keyCode==37 || e.keyCode==39)
return;
obj.value = obj.value.toUpperCase();
}
</script>


<?php

//////////////////////////////////////////////// INICIANDO VARIABLES

$editorial = isset($_POST['editorial'])?$_POST['editorial']:'';

$BD1 = "localhost";
$BD2 = "distri_fdvl";
$BD3 = "distri";
$BD4 = "DISTRI77dora";
$BD = mysql_pconnect($BD1, $BD3, $BD4) or trigger_error(mysql_error(),E_USER_ERROR);
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
$msg = $_GET["msg"]; 
$moneda = isset($_POST['moneda'])?$_POST['moneda']:'';






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
mysql_select_db($BD2, $BD);


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





$query_Recordset1=
"select NOT_CANTID, NOT_PRECIO, (NOT_CANTID * NOT_PRECIO) AS TOTAL, inv_notaed.NOT_NUMNOT, NOT_CODART, NOT_NUMPED, ven_nombre,clt_nombre, NOT_FCHNOT, clt_direc, clt_rif,clt_telef,NOT_CANTID,NOT_PRECIO,aut_nombre,lib_descri, trs_descrip,ped_observ,clt_codcli, ped_pordes, prv_nombre,not_user
FROM inv_notaed INNER JOIN inv_notaec
on inv_notaed.NOT_NUMNOT = inv_notaec.NOT_NUMNOT
JOIN inv_pedidc
on inv_notaec.NOT_NUMPED = inv_pedidc.ped_numped
JOIN inv_cliente
on inv_cliente.clt_codcli = inv_pedidc.ped_codcli
JOIN inv_vende
on inv_pedidc.ped_codven = inv_vende.ven_codven
JOIN inv_libros
on inv_libros.lib_codart = inv_notaed.NOT_CODART 
JOIN inv_autor
on inv_autor.aut_codigo = inv_libros.aut_codigo 
JOIN inv_provee
on inv_provee.prv_codpro = inv_libros.prv_codpro
JOIN inv_transac
on inv_transac.trs_codtrs = inv_pedidc.ped_codtrs
WHERE inv_notaed.NOT_NUMNOT ='$nota_entrega'
AND NOT_CANTID <> 0
ORDER BY inv_libros.lib_codart asc";

////'NE2007080001'


$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $BD) or die(mysql_error());
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
$TAMANO_PAGINA = 50; 

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
<SPAN class='noimprimir'>Busqueda de Nota de Entrega por Facturar</SPAN>

<div id="FormaModOperativo">
	<form name="frmLibro" method="post" action="inventario.php?p=facturaPrivada">
  
  </label>

<table width="100%" border="0">
  <tr>
    <td>
    
  <table width="729">
    <tr>
      <td width="89" class="TextFiel">N&ordm;. Entrega:</td>
      <td colspan="3" align="left"><span id="sprytextfield1">
        <input name="nota_entrega" type="text" onkeyup = "upperCase(this,event)"  class="inputCodigoP" id="nota_entrega" style="border-color:#BFDBFF;border-width:1px;border-style:solid;text-align:left "value="<?php echo $row_Recordset1['NOT_NUMNOT']; ?>" size="30" maxlength="12" />
        <span class="textfieldRequiredMsg">..?</span></span>
        <input type="submit" name="enviar" id="enviar" value="Buscar"   />
        <input type="reset" name="Limpiar" id="Limpiar" value="Limpiar" /></td>
      </tr>
    <tr>
      <?php
$NE= $row_Recordset1['NOT_NUMNOT'];

?>

	
     <td class="TextFiel">Moneda a Fact:</td>
      <td colspan="3"><span id="spryselect1">
        <label>
          <select name="moneda" id="moneda" >
            <option value="Bs">Bol&iacute;var (Venezuela)</option>
            <option value="$">D&oacute;lar (USA)</option>
            <option value="&euro;">Euro</option>
          </select>
        </label>

        <span class="selectRequiredMsg">Seleccione el Tipo de Moneda.</span></span></td>
    </tr>
    <tr>
 

      
  <?php
$NE= $row_Recordset1['NOT_NUMNOT'];

?>
      
      
      
      
      <td class="TextFiel">N&ordm;. Pedido:</td>
      <td colspan="3">
      <input name="cod_pedido" type="text" class="inputCodigo2" id="cod_pedido" value="<?php echo $row_Recordset1['NOT_NUMPED']; ?>" size="30" readonly="readonly">
      
      <input type="hidden" class="inputCodigo2" id="$usuarioN" value="<?php echo $row_Recordset1['not_user']; ?>" size="30" readonly="readonly">
      
      
      
      
        </td>
    </tr>
    <tr>
      <td class="TextFiel">Fondo:</td>
      <td colspan="3"><input name="fondo" type="text" class="inputCodigo2" id="fondo" value="<?php echo $row_Recordset1['prv_nombre']; ?>" size="60" readonly="readonly" /></td>
    </tr>
    <tr>
      <td class="TextFiel">Vendedor:</td>
      <td colspan="3"><input name="vendedor" type="text" class="inputCodigo2" id="vendedor" value="<?php echo $row_Recordset1['ven_nombre']; ?>" size="30" readonly="readonly" /></td>
    </tr>
    <tr>
    
      <td class="TextFiel">Cliente:</td>
      <td><input name="cliente" type="text" class="inputCodigo2" id="cliente" value="<?php echo $row_Recordset1['clt_codcli']; ?>  <?php echo $row_Recordset1['clt_nombre']; ?>" size="60" readonly="readonly"></td>
      <td width="91" align="right"><span class="TextFiel">Fecha:</span></td>
      <TD align="LEFT" width="189">
        
      <?php 
	
	if ($row_Recordset1['NOT_FCHNOT'] == "")

	{
	?>
    
    <input name="vende3" type="text" class="inputCodigo3" id="vende3" size="20" readonly="readonly">
    
	<?php
	
	}
	
	else
	{
		
		?>
    
    
    <input name="vende3" type="text" class="inputCodigo3" id="vende3" value="<?php echo cambiarFormatoFecha ($row_Recordset1['NOT_FCHNOT']); ?>" size="20" readonly="readonly">
    
	<?php
	
	}

		?>
         
        
        
        </td>
    </tr>
    <tr>
      <td valign="top" class="TextFiel">Direcci&oacute;n:</td>
      <td colspan="3"><textarea name="direccion" COLS="92" ROWS="3" readonly="readonly" class="inputCodigo2" id="direccion"><?php echo $row_Recordset1['clt_direc']; ?></textarea></td>
      </tr>
    <tr>
      <td valign="top" class="TextFiel">R.I.F.:</td>
      <td><input name="vende7" type="text" class="inputCodigo2" id="vende8" value="<?php echo $row_Recordset1['clt_rif']; ?>" size="30" readonly="readonly"></td>
      <td align="right"><span class="TextFiel">Tel&eacute;fono:</span></td>
      <td><input name="vende7" type="text" class="inputCodigo3" id="vende9" value="<?php echo $row_Recordset1['clt_telef']; ?>" size="20" readonly="readonly"></td>
    </tr>
    <tr>
      <td valign="top" class="TextFiel">Transacci&oacute;n:</td>
      <td colspan="3"><input name="transaccion" type="text" class="inputCodigo2" id="transaccion" value="<?php echo $row_Recordset1['trs_descrip']; ?>" size="30" readonly="readonly" /></td>
    </tr>
    <tr>
      <td valign="top" class="TextFiel">Contacto:</td>
      <td><input name="vende4" type="text" class="inputCodigo2" id="vende4" value="<?php echo $row_Recordset1['clt_nombre']; ?>" size="60" readonly="readonly"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td valign="top" class="TextFiel">Observaci&oacute;n:</td>
      <td colspan="3"><textarea name="direccion2" COLS="92" ROWS="3" readonly="readonly" class="inputCodigo2" id="direccion2"><?php echo $row_Recordset1['ped_observ']; ?></textarea></td>
    </tr>
  </table>
    
    
    </td>
  </tr>
</table>

<table width="100%" border="0">
  <tr>
    <td>
    
  <hr>
  <span class="TituloTabla">Detalle de Factura por Articulo (Libros)</span></td>
</table>


<table width="100%" border="0">
  <tr>
    <td>
    
 <div id='tabla'>
	<TABLE CELLSPACING=0 border="1" id="tabDet" name="tabDet">
	
		<TR class='estilotitulo'>
		  <TD width='10%' align="center">Cod. Art.</TD>
		  <TD width='70%' align="center">Titulo y Autor</TD>
		  <TD width='5%' align="center">Cant.</TD>		
			<TD width='10%' align="center">Precio</TD> 
			<TD width='10%' align="center">Importe</TD>
		</TR>

     <?php 
	 
	  if ($nota_entrega == "")
{


}

else

{


	 
	 do { ?>
       <tr>
         <td class="Estilo3"><div align="center"><?php echo $row_Recordset1['NOT_CODART']; ?></div></td>
         <td bgcolor="#FFFFFF" class="Estilo51" style='text-transform: uppercase;'><div align="justify"><?php echo $row_Recordset1['lib_descri']; ?>,  <?php echo $row_Recordset1['aut_nombre']; ?></div>
         
           
         <td class="Estilo60"><div align="center"><?php echo $row_Recordset1['NOT_CANTID']; ?></div></td> 
         <td class="Estilo60"><div align="center"><?php echo number_format($row_Recordset1['NOT_PRECIO'], 2, ',', '.'); ?></div></td> 

         <td class="Estilo60"><div align="center"><?php echo number_format($row_Recordset1['TOTAL'], 2, ',', '.'); ?></div></td> 

<?php 
$total = $total + $row_Recordset1['TOTAL'];
$descuento = $row_Recordset1['ped_pordes'];
$pagar = $total*$descuento/100;
$Cantidades = $Cantidades+$row_Recordset1['NOT_CANTID'];

$pagarFinal = $total-$pagar




?>         
         <?php } 
		 
		
		 while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
		 
		 
		

		 }

		 
		 ?>


</table>

    </td>
  </tr>
</table>

<Br>


<div id='estTabTotal'>
	<TABLE width="100%" id="tabTotal" name="tabTotal">
		<TR>
			<TD width='70%'></TD>
			<TD width="15%" align="left"><strong>Total</strong></TD>
			<TD width='15%' align="right"><?php echo number_format($total,2, ',', '.') ?> <?php echo $moneda  ?></TD>

          Total de Títulos  <?php echo $totalRows_Recordset1 ?>, Total Libros <?php echo $Cantidades  ?>.


        </TR>
		<TR>
			<TD></TD>
			<TD align="left"><strong>Descuento</strong></TD>
			<TD align="right"><input type='text' id="desc" name="desc" size='5' maxlength='5' value='<?php echo number_format($descuento,2, ',', '.') ?>' class='inputCodigo' readonly> %</TD>
		</TR>
		<TR>
			<TD></TD>
			<TD align="left"><strong>Total General</strong></TD>
			<TD align="right"><?php echo number_format($pagarFinal,2, ',', '.') ?> <?php echo $moneda  ?></TD>
		</TR>
		<TR>
		  <TD>
          </TD>
		   <hr class='noimprimir'>
        </TD>
	    </TR>
	</table>
</div>
<Br>
<hr class='noimprimir'>

<?php



?>


<?php print "<script> calcularPrecioTotal(8); </script>"; ?>
<div id="FormaModOperativo">
	<table>
	<tr>

	</tr>
	<tr><td colspan="4" class="mensajes" class='noimprimir'><?php echo($msg); ?></td></tr></td>
  
  <?php
  
   if ($nota_entrega == "")
{


}

else

{


   if (mysql_num_rows($res) == 0) 
{ 
echo "<script>alert('NO EXISTE LA NOTA DE ENTREGA EN EL SISTEMA.')</script>"; 
}


}

  ?>
  

</div>
        
        <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
        </script>
        
        
        <?php 
		mysql_close($BD);
		?>




<div id="FormaModOperativo">
	<table>
	<tr>
		<td width="15%">Observaciones:</td>
		<td width="50%" colspan="3"><textarea id="observ" name="observ" COLS="102" ROWS="2" maxlength="100"></textarea></td>
	</tr>
	<tr><td colspan="4" class="mensajes" class='noimprimir'><?php echo($msg); ?><td width="35%"></td></tr>
	<tr>
		<td colspan="4" class="botones">

  </form>
  
  

<script type="text/javascript">
function show_confirm()
{
var r=confirm("Desea Imprimir la Facturación.?");
if (r==true)
  {
 window.open('facturaPrivadaPDF.php?$nota_entrega=<?=$nota_entrega;?>','nuevaVentana','width=400, height=400');
  }
else
  {
  alert("Ha Cancelado la Operación!");
  }
}
</script>
<input name="enviar2" type="submit" id="enviar2" value="Guardar" onclick="return confirm('¿Desea generar una Factura?');">
</input>


<input type="button" value="Imprimir" onclick="show_confirm()" onclick="window.open('facturaPrivadaPDF.php?$nota_entrega=<?=$nota_entrega;?>','nuevaVentana','width=400, height=400')" />
</input>


            
			<INPUT TYPE="button" VALUE="Limpiar" onClick="limpiarPagina('inventario.php?p=facturaPrivada');" class='noimprimir'>
</input>


		</td>
	</tr>
	</table>
</div>

<?PHP
function guardar(){
$link = mysql_connect("localhost","root","5421836") or die (mysql_error());  
mysql_select_db("fdvl",$link);




$fecha = date("Y-m-d H:i:s"); 
$can_dias = 30; 
$fec_vencimiento= date("Y-m-d", strtotime("$fecha + $can_dias days")); 
$hora = date("H:i:s");  
$nota_entrega = $_POST['nota_entrega'];
$desc = $_POST['desc'];
$moneda = $_POST['moneda'];
$estatus = 'NI' ;
$cliente = $_POST['cliente'];
$fondo = $_POST['fondo'];
$vend = $_POST['vendedor'];
$trans = $_POST['transaccion']; 
$cod_pedido = $_POST['cod_pedido'];
$usuarioNE = $_POST['$usuarioN'];
$nota = $_POST['observ'];


////////////////////////////////////////////////// valida si no existe o esta procesada 

$result = @mysql_query("
select *
FROM inv_facturac INNER JOIN inv_cliente
on inv_facturac.fac_codcli = inv_cliente.clt_codcli
WHERE inv_facturac.fac_numnot ='$nota_entrega'
",$link); 

if (mysql_num_rows($result) == 0) 
{ 
////// VALIDA SI EXISTE YA EN BD

//////////$nota_entrega = isset($_POST['nota_entrega'])?$_POST['nota_entrega']:'';
$usuario=$_SESSION['login_usuario'];

$result = @mysql_query("
select NOT_CANTID, NOT_PRECIO, (NOT_CANTID * NOT_PRECIO) AS TOTAL, inv_notaed.NOT_NUMNOT, NOT_CODART, NOT_NUMPED, ven_nombre,clt_nombre, NOT_FCHNOT, clt_direc, clt_rif,clt_telef,NOT_CANTID,NOT_PRECIO,aut_nombre,lib_descri, trs_descrip,ped_observ,clt_codcli, ped_pordes, prv_nombre,  not_user
FROM inv_notaed INNER JOIN inv_notaec
on inv_notaed.NOT_NUMNOT = inv_notaec.NOT_NUMNOT
JOIN inv_pedidc
on inv_notaec.NOT_NUMPED = inv_pedidc.ped_numped
JOIN inv_cliente
on inv_cliente.clt_codcli = inv_pedidc.ped_codcli
JOIN inv_vende
on inv_pedidc.ped_codven = inv_vende.ven_codven
JOIN inv_libros
on inv_libros.lib_codart = inv_notaed.NOT_CODART 
JOIN inv_autor
on inv_autor.aut_codigo = inv_libros.aut_codigo 
JOIN inv_provee
on inv_provee.prv_codpro = inv_libros.prv_codpro
JOIN inv_transac
on inv_transac.trs_codtrs = inv_pedidc.ped_codtrs
WHERE inv_notaed.NOT_NUMNOT ='$nota_entrega'
AND NOT_CANTID <> 0
ORDER BY NOT_CANTID, inv_libros.col_colecc, inv_libros.lib_numedit, inv_libros.lib_present
",$link); 

$resultContador = @mysql_query("
select fac_numfact
FROM inv_facturac
ORDER BY fac_numfact DESC
",$link); 
$row2 = mysql_fetch_array($resultContador);
$codigoFact=$row2['fac_numfact'];
$codigoFact = $codigoFact+1;


//CONTADOR
$i = 0;
//MAX
$max = 21;



  
while($row = mysql_fetch_array($result))
{

//If the current row is the last one, create new page and print column title
    if ($i == $max)
    {
  $sql = "INSERT INTO inv_facturac (fac_fecha, fac_hora,fac_numnot,fac_usuario,fac_mtotal,fac_mtodcto,fac_mtontalg,fac_cantlib,fac_cantitulo,fac_moneda,fac_estatus,fac_fechav,fac_numped,fac_codcli,fac_fondo,fac_vendedor,fac_trans,fac_usuarioNE, observacion)
    VALUES
   ('$fecha','$hora','$nota_entrega','$usuario','$totalPagar','$descuento','$pagarFinal','$totalC','$i','$moneda','$estatus','$fec_vencimiento','$cod_pedido','$cliente','$fondo','$vend','$trans','$usuarioN','$nota')";
  mysql_query($sql, $link) or die(mysql_error($link));

$codigoFact = $codigoFact + 1;



$i = 0;
   	$totalC = 0;
		$totalPagar = 0;
$descuento = 0;
$pagar = 0;
$pagarFinal = 0;
    
  }


$usuarioN=$row['not_user'];
$codigoArt=$row['NOT_CODART'];
$codigoDesc=$row['lib_descri']; 
$codigoCant = number_format($row['NOT_CANTID'], 2, '.', ','); 
$codigoPrecio = number_format($row['NOT_PRECIO'], 2, '.', ','); 
$codigoTotal=$codigoCant*$codigoPrecio; 
   
  $sql = "INSERT INTO inv_facturad (fac_numfact, fac_numnot,fac_numped,fac_codcli,fac_codart,fac_descart,fac_cantid,fac_preciou,fac_preciot)
    VALUES
   ('$codigoFact','$nota_entrega','$cod_pedido','$cliente','$codigoArt','$codigoDesc','$codigoCant','$codigoPrecio','$codigoTotal')";
  mysql_query($sql, $link) or die(mysql_error($link));





$i = $i + 1;

$totalC = $totalC + $row['NOT_CANTID'];
$totalPagar = $totalPagar + $row['TOTAL'];
$descuento = $row['ped_pordes'];
$pagar = $totalPagar*$descuento/100;
$pagarFinal = $totalPagar-$pagar;
  

  
 


  //////////////// cierra el bucle
}

  $sql = "INSERT INTO inv_facturac (fac_fecha, fac_hora,fac_numnot,fac_usuario,fac_mtotal,fac_mtodcto,fac_mtontalg,fac_cantlib,fac_cantitulo,fac_moneda,fac_estatus,fac_fechav,fac_numped,fac_codcli,fac_fondo,fac_vendedor,fac_trans,fac_usuarioNE, observacion)
    VALUES
   ('$fecha','$hora','$nota_entrega','$usuario','$totalPagar','$descuento','$pagarFinal','$totalC','$i','$moneda','$estatus','$fec_vencimiento','$cod_pedido','$cliente','$fondo','$vend','$trans','$usuarioN','$nota')";
  mysql_query($sql, $link) or die(mysql_error($link));



echo "<script>alert('LOS DATOS FUERON GUARDADOS SATISFACTORIAMENTE, PUEDE IMPRIMIR!.')</script>"; 

////////////////////////////////////////////////// valida si no existe o esta procesada  TERMINA EL IF QUE VALIDA SI EXISTE O NO 
}
else
{ 
echo "<script>alert('YA ESTA NOTA DE ENTREGA FUE PROCESADA PARA FACTURAR!.')</script>"; 
}
////////////////////////////////////////////////// valida si no existe o esta procesada  TERMINA EL IF QUE VALIDA SI EXISTE O NO 


mysql_close($link);
/////////CIERRA LA FUNCION
}

if(isset($_POST['enviar2'])){
guardar();
}//fin if post


?>


</form>
<p>&nbsp;</p>












<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
</script>
