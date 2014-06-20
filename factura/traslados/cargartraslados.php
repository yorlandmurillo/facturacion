<?
require("../admin/session.php"); // incluir motor de autentificación.
require_once('../clases/odbc.php');
require_once('../clases/mysql.php');


	$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
	$nivel_acceso=2;// definir nivel de acceso para esta página.

	if ($_SESSION['usuario_nivel'] == $nivel_acceso){	

	$year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H)-1;
	$fecha=$day."/".$month."/".$year;
	
	$obj=new manejadordb;

	$res = $obj->consultar("select * from traslado");
	
	if(mysql_num_rows($res)>0){
	
	$query="select * from tbl_traslados";
	$result=$obj->consultar($query);

	$res = $obj->consultar("select * from traslado");
	$cantr=0;
	
	while ($row = mysql_fetch_assoc($res)){

	if(!strcasecmp($row["condicion"],"Firme"))$condicion=1;
	if(!strcasecmp($row["condicion"],"Consignacion"))$condicion=2;
	if(!strcasecmp($row["condicion"],"Consignacion DN"))$condicion=3;

	$sql= "insert into tbl_traslados (cod_traslado,cod_libro,sucursal,cantidad,condicion,titulo,autor,coleccion,editorial,tema";
	$sql.= ",subtema,precio,descuento,isbn,cod_barra,solicitud,estatus,incluidopor,fechainclusion)values('".trim($row["codigo_traslado"])."'";
	$sql.= ",'".trim($row["codigo"])."',".$row["sucursal"].",".$row["cantidad"].",$condicion,'".trim($row["titulo"])."'";
	$sql.= ",'".trim($row["autor"])."','".trim($row["coleccion"])."','".trim($row["editorial"])."','".trim($row["tema"])."'";
	$sql.= ",'".trim($row["subtema"])."',".$row["precio"].",".$row["descuento"].",'".trim($row["isbn"])."','".trim($row["barras"])."'";
	$sql.= ",'".trim($row["soliorden"])."',0,'".trim($row["responsable"])."'";
	$sql.= ",'".strftime("%Y-%m-%d",strtotime($row["fecha"]))."')";
	
		if($obj->query($sql)==true){
			$cantr++;
		}
	}
	$obj->query("delete from traslado");
	echo utf8_encode("Fueron subidos ".$cantr." traslados al servidor");	

	}else{
	echo utf8_encode("No existen traslados para subir");
	}
	}else{
	echo utf8_encode("Ud. no tiene permisos para realizar esta operación");
	}
?>