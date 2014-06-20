<? 
include_once("../dbmanager.php");

//implementamos la clase 
class manejadordb{
 //constructor	
 function manejadordb(){
 
 }	
 // consultas 
function getfechamysql(){
    $year=date('Y');
	$month=date('m');
	$day=date('d');
	$hour=date('H')-1;
	$minute=date('i');
	$second=date('s');
	return $year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
}

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
//die("Estoy en la funcion consultar remoto correspondiente a manejadordb-->admin");
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
/*function gettarjetabl($cedula){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_inventario WHERE cod_producto='$codp'";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return $result;
   }
 }*/

function setuser($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_usuario WHERE id_usuario='$cod'";      
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
 
/*
function getautor($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_inventario WHERE cod_producto='$cod';";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['autor'];
	 }
   }
 } 
*/
/*
 function setcodinvlibro($codinv,$codp,$suc,$cond){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query="SELECT tbl_inventario.cod_producto  AS codigo FROM tbl_inventario INNER JOIN tbl_detalleinventario ON 
tbl_inventario.cod_producto = tbl_detalleinventario.cod_producto
WHERE (((tbl_inventario.cod_producto)='$codp') AND ((tbl_inventario.estatus)=1) AND ((tbl_detalleinventario.sucursal)=$suc) 
AND ((tbl_detalleinventario.condicion)=$cond) AND ((tbl_detalleinventario.estatus)=6) AND ((tbl_detalleinventario.cod_invent)='$codinv')) 
OR (((tbl_inventario.isbn)='$codp')) OR (((tbl_inventario.cod_barra)='$codp'));";
	 
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['codigo'];
	 }
   }
 } 
*/
function setmontoprecierre($user,$suc,$campo,$dated,$dateh){
   $fecha=$dated." 00:00:00";
   $fechah=$dateh." 23:59:59";
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT sum($campo) as monto, sum(cambio) as cambio FROM tbl_facturas WHERE vendedor=$user AND sucursal=$suc AND estatus_factura=3 AND fecha_factura Between '$fecha' And '$fechah'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
		if($campo=="efectivo"){
		return $row['monto']-$row['cambio'];
		}else   return $row['monto'];

	 }
   }
 } 

function setmontoprecierrexfecha($suc,$campo,$date){
   $fecha=$date." 00:00:00";
   $fechah=$date." 23:59:59";
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT sum($campo) as monto, sum(cambio) as cambio FROM tbl_facturas WHERE  sucursal=$suc AND estatus_factura=3 AND fecha_factura Between '$fecha' And '$fechah'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
		if($campo=="efectivo"){
		return $row['monto']-$row['cambio'];
		}else   return $row['monto'];

	 }
   }
 } 


function setsumtraslados($cod,$suc){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT sum(cantidad) as cantidad FROM tbl_itemtraslado WHERE cod_t='$cod' and sucursal=$suc";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['cantidad'];
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
/*
function seteditorial($cod){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
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
 } */
function geteditorial($cod){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      $query = "SELECT * FROM tbl_editorial WHERE (((id_editorial)=$cod));";      
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

function getcoleccion($cod){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      $query = "SELECT * FROM tbl_coleccion WHERE (((id_coleccion)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['col_descripcion'];
	 }
   }
 } 

function gettema($cod){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      $query = "SELECT * FROM tbl_tema WHERE (((id_tema)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['tema'];
	 }
   }
 } 
function getsubtema($cod){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      $query = "SELECT * FROM tbl_subtema WHERE (((id_subtema)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['subtema'];
	 }
   }
 } 

function getformato($cod){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      $query = "SELECT * FROM tbl_formato WHERE (((id)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['descripcion'];
	 }
   }
 } 

function gettomo($cod){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      $query = "SELECT * FROM tbl_tomo WHERE (((tomo_id)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['descripcion'];
	 }
   }
 } 
function getvolumen($cod){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      $query = "SELECT * FROM tbl_volumen WHERE (((volumen_id)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['descripcion'];
	 }
   }
 } 

function getedicion($cod){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      $query = "SELECT * FROM tbl_edicion WHERE (((edicion_id)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['descripcion'];
	 }
   }
 } 

/*
function getncoleccion($cod){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      $query = "SELECT * FROM tbl_inventario WHERE (((cod_producto)='$cod'));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['n_coleccion'];
	 }
   }
 } */
function getdescuento($cod,$suc){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      $query = "SELECT * FROM tbl_distinventario WHERE cod_producto='$cod' and sucursal=$suc;";      
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

function getexistencia($cod,$suc){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      $query = "SELECT sum(cantidad) as cantidad FROM tbl_distinventario WHERE cod_producto='$cod' and sucursal=$suc;";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['cantidad'];
	 }
   }
 } 
 
function setproveedor($cod){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
      $query = "SELECT * FROM tbl_proveedor WHERE (((id)=$cod));";      
	  $result = @mysql_query($query);
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['proveedor'];
	 }
   }
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
	   return $row['precio'];
	 }
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
	   return $row['descuento'];
	 }
   }
 } */
/*
function setcosto($cod){
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
	   return $row['costo'];
	 }
   }
 } 
*/

function setnivel($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_nivel WHERE id_nivel='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['nivel'];
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

 function settraslado($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_traslados WHERE id_traslado='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['cod_traslado'];
	 }
   }
 } 

