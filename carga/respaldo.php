<?php
include 'conec.php';
if($_POST['submit'])
 { 
   // $output=shell_exec("..\..\mysql\bin\mysqldump -u inventa_bd -pValenta@04  --lock-tables inventa_pglibreria tbl_facturas tbl_itemfactura tbl_sucursal"); // ejemplo windows
   $output=shell_exec("/usr/bin/mysqldump -u inventa_bd -pValenta@04  --lock-tables inventa_pglibreria tbl_cierre tbl_cliente tbl_facturas tbl_itemfactura tbl_sucursal"); // ejemplo linux
    if(trim($output)==NULL)
     {
         echo "Error creando el backup de la DB: ".$dbase;
         exit();
     }
	 //Actualizar estado de envío de factura e itemfactura
	  mysql_query("update tbl_facturas set enviado='S' where estatus_factura <> '0'",$db);
	  mysql_query("update tbl_itemfactura set enviado='S' where estatus_cancelacion <> '0'",$db);
	 
	 //Nombre de la sucursal
	 $select="select tbl_sucursal.sucursal from
	 tbl_sucursal,tbl_facturas
	 where tbl_sucursal.id_sucursal=tbl_facturas.sucursal
	 limit 0,1";
	 $result = mysql_query($select,$db) or die($select."<br>.Busca sucursal<br>".mysql_error());
	if ($row = mysql_fetch_array($result)) 
	{
		$sucursal=str_replace(" ","_",$row[0]);
		
	}
	$name="facturacion_".$sucursal;
	date_default_timezone_set("America/Caracas"); 
    header('Content-type: text/plain');
    header('Content-Disposition: attachment; filename="'.$name.'_'.date("d").'-'.date("m").'-'.date("Y").'_'.date("h").'-'.date("i").'-'.date("s").'_'.date("a").'.sql"');
    echo $output;
    exit();
 }    
?>
<html>
<head>
</head>
<body>
 <form action="" method="post">  
 <font size=4><b>Haga click aqui para hacer un respaldo de las facturas</b></font>
  <input type="submit" name="submit" value="Respaldo" />  
 </form>
</body>
</html>
