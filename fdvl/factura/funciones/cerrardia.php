<? 
require("../admin/session.php"); // incluir motor de autentificación.
include_once('../clases/factura.php');

$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.
$factura=new factura();


if ($_SESSION['usuario_nivel']==$nivel_acceso || $_SESSION['usuario_nivel']==2){

	if($factura->verificarcierredia()==true){
		if($factura->cerrardia($_SESSION['usuario_id'],$_SESSION['usuario_sucursal'])==true){
		
			echo utf8_encode("Cierre procesado con éxito");
			
		}else echo "No existen facturas que procesar";
		
	}else echo utf8_encode("El día ya fue cerrado");

}else{
echo utf8_encode("Ud. no tiene permisos para realizar esta operación");}
?>