function setcondicionsol($cods){
    //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_solicitud WHERE codigo='$cods'";      
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['condicion'];
	 }
   }
 } 

function setcondicion($id){
    //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_condicion WHERE id_condicion=$id;";      
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return utf8_encode($row['cond_descripcion']);
	 }
   }
 } 


function procesartraslado($id,$fecha,$usuario){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "update tbl_traslados set estatus=8,cargadopor='$usuario',fechacarga='$fecha' WHERE cod_traslado='$id' ";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return true;
   }
 }

function anulartraslado($id,$fecha,$usuario){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "update tbl_traslados set estatus=18,cargadopor='$usuario',fechacarga='$fecha' WHERE cod_traslado='$id' ";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return true;
   }
 }

function anularitemtraslado($id,$fecha,$usuario){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "update tbl_itemtraslado set estatus=18 where cod_t='$id';";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return true;
   }
}



function verificart($codp,$cond,$suc){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_distinventario WHERE cod_producto='$codp' and sucursal=$suc and condicion=$cond ";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   $row = mysql_num_rows($result);	  
	   return $row;
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

/*
function existencia($codp){
   
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_inventario WHERE cod_producto='$codp'";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return $result;
   }
 }
*/

 
 //elimina los items a la factura
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
  
//elimina un item a la factura

function borraritem($codp,$cod,$cant){
//die("<script>alert('Estoy aqui en borraritem***')</script>");
   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "DELETE FROM tbl_itemfactura WHERE id_itemfactura='$codp' ";
     $result = @mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
 //inserta un nuevo item a la factura
 
function detallesolicitud($cods){

   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "select * from tbl_itemsolicitud where cod_sol='$cods'";
     $result = mysql_query($query);
     if (!$result)
	   return false;
     else{
	 echo'<table width="730" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla" >
	<tr bgcolor="#990000">
    <td colspan="15"><div align="center" class="Style5"><strong>Listado de Libros Solicitados </strong></div></td>
    </tr>
     <tr>
      <td bgcolor="#990000" class="celdal"><div align="center"><strong>C&oacute;digo</strong></div></td>
      <td colspan="9" align="left" bgcolor="#990000" class="celdal"><div align="center"><strong>T&iacute;tulo</strong></div></td>
      <td colspan="2" align="center" bgcolor="#990000" class="celdal"><div align="center"><strong>Cantidad</strong></div></td>
      <td align="center" bgcolor="#990000" class="celdal"><strong>Bs.F</strong></td>
      <td align="center" bgcolor="#990000" class="celdal"><strong>*</strong></td>
    </tr>';
	$montototal=0;
	 while($row = mysql_fetch_assoc($result)){	  
	 $montototal=$montototal+$row['total'];
	echo "<tr>";
	 echo "<td class=\"celdal\"><div align=\"center\">".$row['cod_libro']."</div></td>
      <td colspan=\"9\" class=\"celdal\"><div align=\"left\">".$row['titulo']."</div></td>
      <td colspan=\"2\" align=\"center\" class=\"celdal\"><div align=\"center\">".$row['cantidad']."</div></td>
      <td class=\"celdal\"><div align=\"right\">".number_format($row['costo'],2,',','.')."</div></td>";
	 echo '<td align="center" bgcolor="#990000" class="celdal"><input type="radio" name="listado" id="listado" value="'.$row['id'].'"></td>';
	 echo "</tr>";
	 }
	 
	echo'<tr bgcolor="#F5F5F5">
    <td colspan="15" class="celdal"><div align="center" class="Style5"><strong>&nbsp;</strong></div></td>
    	</tr>';
	echo'<tr bgcolor="#990000">
    <td colspan="15"><div align="right" class="Style5"><strong></strong><strong>
        <input type="hidden" name="totalgen" id="totalgen" readonly="true" size="15" class="bordes" value="'.$montototal.'"/>
      </strong></div></td>
    	</tr>';
/*	echo'<tr bgcolor="#990000">
    <td colspan="15"><div align="right" class="Style5"><strong>Total General: </strong><strong>
        <input type="text" name="totalgen1" id="totalgen1" readonly="true" size="15" class="bordes" value="'.number_format($montototal,2,',','.').'"/>
      </strong></div></td>
    	</tr>';*/
	 echo'<tr bgcolor="#990000">
    <td colspan="15"><div align="right" class="Style5"><strong>Total Bs.F: </strong><strong>
        <input type="text" name="totalgen2" id="totalgen2" readonly="true" size="15" class="bordes" value="'.number_format($montototal,2,',','.').'"/>
      </strong></div></td>
    	</tr>';
 	 echo'</table>';
	 }
   }
} 
 
function detalletraslado($cods){

   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "select * from tbl_itemsolicitud where cod_sol='$cods'";
	 $result = mysql_query($query);
     $query2 = "select * from tbl_solicitud where codigo='$cods'";
	 $result2 = mysql_query($query2);
	 if (!$result && !$result2)
	   return false;
     else{
	 $cond = mysql_fetch_assoc($result2);
	 $condicion=$cond['condicion'];
	 echo'<input name="condicion" type="hidden" id="condicion" value="'.$condicion.'">
	 <table width="730" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla" >
	<tr bgcolor="#990000">
    <td colspan="15"><div align="center" class="Style5"><strong>Detalle de la Solicitud</strong></div></td>
    </tr>
     <tr>
      <td bgcolor="#990000" class="celdal"><div align="center"><strong>C&oacute;digo</strong></div></td>
      <td colspan="9" align="left" bgcolor="#990000" class="celdal"><div align="center"><strong>T&iacute;tulo</strong></div></td>
      <td colspan="2" align="center" bgcolor="#990000" class="celdal"><div align="center"><strong>Cantidad</strong></div></td>
      <td bgcolor="#990000" class="celdal"><div align="center"><strong>Cant. Dist</strong></div><div align="center"></div></td>
      <td align="center" bgcolor="#990000" class="celdal"><strong>Por Dist.</strong></td>
      <td align="center" bgcolor="#990000" class="celdal"><strong>*</strong></td>
    </tr>';
	$montototal=0;
	 while($row = mysql_fetch_assoc($result)){	  
	 $cantpd=$row['cantidad']-$row['cantdist'];
	echo "<tr>";
	 echo "<td class=\"celdal\"><div align=\"center\">".$row['cod_libro']."</div></td>
      <td colspan=\"9\" class=\"celdal\"><div align=\"left\">".$row['titulo']."</div></td>
      <td colspan=\"2\" align=\"center\" class=\"celdal\"><div align=\"center\">".$row['cantidad']."</div></td>
      <td class=\"celdal\"><div align=\"center\">".$row['cantdist']."</div></td>
      <td class=\"celdal\"><div align=\"center\">".$cantpd."</div></td>";
	 echo "<td align='center' bgcolor='#990000' class='celdal'><input type='radio' name='listado' id='listado' value='".$row['id']."' onclick=\"cantidad(".$row['id'].")\"></td>";
	 echo "</tr>";
	 }
	 
	echo'<tr bgcolor="#F5F5F5">
    <td colspan="15" class="celdal"><div align="center" class="Style5"><strong>&nbsp;</strong></div></td>
    	</tr>';
 	 echo'</table>';
	 }
   }
}

