<script type="text/javascript" src="includes/calendar.js"></script>
<script type="text/javascript" src="lang/calendar-es.js"></script>
<script type="text/javascript" src="includes/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="includes/calendar-win2k-cold-2.css"/>
<link rel="STYLESHEET" type="text/css" href="includes/estilos.css" media='screen'>
<link rel="STYLESHEET" type="text/css" href="includes/estilos_imprimir.css" media="print">
<style type="text/css">
<!--
.Estilo10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #990000; }
.Estilo11 {color: #990000}
.Estilo12 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif;}
-->
</style>
<div id="navegador">
	<p><img src="../../imagenes/banner.png" alt="" width="760" height="148" /></p>
</div>
<script>
function imprimirPagina(){
	focus(); 
	print();
}
</script>

<html>
<head>
<?
//////////////////////////////////////////////// INICIANDO VARIABLES
include("conexion.php");
include("includes/functions.php");
include("grafico.php");
//////////////////////////////////////////////// INICIANDO VARIABLES

  function cambiarFormatoFecha($fecha){ 
    list($anio,$mes,$dia)=explode("-",$fecha); 
    return $dia."/".$mes."/".$anio; 
}
$arreglosuc=explode("-", $_POST["sucursal"]);
$id_suc=$arreglosuc[0];
$suc=$arreglosuc[1];

$Cantidades= 0;
$totalCantidadFINAL = 0;
$totalFINAL = 0; 
$total60FINAL = 0;
$fecha=$_POST["fecha"];
$fecha2=$_POST["fecha2"];

$sucursal=$id_suc;
$Fecha_num=$_POST["fecha"];
$Fecha_num2=$_POST["fecha2"];

if($id_suc==0)
{
	$condicion1="";
	$condicion2="";
}
else
{
	$condicion1="AND inv_cliente.clt_codcli = '$id_suc'";
	$condicion2="AND fdvl_operaciones.COD_CLIENTE = '$id_suc'";
}

/*
cambio de fecha 
*/
setlocale(LC_TIME, 'Spanish');

/*
setlocale(LC_TIME, 'es_ES');
setlocale(LC_TIME, 'es_MX');
*/
$fechaconsulta=strftime('%d %B %Y',strtotime($Fecha_num));
$fechaconsulta2=strftime('%d %B %Y',strtotime($Fecha_num2));

////$xxxx = isset($_POST['editorial'])?$_POST['editorial']:'';

   $variableF = "Bienes Culturales enviado por parte de la Distribuidora de la Cultura mediante una Nota de Entrega y Recibido por la Red de Librerias del Sur 
   mediante un Control Perceptivo(CP), desde el ( $fechaconsulta ) hasta ( $fechaconsulta2 )"; // Modifica $bar... 
?>
   <td class="Estilo3"><? echo  $variableF; ?></span></td>
  
<div id="">
 <div id="">
	
  
  </label>

    </td>
  </tr>
</table>

    </td>
  </tr>
</table>

<Br>

