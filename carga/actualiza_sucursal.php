<?php
include 'conec.php';


$l=0;
if($_POST["Conectate"]) 
{
	$sucursal_actual=$_POST["nomsuc"];
	$arreglosuc=explode("-", $_POST["sucursal"]);
	$id_suc=$arreglosuc[0];
	$suc=$arreglosuc[1];
	$l=1;
	$libreria=str_replace(" ","_",$suc);
	mysql_query("update tbl_sucursal set id_sucursal='$id_suc',sucursal='$sucursal_actual'",$db);
	mysql_query("update tbl_distinventario set sucursal='$id_suc'",$db);
	mysql_query("update tbl_usuario set us_sucursal='$id_suc'",$db);

	header ("Location: ".$_SERVER['PHP_SELF']);
}
if($l==0)
{
	$select_sucursal="SELECT DISTINCT id_sucursal,sucursal
	FROM tbl_sucursal
	ORDER BY sucursal limit 0,1";
	$result_sucursal=mysql_query($select_sucursal,$db) or die($select_sucursal."<br>".mysql_error());
	 while($row_sucursal = mysql_fetch_row($result_sucursal))
	  {
		$id_sucursal=$row_sucursal[0];
		$sucursal_act=$row_sucursal[1];
	  }
	//echo $id_sucursal."<br>";
	
	$select="SELECT DISTINCT id_sucursal,sucursal
	FROM tbl_sucursal2
	ORDER BY sucursal";
	$result=mysql_query($select,$db) or die($select."<br>".mysql_error());
	?>
	<html>
	<head>
	<script language="JavaScript">
	function PrintValues(element){

	  var myString = document.mainform.sucursal.value
	  var myStringLength = myString.length
	  var Comma = myString.lastIndexOf('-')
	  var SufNumChars = Comma + 1
	  var id_suc='';
	
	
	  document.mainform.nomsuc.value=('');
	
	  for(i=0; i<4; i++) 
		id_suc+=(myString.charAt(i));
	
	//alert(id_suc);
		if(id_suc!='0000')
		{
			//document.mainform.nomsuc.style.visibility="hidden";
			document.mainform.nomsuc.style.visibility = 'hidden';
			document.mainform.nomsuc.style.display = 'none';
		}
		else
		{
			document.mainform.nomsuc.style.visibility = 'visible';
			document.mainform.nomsuc.style.display = '';
			document.getElementById(element).style.display = (document.getElementById(element).style.display == "none") ? "" : "none";
		}

	  //document.mainform.nomsuc.value+=(' ');

	  for(i=SufNumChars; i<myStringLength; i++) 
	  document.mainform.nomsuc.value+=(myString.charAt(i));

	}

</script>


	</head>
	<body Onload="PrintValues('secret')">
	<div align=center><font size=5 color=blue><b>ACTUALIZA SUCURSAL</b></font></div>
	<div align=center><font size=3 color=blue><b>FUNDACION LIBRERIAS DEL SUR</b></font></div>
	<div align=center><table border="2"><tr align="center"><td  bgcolor="#00FFFF"><font size=6 color="#610B0B"><b>SUCURSAL ACTUAL: <?echo $id_sucursal." - ".$sucursal_act;?></b></font></td></tr></table></div>
	<div align=center><font size=3><b>SELECCIONE LA SUCURSAL</b></font></div>
	<form name="mainform" method="post" action="<?echo $_SERVER['PHP_SELF'];?>">
	<table>
	 <tr>
	 <td valign="top">
	 <select name="sucursal" onchange="PrintValues('secret');"  target="_parent._top" onmouseclick="this.focus()">
	  <?php
	  while($row = mysql_fetch_row($result))
	   {
			if(trim($row[0])==trim($id_sucursal))
			{
				$sel="selected value";
				$id_s=$row[0];
				$suc=$row[1];
				if($row[0]=='00000')
				{
					$read=" readonly";
				}
			}
			else
			{
				$sel="value";
			}
	   ?>
	   <option <?php echo $sel; ?>="<?php echo $row[0]."-".$row[1]; ?>"><?php echo $row[1]; ?></option>
	   <?php
	   }    
	  ?>
	  </select>
	</td>
	<td>
	  <div id="secret" style="display: none;"><b>NOMBRE DE LA FERIA O EXPOVENTA</b>
	  <input type="text" name="nomsuc" size="30" maxlength="50"></div><br><br>
		</td>

	   <td valign="top"><input type="submit" name="Conectate" value="Actualizar" /></td></tr>
	  </table>
	 </form>
	</body>
	</html>
	<?
}
?>
