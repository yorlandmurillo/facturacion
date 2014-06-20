<?php
// Inicializa de la sesion
session_start();
// Destruye todas las variables de la sesion
session_unset();
// Finalmente, destruye la sesion
session_destroy();
?> 
<title>Salida</title>
<!--Aqui hago una redireccion a la pagina principal inventario.php -->
<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=index.php"> 
