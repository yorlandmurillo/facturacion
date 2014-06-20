<?
class dbmanager{
  var $conect;
     function dbmanager(){
	 }
	 
	 function conectar() {
	     if(!($con=@mysql_pconnect("localhost","root","root")))
		 {
		    ?>
		  <BR><BR><BR>
		<b><div align="center"><font size=5 color="red">ERROR AL CONECTARSE A LA BASE DE DATOS LOCAL</font></div></b>

		<?	
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
	 
	 function conectar_remoto() {
	   if(!($con_remote=@mysql_pconnect("localhost","inventa_bd","Valenta@04")))
	//	if(!($con_remote=@mysql_pconnect("10.0.0.20","inventa_bd","Valenta@04")))
		 {
		     ?>
		  <BR><BR><BR>
		<b><div align="center"><font size=5 color="red">ERROR AL CONECTARSE A LA BASE DE DATOS REMOTA<br>VERIFIQUE LA CONEXION</font></div></b>

		<?	
			 exit();
	      }
		  if (!@mysql_select_db("inventa_pglibreria",$con_remote)) {
		   echo "error al seleccionar la base de datos";  
		  mysql_query ("SET NAMES 'utf8'");
		   exit();
		  }
	       $this->conect=$con;
		   return true;	
	 }

}
?>
