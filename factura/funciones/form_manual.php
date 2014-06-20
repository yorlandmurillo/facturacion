<?
function form_ventas_manual($vendedor,$sucursal,$cliente,$tipo)
{
	include_once("manejadordb.php");
	$factura=new factura();
	$rec=new reconversion();
	$codigo=$factura->codigo($vendedor,$sucursal,$cliente,$tipo);
	$_SESSION['factura']=$codigo;
	//Se buscan los datos del cliente
	$obj=new manejadordb;
	$sql=$obj->consultar_remoto("SELECT * FROM tbl_cliente where cli_cedula='".$_GET['cliente']."' ");//Se conecta al servidor remoto
	$clientes=mysql_fetch_array($sql);
	$cedula=$clientes['cli_cedula'];
	$nombre=$clientes['cli_nombre'];
	$direccion=$clientes['cli_direccion'];
	$telefono=$clientes['cli_telefonohab'];
	$correo=$clientes['cli_correo'];
	$empresa=$clientes['cli_empresa'];
	$year=date('Y');
	$month=date('m');
	$day=date('d');
	
	$fecha_actual=$year."-".$month."-".$day;
	//Datos de la factura
	$sql=$obj->consultar("SELECT fecha_factura,codfacturamanual,numtalonario FROM tbl_facturas where cod_factura='".$codigo."' ");//Se conecta al servidor local
	$talonario=mysql_fetch_array($sql);
	$fecha_factura=substr($talonario['fecha_factura'], 0, 10);
	$codfacturamanual=$talonario['codfacturamanual'];
	$numtalonario=$talonario['numtalonario'];
	
	?>
	<link href="Styles/indes.css" rel="stylesheet" type="text/css" />
	
	<form name="talonario">
	<input type="hidden" name="codfactura" value="<? echo $codigo;?>"/>
	<input type="hidden" name="sucursal" value="<? echo $_SESSION['usuario_sucursal'];?>"/>
	<input type="hidden" name="pagina" value="<? echo $_GET['pagina'];?>"/>
	<input type="hidden" name="tipo" value="<? echo $_GET['tipo'];?>"/>
	<input type="hidden" name="cliente" value="<? echo $_GET['cliente'];?>"/>
	<input type="hidden" name="fecha_actual" value="<? echo $fecha_actual;?>"/>
	
	<tr><td colspan="6" align="center"><strong>IDENTIFICACI&Oacute;N DEL TALONARIO</strong></td></tr>
	<?
		if($fecha_factura!='0000-00-00')
		{
			$fecha2=explode("-", $fecha_factura);
			$fecha=$fecha2[2]."/".$fecha2[1]."/".$fecha2[0];
			?>
			<tr align="center"><td  colspan="6" bgcolor="yellow"><font size=4 color="#610B0B"><b><? echo "FECHA GUARDADA DEL TALONARIO:".$fecha." -*-*-*-*-*- CODIGO FACTURA: ".$codfacturamanual." -*-*-*-*-*- NUMERO DE CONTROL: ".$numtalonario; ?></b></font></td></tr>
			<?
		}
	?>
	<tr>
		  <td width="120" class="celdac" ><strong>Fecha Manual:</strong></span></td>
		  <td width="187" class="celdac" align="left" >
		  <input type="text" name="fecfacturamanual" id="fecfacturamanual" value="<? if(!empty($fecha_factura))echo $fecha_factura; ?>" size="10" readonly="true"/>
		  <img src="imagenes/calendar.png" id="trigger3" style="cursor: pointer; border: 0px solid red;" title="Selector de fecha" onmouseover="this.style.background='white'" onmouseout="this.style.background=''" />
			<script type='text/javascript'>
			  Calendar.setup(
				{
					inputField  : 'fecfacturamanual',         
					 align          :    'Tr',
					 singleClick    :    false,
					 ifFormat    : '%Y-%m-%d',    
					 button      : 'trigger3'     
				}
			);
			</script>
		
		</td>
		<td colspan="2" align="left"><strong>Codigo Fac. Manual:</strong><input type="text" size="10" maxlength="10" name="codfacturamanual" value="<? if(!empty($codfacturamanual))echo $codfacturamanual; ?>" onblur="validarcodfacturamanual(this)" id="codfacturamanual"/></td>
		<td colspan="2" align="left"><strong>Nro. Control:</strong><input type="text" size="10" maxlength="10" name="ncontrol" value="<? if(!empty($numtalonario))echo $numtalonario; ?>" onblur="validarncontrol(this)" id="ncontrol"/></td>
	</tr>
	<tr>
	<td colspan="6" align="center"><input name="actualiza_talonario" type="button" value="Actualiza Talonario" onClick="actualizatalonario();muestraviso()" class="boton" style="display:compact;"/></td>
	</tr>
	</form>
	
<form name="ventas" id="ventas" action="">
	<input type="hidden" name="fecfacturamanual" value="<? if(!empty($fecha_factura))echo $fecha_factura; ?>"/>
	<input type="hidden" name="codfacturamanual" value="<? if(!empty($codfacturamanual))echo $codfacturamanual; ?>"/>
	<input type="hidden" name="ncontrol" value="<? if(!empty($numtalonario))echo $numtalonario; ?>"/>
	
	<tr>
		  <td align="left"><font size="4"><strong>Facturacion Manual</strong></font></td>
		  <td colspan="2" align="right" class="celdac"><!--<strong>N&deg; Factura: </strong>--></span></td>
		  <td colspan="2" class="celdac" align="left"><input type="hidden" name="codfactura" value= "<? echo $codigo; ?>" readonly="true" /></td>
		  <td align="left"><strong>Tipo de Factura:</strong><select name="tipofactura" id="tipofactura" > <option value="3" selected="selected">Manual</option></select></td>
	</tr>
	<tr><td colspan="6" class="celdac"><strong>DATOS DEL CLIENTE</strong></td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td class="celdac">C&eacute;dula o RIF:</td>
		<td class="celdac" align="left"><input type="text" name="cliente" size="12" maxlength="15" onKeyUp="validarnum(this,1)" value="<?echo $cedula; ?>" readonly="true">&nbsp;<a href="consultas/clientes.php" class="boton"></a></td>
		<td class="celdac" align="right">Nombre:</td>
		<td class="celdac" align="left"><input type="text" name="nombrecl" size="30" maxlength="50" value="<?echo $nombre; ?>" readonly="true"></td>
		<td class="celdac" align="right">Tel&eacute;fono:&nbsp;</td>
		<td class="celdac" align="left"><input type="text" name="telefonocl" size="20" maxlength="20" value="<?echo $telefono; ?>" readonly="true"></td>
	</tr>
	<tr>
		<td class="celdac" align="right">Direcci&oacute;n:</td>
		<td class="celdac" align="left"><input type="text" name="direccioncl" size="30" maxlength="50" value="<?echo $direccion; ?>" readonly="true"></td>
		<td class="celdac" align="right">Empresa:</td>
		<td class="celdac" align="left"><input type="text" name="empresacl" size="30" maxlength="50" value="<?echo $empresa; ?>" readonly="true"></td>
		<td class="celdac" align="right">E-Mail:&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td class="celdac" align="left"><input type="text" name="correocl" size="30" maxlength="50" value="<?echo $correo; ?>" readonly="true"></td>
	</tr>

	<?

	formapago_m();
	?>
	</form>
	<?
}
function formapago_m()
{
	include_once("manejadordb.php");
	//creamos el objeto $obj de la clase cEmpleado
	$obj=new manejadordb;
	$fact=$_SESSION['factura'];
	$user=$_SESSION['usuario_sucursal'];
	$id_user=$_SESSION['usuario_id'];
	$pago1="select * from tbl_itemfactura where cod_factura='$fact' and sucursal='$user' and vendedor='$id_user' and estatus_cancelacion=0;";
	$lista= $obj->consultar($pago1);
	$i=0;
	$monto_iva_total=0;
	while($row = mysql_fetch_array($lista)){
		$monto_iva_total+=($row['precio_unid']*$row['cantidad'])*$row['iva'];
		$i++;
	}
?>

	<tr><td colspan="6" class="style4" align="center"><strong>Detalle de la Factura </strong></td></tr>
	<tr>
		<td colspan="6" width="120" height="10" class="celdac">&nbsp;&nbsp;Cantidad: </strong></span>
			<input type="text" name="cantidad" size="3" maxlength="3" value="1"><a href="#" onclick="mas(); return false"><img src="imagenes/add.png" border="0"></a><a href="#" onclick="menos(); return false"><img src="imagenes/del.png" border="0"></a><strong>&nbsp;&nbsp;Codigo: </strong></span>
			<input type="text" name="codproducto" size="15" maxlength="50" onkeypress="iSubmitEnter(event,document.ventas)" />
			<input name="additemf" type="button" class="boton" onclick="agregaritem()" value="Agregar"/>
			<input name="titulos" type="button" class="boton" onclick="ventana('consultas/titulos.php','buscar')" value="Buscar"/>
		</td>
	</tr>
	<tr><td colspan="6"><div id="contenidos"></div></td></tr>
	<tr><th width="85" height="10" colspan="4"></th></tr>
	<tr>
		<th width="85" height="10" colspan="4" class="celdad" align="right">Sub-Total: </th>
		<th width="85" height="10" colspan="4" class="celdad" align="right">
			<input type="text" name="subtotal" size="15" maxlength="50" readonly="true" value="
				<?
				$pago="SELECT sum(precio_unid*cantidad) AS suma 
				FROM tbl_itemfactura 
				where cod_factura='$fact' 
				and sucursal='$user' 
				and vendedor='$id_user' 
				and estatus_cancelacion=0";

				$m=$obj->consultar($pago);
				$monto=mysql_fetch_array($m);
				if($monto['suma']==0)$monto=0;echo number_format(round($monto['suma'],4),2,',','.');?>" class="campo"/> 


			<input type="hidden" name="subtotal1" value="
				<?
				/*$fact=$_SESSION['factura'];
				$user=$_SESSION['usuario_sucursal'];
				$id_user=$_SESSION['usuario_id'];*/

				$pago="SELECT sum(precio_unid*cantidad) AS suma 
				FROM tbl_itemfactura 
				where cod_factura='$fact' 
				and sucursal='$user' 
				and vendedor='$id_user' 
				and estatus_cancelacion=0";

				$m=$obj->consultar($pago);
				$monto=mysql_fetch_array($m);
				if($monto['suma']==0)$monto=0;echo round($monto['suma'],4);?>"/> 
		</th>
	</tr>
	<tr>
		<?
		$i=$obj->consultar("SELECT  * FROM tbl_iva where id_iva=2;");
		$iva=mysql_fetch_array($i);
		?>
		<th width="85" height="10" colspan="4" class="celdad" align="right">IVA <? echo $iva['valor']*100;?>%:<input type="hidden" name="porcentajeiva" value="<? echo $iva['valor'];?>"/> </th>
		<th width="85" height="10" colspan="4" class="celdad" align="right">
			<input type="text" name="totaliva" size="15" maxlength="50" readonly="true" value="
			<?
			$t_iva=$monto_iva_total;/*$monto['suma']*$iva['valor'];*/
			if($t_iva=="")$t_iva=0;echo  number_format(round($t_iva,4),2,',','.');?>" class="campo" /> 

			<input type="hidden" name="mtoiva" value="
			<?
			round($monto_iva_total,2);
			if($t_iva=="")$t_iva=0;echo round($t_iva,4); ?>"/> 
		</th>
	</tr>
	<tr>
		<th width="85" height="10" colspan="4" class="celdad" align="right">Total Cancelar: </th>
		<th width="85" height="10" colspan="4" class="celdad" align="right">
			<input type="hidden" name="totalcancelar1" value="
			<?
			$i=$obj->consultar("SELECT  * FROM tbl_iva");$iva=mysql_fetch_array($i);
			if($monto['suma']==0)$monto=0;echo round($monto['suma']+$monto_iva_total,4); ?>" class="campo"/> 

			<input type="text" name="totalcancelar" size="15" maxlength="50" readonly="true" value="
			<?
			$i=$obj->consultar("SELECT  * FROM tbl_iva");
			$iva=mysql_fetch_array($i);
			if($monto['suma']==0)$monto=0;echo  number_format(round($monto['suma']+$monto_iva_total,4),2,',','.'); ?>" class="campo"> 
		</th>
	</tr>
	<tr>
		<th width="85" height="10" colspan="4" class="celdad" align="right">Cantidad de Libros: </th>
		<th width="85" height="10" colspan="4" class="celdad" align="right">
		<input type="text" name="totalcancelar" size="15" maxlength="50" readonly="true" value="
		<?
		/*$fact=$_SESSION['factura'];
		$user=$_SESSION['usuario_sucursal'];
		$id_user=$_SESSION['usuario_id'];*/
		$pago3="SELECT sum(cantidad) AS cantidad FROM tbl_itemfactura where cod_factura='$fact' and sucursal='$user' and vendedor='$id_user' and estatus_cancelacion=0";
		$cant=$obj->consultar($pago3);
		$items=mysql_fetch_array($cant);
		if($items['cantidad']==0)$cantidad=0; else $cantidad=$items['cantidad']; echo  $cantidad; ?>" class="campo"> 

		</th>
	</tr>
	<tr><th  height="10" colspan="6" class="celdad" align="right">PRESIONE LA TECLA [F5] PARA ACTUALIZAR LA FACTURA</th></tr>
	<tr><th  height="10" colspan="6" class="celdad">Forma de Pago</th></tr>
	<tr><th  height="10" colspan="6" class="celdad"></th></tr>
	<tr>
		<th height="5" class="celda" align="left"><font size="1">Monto Efectivo</font></th>
		<th height="5" class="celda" align="left"><font size="1">Monto Tarj. D&eacute;bito</font></th>
		<th height="5" class="celda" align="left"><font size="1">Monto Tarj. Cr&eacute;dito</font></th>
		<th height="5" class="celda" align="left"><font size="1">Monto BonoLibro</font></th>
		<th height="5" class="celda" align="left"><font size="1">Monto Especial</font></th>
		<th height="5" class="celda" align="left"><font size="1">Otra Moneda</font></th>
	</tr>
	<tr>
		<th height="5" class="celdal" align="left"><input type="text" name="montoefectivo" value="0" size="10" class="campo" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)" onclick="quitarcero('montoefectivo')" onDblClick="pordefecto('montoefectivo')"></th>
		<th height="5" class="celdal" align="left"><input type="text" name="montotdb" value="0" size="14" class="campo" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)" onclick="quitarcero('montotdb')" onDblClick="pordefecto('montotdb')" readonly="true"></th>
		<th height="5" class="celdal" align="left"><input type="text" name="montotdc" value="0" size="14" class="campo" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)" onclick="quitarcero('montotdc')" onDblClick="pordefecto('montotdc')" readonly="true"></th>
		<th height="5" class="celdal" align="left"><input type="text" name="montobl" value="0" size="15" class="campo" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)" onclick="quitarcero('montobl')" onDblClick="pordefecto('montobl')" readonly="true"></th>
		<th height="5" class="celdal" align="left"><input type="text" name="montoesp" value="0" size="15" class="campo" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)" onclick="quitarcero('montoesp')" onDblClick="pordefecto('montoesp')" readonly="true"></th>
		<th height="5" class="celdal" align="left"><input type="text" name="otromonto" value="0" size="15" class="campo" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)" onclick="quitarcero('otromonto')" onDblClick="pordefecto('otromonto')" readonly="true"></th>
	</tr>
	<tr><th  height="10" colspan="6" class="celdad"></th></tr>

	<tr>
		<th height="5" class="celda" align="left"><font size="1">Monto Cheque</font></th>
		<th height="5" class="celda" align="left"><font size="1">Nro. Cheque</font></th>
		<th height="5" class="celda" align="left"><font size="1">Nro. Cuenta</font></th>
		<th height="5" class="celda" align="left"><font size="1">Banco</font></th>
		<th height="5" class="celda" align="left"><font size="1">Nro. Conformaci&oacute;n</font></th>
		<th height="5" class="celda" align="left"><font size="1">Cesta Ticket</font></th>
	</tr>
	<tr>
		<th height="5" class="celdal" align="left"><input type="text" name="montocheque" value="0" size="10" class="campo" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)" onclick="quitarcero('montocheque')" onDblClick="pordefecto('montocheque')" readonly="true"></th>
		<th height="5" class="celdal" align="left"><input type="text" name="nrocheque" value="0" size="14" class="campo" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)" onclick="quitarcero('nrocheque')"></th>
		<th height="5" class="celdal" align="left"><input type="text" name="nrocuenta" value="0" size="14" class="campo" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)" onclick="quitarcero('nrocuenta')"></th>
		<th height="5" class="celdal" align="left">
			<?
			$bancos= $obj->consultar("select * from tbl_bancos order by id_tbl_bancos");
			?>
			<select name="bancos" id="bancos">
				<?
				while($bco = mysql_fetch_array($bancos)){
				?>
					<option value="<?echo $bco['id_tbl_bancos'];?>"><?echo $bco['banco'];?></option>
				<?
				}
				?>
			</select>
		</th>
		<th height="5" class="celdal" align="left"><input type="text" name="nroconformacion" value="0" size="15" class="campo" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)" onclick="quitarcero('nroconformacion')"></th>
		<th height="5" class="celdal" align="left"><input type="text" name="cestaticket" value="0" size="15" class="campo" onkeyup="validarnum(this,1)" onchange="validarnum(this,1)" onclick="quitarcero('cestaticket')" onDblClick="pordefecto('cestaticket')" readonly="true"></th>
	</tr>
	<tr>
		<th>Cambio:</th><th colspan="2" align="left"><input type="text" name="montocambio" value="0" size="15" readonly="true"/><input name="calcular" type="button" value="Calcular"  onClick="calcularcambio()" class="boton"/><input type="hidden" name="vendedor" value="<? echo $_SESSION['usuario_id'];?>"/> <input type="hidden" name="sucursal" value="<? echo $_SESSION['usuario_sucursal'];?>"/></th>
		<th colspan="3" align="right"><input name="Aceptar" type="button" value="Aceptar"  onClick="aceptarfactura()" class="boton" style="display:compact;"/><input name="Cancelar" type="button" value="Cancelar" onClick="cancela_factura()" class="boton" /></th>
	</tr>
	<tr><th colspan="6"><div id="resultado"></div></th></tr>
<?

}
?>
