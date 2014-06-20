<? 
require("../admin/session.php");// // incluir motor de autentificación.
include_once('../clases/factura.php');
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=2;// definir nivel de acceso para esta página.
$origen=getenv("HTTP_REFERER"); 

if ($_SESSION['usuario_nivel']!=$nivel_acceso && $_SESSION['usuario_nivel']!=2){
echo '<div align="center"><h1>Usted no tiene pérmiso para acceder a esta página</h1></div>';
echo '<div align="center"><input type="button" value="Salir" onClick="Javascript:location.reload(true)" style="border:double;background-color:#990000;text-align:center;color:#FFFFFF;" ></div>';
/*echo '<script language="javascript">window.close(this)</script>';*/
//Header ("Location: ../admin/login.php?error_login=5");
//exit;
}else{
$obj=new manejadordb;
$obj2=new factura;

@ $factura=$_GET['codf'];
@ $cliente=$_GET['cliente'];
$user=$_SESSION['usuario_id'];
$suc=$_SESSION['usuario_sucursal'];

$codigof="D".$factura;
if($obj->verificardev($codigof)==0){
$factd="D".$factura;


$fecha=$obj2->getfechamysql();
$origen="../consultas/facturas.php"; 

$row = mysql_fetch_assoc($obj->consultar("select correlativo from tbl_facturas order by correlativo desc"));
$cod=$row['correlativo']+1;
$obj->query("INSERT INTO tbl_facturas (cod_factura,fecha_factura,cod_cliente,vendedor,sucursal,correlativo,tipofactura)VALUES('$factd','$fecha',$cliente,$user,$suc,$cod,2);");

}else $factd="Devuelta";

$query = "SELECT * FROM tbl_itemfactura where cod_factura='$factura' and sucursal=$suc ";
$result = $obj->consultar($query);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Devoluci&oacute;n de Facturas</title>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function validarnum(obj,valores){
	if(valores==1)
		cadena="0123456789."
	else if(valores==2)
	    	cadena=" abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.,-"
	else if (valores==3)
		cadena="0123456789"
		
	var val2=obj.value.length
	
	for(i=0;(i<obj.value.length)&&(val2==obj.value.length);i++){
		var car=obj.value.substr(i,1)
		val=0
		for(j=0;(j<cadena.length)&&(val==0);j++)
			if(car==cadena.substr(j,1)) val=1
		if(val==0)
			val2=i;
	}
	obj.value=obj.value.substr(0,val2)
}

//-->
</script>
</head>
<a href="<?= $origen; ?>" style="border:double;background-color:#FFFFFF;text-decoration:inherit;border-bottom-style:double"><img src='../imagenes/salir.png' border="0"> Volver</a>
<style>
.campo{
    border:double;
	border-color:#CCCCCC;
	background-color:#990000;
	color:#FFFFFF;
}
.sinborde{
    border:none;
}
input { border: 1px solid red;background-color:#EFEFEF;text-align:right;}

td.activetab {
    background-color: silver;
}
.style1 {border: double; border-color: #CCCCCC; background-color: #FFFFFF; color: #FFFFFF; }
.selecionada:hover{
	background:#CCCCCC;
}

</style>
<body>
<div align="center" id="resultado"></div>

<form id="devolucion" name="devolucion" action="" >
<input type="hidden" name="usid" id="usid" value="<?= $user;?>">
<input type="hidden" name="sucursal" id="sucursal" value="<?= $suc;?>">
<input type="hidden" name="cliente" id="cliente" value="<?= $cliente;?>">

<br>
<table width="669" height="202" border="0" align="center" cellpadding="0" cellspacing="0" id="table1" style="border:double;border-color:#990000;border-bottom-style:groove;" widtd="398">
  <tr>
    <th height="32" colspan="7" class="campo">Devoluci&oacute;n</th>
  </tr>
  <tr>
    <th width="71" height="27" class="campo"> <div align="left">Factura:</div></th>
    <th width="238" height="27"><div align="left">
      <input type="text" name="codf" id="codf" size="18" maxlengtd="15" value="<?= $factura;?>"  readonly="true" />
    </div></th>
    <th width="100" height="27">&nbsp;</th>
    <td width="63" >&nbsp;</td>
    <th colspan="2">&nbsp;</th>
    <th width="32">&nbsp;</th>
  </tr>
  <tr>
    <th height="28" colspan="7">Detalle de Factura</th>
  </tr>
  <tr>
    <th height="23">&nbsp;</th>
    <th height="23">&nbsp;</th>
    <th height="23">&nbsp;</th>
    <th height="23">&nbsp;</th>
    <th height="23" colspan="2">&nbsp;</th>
    <th height="23">&nbsp;</th>
  </tr>
  <tr>
    <th height="19" class="campo">C&oacute;digo</th>
    <th class="campo">Descripci&oacute;n</th>
    <th class="campo">Precio</th>
    <th class="campo">Cant.</th>
    <th width="70" class="campo">Estatus</th>
    <th width="87" class="campo">C. Dev </th>
    <th class="campo">*</th>
  </tr>
  <?
  	$band=0;	
	if($factd=="Devuelta")$band=1;
	while($row = mysql_fetch_assoc($result)){
	$id=$row['id_itemfactura'];
	$cand=$row['cif']+$row['cic']+$row['cicdn'];
	$dev=$row['cantidad']-$cand;
	echo "<tr class='selecionada' >";
	echo "<td width='85' height='5' align='left' class='selecionada'>".$row['cod_producto']."</td>";
	echo "<td width='389' height='5' align='left' class='selecionada'>".$row['descripcion']."</td>";
	echo "<td width='141' height='5' align='right'class='selecionada'>".number_format($row['precio_unid'],2,',','.')."</td>";
	echo "<td width='77'  height='5' align='center' class='selecionada'>".$row['cantidad']."</td>";
	echo "<td width='72' height='5' align='center'  class='selecionada'>".$obj->setestatus($row['devuelto'])."</td>";
	echo "<td width='72' height='5' align='center'  class='selecionada'>".$dev."</td>";
	if($band!=1){
	if($row['devuelto']==15 && $cand==0){
	echo "<td width='72' height='5' align='center'  class='selecionada' ><input type='radio' id='items' name='items' value='".$id."' onclick=\"cantidad('".$id."')\" disabled='true'></td>";
	}else{
	echo "<td width='72' height='5' align='center'  class='selecionada' ><input type='radio' id='items' name='items' value='".$id."' onclick=\"cantidad('".$id."')\" ></td>";
	}
	}
	echo "	</tr>";
	}
	
	?>
  <tr>
    <th colspan="7">&nbsp;</th>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <th colspan="2" align="right">Cantidad a devolver:</th>
    <th align="right"> <div id="cantidad"> </div></th>
    <th colspan="3" align="right"><input type="button" name="devolver" class="campo" value="Devolver" onclick="devolveritem();return false" /></th>
  </tr>
</table>
<br/>
<? if($factd!="Devuelta"){?>
<table width="772" height="202" border="0" align="center" cellpadding="0" cellspacing="0" style="border:double;border-color:#990000;border-bottom-style:groove;" widtd="398">
  <tr>
    <th height="32" colspan="7" class="campo">Cambios</th>
  </tr>
  <tr>
    <th width="99" height="27" class="campo"><div align="left">Cantidad:</div></th>
    <th width="49" height="27" align="left"><select name="cantitems" id="cantitems">
      <?
	$i=0;
	while($i<=100){
		echo '<option value='.$i.'>'.$i.'</option>';
	$i++;
	}
	?>
    </select>    </th>
    <th width="122" height="27" align="right" class="campo">C&oacute;digo:</th>
    <th width="120" align="right"><input type="text" name="codp" id="codp" size="18" maxlengtd="15" value="" onkeypress="iSubmitEnter(event,document.devolucion)" /></th>
    <th height="27" colspan="2"><div align="left">
      <input type="button" name="agregar" class="campo" value="Agregar" onclick="agregaritem();return false" />
    </div></th>
    <td width="136" >&nbsp;</td>
  </tr>
  <tr>
    <th height="28" colspan="7"> Agregar articulos nuevos</th>
  </tr>
  <tr>
    <th height="23" colspan="7" align="left">Devoluci&oacute;n N&deg;:
      <input type="text" name="codfdv" id="codfdv" size="18" maxlengtd="15" value="<?= $factd;?>" readonly="true" /></th>
  </tr>
  <tr>
    <th height="19" class="campo">C&oacute;digo</th>
    <th colspan="3" class="campo">Descripci&oacute;n</th>
    <th width="145" class="campo">Precio</th>
    <th width="93" align="center" class="campo">Cant.</th>
    <th class="campo">% Desc.</th>
  </tr>
  <? 
  	$total=0;
	$filas= $obj->consultar("select * from tbl_itemfactura where cod_factura='$factd' and sucursal=$suc ");
	while($items = mysql_fetch_array($filas)){
	$total=$total+($items['precio_unid']*$items['cantidad']);
	echo "<tr ondblclick=\"borraritem('".$items['id_itemfactura']."','".$items['cod_producto']."','".$items['cantidad']."','".$suc."');return false\" class='selecionada' >";
	echo "<th height='19' >".$items['cod_producto']."</th>";
	echo "<th colspan='3' align='left'>".$items['descripcion']."</th>";
	echo "<th align='right'>".number_format($items['precio_unid'],2,',','.')."</th>";
	echo "<th width='102' >".$items['cantidad']."</th>";
	echo "<th>".$items['descuento']."</th>";
	echo "	</tr>";
	}
	?>
  <tr>
    <th colspan="7">&nbsp;</th>
  </tr>
   <?  

	  $sql1 = "SELECT * FROM tbl_itemfactura where cod_factura='$factura' and sucursal=$suc and devuelto=15";
	  $r1 = $obj->consultar($sql1);
	  
	  while($fila1 = mysql_fetch_assoc($r1)){
	  $cant=$fila1['cif']+$fila1['cic']+$fila1['cicdn'];
	  $cantdev=$fila1['cantidad']-$cant;
	  $montodev=$montodev+($fila1['precio_unid']*$cantdev);
	  
	  }
	  $sql = "SELECT * FROM tbl_facturas where cod_factura='$factura' and sucursal=$suc ";
	  $r = $obj->consultar($sql);
	  $fila = mysql_fetch_assoc($r);
	?>
  <tr>
    <th>&nbsp;</th>
    <th colspan="3" align="right">&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th align="left">Sub-Total</th>
    <th><input type="hidden" name="subtotal" id="subtotal" size="18" maxlengtd="15" value="<?= $total;?>" />
      <input type="text" name="subtotal1" id="subtotal1" size="18" maxlengtd="15" value="<?= number_format($total,2,',','.');?>"  readonly="true" /></th>
  </tr>
  <tr>
    <th colspan="2" align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th align="left">0% IVA</th>
    <th><input type="hidden" name="iva" id="iva" size="18" maxlengtd="15" value="0" />
      <input type="text" name="iva1" id="iva1" size="18" maxlengtd="15" value="0"  readonly="true" /></th>
  </tr>
  <tr>
    <th colspan="2" align="right">Monto Devuelto:</th>
    <th colspan="2"> <input type="hidden" name="montodev" id="montodev" size="18" maxlengtd="15" value="<?= $montodev;?>" />
        <input type="text" name="montodev1" id="montodev1" size="18" maxlengtd="15" value="<?= number_format($montodev,2,',','.');?>"  readonly="true" /></th>
    <th align="right">&nbsp;</th>
    <th align="left">Total:</th>
    <th>
	<input type="hidden" name="montototal1" id="montototal1" size="18" maxlengtd="15" value="<?= $total;?>" />
	<input type="text" name="montototal" id="montototal" size="18" maxlengtd="15" value="<?= number_format($total,2,',','.');?>"  readonly="true" /></th>
  </tr>
  <tr>
    <th colspan="2" align="right">Monto Factura:</th>
    <th colspan="2"> <input type="hidden" name="montofact" id="montofact" size="18" maxlengtd="15" value="<?= $fila['mto_total'];?>" />
        <input type="text" name="montofact1" id="montofact1" size="18" maxlengtd="15" value="<?= number_format($fila['mto_total'],2,',','.');?>" readonly="true" /></th>
    <th colspan="2" align="right">Saldo a Favor : </th>
    <th><input type="hidden" name="afavor" id="afavor" size="18" maxlengtd="15" value="<? if (($montodev-$total)>0) echo $montodev-$total; else echo "0"; ?>" />
	<input type="text" name="afavor" id="afavor" size="18" maxlengtd="15" value="<? if (($montodev-$total)>0) echo number_format($montodev-$total,2,',','.'); else echo number_format(0,2,',','.'); ?>"  readonly="true" /></th>
  </tr>
  <tr>
    <th colspan="2" align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
    <th colspan="2" align="right">Total Cancelar :</th>
    <th><input type="hidden" name="diferencia" id="diferencia" size="18" maxlengtd="15" value="<? if (($total-$montodev)>0) echo $total-$montodev; else echo "0";?>" />
      <input type="text" name="diferencial" id="diferencial" size="18" maxlengtd="15" value="<? if (($total-$montodev)>0) echo number_format($total-$montodev,2,',','.'); else echo number_format(0,2,',','.'); ?>"  readonly="true" /></th>
  </tr>
  <tr>
    <th colspan="4" align="center">Forma de Pago </th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="right">&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="left">Efectivo :</th>
    <th><input type="text" name="efectivo" id="efectivo" size="18" maxlengtd="15" value="0" onkeyup="validarnum(this,1)" /></th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="left">TDB :</th>
    <th><input type="text" name="tdb" id="tdb" size="18" maxlengtd="15" value="0" onkeyup="validarnum(this,1)" /></th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="left">TDC : </th>
    <th><input type="text" name="tdc" id="tdc" size="18" maxlengtd="15" value="0" onkeyup="validarnum(this,1)" /></th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="left">Bono Libro : </th>
    <th><input type="text" name="bl" id="bl" size="18" maxlengtd="15" value="0" onkeyup="validarnum(this,1)" /></th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="left">Especial : </th>
    <th><input type="text" name="especial" id="especial" size="18" maxlengtd="15" value="0" onkeyup="validarnum(this,1)" /></th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="left">Otra Moneda : </th>
    <th><input type="text" name="omoneda" id="omoneda" size="18" maxlengtd="15" value="0" onkeyup="validarnum(this,1)" /></th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="left">Cesta Ticket : </th>
    <th><input type="text" name="cesta" id="cesta" size="18" maxlengtd="15" value="0" onkeyup="validarnum(this,1)" /></th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="left">Cheque : </th>
    <th><input type="text" name="cheque" id="cheque" size="18" maxlengtd="15" value="0" onkeyup="validarnum(this,1)" /></th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="right">&nbsp;</th>
    <th>Nro. Cheque</th>
    <th>Nro. Cuenta </th>
    <th align="center">Banco</th>
    <th colspan="2" align="left">Nro. Conformaci&oacute;n </th>
  </tr>
  <tr>
    <th colspan="2" align="right">&nbsp;</th>
    <th><input type="text" name="nrocheque" id="nrocheque" size="18" maxlengtd="15" value="0" onkeyup="validarnum(this,3)" /></th>
    <th><input type="text" name="nrocuenta" id="nrocuenta" size="18" maxlengtd="15" value="0" onkeyup="validarnum(this,3)" /></th>
    <th align="right"><select name="bancos" id="bancos">
	<?
	$bancos= $obj->consultar("select * from tbl_bancos order by id_tbl_bancos");
	while($bco = mysql_fetch_array($bancos)){
	echo "<option value=".$bco['id_tbl_bancos'].">".$bco['banco']."</option>";
	}
	?>
    </select></th>
    <th colspan="2" align="left"><input type="text" name="nroconf" id="nroconf" size="18" maxlengtd="15" value="0" onkeyup="validarnum(this,3)" /></th>
  </tr>
  <tr>
    <th colspan="2" align="right">&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="right">&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="right">&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="right">&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="right">&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="2" align="right">&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th colspan="2">&nbsp;</th>
  </tr>
  
  <tr>
    <th>&nbsp;</th>
    <th colspan="3" align="right">&nbsp;</th>
    <th colspan="3" align="right"><input type="button" name="procesar" class="campo" value="Procesar" onclick="aceptardev();return false" />
      <input type="button" name="imprimir" class="campo" value="Imprimir" onclick="procesardev();return false" />
      <input type="button" name="cancelar" class="campo" value="Cancelar" onclick="cancelaritems()" /></th>
    </tr>
</table>
<? }else echo "<div align='center'><strong>LA FACTURA YA FUE DEVUELTA</strong></div>";?>
<p>&nbsp;</p>
</form>

</body>
</html>
<? }?>