function traslados($codt){

   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "select * from tbl_itemtraslado where cod_t='$codt'";
     $result = mysql_query($query);
     if (!$result)
	   return false;
     else{
	 echo'<table width="730" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla" >
	<tr bgcolor="#990000">
    <td colspan="15"><div align="center" class="Style5"><strong>Detalle de Traslado</strong></div></td>
    </tr>
     <tr>
      <td bgcolor="#990000" class="celdal"><div align="center"><strong>C&oacute;digo</strong></div></td>
      <td colspan="9" align="left" bgcolor="#990000" class="celdal"><div align="center"><strong>T&iacute;tulo</strong></div></td>
      <td colspan="2" align="center" bgcolor="#990000" class="celdal"><div align="center"><strong>Cantidad</strong></div></td>
      <td bgcolor="#990000" class="celdal"><div align="center"><strong>Sucursal</strong></div><div align="center"></div></td>
      <td align="center" bgcolor="#990000" class="celdal"><strong>Condici&oacute;n</strong></td>
      <td align="center" bgcolor="#990000" class="celdal"><strong>*</strong></td>
    </tr>';
	 while($row = mysql_fetch_assoc($result)){	  
		echo "<tr>";
	 echo "<td class=\"celdal\"><div align=\"center\">".$row['cod_l']."</div></td>
      <td colspan=\"9\" class=\"celdal\"><div align=\"left\">".$row['titulo']."</div></td>
      <td colspan=\"2\" align=\"center\" class=\"celdal\"><div align=\"center\">".$row['cantidad']."</div></td>
      <td class=\"celdal\"><div align=\"center\">".$this->setsucursal($row['sucursal'])."</div></td>
      <td class=\"celdal\"><div align=\"center\">".$this->setcondicion($row['condicion'])."</div></td>";
	 echo "<td align='center' bgcolor='#990000' class='celdal'><input type='radio' name='itemt' id='itemt' value='".$row['id']."'></td>";
	 echo "</tr>";
	 }
	 
	echo'<tr bgcolor="#F5F5F5">
    <td colspan="15" class="celdal"><div align="center" class="Style5"><strong>&nbsp;</strong></div></td>
    	</tr>';
 	 echo'</table>';
	 }
   }
}

function verifisol($user){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
     $query = "SELECT * FROM tbl_solicitud WHERE incluidapor=$user and estatus=0 ";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   $row = mysql_num_rows($result);	  
	   return $row;
   }
 }

function getattrsol($cods,$dato){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
   $query = "SELECT tbl_usuario.us_login AS usuario, tbl_condicion.cond_descripcion AS condicion, tbl_proveedor.proveedor AS proveedor, tbl_proveedor.direccion AS direccion, tbl_proveedor.rif AS rif, tbl_formapago.formapago AS fpago, tbl_estatus.estatus AS estatus, tbl_tipoproveedor.tipoproveedor AS tipo, tbl_solicitud.fecha_entrega AS entrega, tbl_solicitud.fecha_vencconsig AS vencimiento, tbl_solicitud.fecha_venc AS venconsig ";
  $query .= " FROM (((((tbl_solicitud INNER JOIN tbl_usuario ON tbl_solicitud.incluidapor = tbl_usuario.id_usuario) INNER JOIN tbl_condicion ON tbl_solicitud.condicion = tbl_condicion.id_condicion) INNER JOIN tbl_proveedor ON tbl_solicitud.proveedor = tbl_proveedor.id) INNER JOIN tbl_formapago ON tbl_solicitud.formapago = tbl_formapago.id) INNER JOIN tbl_estatus ON tbl_solicitud.estatus = tbl_estatus.id_estatus) INNER JOIN tbl_tipoproveedor ON (tbl_formapago.id = tbl_tipoproveedor.id) AND (tbl_proveedor.tipo_proveedor = tbl_tipoproveedor.id)";
$query .= " WHERE (((tbl_solicitud.codigo)='$cods')) GROUP BY tbl_usuario.us_login, tbl_condicion.cond_descripcion, tbl_proveedor.proveedor, tbl_proveedor.direccion, tbl_proveedor.rif, tbl_formapago.formapago, tbl_estatus.estatus, tbl_tipoproveedor.tipoproveedor, tbl_solicitud.fecha_entrega, tbl_solicitud.fecha_vencconsig, tbl_solicitud.fecha_venc;";      

	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   $row = mysql_fetch_assoc($result);	  
	   return $row[$dato];
   }
 }

