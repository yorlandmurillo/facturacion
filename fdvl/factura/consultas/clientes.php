<? 
require("../admin/session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.

if ($_SESSION['usuario_nivel'] < $nivel_acceso){
Header ("Location: ../admin/login.php?error_login=5");
exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<META content="MyDB Studio" name=GENERATOR>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<title>Clientes</title>
<script type="text/javascript" src="../funciones/js/ajax.js"></script>
<script type="text/javascript" src="../jsefectos/prototype.js"></script>
<script type="text/javascript" src="../jsefectos/effects.js"></script>
<script type="text/javascript" src="../jsefectos/dragdrop.js"></script>
<script type="text/javascript" src="../jsefectos/litboxflash.js"></script>
<script type="text/javascript" src="../jsefectos/scriptaculous.js"></script>
<script type="text/javascript" src="../jsefectos/funciones.js"></script>
<script type="text/javascript" src="funciones/js/validacion.js"></script>
<link rel="stylesheet" type="text/css" href="funciones/js/formulario.css">
<link rel="stylesheet" href="../styles/litbox.css" type="text/css" media="screen" />

<style type="text/css">
<!--
body {
        font-size: 11px;
        font-family: Tahoma,Arial,sans-serif;
}
a {
        font-family: Tahoma,Arial,sans-serif; 
        font-size: 12px;
        color: #990000;
        text-decoration: none;
}
a:hover {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 14px;
        color: #0000FF;
        text-decoration: none;
		
}
h1 {
        font-family: Tahoma, Arial, sans-serif;
        font-size: 16px;
        font-weight: bold;
}
table{
        padding: 5;
}
th {
        font-size : 11px;
        font-family : Tahoma, Arial, sans-serif;
        color : #FFFFFF;
        text-align : center;
        font-weight : bold;
        background-color:#990000;
}
tr {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 11px;
        background-color : #FFFFFF;
}
td {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 11px;
}
TABLE.Mtable TD {
        BORDER-RIGHT: #93bee2 1px solid;
        BORDER-BOTTOM: #c1cdd8 1px solid;
}
TABLE.Mtable TH {
        BORDER-RIGHT: #93bee2 1px solid;
}
TABLE.Mtable {
        border: 1px solid #336699;
}

.TRalter {
        background-color : #F0F0F0; 
}


TABLE.buscarTable {
        border: 1px solid #336699;
}
input {
        font-size: 11px;
        font-family: Tahoma, Arial, sans-serif;
}
.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}


-->
</style>
<script>
function vacio(q) {
	for ( i = 0; i < q.length; i++ ) {
			if ( q.charAt(i) != " " ) {
					return true
			}
	}
	return false
}

function enviardatos(datos){
//alert(datos+"\n"+datos.length+"\n"+datos.substring(0, datos.length-1)+"\n"+datos.substring(datos.length-1, datos.length));
var ced=datos.substring(0, datos.length-1);
var tipo=datos.substring(datos.length-1, datos.length);

//die();
	window.location="../additemfactura.php?cliente="+ced+"&tipo="+tipo+"&pagina=1";
}

function validabusqueda(F) {
	if( vacio(F.buscar.value) == false ) {
		alert("Deebe introducir un numero de cedula, pasaporte o rif")
		return false
	}
	else if(F.buscar.value.length<6)
	{
		alert("El número de identificacion debe ser igual o mayor a 6 digitos\nSi el número es menor de 6 digitos rellene con ceros a la izquierda")
		return false
	} 
	else if(F.buscar.value.lastIndexOf("'")!=-1)
	{
		alert("Caracter no válido en la cedula o rif (')");
		return false
	}   
	else {
		return true
	}        
}




</script>
</head>
<body>
<div align=center><b><font size=5>
<?
if($_GET['tipo']=='m')
{
?>	
		SE CARGAR&Aacute UNA FACTURA MANUAL
		<?
}
elseif($_GET['tipo']=='n')
{
?>	
		SE PROCESAR&Aacute UNA FACTURA NORMAL
		<?
}
?>
</font></b></div>
<h1>Clientes</h1>


<!-- buscar engine -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" name="mform" id="mform" onSubmit="return validabusqueda(this)">
<?
	if($_GET['facturando'])
	{
		?>	
		<input type="hidden" name="facturando" value="<?echo $_GET['facturando']; ?>">
		<?
	}
	if($_GET['consultando'])
	{
		?>	
		<input type="hidden" name="consultando" value="<?echo $_GET['consultando']; ?>">
		<?
	}
?>
  <table width="200" border="0" cellpadding="0" cellspacing="0" class="buscarTable">
    <tr>
      <td nowrap> <b>Buscar</b> 
        <input type="text" name="buscar" value="<?php if(!empty($_GET['buscar']))echo $_GET['buscar']; ?>">
			<input type="hidden" name="tipo" value="<?echo $_GET['tipo']; ?>">
   <input name="Submit" type="submit" class="boton" value="Buscar">
 
 </tr>
 
</table>
</form>
<!-- buscar engine -->


<?php

//include_once("../manejadordb.php");
$objempleados=new manejadordb;
$tipo = $_GET['tipo'];

$sql_pendiente="select * from tbl_facturas where estatus_factura='0'";
$result_pendiente = $objempleados->consultar($sql_pendiente);//Se conecta al servidor remoto
if ($rowpendiente = mysql_fetch_array($result_pendiente)) 
{
	do 
	{
		echo $rowpendiente["cod_factura"]."-*-".$rowpendiente["vendedor"]."-*-".$rowpendiente["sucursal"]."<br>";
		if ($objempleados->delfactura($rowpendiente["cod_factura"],$rowpendiente["vendedor"],$rowpendiente["sucursal"])==true){
			echo "factura pendiente eliminads correctamente_2";
		}else{
			echo "Ocurrio un error";
		}

	} while ($rowpendiente = mysql_fetch_array($result_pendiente));

}

$sql_itempendiente="select * from tbl_itemfactura where estatus_cancelacion='0'";
$result_itempendiente = $objempleados->consultar($sql_itempendiente);//Se conecta al servidor remoto
if ($rowitempendiente = mysql_fetch_array($result_itempendiente)) 
{
	do 
	{
		echo $rowitempendiente["cod_producto"]."-*-".$rowitempendiente["cod_factura"]."-*-".$rowitempendiente["vendedor"]."-*-".$rowitempendiente["sucursal"]."<br>";
		if ($objempleados->delitems($rowitempendiente["cod_factura"],$rowitempendiente["vendedor"],$rowitempendiente["sucursal"])==true){
		echo "item pendients eliminado correctamente_1";
		}else{
			echo "Ocurrio un error";
		}

	} while ($rowitempendiente = mysql_fetch_array($result_itempendiente));

}

//die();
//Busqueda de clientes
	$query = "SELECT * FROM tbl_cliente WHERE cli_cedula = '".addslashes($_GET['buscar'])."'";
 
	
 //die($query);
 // ************* end of buscar *****************/  
 //$result = $objempleados->consultar_remoto($query);//Se conecta al servidor local
 $result = $objempleados->consultar_remoto($query);//Se conecta al servidor remoto
 $numrows = mysql_num_rows($result); // result of count query


 
 if($numrows == 0 && !empty($_GET['buscar'])) //No se encuentra el dato buscado
 {
 ?>
    <b>No Existe el Cliente</b><br><br>
         <a href="javascript:history.back();">[Regresar]</a>
		 <script type="text/javascript">new LITBox('../funciones/addclientes.php?facturando=1&tipo=<?echo $tipo;?>&buscar=<?echo $_GET['buscar'];?>',{type:'window',overlay:false,height:370, width:550})</script>
	<?
 }
 else //se ha encontrado el dato en la tabla clientes
 {
	
	if(empty($_GET['buscar'])&& $_GET['facturando'])
	{
		if($_GET['tipo']=='m')
		{
			?>
			<div align=center><b><font color=blue size=4>POR FAVOR INTRODUZCA LOS DATOS AL CLIENTE PARA CARGAR LA FACTURA<br>PREFERIBLEMENTE SIN PUNTOS NI ESPACIOS</font></b></div>
			<?
		}
		elseif($_GET['tipo']=='n')
		{
			?>
			<div align=center><b><font color=blue size=4>POR FAVOR PIDALE LOS DATOS AL CLIENTE PARA HACER LA FACTURA<br>PREFERIBLEMENTE SIN PUNTOS NI ESPACIOS</font></b></div>
			<?
		}
		
		
	}
	else
	{
		//die("-*->".$tipo);
		//echo our table
		
		if($_GET['consultando'])
		{
			?>
			<table class="Mtable border="0" width="100%" cellpadding="0" cellspacing="0">    
				<th><? echo ucfirst("C&eacute;dula");?></th>
				<th><? echo ucfirst("Nombre y Apellido");?></th>
				<th><? echo ucfirst("Direcci&oacute;n");?></th>
				<th><? echo ucfirst("Tel&eacute;fono");?></th>
				<th><? echo ucfirst("Celular");?></th>
				<th><? echo ucfirst("Tarjeta BonoLibro");?></th>
				<th><? echo ucfirst("Empresa");?></th>
				<th><? echo ucfirst("Opciones");?></th>
			 <?
			 $i = 0;
		 }
		 while ($row = mysql_fetch_assoc($result)) 
		 { 
			$cedula=$row["cli_cedula"]."".$tipo;
			if($_GET['facturando'])
			{
				?>	
				<script type="text/javascript">enviardatos("<?echo $cedula?>");</script>
				<?
			}
			
			// alternate color
			if($i%2 == 0)
			{
			?>
				<tr class="TRalter">
			<?
			}
			else
			{
			?>
				<tr>
			<?
			}
			
			$cedula=$row["cli_cedula"]."".$tipo;
			
			 ?>
			<td align='left'><?echo $row["cli_cedula"]?></td>
			<?
			 if(strlen(strlen($row['cli_direccion'])>10 || strlen($row['cli_empresa'])>10))
			 {
				$pts="...";
			 }else $pts="";
			 ?>
			 <td align='left'><?echo strtoupper($row["cli_nombre"])?></td>
			 <td align='left'><?echo strtoupper(substr($row["cli_direccion"],0,10).$pts)?></td>
			 <td align='right'><?echo $row["cli_telefonohab"]?></td>;
			 <td align='right'><?echo $row["cli_celular"]?></td>
			 <td align='right'><?echo $row["cli_tarjetabl"]?></td>
			 <td align='left'><?echo strtoupper(substr($row["cli_empresa"],0,10).$pts)?></td>
			 <td align='center'><input name='radio' class='boton' type='button' value='Editar' onClick='editarcliente("<?echo $row["cli_cedula"]?>")'></td>
			</tr>
			<?
			$i++;    
		 } 
  
		 echo "</table>\n";
     }
     mysql_free_result($result);
 }
?>


<a href='' onClick="javascript:window.close(this)"  style="border:groove;background-color:#CCCCCC;"><img src='../imagenes/salir.png' border="0"> Salir</a>
 
 <?
		if($_GET['tipo']=='m')
		{
			?>
			<div align='center'><img src="../imagenes/talonario.jpg" /></div>
			<?
		}
?>
</body>
</html>
