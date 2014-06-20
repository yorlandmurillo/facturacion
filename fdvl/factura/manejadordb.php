<?php 
include_once("dbmanager.php");
//implementamos la clase 
class manejadordb{
 //constructor	
 function manejadordb(){
 
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
 
 function consultar_remoto($query=""){
 //die("Estoy en la funcion consultar remoto correspondiente a manejadordb-->factura");
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

 function setclavesuc($cod){
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
	   return $row['clave_sucursal'];
	 }
   }
 } 
function setcodsuc($cod){
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
	   return $row['codigo_sucursal'];
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
 
 function devolveritem($id,$suc){
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
	 	
	 $this->query("update tbl_distinventario set cantidad=cantidad+$cif where sucursal=$suc and condicion=1 ");
	 $this->query("update tbl_distinventario set cantidad=cantidad+$cic where sucursal=$suc and condicion=2 ");
     $this->query("update tbl_distinventario set cantidad=cantidad+$cicdn where sucursal=$suc and condicion=3 ");
	 $this->query("update tbl_itemfactura set devuelto=15 WHERE id_itemfactura=$id ");
	return true; 
   }else return false; 
 } 

/******************/
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
/******************/

 
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

 
 function setuser($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_usuarios WHERE id_usuario='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['us_login'];
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

function setiva($cod){
      //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_iva WHERE id_iva=$cod;";      
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   $iva=$row['valor'];
	   return $iva;
	 }
   }
 } 
 
 
function setivaporcentaje($cod){
      //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_iva WHERE id_iva=$cod;";      
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   $iva=$row['porcentaje'];
	   return $iva;
	 }
   }
 } 
 



/*********************************/

/******************************/
function getsucursal($suc){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT cli_tarjetabl FROM tbl_cliente WHERE cli_cedula=$cedula ";
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	 }else{
	 $row = mysql_fetch_assoc($result);
	 $tarjeta=$row['cli_tarjetabl'];
	 return $tarjeta;
	 }
   }
 }

/*********************************/

function delitems($codf,$vend,$suc){
   $con = new dbmanager;
   if($con->conectar()==true){

	$r=$this->consultar("select * FROM tbl_itemfactura WHERE cod_factura='$codf' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=0 ");
	
	while($fil=mysql_fetch_assoc($r)){
	$prod=$fil['cod_producto'];
	$cif=$fil['cif'];
	$cic=$fil['cic'];
	$cicdn=$fil['cicdn'];
		
	$a="update tbl_distinventario set cantidad=cantidad+$cif WHERE cod_producto ='".addslashes($prod)."' and sucursal=$suc and condicion=1 ORDER BY cantidad,FECHA_NOTA_ENTREGA DESC LIMIT 1";
	//$this->query($a);
	$this->query_remoto($a);
	$b="update tbl_distinventario set cantidad=cantidad+$cic WHERE cod_producto ='".addslashes($prod)."' and sucursal=$suc and condicion=2 ORDER BY cantidad,FECHA_NOTA_ENTREGA DESC LIMIT 1";
	//$this->query($b);
	$this->query_remoto($b);
	$c="update tbl_distinventario set cantidad=cantidad+$cicdn WHERE cod_producto ='".addslashes($prod)."' and sucursal=$suc and condicion=3 ORDER BY cantidad,FECHA_NOTA_ENTREGA DESC LIMIT 1";
  	//$this->query($c);
	$this->query_remoto($c); 
	}

	 if($con->conectar()==true){
		 $query = "DELETE FROM tbl_itemfactura WHERE cod_factura='$codf' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=0 ";
		 $result = @mysql_query($query);
	}
     if (!$result)
	   return false;
     else
       return true;
   }
 }
 

 
/******************************/



