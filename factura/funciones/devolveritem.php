<? 
require("../admin/session.php");// // incluir motor de autentificaci�n.

$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma p�gina.
$nivel_acceso=1;// definir nivel de acceso para esta p�gina.


$obj=new manejadordb;

$factura=$_POST['codf'];
$items=$_POST['item'];
$user=$_SESSION['usuario_id'];
$suc=$_SESSION['usuario_sucursal'];
$cant=$_POST['cant'];	

if($cant>0){

if($obj->devolveritem($items,$suc,$cant)==true){
	echo utf8_encode("Item devuelto con �xito");

}else echo utf8_encode("Fall� la devoluci�n");

}else echo utf8_encode("Especifique la cantidad a devolver");

?>