function getattrtraslado($codt,$dato){
   //creamos el objeto $con a partir de la clase DBManager
   $con = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con->conectar()==true){
   $query = "SELECT tbl_traslados.cod_traslado AS codigo, tbl_itemtraslado.cod_l AS libro, tbl_itemtraslado.titulo AS titulo, tbl_itemtraslado.editorial AS editorial, tbl_itemtraslado.precio AS precio, tbl_itemtraslado.sucursal AS sucursal, tbl_itemtraslado.cantidad AS cantidad, tbl_itemtraslado.condicion AS condicion, tbl_itemtraslado.solicitud, tbl_traslados.incluidopor, tbl_traslados.fechainclusion, tbl_traslados.estatus, tbl_traslados.observaciones FROM tbl_traslados INNER JOIN tbl_itemtraslado ON tbl_traslados.cod_traslado = tbl_itemtraslado.cod_t WHERE (((tbl_traslados.cod_traslado)='$codt')) ORDER BY tbl_itemtraslado.sucursal;"; 

	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   $row = mysql_fetch_assoc($result);	  
	   return $row[$dato];
   }
 }

function codigo($table,$column,$tipo,$user){
$cad="";
   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "select $column from $table order by $column desc";
     $result = mysql_query($query);
     if (!$result){
	   return false;
     }else{
	   $row = mysql_fetch_assoc($result);	  
	   if($tipo==1)$cad="FA";
	   if($tipo==2)$cad="FD";
	   if($tipo==3)$cad="SMLS";
	   if($tipo==4)$cad="RLS";
	   //$cad.= $row['id']+1;
		
	$row = mysql_fetch_assoc($this->consultar("select correlativo from tbl_solicitud order by correlativo desc"));
	$cod=$row['correlativo'];
	$row2 = mysql_fetch_assoc($this->consultar("select correlativo from tbl_solicitud where incluidapor=$user and estatus=0"));
	$cod2=$row2['correlativo'];
	$codactual=$cad.$cod2;
	if($cod=="")$cod=1;else $cod+=1;
	$codigosol=$cad.$cod;
	
	if(mysql_num_rows($this->consultar("select * from tbl_solicitud where incluidapor=$user and estatus=0"))==0){
	$this->query("insert into tbl_solicitud (codigo,fecha,incluidapor,correlativo)values('$codigosol','".date('Y-m-d')."',$user,$cod)");
	return $codigosol;
   	}else return $codactual;
   	mysql_close($con); 
}	
}
}
function codigot($table,$column,$tipo,$user){
$cad="";
   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "select $column from $table order by $column desc";
     $result = mysql_query($query);
     if (!$result){
	   return false;
     }else{
	   $row = mysql_fetch_assoc($result);	  
	   if($tipo==1)$cad="FA";
	   if($tipo==2)$cad="FD";
	   if($tipo==3)$cad="SMLS";
	   if($tipo==4)$cad="RLS";
	   //$cad.= $row['id']+1;
		
	   $row = mysql_fetch_assoc($this->consultar("select correlativo from $table order by correlativo desc"));
       $cod=$row['correlativo'];
	   $row2 = mysql_fetch_assoc($this->consultar("select correlativo from $table where incluidopor=$user and estatus=12"));
	   $cod2=$row2['correlativo'];
	   $codactual=$cad.$cod2;
	   if($cod=="")$cod=1;else $cod+=1;
	   $codigot=$cad.$cod;
	
	if(mysql_num_rows($this->consultar("select * from $table where incluidopor=$user and estatus=12"))==0){
	$this->query("insert into $table (cod_traslado,estatus,incluidopor,fechainclusion,correlativo)values('$codigot',12,$user,'".date('Y-m-d')."',$cod)");
	return $codigot;
   	}else return $codactual;
   	mysql_close($con); 
}	
}
}

