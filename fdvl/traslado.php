<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<div id="navegador">
	<p>
		<SPAN class='noimprimir'>
		<a href="#">Sistema de Inventario</a> | 
		<a href="#">Módulo Operativo</a> | </SPAN>Pedido
	</p>
</div>

<?php
include("includes/functions.php");

//////////////////////////////////////////////// INICIANDO VARIABLES
$cod_pedido = isset($_POST['cod_pedido'])?$_POST['cod_pedido']:'';
$cliente = isset($_POST['cliente'])?$_POST['cliente']:'';
$direccion = isset($_POST['direccion'])?$_POST['direccion']:'';
$rif = isset($_POST['rif'])?$_POST['rif']:'';
$tlf = isset($_POST['tlf'])?$_POST['tlf']:'';
$contac = isset($_POST['contac'])?$_POST['contac']:'';
$trans = isset($_POST['trans'])?$_POST['trans']:'';
$pago = isset($_POST['pago'])?$_POST['pago']:'';
$editorial = isset($_POST['editorial'])?$_POST['editorial']:'';
$vendedor = isset($_POST['vendedor'])?$_POST['vendedor']:'';
$contacClt = isset($_POST['contacClt'])?$_POST['contacClt']:'';
$observ = isset($_POST['observ'])?$_POST['observ']:'';
$desc = isset($_POST['desc'])?$_POST['desc']:'';
$feria = isset($_POST['feria'])?$_POST['feria']:'';

$usuario=$_SESSION['datos_usuario'] ;



$msg = $_GET["msg"];
/*
if ($cod_pedido == ""){
	$link=Conectarse();
	$strQry="	SELECT MAX(SUBSTRING(ped_numped, 9, 4))
				FROM inv_pedidc
				WHERE 
					SUBSTRING(ped_numped, 3, 6) = EXTRACT(YEAR_MONTH FROM sysdate())";
	$result=mysql_query($strQry,$link);
	if($row = mysql_fetch_array($result)){
		$numpedMax = str_pad(($row[0]+1),4,"0",STR_PAD_LEFT);
	}
	$cod_pedido = "PE".date('Ym').$numpedMax;
	mysql_free_result($result);
	
	$sql= "INSERT INTO inv_pedidc (ped_numped) VALUES ('".$cod_pedido."') ";
	//echo $sql;
	$result=@mysql_query($sql,$link);
		
	mysql_close($link);
}
*/
if ($cliente != ""){
	$link=Conectarse();
	/*
	if ($cod_pedido == ""){
		$strQry="	SELECT MAX(SUBSTRING(ped_numped, 9, 4))
					FROM inv_pedidc
					WHERE 
						SUBSTRING(ped_numped, 3, 6) = EXTRACT(YEAR_MONTH FROM sysdate())";
		
		$result=mysql_query($strQry,$link);
		if($row = mysql_fetch_array($result)){
			$numpedMax = str_pad(($row[0]+1),4,"0",STR_PAD_LEFT);
		}
		$cod_pedido = "PE".date('Ym').$numpedMax;
		mysql_free_result($result);
		
		$sql= "INSERT INTO inv_pedidc (ped_numped) VALUES ('".$cod_pedido."') ";
		//echo $sql;
		$result=@mysql_query($sql,$link);
	}*/
	
	$strQry="select clt_direc, clt_rif, clt_telef, clt_contac from inv_cliente where clt_codcli = ". $cliente;
	$result=mysql_query($strQry,$link);
	if($row = mysql_fetch_array($result)){
		$direccion = utf8_decode($row[0]);
		$rif = $row[1];
		$tlf = $row[2];
		$contac = utf8_decode($row[3]);
	}
	mysql_free_result($result);
	mysql_close($link);
	
	$msg="";
}	
	 
?>



