<?php
class directorio{

var $dirs=array("envios","recepcion");

/*var $carpetas=array("facturas","audinventario","chat","cierre","cliente","detalleinventario","devolucioncliente","devolucionlibreria","distinventario","envios","log_sesiones","itemdevolucion","itemfactura","precierrecaja","sesiones");
var $tablas=array("tbl_facturas","tbl_audinventario","tbl_chat","tbl_cierre","tbl_cliente","tbl_detalleinventario","tbl_devolucioncliente","tbl_devolucionlibreria","tbl_distinventario","tbl_envios","log_sesiones","tbl_itemdevolucion","tbl_itemfactura","tbl_precierrecaja","tbl_sesiones");*/

var $carpetas=array("facturas","itemfactura");
var $tablas=array("tbl_facturas","tbl_itemfactura");



	function __directorio(){

	}
	
	function creardir($suc){
	
	for($j=0;$j<sizeof($this->dirs);$j++){	

		for($i=0;$i<sizeof($this->carpetas);$i++){
			if (!file_exists($this->dirs[$j]."/".$this->carpetas[$i])){
				mkdir($this->dirs[$j]."/".$this->carpetas[$i]);
				chmod($this->dirs[$j]."/".$this->carpetas[$i],0777);
			}
		}
	}

	for($j=0;$j<sizeof($this->dirs);$j++){	

		for($i=0;$i<sizeof($this->carpetas);$i++){
			if (!file_exists($this->dirs[$j]."/".$this->carpetas[$i]."/".$suc)){
			mkdir($this->dirs[$j]."/".$this->carpetas[$i]."/".$suc);
			chmod($this->dirs[$j]."/".$this->carpetas[$i]."/".$suc,0777);
			}
		}
	}
	}
}
?>