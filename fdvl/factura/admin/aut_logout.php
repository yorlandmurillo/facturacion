<?
// Cargamos variables
require("session.php"); // incluir motor de autentificación.
include_once('../clases/factura.php');
require ("aut_config.inc.php");
$factura=new factura();

$factura->precierre($_SESSION['usuario_id'],$_SESSION['usuario_sucursal']);

session_destroy();
//exit();
Header ("Location: ../../index.php");
?>