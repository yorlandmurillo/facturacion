<?php
	require_once('ado.php');
	class mysql extends ado {
		function db_connect() {
			$this->host = "localhost";
			$this->usuario = "root";
			$this->senha = "120842ma";
			$this->banco = "pglibreria";
			if ($conn = mysql_pconnect($this->host,$this->usuario,$this->senha)) {
				if ($db = mysql_select_db($this->banco,$conn)) {
					return $conn;
				}
			}
			else {
				return false;
			}
		}

		function db_close($conn) {
			if (mysql_close($conn)) {
				return true;
			}
			else {
				return false;
			}
		}

		function db_name($banco) {
			if ($db = mysql_select_db($banco,$this->conn)) {
				$this->banco = $banco;
				return $db;
			}
			else {
				return false;
			}
		}

		function query($sql) {
			$this->conn = $this->db_connect() or die ("No es posible conectar con la base de datos.");
			if ($res = mysql_query($sql,$this->conn) or die ("Inválida: ".mysql_error())) {
				$this->db_close($this->conn);
				return $res;
			}
			else {
				echo "Falló el query.";
				$this->db_close($this->conn);			
				return false;
			}
		}

		function to_array($res) {
			if ($linha = mysql_fetch_array($res)) {
				return $linha;
			}
			else {
				return false;
			}
		}
		
		function num_rows($res) {
			if ($num = mysql_num_rows($res)) {
				return $num;
			}
			else {
				return false;
			}
		}

		function num_fields($res) {
			if ($num = mysql_num_fields($res)) {
				return $num;
			}
			else {
				return false;
			}
		}

		function affected_rows($res) {
			if ($num = mysql_affected_rows($res)) {
				return $num;
			}
			else {
				return false;
			}
		}
		
	}
?>