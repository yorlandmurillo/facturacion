<? 
require("../admin/session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.

function getIP() {
$ip= shell_exec("wget -q -O - checkip.dyndns.org|sed -e 's/.*Current IP Address://' -e 's/<.*$//'");


return $ip; 
} 

function getRealIP()
{

   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );

      // los proxys van añadiendo al final de esta cabecera
      // las direcciones ip que van "ocultando". Para localizar la ip real
      // del usuario se comienza a mirar por el principio hasta encontrar
      // una dirección ip que no sea del rango privado. En caso de no
      // encontrarse ninguna se toma como valor el REMOTE_ADDR

      $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

      reset($entries);
      while (list(, $entry) = each($entries))
      {
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+)/", $entry, $ip_list) )
         {
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\\./',
                  '/^127\\.0\\.0\\.1/',
                  '/^192\\.168\\..*/',
                  '/^172\\.((1[6-9])|(2[0-9])|(3[0-1]))\\..*/',
                  '/^10\\..*/');

            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

            if ($client_ip != $found_ip)
            {
               $client_ip = $found_ip;
               break;
            }
         }
      }
   }
   else
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );
   }

   return $client_ip;

}




if ($_SESSION['usuario_nivel']<$nivel_acceso && $_SESSION['usuario_nivel']!=2){

echo utf8_encode("Usted no tiene permisos para realizar esta operación");

}else{
$obj=new manejadordb;
/*Tipo de Registro
1= Registrar un item de una solicitud
2= Registrar una solicitud
3= Registrar un traslado
4= Modificar un traslado
*/

$tiporegistro=trim($_POST['tipor']);

if($tiporegistro==1){

$iplocal=getIP();
$ipremota=trim($_POST['ipremota']);
$puerto=trim($_POST['puerto']);
$sucursal=trim($_POST['sucursal']);
$tiempo=trim($_POST['tiempo']);
$lpf=trim($_POST['lpf']);
$lpfm=trim($_POST['lpfm']);
$cantfact=trim($_POST['cantfact']);
$version=trim($_POST['version']);


if($ipremota!="" && $puerto!="" && $lpf>=0 && $lpfm >= 0 && $cantfact >= 0 && $cantfact <= 2){

if($obj->query("insert into tbl_preferencias (sucursal_id,ipservidor,iplocal,ptoimpresora,tiemposincro,version,libros_pf,libros_pfm,cant_facturas,creada_por,f_creacion)values($sucursal,'$ipremota','$iplocal','$puerto',$tiempo,'$version',$lpf,$lpfm,$cantfact,".$_SESSION['usuario_id'].",'".date('y-m-d h:i:s')."')")==true){
echo utf8_encode("Operación realizada con éxito");
}else echo utf8_encode("No se pudo realizar el registro");

}else echo utf8_encode("Error al procesar la operación por favor verifique los datos");

}elseif($tiporegistro==2){

$iplocal=getIP();//trim($_POST['iplocal']);
$ipremota=trim($_POST['ipremota']);
$puerto=trim($_POST['puerto']);
$sucursal=trim($_POST['sucursal']);
$tiempo=trim($_POST['tiempo']);
$lpf=trim($_POST['lpf']);
$lpfm=trim($_POST['lpfm']);
$cantfact=trim($_POST['cantfact']);
$version=trim($_POST['version']);

if($ipremota!="" && $puerto!="" && $lpf>=0 && $lpfm >= 0 && $cantfact >= 0 && $cantfact <= 2){
		if($obj->query("update tbl_preferencias set ipservidor='$ipremota',iplocal='$iplocal',ptoimpresora='$puerto',tiemposincro=$tiempo,version='$version',libros_pf=$lpf,libros_pfm=$lpfm,cant_facturas=$cantfact,mod_por=".$_SESSION['usuario_id'].",f_modificacion='".date('y-m-d h:i:s')."' where sucursal_id=$sucursal;")==true){
echo utf8_encode("Operación realizada con éxito");
}else echo utf8_encode("Error al conectar con la base de datos");
}else echo utf8_encode("Error al procesar la operación por favor verifique los datos");

}elseif($tiporegistro==3){

$iplocal=getIP();
$obj->query("update tbl_preferencias set iplocal='$iplocal' where sucursal_id=".$_SESSION['usuario_sucursal'].";");
}

}
?>