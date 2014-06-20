<?PHP
  ini_set('session.bug_compat_warn',0);   
  session_start();
  include("includes/sesiones.php");
  $_SESSION['server_name'] = 'http://inventario.distribuidoradellibro.gob.ve/inventario/inventario.php';
?>

<html>
	<head>
		<title>Sistema de Inventario</title>
		<script src="includes/validation.js" type="text/javascript"></script>
		<script type="text/javascript" src="includes/calendar.js"></script>
		<script type="text/javascript" src="lang/calendar-es.js"></script>
		<script type="text/javascript" src="includes/calendar-setup.js"></script>
		
		<link rel="stylesheet" type="text/css" media="all" href="includes/calendar-win2k-cold-2.css"/>
		<link rel="STYLESHEET" type="text/css" href="includes/estilos.css" media='screen'>
		<link rel="STYLESHEET" type="text/css" href="includes/estilos_imprimir.css" media="print">
	</head>
	<body>
	<div id="noMostrar" align="left">
	<table>
		<tr align="top">
			<td><img src="images/logolateral.jpg" border=0 width="100"></td>
		  <td><img src="imagenes/cabeceramia.jpg" border=0 width="550"></td>
	  </tr>
	</table>
	</div>
	<div id="borde">
    <link rel="SHORTCUT ICON" href="images/bandera.ico">
	<div id="contenedor">
		 <div id="cabecera">
			<h1><span>Gobierno Bolivariano de Venezuela</span></h1>
		 </div>
		 <div id="logomenu">
         <?php if($conectado){?>	 
		     <div id="logolateral">
			     <h1><span>Ministerio del Poder popular para la Cultura</span></h1>
		     </div>
		     <?php include("includes/menu.htm") ?>
	  </div>
		 <div id="cuerpo">






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
					<a href="#"></a> SISTEMA DE INVENTARIO | PEDIDO | <? echo "$usuario"; ?>
		<a href="#"></a></SPAN>
	</p>
</div>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<div id="navegador">
	
    
</div>
<script type="text/javascript">
function upperCase(obj,e) {
if (e.keyCode==37 || e.keyCode==39)
return;
obj.value = obj.value.toUpperCase();
}
</script>

<form name="frmReimpresion" method="post">

<table>
<tr>
			
  
  </td>
   	</tr>
</table>


<?php
function Conectarse()
{
if (!($link= @mysql_connect("localhost","inventa_fdvl","fdvl@master2012")))
{
echo "Error conectando a la base de datos.";
exit();
}
if (! @mysql_select_db("inventa_fdvl",$link))
{
echo "Error seleccionando la base de datos.";
exit();
}
mysql_query ("SET NAMES 'utf8'"); 


return $link;
}
//$link=Conectarse();
//echo "Conexión con la base de datos conseguida.<br>";
//@mysql_close($link); //cierra la conexion

?>



</SPAN>
<?php
include("includes/functions.php");

//////////////////////////////////////////////// INICIANDO VARIABLES
$codigo = isset($_POST['codigo'])?$_POST['codigo']:'';
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
$tipo = "";

$codigo = $_GET['codigo'];




if ($codigo != ""){



//echo substr($codigo,0,2);
	$tipo=substr($codigo,0,2);
	
	$link=Conectarse();
	
	if($tipo=='NE'){ 
		$cod_recep=$codigo;
		$strQry="	SELECT 	n.not_numped, c.clt_codcli, c.clt_nombre, c.clt_direc, c.clt_rif, c.clt_telef, 
							t.trs_descrip, c.clt_contac, p.ped_pordes, v.ven_nombre, p.ped_observ, cp.con_descri,
							n.not_fchnot, n.not_observ, n.not_recibo, n.not_entreg, n.not_estatus,not_user,NOT_FCHNOT,ped_user,ped_fchped,n.NOT_CAJAS,n.NOT_PAQUETES
					FROM inv_notaec n
					LEFT JOIN inv_pedidc p ON n.not_numped = p.ped_numped
					LEFT JOIN inv_cliente c ON p.ped_codcli = c.clt_codcli
					LEFT JOIN inv_transac t ON p.ped_codtrs = t.trs_codtrs
					LEFT JOIN inv_vende v ON p.ped_codven = v.ven_codven
					LEFT JOIN inv_condic cp ON p.con_codigo = cp.con_codigo
					WHERE n.not_numnot = '". $codigo."'";
		//echo $strQry;
		$result=mysql_query($strQry,$link);
		if($row = mysql_fetch_array($result)){
			$pedido = $row[0];
			$cod_cliente = $row[1];
			$cliente = utf8_decode($row[2]);
			$direccion = utf8_decode($row[3]);
			$rif = $row[4];
			$tlf = $row[5];
			$trans = utf8_decode($row[6]);
			$contac = utf8_decode($row[7]);
			$desc = number_format($row[8],2,',','.');
			$vende = utf8_decode($row[9]);
			$obserCli = utf8_decode($row[10]);
			$pago = utf8_decode($row[11]);
			$fecha = $row[12];
			$observ = utf8_decode($row[13]);
			$recibido = utf8_decode($row[14]);
			$autorizado = utf8_decode($row[15]);
						$estatusNE = utf8_decode($row[16]);
						$userNE=$row["not_user"];
						$fechaNE=$row["NOT_FCHNOT"];
						$userPE=$row["ped_user"];
						$fechaPE=$row["ped_fchped"];
						$cajas=$row["NOT_CAJAS"];
						$paquetes=$row["NOT_PAQUETES"];
						

		}
	}elseif($tipo=='PE'){
		$pedido=$codigo;
		
		$resultFac = @mysql_query("
select *
FROM inv_notaec 
WHERE NOT_NUMPED = '". $codigo."'
",$link); 
$rowFac=mysql_fetch_array($resultFac); 
$nota_de_entrega=$rowFac["NOT_NUMNOT"];


$userNE=$rowFac["not_user"];
						$fechaNE=$rowFac["NOT_FCHNOT"];

		
		
		$strQry="	SELECT c.clt_codcli, c.clt_nombre, c.clt_direc, c.clt_rif, c.clt_telef, t.trs_descrip, 
					c.clt_contac, p.ped_pordes, v.ven_nombre, p.ped_observ, cp.con_descri, p.ped_fchped, ped_estatus,ped_user,ped_fchped
				FROM inv_pedidc p
				LEFT JOIN inv_cliente c ON p.ped_codcli = c.clt_codcli
				LEFT JOIN inv_transac t ON p.ped_codtrs = t.trs_codtrs
				LEFT JOIN inv_vende v ON p.ped_codven = v.ven_codven
				LEFT JOIN inv_condic cp ON p.con_codigo = cp.con_codigo
				WHERE p.ped_numped = '". $codigo."'";
		//echo $strQry;
		$result=mysql_query($strQry,$link);
		if($row = mysql_fetch_array($result)){
			$cod_cliente = $row[0];
			$cliente = utf8_decode($row[1]);
			$direccion = utf8_decode($row[2]);
			$rif = $row[3];
			$tlf = $row[4];
			$trans = utf8_decode($row[5]);
			$contac = utf8_decode($row[6]);
			$desc = number_format($row[7],2,',','.');
			$recibido = utf8_decode($row[8]);
			$observ = utf8_decode($row[9]);
			$pago = utf8_decode($row[10]);
			$fecha = $row[11];
				$estatus2 = utf8_decode($row[16]);
			$userPE=$row["ped_user"];
						$fechaPE=$row["ped_fchped"];
			
									$estatus2 = utf8_decode($row[12]);
		}
	}elseif($tipo=='OC'){
		$pedido=$codigo;
		$strQry="	SELECT p.prv_codpro, p.prv_nombre, p.prv_direc, p.prv_rif, p.prv_telef, t.trs_descrip, 
					p.prv_contac, c.ord_pordes, ord_solici, c.ord_observ, cp.con_descri, c.ord_fchord, c.ord_acepta,c.ord_estatus 
				FROM inv_ordenc c, inv_provee p, inv_transac t, inv_condic cp 
				WHERE c.ord_codprov = p.prv_codpro
				AND c.ord_codtrs = t.trs_codtrs
				AND c.con_codigo = cp.con_codigo
				AND c.ord_numord = '". $codigo."'";
		//echo $strQry;
		$result=mysql_query($strQry,$link);
		if($row = mysql_fetch_array($result)){
			
			$cod_cliente = $row[0];
			$cliente = utf8_decode($row[1]);
			$direccion = utf8_decode($row[2]);
			$rif = $row[3];
			$tlf = $row[4];
			$trans = utf8_decode($row[5]);
			$contac = utf8_decode($row[6]);
			$desc = number_format($row[7],2,',','.');
			$recibido = utf8_decode($row[8]);
			$observ = utf8_decode($row[9]);
			$pago = utf8_decode($row[10]);
			$fecha = $row[11];
			$autorizado = utf8_decode($row[12]);
			$ord_estatus = utf8_decode($row[13]);
		
			$resultif = @mysql_query("
select inf_numinf,inf_numord
FROM inv_inforc
WHERE inf_numord = '". $codigo."'
",$link); 
$rowif=mysql_fetch_array($resultif); 
$ocompra=$rowif["inf_numinf"];


		}
		}elseif($tipo=='CP'){
		
		$resultFac = @mysql_query("
select *
FROM fdvl_operaciones
WHERE REC_RECEPCION = '". $codigo."'
",$link); 
$rowFac=mysql_fetch_array($resultFac); 
$nota_de_entrega=$rowFac["REC_NUMNOT"];
$control_pe=$rowFac["REC_RECEPCION"];

		$strQry="	SELECT 	n.not_numped, c.clt_codcli, c.clt_nombre, c.clt_direc, c.clt_rif, c.clt_telef, 
							t.trs_descrip, c.clt_contac, p.ped_pordes, v.ven_nombre, p.ped_observ, cp.con_descri,
							n.not_fchnot, n.not_observ, n.not_recibo, n.not_entreg, n.not_estatus
					FROM inv_notaec n
					LEFT JOIN inv_pedidc p ON n.not_numped = p.ped_numped
					LEFT JOIN inv_cliente c ON p.ped_codcli = c.clt_codcli
					LEFT JOIN inv_transac t ON p.ped_codtrs = t.trs_codtrs
					LEFT JOIN inv_vende v ON p.ped_codven = v.ven_codven
					LEFT JOIN inv_condic cp ON p.con_codigo = cp.con_codigo
					LEFT JOIN fdvl_operaciones op ON op.REC_NUMNOT = n.NOT_NUMNOT
					WHERE op.REC_RECEPCION = '". $codigo."'";
		//echo $strQry;
		$result=mysql_query($strQry,$link);
		if($row = mysql_fetch_array($result)){
			
			$pedido = $row[0];
			$cod_cliente = $row[1];
			$cliente = utf8_decode($row[2]);
			$direccion = utf8_decode($row[3]);
			$rif = $row[4];
			$tlf = $row[5];
			$trans = utf8_decode($row[6]);
			$contac = utf8_decode($row[7]);
			$desc = number_format($row[8],2,',','.');
			$vende = utf8_decode($row[9]);
			$obserCli = utf8_decode($row[10]);
			$pago = utf8_decode($row[11]);
			$fecha = $row[12];
			$observ = utf8_decode($row[13]);
			$recibido = utf8_decode($row[14]);
			$autorizado = utf8_decode($row[15]);
						$estatus = utf8_decode($row[16]);
		}
	}elseif($tipo=='IR'){
		$cod_recep=$codigo;
		$strQry="	SELECT 	i.inf_numord, p.prv_codpro, p.prv_nombre, p.prv_direc, p.prv_rif, p.prv_telef, 
							t.trs_descrip, p.prv_contac, o.ord_pordes, o.ord_observ, cp.con_descri,
							i.inf_fchrec, i.inf_observ, i.inf_recibo, i.inf_entreg,o.ord_estatus
					FROM inv_inforc i
					LEFT JOIN inv_ordenc o ON i.inf_numord = o.ord_numord
					LEFT JOIN inv_provee p ON o.ord_codprov = p.prv_codpro
					LEFT JOIN inv_transac t ON o.ord_codtrs = t.trs_codtrs
					LEFT JOIN inv_condic cp ON o.con_codigo = cp.con_codigo
					WHERE i.inf_numinf = '". $codigo."'";
		
		//echo $strQry;
		$result=mysql_query($strQry,$link);
		if($row = mysql_fetch_array($result)){
			
			$pedido = $row[0];
			$cod_cliente = $row[1];
			$cliente = utf8_decode($row[2]);
			$direccion = utf8_decode($row[3]);
			$rif = $row[4];
			$tlf = $row[5];
			$trans = utf8_decode($row[6]);
			$contac = utf8_decode($row[7]);
			$desc = number_format($row[8],2,',','.');
			$obserCli = utf8_decode($row[9]);
			$pago = utf8_decode($row[10]);
			$fecha = $row[11];
			$observ = utf8_decode($row[12]);
			$recibido = utf8_decode($row[13]);
			$autorizado = utf8_decode($row[14]);
			$oestatus = utf8_decode($row[15]);
		}
	}
	mysql_free_result($result);
	mysql_close($link);
	
	$msg="";
?>

<div id="FormaModOperativo">
	<table>
  		<tr class='noimprimir'>
    		<td width="15%"></td>
			<td width="30%"></td>
   			<td width="10%"></td>
			<td width="24%"></td>
   			<td width="6%"></td>
			<td width="15%"></td>
		</tr>
		<?php if(($tipo=='NE')||($tipo=='IR')){ ?>
		<tr>
			<?php if($tipo=='NE'){ ?>
    		<td>Nº. Entrega:</td>
			<?php }elseif($tipo=='IR'){ ?>
			<td>Nº. Recepción:</td>
			<?php } ?>

		<script language="JavaScript">
function volver()
{
    window.location.href = "inventario.php?p=nota_entrega";
}
</script>


		  <td colspan="5"><input name="cod_recep" type="text" class="inputCodigo" id="cod_recep" value="<?php echo($cod_recep); ?>" size="30" readonly="readonly">
	      <input type="button" onClick="volver()" value="Volver" name="button" /></td>
		</tr>



  <?php } ?>
  		<tr>
			<?php if(($tipo=='NE')||($tipo=='PE')){ ?>
      <td>Nº. Pedido:</td>
	  <td colspan="5"><input name="pedido" type="text" class="inputCodigo" id="pedido" value="<?php echo($pedido); ?>" size="30" readonly="readonly"> 
			<?php }elseif(($tipo=='IR')||($tipo=='OC')){ ?>
			<td>Nº. Compra:</td>
			<td colspan="5"><input name="pedido" type="text" class="inputCodigo" id="pedido" value="<?php echo($pedido); ?>" size="30" readonly="readonly"> 
			<?php } ?>

			<?php if($tipo=='CP'){ ?>
      <td>Nº. CP:</td>
	  <td colspan="5"><input name="pedido" type="text" class="inputCodigo" id="pedido" value="<?php echo($control_pe); ?>" size="30" readonly="readonly"> 
			<?php } ?>

			
			 
		     
             
             <?php

	  if ($estatus == 'P')
{
$estatus = 'NOTA DE ENTREGA PROCESADA'; 
}



if ($nota_de_entrega == "")
{
	
	  if ($estatus == 'P')
{
$estatus = 'NOTA DE ENTREGA PROCESADA'; 
}
   if ($estatus == 'A')
{
	$estatus = 'NOTA DE ENTREGA   ***** A N U L A D A *****   '; 
}
	
	
	if ($estatus2 == 'P')
{
$estatus = 'PENDIENTE POR NOTA DE ENTREGA'; 
}

if ($estatus2 == 'A')
{
$estatus = 'PEDIDO   ***** A N U L A D O *****   '; 
}

if ($estatus2 == 'S')
{
$estatus = 'EN PROCESO DE REVISION '; 
}



if ($ord_estatus == 'P')
{
$estatus = 'ORDEN DE COMPRA PENDIENTE'; 
}

if ($ord_estatus == 'R')
{
$estatus = $ocompra;
}



if ($ord_estatus == 'A')
{
$estatus = 'ANULADA'; 
}
///$estatus = $ocompra;



if ($oestatus  == 'R')
{
$estatus = 'RECIBIDO CONFORME'; 
}

if ($estatus2  == 'P')
{
$estatus = 'PEDIDO PENDIENTE'; 
}
if ($estatus2  == 'E')
{
$estatus = 'PEDIDO DESCARGADO'; 
}

if ($estatus2  == 'A')
{
$estatus = 'PEDIDO ANULADO'; 
}

if ($estatusNE  == 'P')
{
$estatus = 'PEDIDO DESCARGADO'; 
}

if ($estatusNE  == 'A')
{
$estatus = 'NOTA DE ENTREGA ANULADA'; 
}

	  if ($dev_status == 'P')
{
$estatus = 'PENDIENTE POR EL ALMACEN DE LA FDVC'; 
}
	  if ($dev_status == 'R')
{
$estatus = "RECIBIDA POR ALMACEN No. $nota_credito" ; 
}

	?>



<!-- 
colocar texto parpadeante

<span style="text-decoration:blink"><?php echo($estatus); ?></span>


-->

<tr>
    		<td>Estatus:</td>
			<td colspan="5"><input name="vende" type="text" class="TextFielBold" id="vende" value="<?php echo($estatus); ?>" size="50" readonly="readonly"></td>
		</tr>
		<?PHP
	}
else
{
	
	
if ($estatus2 == 'E')
{
	$estatus = 'PEDIDO DESCARGADO' ;
	
}



if ($estatus2 == 'A')
{
$estatus = 'PEDIDO   ***** A N U L A D O *****   '; 
}

?>
             N&ordm;. Entrega:
<input name="pedido2" type="text" class="inputCodigo" id="pedido2" value="<?php echo($nota_de_entrega); ?>" size="30" readonly="readonly" /></td>
		</tr>
        
        
        <tr>
    		<td>Estatus:</td>
			<td colspan="5"><input name="vende" type="text" class="TextFielBold" id="vende" value="<?php echo($estatus); ?>" size="50" readonly="readonly"></td>
		</tr>
<?php

}
?>



  <?php if($tipo=='CP')
  

  
  
  { 
  
  
  
  



  
  
  ?>
		
        <td>Vendedor:</td>
			<td colspan="5"><input name="vende" type="text" font style="text-transform: uppercase" class="inputCodigo" id="vende" value="<?php echo($vende); ?>" size="30" readonly="readonly"></td>
		</tr>
		<?php } ?>
		<tr>

  <?php if($tipo=='NE')
  

  
  
  { 
  
  
  
  



  
  
  ?>
		
        <td>Vendedor:</td>
			<td colspan="5"><input name="vende" type="text" font style="text-transform: uppercase" class="inputCodigo" id="vende" value="<?php echo($vende); ?>" size="30" readonly="readonly"></td>
		</tr>
		<?php } ?>
			<?php if(($tipo=='IR')||($tipo=='OC')){ ?>
    		<td>Editorial:</td>
			<?php }else{ ?>
			<td>Cliente:</td>
			<?php } ?>
			<td colspan="3"><input name="cod_cliente" font style="text-transform: uppercase" type="text" class="inputCodigo" id="cod_cliente" value="<?php echo($cod_cliente.' '.$cliente); ?>" size="69" readonly="readonly"></td>
   			<td>Fecha:</td>
			<td><input name="fecha" type="text" class="inputCodigo" id="fecha" value="<?php echo cambiaf_a_normal($fecha); ?>" size="12" readonly="readonly"></td>
		</tr>
		<tr>
			<td>Dirección:</td>
			<td colspan="5"><textarea name="direccion" font style="text-transform: uppercase" COLS="92" ROWS="2" readonly="readonly" class="inputCodigo" id="direccion"><?php echo($direccion); ?></textarea></td>
		</tr>
		<tr>
    		<td>R.I.F.:</td>
			<td><input name="rif" type="text" font style="text-transform: uppercase" class="inputCodigo" id="rif" value="<?php echo($rif); ?>" size="30" readonly="readonly"></td>
   			<td>Telefono:</td>
			<td colspan="3"><input name="tlf" type="text" class="inputCodigo" id="tlf" value="<?php echo($tlf); ?>" size="47" readonly="readonly"></td>
		</tr>
		<tr>
			<td>Transacción:</td>
			<td><input name="trans" type="text" font style="text-transform: uppercase" class="inputCodigo" id="trans" value="<?php echo($trans); ?>" size="30" readonly="readonly"></td></td>
			<td>Contacto:</td>
			<td colspan="3"><input name="contac" font style="text-transform: uppercase" type="text" class="inputCodigo" id="contac" value="<?php echo($contac); ?>" size="47" readonly="readonly"></td>
		</tr>
		<tr>
			<td>Forma de Pago:</td>
			<td colspan="5"><input name="pago" font style="text-transform: uppercase" type="text" class="inputCodigo" id="pago" value="<?php echo($pago); ?>" size="30" readonly="readonly"></td></td>
		</tr>
		<?php if(($tipo=='NE')||($tipo=='IR')||($tipo=='CP')){ ?>
		<tr>
			<td>Observaciones:</td>
			<td colspan="5"><textarea name="obserCli" font style="text-transform: uppercase" COLS="92" ROWS="2" readonly="readonly" class="inputCodigo" id="obserCli"><?php echo($obserCli); ?></textarea></td>
		</tr>
		<?php } ?>
  	</table>
</div>

<hr>
	

Detalle de los Articulos (Libros)
<div id='tabla'>
  <TABLE width="100%" border="1" CELLSPACING=0 id="tabDet" name="tabDet">
    <TR class='estilotitulo'>
      <?php if(($tipo=='NE')||($tipo=='IR')){ ?>
      <TD width='80'>Cod. Articulo</TD> 
      <TD width='210'>Titulo</TD>
      <TD width='150'>Autor</TD>
      <TD width='52'>Numero de Tomo</TD>		
      <TD width='12'>P</TD> 
      <TD width='60'>Precio Unitario</TD>
      <TD width='48'>Cant Pedida</TD>
      <TD width='48'>Cant Entreg</TD>
      <TD width='70'>Precio Exten.</TD>
      <?php }elseif(($tipo=='PE')||($tipo=='OC')){ ?>
      <TD width='80'>Cod. Articulo</TD> 
      <TD width='240'>Titulo</TD>
      <TD width='155'>Autor</TD>
      <TD width='55'>Numero de Tomo</TD>		
      <TD width='15'>P</TD> 
      <TD width='60'>Precio Unitario</TD>
      <TD width='55'>Cantidad</TD>
      <TD width='70'>Precio Exten.</TD>
      <?php } ?>
	   <?php if($tipo=='CP'){ ?>
      <TD width='80'>Cod. Articulo</TD> 
      <TD width='210'>Titulo</TD>
      <TD width='150'>Autor</TD>
      <TD width='52'>Numero de Tomo</TD>		
      <TD width='12'>P</TD> 
      <TD width='60'>Precio Unitario</TD>
      <TD width='48'>Cant NE</TD>
      <TD width='48'>Cant CP</TD>
      <TD width='70'>Total Bs.</TD>
      <?php } ?>
      </TR>
    <?php
	if ($codigo != ""){
		$link=Conectarse();
		if($tipo=='NE')
				
		{
		
		 
$tipodeprovee = @mysql_query("
select inv_provee.prv_codpro
FROM inv_notaed
LEFT JOIN inv_libros ON inv_notaed.NOT_CODART = inv_libros.lib_codart
LEFT JOIN inv_provee ON inv_libros.prv_codpro = inv_provee.prv_codpro
WHERE inv_notaed.NOT_NUMNOT ='". $codigo."'
LIMIT 0 , 1
",$link); 
$verificar=mysql_fetch_array($tipodeprovee); 
$validacion=$verificar["prv_codpro"];


if ($validacion != "0001")
{
$strQry ="	SELECT p.ped_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, 
								nd.NOT_PRECIO, p.ped_cantid, nd.not_cantid, z.prv_nombre
						FROM inv_notaec nc
						LEFT JOIN inv_pedidd p ON p.ped_numped = nc.not_numped
						LEFT JOIN inv_notaed nd ON nd.not_numnot = nc.not_numnot
						LEFT JOIN inv_libros l ON p.ped_codart = l.lib_codart
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
								LEFT JOIN inv_provee z  ON l.prv_codpro = z.prv_codpro
						WHERE nd.not_codart = p.ped_codart
						AND nc.not_numnot = '". $codigo."'
								AND NOT_CANTID <> 0
								ORDER BY l.lib_descri
											";		
}
else
{
	$strQry ="	SELECT p.ped_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, 
								nd.NOT_PRECIO, p.ped_cantid, nd.not_cantid, z.prv_nombre
						FROM inv_notaec nc
						LEFT JOIN inv_pedidd p ON p.ped_numped = nc.not_numped
						LEFT JOIN inv_notaed nd ON nd.not_numnot = nc.not_numnot
						LEFT JOIN inv_libros l ON p.ped_codart = l.lib_codart
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
								LEFT JOIN inv_provee z  ON l.prv_codpro = z.prv_codpro
						WHERE nd.not_codart = p.ped_codart
						AND nc.not_numnot = '". $codigo."'
								AND NOT_CANTID <> 0
								ORDER BY l.lib_numedit
											";
}


						 
						$xxx= $strQry['l.lib_codart'];
						$provee= $strQry['z.prv_nombre'];
						
						
		}elseif($tipo=='PE'){
			$strQry ="	SELECT p.ped_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, p.ped_precio, 
								p.ped_cantid, p.ped_cantide
						FROM inv_pedidd p
						LEFT JOIN inv_libros l ON p.ped_codart = l.lib_codart
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
						WHERE p.ped_numped = '". $codigo."'
						ORDER BY l.lib_descri
						";
		}elseif($tipo=='IR'){
			$strQry ="	SELECT o.ord_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, id.inf_precio, 
								l.lib_preact, o.ord_cantid, id.inf_cantid
						FROM inv_inforc ic
						LEFT JOIN inv_ordend o ON o.ord_numord = ic.inf_numord
						LEFT JOIN inv_inford id ON id.inf_numinf = ic.inf_numinf
						LEFT JOIN inv_libros l ON o.ord_codart = l.lib_codart
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
						WHERE id.inf_codart = o.ord_codart
						AND id.inf_numinf = '". $codigo."'
						ORDER BY l.lib_descri
						";						
		}elseif($tipo=='CP'){
			$strQry ="SELECT b.REC_CODART,l.lib_descri, aut.aut_nombre, l.lib_numedit, l.lib_present,b.NOT_PRECIO,b.NOTA_CANTID, b.REC_CANTID
FROM fdvl_operaciones a
INNER JOIN fdvl_operacionesd b
ON a.REC_RECEPCION = b.REC_RECEPCIOND
JOIN inv_libros l ON b.REC_CODART = l.lib_codart
JOIN inv_autor aut ON l.aut_codigo = aut.aut_codigo
WHERE a.REC_RECEPCION = '". $codigo."'
ORDER BY l.lib_descri

";					
		}elseif($tipo=='OC'){
			$strQry ="	SELECT c.ord_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, l.lib_preact, 
								c.ord_cantid, c.ord_cantidr
					FROM inv_ordend c
					LEFT JOIN inv_libros l ON c.ord_codart = l.lib_codart
					LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
					WHERE c.ord_numord = '". $codigo."'
					ORDER BY l.lib_descri
					";
		}
		$result=mysql_query($strQry,$link);
		while($row = mysql_fetch_array($result)) {
			if(($tipo=='NE')||($tipo=='IR')||($tipo=='CP')){
				$cant = isset($row[7])?$row[7]:'0';
			}else{
				$cant = isset($row[6])?$row[6]:'0';
			}
		echo("<tr>");
			printf("<td>%s</td> ", isset($row[0])?$row[0]:' - '); // ped_codart
			printf("<td>%s</td> ", isset($row[1])?strtoupper(utf8_decode($row[1])):' - '); // lib_descri
			printf("<td>%s</td> ", isset($row[2])?strtoupper(utf8_decode($row[2])):' - '); // aut_nombre
			printf("<td>%s</td> ", isset($row[3])?$row[3]:' - '); // lib_numedit
			printf("<td>%s</td> ", isset($row[4])?$row[4]:' - '); // lib_present
			printf("<td>%s</td> ", isset($row[5])?number_format($row[5],2,',','.'):'0,00'); // ped_precio
			printf("<td>%s</td> ", isset($row[6])?$row[6]:'0'); // ped_cantid
			if(($tipo=='NE')||($tipo=='IR')||($tipo=='CP')){printf("<td>%s</td> ", $cant);}
			//printf("<td><input type='text' size='3' maxlength='6' value='%s' onKeyPress='return isNumeric(event);' onChange='calcularPrecio2(this,2);'></td> ", isset($cantEnt)?$cantEnt:'0'); // ped_cantide
			//printf("<td>%s</td> ", isset($cantEnt)?$cantEnt:'0'); // ped_cantide
			printf("<td>%s</td> ", number_format($row[5]*($cant),2,',','.'));
		echo("</tr>");
		}
		mysql_free_result($result);
		mysql_close($link);
	}
	?>
    </table>
</div>
<Br>
<div id='estTabTotal'>
	<TABLE width="100%" id="tabTotal" name="tabTotal">
		<TR>
			<TD width='480'></TD>
			<TD width='50'><strong>Total</strong></TD>
			<TD width='75'>0 Uni.</TD>
			<TD width='125'>0,00 Bs.</TD>
		</TR>
		<TR>
			<TD></TD>
			<TD colspan="2"><strong>Descuento</strong></TD>
			<TD><input name="desc" type='text' class='inputCodigo' id="desc" value='<?php echo($desc); ?>' size='5' maxlength='5' readonly="readonly"> %</TD>
		</TR>
		<TR>
			<TD></TD>
			<TD colspan="2"><strong>Total General</strong></TD>
			<TD>0,00 Bs.</TD>
		</TR>
	</table>
</div>
<Br>
<hr class='noimprimir'>
<?php 	if(($tipo=='NE')||($tipo=='IR')||($tipo=='CP')){ print "<script> calcularPrecioTotal(8); </script>"; }
		elseif(($tipo=='PE')||($tipo=='OC')){ print "<script> calcularPrecioTotal(7); </script>"; } ?>
<div id="FormaModOperativo">
	<table>


<?php if($tipo=='NE') 
{
	?>


   <tr>
	  <td>Cajas:</td>
	  <td><input name="recibido23" type="text" class="inputCodigootros" id="recibido25" value="<?php echo($cajas); ?>" size="38" readonly="readonly" /></td>
	  <td>Paquetes:</td>
	  <td><input name="recibido222" type="text" class="inputCodigootros" id="recibido222" value="<?php echo($paquetes); ?>" size="38" readonly="readonly" /></td>
	</tr>
    


	<tr>
	  <td>NE Creado por:</td>
	  <td><input name="recibido23" type="text" style="text-transform: uppercase" class="inputCodigoP" id="recibido25" value="<?php echo($userNE); ?>" size="38" readonly="readonly" /></td>
	  <td>Fecha:</td>
	  <td><input name="recibido222" type="text" style="text-transform: uppercase" class="inputCodigoP" id="recibido222" value="<?php echo cambiaf_a_normal($fechaNE); ?>"  size="38" readonly="readonly" /></td>
	</tr>
    
  
 
    
<?php
}
?>



	<tr>
		<?php if(($tipo=='NE')||($tipo=='IR')||($tipo=='CP')){ ?>
		<td width='15%'>Recibido:</td>
		<?php }elseif($tipo=='PE'){ ?>
		<td width='15%'>Vendedor:</td>
		<?php }elseif($tipo=='OC'){ ?>
		<td width='15%'>Solicitado por:</td>
		<?php } ?>
		<td width='35%'><input name="recibido"  font style="text-transform: uppercase" type="text" class="inputCodigo" id="recibido" value="<?php echo($recibido); ?>" size="38" readonly="readonly"></td>
		<?php if(($tipo=='NE')||($tipo=='CP')){ ?>
		<td width='15%'>Autorizado:</td>
		<?php }elseif($tipo=='PE'){ ?>
		<td width='15%'>Cliente:</td>
		<?php }elseif($tipo=='OC'){ ?>
		<td width='15%'>Aceptado por:</td>
		<?php }elseif($tipo=='IR'){ ?>
		<td width='15%'>Proveedor:</td>
		<?php } ?>
		<td width='35%'><input name="autorizado" type="text"  font style="text-transform: uppercase" class="inputCodigo" id="autorizado" value="<?php echo($autorizado); ?>" size="38" readonly="readonly"></td>
	</tr>
	
    
<?php if($tipo=='NE') 
{
	?>
    <tr>
	  <td>PE Creado por:</td>
	  <td><input name="recibido2" type="text" font style="text-transform: uppercase" class="inputCodigo" id="recibido23" value="<?php echo($userPE); ?>" size="38" readonly="readonly" /></td>
	  <td>Fecha:</td>
	  <td><input name="recibido22" type="text" class="inputCodigo" id="recibido24" value="<?php echo($fechaPE); ?>" size="38" readonly="readonly" /></td>
	  </tr>
	
        
<?php
}
?>
    
    
    
    
    
    
    













	<tr>
	  <td>Observaciones:</td>
	  <td colspan="3"><textarea name="observ" cols="90" font style="text-transform: uppercase" rows="2" readonly="readonly" class="inputCodigo" id="observ" maxlength="100"><?php echo($observ); ?></textarea></td>
	  </tr>
	<tr><td colspan="4"></td></tr>
	<tr>
		<td colspan="4">
        
        
       <?php
        if($tipo=='NE') 
		{?>
          <a href="excel_entregareimpresion.php?pedido=<?php echo($pedido); ?>&cod_recep=<?php echo($cod_recep); ?>&fecha=<?php echo cambiaf_a_normal($fecha);?>&cod=<?php echo($codigo); ?>&recibido=<?php echo($recibido); ?>&autorizado=<?php echo($autorizado); ?>&observ=<?php echo($observ); ?>"><img src="images/icono-excel.png" alt="Enviar a Excel" width="45" height="45" border=0 align="right" class='noimprimir' style="cursor:pointer" /></td>
        <td colspan="4">
		<?php 
		}
		?>
		<img src="images/icono-impresion.gif" alt="Imprimir" width="49" height="49" border=0 align="right" class='noimprimir' style="cursor:pointer" onClick="imprimirPagina();" /></td>
        
        
	</tr>
	</table>
</div>
</form>
<p>&nbsp;</p>
<?php } ?>



























































































		 </div>
		 <?php }else{?>
		    <div id="logolateral">
			     <h1><span>Ministerio del Poder popular para la Cultura</span></h1>
		     </div>
		  <?php  include("conectarse.php")
		 ?>
		 </div>
		 <?php } ?>
	</div>
	</div>
	</body>
</html>