function delfactura($codf,$vend,$suc){
   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "DELETE FROM tbl_facturas WHERE cod_factura='$codf' and sucursal=$suc and vendedor=$vend and estatus_factura=0 ";
     $result = @mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
  
//elimina un item a la factura

function borraritem($codp,$cod,$cant,$suc){
   $con = new dbmanager;
   if($con->conectar()==true){
   
   $query2="select * FROM tbl_itemfactura WHERE id_itemfactura=$codp ";
   $r=$this->consultar($query2);
   $fil=mysql_fetch_assoc($r);
	$prod=$fil['cod_producto'];
	$cif=$fil['cif'];
	$cic=$fil['cic'];
	$cicdn=$fil['cicdn'];
//	$cantidadexist=$this->getexistencia_remoto($prod,$suc);
		
	$a="update tbl_distinventario set cantidad=cantidad+$cif WHERE cod_producto ='".addslashes($cod)."' and sucursal=$suc and condicion=1";
	//$this->query($a);
	$this->query_remoto($a);
	$b="update tbl_distinventario set cantidad=cantidad+$cic WHERE cod_producto ='".addslashes($cod)."' and sucursal=$suc and condicion=2 ";
	//$this->query($b);
	$this->query_remoto($b);
	$c="update tbl_distinventario set cantidad=cantidad+$cicdn WHERE cod_producto ='".addslashes($cod)."' and sucursal=$suc and condicion=3 ";
  	//$this->query($c); 
	$this->query_remoto($c);
	
	 if($con->conectar()==true){
		$query = "DELETE FROM tbl_itemfactura WHERE id_itemfactura=$codp ";
	 }
     $result = @mysql_query($query);
	// $this->ainventario($cod,$cant);
     if (!$result)
	   return false;
     else
       return true;
   }
 }

 //cancela una factura
 function cancelafactura($codf,$vend,$suc){
   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "update tbl_facturas set estatus_factura='5' WHERE cod_factura='$codf' and sucursal=$suc and vendedor=$vend and estatus_factura=3 ";
     $result = @mysql_query($query);
	 $this->query_remoto($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
 
 //Cancelar una detalles de una factura
 function cancelaitems($codf,$vend,$suc){
   $con = new dbmanager;
   if($con->conectar()==true){

	$r=$this->consultar("select * FROM tbl_itemfactura WHERE cod_factura='$codf' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=3 ");
	//die("select * FROM tbl_itemfactura WHERE cod_factura='$codf' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=3 ");
	while($fil=mysql_fetch_assoc($r))
	{
		$prod=$fil['cod_producto'];
		$cif=$fil['cif'];
		$cic=$fil['cic'];
		$cicdn=$fil['cicdn'];
			
		$a="update tbl_distinventario set cantidad=cantidad+$cif WHERE cod_producto ='".addslashes($prod)."' and sucursal=$suc and condicion=1 ORDER BY cantidad,FECHA_NOTA_ENTREGA DESC LIMIT 1";
		//$this->query($a);
		$this->query_remoto($a);
		$b="update tbl_distinventario set cantidad=cantidad+$cic WHERE cod_producto ='".addslashes($prod)."' and sucursal=$suc and condicion=2 ORDER BY cantidad,FECHA_NOTA_ENTREGA DESC LIMIT 1";
		//$this->query($b);
		$this->query_remoto($b);
		$c="update tbl_distinventario set cantidad=cantidad+$cicdn WHERE cod_producto ='".addslashes($prod)."' and sucursal=$suc and condicion=3 ORDER BY cantidad,FECHA_NOTA_ENTREGA DESC LIMIT 1";
		//$this->query($c);
		$this->query_remoto($c); 
	//}
		//Sumo las diferentes cantidades
		//$existencia=$cif+$cic+$cicdn;
		$cantidadexist=$this->getexistencia_remoto($prod,$suc);
		 if($con->conectar()==true){
			 $query = "update tbl_itemfactura set estatus_cancelacion='5', existencia='$cantidadexist' WHERE cod_factura='$codf' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=3 and cod_producto='".addslashes($prod)."' ";
			 echo $query."<br>";
 			$this->query($query);
			 $this->query_remoto($query); 
			 $result = @mysql_query($query) or die(mysql_error);
		}
	
	}
     if (!$result)
	   return false;
     else
       return true;
   }
 }



 //Crea la factura 
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
     $query = "UPDATE tbl_itemfactura t SET estatus_cancelacion=3 where cod_factura='$codf' and sucursal=$suc and estatus_cancelacion=0 ";
      $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
}



//reducir inventario

//fin

function detallesolicitud(){


}


function getexistencia($codigo,$suc){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
   
     $query = "SELECT sum(cantidad) as cantexist  FROM tbl_distinventario where `cod_producto`='$codigo' and sucursal=$suc;";
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	 }else{
	 $row = mysql_fetch_assoc($result);
	 $tarjeta=$row['cantexist'];
	 return $tarjeta;
	 }
   }
 }
 
 function getmodo($maquina){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar_remoto()==true){
   
     $query = "SELECT modo  FROM tbl_modo where maquina='$maquina'";
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	 }else{
		 $row = mysql_fetch_assoc($result);
		 $modo=$row['modo'];
		 return $modo;
	 }
   }
 }


