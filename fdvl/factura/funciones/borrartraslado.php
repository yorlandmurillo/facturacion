<? 
require("../admin/session.php"); // incluir motor de autentificaci�n.
include_once('../clases/factura.php');

$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma p�gina.
$nivel_acceso=2;// definir nivel de acceso para esta p�gina.
$obj=new manejadordb();
$objf=new factura();

$codt=trim($_POST['codt']);
$user=$_SESSION['usuario_id'];
$fecha=$objf->getfechamysql();

if ($_SESSION['usuario_nivel'] <= $nivel_acceso){

	if($obj->query("update tbl_traslados set estatus=13,cargadopor=$user,fechacarga='$fecha' where cod_traslado='$codt' ")==true){

		echo utf8_encode("Traslado borrado con �xito");

	}else echo utf8_encode("El traslado no pudo ser borrado");

}else{echo utf8_encode("Ud. no tiene permisos para realizar esta operaci�n");}
?>