function crearitem($codp,$codf,$cant,$preciounid,$existencia,$descripcion){
while ($codp!="" && $codf!=""){
   $con = new dbmanager;
   if($con->conectar()==true){
     $query = "INSERT INTO tbl_itemfactura (cod_factura,cod_producto,descripcion,precio_unid,cantidad,existencia) 
	 VALUES ('$codf','$codp','$descripcion',$preciounid,$cant,$existencia)";
	 //die($query);
     $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
 }
 
 
 function query_remoto($query=""){
// die("Estoy en la funcion query_remoto correspondiente a manejadordb-->admin");
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
function gettarjetabl_remoto($cedula){
   
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

function setuser_remoto($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_usuario WHERE id_usuario='$cod'";      
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
 

function getautor_remoto($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_inventario WHERE cod_producto='$cod';";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['autor'];
	 }
   }
 } 


 function setcodinvlibro_remoto($codinv,$codp,$suc,$cond){
   
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query="SELECT tbl_inventario.cod_producto  AS codigo FROM tbl_inventario INNER JOIN tbl_detalleinventario ON 
tbl_inventario.cod_producto = tbl_detalleinventario.cod_producto
WHERE (((tbl_inventario.cod_producto)='$codp') AND ((tbl_inventario.estatus)=1) AND ((tbl_detalleinventario.sucursal)=$suc) 
AND ((tbl_detalleinventario.condicion)=$cond) AND ((tbl_detalleinventario.estatus)=6) AND ((tbl_detalleinventario.cod_invent)='$codinv')) 
OR (((tbl_inventario.isbn)='$codp')) OR (((tbl_inventario.cod_barra)='$codp'));";
	 
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['codigo'];
	 }
   }
 } 

function setmontoprecierre_remoto($user,$suc,$campo,$dated,$dateh){
   $fecha=$dated." 00:00:00";
   $fechah=$dateh." 23:59:59";
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT sum($campo) as monto, sum(cambio) as cambio FROM tbl_facturas WHERE vendedor=$user AND sucursal=$suc AND estatus_factura=3 AND fecha_factura Between '$fecha' And '$fechah'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
		if($campo=="efectivo"){
		return $row['monto']-$row['cambio'];
		}else   return $row['monto'];

	 }
   }
 } 

function setmontoprecierrexfecha_remoto($suc,$campo,$date){
   $fecha=$date." 00:00:00";
   $fechah=$date." 23:59:59";
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT sum($campo) as monto, sum(cambio) as cambio FROM tbl_facturas WHERE  sucursal=$suc AND estatus_factura=3 AND fecha_factura Between '$fecha' And '$fechah'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
		if($campo=="efectivo"){
		return $row['monto']-$row['cambio'];
		}else   return $row['monto'];

	 }
   }
 } 


function setsumtraslados_remoto($cod,$suc){
   
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT sum(cantidad) as cantidad FROM tbl_itemtraslado WHERE cod_t='$cod' and sucursal=$suc";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['cantidad'];
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
function geteditorial_remoto($cod){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT * FROM tbl_editorial WHERE (((id_editorial)=$cod));";      
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

function getcoleccion_remoto($cod){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT * FROM tbl_coleccion WHERE (((id_coleccion)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['col_descripcion'];
	 }
   }
 } 

function gettema_remoto($cod){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT * FROM tbl_tema WHERE (((id_tema)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['tema'];
	 }
   }
 } 
function getsubtema_remoto($cod){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT * FROM tbl_subtema WHERE (((id_subtema)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['subtema'];
	 }
   }
 } 

function getformato_remoto($cod){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT * FROM tbl_formato WHERE (((id)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['descripcion'];
	 }
   }
 } 

function gettomo_remoto($cod){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT * FROM tbl_tomo WHERE (((tomo_id)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['descripcion'];
	 }
   }
 } 
function getvolumen_remoto($cod){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT * FROM tbl_volumen WHERE (((volumen_id)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['descripcion'];
	 }
   }
 } 

function getedicion_remoto($cod){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT * FROM tbl_edicion WHERE (((edicion_id)=$cod));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['descripcion'];
	 }
   }
 } 


function getncoleccion_remoto($cod){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT * FROM tbl_inventario WHERE (((cod_producto)='$cod'));";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['n_coleccion'];
	 }
   }
 } 
function getdescuento_remoto($cod,$suc){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT * FROM tbl_distinventario WHERE cod_producto='$cod' and sucursal=$suc;";      
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

function getexistencia_remoto($cod,$suc){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT sum(cantidad) as cantidad FROM tbl_distinventario WHERE cod_producto='$cod' and sucursal=$suc;";      
	  $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['cantidad'];
	 }
   }
 } 
 
function setproveedor_remoto($cod){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
      $query = "SELECT * FROM tbl_proveedor WHERE (((id)=$cod));";      
	  $result = @mysql_query($query);
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['proveedor'];
	 }
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
	   return $row['precio'];
	 }
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
	   return $row['descuento'];
	 }
   }
 } 

function setcosto_remoto($cod){
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
	   return $row['costo'];
	 }
   }
 } 


function setnivel_remoto($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_nivel WHERE id_nivel='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['nivel'];
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

 function settraslado_remoto($cod){
   
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_traslados WHERE id_traslado='$cod'";      
	 $result = @mysql_query($query);
	 
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['cod_traslado'];
	 }
   }
 } 

function setcondicionsol_remoto($cods){
    //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_solicitud WHERE codigo='$cods'";      
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return $row['condicion'];
	 }
   }
 } 

function setcondicion_remoto($id){
    //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_condicion WHERE id_condicion=$id;";      
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	  
	   return utf8_encode($row['cond_descripcion']);
	 }
   }
 } 


function procesartraslado_remoto($id,$fecha,$usuario){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "update tbl_traslados set estatus=8,cargadopor='$usuario',fechacarga='$fecha' WHERE cod_traslado='$id' ";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return true;
   }
 }