function crearitem($codp,$codf,$cant,$preciounid,$existencia,$descripcion,$vend,$suc,$isbn,$vif,$vic,$vicdn,$descuento,$precio_sd,$iva){
while ($codp!="" && $codf!=""){ 
   $con = new dbmanager;
   if($con->conectar()==true){
	 $query = "INSERT INTO tbl_itemfactura (cod_factura,cod_producto,descripcion,precio_unid,cantidad,existencia,descuento,sucursal,vendedor,isbn,cif,cic,cicdn,precio_sd,iva) 
	 VALUES ('$codf','$codp','$descripcion',$preciounid,$cant,$existencia,$descuento,$suc,$vend,'$isbn',$vif,$vic,$vicdn,$precio_sd,$iva)";
	 //die($query);
     $result = mysql_query($query);
	 if (!$result)
	   return false;
     else
       return true;
   }
 }
}


function getpreferencia($sucursal,$preferencia){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
		 $query = "SELECT $preferencia FROM tbl_preferencias WHERE sucursal_id=$sucursal;";      
		 $result = @mysql_query($query);
		 if (!$result){
		   return false;
		}
		 else{
		   $row = mysql_fetch_assoc($result);	  
		   return $row[$preferencia];
		}
   }
 }

 
 //Conexiones remotas
 function query_remoto($query=""){
//   die("Estoy en la funcion query_remoto correspondiente a manejadordb-->factura");
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

function existencia_remoto($codp){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_inventario WHERE cod_producto='$codp'";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return $result;
   }
 }
 function setclavesuc_remoto($cod){
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
	   return $row['clave_sucursal'];
	 }
   }
 } 
function setcodsuc_remoto($cod){
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
	   return $row['codigo_sucursal'];
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
 
function setdescuento_remoto($cod,$suc){
      //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_distinventario WHERE cod_producto='$cod' and sucursal=$suc";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['descuento'];
	 }
   }
 }
 function setcodp_remoto($cod){
      //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_inventario WHERE cod_producto='$cod' or isbn='$cod' or cod_barra='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['cod_producto'];
	 }
   }
 }
 
function codbarraduplicado_remoto($cod){
      //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_inventario WHERE isbn='$cod' or cod_barra='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_num_rows($result);	  
	   return $row;
	 }
   }
 }

 function devolveritem_remoto($id,$suc){
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
	 	
	 $this->query_remoto("update tbl_distinventario set cantidad=cantidad+$cif where sucursal=$suc and condicion=1 ");
	 $this->query_remoto("update tbl_distinventario set cantidad=cantidad+$cic where sucursal=$suc and condicion=2 ");
     $this->query_remoto("update tbl_distinventario set cantidad=cantidad+$cicdn where sucursal=$suc and condicion=3 ");
	 $this->query_remoto("update tbl_itemfactura set devuelto=15 WHERE id_itemfactura=$id ");
	return true; 
   }else return false; 
 } 
 
  
 function verificarexist_remoto($codp){
    //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_inventario WHERE cod_producto='$codp' or isbn='$codp' or cod_barra='$codp'";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
       $row = mysql_num_rows($result);
	   return $row;
   }
 }