<? IF ($cliente == '0398')
{ 
?>
<script>
	////////////////////////// CAMPOS QUE SE DEBEN VALIDAR
	var fieldsFormatForm = Array(new Array('cliente', 'NO', 'SELECTED_OPTION', 'Cliente'),
								new Array('trans', 'NO', 'SELECTED_OPTION', 'Transaccion'),
     							new Array('pago', 'NO', 'SELECTED_OPTION', 'Forma de Pago'),
								new Array('feria', 'NO', 'SELECTED_OPTION', 'Feria'));
	var fieldsFormatForm2 = Array(new Array('cliente', 'NO', 'SELECTED_OPTION', 'Cliente'),
								new Array('trans', 'NO', 'SELECTED_OPTION', 'Transaccion'),
								new Array('pago', 'NO', 'SELECTED_OPTION', 'Forma de Pago'),
								new Array('feria', 'NO', 'SELECTED_OPTION', 'Feria'));
	var fieldsFormatForm3 = Array(new Array('cliente', 'NO', 'SELECTED_OPTION', 'Cliente'),
								new Array('trans', 'NO', 'SELECTED_OPTION', 'Transaccion'),
								new Array('pago', 'NO', 'SELECTED_OPTION', 'Forma de Pago'),
								new Array('feria', 'NO', 'SELECTED_OPTION', 'Feria'),
						
								new Array('vendedor', 'NO', 'SELECTED_OPTION', 'Vendedor'),
								new Array('contacClt', 'NO', 'VACIO', 'Cliente'),
								new Array('observ', 'NO', 'VACIO', 'Observaciones'));
</script>


<?
}
else
{ 
?>
<script>
	////////////////////////// CAMPOS QUE SE DEBEN VALIDAR
	var fieldsFormatForm = Array(new Array('cliente', 'NO', 'SELECTED_OPTION', 'Cliente'),
								new Array('trans', 'NO', 'SELECTED_OPTION', 'Transaccion'),
								new Array('pago', 'NO', 'SELECTED_OPTION', 'Forma de Pago'));
	var fieldsFormatForm2 = Array(new Array('cliente', 'NO', 'SELECTED_OPTION', 'Cliente'),
								new Array('trans', 'NO', 'SELECTED_OPTION', 'Transaccion'),
								new Array('pago', 'NO', 'SELECTED_OPTION', 'Forma de Pago'));
	var fieldsFormatForm3 = Array(new Array('cliente', 'NO', 'SELECTED_OPTION', 'Cliente'),
								new Array('trans', 'NO', 'SELECTED_OPTION', 'Transaccion'),
								new Array('pago', 'NO', 'SELECTED_OPTION', 'Forma de Pago'),
					
								new Array('vendedor', 'NO', 'SELECTED_OPTION', 'Vendedor'),
								new Array('contacClt', 'NO', 'VACIO', 'Cliente'),
								new Array('observ', 'NO', 'VACIO', 'Observaciones'));
</script>



<? 

}
?>










<form name="frmPedido" method="post">
<div id="FormaModOperativo">
	<input type="hidden" name="cod_libro">
	<input type="hidden" name="precio_libro">
	<input type="hidden" name="cant_libro">
