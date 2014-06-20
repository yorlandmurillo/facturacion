<?php
	include("includes/permiso.php");
	$pagina=$_GET['p'];
	
	if (!isset($_GET['p'])) {
    include("inicio.php");
} else {
  
	
	switch($pagina) {
	case "Pedido":
		 if (verificar_permiso($login_usuario,13)){include("Pedido.php");}else{echo "Permiso Denegado";}
		 break;

 	case "librosConsulta":
		 if (verificar_permiso($login_usuario,0)){include("librosConsulta.php");}else{echo "Permiso Denegado";}
		 break;
		 
		 	 case "reimpresion_ver_pe_ne":
		 if (verificar_permiso($login_usuario,0)){include("reimpresion_ver_pe_ne.php");}else{echo "Permiso Denegado";}
		 break;
		 
		  	case "libros":
		 if (verificar_permiso($login_usuario,0)){include("libros.php");}else{echo "Permiso Denegado";}
		 break;
		 
		 
    case "reimpresion":
		 if (verificar_permiso($login_usuario,16)){include("reimpresion.php");}else{echo "Permiso Denegado";}
		 break;
		 
		   case "devolucion":
		 if (verificar_permiso($login_usuario,0)){include("devolucion.php");}else{echo "Permiso Denegado";}
		 break;

 case "RecepcionLS":
		 if (verificar_permiso($login_usuario,0)){include("RecepcionLS.php");}else{echo "Permiso Denegado";}
		 break;
 case "estadisticaslb":
		 if (verificar_permiso($login_usuario,0)){include("estadisticaslb.php");}else{echo "Permiso Denegado";}
		 break;
		 
		  case "estadisticaslb2":
		 if (verificar_permiso($login_usuario,0)){include("estadisticaslb2.php");}else{echo "Permiso Denegado";}
		 break;
		 		 
 case "actualizar":
		 if (verificar_permiso($login_usuario,0)){include("actualizar.php");}else{echo "Permiso Denegado";}
		 break;
 case "actualizar2":
		 if (verificar_permiso($login_usuario,0)){include("actualizar2.php");}else{echo "Permiso Denegado";}
		 break;

 case "traslado":
		 if (verificar_permiso($login_usuario,0)){include("traslado.php");}else{echo "Permiso Denegado";}
		 break;
		 
	case "operativo":   // Pagina de administracion de usuarios
		 if (verificar_permiso($login_usuario,0)){include("operativo.php");}else{echo "Permiso Denegado";}
		 break;


case "cambiacbarra":   // Pagina de administracion de usuarios
		 if (verificar_permiso($login_usuario,0)){include("cambiacbarra.php");}else{echo "Permiso Denegado";}
		 break;


	default:
   } 
   
   
   
   }

?>
