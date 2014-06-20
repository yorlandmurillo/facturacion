<?php
include 'conec.php';
if($_GET['start'])
	$comienzo=$_GET['start'];
elseif($_GET['back'])
	$comienzo=$_GET['back'];
elseif($_GET['comienzo'])
	$comienzo=$_GET['comienzo'];
else
	$comienzo=1;

$limit=50;
if($_GET['pagina'])
{
	$pagina=$_GET['pagina'];
}
else
	$pagina=1;	

$select_todos="SELECT * from tbl_distinventario";
//die($select);
$result_todos = mysql_query($select_todos) or die ($select_todos."<br>".mysql_error());
$nf_items=mysql_num_rows($result_todos);
if($nf_items <= $limit)
{
	$pages=1;
}
else
{
	$cociente = floor($nf_items / $limit);
    $resto = $nf_items % $limit;
    if($resto > 0)
		$add=1;
	else $add=0;
	$pages=$cociente+$add;
}
$piso=$limit*($pagina-1);

/*************************************/






?>
<html>
<head>
</head>
<body>
<table border=1>
<tr><td width=1200>
<div align=center>
<?
$maxp=30;
$end=$pages;




?>
<table border=1>
<tr><td width=1200 align=center>
<div align=center><font size=4><? echo $pages." ";?>PAGINAS</font></div>
<?
if($comienzo>1)
{
	?>
	<a href="<?echo $_SERVER['PHP_SELF']?>?back=<?echo $comienzo-1;?>"><=</a>
	<?
}

for($i=0;$i<=$maxp;$i++)
{
	?>
	<a href="<?echo $_SERVER['PHP_SELF'];?>?pagina=<?echo ($comienzo+$i);?>&comienzo=<?echo ($comienzo);?>"><?echo ($comienzo+$i)."  ";?></a>
	<?
}

$ult=$comienzo+$i-1;
if($ult<$end)
{
	?>
	<a href="<?echo $_SERVER['PHP_SELF']?>?start=<?echo $comienzo+1;?>">=></a>
	<?
}

?>
</td></tr>
</table>



<table border=1>
<?
$select="SELECT * from tbl_distinventario limit $piso,$limit";
//die($select);
$result = mysql_query($select) or die ($select."<br>".mysql_error());
?>	
<br><br>
<div align=center><font size=5><b>LISTADO DE NOTAS DE BIENES</b></font></div>
 <?
 $num=1;
 //echo "<tr align=center><td></td><td><B>NOTA DE ENTREGA</B></td><td><B>PEDIDO</B></td><td><B>HORA</B></td><td><B>FECHA</td><td><B>OSERVACIONES</B></td></tr>";

  while($row = mysql_fetch_row($result))
   {
		echo "<tr><td>".$num."</td><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td></tr>";
		$num++;
		
   }    
 ?>
 </table>
 </div>
</body>
</html>
<?

