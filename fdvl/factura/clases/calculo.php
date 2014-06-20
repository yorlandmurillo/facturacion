<?
class calculo extends manejadordb{
var $year;
var $month;
var $day;
var $hour;
var $minute;
var $second;
var $partsecond;
var $tz;
    
function codigo($vendedor,$sucursal,$cliente){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	$fecha=$year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
	$codigof=new  manejadordb;
//Selecciono el ultimo correlativo de las facturas
	$row = mysql_fetch_assoc($codigof->consultar("select correlativo from tbl_facturas order by correlativo desc"));
	$cod=$row['correlativo'];
//Selecciono el correlativo de la factura actual
	$row2 = mysql_fetch_assoc($codigof->consultar("select correlativo from tbl_facturas where vendedor=$vendedor and sucursal=$sucursal and estatus_factura=0"));
	$cod2=$row2['correlativo'];
	$codfacturaactual=$year.$month.$day."-".$cod2;
	
	if($cod=="")$cod=1;else $cod+=1;
	$codfactura=$year.$month.$day."-".$cod;
	
	if(mysql_num_rows($codigof->consultar("select * from tbl_facturas where vendedor=$vendedor and sucursal=$sucursal and estatus_factura=0 "))==0){
	$codigof->query("INSERT INTO tbl_facturas (cod_factura,fecha_factura,cod_cliente,vendedor,sucursal,correlativo)VALUES('$codfactura','$fecha',$cliente,$vendedor,$sucursal,$cod);");
	return $codfactura;
   	}else return $codfacturaactual;
   
   }
	function getfechamysql(){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	return $year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
   	}
	
	function verificardia(){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	$fecha=$year."-".$month."-".$day;
	$factura=new  manejadordb;
		if(mysql_num_rows($factura->consultar("select * from tbl_cierre where fecha='$fecha' and estatus=7 "))>0){
			return true;
	   	}else return false;
   	}

	function verificarcierredia(){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	$fecha=$year."-".$month."-".$day;
	$factura=new  manejadordb;
	if(mysql_num_rows($factura->consultar("select * from tbl_cierre where fecha='$fecha' and estatus=6 "))>0){
	return true;
   	}else return false;
	
   	}
	
	function cantitems($suc,$vendedor,$date){
       $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	
	if(isset($date) && !empty($date) && $date!=0){
	$fecha=$date." "."00:00:00";
	$fechah=$date." "."23:59:59";
	}else{
	$fecha=$year."-".$month."-".$day." "."00:00:00";
	$fechah=$year."-".$month."-".$day." "."23:59:59";
	}

	$fechaa=$this->getfechamysql();
	$factura=new  manejadordb;

	if(!empty($suc) && $vendedor==0){
	$query="SELECT tbl_itemfactura.cantidad as cant FROM tbl_facturas INNER JOIN tbl_itemfactura ON (tbl_facturas.sucursal = tbl_itemfactura.sucursal) AND (tbl_facturas.cod_factura = tbl_itemfactura.cod_factura) WHERE  tbl_facturas.sucursal=$suc AND tbl_facturas.estatus_factura=3 AND tbl_facturas.fecha_factura Between '$fecha' And '$fechah' ";
	}

	if(!empty($suc) && $vendedor!=0){
	$query="SELECT tbl_itemfactura.cantidad as cant FROM tbl_facturas INNER JOIN tbl_itemfactura ON (tbl_facturas.sucursal = tbl_itemfactura.sucursal) AND (tbl_facturas.cod_factura = tbl_itemfactura.cod_factura) WHERE  tbl_facturas.vendedor=$vendedor AND tbl_facturas.sucursal=$suc AND tbl_facturas.estatus_factura=3 AND tbl_facturas.fecha_factura Between '$fecha' And '$fechah' ";
	}

	$result=$factura->consultar($query);

	while($row=mysql_fetch_assoc($result)){
	$item=$item+$row['cant'];
	}
	return $item;

	}

	function factinicial($suc,$vendedor,$date){
    	$year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);

	if(isset($date) && !empty($date) && $date!=0){
	$fecha=$date." "."00:00:00";
	$fechah=$date." "."23:59:59";
	}else{
	$fecha=$year."-".$month."-".$day." "."00:00:00";
	$fechah=$year."-".$month."-".$day." "."23:59:59";
	}

