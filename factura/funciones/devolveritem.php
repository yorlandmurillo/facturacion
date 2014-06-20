<? 
require("../admin/session.php");// // incluir motor de autentificación.

$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.


$obj=new manejadordb;

$factura=$_POST['codf'];
$items=$_POST['item'];
$user=$_SESSION['usuario_id'];
$suc=$_SESSION['usuario_sucursal'];
$cant=$_POST['cant'];	

if($cant>0){

if($obj->devolveritem($items,$suc,$cant)==true){
	echo utf8_encode("Item devuelto con éxito");

}else echo utf8_encode("Falló la devolución");

}else echo utf8_encode("Especifique la cantidad a devolver");

?>