function anulartraslado_remoto($id,$fecha,$usuario){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "update tbl_traslados set estatus=18,cargadopor='$usuario',fechacarga='$fecha' WHERE cod_traslado='$id' ";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return true;
   }
 }

function anularitemtraslado_remoto($id,$fecha,$usuario){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "update tbl_itemtraslado set estatus=18 where cod_t='$id';";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   return true;
   }
}



function verificart_remoto($codp,$cond,$suc){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_distinventario WHERE cod_producto='$codp' and sucursal=$suc and condicion=$cond ";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   $row = mysql_num_rows($result);	  
	   return $row;
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

function borraritem_remoto($codp,$cod,$cant){
  $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "DELETE FROM tbl_itemfactura WHERE id_itemfactura='$codp' ";
     $result = @mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
 //inserta un nuevo item a la factura
 
function detallesolicitud_remoto($cods){

  $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "select * from tbl_itemsolicitud where cod_sol='$cods'";
     $result = mysql_query($query);
     if (!$result)
	   return false;
     else{
	 echo'<table width="730" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla" >
	<tr bgcolor="#990000">
    <td colspan="15"><div align="center" class="Style5"><strong>Listado de Libros Solicitados </strong></div></td>
    </tr>
     <tr>
      <td bgcolor="#990000" class="celdal"><div align="center"><strong>C&oacute;digo</strong></div></td>
      <td colspan="9" align="left" bgcolor="#990000" class="celdal"><div align="center"><strong>T&iacute;tulo</strong></div></td>
      <td colspan="2" align="center" bgcolor="#990000" class="celdal"><div align="center"><strong>Cantidad</strong></div></td>
      <td align="center" bgcolor="#990000" class="celdal"><strong>Bs.F</strong></td>
      <td align="center" bgcolor="#990000" class="celdal"><strong>*</strong></td>
    </tr>';
	$montototal=0;
	 while($row = mysql_fetch_assoc($result)){	  
	 $montototal=$montototal+$row['total'];
	echo "<tr>";
	 echo "<td class=\"celdal\"><div align=\"center\">".$row['cod_libro']."</div></td>
      <td colspan=\"9\" class=\"celdal\"><div align=\"left\">".$row['titulo']."</div></td>
      <td colspan=\"2\" align=\"center\" class=\"celdal\"><div align=\"center\">".$row['cantidad']."</div></td>
      <td class=\"celdal\"><div align=\"right\">".number_format($row['costo'],2,',','.')."</div></td>";
	 echo '<td align="center" bgcolor="#990000" class="celdal"><input type="radio" name="listado" id="listado" value="'.$row['id'].'"></td>';
	 echo "</tr>";
	 }
	 
	echo'<tr bgcolor="#F5F5F5">
    <td colspan="15" class="celdal"><div align="center" class="Style5"><strong>&nbsp;</strong></div></td>
    	</tr>';
	echo'<tr bgcolor="#990000">
    <td colspan="15"><div align="right" class="Style5"><strong></strong><strong>
        <input type="hidden" name="totalgen" id="totalgen" readonly="true" size="15" class="bordes" value="'.$montototal.'"/>
      </strong></div></td>
    	</tr>';
/*	echo'<tr bgcolor="#990000">
    <td colspan="15"><div align="right" class="Style5"><strong>Total General: </strong><strong>
        <input type="text" name="totalgen1" id="totalgen1" readonly="true" size="15" class="bordes" value="'.number_format($montototal,2,',','.').'"/>
      </strong></div></td>
    	</tr>';*/
	 echo'<tr bgcolor="#990000">
    <td colspan="15"><div align="right" class="Style5"><strong>Total Bs.F: </strong><strong>
        <input type="text" name="totalgen2" id="totalgen2" readonly="true" size="15" class="bordes" value="'.number_format($montototal,2,',','.').'"/>
      </strong></div></td>
    	</tr>';
 	 echo'</table>';
	 }
   }
} 
 
function detalletraslado_remoto($cods){

  $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "select * from tbl_itemsolicitud where cod_sol='$cods'";
	 $result = mysql_query($query);
     $query2 = "select * from tbl_solicitud where codigo='$cods'";
	 $result2 = mysql_query($query2);
	 if (!$result && !$result2)
	   return false;
     else{
	 $cond = mysql_fetch_assoc($result2);
	 $condicion=$cond['condicion'];
	 echo'<input name="condicion" type="hidden" id="condicion" value="'.$condicion.'">
	 <table width="730" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla" >
	<tr bgcolor="#990000">
    <td colspan="15"><div align="center" class="Style5"><strong>Detalle de la Solicitud</strong></div></td>
    </tr>
     <tr>
      <td bgcolor="#990000" class="celdal"><div align="center"><strong>C&oacute;digo</strong></div></td>
      <td colspan="9" align="left" bgcolor="#990000" class="celdal"><div align="center"><strong>T&iacute;tulo</strong></div></td>
      <td colspan="2" align="center" bgcolor="#990000" class="celdal"><div align="center"><strong>Cantidad</strong></div></td>
      <td bgcolor="#990000" class="celdal"><div align="center"><strong>Cant. Dist</strong></div><div align="center"></div></td>
      <td align="center" bgcolor="#990000" class="celdal"><strong>Por Dist.</strong></td>
      <td align="center" bgcolor="#990000" class="celdal"><strong>*</strong></td>
    </tr>';
	$montototal=0;
	 while($row = mysql_fetch_assoc($result)){	  
	 $cantpd=$row['cantidad']-$row['cantdist'];
	echo "<tr>";
	 echo "<td class=\"celdal\"><div align=\"center\">".$row['cod_libro']."</div></td>
      <td colspan=\"9\" class=\"celdal\"><div align=\"left\">".$row['titulo']."</div></td>
      <td colspan=\"2\" align=\"center\" class=\"celdal\"><div align=\"center\">".$row['cantidad']."</div></td>
      <td class=\"celdal\"><div align=\"center\">".$row['cantdist']."</div></td>
      <td class=\"celdal\"><div align=\"center\">".$cantpd."</div></td>";
	 echo "<td align='center' bgcolor='#990000' class='celdal'><input type='radio' name='listado' id='listado' value='".$row['id']."' onclick=\"cantidad(".$row['id'].")\"></td>";
	 echo "</tr>";
	 }
	 
	echo'<tr bgcolor="#F5F5F5">
    <td colspan="15" class="celdal"><div align="center" class="Style5"><strong>&nbsp;</strong></div></td>
    	</tr>';
 	 echo'</table>';
	 }
   }
}

