<?php
include_once("manejadordb.php");
//variables POST
$obj=new manejadordb;
$codfacturamanual=$_POST['codfacturamanual'];
$codmanual= substr($codfacturamanual, -6);  

	$query="SELECT * FROM tbl_facturas 
	WHERE codfacturamanual like '%$codmanual'
		and estatus_factura='3'
		and cod_factura like 'M-%'";
	//die($query);
	
	if($obj->consultar_remoto($query)!=false)
	{
		$result=mysql_query($query) or die($query."<br>".mysql_error());
		$nf=mysql_num_rows($result);
		if($nf==0)
		{
			echo "0";
		}
		else
		{
			$row = mysql_fetch_row($result);
			$fecha1=substr($row[1], 0, 10);
			$fecha2=explode("-", $fecha1);
			$fecha=$fecha2[2]."/".$fecha2[1]."/".$fecha2[0];;
			echo "La factura ".$row[26]." ya esta cargada\nCodigo de la Factura: ".$row[0]."\nFecha: ".$fecha;
		}
	}
	else
	{
		echo "0";
	}

?>