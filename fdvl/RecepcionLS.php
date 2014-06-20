<script src="/inventario/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="/inventario/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<div id="navegador">
	<p>
		<SPAN class='noimprimir'>
		<a href="#">Sistema de Inventario</a> | 
	<a href="#">Módulo Operativo</a> | </SPAN>Proceso de Control Perceptivo</p>
	
</div>
<p><font color=red size=3><strong>RECUERDE ACTUALIZAR EL INVENTARIO ANTES DE CARGAR UNA NOTA DE ENTREGA</strong></font><p>
<script type="text/javascript">
function upperCase(obj,e) {
if (e.keyCode==37 || e.keyCode==39)
return;
obj.value = obj.value.toUpperCase();
}
</script>


<?php
include("includes/functions.php");
include 'conec_local.php';
include 'conec_distribuidora.php';
$inexistentes=0;



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
$nota_entrega = isset($_POST['nota_entrega'])?$_POST['nota_entrega']:'';

$feria = isset($_POST['feria'])?$_POST['feria']:'';
$usuario=$_SESSION['Nusuario'];


function cambiarFormatoFecha($fecha)
{ 
    list($anio,$mes,$dia)=explode("-",$fecha); 
    return $dia."/".$mes."/".$anio; 
}




$msg = $_GET["msg"]; 

if ($cod_entrega!= '')
{
	//$db_distr=Conectarse();
	$strQry="	SELECT c.clt_codcli, c.clt_nombre, c.clt_direc, c.clt_rif, c.clt_telef, t.trs_descrip, c.clt_contac, p.ped_pordes, v.ven_nombre, n.NOT_OBSERV, cp.con_descri, p.ped_feria, n.NOT_FCHNOT, n.NOT_NUMNOT,  p.ped_numped, n.NOT_FERIAS
				FROM inv_pedidc p
				LEFT JOIN inv_notaec n ON p.ped_numped = n.NOT_NUMPED
				LEFT JOIN inv_cliente c ON p.ped_codcli = c.clt_codcli
				LEFT JOIN inv_transac t ON p.ped_codtrs = t.trs_codtrs
				LEFT JOIN inv_vende v ON p.ped_codven = v.ven_codven
				LEFT JOIN inv_condic cp ON p.con_codigo = cp.con_codigo
				WHERE n.NOT_NUMNOT = '$cod_entrega'
								
				";
	$result=mysql_query($strQry,$db_distr);
	if($row = mysql_fetch_array($result))
	{
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
		$feria = utf8_decode($row[11]);
		$fechaNota = utf8_decode($row[12]);
		$nota_entrega = utf8_decode($row[13]);
		$npedido = utf8_decode($row[14]);
				$ferias = utf8_decode($row[15]);
	
		///////////////////////////////// alberto	
		$resultFac = @mysql_query("select * FROM fdvl_operaciones WHERE REC_NUMNOT ='$nota_entrega'",$db_distr); 
	//	$resultFac = @mysql_query("select * FROM fdvl_operaciones WHERE REC_NUMNOT ='$nota_entrega'",$db_local);
		$rowFac=mysql_fetch_array($resultFac); 
		$fac_numfact=$rowFac["REC_RECEPCION"];

		if (mysql_num_rows($resultFac) == 0) 
		{ 

		}
		else
		{
			echo "<script>alert('NOTA DE ENTREGA YA PROCESADA BAJO EL Nº $fac_numfact');
			document.location=('inventario.php?p=RecepcionLS');
			</script>"; 

		}
		///////////////////////////////// alberto	
	}

	if (mysql_num_rows($result) == 0) 
	{ 

	}

	mysql_free_result($result);
	mysql_close($db_distr);
	
	$msg="";
}	
?>
<script>
	////////////////////////// CAMPOS QUE SE DEBEN VALIDAR
	var fieldsFormatForm = Array(new Array('observ', 'NO', 'VACIO', 'Observaciones'));