function traslados_remoto($codt){

  $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "select * from tbl_itemtraslado where cod_t='$codt'";
     $result = mysql_query($query);
     if (!$result)
	   return false;
     else{
	 echo'<table width="730" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla" >
	<tr bgcolor="#990000">
    <td colspan="15"><div align="center" class="Style5"><strong>Detalle de Traslado</strong></div></td>
    </tr>
     <tr>
      <td bgcolor="#990000" class="celdal"><div align="center"><strong>C&oacute;digo</strong></div></td>
      <td colspan="9" align="left" bgcolor="#990000" class="celdal"><div align="center"><strong>T&iacute;tulo</strong></div></td>
      <td colspan="2" align="center" bgcolor="#990000" class="celdal"><div align="center"><strong>Cantidad</strong></div></td>
      <td bgcolor="#990000" class="celdal"><div align="center"><strong>Sucursal</strong></div><div align="center"></div></td>
      <td align="center" bgcolor="#990000" class="celdal"><strong>Condici&oacute;n</strong></td>
      <td align="center" bgcolor="#990000" class="celdal"><strong>*</strong></td>
    </tr>';
	 while($row = mysql_fetch_assoc($result)){	  
		echo "<tr>";
	 echo "<td class=\"celdal\"><div align=\"center\">".$row['cod_l']."</div></td>
      <td colspan=\"9\" class=\"celdal\"><div align=\"left\">".$row['titulo']."</div></td>
      <td colspan=\"2\" align=\"center\" class=\"celdal\"><div align=\"center\">".$row['cantidad']."</div></td>
      <td class=\"celdal\"><div align=\"center\">".$this->setsucursal($row['sucursal'])."</div></td>
      <td class=\"celdal\"><div align=\"center\">".$this->setcondicion($row['condicion'])."</div></td>";
	 echo "<td align='center' bgcolor='#990000' class='celdal'><input type='radio' name='itemt' id='itemt' value='".$row['id']."'></td>";
	 echo "</tr>";
	 }
	 
	echo'<tr bgcolor="#F5F5F5">
    <td colspan="15" class="celdal"><div align="center" class="Style5"><strong>&nbsp;</strong></div></td>
    	</tr>';
 	 echo'</table>';
	 }
   }
}

function verifisol_remoto($user){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT * FROM tbl_solicitud WHERE incluidapor=$user and estatus=0 ";      
	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   $row = mysql_num_rows($result);	  
	   return $row;
   }
 }

function getattrsol_remoto($cods,$dato){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
   $query = "SELECT tbl_usuario.us_login AS usuario, tbl_condicion.cond_descripcion AS condicion, tbl_proveedor.proveedor AS proveedor, tbl_proveedor.direccion AS direccion, tbl_proveedor.rif AS rif, tbl_formapago.formapago AS fpago, tbl_estatus.estatus AS estatus, tbl_tipoproveedor.tipoproveedor AS tipo, tbl_solicitud.fecha_entrega AS entrega, tbl_solicitud.fecha_vencconsig AS vencimiento, tbl_solicitud.fecha_venc AS venconsig ";
  $query .= " FROM (((((tbl_solicitud INNER JOIN tbl_usuario ON tbl_solicitud.incluidapor = tbl_usuario.id_usuario) INNER JOIN tbl_condicion ON tbl_solicitud.condicion = tbl_condicion.id_condicion) INNER JOIN tbl_proveedor ON tbl_solicitud.proveedor = tbl_proveedor.id) INNER JOIN tbl_formapago ON tbl_solicitud.formapago = tbl_formapago.id) INNER JOIN tbl_estatus ON tbl_solicitud.estatus = tbl_estatus.id_estatus) INNER JOIN tbl_tipoproveedor ON (tbl_formapago.id = tbl_tipoproveedor.id) AND (tbl_proveedor.tipo_proveedor = tbl_tipoproveedor.id)";
$query .= " WHERE (((tbl_solicitud.codigo)='$cods')) GROUP BY tbl_usuario.us_login, tbl_condicion.cond_descripcion, tbl_proveedor.proveedor, tbl_proveedor.direccion, tbl_proveedor.rif, tbl_formapago.formapago, tbl_estatus.estatus, tbl_tipoproveedor.tipoproveedor, tbl_solicitud.fecha_entrega, tbl_solicitud.fecha_vencconsig, tbl_solicitud.fecha_venc;";      

	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   $row = mysql_fetch_assoc($result);	  
	   return $row[$dato];
   }
 }