<hr class='noimprimir'>
<?
/////////////////////////////////// GRAFICO /////////////////////////////////////////////////////////////
$resultContador = @mysql_query("
select inv_cliente.clt_codcli AS CODIGO, inv_cliente.clt_nombre AS CLIENTE, inv_notaec.NOT_NUMNOT AS NOTA_ENTREGA,inv_notaec.not_estatus AS ESTATUS,  
inv_provee.prv_nombre AS EDITORIAL_ENVIADA ,inv_notaec.NOT_FCHNOT AS FECHA_ENVIO, fdvl_operaciones.REC_FCHNOT AS FECHA_RECIBIDO,  
SUM(inv_notaed.NOT_CANTID) AS CANT_ENVIADA, fdvl_operaciones.REC_RECEPCION
FROM inv_pedidc
INNER JOIN inv_notaec 
ON inv_pedidc.ped_numped = inv_notaec.NOT_NUMPED
JOIN inv_notaed ON inv_notaec.NOT_NUMNOT = inv_notaed.NOT_NUMNOT
JOIN inv_libros ON inv_notaed.NOT_CODART = inv_libros.lib_codart
JOIN inv_provee ON inv_libros.prv_codpro = inv_provee.prv_codpro
JOIN inv_cliente ON inv_pedidc.ped_codcli = inv_cliente.clt_codcli
LEFT JOIN fdvl_operaciones ON fdvl_operaciones.COD_CLIENTE = inv_pedidc.ped_codcli
AND inv_notaec.NOT_NUMNOT = fdvl_operaciones.REC_NUMNOT
WHERE ( inv_notaec.NOT_FCHNOT >= '$fecha'
AND inv_notaec.NOT_FCHNOT <= '$fecha2'  ".$condicion1."
)",$link);
$row2=mysql_fetch_array($resultContador); 
$cantidad=number_format($row2['CANT_ENVIADA'],0,',','.');

$resultContador2 = @mysql_query("
select sum(fdvl_operacionesd.REC_CANTID) AS CANT_RECIBIDA
FROM fdvl_operaciones
INNER JOIN fdvl_operacionesd 
ON fdvl_operaciones.REC_RECEPCION = fdvl_operacionesd.REC_RECEPCIOND
WHERE ( fdvl_operaciones.REC_FCHNOT >= '$fecha'
AND fdvl_operaciones.REC_FCHNOT <= '$fecha2'  ".$condicion2."
)",$link);

$row22=mysql_fetch_array($resultContador2); 
$cantidad2=number_format($row22['CANT_RECIBIDA'],0,',','.');


$graphstyle_nr = 1;

//Paramnetros del gráfico
$enviados = $cantidad;
$recibidos = $cantidad2;
$graph = new BAR_GRAPH("vBar");
$graph->values = "$enviados,$recibidos";
$graph->labels = "TITULOS ENVIADOS,TITULOS RECIBIDOS";
$graph->showValues = 1;
$graph->barWidth = 20;
$graph->barLength = 1.0;
$graph->labelSize = 12;
$graph->absValuesSize = 12;
$graph->percValuesSize = 12;
$graph->graphPadding = 10;
$graph->graphBGColor = "#ABCDEF";
$graph->graphBorder = "1px solid blue";
$graph->barColors = "#A0C0F0";
$graph->barBGColor = "#E0F0FF";
$graph->barBorder = "2px outset white";
$graph->labelColor = "#333333";
$graph->labelBGColor = "#C0E0FF";
$graph->labelBorder = "2px groove white";
$graph->absValuesColor = "#000000";
$graph->absValuesBGColor = "#FFFFFF";
$graph->absValuesBorder = "2px groove white";
echo $graph->create();

/////////////////////////////////// GRAFICO /////////////////////////////////////////////////////////////
$resultContador123 = @mysql_query("
select inv_cliente.clt_codcli AS CODIGO, inv_cliente.clt_nombre AS CLIENTE, inv_notaec.NOT_NUMNOT AS NOTA_ENTREGA,inv_notaec.not_estatus AS ESTATUS,  inv_provee.prv_nombre AS EDITORIAL_ENVIADA ,
inv_notaec.NOT_FCHNOT AS FECHA_ENVIO, fdvl_operaciones.REC_FCHNOT AS FECHA_RECIBIDO,  SUM(inv_notaed.NOT_CANTID) AS CANT_ENVIADA, fdvl_operaciones.REC_RECEPCION AS control_perceptivo
FROM inv_pedidc
INNER JOIN inv_notaec 
ON inv_pedidc.ped_numped = inv_notaec.NOT_NUMPED
JOIN inv_notaed ON inv_notaec.NOT_NUMNOT = inv_notaed.NOT_NUMNOT
JOIN inv_libros ON inv_notaed.NOT_CODART = inv_libros.lib_codart
JOIN inv_provee ON inv_libros.prv_codpro = inv_provee.prv_codpro
JOIN inv_cliente ON inv_pedidc.ped_codcli = inv_cliente.clt_codcli
LEFT JOIN fdvl_operaciones ON fdvl_operaciones.COD_CLIENTE = inv_pedidc.ped_codcli
AND inv_notaec.NOT_NUMNOT = fdvl_operaciones.REC_NUMNOT
WHERE ( inv_notaec.NOT_FCHNOT >= '$fecha'
AND inv_notaec.NOT_FCHNOT <= '$fecha2'  ".$condicion1."
)
GROUP BY inv_notaed.NOT_NUMNOT
ORDER BY inv_cliente.clt_nombre, inv_notaec.NOT_FCHNOT",$link);
?>

<style type="text/css">
<!--
.tipo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	color: #000009;
}
.tipo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	color: #0000FF;
}
-->
</style>

<table width="100%" border="0">
  <tr>
    <td>
</table>


<table width="100%" border="0">
  <tr>
    <td>
 <div id='tabla'>
	<TABLE width="100%" border="1" CELLSPACING=0 id="tabDet" name="tabDet">
		<TR class='estilotitulo'>
		  <TD width='30%'  style="background-color:#990000" align="left">LIBRERIA</TD>
		  <TD width='10%' style="background-color:#990000" align="center">NOTA DE ENTREGA</TD>		
		  <TD width='10%' style="background-color:#990000" align="center">FECHA NE</TD>		
		  <TD width='10%' style="background-color:#990000" align="center">ESTATUS</TD>		
		  <TD width='10%' style="background-color:#990000" align="center">CONTROL PERCEPTIVO</TD>		
		  <TD width='10%' style="background-color:#990000" align="center">RECIBIDA</TD>		
		  <TD width='40%' style="background-color:#990000" align="center">EDITORIAL</TD>		
		</TR>
   <?

 $totalcp = 0;
	 
 do 
 { 
	///$row123=mysql_fetch_array($resultContador123); 
	if ($row123['CLIENTE'] == '' )
	{
	}
	else
	{
	 ?>
		<tr>
		<td class="Estilo3"><div align="left"><? echo $row123['CLIENTE']; ?></div></td>
		<td class="Estilo3"><div align="center"><? echo $row123['NOTA_ENTREGA']; ?></div></td>
		<td class="Estilo3"><div align="center"><? echo cambiarFormatoFecha ($row123['FECHA_ENVIO']); ?></div></td>												  
		<?
		if ($row123['ESTATUS'] == 'P')
		{
		?>
			<td class="Estilo3"><div align="center"><? echo 'PROCESADA'; ?></div></td>

		<?
		}
		else
		{
		?>
			<td class="tipo1"><div align="center"><? echo 'ANULADA'; ?></div></td>
		 <?
		}
		
		if ($row123['control_perceptivo'] == '')
		{
			?>
			<td class="tipo1"><div align="center"><? echo 'NO ENTREGADA'; ?></div></td>
			<?
			$totalcp = $totalcp + 1;
		}
		else
		{
			?>
			<td class="tipo2"><div align="center"><? echo $row123['control_perceptivo']; ?></div></td>
			<?
			$totalNE = $totalNE + 1;
		 }

		if ($row123['FECHA_RECIBIDO'] == '')
		{
			?>
				<td class="tipo1"><div align="center"><? echo '-------'; ?></div></td>
			<?
		}
		else
		{
			?>
			<td class="tipo2"><div align="center"><? echo cambiarFormatoFecha ($row123['FECHA_RECIBIDO']); ?></div></td>
		 <?
		}
		 ?>        
			<td class="Estilo3"><div align="center"><? echo  substr($row123['EDITORIAL_ENVIADA'],0,40); ?></div></td>												
		<?  		 
	}	
}
 while ($row123= mysql_fetch_assoc($resultContador123)); 
	 /////termina el if } para cerrar los espacios vacios
	 ?>
               
    </table>
    </td>
  </tr>
</table>

<p><Br>
</p>
<table width="100%" border="0" bgcolor="#FFFFFF">
  <tr bgcolor="#FFFFFF">
    <td width="35%"><strong class="Estilo10">Notas de Entregas Pendientes por Entregar:</strong></td>
    <td width="50%"><div align="left" class="Estilo11"><span class="Estilo12"><? echo number_format($totalcp, 0, ',', '.'); ?></span></div></td>
  </tr>
  <tr>
    <td width="35%" class="Estilo10"><strong>Controles Perceptivos Realizados:</strong></td>
    <td><div align="left" class="Estilo11"><span class="Estilo12"><? echo number_format($totalNE, 0, ',', '.'); ?></span></div></td>
  </tr>
</table>
<p>
<?
mysql_close($link);
  ?>
  
</p>
<p><img src="images/icono-impresion.gif" alt="Imprimir" width="45" height="45" border=0 align="right" class='noimprimir' style="cursor:pointer" onClick="imprimirPagina();" />
      </td>
    </form>
      <script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {validateOn:["blur"]});
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var spryselect5 = new Spry.Widget.ValidationSelect("spryselect5");
var spryselect6 = new Spry.Widget.ValidationSelect("spryselect6");
//-->
    </script>
</body>
    </html>