<?php
	session_start();
	include("includes/conexion.php");
	
	$servidor  = $_SESSION['server_name'];
	$link=conectarse();


	$cod=$_GET['cod'];

	$cod_entrega=$_GET['cod_recep'];

    $pedido = $_GET["pedido"]; 
	$fecha=$_GET['fecha'];
	$recibo=$_GET['recibido'];
	$autorizado=$_GET['autorizado'];
	$observ=$_GET['observ'];

	$cod_libros=$_GET['cod_libro'];
	$precio_libros=$_GET['precio_libro'];
	$cant_libros=$_GET['cant_libro'];
	$cant_libros2=$_GET['cant_libro2'];
	
	$cod_cliente = '';
	$cliente = '';
	$direccion = '';
	$rif = '';
	$tlf = '';
	$trans = '';
	$contac = '';
	$desc = '';
	$vende = '';
	$obserCli = '';
	$pago = '';
	
	
	//echo ($precio_libros);
	$cod_libro = explode(',',$cod_libros);
	$precio_libro = explode('+',$precio_libros);
	$cant_libro = explode(',',$cant_libros);
	$cant_libro2 = explode(',',$cant_libros2);

	$strQry="	
	
	SELECT c.clt_codcli, c.clt_nombre, c.clt_direc, c.clt_rif, c.clt_telef, t.trs_descrip, c.clt_contac, p.ped_pordes, v.ven_nombre, p.ped_observ, cp.con_descri 
				FROM inv_pedidc p
				LEFT JOIN inv_cliente c ON p.ped_codcli = c.clt_codcli
				LEFT JOIN inv_transac t ON p.ped_codtrs = t.trs_codtrs
				LEFT JOIN inv_vende v ON p.ped_codven = v.ven_codven
				LEFT JOIN inv_condic cp ON p.con_codigo = cp.con_codigo
				WHERE p.ped_numped = '". $pedido."'";
				
				
	$result=mysql_query($strQry);
	if($row = mysql_fetch_array($result)){
		$cod_cliente = $row[0];
		$cliente = utf8_decode($row[1]);
		$direccion = utf8_decode($row[2]);
		$rif = $row[3];
		$tlf = $row[4];
		$trans = utf8_decode($row[5]);
		$contac = utf8_decode($row[6]);
		$desc = number_format($row[7],2,',','.');
		$vende = utf8_decode($row[8]);
		$obserCli = utf8_decode($row[9]);
		$pago = utf8_decode($row[10]);
	}
	mysql_free_result($result);
	
	
	
	header("Content-Type: application/vnd.ms-excel ");
	header("Content-Disposition: attachment; filename=".$cod_entrega.".xls");
?> 

<table border=0>
	<tr height='60'>
		<td><img src="images/cabecera.jpg" width='760' height='75'></td>
	</tr>
	<tr height='100'>
		<td><img src="images/logolateral.jpg" width='175' height='115'></td>
		<TD></TD><TD></TD><TD></TD><TD></TD><TD></TD>
		<td><img src="images/filven6.jpg" width='152' height='133'></td>
	</tr>
	<tr><TD></TD></tr>
	<tr><TD>Nº. Entrega:</TD><TD><strong><?php echo $cod_entrega; ?></strong></TD>
		<TD>Fecha: <strong><?php echo $fecha; ?></strong></TD></tr>
	<tr><TD>Nº. Pedido:</TD><TD colspan="4"><strong><?php echo $pedido; ?></strong></TD></tr>
	<tr><TD>Vendedor:</TD><TD colspan="4"><strong><?php echo $vende; ?></strong></TD></tr>
	<tr><TD>Cliente:</TD><TD colspan="7"><strong><?php echo $cod_cliente.' - '.$cliente; ?></strong></TD></tr>
	<tr><TD>Dirección:</TD><TD colspan="7"><strong><?php echo $direccion; ?></strong></TD></tr>
	<tr><TD>R.I.F.:</TD><TD><strong><?php echo $rif; ?></strong></TD>
		<TD colspan="6">Telefono: <strong><?php echo $tlf; ?></strong></TD></tr>
	<tr><TD>Contacto:</TD><TD><strong><?php echo $contac; ?></strong></TD>
		<TD colspan="6">Transacción: <strong><?php echo $trans; ?></strong></TD></tr>
	<tr><TD colspan="3">Forma de Pago: <strong><?php echo $pago; ?></strong></TD></tr>
	<tr><TD></TD></tr>
	<tr><TD>Observaciones:</TD><TD colspan="7"><strong><?php echo $obserCli; ?></strong></TD></tr>
	<tr><TD></TD></tr>
	<tr bgcolor="#eeeeee">
    	<TD align='center' width='100'><strong><font size="2" color="#990000">Cod. Articulo</font></strong></TD> 
		<TD width='150'><strong><font size="2" color="#990000">Titulo</font></strong></TD> 
		<TD width='150'><strong><font size="2" color="#990000">Autor</font></strong></TD> 
		<TD align='center' width='55'><strong><font size="2" color="#990000">Num Tomo</font></strong></TD> 		
		<TD align='center' width='15'><strong><font size="2" color="#990000">P</font></strong></TD> 
		<TD align='center' width='60'><strong><font size="2" color="#990000">Precio Unitario</font></strong></TD> 
		<TD align='center' width='35'><strong><font size="2" color="#990000">Cant Ped</font></strong></TD> 
		<TD align='center' width='35'><strong><font size="2" color="#990000">Cant Entr</font></strong></TD> 
		<TD align='center' width='70'><strong><font size="2" color="#990000">Precio Exten.</font></strong></TD> 
	</tr>
	
	<?php
	
	
	
	
	
	
	
	
	
	
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



