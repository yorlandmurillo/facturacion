<?php
	session_start();
	if ( !isset($_SESSION['username']) && !isset($_SESSION['userid']) ){
		if ( @$idcnx = @mysql_connect('localhost','inventa_bd','Valenta@04') ){
			
			if ( @mysql_select_db('inventa_vicepresidencia',$idcnx) ){
				
				$sql = 'SELECT * FROM censo_user WHERE user="' . $_POST['login_username']. '" && passwd="' . $_POST['login_userpass'] . '" LIMIT 1';
				if ( @$res = @mysql_query($sql) ){
					if ( @mysql_num_rows($res) == 1 ){
						
						$user = @mysql_fetch_array($res);
						
						$_SESSION['username']	= $user['user'];
						$_SESSION['userid']	= $user['id'];
						$_SESSION['Nombre']	= $user['Nombre'];
						$_SESSION['Apellido']	= $user['Apellido'];
						$_SESSION['Nivel']	= $user['Nivel'];
						echo 1;
?>						
					
				
<?php

					}
										
					else
						echo 0;
				}
				else
					echo 0;
				
				
			}
			
			mysql_close($idcnx);
		}
		else
			echo 0;
	}
	else{
		echo 0;
	}
?>