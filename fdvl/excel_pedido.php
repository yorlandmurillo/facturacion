<?php
	session_start();
	include("includes/conexion.php");
	
	$servidor  = $_SESSION['server_name'];
	$link=conectarse();
	
	$cod_pedido=$_POST['cod_pedido'];
	$fecha=$_POST['fecha'];
	$cliente=$_POST['cliente'];
	$vendedor=$_POST['vendedor'];
	$trans=$_POST['trans'];
	$pago=$_POST['pago'];
	$contacClt=$_POST['contacClt'];
	$observ=$_POST['observ'];
	$desc=$_POST['desc'];
	
	$cod_libros=$_POST['cod_libro'];
	$precio_libros=$_POST['precio_libro'];
	$cant_libros=$_POST['cant_libro'];
	
	$editorial=$_POST['editorial'];
	
	$nomCliente = '';
	$direccion ='';
	$rif ='';
	$tlf ='';
	$contac =''; 
	$transDesc ='';
	$pagoDesc ='';
		
	//echo ($precio_libros);
	$cod_libro = explode(',',$cod_libros);
	$precio_libro = explode('+',$precio_libros);
	$cant_libro = explode(',',$cant_libros);

	$strQry="	SELECT c.clt_nombre, c.clt_direc, c.clt_rif, c.clt_telef, c.clt_contac, p.prv_nombre, t.trs_descrip, cp.con_descri, v.ven_nombre
				FROM inv_cliente c, inv_provee p, inv_transac t, inv_condic cp, inv_vende v
				WHERE c.clt_codcli = '". $cliente."' 
				AND p.prv_codpro='". $editorial."'
				AND t.trs_codtrs='". $trans."'
				AND cp.con_codigo='". $pago."'
				AND v.ven_codven='". $vendedor."'";
	$result=mysql_query($strQry,$link);
	if($row = mysql_fetch_array($result)){
		$nomCliente = utf8_decode($row[0]);
		$direccion = utf8_decode($row[1]);
		$rif = $row[2];
		$tlf = $row[3];
		$contac = utf8_decode($row[4]);
		$editorial = utf8_decode($row[5]);
		$transDesc = utf8_decode($row[6]);
		$pagoDesc = utf8_decode($row[7]);
		$vendedor = utf8_decode($row[8]);
	}
	mysql_free_result($result);
	
	/*$trans = utf8_decode($row[5]);
	$desc = number_format($row[7],2,',','.');
		$vende = utf8_decode($row[8]);
		$obserCli = utf8_decode($row[9]);
		$pago = utf8_decode($row[10]);*/
	
	header("Content-Type: application/vnd.ms-excel ");
	header("Content-Disposition: attachment; filename=".$cod_pedido.".xls");
?> 

