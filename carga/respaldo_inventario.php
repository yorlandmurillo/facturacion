<?php
include 'conec.php';
if($_POST['submit'])
 { 
   // $output=shell_exec("..\..\mysql\bin\mysqldump -u inventa_bd -pValenta@04  --lock-tables inventa_pglibreria tbl_facturas tbl_itemfactura tbl_sucursal"); // ejemplo windows
   $output=shell_exec("/usr/bin/mysqldump -u root -phola  --lock-tables inventa_pglibreria tbl_distinventario tbl_inventario tbl_autor tbl_editorial"); // ejemplo linux
    if(trim($output)==NULL)
     {
         echo "Error creando el backup de la DB: ".$dbase;
         exit();
     }
	 $name="facturacion";
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
