<? 
require("../admin/session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=3;// definir nivel de acceso para esta página.

if ($_SESSION['usuario_nivel']!=$nivel_acceso && $_SESSION['usuario_nivel']!=2){

echo utf8_encode("Usted no tiene permisos para realizar esta operación");

}else{
$obj=new manejadordb;
$obj->detallesolicitud($obj->codigo('tbl_solicitud','id',3,$_SESSION['usuario_id']));
}
?>