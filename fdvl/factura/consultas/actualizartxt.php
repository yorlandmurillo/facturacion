<?php
require_once ("thread_class.php");
include_once ("creartxt.php");

function actualizarlistado(){ 
$pathToPhp = "/usr/bin/php5";

$A = new Threader("$pathToPhp -f creartxt.php",null, "crear_archivo");

if ($A->active)
{
  //  echo "[Thread ".$A->threadName."] => " . $A->listen();
    
arreglo_libros();
}
}


?>