</script>
<form name="frmEntrega" method="post">
	<div id="FormaModOperativo">
	<input type="hidden" name="cod_libro"><input type="hidden" name="precio_libro"><input type="hidden" name="editorial"><input type="hidden" name="cant_libro">
	<input type="hidden" name="cant_libro2"><input type="hidden" name="cod_Barra"><input type="hidden" name="tomo"><input type="hidden" name="presentacion">
    <input type="hidden" name="cod_titulo"><input type="hidden" name="cod_autor"><input type="hidden" name="cod_isbn"><input type="hidden" name="cantLib">
	
	<table>
		<tr class='noimprimir'><td width="15%"></td><td width="30%"></td><td width="10%"></td><td width="24%"></td><td width="6%"></td><td width="15%"></td></tr>
		<tr class='noimprimir'><td colspan="4" class="mensajes"><?php echo($msg); ?></td></tr>
		<tr>
    		<td>Nº. Entrega:</td><td colspan="5"><span id="sprytextfield1">
			  <input name="cod_entrega" type="text" onkeyup = "upperCase(this,event)"  class="inputCodigoP" id="cod_entrega" style="border-color:#BFDBFF;border-width:1px;border-style:solid;text-align:left "value="<?php echo $row['13']; ?>" size="30" maxlength="12" />
			  <span class="textfieldRequiredMsg"></span></span>
			  <input type="submit" name="enviar" id="enviar" value="Buscar"   />
          <input type="reset" name="Limpiar" id="Limpiar" value="Limpiar" /></td>
		</tr>
  		<tr>
  		  <td>N&ordm;. Pedido:</td>
  		  <td colspan="5"><input name="pedido" type="text" class="inputCodigo" id="pedido" value="<?php echo($npedido); ?>" size="30" readonly="readonly" /></td>
		</tr>
		
        <?PHP 
			IF ($cod_cliente == '0398')
			{ 
		?>
			<tr><td>Feria :</td><td><span id="spryselect1"><input name="pedido2" type="text" class="inputCodigo" id="pedido2" value="<?php echo($ferias); ?>" size="30" readonly="readonly" /></tr>		   

          <?PHP 
			}
            ?>
		<tr>
    		<td>Vendedor:</td>
			<td colspan="5"><input name="vende" type="text" class="inputCodigo" id="vende" value="<?php echo($vende); ?>" size="30" readonly="readonly">
		    <input name="ncliente" type="hidden" id="ncliente" value="<?php echo($cod_cliente); ?>" />
            <input name="ncliente2" type="hidden" id="ncliente2" value="<?php echo($cliente); ?>" />
            </td>
		</tr>
		<tr>
    		<td>Cliente:</td>
			<td colspan="3"><input name="cod_cliente" type="text" class="inputCodigo" id="cod_cliente" value="<?php echo($cod_cliente.' '.$cliente); ?>" size="69" readonly="readonly"></td>
   			<td>Fecha:</td>
			<td><input name="fecha" type="text" class="inputCodigo" id="fecha" value="<?php echo cambiarFormatoFecha ($row[12]); ?>" size="12" readonly="readonly"></td>
		</tr>
		<tr>
			<td>Dirección:</td>
			<td colspan="5"><textarea name="direccion" COLS="92" ROWS="2" readonly="readonly" class="inputCodigo" id="direccion"><?php echo($direccion); ?></textarea></td>
		</tr>
		<tr>
    		<td>R.I.F.:</td>
			<td><input name="rif" type="text" class="inputCodigo" id="rif" value="<?php echo($rif); ?>" size="30" readonly="readonly"></td>
   			<td>Telefono:</td>
			<td colspan="3"><input name="tlf" type="text" class="inputCodigo" id="tlf" value="<?php echo($tlf); ?>" size="47" readonly="readonly"></td>
		</tr>
		<tr>
			<td>Transacción:</td>
			<td><input name="trans" type="text" class="inputCodigo" id="trans" value="<?php echo($trans); ?>" size="30" readonly="readonly"></td></td>
			<td>Contacto:</td>
			<td colspan="3"><input name="contac" type="text" class="inputCodigo" id="contac" value="<?php echo($contac); ?>" size="47" readonly="readonly"></td>
		</tr>
		<tr>
			<td>Forma de Pago:</td>
			<td colspan="5"><input name="pago" type="text" class="inputCodigo" id="pago" value="<?php echo($pago); ?>" size="30" readonly="readonly">
		    <input name="condicionMensaje" type="hidden"  class="inputCodigo2" id="vendedor3" value="<?php echo $rowMensaje["clt_envia"]; ?>" size="30" readonly="readonly" />
		    <input name="condicionCorreo" type="hidden" class="inputCodigo2" id="vendedor" value="<?php echo $rowMensaje["clt_mail_envia"]; ?>" size="30" readonly="readonly" /></td></td>
		</tr>
		<tr>
		  <td>Observaciones</td>
		  <td colspan="5"><textarea name="obserCli" cols="92" rows="2" readonly="readonly" class="inputCodigo" id="obserCli"><?php echo($obserCli); ?></textarea></td>
	  </tr>
		<tr></tr>
  	</table>
	</div>
	<?
	if ($cod_entrega != "")
	{
		$strQry1 ="	SELECT p.NOT_CODART, UCASE(l.lib_descri), UCASE(a.aut_nombre),UCASE(pr.prv_nombre),  l.lib_codsib, l.lib_codbarra,  l.lib_numedit,l.lib_present,p.NOT_PRECIO, p.NOT_CANTID,p.NOT_CANTID*p.NOT_PRECIO
					FROM inv_notaed p
					LEFT JOIN inv_libros l ON p.NOT_CODART = l.lib_codart
						LEFT JOIN inv_provee pr ON pr.prv_codpro = l.prv_codpro
					LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
					WHERE p.NOT_NUMNOT = '$cod_entrega'
					AND NOT_CANTID <> 0
					ORDER BY l.lib_descri,l.lib_codart 					
					";
		//die($strQry);
		$result1=mysql_query($strQry1,$db_distr);
		$nf1=mysql_num_rows($result1);
		echo "<div align=center><table>";
		while($row1 = mysql_fetch_array($result1))
		{
			$cod_producto=$row1[0];
			$busca_inventario="select * from tbl_inventario where cod_producto='$cod_producto'";
			$result_inventario=mysql_query($busca_inventario,$db_local);
			$nf_inventario=mysql_num_rows($result_inventario);
			if($nf_inventario==0)
			{
				$inexistentes=1;
				break;
			}
		}
		
		if($inexistentes!=0)
		{
			echo "<div align=center><table border=1>";
			echo "<tr><td colspan=4 align=center><font color=red size=5><strong>ESTOS ARTICULOS NO SE ENCUENTRAN EN EL INVENTARIO</font></strong></td></tr>";
			echo "<tr align=center><td><strong>CODIGO</strong></td><td><strong>TITULO</strong></td><td><strong>AUTOR</strong></td><td><strong>EDITORIAL</strong></td></tr>";
			
			$strQry1 ="	SELECT p.NOT_CODART, UCASE(l.lib_descri), UCASE(a.aut_nombre),UCASE(pr.prv_nombre),  l.lib_codsib, l.lib_codbarra,  l.lib_numedit,l.lib_present,p.NOT_PRECIO, p.NOT_CANTID,p.NOT_CANTID*p.NOT_PRECIO
						FROM inv_notaed p
						LEFT JOIN inv_libros l ON p.NOT_CODART = l.lib_codart
							LEFT JOIN inv_provee pr ON pr.prv_codpro = l.prv_codpro
						LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
						WHERE p.NOT_NUMNOT = '$cod_entrega'
						AND NOT_CANTID <> 0
						ORDER BY l.lib_descri,l.lib_codart 					
						";
			//die($strQry);
			$result1=mysql_query($strQry1,$db_distr);
			$nf1=mysql_num_rows($result1);
			
			while($row1 = mysql_fetch_array($result1))
			{
				$cod_producto=$row1[0];
				$busca_inventario="select * from tbl_inventario where cod_producto='$cod_producto'";
				$result_inventario=mysql_query($busca_inventario,$db_local);
				$nf_inventario=mysql_num_rows($result_inventario);
				if($nf_inventario==0)
				{
					echo "<tr><td>".$row1[0]."</td><td>".$row1[1]."</td><td>".$row1[2]."</td><td>".$row1[3]."</td></tr>";
				}
			}
			echo "<tr><td colspan=4 align=center><font color=red><strong>DEBE ACTUALIZAR EL INVENTARIO PARA CARGAR ESTOS ARTICULOS</font></strong></td></tr>";
			echo "</table></div>";
		}
	}
	?>
	
	
	
	<hr>Detalle de los Articulos (Libros)
	<div id='tabla'>
	<TABLE CELLSPACING=0 border="1" id="tabDet" name="tabDet">
		<TR class='estilotitulo'>
			<TD width='80' bgcolor="#990000">Cod. Articulo</TD> <TD width='210' bgcolor="#990000">Titulo</TD><TD width='150' bgcolor="#990000">Autor</TD>
			<TD width='150' bgcolor="#990000">Editorial</TD><TD width='52' align="center" bgcolor="#990000">ISBN</TD><TD width='12' align="center" bgcolor="#990000">Cod. Barra</TD> 
			<TD width='12' align="center" bgcolor="#990000">Tomo</TD><TD width='12' align="center" bgcolor="#990000">Presentacion</TD><TD width='60' align="center" bgcolor="#990000">Precio Unitario</TD>
			<TD width='48' align="center" bgcolor="#990000">Cant Enviada</TD><TD width='48' align="center" bgcolor="#990000">Cant Entreg</TD><TD width='70' align="center" bgcolor="#990000" >Bsf.</TD>
	  </TR>
	<?php
	if ($cod_entrega != "")
	{
		$strQry ="	SELECT p.NOT_CODART, UCASE(l.lib_descri), UCASE(a.aut_nombre),UCASE(pr.prv_nombre),  l.lib_codsib, l.lib_codbarra,  l.lib_numedit,l.lib_present,p.NOT_PRECIO, p.NOT_CANTID,p.NOT_CANTID*p.NOT_PRECIO
					FROM inv_notaed p
					LEFT JOIN inv_libros l ON p.NOT_CODART = l.lib_codart
						LEFT JOIN inv_provee pr ON pr.prv_codpro = l.prv_codpro
					LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
					WHERE p.NOT_NUMNOT = '$cod_entrega'
					AND NOT_CANTID <> 0
					ORDER BY l.lib_descri,l.lib_codart 					
					";
		//die($strQry);
		$result=mysql_query($strQry,$db_distr);
		$nf=mysql_num_rows($result);
		while($row = mysql_fetch_array($result))
		{
			
			echo("<tbody id='tbodyDet' ><tr>");
			printf("<td>%s</td> ", isset($row[0])?$row[0]:' - '); // ped_codart
			printf("<td>%s</td> ", isset($row[1])?utf8_decode($row[1]):' - '); // lib_descri
			printf("<td>%s</td> ", isset($row[2])?utf8_decode($row[2]):' - '); // aut_nombre
						printf("<td>%s</td> ", isset($row[3])?utf8_decode($row[3]):' - '); // prv_nombre
			if ($row[4] == 0) 
			{
				$row[4] = '---';
				printf("<td>%s</td> ", isset($row[4])?$row[4]:' - '); // lib_codsib
			}
			else
			{
				printf("<td>%s</td> ", isset($row[4])?$row[4]:' - '); // lib_codsib
			}

			if ($row[5] == 0) 
			{
				$row[5] = '---';
				printf("<td>%s</td> ", isset($row[5])?$row[5]:' - '); // lib_codbarra
			}
			else
			{
				printf("<td>%s</td> ", isset($row[5])?$row[5]:' - '); // lib_codbarra
			}

			if ($row[6] == '' or $row[6] == 0) 
			{
				$row[6] = '---';
				printf("<td>%s</td> ", isset($row[6])?$row[6]:' - '); // lib_numedit
			}
			else
			{
				printf("<td>%s</td> ", isset($row[6])?$row[6]:' - '); // lib_numedit
			}

			if ($row[7] == 'U') 
			{
				$row[7] = 'UNICA';
				printf("<td>%s</td> ", isset($row[7])?$row[7]:' - '); // lib_present
			}

			if ($row[7] == 'R') 
			{
				$row[7] = 'RUSTICO';
				printf("<td>%s</td> ", isset($row[7])?$row[7]:' - '); // lib_present
			}

			if ($row[7] == 'E') 
			{
				$row[7] = 'EMPASTADO';
				printf("<td>%s</td> ", isset($row[7])?$row[7]:' - '); // lib_present
			}

			printf("<td>%s</td> ", isset($row[8])?number_format($row[8],2,',','.'):'0,00'); // p.NOT_PRECIO
			printf("<td>%s</td> ", isset($row[9])?$row[9]:'0'); // p.NOT_CANTID
			$row[11] = $row[9];
			printf("<td><input type='text' onClick=this.value='' align='center' style='text-align: center' size='3' maxlength='6' value='%s' onKeyPress=\"return esNumero(event,'d',this);\" onChange='calcularPrecio2(this,2);'></td> ", isset($row[11])?$row[11]:'0'); // ped_cantide
			//printf("<td>%s</td> ", isset($cantEnt)?$cantEnt:'0'); // 
			printf("<td>%s</td> ", number_format($row[10]+(isset($cantEnt)?$cantEnt:'0'),2,',','.'));//p.NOT_CANTID*p.NOT_PRECIO
			echo("</tr></tbody>");
		}
		
		mysql_free_result($result);
		mysql_close($db_distr);
	}
	?>
	</table>
	</div>
	<Br>
	<div id='estTabTotal'>
	<TABLE id="tabTotal" name="tabTotal">
		<TR><TD width='480'></TD><TD width='50'><strong>Total</strong></TD><TD width='75'>0 Uni.</TD><TD width='125'>0,00 Bs.</TD></TR>
		<TR><TD></TD><TD colspan="2"><strong>Descuento</strong></TD>
			<TD><input type='text' align='center' id="desc" name="desc" size='5' maxlength='5' value='<?php echo($desc); ?>' class='inputCodigo' readonly /> %</TD>
		</TR>
		<TR><TD>&nbsp;</TD><TD colspan="2"><strong></strong></TD><TD>0,00 Bs.</TD></TR>
	</table>
	</div>
	<Br>
	<hr class='noimprimir'>
	<?php print "<script> calcularPrecioTotal(11); </script>"; ?>
	<div id="FormaModOperativo">
	<table>
	
	  <?
		if($inexistentes==0)
		{
	  ?>
		<tr>
		  <td width="100%" valign="top">Recepción Verificada por:</td>
		  <td colspan="2"><input name="usuario" type="text" id="usuario" value="<?php echo($usuario); ?>" size="38" readonly="readonly" /></td>
		 </tr>
		<tr>
			<td width="100%" valign="top">Observaciones:</td>
			<td colspan="2"><textarea id="observ" name="observ" COLS="85" ROWS="2"><?php echo($observ); ?></textarea></td>
		</tr>
		<tr><td colspan="4" class="mensajes" class='noimprimir'><?php echo($msg); ?><td width="100%"></td></tr>
		<tr>
			<td colspan="3" class="botones">
				<INPUT TYPE="button" VALUE="Aceptar" onClick="guardarRecepcion(fieldsFormatForm,this.form,'process_carga.php');" class='noimprimir'>
				<INPUT TYPE="button" VALUE="Limpiar" onClick="limpiarPagina('inventario.php?p=RecepcionLS');" class='noimprimir'>
			</td>
		</tr>
		<?
		}
		else
		{
	  ?>
		
		<tr><td colspan="5" align=center><strong><font size=5 color=red>NO SE PUEDE CARGAR LA NOTA DE ENTREGA</font></strong></td></tr>
		<tr><td colspan="5" align=center><strong><font size=5 color=red>SE REQUIERE ACTUALIZAR EL INVENTARIO</font></strong></td></tr>
		<?
		}
		?>
	
	</table>
	</div>
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
