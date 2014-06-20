<?php
require("admin/session.php");// // incluir motor de autentificación.

$obj=new manejadordb;


$userd=$_POST['userdest'];
$cadena =$_POST['mensaje'];
$count=0;

for($i=0;$i<strlen($cadena); $i++){

  if($count==45 && substr_count($cadena[$i],"\n")==0){
  $cad.="\n";  
  $count=0; 
  }	
  $cad.=$cadena[$i];

$count++;
 
}

$mensaje=$cad;

$sucursal=$_SESSION['usuario_sucursal'];
$usuario=$_SESSION['usuario_nombre'];
$iduser=$_SESSION['usuario_id'];

if($usuario=='') $usuario='anonimo';
if($mensaje=='') $mensaje='ningun mensaje';

$query = "INSERT INTO tbl_chat (usuario,mensaje,sucursal,fecha,iduser,iduserd) VALUES ('$usuario','$mensaje',$sucursal,NOW(),$iduser,$userd)";

$obj->query($query);

//mysql_query($query);
//eliminando registros si estos superarn los 10
$max=5;
$NroRegistros=mysql_num_rows($obj->consultar("SELECT * FROM tbl_chat"));
if($NroRegistros>$max){
	$NroAEliminar=$NroRegistros-$max;
//	$sql="DELETE FROM tbl_chat ORDER BY fecha ASC LIMIT $NroAEliminar";
	$sql="update tbl_chat set estatus=2 ORDER BY fecha ASC LIMIT $NroAEliminar";
	$obj->query($sql);
}
?>