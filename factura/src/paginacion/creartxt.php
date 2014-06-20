<?
include_once("../../manejadordb.php");				function libros(){					$obj= new  manejadordb();		
		$query = "SELECT tbl_distinventario.cod_producto as codigo, tbl_inventario.descripcion as titulo, tbl_inventario.autor as autornom, tbl_coleccion.col_descripcion as coleccion, tbl_editorial.editorial as editorialnom, tbl_inventario.precio as pvp, Sum(tbl_distinventario.cantidad) AS cantidad 
FROM ((tbl_inventario INNER JOIN tbl_distinventario ON tbl_inventario.cod_producto = tbl_distinventario.cod_producto) INNER JOIN tbl_coleccion ON tbl_inventario.coleccion = tbl_coleccion.id_coleccion) INNER JOIN tbl_editorial ON tbl_inventario.editorial = tbl_editorial.id_editorial
WHERE (((tbl_distinventario.sucursal)=125) AND ((tbl_inventario.estatus)=1))
GROUP BY tbl_distinventario.cod_producto, tbl_inventario.descripcion, tbl_inventario.autor, tbl_coleccion.col_descripcion, tbl_editorial.editorial, tbl_inventario.precio HAVING (((Sum(tbl_distinventario.cantidad))>0));";




		$result = $obj->consultar($query);		$j=0;			//$libros="data3 = new Array(";				while ($lib = mysql_fetch_array($result)){		
		
//		$libros.='"{Apellido":"'." "$lib['descripcion'].",".'"Nombre":"'." "$lib['autor'].",".'"Nacimiento":"'." "$lib['cod_producto'].",".'"Ranking":"'." "$lib['precio'].",".'"Ciudad":"'." "$lib['isbn'].'"},"';

//		$libros.='{"Codigo": "'.$lib['codigo'].'",'.'"Titulo": "'.$lib['titulo'].'",'.'"Autor": "'.$lib['autornom'].'",'.'"Coleccion": "'.$lib['coleccion'].'",'.'"Editorial": "'.$lib['editorialnom'].'",'.'"Precio " : "'.$lib['pvp'].'",'.'"Existencia " : "'.$lib['cantidad'].'"},'."\n";

		//$libros[$j]=array("Codigo"=>$lib['codigo'],"Titulo"=>utf8_decode($lib['titulo']),"Autor"=>$lib['autornom'],"Coleccion"=>$lib['coleccion'],"Editorial"=>$lib['editorialnom'],"Precio"=>$lib['pvp'],"Existencia"=>$lib['cantidad']);
		
		$libros.=$lib['codigo']."|".utf8_encode($lib['titulo'])."|".$lib['autornom']."|".$lib['coleccion']."|".$lib['editorialnom']."|".number_format($lib['pvp'],2,",",".")."|".$lib['cantidad']."\n";
		
		
		}

//		$libros.='{"Codigo": "'.$lib['codigo'].'",'.'"Titulo": "'.$lib['titulo'].'",'.'"Autor": "'.$lib['autornom'].'",'.'"Coleccion": "'.$lib['coleccion'].'",'.'"Editorial": "'.$lib['editorialnom'].'",'.'"Precio " : "'.$lib['pvp'].'",'.'"Existencia " : "'.$lib['cantidad'].'"});'."\n";


		// Returns an associative array by alternating array elements

		$fh = fopen("libros.txt", "w");		fwrite($fh, $libros);		fclose($fh);		shell_exec("chmod 777 -R /var/www/html/sigeslib/src/");

		}		

libros();
?>
