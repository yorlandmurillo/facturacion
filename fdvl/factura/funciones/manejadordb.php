<?php 
include_once("../dbmanager.php");
//implementamos la clase 
class manejadordb{
 //constructor	
function manejadordb(){
 
}	
function getfechamysql(){
    $year=date(Y);
	$month=date(m);
	$day=date(d);
	$hour=date(H);
	$minute=date(i);
	$second=date(s);
	return $year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
}
 
 
 // consultas 
function consultar($query=""){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return $result;
   }
   mysql_close($con); 
 }
 
function query($query=""){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return true;
   }
   mysql_close($con); 
 }

/*
function existencia($cedula){
   
    $con = new dbmanager;
   if($con->conectar()==true){
	$query="select * from tbl_cliente where cli_cedula='$cedula' ";
     $result = mysql_query($query);
	
     if (mysql_num_rows($result)>0)
	   return true;
     else
       return false;
   }
 
 }
 function setdescuento($cod){
      //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_inventario WHERE cod_producto='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['descuento']*100;
	 }
   }
 }*/
 /*
 function setprecio($cod){
      //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_inventario WHERE cod_producto='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   $descuento=($row['precio'])*($row['descuento']);
	   $precio=$row['precio']-$descuento;
	   return $precio;
	 }
   }
 } */
 //elimina los items a la factura
function delitems($codf){
   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "DELETE FROM tbl_itemfactura WHERE cod_factura='$codf' and estatus_cancelacion=0 ";
     $result = @mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
  
//elimina un item a la factura

function borraritem($cod){
   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "DELETE FROM tbl_itemfactura WHERE id_itemfactura='$cod' ";
     $result = @mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
 //inserta un nuevo item a la factura
 
function insertarcliente($query=""){
   $con = new dbmanager;
   if($con->conectar()==true){
      $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }

function editarcliente($query=""){
   $con = new dbmanager;
   if($con->conectar()==true){
      $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }



function crearfactura($suc,$codf,$cliente,$vend,$total,$subt,$mtoiva,$iva,$efec,$tdb,$tdc,$bl,$esp,$mtocheque,$nrocheque,$nrocta,$banco,$nroconf,$cambio,$otramoneda,$cesta){

while ($codf!="" && $vend!="" && $suc!=""){
   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "UPDATE tbl_facturas t SET efectivo=$efec,cheque=$mtocheque,tdb=$tdb,tdc=$tdc,bl=$bl,cesta_ticket=$cesta,cta_bancaria='$nrocta',num_cheque='$nrocheque',banco=$banco,nro_conformacion=$nroconf,iva=$iva,mto_iva=$mtoiva,sub_totla=$subt,mto_total=$total,cambio=$cambio,estatus_factura=3 where cod_factura='$codf' and vendedor=$vend and sucursal=$suc ";
      $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
}

function procesaritems($suc,$codf,$vend){
while ($codf!="" && $vend!="" && $suc!=""){
   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "UPDATE tbl_itemfactura t SET estatus_cancelacion=3 where cod_factura='$codf' and estatus_cancelacion=0 ";
      $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
}
function setsucursal($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_sucursal WHERE id_sucursal='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['sucursal'];
	 }
   }
 } 

function setestatus($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_estatus WHERE id_estatus='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['estatus'];
	 }
   }
 } 

function verificaruser($login=""){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_usuario WHERE us_login='$login' ";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   $row = mysql_num_rows($result);	  
	   return $row;
   }
 }

function devolveritem($id,$suc,$cant){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_itemfactura WHERE id_itemfactura=$id ";      
	 $result = @mysql_query($query);
	 $row = mysql_fetch_assoc($result);	  
	 $codf=	$row['cod_factura'];
	 $codp=	$row['cod_producto'];
	 $cif=	$row['cif'];
 	 $cic=	$row['cic'];
	 $cicdn=$row['cicdn'];
	 $valor1=0;
	 $valor2=0;
	 if($cicdn>0 && $cant>0){	
	 	if($cant>$cicdn){
			$valor1=$cant-$cicdn;
			$this->query("update tbl_distinventario set cantidad=cantidad+$cicdn where sucursal=$suc and condicion=3 ");	
			$this->query("update tbl_itemfactura set cicdn=cicdn-$cicdn where id_itemfactura=$id and sucursal=$suc ");	
		}elseif($cant<=$cicdn){
			$valor1=$cant-$cicdn;
			$this->query("update tbl_distinventario set cantidad=cantidad+$cant where sucursal=$suc and condicion=3 ");
			$this->query("update tbl_itemfactura set cicdn=cicdn-$cant where id_itemfactura=$id and sucursal=$suc ");		
		}
	 }else $valor1=$cant;
	 
	 if($cic>0 && $valor1>0){	
	 	if($valor1>$cic){
			$valor2=$valor1-$cic;
			$this->query("update tbl_distinventario set cantidad=cantidad+$cic where sucursal=$suc and condicion=2 ");	
			$this->query("update tbl_itemfactura set cic=cic-$cic where id_itemfactura=$id and sucursal=$suc ");	
		}elseif($valor1<=$cic){
			$valor2=$valor1-$cic;
			$this->query("update tbl_distinventario set cantidad=cantidad+$valor1 where sucursal=$suc and condicion=2 ");	
			$this->query("update tbl_itemfactura set cic=cic-$valor1 where id_itemfactura=$id and sucursal=$suc ");					
		}
	 }else $valor2=$valor1;
	 
	 if($cif>0 && $valor2>0){	
	 	
		if($valor2>$cif){
			$this->query("update tbl_distinventario set cantidad=cantidad+$cif where sucursal=$suc and condicion=1 ");	
			$this->query("update tbl_itemfactura set cif=cif-$cif where id_itemfactura=$id and sucursal=$suc ");				
		}elseif($valor2<=$cif){
			$this->query("update tbl_distinventario set cantidad=cantidad+$valor2 where sucursal=$suc and condicion=1 ");	
			$this->query("update tbl_itemfactura set cif=cif-$valor2 where id_itemfactura=$id and sucursal=$suc ");					
		}
	 }
	 $this->query("update tbl_itemfactura set devuelto=15 WHERE id_itemfactura=$id ");
	 
	return true; 
   }else return false; 
 } 
 
 /******************/