<table>
  		<tr class='noimprimir'>
    		<td width="18%"></td>
			<td width="32%"></td>
   			<td width="10%"></td>
			<td width="40%"></td>
		</tr>
		<tr class='noimprimir'><td colspan="4" class="mensajes"><?php echo($msg); ?></td></tr>
		<tr>
    		<td>&nbsp;</td>
			<td>Fecha:
            <input type="text" id="fecha" name="fecha" readonly value="<?php echo date('d/m/Y'); ?>" size="12" class="inputCodigo" /></td>
   			<td colspan="2">&nbsp;</td>
		</tr>
  		<tr>
			<td>Traslado para:</td>
			<td colspan="3"><select class="selectPedido" id="cliente" name="cliente" onchange="frmPedido.submit();">
                	<option value="0" <?php if($cliente==""){echo("selected");} ?>>--Seleccione--</option>
									<?php
									$link=Conectarse();
									$result=mysql_query("select clt_codcli, rtrim(clt_nombre) from inv_cliente  WHERE clt_nombre LIKE '%LIBRERIA DEL SUR%' order by clt_nombre",$link);
									while($row = mysql_fetch_array($result)) {
										if($row[0]==$cliente){
											printf("<option value='%s' selected>%s</option> ", $row[0], utf8_decode($row[1]));
										}else{
											printf("<option value='%s'>%s</option> ", $row[0], utf8_decode($row[1]));
										}
									}
									mysql_free_result($result);
									mysql_close($link);
									?>
              		</select>
					<input type="Button" value="Buscar" onclick="buscaCliente();" class='noimprimir'> </td>
    	</tr>
		<tr>
			<td>Dirección:</td>
			<td colspan="3"><textarea name="direccion" COLS="80" ROWS="2" readonly="readonly" class="inputCodigo" id="direccion" maxlength="100"><?php echo($direccion); ?></textarea></td>
		</tr>
		<tr>
    		<td>R.I.F.:</td>
			<td><input name="rif" type="text" class="inputCodigo" id="rif" value="<?php echo($rif); ?>" size="30" readonly="readonly"></td>
   			<td>Telefono:</td>
			<td><input name="tlf" type="text" class="inputCodigo" id="tlf" value="<?php echo($tlf); ?>" size="30"></td>
		</tr>
		<tr>
    		<td>Contacto:</td>
			<td><input name="contac" type="text" class="inputCodigo" id="contac" value="<?php echo($contac); ?>" size="30" readonly="readonly"></td>
   			<td>Transacción:</td>
			<td><span id="spryselect2">
			  <select id="trans" name="trans">
			    <option value="0" <?php if($trans==""){echo("selected");} ?>>--Seleccione--</option>
			    <?php
									$link=Conectarse();
									$result=mysql_query("select trs_codtrs, rtrim(trs_descrip) from inv_transac where trs_tiptrs='S' order by trs_codtrs",$link);
									while($row = mysql_fetch_array($result)) {


										if($row[0]==$trans){
											printf("<option value='%s' selected>%s - %s</option> ", $row[0],$row[0], utf8_decode($row[1]));
										}else{
											printf("<option value='%s'>%s - %s</option> ", $row[0],$row[0], utf8_decode($row[1]));
										}
									}
									mysql_free_result($result);
									mysql_close($link);
									?>
		    </select>
		    <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
		</tr>
		<tr>
    		<td>Forma de Pago:</td>
			<td><span id="spryselect3">
			  <select id="pago" name="pago">
			    <option value="0" <?php if($pago==""){echo("selected");} ?>>--Seleccione--</option>
			    <?php
									$link=Conectarse();
									$result=mysql_query("select con_codigo, rtrim(con_descri) from inv_condic order by con_codigo",$link);
									while($row = mysql_fetch_array($result)) {
										if($row[0]==$pago){
											printf("<option value='%s' selected>%s - %s</option> ", $row[0],$row[0], utf8_decode($row[1]));
										}else{
											printf("<option value='%s'>%s - %s</option> ", $row[0],$row[0], utf8_decode($row[1]));
										}
									}
									mysql_free_result($result);
									mysql_close($link);
									?>
		    </select>
  <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                    <?PHP IF ($cliente == '0398')
					{ 
?>
                    
			<td>Feria :</td>
		  <td><span id="spryselect1">
		  <select id="feria" name="feria">
			    <option value="0" <?php if($feria==""){echo("selected");} ?>>--Seleccione--</option>
			    <?php
									$link=Conectarse();
									$result=mysql_query("select rtrim(feria_descrip) , feria_tipo from inv_feria WHERE TIPO = 'N' order by feria_descrip",$link);
									while($row = mysql_fetch_array($result)) {
										if($row[0]==$feria){
											printf("<option value='%s' selected>%s - %s</option> ", $row[0],$row[0], utf8_decode($row[1]));
										}else{
											printf("<option value='%s'>%s - %s</option> ", $row[0],$row[0], utf8_decode($row[1]));
										}
									}
								
								
									
									mysql_free_result($result);
									mysql_close($link);
									?>
		    </select>
		    <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
            <input name="tipo" type="hidden" value="N" />
            <?PHP 
            
}

            ?>
            
            
             <?PHP IF ($cliente == '0851')
					{ 
?>
                    
			<td>Feria :</td>
			<td><span id="spryselect1">
			  <select id="feria" name="feria">
			    <option value="0" <?php if($feria==""){echo("selected");} ?>>--Seleccione--</option>
			    <?php
									$link=Conectarse();
									$result=mysql_query("select rtrim(feria_descrip) , feria_tipo from inv_feria WHERE TIPO = 'I' order by feria_descrip",$link);
									while($row = mysql_fetch_array($result)) {
										if($row[0]==$feria){
											printf("<option value='%s' selected>%s - %s</option> ", $row[0],$row[0], utf8_decode($row[1]));
										}else{
											printf("<option value='%s'>%s - %s</option> ", $row[0],$row[0], utf8_decode($row[1]));
										}
									}
								
								$tipo = 'I';
								
									mysql_free_result($result);
									mysql_close($link);
									?>
		    </select>
		    <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
            <input name="tipo" type="hidden" value="I" />

            <?PHP 
            
}

            ?>
            
		</tr>
  	</table>
</div>

<hr class='noimprimir'>

<SPAN class='noimprimir'>Busqueda de Articulos</SPAN>

