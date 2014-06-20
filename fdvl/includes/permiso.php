<?php
function verificar_permiso($login,$nivel)
{
	include("includes/conexion.php");
	$link=conectarse();
	$str_qry="select * from inv_permiso where per_login = '".$login ."' and per_nivel = '".$nivel ."'";
	$result=mysql_query($str_qry,$link);
	if($row = mysql_fetch_array($result)){
		mysql_free_result($result);
		mysql_close($link);
		return true;
	}else{
		mysql_free_result($result);
		mysql_close($link);
		return false;
	}
}
?>