function detallesolicitud(){


}


 function verificardev($codp){
    //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_facturas WHERE cod_factura='$codp' and estatus_factura=3 ";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
       $row = mysql_num_rows($result);
	   return $row;
   }
 }

 
 
 // consultas remotas
function consultar_remoto($query=""){
 // die("Estoy en la funcion consultar remoto correspondiente a manejadordb-->funciones");
   //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return $result;
   }
   mysql_close($con_remoto); 
 }
 
function query_remoto($query=""){
//die("Estoy en la funcion query_remoto correspondiente a manejadordb-->funciones");
   
   //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return true;
   }
   mysql_close($con_remoto); 
 }


function existencia_remoto($cedula){
   
    $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
	$query="select * from tbl_cliente where cli_cedula='$cedula' ";
     $result = mysql_query($query);
	
     if (mysql_num_rows($result)>0)
	   return true;
     else
       return false;
   }
 
 }
 function setdescuento_remoto($cod){
      //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_inventario WHERE cod_producto='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['descuento']*100;
	 }
   }
 }
 
 function setprecio_remoto($cod){
      //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_inventario WHERE cod_producto='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   $descuento=($row['precio'])*($row['descuento']);
	   $precio=$row['precio']-$descuento;
	   return $precio;
	 }
   }
 } 
 //elimina los items a la factura
 
function delitems_remoto($codf){
   $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "DELETE FROM tbl_itemfactura WHERE cod_factura='$codf' and estatus_cancelacion=0 ";
     $result = @mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
  
//elimina un item a la factura

function borraritem_remoto($cod){
   $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "DELETE FROM tbl_itemfactura WHERE id_itemfactura='$cod' ";
     $result = @mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
 //inserta un nuevo item a la factura
 
function insertarcliente_remoto($query=""){
   $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
      $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }

function editarcliente_remoto($query=""){
   $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
      $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }



function crearfactura_remoto($suc,$codf,$cliente,$vend,$total,$subt,$mtoiva,$iva,$efec,$tdb,$tdc,$bl,$esp,$mtocheque,$nrocheque,$nrocta,$banco,$nroconf,$cambio,$otramoneda,$cesta){

while ($codf!="" && $vend!="" && $suc!=""){
   $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "UPDATE tbl_facturas t SET efectivo=$efec,cheque=$mtocheque,tdb=$tdb,tdc=$tdc,bl=$bl,cesta_ticket=$cesta,cta_bancaria='$nrocta',num_cheque='$nrocheque',banco=$banco,nro_conformacion=$nroconf,iva=$iva,mto_iva=$mtoiva,sub_totla=$subt,mto_total=$total,cambio=$cambio,estatus_factura=3 where cod_factura='$codf' and vendedor=$vend and sucursal=$suc ";
      $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
}

function procesaritems_remoto($suc,$codf,$vend){
while ($codf!="" && $vend!="" && $suc!=""){
   $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "UPDATE tbl_itemfactura t SET estatus_cancelacion=3 where cod_factura='$codf' and estatus_cancelacion=0 ";
      $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
}
function setsucursal_remoto($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_sucursal WHERE id_sucursal='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['sucursal'];
	 }
   }
 } 

function setestatus_remoto($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_estatus WHERE id_estatus='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['estatus'];
	 }
   }
 } 

