<?phpinclude_once("../../manejadordb.php");			function arreglo_libros(){										$libros = file('libros.txt');				for ($i = 0; $i < count($libros); $i++) {				$tmp = explode('|', $libros[$i]);				
				$libros[$i]=array("Codigo"=>$tmp[0],"Titulo"=>utf8_encode($tmp[1]),"Autor"=>$tmp[2],"Coleccion"=>$tmp[3],"Editorial"=>$tmp[4],"Precio"=>$tmp[5],"Cantidad"=>$tmp[6]);

							}					return $libros;				}?>
199.7.52.72:8064.4.56.23:80