<?
require("aut_verifica.inc.php");
$_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s"); 
	   //sino, calculamos el tiempo transcurrido
     $fechaGuardada = $_SESSION["ultimoAcceso"];
     $ahora = date("Y-n-j H:i:s");
     $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
    //comparamos el tiempo transcurrido
     if($tiempo_transcurrido >= 6) {
     //si pasaron 10 minutos o m�s
      session_destroy(); // destruyo la sesi�n
      header("Location: index.php"); //env�o al usuario a la pag. de autenticaci�n
      //sino, actualizo la fecha de la sesi�n
    }else {
    $_SESSION["ultimoAcceso"] = $ahora;
   }

?>