	$fechaa=$this->getfechamysql();
	$factura=new  manejadordb;

	if(!empty($suc) && $vendedor==0){
	$query= "SELECT * FROM tbl_facturas WHERE sucursal=$suc AND estatus_factura=3 AND fecha_factura Between '$fecha' And '$fechah' order by fecha_factura "; 
	}
	
	if(!empty($suc) && $vendedor!=0){
	$query= "SELECT * FROM tbl_facturas WHERE vendedor=$vendedor AND sucursal=$suc AND estatus_factura=3 AND fecha_factura Between '$fecha' And '$fechah' order by fecha_factura "; 
	}
		
	$result=$factura->consultar($query);
	$row=mysql_fetch_assoc($result);
	$fi=$row['cod_factura'];
	return $fi;
	}

	function factfinal($suc,$vendedor,$date){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);

	if(isset($date) && !empty($date) && $date!=0){
	$fecha=$date." "."00:00:00";
	$fechah=$date." "."23:59:59";
	}else{
	$fecha=$year."-".$month."-".$day." "."00:00:00";
	$fechah=$year."-".$month."-".$day." "."23:59:59";
	}
	$fechaa=$this->getfechamysql();
	$factura= new  manejadordb;

	if(!empty($suc) && $vendedor==0){
	$query="SELECT cod_factura FROM tbl_facturas WHERE sucursal=$suc AND estatus_factura=3 AND fecha_factura Between '$fecha' And '$fechah' order by fecha_factura desc"; 
	}
	
	if(!empty($suc) && $vendedor!=0){
	$query="SELECT cod_factura FROM tbl_facturas WHERE vendedor=$vendedor AND sucursal=$suc AND estatus_factura=3 AND fecha_factura Between '$fecha' And '$fechah' order by fecha_factura desc"; 
	}
	
	$result=$factura->consultar($query);
	$row=mysql_fetch_assoc($result);
	$ff=$row['cod_factura'];
	return $ff;
	}

/* Funcion para efectuar el cierre diario */
	function cerrardia($vendedor,$suc){
   	$year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	$fecha=$year."-".$month."-".$day." "."00:00:00";
	$fechah=$year."-".$month."-".$day." "."23:59:59";
	$fechac=$year."-".$month."-".$day;
	$fechaa=$this->getfechamysql();
	$factura=new  manejadordb;

	$fi=$this->factinicial($suc,0,0);
	$ff=$this->factfinal($suc,0,0);
	$item=$this->cantitems($suc,0,0);

	$query="SELECT * FROM tbl_facturas WHERE sucursal=$suc AND estatus_factura=3 AND fecha_factura Between '$fecha' And '$fechah' ";
	
	$result=$factura->consultar($query);
	
	$num=mysql_num_rows($result);
	
	$nc=0;
	while($row=mysql_fetch_assoc($result)){

		$efectivo=$efectivo+($row['efectivo']-$row['cambio']);
		$cheque=$cheque+$row['cheque'];
		$tdb=$tdb+$row['tdb'];
		$tdc=$tdc+$row['tdc'];
		$bl=$bl+$row['bl'];
		$cesta=$cesta+$row['cesta_ticket'];
		$especial=$especial+$row['pago_especial'];
		$omoneda=$omoneda+$row['otra_moneda'];
		$descuento=$descuento+$row['descuento'];
	if($row['cheque']>0){$nc++;}

	}
	if($num>0){ 
	
	if($factura->query("update tbl_cierre set total_clientes=$num,total_ejemplares=$item,total_credito=$tdc,total_debito=$tdb,total_efectivo=$efectivo,total_bonolibro=$bl,cant_cheques=$nc,total_cheques=$cheque,total_descuentos=$descuento,total_especiales=$especial,total_cestatikets=$cesta,total_omoneda=$omoneda,factura_inicial='$fi',factura_final='$ff',cerrado_por=$vendedor,fecha_cierre='$fechaa', estatus=6 where fecha='$fechac' and cod_sucursal=$suc and estatus=6 ")==true){
		return true;
		}else return false;
	}else false;	
	}

