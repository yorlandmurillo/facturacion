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
.noimprimir table tr .TextNormal {
	color: #000;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
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
					<a href="#"></a> SISTEMA DE INVENTARIO | REIMPRESION | <? echo "$usuario"; ?>
		<a href="#"></a></SPAN>
	</p>
</div>

<script type="text/javascript">
function upperCase(obj,e) {
if (e.keyCode==37 || e.keyCode==39)
return;
obj.value = obj.value.toUpperCase();
}
</script>

<form name="frmReimpresion" method="post">
<SPAN class='noimprimir'>
<table>
<tr>
			<td class="TextNormal">Introduzca el código:</td>
<td><span id="sprytextfield1">
  <input type="text" id="codigo" onkeyup = "upperCase(this,event)" name="codigo" style="border-color:#BFDBFF;border-width:1px;border-style:solid;text-transform: uppercase; text-align:left "class="inputCodigoP" value="<?php echo($codigo); ?>" size="15" maxlength="13" />
</span>  
<input type="Button" value="Buscar" onclick="frmReimpresion.submit();" class='noimprimir'> </td>
   	</tr>
</table>
<Br>
<hr class='noimprimir'>

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
if ($codigo != ""){
//echo substr($codigo,0,2);
	$tipo=substr($codigo,0,2);
	
	$link=Conectarse();
	
	if($tipo=='NE'){ 
		$cod_recep=$codigo;
		$strQry="	SELECT 	n.not_numped, c.clt_codcli, c.clt_nombre, c.clt_direc, c.clt_rif, c.clt_telef, 
							t.trs_descrip, c.clt_contac, p.ped_pordes, v.ven_nombre, p.ped_observ, cp.con_descri,
							n.not_fchnot, n.not_observ, n.not_recibo, n.not_entreg, n.not_estatus,not_user,NOT_FCHNOT,ped_user,ped_fchped,n.NOT_CAJAS,n.NOT_PAQUETES,n.NOT_FERIAS
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
						$ferias=$row["NOT_FERIAS"];
						

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
					c.clt_contac, p.ped_pordes, v.ven_nombre, p.ped_observ, cp.con_descri, p.ped_fchped, ped_estatus,ped_user,ped_fchped, p.ped_localidad,p.ped_estado,p.ped_pais, p.ped_feria
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
				$estatus2 = utf8_decode($row[12]);
			$userPE=$row["ped_user"];
						$fechaPE=$row["ped_fchped"];
			
											$localidad = utf8_decode($row[15]);
				$estado = utf8_decode($row[16]);
					$pais = utf8_decode($row[17]);
						$ferias = utf8_decode($row[18]);
					
					
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
		
		}elseif($tipo=='DE'){
		$pedido=$codigo;
		$strQry="	SELECT c.clt_codcli, c.clt_nombre, c.clt_direc, c.clt_rif, c.clt_telef, 
					c.clt_contac, p.dev_observ, p.dev_fcdev,dev_estatus, p.dev_user
				FROM inv_devolucion p
				LEFT JOIN inv_cliente c ON p.dev_codcli = c.clt_codcli
				WHERE p.dev_devolucion = '". $codigo."'";
		//echo $strQry;
		$result=mysql_query($strQry,$link);
		if($row = mysql_fetch_array($result)){
			
			$cod_cliente = $row[0];
			$cliente = utf8_decode($row[1]);
			$direccion = utf8_decode($row[2]);
			$rif = $row[3];
			$tlf = $row[4];
			$contac = utf8_decode($row[5]);
            $observ = utf8_decode($row[6]);
			$fecha = $row[7];
			$dev_status = utf8_decode($row[8]);
$recibido = utf8_decode($row[9]);
$autorizado = utf8_decode($row[9]);

$resultdev= @mysql_query("
select nc_numdev,nc_numcd
FROM inv_notadecredito
WHERE nc_numdev = '". $codigo."'
",$link); 
$rowdev=mysql_fetch_array($resultdev); 
$nota_credito=$rowdev["nc_numcd"];


		}
		
		
		
		}elseif($tipo=='NC'){
		$pedido=$codigo;
		$strQry="	SELECT c.clt_codcli, c.clt_nombre, c.clt_direc, c.clt_rif, c.clt_telef, 
					c.clt_contac, p.nc_observ, p.nc_fch,d.dev_estatus, u.usr_user
				FROM inv_notadecredito p
				LEFT JOIN inv_cliente c ON p.nc_cliente = c.clt_codcli
						LEFT JOIN inv_devolucion d ON p.nc_numdev = d.dev_devolucion
				LEFT JOIN inv_user u ON p.nc_userdev = u.usr_login
				WHERE p.nc_numcd = '". $codigo."'";
		//echo $strQry;
		$result=mysql_query($strQry,$link);
		if($row = mysql_fetch_array($result)){
			
			$cod_cliente = $row[0];
			$cliente = utf8_decode($row[1]);
			$direccion = utf8_decode($row[2]);
			$rif = $row[3];
			$tlf = $row[4];
			$contac = utf8_decode($row[5]);
            $observ = utf8_decode($row[6]);
			$fecha = $row[7];
			$dev_status = utf8_decode($row[8]);
$recibido = utf8_decode($row[9]);
$autorizado = utf8_decode($row[9]);

$resultdev= @mysql_query("
select nc_numdev,nc_numcd
FROM inv_notadecredito
WHERE nc_numcd = '". $codigo."'
",$link); 
$rowdev=mysql_fetch_array($resultdev); 
$nota_credito=$rowdev["nc_numdev"];


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
    		<td width="5%"></td>
			<td width="10%"></td>
   			<td width="3%"></td>
			<td width="7%"></td>
   			<td width="15%"></td>
			<td width="7%"></td>
		</tr>
		<?php if(($tipo=='NE')||($tipo=='IR')){ ?>
		<tr>
			<?php if($tipo=='NE'){ ?>
    		<td>Nº. Entrega:</td>
			<?php }elseif($tipo=='IR'){ ?>
			<td>Nº. Recepción:</td>
			<?php } ?>

		

		  <td colspan="6"><input name="cod_recep" type="text" class="inputCodigo" id="cod_recep" value="<?php echo($cod_recep); ?>" size="30" readonly="readonly"></td>
		</tr>



  <?php } ?>
  		<tr>
			<?php if(($tipo=='NE')||($tipo=='PE')){ ?>
      <td>Nº. Pedido:</td>
	  <td colspan="5"><input name="pedido" type="text" class="inputCodigo" id="pedido" value="<?php echo($pedido); ?>" size="30" readonly="readonly"> 
			<?php }elseif(($tipo=='IR')||($tipo=='OC')){ ?>
		
			<td width="11%">Nº Compra:</td>
      <td colspan="5"><input name="pedido" type="text" class="inputCodigo" id="pedido" value="<?php echo($pedido); ?>" size="30" readonly="readonly"> 
			 
       
			<?php } ?>

			<?php if($tipo=='DE'){ ?>
      <td width="4%">Devolución:</td>
	  <td colspan="5"><input name="pedido" type="text" class="inputCodigo" id="pedido" value="<?php echo($pedido); ?>" size="30" readonly="readonly"> 
			<?php } ?>

			<?php if($tipo=='NC'){ ?>
      <td width="3%">Nota de Credito:</td>
	  <td width="10%" colspan="5"><input name="pedido" type="text" class="inputCodigo" id="pedido" value="<?php echo($pedido); ?>" size="30" readonly="readonly"> 
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

	<?PHP IF ($ferias != '')
					{ 
?>

    <tr>
		  <td>Destino:</td>
			<td colspan="5"><input name="feria" type="text" class="inputCodigo" id="feria" value="<?php echo "$ferias"; ?>" size="70" readonly="readonly" /></td>
			<td>&nbsp;</td>
            


    <?PHP 
         }

            ?>
            
    
<tr>
    		<td>Estatus:</td>
			<td colspan="5"><input name="vende" type="text" class="inputCodigootros" id="vende" value="<?php echo($estatus); ?>" size="50" readonly="readonly"></td>
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
        
        	<?PHP IF ($ferias != '')
					{ 
?>

	  <tr>
		  <td>Destino:</td>
			<td colspan="5"><input name="feria" type="text" class="inputCodigo" id="feria" value="<?php echo "$ferias"; ?>" size="70" readonly="readonly" /></td>
			<td>&nbsp;</td>
            


    <?PHP 
         }

            ?>


  <tr>
    		<td>Estatus:</td>
			<td colspan="5"><input name="vende" type="text" class="inputCodigootros" id="vende" value="<?php echo($estatus); ?>" size="50" readonly="readonly"></td>
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


  <?php if($tipo=='NE')
  

  
  
  { 
  
  
  
  



  
  
  ?>
		
        <td>Vendedor:</td>
			<td colspan="5"><input name="vende" type="text" font style="text-transform: uppercase" class="inputCodigo" id="vende" value="<?php echo($vende); ?>" size="30" readonly="readonly"></td>
		</tr>
		<?php } ?>
			<?php if(($tipo=='IR')||($tipo=='OC')){ ?>
    		<tr>
    		  <td>Editorial:</td>
			<?php }else{ ?>
			<td>Cliente:</td>
			<?php } ?>
			<td colspan="3"><input name="cod_cliente" font style="text-transform: uppercase" type="text" class="inputCodigo" id="cod_cliente" value="<?php echo($cod_cliente.' '.$cliente); ?>" size="69" readonly="readonly"></td>
   			<td>Fecha:
   			  <input name="fecha" type="text" class="inputCodigo" id="fecha" value="<?php echo cambiaf_a_normal($fecha); ?>" size="12" readonly="readonly"></td>
   			<td>&nbsp;</td>
			<td>&nbsp;</td>
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
			<td colspan="4"><input name="contac" font style="text-transform: uppercase" type="text" class="inputCodigo" id="contac" value="<?php echo($contac); ?>" size="47" readonly="readonly"></td>
		</tr>
		<tr>
			<td> Pago:</td>
			<td colspan="5"><input name="pago" font style="text-transform: uppercase" type="text" class="inputCodigo" id="pago" value="<?php echo($pago); ?>" size="30" readonly="readonly"></td>
			<td>            
			</td>
		</tr>
		<?php if(($tipo=='NE')||($tipo=='IR')||($tipo=='CP')){ ?>
		<tr>
			<td>Observaciones:</td>
			<td colspan="5"><textarea name="obserCli" font style="text-transform: uppercase" COLS="92" ROWS="5" readonly="readonly" class="inputCodigo" id="obserCli"><?php echo($obserCli); ?></textarea></td>
		</tr>
		<?php } ?>
        
        
  
                    
                    
                          
        
        
  	</table>
</div>

<hr>
	

Detalle de los Articulos (Libros)
<div id='tabla'>
  <TABLE CELLSPACING=0 border="1" id="tabDet" name="tabDet">
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
	     <?php if($tipo=='DE'){ ?>
      <TD width='80'>Cod. Articulo</TD> 
      <TD width='210'>Titulo</TD>
      <TD width='150'>Autor</TD>
      <TD width='52'>Numero de Tomo</TD>		
      <TD width='12'>P</TD> 
      <TD width='60'>Precio Unitario</TD>
      <TD width='60'>Cant Dev</TD>
      <TD width='48'>Total Bs.</TD>
    
      <?php } ?>
	   <?php if($tipo=='NC'){ ?>
      <TD width='80'>Cod. Articulo</TD> 
      <TD width='210'>Titulo</TD>
      <TD width='150'>Autor</TD>
      <TD width='52'>Numero de Tomo</TD>		
      <TD width='12'>P</TD> 
      <TD width='60'>Precio Unitario</TD>
      <TD width='60'>Cant Dev</TD>
      <TD width='48'>Total Bs.</TD>
    
      <?php } ?>
      </TR>
    <?php
	if ($codigo != ""){
		$link=Conectarse();
		if($tipo=='NE'){
			
			
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
								nd.NOT_PRECIO, p.ped_cantid, nd.not_cantid
						FROM inv_notaec nc
						LEFT JOIN inv_pedidd p ON p.ped_numped = nc.not_numped
						LEFT JOIN inv_notaed nd ON nd.not_numnot = nc.not_numnot
						LEFT JOIN inv_libros l ON p.ped_codart = l.lib_codart
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
						WHERE nd.not_codart = p.ped_codart
						AND nc.not_numnot = '". $codigo."'
										AND NOT_CANTID <> 0
										ORDER BY l.lib_descri
											 ";
						 
						
}
else
{
		$strQry ="	SELECT p.ped_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, 
								nd.NOT_PRECIO, p.ped_cantid, nd.not_cantid
						FROM inv_notaec nc
						LEFT JOIN inv_pedidd p ON p.ped_numped = nc.not_numped
						LEFT JOIN inv_notaed nd ON nd.not_numnot = nc.not_numnot
						LEFT JOIN inv_libros l ON p.ped_codart = l.lib_codart
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
						WHERE nd.not_codart = p.ped_codart
						AND nc.not_numnot = '". $codigo."'
										AND NOT_CANTID <> 0
										ORDER BY l.lib_numedit
											 ";
						 
					
}
			
			
			
						$xxx= $strQry['l.lib_codart'];
						
		}elseif($tipo=='PE'){
			$strQry ="	SELECT p.ped_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, p.ped_precio, 
								p.ped_cantid, p.ped_cantide
						FROM inv_pedidd p
						LEFT JOIN inv_libros l ON p.ped_codart = l.lib_codart
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
						WHERE p.ped_numped = '". $codigo."'
						AND p.ped_cantid <> 0
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
		}elseif($tipo=='DE'){
			$strQry ="	
SELECT p.dev_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, p.dev_precio, 
								p.dev_cantid
						FROM inv_devolucionde p
						LEFT JOIN inv_libros l ON p.dev_codart = l.lib_codart
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
						
						WHERE p.dev_devolucion = '". $codigo."'
						ORDER BY l.lib_descri
					";			
						
						}elseif($tipo=='NC'){
			$strQry ="	
SELECT p.nc_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, p.nc_precio, 
								p.nc_cantid
						FROM inv_notadecreditod p
						LEFT JOIN inv_libros l ON p.nc_codart = l.lib_codart
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
						
						WHERE p.nc_numcd = '". $codigo."'
						
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
		elseif(($tipo=='PE')||($tipo=='OC')||($tipo=='DE')||($tipo=='NC')){ print "<script> calcularPrecioTotal(7); </script>"; } ?>
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
	  <!-- <td>Fecha:</td>
	  <td><input name="recibido222" type="text" style="text-transform: uppercase" class="inputCodigoP" id="recibido222" value="<?php ///echo cambiaf_a_normal($fechaNE); ?>"  size="38" readonly="readonly" /></td>
	</tr>
    -->
    
  
 
    
<?php
}
?>



	<tr>
		<?php if(($tipo=='NE')||($tipo=='IR')||($tipo=='CP')||($tipo=='NC')){ ?>
		<td width='15%'>Recibido:</td>
		<?php }elseif($tipo=='PE'){ ?>
		<td width='15%'>Vendedor:</td>
		<?php }elseif($tipo=='OC'){ ?>
		<td width='15%'>Solicitado por:</td>
		<?php }elseif($tipo=='DE'){ ?>
		<td width='15%'>Solicitado por:</td>
		<?php } ?>
		<td width='35%'><input name="recibido"  font style="text-transform: uppercase" type="text" class="inputCodigo" id="recibido" value="<?php echo($recibido); ?>" size="38" readonly="readonly"></td>
		<?php if(($tipo=='NE')||($tipo=='CP')||($tipo=='DE')){ ?>
		<td width='15%'>Autorizado:</td>
		<?php }elseif($tipo=='PE'){ ?>
		<td width='15%'>Cliente:</td>
		<?php }elseif($tipo=='OC'){ ?>
		<td width='15%'>Aceptado por:</td>
		<?php }elseif($tipo=='NC'){ ?>
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
		<td colspan="3"><textarea name="observ" COLS="90" font style="text-transform: uppercase" ROWS="5" readonly="readonly" class="inputCodigo" id="observ"><?php echo($observ); ?></textarea></td>
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
		<img src="images/icono-impresion.gif" alt="Imprimir" width="49" height="49" border=0 align="right" class='noimprimir' style="cursor:pointer" onclick="imprimirPagina();" /></td>
        
        
	</tr>
	</table>
</div>
</form>
<p>&nbsp;</p>
<?php } ?>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