/******************/
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

 
 function setuser_remoto($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_usuarios WHERE id_usuario='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['us_login'];
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
	   //$descuento=($row['precio'])*($row['descuento']);
	   $precio=$row['precio'];//-$descuento;
	   return $precio;
	 }
   }
 } 
 
function setiva_remoto($cod){
      //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT iva FROM tbl_inventario WHERE cod_producto=$cod;";    
	//die($query);  
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   $valor_iva=$row['iva'];
		if( $valor_iva==1)
			$iva=0;
		else
			$iva=0.12;


	   return $iva;
	 }
   }
 } 
 
 
function setivaporcentaje_remoto($cod){
      //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_iva WHERE id_iva=$cod;";      
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   $iva=$row['porcentaje'];
	   return $iva;
	 }
   }
 } 
 
 

function gettarjetabl_remoto($cedula){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT cli_tarjetabl FROM tbl_cliente WHERE cli_cedula=$cedula ";
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	 }else{
	 $row = mysql_fetch_assoc($result);
	 $tarjeta=$row['cli_tarjetabl'];
	 return $tarjeta;
	 }
   }
 }
 
 function seteditorial_remoto($cod){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT tbl_inventario.cod_producto, tbl_editorial.editorial FROM tbl_inventario INNER JOIN tbl_editorial ON tbl_inventario.editorial = tbl_editorial.id_editorial WHERE (((tbl_inventario.cod_producto)='$cod'));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['editorial'];
	 }
   }
 } 


/*********************************/

/******************************/
function getsucursal_remoto($suc){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT cli_tarjetabl FROM tbl_cliente WHERE cli_cedula=$cedula ";
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	 }else{
	 $row = mysql_fetch_assoc($result);
	 $tarjeta=$row['cli_tarjetabl'];
	 return $tarjeta;
	 }
   }
 }

/*********************************/

