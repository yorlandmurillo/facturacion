<?php
	require_once('ado.php');
	class sqlserver extends ado {
		function db_connect() {
			$this->host = "192.168.1.136";
			$this->usuario = "php";
			$this->senha = "ma110842";
			$this->banco = "pgtraslado";
			if ($conn = mssql_connect($this->host,$this->usuario,$this->senha)) {
				if ($db = mssql_select_db($this->banco,$conn)) {
					return $conn;
				}
			}
			else {
				return false;
			}
		}

		function db_close($conn) {
			if (mssql_close($conn)) {
				return true;
			}
			else {
				return false;
			}
		}

		function db_name($banco) {
			if ($db = mssql_select_db($banco,$this->conn)) {
				$this->banco = $banco;			
				return $db;
			}
			else {
				return false;
			}
		}

		function query($sql) {
			$this->conn = $this->db_connect() or die ("No es posible conectar con la base de datos.");
			if ($res = mssql_query($sql,$this->conn)) {
				$this->db_close($this->conn);
				return $res;
			}
			else {
				$this->db_close($this->conn);			
				return false;
			}
		}

		function to_array($res) {
			if ($linha = mssql_fetch_array($res)) {
				return $linha;
			}
			else {
				return false;
			}
		}
		
		function num_rows($res) {
			if ($num = mssql_num_rows($res)) {
				return $num;
			}
			else {
				return false;
			}
		}

		function num_fields($res) {
			if ($num = mssql_num_fields($res)) {
				return $num;
			}
			else {
				return false;
			}
		}

		function affected_rows($res) {
			if ($num = mssql_rows_affected($res)) {
				return $num;
			}
			else {
				return false;
			}
		}
		
	}
?>