<?php
include 'conec.php';
$nota_entrega=str_replace(".xls", "", $_GET[arch]);
$id_sucursal=$_GET[id_suc];
$carganota=$_GET[carganota];
$numsolicitud=$_GET[numsolicitud];
$traslado=$_GET[traslado];
?>
<script type="text/javascript">
//var ck_observacioines = /^[A-Za-z0-9 ]{3,100}$/;

function validate(form)
{
	var observaciones = form.observaciones.value;
	var libreria_cliente = form.libreria_cliente.value;
	var id_sucursal=form.id_sucursal.value;
	var nombresucursal=form.nombresucursal.value;
	var libros_faltantes=form.libros_faltantes.value;
	var actualiza=form.actualiza.value;
	
	 if(observaciones=='')
	 {
		alert("Por favor escriba las observaciones de la carga de la nota de entrega.\nSi todo esta bien, escriba Ok");
		return false;
	 }
	 else
	 {
		if(libros_faltantes=='')
		{
			
			confirmar=confirm("La nota de entrega fue hecha para "+libreria_cliente+" y usted se encuenta en "+id_sucursal+" - "+nombresucursal+"\n¿Desea continuar?");
			if (confirmar)
			{
				return true;
			}
			else
			{
				return false;
			}
			
		}
		else
		{
			alert("No se puede cargar la nota de entrega sin actualizar el listado de libros\n"+libros_faltantes);
			return false
		}
	}
 
 }
 
</script>
<?

if($id_sucursal!='')
{
	$sql_buscasucural="select sucursal from tbl_sucursal where id_sucursal='$id_sucursal'";
	$result_buscasucural=mysql_query($sql_buscasucural);
	$nf_buscasucural=mysql_num_rows($result_buscasucural);
	if($nf_buscasucural>0)
	{
		while($row = mysql_fetch_row($result_buscasucural))
		{
			$sucursal=$row[0];
		}
	}
}
	