function getattrtraslado_remoto($codt,$dato){
   //creamos el objeto $con a partir de la clase DBManager
  $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
   $query = "SELECT tbl_traslados.cod_traslado AS codigo, tbl_itemtraslado.cod_l AS libro, tbl_itemtraslado.titulo AS titulo, tbl_itemtraslado.editorial AS editorial, tbl_itemtraslado.precio AS precio, tbl_itemtraslado.sucursal AS sucursal, tbl_itemtraslado.cantidad AS cantidad, tbl_itemtraslado.condicion AS condicion, tbl_itemtraslado.solicitud, tbl_traslados.incluidopor, tbl_traslados.fechainclusion, tbl_traslados.estatus, tbl_traslados.observaciones FROM tbl_traslados INNER JOIN tbl_itemtraslado ON tbl_traslados.cod_traslado = tbl_itemtraslado.cod_t WHERE (((tbl_traslados.cod_traslado)='$codt')) ORDER BY tbl_itemtraslado.sucursal;"; 

	 $result = @mysql_query($query);
	 if (!$result)
	   return false;
	 else
	   $row = mysql_fetch_assoc($result);	  
	   return $row[$dato];
   }
 }

function codigo_remoto($table,$column,$tipo,$user){
$cad="";
  $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "select $column from $table order by $column desc";
     $result = mysql_query($query);
     if (!$result){
	   return false;
     }else{
	   $row = mysql_fetch_assoc($result);	  
	   if($tipo==1)$cad="FA";
	   if($tipo==2)$cad="FD";
	   if($tipo==3)$cad="SMLS";
	   if($tipo==4)$cad="RLS";
	   //$cad.= $row['id']+1;
		
	$row = mysql_fetch_assoc($this->consultar("select correlativo from tbl_solicitud order by correlativo desc"));
	$cod=$row['correlativo'];
	$row2 = mysql_fetch_assoc($this->consultar("select correlativo from tbl_solicitud where incluidapor=$user and estatus=0"));
	$cod2=$row2['correlativo'];
	$codactual=$cad.$cod2;
	if($cod=="")$cod=1;else $cod+=1;
	$codigosol=$cad.$cod;
	
	if(mysql_num_rows($this->consultar("select * from tbl_solicitud where incluidapor=$user and estatus=0"))==0){
	$this->query("insert into tbl_solicitud (codigo,fecha,incluidapor,correlativo)values('$codigosol','".date('Y-m-d')."',$user,$cod)");
	return $codigosol;
   	}else return $codactual;
   	mysql_close($con); 
}	
}
}
function codigot_remoto($table,$column,$tipo,$user){
$cad="";
  $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "select $column from $table order by $column desc";
     $result = mysql_query($query);
     if (!$result){
	   return false;
     }else{
	   $row = mysql_fetch_assoc($result);	  
	   if($tipo==1)$cad="FA";
	   if($tipo==2)$cad="FD";
	   if($tipo==3)$cad="SMLS";
	   if($tipo==4)$cad="RLS";
	   //$cad.= $row['id']+1;
		
	   $row = mysql_fetch_assoc($this->consultar("select correlativo from $table order by correlativo desc"));
       $cod=$row['correlativo'];
	   $row2 = mysql_fetch_assoc($this->consultar("select correlativo from $table where incluidopor=$user and estatus=12"));
	   $cod2=$row2['correlativo'];
	   $codactual=$cad.$cod2;
	   if($cod=="")$cod=1;else $cod+=1;
	   $codigot=$cad.$cod;
	
	if(mysql_num_rows($this->consultar("select * from $table where incluidopor=$user and estatus=12"))==0){
	$this->query("insert into $table (cod_traslado,estatus,incluidopor,fechainclusion,correlativo)values('$codigot',12,$user,'".date('Y-m-d')."',$cod)");
	return $codigot;
   	}else return $codactual;
   	mysql_close($con); 
}	
}
}

function crearitem_remoto($codp,$codf,$cant,$preciounid,$existencia,$descripcion){
while ($codp!="" && $codf!=""){
  $con_remoto = new dbmanager;
   if($con_remoto->conectar_remoto()==true){
     $query = "INSERT INTO tbl_itemfactura (cod_factura,cod_producto,descripcion,precio_unid,cantidad,existencia) 
	 VALUES ('$codf','$codp','$descripcion',$preciounid,$cant,$existencia)";
     $result = mysql_query($query);
     if (!$result)
	   return false;
     else
       return true;
   }
 }
 }
 

function setiva_remoto($cod){
      //creamos el objeto $con a partir de la clase DBManager
   $con_remoto = new dbmanager;
   //usamos el metodo conectar para realizar la conexion
   if($con_remoto->conectar_remoto()==true){
     $query = "SELECT iva FROM tbl_inventario WHERE cod_producto=$cod;";      
	 $result = @mysql_query($query);
	 if (!$result){
	   return false;
	   }
	 else{
	   $row = mysql_fetch_assoc($result);	 
		$iva=$row['iva'];
	   return $iva;
	 }
   }
 } 

 
 
}
?>
