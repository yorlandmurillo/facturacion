<?
function timeout(){
require("aut_config.inc.php");
require("session.php");
$b=new base();
$link=$b->conectar();
$b->ejecutar("SELECT * FROM seguridad",$link);
if(mysql_num_rows($b->getresult())>0){
$timeout=mysql_result($b->getresult(),0,"timeout");
}
$b->ejecutar("select * from sesiones where id_user=".$_SESSION['usuario_id']."",$link);
if(mysql_num_rows($b->getresult())>0){
 $fechaGuardada=mysql_result($b->getresult(),0,"sesiones_us_ex");
}
$anio=date("Y");
$mese=date("m");
$dia=date("d");
$hora=date("H")-1;
$minuto=date("i");
$segundo=date("s");
$ahora=$anio."-".$mese."-".$dia." ".$hora.":".$minuto.":".$segundo;
//$ahora = date("Y-n-j H:i:s");
     $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
    //comparamos el tiempo transcurrido
     if($tiempo_transcurrido >= $timeout) {
	 $b->ejecutar("UPDATE log_sesiones s SET sesiones_us_ex='$ahora',expirada=1 where id_user=".$_SESSION['usuario_id']." and expirada=0",$link);
     //si pasaron 10 minutos o más
      session_destroy(); // destruyo la sesión
      header("Location: login.php"); //envío al usuario a la pag. de autenticación
      //sino, actualizo la fecha de la sesión
    }else {
    $_SESSION["ultimoAcceso"] = $ahora;
	$b->ejecutar("UPDATE sesiones s SET sesiones_us_ex='$ahora' where id_user=".$_SESSION['usuario_id']."",$link);
   }
}
?>