function delitems_remoto($codf,$vend,$suc){
   $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){

	$r=$this->consultar("select * FROM tbl_itemfactura WHERE cod_factura='$codf' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=0 ");
	
	while($fil=mysql_fetch_assoc($r)){
	$prod=$fil['cod_producto'];
	$cif=$fil['cif'];
	$cic=$fil['cic'];
	$cicdn=$fil['cicdn'];
		
	$a="update tbl_distinventario set cantidad=cantidad+$cif WHERE cod_producto ='".addslashes($prod)."' and sucursal=$suc and condicion=1 ORDER BY cantidad,FECHA_NOTA_ENTREGA DESC LIMIT 1";
	$this->query_remoto($a);
	$b="update tbl_distinventario set cantidad=cantidad+$cic WHERE cod_producto ='".addslashes($prod)."' and sucursal=$suc and condicion=2 ORDER BY cantidad,FECHA_NOTA_ENTREGA DESC LIMIT 1";
	$this->query_remoto($b);
	$c="update tbl_distinventario set cantidad=cantidad+$cicdn WHERE cod_producto ='".addslashes($prod)."' and sucursal=$suc and condicion=3 ORDER BY cantidad,FECHA_NOTA_ENTREGA DESC LIMIT 1";
  	$this->query_remoto($c); 
	}

     $query = "DELETE FROM tbl_itemfactura WHERE cod_factura='$codf' and sucursal=$suc and vendedor=$vend and estatus_cancelacion=0 ";
     $result = @mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
 

 //elimina los items a la factura

function delfactura_remoto($codf,$vend,$suc){
   $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "DELETE FROM tbl_facturas WHERE cod_factura='$codf' and sucursal=$suc and vendedor=$vend and estatus_factura=0 ";
     $result = @mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
  
//elimina un item a la factura

function borraritem_remoto($codp,$cod,$cant,$suc){
die("Estoy borraritem_remoto en el manejador db de factura");
   $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
   
   $query2="select * FROM tbl_itemfactura WHERE id_itemfactura=$codp ";
   $r=$this->consultar($query2);
   $fil=mysql_fetch_assoc($r);
	$prod=$fil['cod_producto'];
	$cif=$fil['cif'];
	$cic=$fil['cic'];
	$cicdn=$fil['cicdn'];
		
	$a="update tbl_distinventario set cantidad=cantidad+$cif WHERE cod_producto ='".addslashes($cod)."' and sucursal=$suc and condicion=1 ORDER BY cantidad,FECHA_NOTA_ENTREGA DESC LIMIT 1 ";
	$this->query_remoto($a);
	$b="update tbl_distinventario set cantidad=cantidad+$cic WHERE cod_producto ='".addslashes($cod)."' and sucursal=$suc and condicion=2 ";
	$this->query_remoto($b);
	$c="update tbl_distinventario set cantidad=cantidad+$cicdn WHERE cod_producto ='".addslashes($cod)."' and sucursal=$suc and condicion=3 ";
  	$this->query_remoto($c); 
   
     $query = "DELETE FROM tbl_itemfactura WHERE id_itemfactura=$codp ";
     $result = @mysql_query($query);
	// $this->ainventario($cod,$cant);
     if (!$result)
	   return false;
     else
       return true;
   }
 }




 //Crea la factura 
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
     $query = "UPDATE tbl_itemfactura t SET estatus_cancelacion=3 where cod_factura='$codf' and sucursal=$suc and estatus_cancelacion=0 ";
      $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
}

//reducir inventario
function rinventario_remoto($codp,$cant){

while (!empty($codp) && !empty($cant)){
   $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "update tbl_inventario set cantidad=cantidad-$cant where cod_producto=$codp ";
     $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
 }
//fin

//Aumentar inventario
function ainventario_remoto($codp,$cant){

while (!empty($codp) && !empty($cant)){
   $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "update tbl_inventario set cantidad=cantidad+$cant where cod_producto=$codp ";
     $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
 }




function getexistencia_remoto($codigo,$suc){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
   
     $query = "SELECT sum(cantidad) as cantexist  FROM tbl_distinventario where `cod_producto`='$codigo' and sucursal=$suc;";
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	 }else{
	 $row = mysql_fetch_assoc($result);
	 $tarjeta=$row['cantexist'];
	 return $tarjeta;
	 }
   }
 }


function crearitem_remoto($codp,$codf,$cant,$preciounid,$existencia,$descripcion,$vend,$suc,$isbn,$vif,$vic,$vicdn,$descuento,$precio_sd,$iva){
while ($codp!="" && $codf!=""){ 
   $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
	 $query = "INSERT INTO tbl_itemfactura (cod_factura,cod_producto,descripcion,precio_unid,cantidad,existencia,descuento,sucursal,vendedor,isbn,cif,cic,cicdn,precio_sd,iva) 
	 VALUES ('$codf','$codp','$descripcion',$preciounid,$cant,$existencia,$descuento,$suc,$vend,'$isbn',$vif,$vic,$vicdn,$precio_sd,$iva)";
     $result = mysql_query($query);
	    // $this->rinventario($codp,$cant);
	 if (!$result)
	   return false;
     else
       return true;
   }
 }
}


function getpreferencia_remoto($sucursal,$preferencia){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT $preferencia FROM tbl_preferencias WHERE sucursal_id=$sucursal;";      
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row[$preferencia];
	   
	 }
   }
 }
 
}
?>
