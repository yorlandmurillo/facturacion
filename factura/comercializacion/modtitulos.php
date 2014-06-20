<?
require("../admin/session.php"); // incluir motor de autentificación.
$nivel_acceso=1;// definir nivel de acceso para esta página.
//die("Estoy aqui !!!!");
?>
<script language="JavaScript" type="text/javascript">

function esc(){
	window.close(this);
}
</script>
<?
if ($_SESSION['usuario_nivel']<$nivel_acceso && $_SESSION['usuario_nivel']!=2){

echo '<div align="center"><h1>Usted no tiene pérmiso para acceder a esta página</h1></div>';
echo '<div align="center"><input type="button" value="Salir" onClick="Javascript:window.close(this)" style="border:double;background-color:#990000;text-align:center;color:#FFFFFF;" ></div>';
/*echo '<script language="javascript">window.close(this)</script>';*/
//Header ("Location: ../admin/login.php?error_login=5");
//exit;
}
else
{
	$obj=new manejadordb;
	if($_POST['actualiza'])
	{ 
		$codigo=$_POST['codigo'];
		$precio=$_POST['precio'];
		$cantidad=$_POST['cantidad'];
		
		$cod_barra=$_POST['cod_barra'];
		

		
		$sql_act_inventario="update tbl_inventario set precio='$precio', cod_barra='$cod_barra' where cod_producto='$codigo'";
		if($obj->consultar_remoto($sql_act_inventario))
		{
			//die($sql_act_inventario);
			$sql_actualiza="update tbl_distinventario set cantidad='$cantidad', cod_barra='$cod_barra' where cod_producto='$codigo'";
			if($obj->consultar_remoto($sql_actualiza))
			{
			?>
			<div align=center>
				<font size=5><b>El registro <? echo $codigo?> ha sido actualizado</b></font>
				
					<br><br>
			<input name="salir" type="button" class="botones" onclick="esc()" value="Salir" /></font></div>
				<?
			}
		}
	}
	else
	{
	
		$codigol=$_GET['codigol'];
		$origen=getenv("HTTP_REFERER"); 
		$busca_distinventario = "SELECT * FROM tbl_distinventario where cod_producto='$codigol'";
		//$result_distinventario = $obj->consultar($busca_distinventario);
		$result_distinventario = $obj->consultar_remoto($busca_distinventario);
		
		
		if ($myrow = mysql_fetch_array($result_distinventario)) 
		{
		$cod_producto=$myrow["cod_producto"];
			$descripcion=$myrow["descripcion"];
			$autor=$myrow["autor"];
			$editorial=$myrow["editorial"];
			$cod_barra=$myrow["cod_barra"];
			$cantidad=$myrow["cantidad"];
		}
		
		$buscalibrod="select * from tbl_inventario where cod_producto='$codigol'";
		//$resultbuscalibro = $obj->consultar($buscalibrod);
		$resultbuscalibro = $obj->consultar_remoto($buscalibrod);
		if ($rowlibro1= mysql_fetch_array($resultbuscalibro)) 
		{
			$precio=$rowlibro1['precio'];
		}
		
		?>
		
			<font size=5><b> <? echo $cod_producto ?></b><br>
			<font size=5><b> <? echo $descripcion ?></b><br>
			<? echo $autor ?><br>
			<? echo $editorial ?><br>
			<form action=""  method="post">
			
			
				 CODIGO
			 <input type="text" onkeypress="return pulsar(event)" name="codigo" size="10" maxlength="50" value="<?echo $codigol?>" readonly="readonly" ><br>
					PRECIO
			 <input type="text" onkeypress="return pulsar(event)" name="precio" size="4" maxlength="4" value="<?echo $precio?>"
			 <?
				
			if($_SESSION['usuario_nivel']==1)
			{
				?>
				readonly="readonly"
			 <?
			}
			?>
			 ></font><br><br>
				CANTIDAD
			 <input type="text" onkeypress="return pulsar(event)" name="cantidad" size="4" maxlength="50" value="<?echo $cantidad?>"
			  <?
				
			if($_SESSION['usuario_nivel']==1)
			{
				?>
				readonly="readonly"
			 <?
			}
			?>
			 ></font><br><br>
			 <font size=4>CODIGO DE BARRAS
		  <input type="text" onkeypress="return pulsar(event)" name="cod_barra" size="50" maxlength="50" value="<?echo $cod_barra?>"><br><br>

			  <b><div align='center'><input type="submit" name="actualiza" value="ACTUALIZAR" />  </div></b>
			
		  
		  
		 </form>
		 <?
		
		
	}



}
