<?php
include 'conec.php';
?>

<script language="JavaScript" type="text/javascript">

function esc(){
	window.close(this);
}
</script>
<?

//	$obj=new manejadordb;
if($_POST['submit'])
{ 
	$codigo=$_POST['codigo'];
	$cantidad=$_POST['cantidad'];
	$sql_actualiza="update tbl_distinventario set cantidad='$cantidad'where cod_producto='$codigo'";
	if(mysql_query($sql_actualiza))
	{
	?>
	<div align=center>
		<font size=5><b>El registro <? echo $codigo?> ha sido actualizado</b></font>
		
			<br><br>
	<input name="salir" type="button" class="botones" onclick="esc()" value="Salir" /></font></div>
		<?
	}
}
else
{

	$codigol=$_GET['codigol'];
	$origen=getenv("HTTP_REFERER"); 
	$query = "SELECT * FROM tbl_distinventario where cod_producto='$codigol'";
	//die($query);
	$result = mysql_query($query);
	if ($myrow = mysql_fetch_array($result)) 
	{
	?>
		<font size=5><b> <? echo $myrow["cod_producto"] ?></b><br>
		<font size=5><b> <? echo $myrow["descripcion"] ?></b><br>
		<? echo $myrow["autor"] ?><br>
		<? echo $myrow["editorial"] ?><br>
		<form action=""  method="post"> 
		<input type="hidden" name="codigo" value="<?echo $myrow["cod_producto"]?>">
	 <font size=4><font size='5'>CANTIDAD
	 <input type="text" name="cantidad" size="4" maxlength="50" value="<?echo $myrow["cantidad"]?>"><br><br>
	  <b><div align='center'><input type="submit" name="submit" value="ACTUALIZAR" />  </div></b>
	 </form>
	 <?
	}
}
