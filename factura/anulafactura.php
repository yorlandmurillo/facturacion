<?php
include_once("manejadordb.php");
require("admin/session.php");// // incluir motor de autentificación.
?>
<script language="javascript">
function esc(){
	window.close(this);
}

</script>
<?
$codf=$_POST['codf'];
$vend=$_POST['vend'];
$suc=$_POST['suc'];
$fecha=$_POST['fecha'];
//die($codf."-*-".$vend."-*-".$suc);
$obj=new manejadordb;

if(isset($codf) && !empty($codf) && isset($suc) && !empty($suc) && isset($vend) && !empty($vend))  
{
	
	if($obj->cancelafactura($codf,$vend,$suc)==true)
	{
		echo "<br><br><div align=center><b>La Factura ".$codf." ha sido anulada correctamente</b></div><br>";
	}
	else
	{
		echo "Ocurrio un error al anular la factura";
	}
	if ($obj->cancelaitems($codf,$vend,$suc)==true)
	{
		echo "<div align=center><b>Los detalles de factura ".$codf." han sido anulados correctamente</b></div><br>";
	}else
	{
		echo "Ocurrio un error al anular los detalles";
	}

}
?>
<br><br>
<form>
<div align="center">
<!--<input name="salir" type="button" class="botones" onclick="esc()" value="Salir" />-->
  </div>
</form>
