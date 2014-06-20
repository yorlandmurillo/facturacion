<?php
session_start();
include("includes/functions.php");
$codigos_existentes=array();
$cant_act=array();
$codigos_ausentes=array();
$cant_agreg=array();
$cod_isbnagreg=array();
$cod_Barraagreg=array();
$cod_autoragreg=array();
$cod_tituloagreg=array();
$editorialagreg=array();
$tomoagreg=array();
$presentacionagreg=array();

$link2 = mysql_connect("localhost","inventa_bd","Valenta@04") or die (mysql_error());  
mysql_select_db("inventa_pglibreria",$link2);

$busca_sucursal="select * from tbl_sucursal order by sucursal asc";
$result_sucursal=mysql_query($busca_sucursal,$link2) or die("Busqueda de la sucursal<br>".mysql_error());//Apunta a la base de datos local
while($row = mysql_fetch_row($result_sucursal))
{
	$id_sucursal=$row[0];
	$nombresucursal=$row[1];
}


$fechaLarga = date("Y-m-d h:i:s",time());


echo "Valores POST<br>";
$num2=count($_POST);
$tags2 = array_keys($_POST); // obtiene los nombres de las variables
$valores2 = array_values($_POST);// obtiene los valores de las variables
print_r($tags2);
echo "<br><br>";
print_r($valores2);
echo "<br><br>";
//die();

$usuario=$_POST['usuario'];
$feria=$_POST['feria'];
$cod_entrega=$_POST['cod_entrega'];
$pedido=$_POST['pedido'];
$fecha=$_POST['fecha'];
$recibo=$_POST['recibido'];
$autorizado=$_POST['autorizado'];
$observ=$_POST['observ'];
//$desc=$_POST['desc'];
$ncliente=$_POST['ncliente'];
$ncliente2=$_POST['ncliente2'];

$precio_libros=$_POST['precio_libro'];
$cant_libros=$_POST['cant_libro'];
$cant_libros2=$_POST['cant_libro2'];
$precio_libro = explode('+',$_POST['precio_libro']);
$cant_libro = explode(',',$cant_libros);
$cant_libro2 = explode(',',$cant_libros2);

$cod_libro = explode(',',$_POST['cod_libro']);
$cant_entreg=explode(',',$_POST['cant_libro2']);
$cod_isbnentreg=explode(',',$_POST['cod_isbn']);
$cod_Barraentreg=explode(',',$_POST['cod_Barra']);
$cod_autorentreg=explode('*',$_POST['cod_autor']);
$cod_tituloagreg=explode('*',$_POST['cod_titulo']);
$editorialentreg=explode('*',$_POST['editorial']);
$tomoentreg=explode(',',$_POST['tomo']);
$presentacionentreg=explode(',',$_POST['presentacion']);




