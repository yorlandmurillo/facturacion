<?php
if($_GET['start'])
	$l=$_GET['start'];
elseif($_GET['back'])
	$l=$_GET['back'];
else
	$l=1;
$maxp=10;
$end=20;

//echo "-*->".$l,"<br>";
if($l>1)
{
	?>
	<a href="cadenas.php?back=<?echo $l-1;?>"><=</a>
	<?
}
for($i=0;$i<$maxp;$i++)
{
	echo ($l+$i)."  ";
}
$ult=$l+$i-1;
if($ult<$end)
{
	?>
	<a href="cadenas.php?start=<?echo $l+1;?>">=></a>
	<?
}

?>

