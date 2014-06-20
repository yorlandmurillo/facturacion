<?php
	session_start();
	include("includes/conexion.php");
	include("includes/functions.php");
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
	
		$hora = date("H:i:s");  
		$feria=$_POST['feria'];
		$tipo=$_POST['tipo'];
		
		
	$editorial=$_POST['editorial'];
	
   $usuario=$_POST['usuario'];
   
   	list($localidad, $estado, $pais) =explode(',', $city);

	//echo ($precio_libros);
	$cod_libro = explode(',',$cod_libros);
	$precio_libro = explode('+',$precio_libros);
	$cant_libro = explode(',',$cant_libros);
	
	//echo($cod_libro[0]."-".$precio_libro[0]."-".$cant_libro[0]);
	$accion="G";
	
	switch($accion) { 
	case "G":   // guarda informacion del usuario
	
		$strQry="	SELECT MAX(SUBSTRING(ped_numped, 9, 4))
					FROM inv_solicitud_c
					WHERE 
						SUBSTRING(ped_numped, 3, 6) = EXTRACT(YEAR_MONTH FROM sysdate())";
		
		$result=mysql_query($strQry,$link);
		if($row = mysql_fetch_array($result)){
			$numpedMax = str_pad(($row[0]+1),4,"0",STR_PAD_LEFT);
		}
		$cod_pedido = "SO".date('Ym').$numpedMax;
		$hora = date("H:i:s"); 

		mysql_free_result($result);
		$sql= "INSERT INTO inv_solicitud_c (ped_numped, ped_fchped,ped_hora, ped_codcli, ped_codven,ped_estatus,ped_codtrs,ped_user,ped_observ,ped_pordes,con_codigo,ped_feria,ped_tipo,printer, ped_localidad,ped_estado,ped_pais)
				VALUES ('$cod_pedido','" . cambiaf_a_mysql($fecha) . "','$hora','$cliente','$vendedor','S','$trans','$usuario','$observ','$desc','$pago','$feria','$tipo','N','".utf8_encode($localidad)."','".utf8_encode($estado)."','".utf8_encode($pais)."') ";
	
	/*
		$sql= 	"UPDATE inv_pedidc 
				SET  
				ped_fchped='" . cambiaf_a_mysql($fecha) . "', 
				ped_codcli='$cliente', 
				ped_codven='$vendedor',
				ped_estatus='P',
				ped_codtrs='$trans',
				ped_user='$usuario',
				ped_observ='$observ',
				ped_pordes='$desc',
				con_codigo='$pago'
		//echo $sql;
				WHERE ped_numped='$cod_pedido'";*/
		$result=@mysql_query($sql,$link);
		 if($result)
		 {
			//mysql_free_result($result);
			$sql= "INSERT INTO inv_solicitud_d  (ped_numped  ,ped_codart, ped_cantid, ped_precio) VALUES ";
			for ($i=0;$i<count($cod_libro);$i++) {
				$sql=$sql."('$cod_pedido','".$cod_libro[$i]."','".$cant_libro[$i]."','".cambia_a_american($precio_libro[$i])."')";
				if(($i+1)<count($cod_libro)){$sql=$sql.",";}
			}
			//echo $sql;
						
			$result=@mysql_query($sql,$link);
			///if($result)
			///{
				///for ($i=0;$i<count($cod_libro);$i++) {
					///$sql= "UPDATE inv_libros l SET l.lib_exiact = IFNULL(l.lib_exiact,0) - '".$cant_libro[$i]."' WHERE l.lib_codart = '".$cod_libro[$i]."' ";
					///$result=@mysql_query($sql,$link);
			
			///}
			///}
			
			if($result)
			 {
				$msg="SOLICITUD EN PROCESO DE APROBACIÓN";
			 }else{
			 	$msg="Error al intertar guardar en la solicitud";
			 }
		 }else{
		 	$msg="Error al intertar guardar el solicitud";
		 }
		 break;
	case "E":   // elimina informacion del usuario
		 
	case "A":   // actualiza informacion del usuario
		 
	default:   // bloque 3 
		 echo "error"; 
   } 
	//mysql_free_result($result);
	mysql_close($link);
		
	//echo $msg;
	//header("location: inventario.php?p=pedido&msg=".urlencode($msg));
	//header("location:");
	//include("excel_pedido.php");
	
	?>
	
<html>

<head>
<title>Pedido procesado...</title>
<link rel="STYLESHEET" type="text/css" href="includes/estilos.css" media='screen'>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	background-color: #FFF;
}
</style>
</head>

<body>

<script language="JavaScript">
function volver()
{
    window.location.href = "inventario.php?p=Pedido";
}
</script>

<form name="frmPedido" method="post" action="excel_pedido.php">
	<input type="hidden" name="cod_pedido" value="<?php echo($cod_pedido); ?>">
	<input type="hidden" name="fecha" value="<?php echo($fecha); ?>">
	<input type="hidden" name="cliente" value="<?php echo($cliente); ?>">
	<input type="hidden" name="vendedor" value="<?php echo($vendedor); ?>">
	<input type="hidden" name="trans" value="<?php echo($trans); ?>">
	<input type="hidden" name="pago" value="<?php echo($pago); ?>">
	<input type="hidden" name="contacClt" value="<?php echo($contacClt); ?>">
	<input type="hidden" name="observ" value="<?php echo($observ); ?>">
	<input type="hidden" name="desc" value="<?php echo($desc); ?>">
	<input type="hidden" name="cod_libro" value="<?php echo($cod_libros); ?>">
	<input type="hidden" name="precio_libro" value="<?php echo($precio_libros); ?>">
	<input type="hidden" name="cant_libro" value="<?php echo($cant_libros); ?>">
	<input type="hidden" name="editorial" value="<?php echo($editorial); ?>">

  <table align='center'>
	<tr><td><img src="images/cabecera.jpg" border=0 width="550"></td></tr>
	<tr><td><p>&nbsp;</p></td></tr>
	<tr><td><p>&nbsp;</p></td></tr>
	<tr align="center">
		<td> 
			<SPAN class='mensajes'>
			<?php echo $msg; ?>
			</SPAN>
		</td>
	</tr>
	<tr><td><p>&nbsp;</p></td></tr>
	<tr align="center"><td><p>Código de Solicitud:  <?php echo $cod_pedido; ?></p></td></tr>
	<tr><td><p>&nbsp;</p></td></tr>
	<tr align="center">
		<td><input type="button" onClick="volver()" value="Volver" name="button2">  

  

  

<?
	 $codigo=$_POST[codigo];

?>
<a href=reimpresion_ver_pe_ne.php?codigo=<?php echo $cod_pedido; ?>>


  </input></td>
	</tr>
</table>
</form>	

</body>

</html>