/* Fin de Funcion para efectuar el cierre diario */



/* Funcion para efectuar el cierre automatico del dia */
	function cerrardiaaut($suc){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$fechaa=$this->getfechamysql();
	$factura=new  manejadordb;
	$hoy=$year."-".$month."-".$day;
	$sql="SELECT * FROM tbl_cierre WHERE cod_sucursal=$suc AND fecha < '$hoy' AND estatus=6 ";
	$r=$factura->consultar($sql);

	$reg=mysql_fetch_assoc($r);
	$date=$reg['fecha'];
	$fi=$this->factinicial($suc,0,$date);
	$ff=$this->factfinal($suc,0,$date);
	$item=$this->cantitems($suc,0,$date);
	
	$fecha=$date." 00:00:00";
	$fechah=$date." 23:59:59";

	$query="SELECT * FROM tbl_facturas WHERE sucursal=64 and estatus_factura=3 and fecha_factura Between '$fecha' And '$fechah' ";
	$result=$factura->consultar($query);
	$num=mysql_num_rows($result);
	$nc=0;
	while($row=mysql_fetch_assoc($result)){
		$efectivo=$efectivo+($row['efectivo']-$row['cambio']);
		$cheque=$cheque+$row['cheque'];
		$tdb=$tdb+$row['tdb'];
		$tdc=$tdc+$row['tdc'];
		$bl=$bl+$row['bl'];
		$cesta=$cesta+$row['cesta_ticket'];
		$especial=$especial+$row['pago_especial'];
		$omoneda=$omoneda+$row['otra_moneda'];
		$descuento=$descuento+$row['descuento'];
	if($row['cheque']>0){$nc++;}

	}
	 	 
	if($factura->query("update tbl_cierre set total_clientes=$num,total_ejemplares=$item,total_credito=$tdc,total_debito=$tdb,total_efectivo=$efectivo,total_bonolibro=$bl,cant_cheques=$nc,total_cheques=$cheque,total_descuentos=$descuento,total_especiales=$especial,total_cestatikets=$cesta,total_omoneda=$omoneda,factura_inicial='$fi',factura_final='$ff',estatus=6,fecha_cierre='$fechaa' where fecha='$date' and cod_sucursal=$suc and estatus=6 ")==true){
		
		//return $num;
		return true;
		}else return false;
	
	}


/* Fin de Funcion para efectuar el cierre diario */


/**************************************/

	function precierre($vendedor,$suc){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	$fecha=$year."-".$month."-".$day." "."00:00:00";
	$fechah=$year."-".$month."-".$day." "."23:59:59";
	$fechac=$year."-".$month."-".$day;
	$fechaa=$this->getfechamysql();
	$factura=new  manejadordb;

	$fi=$this->factinicial($suc,$vendedor,0);
	$ff=$this->factfinal($suc,$vendedor,0);
	$item=$this->cantitems($suc,$vendedor,0);

	$query="SELECT * FROM tbl_facturas WHERE vendedor=$vendedor AND sucursal=$suc AND estatus_factura=3 AND fecha_factura Between '$fecha' And '$fechah' ";
	
	$result=$factura->consultar($query);
	
	$num=mysql_num_rows($result);
	
	$nc=0;
	while($row=mysql_fetch_assoc($result)){

		$efectivo=$efectivo+($row['efectivo']-$row['cambio']);
		$cheque=$cheque+$row['cheque'];
		$tdb=$tdb+$row['tdb'];
		$tdc=$tdc+$row['tdc'];
		$bl=$bl+$row['bl'];
		$cesta=$cesta+$row['cesta_ticket'];
		$especial=$especial+$row['pago_especial'];
		$omoneda=$omoneda+$row['otra_moneda'];
		$descuento=$descuento+$row['descuento'];
	if($row['cheque']>0){$nc++;}

	}
	 
	if($factura->query("update tbl_precierrecaja set total_clientes=$num,total_ejemplares=$item,total_credito=$tdc,total_debito=$tdb,total_efectivo=$efectivo,total_bonolibro=$bl,cant_cheques=$nc,total_cheques=$cheque,total_descuentos=$descuento,total_especiales=$especial,total_cestatikets=$cesta,total_omoneda=$omoneda,factura_inicial='$fi',factura_final='$ff',fecha_cierre='$fechaa' where fecha='$fechac' and cod_sucursal=$suc and estatus=6 and vendedor=$vendedor ")==true){
		return true;
		}else return false;
	}

