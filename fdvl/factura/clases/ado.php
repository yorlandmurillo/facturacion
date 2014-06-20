<?php
	class ado {
		var $conn;	
		var	$host;
		var	$banco;
		var	$user;
		var	$senha;
		var	$port;
		function db_connect() {
		}
		
		function db_name($banco,$conn) {
			echo "Este método no está disponíble en esta base de dados.";		
		}

		function query($sql) {
			echo "Este método no está disponíble en esta base de dados.";				
		}

		function to_array($res) {
			echo "Este método no está disponíble en esta base de dados.";				
		}
		
		function num_rows($res) {
			echo "Este método no está disponíble en esta base de dados.";				
		}

		function num_fields($res) {
			echo "Este método no está disponíble en esta base de dados.";				
		}

		function affected_rows($res) {
			echo "Este método no está disponíble en esta base de dados.";				
		}		
		function db_close() {
			echo "Este método no está disponíble en esta base de dados.";						
		}
	}
?>