$cod_art_nota="";
for($j=0;$j<count($cod_libro);$j++)
{
	$codigon=$cod_libro[$j];
	$cantidad_entregada=$cant_entreg[$j];
	$$cod_isbn_entregada=$cod_isbnentreg[$j];
	$cod_Barra_entregada=$cod_Barraentreg[$j];
	$cod_autor_entregada=$cod_autorentreg[$j];
	$cod_titulo_entregada=$cod_tituloagreg[$j];
	$editorial_entregada=$editorialentreg[$j];
	$tomo_entregada=$tomoentreg[$j];
	$presentacion_entregada=$presentacionentreg[$j];
	
	$busca_existencia="select cod_producto from tbl_distinventario where cod_producto='$codigon'";
	$existencia=mysql_query($busca_existencia,$link2) or die("<br>".mysql_error());
	$nf_existencia=mysql_num_rows($existencia);
	if($nf_existencia >0)
	{
		$codigos_existentes[]=$codigon;
		$cant_act[]=$cantidad_entregada;
	}
	else
	{
		$codigos_ausentes[]=$codigon;
		$cant_agreg[]=$cantidad_entregada;
		$cod_isbnagreg[]=$$cod_isbn_entregada;
		$cod_Barraagreg[]=$cod_Barra_entregada;
		$cod_autoragreg[]=$cod_autor_entregada;
		$cod_tituloagreg[]=$cod_titulo_entregada;
		$editorialagreg[]=$editorial_entregada;
		$tomoagreg[]=$tomo_entregada;
		$presentacionagreg[]=$presentacion_entregada;
	}
}
	echo "<font size=5><b>Tabla tbl_distinventario:</b></font><br>Existentes: ".count($codigos_existentes)."<br>Ausentes: ".count($codigos_ausentes)."<br><br>";

	if(count($codigos_existentes)>0)
	{
		$actualiza_existencia="UPDATE tbl_distinventario SET cantidad = CASE cod_producto ";
		$actualiza_fecha_existentes="UPDATE tbl_distinventario SET FECHA_NOTA_ENTREGA='$fechaLarga' where cod_producto in(";
		for($j=0;$j<count($codigos_existentes);$j++)
		{
			if($j==count($codigos_existentes)-1)
				$fin_cod=")";
			else
				$fin_cod=",";
				
			$cod_exist=$codigos_existentes[$j];
			$cantidadact=$cant_act[$j];
			$actualiza_fecha_existentes.="'$cod_exist'".$fin_cod;
			$actualiza_existencia.="WHEN '$cod_exist' THEN cantidad+'$cantidadact' ";
		}
		$actualiza_existencia.="ELSE cantidad ";
		$actualiza_existencia.="END";
		
		echo $actualiza_fecha_existentes."<br><br>";
		echo $actualiza_existencia."<br><br>";
		mysql_query($actualiza_fecha_existentes,$link2); //Ejecuta la sentencia de actualiazcion de fecha existente de tbl_distinventario
		mysql_query($actualiza_existencia,$link2); //Ejecuta la sentencia de actualiazcion de tbl_distinventario
	}

	
	
	
	if(count($codigos_ausentes)>0)
	{
		$agrega_existencia="INSERT INTO `tbl_distinventario` (`cod_producto`, `isbn`, `cod_barra`, `autor`, `descripcion`, `editorial`, `tomo`, `presentacion`, 
														`sucursal`, `condicion`, `cantidad`, `descuento`, `FECHA_NOTA_ENTREGA`) VALUES";
		for($j=0;$j<count($codigos_ausentes);$j++)
		{
			if($j==count($codigos_ausentes)-1)
				$finagrega=";";
			else
				$finagrega=",";
				
			$cod_libro1=$codigos_ausentes[$j];
			$cod_isbn1=$cod_isbnagreg[$j];
			$cod_Barra1=$cod_Barraagreg[$j];
			$cod_autor1=$cod_autoragreg[$j];
			$cod_titulo1=$cod_tituloagreg[$j];
			$editorial1=$editorialagreg[$j];
			$cant_agregada=$cant_agreg[$j];
			$tomo1=$tomoagreg[$j];
			$presentacion1=$presentacionagreg[$j];
			
			$agrega_existencia.="('$cod_libro1','$cod_isbn1','$cod_Barra1','$cod_autor1','$cod_titulo1','$editorial1','$tomo1','$presentacion1','$id_sucursal','0000000001','$cant_agregada',0,'$fechaLarga')".$finagrega;
		}
		
		echo $agrega_existencia;
		echo "<br><br>";
		mysql_query($agrega_existencia,$link2); //Ejecuta la sentencia de inserción de tbl_distinventario
	
	}

	
	echo "<font size=5><b>Tabla nota e itemnota locales:</b></font><br><br>";
	$fecha2=$fecha = date("Y-m-d");
		
	echo $agrega_nota_local="INSERT INTO `tbl_nota` (`NOT_NUMNOT`, `NOT_NUMPED`, `fecha_nota`) VALUES ('$cod_entrega', '$pedido', '$fecha2');";
	mysql_query($agrega_nota_local,$link2); //Ejecuta la sentencia de inserción de tbl_nota
	echo "<br><br>";
	
	$agrega_itemnota_local="INSERT INTO `tbl_itemnota` (`NOT_NUMNOT`, `cod_producto`, `NOT_CANTID`, `NOT_PRECIO`) VALUES";
	for ($i=0;$i<count($cod_libro);$i++) 
	{
	
		if($i==count($cod_libro)-1)
			$fin_item=";";
		else
			$fin_item=",";
		
		$precio_libro1=number_format($precio_libro[$i],2,".",",");

		 $agrega_itemnota_local.= "('$cod_entrega','$cod_libro[$i]','$cant_libro[$i]','$precio_libro1')".$fin_item;			
	}
	echo $agrega_itemnota_local."<br><br>";
	mysql_query($agrega_itemnota_local,$link2); //Ejecuta la sentencia de inserción de tbl_itemnota
	
	
	//Confirma la carga de la nota en la base de datos local
	$chequea_carga_nota="SELECT distinct(tbl_itemnota.NOT_NUMNOT),sum(`NOT_CANTID`) 
						FROM tbl_itemnota,tbl_nota
						where tbl_nota.NOT_NUMNOT=tbl_itemnota.NOT_NUMNOT
						and tbl_nota.NOT_NUMNOT='$cod_entrega'
						group by tbl_itemnota.NOT_NUMNOT";
	
	$resultcarga=mysql_query($chequea_carga_nota,$link2) or die($chequea_carga_nota."<br>".mysql_error());
	if ($myrow_carga= mysql_fetch_array($resultcarga)) 
	{
		$cantidad_items=$myrow_carga[1];
		echo "-*->".$cantidad_items."<br>";
		
		echo "<br><br>";
	
		if($cantidad_items > 0)
		{
			echo "<font size=5><b>Tabla fdvl_operaciones:</b></font><br><br>";

			$link = mysql_connect("distribuidoradellibro.gob.ve","inventa_bd","Valenta@04") or die (mysql_error());  
			mysql_select_db("inventa_fdvl",$link);


			echo "<br><br>";
			echo "<font size=5><b>Tabla fdvl_operaciones:</b></font><br><br>";

			$busca_nota_operaciones="select * from fdvl_operaciones where rec_numnot='$cod_entrega'";
			$status_nota_operaciones=mysql_query($busca_nota_operaciones,$link) or die("<br>".mysql_error()); //apuntando a la base de datos remota
			$nf_nota_operaciones=mysql_num_rows($status_nota_operaciones);	
			if($nf_nota_operaciones==0)
			{
				$fecha = date("Y-m-d H:i:s"); 
				$hora = date("H:i:s");  

				$strQry="	SELECT MAX(SUBSTRING(rec_recepcion, 9, 4))
							FROM fdvl_operaciones
							WHERE SUBSTRING(rec_recepcion, 3, 6) = EXTRACT(YEAR_MONTH FROM sysdate())";
				$result=mysql_query($strQry,$link); //apuntando a la base de datos local
				if($row = mysql_fetch_array($result))
				{
					$numnotMax = str_pad(($row[0]+1),4,"0",STR_PAD_LEFT);
				}

				$cod_entregaDEV = "CP".date('Ym').$numnotMax;
				mysql_free_result($result);


				$sql= "INSERT INTO fdvl_operaciones (rec_recepcion, rec_numnot, rec_numped, rec_fchnot, rec_hora, rec_observ,rec_user,COD_CLIENTE,CLIENTE)
						VALUES ('$cod_entregaDEV','$cod_entrega','$pedido','$fecha','$hora','$observ','$usuario','$ncliente','$ncliente2'); ";
				echo $sql."<br><br>";

				mysql_query($sql,$link);//Debe apuntar a la base de datos remota
				

				$sql2= "INSERT INTO fdvl_operacionesd (REC_RECEPCIOND, REC_NUMNOT  ,REC_CODART, REC_CANTID,NOTA_CANTID,NOT_PRECIO) VALUES";
				for ($i=0;$i<count($cod_libro);$i++) 
				{
				
					if($i==count($cod_libro)-1)
						$fin_operac=";";
					else
						$fin_operac=",";
						$precio_libro1=number_format($precio_libro[$i],2,".",",");

					$sql2.= "('$cod_entregaDEV','$cod_entrega','$cod_libro[$i]','$cant_libro2[$i]','$cant_libro[$i]','$precio_libro1')".$fin_operac;

				}
				@mysql_query($sql2,$link); //Debe apuntar a la base datos remota
				echo $sql2."<br><br>";
			
			}
			else
			{
				while($row = mysql_fetch_row($status_nota_operaciones))
				{
					$control_perceptivo=$row[0];
				}
				//rec_recepcion
				echo "La nota de entrega <b>".$cod_entrega."</b> ya ha sido cargada con anterioridad y genero el control perceptivo <b>".$control_perceptivo."</b><br><br>";
				?>
					<div align="center"><a href="http://localhost/fdvl/inventario.php?p=RecepcionLS">PROCESAR OTRA NOTA DE ENTREGA</a></div
				<?
			}
			
			
		}
		else
		{
			echo "La nota de entrega <b>".$cod_entrega."</b> ya ha sido cargada con anterioridad y genero el control perceptivo <b>".$control_perceptivo."</b><br><br>";
			?>
				<div align="center"><a href="http://localhost/fdvl/inventario.php?p=RecepcionLS">NO SE GENERO EL CONTROL PERCEPTIVO PORQUE LA CANTIDAD DE ITEMS ES CERO</a></div
			<?
		}

	}
	else
	{
		echo "No se pudo generar el contro perceptivo";
		?>
			<div align="center"><a href="http://localhost/fdvl/inventario.php?p=RecepcionLS">NO SE PUDO GENERAR EL CONTROL PERCEPTOVO DE LA NOTA <?echo $cod_entrega;?>;</a></div
		<?
	}
	
	//die();
	//	mysql_free_result($result);
	mysql_close($link);
	mysql_close($link2);
	
	?>

	<html>

	<head>
	<title>Devolución procesado...</title>
	<link rel="STYLESHEET" type="text/css" href="includes/estilos.css" media='screen'>
	<style type="text/css">
	.regla {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
		color: #F03;
		font-weight: bold;
	}
	</style></head>

		<tr align="center">
			<td> 
				<SPAN class='mensajes'>
				</SPAN>
				<table width="100%" border="0">
				  <tr>
					<td width="100%" align="center"><img src="imagenes/banner.png" width="760" height="148"></td>
				  </tr>
				  <tr>
					<td width="100%" align="center">                  <span class="regla"><?php echo $msg; ?>                </span></td>
		</tr>
		<tr><td><p>&nbsp;</p></td></tr>
		<tr align="center"><td><p><span class="regla">CONTROL PERCEPTIVO:  <?php echo $cod_entregaDEV; ?></span></p></td></tr>
		<tr><td><p>&nbsp;</p></td></tr>
		<tr align="center">
			<td> 
			
				<?php echo "<script>alert('CONTROL PERCEPTIVO  Nº $cod_entregaDEV');location.href='inventario.php?p=RecepcionLS';</script>"; 
	?>
				 
					</td>
				  </tr>
			  </table>
				<SPAN class='mensajes'>
				<p align='center'>             
			<p align='center'></td>
		</tr>
	</table>
	</form>	

	</body>

	</html>
<?
