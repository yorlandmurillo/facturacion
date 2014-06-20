<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<div id="navegador">
	<p>
		<SPAN class='noimprimir'>
		<a href="#">Sistema de Inventario</a> | 
		<a href="#">Módulo Operativo</a> | </SPAN>Reimpresión
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
  <input type="text" id="codigo" onkeyup = "upperCase(this,event)" name="codigo" style="border-color:#BFDBFF;border-width:1px;border-style:solid;text-transform: uppercase; text-align:left "class="inputCodigoP" value="<?php echo($codigo); ?>" size="15" maxlength="12" />
  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>  <input type="Button" value="Buscar" onclick="frmReimpresion.submit();" class='noimprimir'> </td>
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
							n.not_fchnot, n.not_observ, n.not_recibo, n.not_entreg
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
		}
	}elseif($tipo=='PE'){
		$pedido=$codigo;
		$strQry="	SELECT c.clt_codcli, c.clt_nombre, c.clt_direc, c.clt_rif, c.clt_telef, t.trs_descrip, 
					c.clt_contac, p.ped_pordes, v.ven_nombre, p.ped_observ, cp.con_descri, p.ped_fchped 
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
		}
	}elseif($tipo=='OC'){
		$pedido=$codigo;
		$strQry="	SELECT p.prv_codpro, p.prv_nombre, p.prv_direc, p.prv_rif, p.prv_telef, t.trs_descrip, 
					p.prv_contac, c.ord_pordes, ord_solici, c.ord_observ, cp.con_descri, c.ord_fchord, c.ord_acepta 
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
		}
	}elseif($tipo=='IR'){
		$cod_recep=$codigo;
		$strQry="	SELECT 	i.inf_numord, p.prv_codpro, p.prv_nombre, p.prv_direc, p.prv_rif, p.prv_telef, 
							t.trs_descrip, p.prv_contac, o.ord_pordes, o.ord_observ, cp.con_descri,
							i.inf_fchrec, i.inf_observ, i.inf_recibo, i.inf_entreg
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
			<td colspan="5"><input type="text" id="cod_recep" name="cod_recep" value="<?php echo($cod_recep); ?>" size="30" class="inputCodigo"></td>
		</tr>
		<?php } ?>
  		<tr>
			<?php if(($tipo=='NE')||($tipo=='PE')){ ?>
    		<td>Nº. Pedido:</td>
			<?php }elseif(($tipo=='IR')||($tipo=='OC')){ ?>
			<td>Nº. Compra:</td>
			<?php } ?>
			<td colspan="5"><input type="text" id="pedido" name="pedido" value="<?php echo($pedido); ?>" size="30" class="inputCodigo"></td>
		</tr>
		<?php if($tipo=='NE'){ ?>
		<tr>
    		<td>Vendedor:</td>
			<td colspan="5"><input type="text" id="vende" name="vende" value="<?php echo($vende); ?>" size="30" class="inputCodigo"></td>
		</tr>
		<?php } ?>
		<tr>
			<?php if(($tipo=='IR')||($tipo=='OC')){ ?>
    		<td>Editorial:</td>
			<?php }else{ ?>
			<td>Cliente:</td>
			<?php } ?>
			<td colspan="3"><input type="text" id="cod_cliente" name="cod_cliente" value="<?php echo($cod_cliente.' '.$cliente); ?>" size="69" class="inputCodigo"></td>
   			<td>Fecha:</td>
			<td><input type="text" id="fecha" name="fecha" value="<?php echo cambiaf_a_normal($fecha); ?>" size="12" class="inputCodigo"></td>
		</tr>
		<tr>
			<td>Dirección:</td>
			<td colspan="5"><textarea id="direccion" name="direccion" COLS="92" ROWS="2" class="inputCodigo"><?php echo($direccion); ?></textarea></td>
		</tr>
		<tr>
    		<td>R.I.F.:</td>
			<td><input type="text" id="rif" name="rif" value="<?php echo($rif); ?>" size="30" class="inputCodigo"></td>
   			<td>Telefono:</td>
			<td colspan="3"><input type="text" id="tlf" name="tlf" value="<?php echo($tlf); ?>" size="47" class="inputCodigo"></td>
		</tr>
		<tr>
			<td>Transacción:</td>
			<td><input type="text" id="trans" name="trans" value="<?php echo($trans); ?>" size="30" class="inputCodigo"></td></td>
			<td>Contacto:</td>
			<td colspan="3"><input type="text" id="contac" name="contac" value="<?php echo($contac); ?>" size="47" class="inputCodigo"></td>
		</tr>
		<tr>
			<td>Forma de Pago:</td>
			<td colspan="5"><input type="text" id="pago" name="pago" value="<?php echo($pago); ?>" size="30" class="inputCodigo"></td></td>
		</tr>
		<?php if(($tipo=='NE')||($tipo=='IR')){ ?>
		<tr>
			<td>Observaciones:</td>
			<td colspan="5"><textarea id="obserCli" name="obserCli" COLS="92" ROWS="2" class="inputCodigo"><?php echo($obserCli); ?></textarea></td>
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
      </TR>
    <?php
	if ($codigo != ""){
		$link=Conectarse();
		if($tipo=='NE'){
			$strQry ="	SELECT p.ped_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, 
								p.ped_precio, p.ped_cantid, nd.not_cantid
						FROM inv_notaec nc
						LEFT JOIN inv_pedidd p ON p.ped_numped = nc.not_numped
						LEFT JOIN inv_notaed nd ON nd.not_numnot = nc.not_numnot
						LEFT JOIN inv_libros l ON p.ped_codart = l.lib_codart
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
						WHERE nd.not_codart = p.ped_codart
						AND nc.not_numnot = '". $codigo."'
						ORDER BY l.col_colecc, l.lib_numedit, l.lib_present";
						 
						$xxx= $strQry['l.lib_codart'];
						
		}elseif($tipo=='PE'){
			$strQry ="	SELECT p.ped_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, p.ped_precio, 
								p.ped_cantid, p.ped_cantide
						FROM inv_pedidd p
						LEFT JOIN inv_libros l ON p.ped_codart = l.lib_codart
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
						WHERE p.ped_numped = '". $codigo."'
						ORDER BY l.col_colecc, l.lib_numedit, l.lib_present";
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
						ORDER BY l.col_colecc, l.lib_numedit, l.lib_present";
		}elseif($tipo=='OC'){
			$strQry ="	SELECT c.ord_codart, l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, l.lib_preact, 
								c.ord_cantid, c.ord_cantidr
					FROM inv_ordend c
					LEFT JOIN inv_libros l ON c.ord_codart = l.lib_codart
					LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
					WHERE c.ord_numord = '". $codigo."'
					ORDER BY l.col_colecc, l.lib_numedit, l.lib_present";
		}
		$result=mysql_query($strQry,$link);
		while($row = mysql_fetch_array($result)) {
			if(($tipo=='NE')||($tipo=='IR')){
				$cant = isset($row[7])?$row[7]:'0';
			}else{
				$cant = isset($row[6])?$row[6]:'0';
			}
		echo("<tr>");
			printf("<td>%s</td> ", isset($row[0])?$row[0]:' - '); // ped_codart
			printf("<td>%s</td> ", isset($row[1])?utf8_decode($row[1]):' - '); // lib_descri
			printf("<td>%s</td> ", isset($row[2])?utf8_decode($row[2]):' - '); // aut_nombre
			printf("<td>%s</td> ", isset($row[3])?$row[3]:' - '); // lib_numedit
			printf("<td>%s</td> ", isset($row[4])?$row[4]:' - '); // lib_present
			printf("<td>%s</td> ", isset($row[5])?number_format($row[5],2,',','.'):'0,00'); // ped_precio
			printf("<td>%s</td> ", isset($row[6])?$row[6]:'0'); // ped_cantid
			if(($tipo=='NE')||($tipo=='IR')){printf("<td>%s</td> ", $cant);}
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
	<TABLE id="tabTotal" name="tabTotal">
		<TR>
			<TD width='480'></TD>
			<TD width='50'><strong>Total</strong></TD>
			<TD width='75'>0 Uni.</TD>
			<TD width='125'>0,00 Bs.</TD>
		</TR>
		<TR>
			<TD></TD>
			<TD colspan="2"><strong>Descuento</strong></TD>
			<TD><input type='text' id="desc" name="desc" size='5' maxlength='5' value='<?php echo($desc); ?>' class='inputCodigo'> %</TD>
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
<?php 	if(($tipo=='NE')||($tipo=='IR')){ print "<script> calcularPrecioTotal(8); </script>"; }
		elseif(($tipo=='PE')||($tipo=='OC')){ print "<script> calcularPrecioTotal(7); </script>"; } ?>
<div id="FormaModOperativo">
	<table>
	<tr>
		<?php if(($tipo=='NE')||($tipo=='IR')){ ?>
		<td width='15%'>Recibido:</td>
		<?php }elseif($tipo=='PE'){ ?>
		<td width='15%'>Vendedor:</td>
		<?php }elseif($tipo=='OC'){ ?>
		<td width='15%'>Solicitado por:</td>
		<?php } ?>
		<td width='35%'><input type="text" id="recibido" name="recibido" value="<?php echo($recibido); ?>" size="38" class="inputCodigo"></td>
		<?php if($tipo=='NE'){ ?>
		<td width='15%'>Autorizado:</td>
		<?php }elseif($tipo=='PE'){ ?>
		<td width='15%'>Cliente:</td>
		<?php }elseif($tipo=='OC'){ ?>
		<td width='15%'>Aceptado por:</td>
		<?php }elseif($tipo=='IR'){ ?>
		<td width='15%'>Proveedor:</td>
		<?php } ?>
		<td width='35%'><input type="text" id="autorizado" name="autorizado" value="<?php echo($autorizado); ?>" size="38" class="inputCodigo"></td>
	</tr>
	<tr>
		<td>Observaciones:</td>
		<td colspan="3"><textarea id="observ" name="observ" COLS="90" ROWS="2" maxlength="100" class="inputCodigo"><?php echo($observ); ?></textarea></td>
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
        
   <img src="images/icono-impresion.gif" alt="Imprimir" width="45" height="45" border=0 align="right" class='noimprimir' style="cursor:pointer" onclick="imprimirPagina();" /></td>
        
        
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
