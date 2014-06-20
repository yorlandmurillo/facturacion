<?php
include 'conec.php';
$select="SELECT `cod_producto` , `descripcion` ,tbl_autor.aut_nombre, tbl_editorial.editorial, precio, `cod_barra`,iva
	FROM `tbl_inventario` , tbl_editorial,tbl_autor
	WHERE tbl_editorial.id_editorial = tbl_inventario.editorial
	and tbl_autor.id_autor = tbl_inventario.aut_codigo
	AND character_length(cod_producto) =10
	AND precio >0
	ORDER BY descripcion";
//die($select);
	$result=mysql_query($select); 
	?>
	<html>
	<head>
	</head>
	<body>
	<div align=center><font size=4 color=blue><b>CATOLOGO DE TITULOS DE LA DISTRIBUIDORA NACIONAL</b></font></div>
	 <table border=1>
	 <tr><td></td><td><b>CODIGO</b></td><td><b>TITULO</b></td><td><b>AUTOR</b></td><td><b>EDITORIAL</b></td><td><b>PRECIO</b></td><td><b>CODIGO DE BARRA</b></td></tr>
	 <?
	 $num=1;
	  while($row = mysql_fetch_row($result))
	   {
			$iva=$row[5];
			if($iva==2)
				$precio=number_format($row[4],2,",",".")."<font color=red>+IVA</font>";
			else
				$precio=number_format($row[4],2,",",".");
			
			
		   ?>
		   <tr border=1><td><? echo $num; ?></td><td><? echo $row[0]; ?></td><td><? echo $row[1]; ?></td><td><? echo $row[2]; ?></td><td><? echo $row[3]; ?></td><td><b><? echo $precio; ?></b></td><td><? echo $row[5]; ?></td></tr>
		   <?php
		   $num++;
	   }    
	 ?>
	 
	 <table>
	</body>
	</html>
	<?

