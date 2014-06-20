<?php
	include("includes/permiso.php");
	$pagina=$_GET['p'];
	
	if (!isset($_GET['p'])) {
    include("inicio.php");
} else {
  
	
	switch($pagina) {
/////////////////////////////////////////     MODULO     DE     MANTENIMIENTO     ///////////////////////////////////////////////////////////////////////////////////////////	
	case "usuarios":   // Pagina de administracion de usuarios
		 if (verificar_permiso($login_usuario,1)){include("usuarios.php");}else{echo "Permiso Denegado";}
		 break;
	case "libros":   // Pagina de administracion de Libros
		 if (verificar_permiso($login_usuario,100)){include("libros.php");}else{echo "Permiso Denegado";}
		 break;

case "proveedor":   // Pagina de administracion de Proveedores
		 if (verificar_permiso($login_usuario,3)){include("proveedor.php");}else{echo "Permiso Denegado";}
		 break;
	case "cliente":   // Pagina de administracion de Clientes
		 if (verificar_permiso($login_usuario,4)){include("cliente.php");}else{echo "Permiso Denegado";}
		 break;
	case "autor":   // Pagina de administracion de Autores
		 if (verificar_permiso($login_usuario,5)){include("autor.php");}else{echo "Permiso Denegado";}
		 break;
	case "transaccion":   // Pagina de administracion de Trasacciones
		 if (verificar_permiso($login_usuario,6)){include("transaccion.php");}else{echo "Permiso Denegado";}
		 break;
	case "empaque":   // Pagina de administracion de Embalaje
		 if (verificar_permiso($login_usuario,7)){include("empaque.php");}else{echo "Permiso Denegado";}
		 break;
	case "ubicacion":   // Pagina de administracion de Almacen
		 if (verificar_permiso($login_usuario,8)){include("ubicacion.php");}else{echo "Permiso Denegado";}
		 break;
	case "vendedor":   // Pagina de administracion de Vendedores
		 if (verificar_permiso($login_usuario,9)){include("vendedor.php");}else{echo "Permiso Denegado";}
		 break;
/////////////////////////////////////////     MODULO     OPERATIVO     ///////////////////////////////////////////////////////////////////////////////////////////	
	case "inventario":
		 if (verificar_permiso($login_usuario,10)){include("inventarioEditorial.php");}else{echo "Permiso Denegado";}
		 break;
	case "compra":
		 if (verificar_permiso($login_usuario,11)){include("ordenCompra.php");}else{echo "Permiso Denegado";}
		 break;
	case "recepcion":
		 if (verificar_permiso($login_usuario,12)){include("informeRecepcion.php");}else{echo "Permiso Denegado";}
		 break;
	case "Pedido":
		 if (verificar_permiso($login_usuario,13)){include("Pedido.php");}else{echo "Permiso Denegado";}
		 break;
	case "entrega":
		 if (verificar_permiso($login_usuario,14)){include("notaEntrega.php");}else{echo "Permiso Denegado";}
		 break;
	case "nota_entrega":
		 if (verificar_permiso($login_usuario,14)){include("nota_entrega.php");}else{echo "Permiso Denegado";}
		 break;
	case "factura":
		 if (verificar_permiso($login_usuario,14)){include("factura.php");}else{echo "Permiso Denegado";}
		 break;
	case "facturaPrivada":
		 if (verificar_permiso($login_usuario,15)){include("facturaPrivada.php");}else{echo "Permiso Denegado";}
		 break;
	case "facturaPrivadaPDF":
		 if (verificar_permiso($login_usuario,15)){include("facturaPrivadaPDF.php");}else{echo "Permiso Denegado";}
		 break;
		 
    case "PedidoModifica":
		 if (verificar_permiso($login_usuario,51)){include("PedidoModifica.php");}else{echo "Permiso Denegado";}
		 break;
		 
	  case "devolucion":
		 if (verificar_permiso($login_usuario,51)){include("devolucion.php");}else{echo "Permiso Denegado";}
		 break;
		 
		   case "notadecredito":
		 if (verificar_permiso($login_usuario,51)){include("notadecredito.php");}else{echo "Permiso Denegado";}
		 break;


	case "reporteCorteLSresumida":
		 if (verificar_permiso($login_usuario,0)){include("reporteCorteLSresumida.php");}else{echo "Permiso Denegado";}
		 break;
		 
		 
		 	case "librosConsulta":
		 if (verificar_permiso($login_usuario,0)){include("librosConsulta.php");}else{echo "Permiso Denegado";}
		 break;
		 
		 case "estadisticaslb":
		 if (verificar_permiso($login_usuario,0)){include("estadisticaslb.php");}else{echo "Permiso Denegado";}
		 break;
		 
		  case "estadisticaslb2":
		 if (verificar_permiso($login_usuario,0)){include("estadisticaslb2.php");}else{echo "Permiso Denegado";}
		 break;
		 
		 case "estadisticaslb_detalle":
		 if (verificar_permiso($login_usuario,0)){include("estadisticaslb_detalle.php");}else{echo "Permiso Denegado";}
		 break;
		 
		  case "estadisticaslb_detalle2":
		 if (verificar_permiso($login_usuario,0)){include("estadisticaslb_detalle2.php");}else{echo "Permiso Denegado";}
		 break;
		 
		 
		  case "estadisticaslbferias":
		 if (verificar_permiso($login_usuario,0)){include("estadisticaslbferias.php");}else{echo "Permiso Denegado";}
		 break;

		  case "estadisticaslbferias2":
		 if (verificar_permiso($login_usuario,0)){include("estadisticaslbferias2.php");}else{echo "Permiso Denegado";}
		 break;
		 
		 
		  case "estadisticaslbferiasInternacionales":
		 if (verificar_permiso($login_usuario,0)){include("estadisticaslbferiasInternacionales.php");}else{echo "Permiso Denegado";}
		 break;

		  case "estadisticaslbferiasInternacionales2":
		 if (verificar_permiso($login_usuario,0)){include("estadisticaslbferiasInternacionales2.php");}else{echo "Permiso Denegado";}
		 break;

		 
		 case "reportelibro":
		 if (verificar_permiso($login_usuario,0)){include("reportelibro.php");}else{echo "Permiso Denegado";}
		 break;
		 
		  case "reportelibrocolocados":
		 if (verificar_permiso($login_usuario,0)){include("reportelibrocolocados.php");}else{echo "Permiso Denegado";}
		 break;
		 
		 

	case "reporteesumida":
		 if (verificar_permiso($login_usuario,0)){include("reporteesumida.php");}else{echo "Permiso Denegado";}
		 break;
		 
		 
	case "reporteCorte":
		 if (verificar_permiso($login_usuario,0)){include("reporteCorte.php");}else{echo "Permiso Denegado";}
		 break;


	case "Pedidoespecial":
		 if (verificar_permiso($login_usuario,103)){include("Pedidoespecial.php");}else{echo "Permiso Denegado";}
		 break;
		 
		 

    case "reimpresion":
		 if (verificar_permiso($login_usuario,16)){include("reimpresion.php");}else{echo "Permiso Denegado";}
		 break;
	/////////////////////////////////////// informatica 	 
		 
	case "sistema":
		 if (verificar_permiso($login_usuario,102)){include("sistema.php");}else{echo "Permiso Denegado";}
		 break;
		 
   case "eliminarfactura":
		 if (verificar_permiso($login_usuario,102)){include("eliminarfactura.php");}else{echo "Permiso Denegado";}
		 break;
		 
  case "reimpresionFact":
		 if (verificar_permiso($login_usuario,102)){include("reimpresionFact.php");}else{echo "Permiso Denegado";}
		 break;

  case "cambiarporcentaje":
		 if (verificar_permiso($login_usuario,102)){include("cambiarporcentaje.php");}else{echo "Permiso Denegado";}
		 break;
		 

  case "cambiarexistecialibro":
		 if (verificar_permiso($login_usuario,102)){include("cambiarexistecialibro.php");}else{echo "Permiso Denegado";}
		 break;

  case "crearcoleccion":
		 if (verificar_permiso($login_usuario,102)){include("crearcoleccion.php");}else{echo "Permiso Denegado";}
		 break;
 
 
 case "RecepcionLS":
		 if (verificar_permiso($login_usuario,102)){include("RecepcionLS.php");}else{echo "Permiso Denegado";}
		 break;
		 



///////////////////////////////////////////////informatica


//////////////// menu ////////////
		 case "mantenimiento":   // Pagina de administracion de usuarios
		 if (verificar_permiso($login_usuario,0)){include("mantenimiento.php");}else{echo "Permiso Denegado";}
		 break;
		 case "operativo":   // Pagina de administracion de usuarios
		 if (verificar_permiso($login_usuario,0)){include("operativo.php");}else{echo "Permiso Denegado";}
		 break;
		  case "consulta":   // Pagina de administracion de usuarios
		 if (verificar_permiso($login_usuario,0)){include("consulta.php");}else{echo "Permiso Denegado";}
		 break;
		  case "reporte":   // Pagina de administracion de usuarios
		 if (verificar_permiso($login_usuario,0)){include("reporte.php");}else{echo "Permiso Denegado";}
		 break;
		 
		  case "lentregado":   // Pagina de administracion de usuarios
		 if (verificar_permiso($login_usuario,1)){include("lentregado.php");}else{echo "Permiso Denegado";}
		 break;

case "existencia":   // Pagina de administracion de usuarios
		 if (verificar_permiso($login_usuario,1)){include("existencia.php");}else{echo "Permiso Denegado";}
		 break;

case "precio":   // Pagina de administracion de usuarios
		 if (verificar_permiso($login_usuario,1)){include("precio.php");}else{echo "Permiso Denegado";}
		 break;
		 
		 case "mentrada":   // Pagina de administracion de usuarios
		 if (verificar_permiso($login_usuario,1)){include("mentrada.php");}else{echo "Permiso Denegado";}
		 break;
		 
		  case "msalida":   // Pagina de administracion de usuarios
		 if (verificar_permiso($login_usuario,1)){include("msalida.php");}else{echo "Permiso Denegado";}
		 break;

		
		////////////////////////
		 
/////////////////////////////////////////     MODULO     DE     REPORTES     ///////////////////////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////// LIBROS ENTREGADOS
	case "libentpclifch":
		 if (verificar_permiso($login_usuario,17)){include("libentpclifch.php");}else{echo "Permiso Denegado";}
		 break;
	case "libentpclirfch":
		 if (verificar_permiso($login_usuario,18)){include("libentpclirfch.php");}else{echo "Permiso Denegado";}
		 break;
	case "libentpprovfch":
		 if (verificar_permiso($login_usuario,19)){include("libentpprovfch.php");}else{echo "Permiso Denegado";}
		 break;
	case "libentpprovrfch":
		 if (verificar_permiso($login_usuario,20)){include("libentpprovrfch.php");}else{echo "Permiso Denegado";}
		 break;
	/////////////////////////////////// EXISTENCIA
	case "rexistxcod":
		 if (verificar_permiso($login_usuario,21)){include("rexistxcod.php");}else{echo "Permiso Denegado";}
		 break;
	case "rexistxedit":
		 if (verificar_permiso($login_usuario,22)){include("rexistxedit.php");}else{echo "Permiso Denegado";}
		 break;
	case "rexistxplat":
		 if (verificar_permiso($login_usuario,23)){include("rexistxplat.php");}else{echo "Permiso Denegado";}
		 break;
	case "rexistxplatmr":
		 if (verificar_permiso($login_usuario,24)){include("rexistxplatmr.php");}else{echo "Permiso Denegado";}
		 break;
	case "rexistxrcod":
		 if (verificar_permiso($login_usuario,25)){include("rexistxrcod.php");}else{echo "Permiso Denegado";}
		 break;
	/////////////////////////////////// PRECIO
	case "rprecxcod":
		 if (verificar_permiso($login_usuario,26)){include("rprecxcod.php");}else{echo "Permiso Denegado";}
		 break;
	case "rprecxedit":
		 if (verificar_permiso($login_usuario,27)){include("rprecxedit.php");}else{echo "Permiso Denegado";}
		 break;
	case "rprecxplat":
		 if (verificar_permiso($login_usuario,28)){include("rprecxplat.php");}else{echo "Permiso Denegado";}
		 break;
	case "rprecxplatmr":
		 if (verificar_permiso($login_usuario,29)){include("rprecxplatmr.php");}else{echo "Permiso Denegado";}
		 break;
	case "rprecxrcod":
		 if (verificar_permiso($login_usuario,30)){include("rprecxrcod.php");}else{echo "Permiso Denegado";}
		 break;
	/////////////////////////////////// MOVIMIENTO DE ENTRADA
	case "moveinvpcod":
		 if (verificar_permiso($login_usuario,31)){include("moveinvpcod.php");}else{echo "Permiso Denegado";}
		 break;
	case "moveinvpfch":
		 if (verificar_permiso($login_usuario,32)){include("moveinvpfch.php");}else{echo "Permiso Denegado";}
		 break;
	case "moveinvprcod":
		 if (verificar_permiso($login_usuario,33)){include("moveinvprcod.php");}else{echo "Permiso Denegado";}
		 break;
	case "moveinvprfch":
		 if (verificar_permiso($login_usuario,34)){include("moveinvprfch.php");}else{echo "Permiso Denegado";}
		 break;
	/////////////////////////////////// MOVIMIENTO DE SALIDA
	case "movsinvpcod":
		 if (verificar_permiso($login_usuario,35)){include("movsinvpcod.php");}else{echo "Permiso Denegado";}
		 break;
	case "movsinvpfch":
		 if (verificar_permiso($login_usuario,36)){include("movsinvpfch.php");}else{echo "Permiso Denegado";}
		 break;
	case "movsinvprcod":
		 if (verificar_permiso($login_usuario,37)){include("movsinvprcod.php");}else{echo "Permiso Denegado";}
		 break;
	case "movsinvprfch":
		 if (verificar_permiso($login_usuario,38)){include("movsinvprfch.php");}else{echo "Permiso Denegado";}
		 break;
	/////////////////////////////////// LISTADO GENERAL
	case "listadolibros":
		 if (verificar_permiso($login_usuario,39)){include("listadolibros.php");}else{echo "Permiso Denegado";}
		 break;
	default:
   } 
   
   
   
   }

?>