/**************************************/

/**************************************/

	function precierreaut($vendedor,$suc){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hoy=$year."-".$month."-".$day;
	$fechaa=$this->getfechamysql();
	$factura=new  manejadordb;
	$sql="SELECT * FROM tbl_precierrecaja WHERE cod_sucursal=$suc AND fecha < '$hoy' AND estatus=6 AND vendedor=$vendedor";
	$r=$factura->consultar($sql);
	$reg=mysql_fetch_assoc($r);
	$date=addslashes($reg['fecha']);
	$fecha= $date." 00:00:00";
	$fechah= $date." 23:59:59";

	$fi=$this->factinicial($suc,$vendedor,$date);
	$ff=$this->factfinal($suc,$vendedor,$date);
	$item=$this->cantitems($suc,$vendedor,$date);

	$query="SELECT * FROM tbl_facturas WHERE vendedor=$vendedor AND sucursal=$suc AND estatus_factura=3 AND fecha_factura Between '$fecha' And '$fechah' ";
	
	$result=$factura->consultar($query);
	
	$num=mysql_num_rows($result);
	
	$nc=0;
	while($row=mysql_fetch_assoc($result)){

		$efectivo=$efectivo+($row['efectivo']-$row['cambio']);
		$cheque=$cheque+$row['cheque'];
		$tdb=$tdb+$row['tdb'];
		$tdc=$tdc+$row['tdc'];
		$bl=$bl+$row['bl'];
		$cesta=$cesta+$row['cesta_ticket'];
		$especial=$especial+$row['pago_especial'];
		$omoneda=$omoneda+$row['otra_moneda'];
		$descuento=$descuento+$row['descuento'];
	if($row['cheque']>0){$nc++;}

	}
	 
	if($factura->query("update tbl_precierrecaja set total_clientes=$num,total_ejemplares=$item,total_credito=$tdc,total_debito=$tdb,total_efectivo=$efectivo,total_bonolibro=$bl,cant_cheques=$nc,total_cheques=$cheque,total_descuentos=$descuento,total_especiales=$especial,total_cestatikets=$cesta,total_omoneda=$omoneda,factura_inicial='$fi',factura_final='$ff',fecha_cierre='$fechaa' where fecha='$date' and cod_sucursal=$suc and estatus=6 and vendedor=$vendedor ")==true){
		return true;
		}else return false;
	}

/**************************************/


	
	function nuevodia($suc,$vend){
       $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	$fechac=$year."-".$month."-".$day;

	$factura=new  manejadordb;

	$query="select * from tbl_cierre where cod_sucursal=$suc and fecha='$fechac' ";
	
	$result=$factura->consultar($query);
	
	if($num=mysql_num_rows($result)==0){
	
		$factura->query("insert into tbl_cierre (cod_sucursal,fecha,estatus)values($suc,'$fechac',6)");
		
	}
	
	$query2="select * from tbl_precierrecaja where cod_sucursal=$suc and vendedor=$vend and fecha='$fechac' ";
	$result2=$factura->consultar($query2);
	
	if($num2=mysql_num_rows($result2)==0){
	
		$factura->query("insert into tbl_precierrecaja (cod_sucursal,fecha,estatus,vendedor)values($suc,'$fechac',6,$vend)");
	
	}
	
	}

	function cierresesion($vend){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$minute=date(i);
	$second=date(s);
	$fechac=$year."-".$month."-".$day;
	$fechaa=$this->getfechamysql();
	$factura=new  manejadordb;

	if($factura->query("update tbl_sesiones set sesiones_us_ex='$fechaa' where id_user=$vend ")==true){
	  if($factura->query("update log_sesiones set sesiones_us_ex='$fechaa',expirada=10 where id_user=$vend and expirada=9")==true){
		return true;
	  }
	}else return false;
	}

}
?>