<table border=0>
	<tr height='60'>
		<td><img src="<?php echo $servidor; ?>/inventario/images/cabecera.jpg" width='630' height='60'></td>
	</tr>
	<tr height='100'>
		<td><img src="<?php echo $servidor; ?>/inventario/images/logolateral.jpg" width='150' height='100'></td>
		<TD></TD><TD></TD><TD></TD><TD></TD><TD></TD>
		<td><img src="<?php echo $servidor; ?>/inventario/images/filven6.jpg" width='110' height='100'></td>
	</tr>
	<tr><TD></TD></tr>
	<tr><TD>Nº. Pedido:</TD><TD><strong><?php echo $cod_pedido; ?></strong></TD>
		<TD>Fecha: <strong><?php echo $fecha; ?></strong></TD></tr>
	<tr><TD>Cliente:</TD><TD colspan="4"><strong><?php echo $nomCliente; ?></strong></TD></tr>
	<tr><TD>Dirección:</TD><TD colspan="7"><strong><?php echo $direccion; ?></strong></TD></tr>
	<tr><TD>R.I.F.:</TD><TD><strong><?php echo $rif; ?></strong></TD>
		<TD colspan="6">Telefono: <strong><?php echo $tlf; ?></strong></TD></tr>
	<tr><TD>Contacto:</TD><TD><strong><?php echo $contac; ?></strong></TD>
		<TD colspan="6">Transacción: <strong><?php echo $trans.' - '.$transDesc; ?></strong></TD></tr>
	<tr><TD colspan="3">Forma de Pago: <strong><?php echo $pago.' - '.$pagoDesc; ?></strong></TD></tr>
	<tr><TD></TD></tr>
	<tr><TD>Editorial:</TD><TD colspan="7"><strong><?php echo $editorial; ?></strong></TD></tr>
	<tr><TD></TD></tr>
	<tr bgcolor="#eeeeee">
		<TD width='90'><strong><font size="2" color="#990000">Cod. Articulo</font></strong></TD> 
		<TD width='150'><strong><font size="2" color="#990000">Titulo</font></strong></TD> 
		<TD width='150'><strong><font size="2" color="#990000">Autor</font></strong></TD> 
		<TD width='55'><strong><font size="2" color="#990000">Num Tomo</font></strong></TD> 		
		<TD width='15'><strong><font size="2" color="#990000">P</font></strong></TD> 
		<TD width='60'><strong><font size="2" color="#990000">Precio Unitario</font></strong></TD> 
		<TD width='40'><strong><font size="2" color="#990000">Cant.</font></strong></TD> 
		<TD width='70'><strong><font size="2" color="#990000">Precio Exten.</font></strong></TD> 
	</tr>
	
	<?php
	$n=14;
	for ($i=0;$i<count($cod_libro);$i++) {
		echo "<tr>";
		echo "<TD><font size='2'># ".$cod_libro[$i]."</font></TD> ";
		$strQry="	SELECT l.lib_descri, a.aut_nombre, l.lib_numedit, l.lib_present, l.lib_preact
					FROM inv_libros l
					LEFT JOIN inv_autor a ON l.aut_codigo = a.aut_codigo
					WHERE l.lib_codart = '". $cod_libro[$i]."'";
		//echo $strQry;
		$result=mysql_query($strQry,$link);
		if($row = mysql_fetch_array($result)){
			echo "<TD><font size='2'>".(isset($row[0])?utf8_decode($row[0]):' - ')."</font></TD> ";
			echo "<TD><font size='2'>".(isset($row[1])?utf8_decode($row[1]):' - ')."</font></TD> ";
			echo "<TD><font size='2'>".(isset($row[2])?$row[2]:' - ')."</font></TD> ";
			echo "<TD><font size='2'>".(isset($row[3])?$row[3]:' - ')."</font></TD> ";
		}
		echo "<TD><font size='2'>".$precio_libro[$i]."</font></TD> ";
		echo "<TD><font size='2'>".$cant_libro[$i]."</font></TD> ";
		echo "<TD><font size='2'>=F".($i+$n)."*G".($i+$n)."</font></TD> ";
		echo "</tr>";
		mysql_free_result($result);
	}
	$m=$n+count($cod_libro);
	mysql_close($link);
	?> 
	<tr><TD></TD></tr>
	<tr><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD>Total:</TD><TD><strong><?php echo ("=SUMA(G".$n.":G".$m.")"); ?></strong></TD>
																	<TD><strong><?php echo ("=SUMA(H".$n.":H".$m.")"); ?></strong></TD></tr>
	<tr><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD>% Desc:</TD><TD></TD><TD><strong><?php echo number_format($desc,2,',','.'); ?></strong></TD></tr>
	<tr><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD>Total General:</TD><TD></TD><TD><strong><?php echo ("=H".($m+1)."*(1-(H".($m+2)."/100))"); ?></strong></TD></tr>
	<tr><TD></TD></tr>
	<tr><TD>Vendedor:</TD><TD><strong><?php echo $vendedor; ?></strong></TD>
		<TD>Cliente: <strong><?php echo $contacClt; ?></strong></TD></tr>
	<tr><TD colspan="8">Observaciones: <strong><?php echo $observ; ?></strong></TD></tr>
	</table>
