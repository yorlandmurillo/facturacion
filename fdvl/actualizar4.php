<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />


<div id="navegador">
	<p>
		<SPAN class='noimprimir'>
		<a href="#">Sistema de Inventario</a> | 
		<a href="#"></a></SPAN>Módulo Operativo
  </p>
</div>

<style type="text/css">
A:link {
	text-decoration: none;
	color:#900;
}
A:visited {text-decoration: none}
A:active {text-decoration: none}
A:hover {text-decoration: underline;
color:#999;

}
</style>


<link href="alberto.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="">

</script>
</head>
<script>
function scr(){
	vrequerimiento=window.open("","vrequerimiento","top=0,left=0,width=1008,height=708,channelmode=0,dependent=0,directories=0,fullscreen=0,location=0,menubar=0,resizable=1,scrollbars=1,status=0,toolbar=0");
	vrequerimiento.location="";
}
</script>

<script>
function planilla(){
	vpan=window.open("","vpan","top=0,left=0,width=1008,height=708,channelmode=0,dependent=0,directories=0,fullscreen=0,location=0,menubar=0,resizable=1,scrollbars=1,status=0,toolbar=0");
	vpan.location="";
}
</script>


<body leftmargin="0" topmargin="0" rightmargin="0" marginwidth="0" marginheight="0">
<table border="1" width="100%" id="table1" style="border-width: 0px" height="198">
	<tr>
		<td height="15" colspan="2" align="left" valign="top" bgcolor="#999999" style="border-style: none; border-width: medium">
		<p style="margin-top: 0; margin-bottom: 0"><b>
	  <font face="Verdana" style="font-size: 8pt" color="#FFFFFF">Actualización de Datos </font></b></td>
	</tr>
	<tr>
    
    
  
            
            
		<td height="15" align="left" valign="top" bgcolor="#FFFFFF" style="border-style: none; border-width: medium"><p class="CIREDLink">Proceso Ejecutado con Éxito se han actualizado toda la información más reciente de (Libros, Editoriales, Autores).</p>
	  <p class="CIREDLink">&nbsp;</p>
	  	</tr>
	
	
	
	<tr>
		<td style="border-style: none; border-width: medium" align="left" valign="top">
		<img src="" width="183" height="1" alt=""></td>
		<td style="border-style: none; border-width: medium" align="left" valign="top">&nbsp;</td>
	</tr>
</table>
</body>
</html>
<hr>
<?php 


$link = mysql_connect("localhost","inventa_bd","Valenta@04") or die (mysql_error());  
 mysql_select_db("inventa_pglibreria",$link);
       mysql_query("DELETE FROM tbl_inventario");
	   					

if (!($link2= @mysql_connect("distribuidoradellibro.gob.ve","inventa_bd","Valenta@04")))
{
echo "<script>alert('Por favor verifique la Conexion de Internet');location.href='index.php';</script>";
// Inicializa de la sesion
session_start();
// Destruye todas las variables de la sesion
session_unset();
// Finalmente, destruye la sesion
session_destroy();
exit();
}
if (! @mysql_select_db("inventa_fdvl",$link2))
{
echo "Error seleccionando la base de datos.";
exit();
}
//$link=Conectarse();
//echo "Conexión con la base de datos conseguida.<br>";
//@mysql_close($link); //cierra la conexion

	


				$result=mysql_query("select lib_codsib, lib_codbarra,prv_codpro,lib_codart,lib_descri,lib_preact,aut_codigo,col_colecc,lib_iva,lib_articulo from inv_libros",$link2);
				
					while($row = mysql_fetch_array($result)) {
					

		  $sql_mov3 = "INSERT INTO tbl_inventario (isbn, cod_barra,editorial, cod_producto,descripcion, precio,aut_codigo,coleccion,iva,lib_articulo)
    VALUES  ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]','$row[9]')";
mysql_query($sql_mov3, $link) or die(mysql_error($link));

					}





$modificaiva = @mysql_query("
UPDATE tbl_inventario
SET precio= '26.7857142857142976000000000000000'
where editorial = '0350' 
",$link); 








mysql_close($link2);

					mysql_free_result($result);
					mysql_close($link);
	

?>

<?php 


$linkE = mysql_connect("localhost","inventa_bd","Valenta@04") or die (mysql_error());  
 mysql_select_db("inventa_pglibreria",$linkE);
       mysql_query("DELETE FROM tbl_editorial");
	   					

if (!($link2E= @mysql_connect("distribuidoradellibro.gob.ve","inventa_bd","Valenta@04")))
{
echo "<script>alert('Por favor verifique la Conexion de Internet');location.href='index.php';</script>";
// Inicializa de la sesion
session_start();
// Destruye todas las variables de la sesion
session_unset();
// Finalmente, destruye la sesion
session_destroy();
exit();
}
if (! @mysql_select_db("inventa_fdvl",$link2E))
{
echo "Error seleccionando la base de datos.";
exit();
}
//$link=Conectarse();
//echo "Conexión con la base de datos conseguida.<br>";
//@mysql_close($link); //cierra la conexion

	


				$resultE=mysql_query("select prv_codpro, prv_nombre,prv_direc, prv_ptoref, prv_telef, prv_fax, prv_rif, prv_nit, prv_web, prv_contac, prv_mail, prv_tipop from inv_provee",$link2E);
				
					while($row = mysql_fetch_array($resultE)) {
					

		  $sql_mov3E = "INSERT INTO tbl_editorial (id_editorial, editorial, direccion, prv_ptoref, telf_oficina1, telf_fax, prv_rif, prv_nit, pag_web, prv_contac, correo, prv_tipop)
    VALUES  ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','" . utf8_encode($row[8]) . "','" . utf8_encode($row[9]) . "','$row[10]','$row[11]')";
mysql_query($sql_mov3E, $linkE) or die(mysql_error($linkE));

					}



mysql_close($link2E);

					mysql_free_result($resultE);
					mysql_close($linkE);
	

?>


<?php 


$linkA = mysql_connect("localhost","inventa_bd","Valenta@04") or die (mysql_error());  
 mysql_select_db("inventa_pglibreria",$linkA);
       mysql_query("DELETE FROM tbl_autor");
	   					

if (!($link2A= @mysql_connect("distribuidoradellibro.gob.ve","inventa_bd","Valenta@04")))
{
echo "<script>alert('Por favor verifique la Conexion de Internet');location.href='index.php';</script>";
// Inicializa de la sesion
session_start();
// Destruye todas las variables de la sesion
session_unset();
// Finalmente, destruye la sesion
session_destroy();
exit();
}
if (! @mysql_select_db("inventa_fdvl",$link2A))
{
echo "Error seleccionando la base de datos.";
exit();
}
//$link=Conectarse();
//echo "Conexión con la base de datos conseguida.<br>";
//@mysql_close($link); //cierra la conexion

	


				$resultA=mysql_query("select aut_codigo,aut_nombre,aut_pais from inv_autor",$link2A);
				
					while($row = mysql_fetch_array($resultA)) {
					

		  $sql_mov3A = "INSERT INTO tbl_autor(id_autor,aut_nombre,aut_pais)
    VALUES  ('$row[0]','$row[1]','$row[2]')";
mysql_query($sql_mov3A, $linkA) or die(mysql_error($linkA));

					}



mysql_close($link2A);

					mysql_free_result($resultA);
					mysql_close($linkA);
	

?>



