
<?php
  $conectado = false; 
  if(!session_is_registered('login_usuario'))
    {session_register('login_usuario');}
  $login_usuario  = $_SESSION['login_usuario'];  
  if(!is_null($login_usuario))
    {$conectado = true;}     
?>    