<div id="FormaModOperativo">
	<input type="hidden" name="accion">
	<table>
		<tr>
			<td>Editorial:</td>
			<td><span id="spryselect4">
			  <select class="selectPedido" id="editorial" name="editorial" onclick="buscaProveedorP(fieldsFormatForm,this.form,0);">
			    <option value="0" <?php if($editorial==""){echo("selected");} ?>>--Seleccione--</option>
			    <?php
					$link=Conectarse();
					$result=mysql_query("select prv_codpro, prv_nombre from inv_provee order by prv_nombre",$link);
					while($row = mysql_fetch_array($result)) {
						if($row[0]==$editorial){
							printf("<option value='%s' selected>%s</option>", $row[0], utf8_decode($row[1]));
						}else{
							printf("<option value='%s'>%s</option>", $row[0], utf8_decode($row[1]));
						}
					}
					mysql_free_result($result);
					mysql_close($link);
				?>
		    </select>
			  <span class="selectRequiredMsg">Seleccione un elemento.</span></span>			  <INPUT TYPE="button" VALUE="Buscar"  onclick="buscaProveedorP(fieldsFormatForm,this.form,1);"  class='noimprimir'>
			</td>
		</tr>
		<tr><td colspan="2"></td></tr>
		<tr>
			<td colspan="2" align="center">
				<INPUT TYPE="button" VALUE="Buscar Articulo"  onclick="buscaArticulo_traslado(fieldsFormatForm2,editorial.value);" class='noimprimir'>
			</td>
		</tr>
	</table>
</div>

<hr>

Detalle de los Articulos (Libros) a solicitar

<div id='tabla'>
	<TABLE CELLSPACING=0 border="1" id="tabDet" name="tabDet">
		<TR class='estilotitulo'>
			<TD width='80'>Cod. Articulo</TD> 
			<TD width='230'>Titulo</TD>
			<TD width='150'>Autor</TD>
			<TD width='55'>Numero de Tomo</TD> 			
			<TD width='15'>P</TD> 
			<TD width='60'>Precio Unitario</TD>
			<TD width='55'>Cantidad</TD>
			<TD width='70'>Precio Exten.</TD>
			<TD width='15' class='noimprimir'>Eli</TD>
		</TR>
	</table>
</div>
<TABLE>
	<TR>
		<TD>
			<INPUT TYPE="button" VALUE="Eliminar seleccionados"  onclick="elimArticulos();" class='noimprimir'>
		</TD> 
	</TR>
</table>
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
			<TD><input type='text' id="desc" name="desc" size='5' maxlength='5' value='0,0' onKeyPress="return esNumero(event,'f',this);" onChange='calcularTotalGeneral();'> %</TD>
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

<div id="FormaModOperativo">
	<table>
	<tr>
		<td width='80'>Vendedor:
	    

        <input type="hidden" name="usuario" value="<?php echo($usuario); ?>"  id="usuario" /></td>
		
        
        
        <td width='350'><span id="spryselect5">
		  <select id="vendedor" name="vendedor">
		    <option value="0" <?php if($vendedor==""){echo("selected");} ?>>--Seleccione--</option>
		    <?php
								$link=Conectarse();
								$result=mysql_query("select ven_codven, rtrim(ven_nombre) from inv_vende order by ven_codven",$link);
								while($row = mysql_fetch_array($result)) {
									if($row[0]==$vendedor){
										printf("<option value='%s' selected>%s - %s</option> ", $row[0],$row[0], utf8_decode($row[1]));
									}else{
										printf("<option value='%s'>%s - %s</option> ", $row[0],$row[0], utf8_decode($row[1]));
									}
								}
								mysql_free_result($result);
								mysql_close($link);
								?>
	      </select>
	    <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
		<td width='60'>Cliente:</td>
		<td width='220'><input type="text" id="contacClt" name="contacClt" value="<?php echo($contacClt); ?>" size="30"></td>
	</tr>
	<tr>
		<td>Observaciones:</td>
		<td colspan="3"><textarea id="observ" name="observ" COLS="90" ROWS="2" maxlength="100"><?php echo($observ); ?></textarea></td>
	</tr>
	<tr><td colspan="4" class="mensajes" class='noimprimir'><?php echo($msg); ?></td></tr>
	<tr>
		<td colspan="4" class="botones">
			<INPUT TYPE="button" VALUE="Guardar" onClick="guardarPedido(fieldsFormatForm3,this.form,'process_pedido.php');" class='noimprimir'>
			<INPUT TYPE="button" VALUE="Limpiar" onClick="limpiarPagina('inventario.php?p=pedido');" class='noimprimir'>
		</td>
	</tr>
	</table>
</div>
</form>
<p>&nbsp;</p>

<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var spryselect5 = new Spry.Widget.ValidationSelect("spryselect5");
//-->
</script>
