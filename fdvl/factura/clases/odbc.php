<?php
	require_once('ado.php');
	class odbc extends ado{
		function db_connect() {
			$this->banco = "pgtraslado"; // Data Source Name
			$this->user = "odbc";
			$this->senha = "120842ma";
			$this->host="localhost";
			$this->port="1433";
			
			if ($conn = odbc_pconnect($this->banco,$this->user,$this->senha)) {
				return $conn;
			}
			else {
				return false;
			}
		}

		function db_close($conn) {
			if (odbc_close($conn)) {
				return true;
			}
			else {
				return false;
			}
		}

		function query($sql) {
			$this->conn = $this->db_connect() or die ("No es posible conectar con la base de datos.");
			if ($res = odbc_exec($this->conn,$sql) or die ("Inválida: ".odbc_errormsg())) {
				return $res;
			}
			else {
				$this->db_close($this->conn);			
				return false;
			}
		}

		function to_array($res) {
			if ($linha = odbc_fetch_array($res)) {
				return $linha;
			}
			else {
				return false;
			}
		}
		
		function num_rows($res) {
			if (odbc_num_rows($res)!=0) {
				return true;
			}else{
				return false;
			}
		}

		function num_fields($res) {
			if ($num = odbc_num_fields($res)) {
				return $num;
			}
			else {
				return false;
			}
		}	
	}
?>