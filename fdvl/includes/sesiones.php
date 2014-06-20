<?php
  $conectado = false;
  
  $login_usuario  = $_SESSION['login_usuario'];  
  $password =	$_SESSION['sucursal'] ;

	if(!is_null($login_usuario))
	{
		$conectado = true;
	}     
?>    