if($_POST['submit'])
{
	$renglon=explode("-",$_POST['libreria']);
	$libreria_carga=$_POST['libreria'];
	$id_sucursal=$renglon[0];
	
	?>
	<div align='center'><b>NOTAS DE ENTREGA - <? echo $libreria_carga?></b></div><br>
		<?
	
	$ruta="notas/".$id_sucursal;
	if (is_dir($ruta))
	{
		$directorio=opendir($ruta); 
		while ($archivo = readdir($directorio))
		{
			$nota_entrega=str_replace(".xls", "", $archivo);
			$sql_notaentrega="SELECT DISTINCT (nota_entrega), tbl_sucursal.sucursal FROM `tbl_controlperceptivo` , tbl_sucursal
			WHERE nota_entrega ='$nota_entrega' AND tbl_controlperceptivo.sucursal_carga = tbl_sucursal.id_sucursal";
			$result_notaentrega = mysql_query($sql_notaentrega, $db);
			$nf_notaentrega=mysql_num_rows($result_notaentrega);
			if($nf_notaentrega>0)
			{
				 echo $archivo."<b>-*-> Esta nota de entrega ya ha sido cargada</b><br>";
			}
			else
			{	
			  ?>
				<a href="lee_notas2.php?arch=<? echo $archivo?>&id_suc=<? echo $id_sucursal?>&carga=<? echo $carganota?>"><? echo $archivo?></a><br>
				<?
			}
		}
		closedir($directorio);
	}
	else
	{
		?><br>
		<div align='center'><b>NO EXISTE LA CARPETA DE NOTAS PARA ESTA SUCURSAL</b></div><br>
		<?
	}
	?><br>
		<div align='center'><a href="lee_notas2.php">Regresar al inicio</a></div><br>
		<?
}
elseif($_GET[arch]!='')
{
	$id_sucursal=$_GET[id_suc];
	$nota_entrega=str_replace(".xls", "", $_GET[arch]);
	$select="select sucursal from tbl_sucursal where id_sucursal='$id_sucursal'";
	$result=mysql_query($select);
	while($row = mysql_fetch_row($result))
	{
		$nombresucursal=$row[0];
	}
	$ruta_nota="notas/".$id_sucursal."/".$_GET[arch];
	if ($mi_array=file($ruta_nota)) 
	{
			?>
		<form autocomplete="off" enctype="multipart/form-data" method="post" action="resp.php" onSubmit="return validate(this);" name="form">
			
			<div align=center><font><b>NOS ENCONTRAMOS EN:</b></font></div>
		<div align=center><font size=5 color=blue><b><?echo $id_sucursal." - ".$nombresucursal; ?></b></font><br></div><br>
			<b><div align='center'><font color='red' size='5'>NOTA DE ENTREGA  <?echo $nota_entrega?></font></div></b>
	
			<div id='tabla'>
		<TABLE CELLSPACING=0 border="1">
	
		<TR class='estilotitulo'>
			<TD width='80' bgcolor="#990000"><font color='white'><b>Cod. Articulo</b></font></TD> 
			<TD width='210' bgcolor="#990000"><font color='white'><b>Titulo</b></font></TD> 
			<TD width='150' bgcolor="#990000"><font color='white'><b>Autor</b></font></TD> 
			<TD width='150' bgcolor="#990000"><font color='white'><b>Editorial</b></font></TD> 
			<TD width='52' align="center" bgcolor="#990000"><font color='white'><b>ISBN</b></font></TD> 	
			<TD width='12' align="center" bgcolor="#990000"><font color='white'><b>Cod. Barra</b></font></TD> 
			<TD width='12' align="center" bgcolor="#990000"><font color='white'><b>Tomo</b></font></TD> 
			<TD width='12' align="center" bgcolor="#990000"><font color='white'><b>Presentacion</b></font></TD>  
			<TD width='60' align="center" bgcolor="#990000"><font color='white'><b>Precio Unitario</b></font></TD> 
			<TD width='48' align="center" bgcolor="#990000"><font color='white'><b>Cant Enviada</b></font></TD> 
			<TD width='48' align="center" bgcolor="#990000"><font color='white'><b>Cant Entreg</b></font></TD> 
			<TD width='70' align="center" bgcolor="#990000" ><font color='white'><b>Bsf.</b></font></TD> 
		</TR>
			<input type="hidden" name="nota_entrega" value="<? echo $nota_entrega; ?>">
			<?
			$l=1;
			date_default_timezone_set('America/Caracas');
			$Cantidad_pedida=0;
			$Cantidad_entregada=0;
			$precio_libros=0;
			$fechaLarga = date("Y-m-d h:i:s",time());
			$fechaCorta = date("Y-m-d",time());
			$fecha_1=$fechaCorta." 00:00:00";
			$fecha_2=$fechaCorta;
			$arrfec=explode("-",$fechaCorta);
			$incyear=$arrfec[0]+1;
			$incdia=$arrfec[2]+1;
			$fecha_venc=$arrfec[0]."-".$arrfec[1]."-".$incdia;
			$fecha_vencconsig=$incyear."-".$arrfec[1]."-".$arrfec[2];
			$actualiza=false;
			$libros_faltantes="";
			while (list ($linea, $contenido) = each ($mi_array)) 
			{ 
			
				if($linea==13)
				{
					$fe = substr($contenido, 21);
					$fe2=str_replace("</strong></TD></tr>", "",$fe);
					$fe3=explode('/',$fe2);
					$fecha_envio=trim($fe3[2])."-".trim($fe3[1])."-".trim($fe3[0])." 00:00:00";
					
					?>
						<input type="hidden" name="fecha_envio" value="<? echo $fecha_envio; ?>">
					<?
				
				}
				
				if($linea==14)
				{
					
					$pe = substr($contenido, 49);
					$pedido=str_replace("</strong></TD></tr>", "",$pe);
					?>
						<b><div align='center'><font color='blue' size='5'><?echo "ESTA BASADA EN EL PEDIDO: ".$pe?></font></div></b><br><br>
						<input type="hidden" name="pedido" value="<? echo $pedido; ?>">
					<?
				}
			
				if($linea==16)
				{
					$rest = substr($contenido, 46);
					$libreria_cliente=str_replace("</strong></TD></tr>", "",$rest);
					$sucursal_envio=substr($libreria_cliente, 0, 4);
			
					?>
						<b><div align='center'><font size='3'>ESTA NOTA DE ENTREGA ESTA DIRIGIDA A:</font></div></b>
						<b><div align='center'><font color='blue' size='7'><?echo $libreria_cliente?></font></div></b>
						<input type="hidden" name="libreria_cliente" value="<? echo $libreria_cliente; ?>">
						<input type="hidden" name="sucursal_envio" value="<? echo $sucursal_envio; ?>">
						<input type="hidden" name="id_sucursal" value="<?echo $id_sucursal;?>">
						<input type="hidden" name="nombresucursal" value="<?echo $nombresucursal;?>">
					<?
				}
	

				if ($linea > 37)
				{
					if(strpos($contenido, '#')!=false)
					{
						$cadena_2=str_replace("<TD align='center'>", "<TD>",$contenido);
						$cadena_3=strip_tags($cadena_2,'<TD>');
						$renglon=explode('<TD>',$cadena_3);
						$renglon[0]=str_replace("# ","",$renglon[0]);
						for($i=0;$i<sizeof($renglon);$i++)
						{
							switch($i)
							{
								case 0:	$descripcion="Codigo=";
										break;
										
								case 1:	$descripcion="Titulo=";
										break;
					
								case 2:	$descripcion="Autor=";
										break;
								
								case 3:	$descripcion="Tomo=";
										break;
					
								case 4:	$descripcion="Presentacion=";
										break;
								
								case 5:	$descripcion="Precio Unitario=";
										break;
								
								case 6:	$descripcion="Cantidad Pedida=";
										$Cantidad_pedida=$Cantidad_pedida+$renglon[$i];
										break;
					
								case 7:	$descripcion="Cantidad Entregada=";
										$Cantidad_entregada=$Cantidad_entregada+$renglon[$i];
										break;
								
								case 8:	$descripcion="Precio total=";
										$precio_libros=$precio_libros+$renglon[$i];
										
										break;
								
								default:	$descripcion="";
										break;
							}
						}
					
						//$j=0;
						$precio_unitario=str_replace("</TD>", "",trim($renglon[5]));
						$costo=$precio_unitario*0.6;
						$total=$costo*$renglon[7];
						$cod_libro=substr(trim($renglon[0]),17,10);
						$autor_name=str_replace("</TD>", "",trim($renglon[2]));
						$titulo=str_replace("</TD>", "",trim($renglon[1]));
						$tomo=str_replace("</TD>", "",trim($renglon[3]));
						$cantidad=str_replace("</TD>", "",trim($renglon[6]));
						$cantdist=str_replace("</TD>", "",trim($renglon[7]));
						$precioexten=str_replace("</TD>", "",trim($renglon[8]));
						$present=str_replace("</TD>", "",trim($renglon[4]));

						//La presentacion
						if($present=="U")
							$presentacion="UNICA";
						elseif($present=="R")
							$presentacion="RUSTICO";
						elseif($present=="E")
							$presentacion="EMPASTADO";
						else
							$presentacion="UNICA";
							
						$sql_libro="SELECT e.editorial, isbn,cod_barra 
									FROM `tbl_inventario`,tbl_editorial e
									WHERE  cod_producto='$cod_libro'
									and e.id_editorial=tbl_inventario.editorial";
						$status_libro=mysql_query($sql_libro) or die($sql_libro."<br>".mysql_error());
						$nf_libro=mysql_num_rows($status_libro);
						$m=0;
						if($nf_libro>0)
						{
						
							while($row = mysql_fetch_row($status_libro))
							{
								if($j=='')
									$j=0;
								$editorial=$row[0];
								$isbn=$row[1];
								$codigodebarra=$row[2];
								
								$cod_libro1[$j]=$cod_libro;

								echo("<tbody id='tbodyDet' ><tr>");
									printf("<td>%s</td> ", isset($cod_libro)?$cod_libro:' - '); // codigo del libro
									printf("<td>%s</td> ", isset($titulo)?$titulo:' - '); // lib_descri
									printf("<td>%s</td> ", isset($autor_name)?$autor_name:' - '); // aut_nombre
									printf("<td>%s</td> ", isset($editorial)?$editorial:' - '); // editorial
									printf("<td>%s</td> ", isset($isbn)?$isbn:' - '); // isbn
									printf("<td>%s</td> ", isset($codigodebarra)?$codigodebarra:' - ');//$codigodebarra
									printf("<td>%s</td> ", isset($tomo)?$tomo:' - ');
									printf("<td>%s</td> ", isset($presentacion)?$presentacion:' - ');
									printf("<td>%s</td> ", isset($precio_unitario)?$precio_unitario:' - ');
									printf("<td>%s</td> ", isset($cantidad)?$cantidad:' - ');
								
									?>
									<td><input type="text" size="3" name="cant_entregada[<?echo $j;?>]" value="<?echo $cantdist?>"></td>
									<?
								printf("<td>%s</td> ", isset($precioexten)?$precioexten:' - ');
									
								echo("</tr></tbody>");
								?>
								<input type="hidden" name="codlibro[<?echo $j?>]" value="<? echo $cod_libro; ?>">
								<input type="hidden" name="titulo[<?echo $j;?>]" value="<?echo $titulo;?>">
								<input type="hidden" name="autor[<?echo $j;?>]" value="<?echo $autor_name;?>">
								<input type="hidden" name="editorial[<?echo $j;?>]" value="<?echo $editorial;?>">
								<input type="hidden" name="isbn[<?echo $j;?>]" value="<?echo $isbn;?>">
								<input type="hidden" name="cod_Barra[<?echo $j;?>]" value="<?echo $codigodebarra;?>">
								<input type="hidden" name="tomo[<?echo $j;?>]" value="<?echo $tomo;?>">
								<input type="hidden" name="presentacion[<?echo $j;?>]" value="<?echo $presentacion;?>">
								<input type="hidden" name="precio_unitario[<?echo $j;?>]" value="<?echo $precio_unitario;?>">
								<input type="hidden" name="cantidad[<?echo $j;?>]" value="<?echo $cantidad;?>">
								<?
								
								$j++;
							}
								?>
							
							<input type="hidden" name="filas" value="<?echo $j?>">
							<?
						}
						else
						{
							$actualiza=true;
							if($libros_faltantes=="")
								$libros_faltantes=$cod_libro;
							else
								$libros_faltantes=$libros_faltantes." - ".$cod_libro;
							?>
							<tr><td colspan="12" align="center"><? echo "<b>Este libro no aparece en el catalogo: <font color ='red' size='4'>".$cod_libro."</font> - ".$titulo."<b>";?></td></tr>
							<?
							$m++;
						}
						$l++;
					}
					
				}
			}
				?>
				<input type="hidden" name="actualiza" value="<?echo $actualiza;?>">
				<input type="hidden" name="libros_faltantes" value="<?echo $libros_faltantes;?>">
				<input type="hidden" name="fecha_carga" value="<?echo $fechaLarga;?>">
			<tr><td colspan="2" align="right"><b>Observaciones</b>: </td><td colspan="10" align="left"><textarea id="observaciones" name="observaciones" rows="5" cols="80"></textarea></td></tr>
			<tr><td colspan="12" class="botones" align="center"><INPUT type="submit" value="Enviar"></td></tr>
			</table>
		</div>
		</form>		
					<?
			$cantidad_libros=$l-1;
			$total_cancelar=$precio_libros*0.6;
				
	}
	  ?><br>
		<div align='center'><a href="lee_notas2.php">Regresar al inicio</a></div><br>
		<?

}
else
{
	?>
		<b><div align='center'><font size='5'>APLICACION PARA LA CARGA OFFLINE DE LAS NOTAS DE ENTREGA<br>SELECCIONE UNA LIBRERIA</font></div></b><br><br><br>
	<?
	$select="select * from tbl_sucursal order by sucursal asc";
	$result=mysql_query($select);
	while($row = mysql_fetch_row($result))
	{
		$id[]=$row[0];
		$nombresucursal[]=$row[1];
	}

		?>
		<html>
		<head>
		</head>
		<body>
		<div align='center'>
		 <form action="" method="post">  
		  <select name="libreria">
		  <?php
		  for($i=0;$i<sizeof($nombresucursal);$i++)
		  {
		   ?>
			   <option value="<?php echo $id[$i]."-".$nombresucursal[$i]; ?>"><?php echo $id[$i]."-".$nombresucursal[$i]; ?></option>
			   <?php
		   }
		  ?>
		
		  </select>
		  <input type="submit" name="submit" value="Buscar Notas de Entrega" />  
		 </form>
		 </div>
		 <div align='center'><img src="imagenes/sinconexion.jpg" /></div>
		</body>
		</html>
		<?
}

