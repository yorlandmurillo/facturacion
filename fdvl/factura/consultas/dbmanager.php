<?
class dbmanager{
  var $conect;
     function dbmanager(){
	 }
	 
	 function conectar() {
	     if(!($con=@mysql_pconnect("localhost","inventa_bd","Valenta@04")))
		 {
		     echo"Error al conectar a la base de datos";	
			 exit();
	      }
		  if (!@mysql_select_db("inventa_pglibreria",$con)) {
		   echo "error al seleccionar la base de datos";  
		   mysql_query ("SET NAMES 'utf8'");
		   exit();
		  }
	       $this->conect=$con;
		   return true;	
	 }

}
?>
