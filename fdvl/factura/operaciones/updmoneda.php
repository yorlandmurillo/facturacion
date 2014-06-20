<?
require("../admin/session.php");
require("../clases/reconversion.php");


class updmoneda extends reconversion{
var $monto;
var $tabla;
var $campo;
var $indice;


	function __updmoneda(){
	
	}

	function updatemonto($tabla,$campo,$indice){
	$this->$tabla=$tabla;
	$this->$campo=$campo;
	$this->$indice=$indice;	
	
	$result=manejadordb::consultar("SELECT ".$this->$indice.",".$this->$campo." FROM ".$this->$tabla." order by ".$this->$indice." ;");

	while($row=mysql_fetch_assoc($result)){
	$monto=$this->redondear_dos_decimal($row[$this->$campo],2);
	manejadordb::query("update ".$this->$tabla." set $campo=$monto where $indice= ".$row[$this->$indice].";");
	}
	
	}
	
}

$upd=new updmoneda();
$upd->updatemonto_remoto("tbl_inventario","precio","id_tbl_inventario");

 
?>