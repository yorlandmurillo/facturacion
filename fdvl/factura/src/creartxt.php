<?
include_once("../manejadordb.php");$usuarios_sesion="libros";												function arreglo_libros(){					$local["arreglo"] =array();			$obj= new  manejadordb();				$query = "SELECT * FROM tbl_inventario;";		$result = $obj->consultar($query);		$j=0;			$libros="";				while ($lib = mysql_fetch_array($result)){		
		
//		$local["arreglo"][$j]=array("titulo"=>$lib['descripcion'],"autor"=>$lib['autor'],"editorial"=>"Edebé","isbn"=>$lib['isbn'],"precio"=>$lib['precio']);//		$libros.=$lib['cod_producto']."|".$lib['autor']."|".$lib['descripcion']."|".$lib['isbn']."|".$lib['precio']."\n";		$libros.=$lib['cod_producto']."\n";
				$j++;		}
		$fh = fopen("libros.txt", "w");		fwrite($fh, $libros);		fclose($fh);		shell_exec("chmod 777 -R /var/www/html/sigeslib/src/");
		}		

arreglo_libros();
?>
