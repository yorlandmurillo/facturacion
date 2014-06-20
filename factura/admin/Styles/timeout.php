<?
require("aut_verifica.inc.php");
$_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s"); 
	   //sino, calculamos el tiempo transcurrido
     $fechaGuardada = $_SESSION["ultimoAcceso"];
     $ahora = date("Y-n-j H:i:s");
     $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
    //comparamos el tiempo transcurrido
     if($tiempo_transcurrido >= 6) {
     //si pasaron 10 minutos o más
      session_destroy(); // destruyo la sesión
      header("Location: index.php"); //envío al usuario a la pag. de autenticación
      //sino, actualizo la fecha de la sesión
    }else {
    $_SESSION["ultimoAcceso"] = $ahora;
   }

?>