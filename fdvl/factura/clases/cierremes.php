<?
include_once("manejadordb.php");
class cierremes extends  manejadordb{
var $year;
var $month;
var $day;
var $hour;
var $minute;
var $second;

    
	function getfechamysql(){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	return $year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
   	}

	function verificarcierremes(){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	$fecha=$year."-".$month."-".$day;
	$factura=new  manejadordb;
	if(mysql_num_rows($factura->consultar("select * from tbl_cierremes where mes=$month and anio=$year and estatus=7 "))>0){
	return true;
   	}else return false;
	}
	
	function cerrarmes(){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	$fecha=$year."-".$month."-".$day;
	$factura=new  manejadordb;
		if($factura->query("update tbl_cierremes set estatus=7 where mes=$month and anio=$year ")==true){
			return true;
		}else return false;
	
   	}

	function cerrarmesaut(){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	$fecha=$year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
	$obj=new  manejadordb;

	$query="select * from tbl_cierremes where anio=$year and estatus=6 ";
	$result=$obj->consultar($query);
	$row=mysql_fetch_assoc($result);
	$mes=$row['mes'];
	
	if($mes < $month){
	
	$obj->query("update tbl_cierremes set estatus=7,fecha_cierre='$fecha',cerrado_por='Sistema' where mes=$mes and anio=$year ");
	$obj->query("INSERT INTO tbl_cierremes (mes,anio,estatus) VALUES ($month,$year,6)");
		
	}
   	}
}
?>