$Texto = $_GET ["Texto"]; 
$Titulo = $_GET ["Titulo"]; 


function cambiarFormatoFecha($fecha){ 
    list($anio,$mes,$dia)=explode("-",$fecha); 
    return $dia."-".$mes."-".$anio; 
}


$query_Recordset1=
"

SELECT p.ped_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, 
								p.ped_precio, p.ped_cantid, (p.ped_precio * nd.not_cantid) AS TOTAL,  nd.not_cantid
								FROM inv_notaec nc
						LEFT JOIN inv_pedidd p ON p.ped_numped = nc.not_numped
						LEFT JOIN inv_notaed nd ON nd.not_numnot = nc.not_numnot
						LEFT JOIN inv_libros l ON p.ped_codart = l.lib_codart
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
						WHERE nd.not_codart = p.ped_codart
						AND nc.not_numnot = '$cod'




";

////'NE2007080001'


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



$n=16;
	$cod_libro = 16;
	$x = 0;
	      do { 
    echo "<tr>";
		echo "<TD align='LEFT'><font size='2' FACE='Consolas,Calibri,Tahoma,Arial Narrow'># ".$row_Recordset1['ped_codart']."</font></TD> ";
        echo "<TD><font size='2' FACE='Consolas,Calibri,Tahoma,Arial Narrow'>".(isset($row_Recordset1['lib_descri'])?utf8_decode($row_Recordset1['lib_descri']):' - ')."</font></TD> ";
        echo "<TD><font size='2'>".(isset($row_Recordset1['aut_nombre'])?utf8_decode($row_Recordset1['aut_nombre']):' - ')."</font></TD> ";
        echo "<TD align='center'><font size='2' FACE='Consolas,Calibri,Tahoma,Arial Narrow'>".(isset($row_Recordset1['lib_numedit'])?utf8_decode($row_Recordset1['lib_numedit']):' - ')."</font></TD> ";
        echo "<TD align='center'><font size='2' FACE='Consolas,Calibri,Tahoma,Arial Narrow'>".(isset($row_Recordset1['lib_present'])?utf8_decode($row_Recordset1['lib_present']):' - ')."</font></TD> ";
        echo "<TD align='center'><font size='2' FACE='Consolas,Calibri,Tahoma,Arial Narrow'>".(isset($row_Recordset1['ped_precio'])?utf8_decode($row_Recordset1['ped_precio']):' - ')."</font></TD> ";
        echo "<TD align='center'><font size='2' FACE='Consolas,Calibri,Tahoma,Arial Narrow'>".(isset($row_Recordset1['ped_cantid'])?utf8_decode($row_Recordset1['ped_cantid']):' - ')."</font></TD> ";
        echo "<TD align='center'><font size='2' FACE='Consolas,Calibri,Tahoma,Arial Narrow'>".(isset($row_Recordset1['not_cantid'])?utf8_decode($row_Recordset1['not_cantid']):' - ')."</font></TD> ";
		echo "<TD align='center'><font size='2' FACE='Consolas,Calibri,Tahoma,Arial Narrow'>".$row_Recordset1['TOTAL']."</font></TD> ";

$total = $total + $row_Recordset1['TOTAL'];
$x++;








?>         
         <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
<?php 

$m=$n+$x ;

$pagar = $total*$desc/100;
$pagarFinal = $total-$pagar;


?>

	<tr><TD></TD></tr>
	<tr><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD>Total:</TD><TD align='center'><strong><?php echo ("=SUMA(G".$n.":G".$m.")"); ?></strong></TD>
																	<TD align='center'><strong><?php echo ("=SUMA(H".$n.":H".$m.")"); ?></strong></TD>
																	<TD align='center'><strong><?php echo number_format($total, 2, ',', '.'); ?></strong></TD></tr>
	<tr><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD>% Desc:</TD><TD></TD><TD></TD><TD align='center'><strong><?php echo number_format($desc, 2, ',', '.'); ?></strong></TD></tr>
	<tr><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD>Total General:</TD><TD></TD><TD></TD><TD align='center'><strong><?php echo number_format($pagarFinal, 2, ',', '.'); ?></strong></TD></tr>
	<tr><TD></TD></tr>
	<tr><TD>Recibido:</TD><TD align='left' colspan='2'><font size='2' FACE='Consolas,Calibri,Tahoma,Arial Narrow'><strong><?php echo $recibo; ?></strong></TD>
		<TD align='left' colspan='5'><font size='2' FACE='Consolas,Calibri,Tahoma,Arial Narrow'>Autorizado: <strong><?php echo $autorizado; ?></strong></TD></tr>
	<tr><TD align='left' colspan='8'><font size='2' FACE='Consolas,Calibri,Tahoma,Arial Narrow'>Observaciones: <strong><?php echo $observ; ?></strong></TD></tr>
	</table>

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	