function verificaruser_remoto($login=""){
   //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_usuario WHERE us_login='$login' ";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   $row = mysql_num_rows($result);	  
	   return $row;
   }
 }

function devolveritem_remoto($id,$suc,$cant){
   //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_itemfactura WHERE id_itemfactura=$id ";      
	 $result = @mysql_query($query);
	 $row = mysql_fetch_assoc($result);	  
	 $codf=	$row['cod_factura'];
	 $codp=	$row['cod_producto'];
	 $cif=	$row['cif'];
 	 $cic=	$row['cic'];
	 $cicdn=$row['cicdn'];
	 $valor1=0;
	 $valor2=0;
	 if($cicdn>0 && $cant>0){	
	 	if($cant>$cicdn){
			$valor1=$cant-$cicdn;
			$this->query_remoto("update tbl_distinventario set cantidad=cantidad+$cicdn where sucursal=$suc and condicion=3 ");	
			$this->query("update tbl_itemfactura set cicdn=cicdn-$cicdn where id_itemfactura=$id and sucursal=$suc ");	
		}elseif($cant<=$cicdn){
			$valor1=$cant-$cicdn;
			$this->query_remoto("update tbl_distinventario set cantidad=cantidad+$cant where sucursal=$suc and condicion=3 ");
			$this->query("update tbl_itemfactura set cicdn=cicdn-$cant where id_itemfactura=$id and sucursal=$suc ");		
		}
	 }else $valor1=$cant;
	 
	 if($cic>0 && $valor1>0){	
	 	if($valor1>$cic){
			$valor2=$valor1-$cic;
			$this->query_remoto("update tbl_distinventario set cantidad=cantidad+$cic where sucursal=$suc and condicion=2 ");	
			$this->query("update tbl_itemfactura set cic=cic-$cic where id_itemfactura=$id and sucursal=$suc ");	
		}elseif($valor1<=$cic){
			$valor2=$valor1-$cic;
			$this->query_remoto("update tbl_distinventario set cantidad=cantidad+$valor1 where sucursal=$suc and condicion=2 ");	
			$this->query("update tbl_itemfactura set cic=cic-$valor1 where id_itemfactura=$id and sucursal=$suc ");					
		}
	 }else $valor2=$valor1;
	 
	 if($cif>0 && $valor2>0){	
	 	
		if($valor2>$cif){
			$this->query_remoto("update tbl_distinventario set cantidad=cantidad+$cif where sucursal=$suc and condicion=1 ");	
			$this->query("update tbl_itemfactura set cif=cif-$cif where id_itemfactura=$id and sucursal=$suc ");				
		}elseif($valor2<=$cif){
			$this->query_remoto("update tbl_distinventario set cantidad=cantidad+$valor2 where sucursal=$suc and condicion=1 ");	
			$this->query("update tbl_itemfactura set cif=cif-$valor2 where id_itemfactura=$id and sucursal=$suc ");					
		}
	 }
	 $this->query("update tbl_itemfactura set devuelto=15 WHERE id_itemfactura=$id ");
	 
	return true; 
   }else return false; 
 } 
 



 function verificardev_remoto($codp){
    //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_facturas WHERE cod_factura='$codp' and estatus_factura=3 ";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
       $row = mysql_num_rows($result);
	   return $row;
   }
 }

 
 
 
 

/******************/

 
}
?>
