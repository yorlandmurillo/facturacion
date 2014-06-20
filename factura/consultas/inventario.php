<? 
require("../admin/session.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?
//echo "-*->".$_SESSION['iva']."-*-".$_SESSION['usuario_sucursal'];
?>
<title>tbl_inventario</title>
<style type="text/css">
<!--
body {
        font-size: 11px;
        font-family: Tahoma, Arial, sans-serif;
}
.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 1px; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}

a {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 12px;
		color: #990000;
        text-decoration: none;

}
a:hover {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 12px;
        color: #990000;
        text-decoration: none;
}
h1 {
        font-family: Tahoma, Arial, sans-serif;
        font-size: 16px;
        font-weight: bold;
}
table{
        padding: 5;
}
th {
        font-size : 11px;
        font-family : Tahoma, Arial, sans-serif;
        color : #FFFFFF;
        text-align : center;
        font-weight : bold;
        background-color : #990000;
}
tr {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 11px;
        background-color : #FFFFFF;
}
td {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 11px;
}
TABLE.Mtable TD {
        BORDER-RIGHT: #93bee2 1px solid;
        BORDER-BOTTOM: #c1cdd8 1px solid;
}
TABLE.Mtable TH {
        BORDER-RIGHT: #93bee2 1px solid;
}
TABLE.Mtable {
        border: 1px solid #336699;
}

.TRalter {
        background-color : #F0F0F0; 
}


TABLE.buscarTable {
        border: 1px solid #336699;
}
input {
        font-size: 11px;
        font-family: Tahoma, Arial, sans-serif;
}


-->
</style>
<script language="javascript">
var agregar
function abrirventana(ventana,nombre,alto,ancho,valor){
   agregar=window.open(ventana+"?codigol="+valor,nombre,'width='+ancho+',height='+alto+',top='+((screen.height/2)-(180.5))+',left='+((screen.width/2)-(310.5))+',toolbar=no,scrollbars=yes,resizable=no,menubar=no,status=no,directories=no,location=no')
  
}

</script>

</head>
<body>
<h1>Inventario</h1>


<!-- buscar engine -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" name="mform" id="mform">
  <table width="200" border="0" cellpadding="0" cellspacing="0" class="buscarTable">
    <tr>
      <td nowrap> <b>Buscar:</b> 
        <input type="text" name="buscar" value="<?php if(!empty($_GET['buscar']))echo $_GET['buscar']; ?>"> 
   <input type="submit" value="ok">
   <input type="submit" value="Ver Todos" onClick="document.mform.buscar.value='';">
      </td>
 </tr>
</table>
</form>
<!-- buscar engine -->


<?php

//include_once("../manejadordb.php");
$obj=new manejadordb;

$query = "SELECT tbl_distinventario.cod_producto, tbl_distinventario.descripcion, tbl_distinventario.autor, tbl_distinventario.isbn, 
			tbl_distinventario.cod_barra,tbl_distinventario.cantidad
			FROM tbl_distinventario";

if(isset($_GET['buscar']) && !empty($_GET['buscar']))
{

	$query.=" where ( (tbl_distinventario.cod_producto = '".addslashes($_GET['buscar'])."') OR (tbl_distinventario.descripcion LIKE '%".addslashes($_GET['buscar'])."%') 
			OR (tbl_distinventario.autor LIKE '%".addslashes($_GET['buscar'])."%') OR (tbl_distinventario.cod_barra = '".addslashes($_GET['buscar'])."'))";
}

 // ************* buscar *****************/

//die($query);
 //$result = $obj->consultar($query);
  $result = $obj->consultar_remoto($query);
 $numrows = mysql_num_rows($result); // result of count query


// ************** pager **************************
 $limit = 15; // Default results per-page.
 if(empty($_GET['page']))$_GET['page'] = 0; // Default page value

 $pages = intval($numrows/$limit); // Number of results pages.

 if($numrows%$limit) $pages++; // has remainder so add one page
 $current = ($_GET['page']/$limit) + 1; // Current page number.

 if(($pages < 1) || ($pages == 0)) 
      $total = 1; // If $pages is less than one or equal to 0, total pages is 1.
 else 
     $total = $pages; // Else total pages is $pages value.

 $first = $_GET['page'] + 1; // The first result.

 if(((($_GET['page'] + $limit) / $limit) >= $pages) && $pages != 1) 
         $last = $_GET['page'] + $limit; //If not last results page, last result equals $page plus limit. 
else
    $last = $numrows; // If last results page, last result equals total number of results.
// ************** end of pager **************************

$num=mysql_num_rows($result);
 $totallibros=0;
while ($lib = mysql_fetch_assoc($result)) 
{         
	$totallibros+=$lib["cantidad"];
}
if($numrows == 0)
{
     echo "<b>No Existe el Producto</b>
         <br>
         <br>
         <a href=\"javascript:history.back();\">[Regresar]</a>\n";
}
else
{
	$query = "SELECT tbl_distinventario.cod_producto, tbl_distinventario.descripcion, tbl_distinventario.autor, tbl_distinventario.isbn, 
			tbl_distinventario.cod_barra,tbl_distinventario.cantidad
			FROM tbl_distinventario";

	if(isset($_GET['buscar']) && !empty($_GET['buscar']))
	{
		$query.=" where ( (tbl_distinventario.cod_producto = '".addslashes($_GET['buscar'])."') OR (tbl_distinventario.descripcion LIKE '%".addslashes($_GET['buscar'])."%') 
				OR (tbl_distinventario.autor LIKE '%".addslashes($_GET['buscar'])."%') OR (tbl_distinventario.cod_barra = '".addslashes($_GET['buscar'])."'))";
	}
//die($query);
 // ************* buscar *****************/

 // ************* end of buscar *****************/  
     $query .= " LIMIT ".$_GET['page'].", $limit"; // add query LIMIT
     $result = mysql_query($query) or die(mysql_error());
     $numrows = mysql_num_rows($result);

     
     //echo our table
     echo "<table class=\"Mtable\" border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";     
	 echo "<th>".ucfirst("C&oacute;digo")."</th>\n";
	 echo "<th>".ucfirst("Descripci&oacute;n")."</th>\n";
	 echo "<th>".ucfirst("Autor")."</th>\n";
	 echo "<th>".ucfirst("Editorial")."</th>\n";
	 echo "<th>".ucfirst("Precio")."</th>\n";
	 echo "<th>".ucfirst("IVA")."</th>\n";
	echo "<th>".ucfirst("Precio Final")."</th>\n";
	echo "<th>".ucfirst("ISBN")."</th>\n";
	echo "<th>".ucfirst("Cantidad")."</th>\n";
	//if($_SESSION['usuario_nivel']==2)
	//{	
		echo "<th>".ucfirst("Opci&oacute;n")."</th>\n";
	//}
	 
	 $i = 0;
	 $totallibros=0;
	 while ($row = mysql_fetch_assoc($result)) 
	{         
	   // alternate color
		$precio=$obj->setprecio_remoto($row["cod_producto"]);
		$getiva=$obj->setiva_remoto($row["cod_producto"]);
		
		if($getiva==1)
			$iva=0;
		elseif($getiva==2)
			$iva=$precio*0.12;
		$preciofinal=$precio+$iva;

		if($i%2 == 0)  
			   echo "<tr class=\"TRalter\">\n";
		else
		echo "<tr>\n";
		 $codigol= $row["cod_producto"]; 
		 echo "<td>".$codigol."</td>\n";
		 echo "<td>".strtoupper($row["descripcion"])."</td>\n";
		 echo "<td>".strtoupper($row["autor"])."</td>\n";
		 echo "<td>".$obj->seteditorial_remoto($row["cod_producto"])."</td>\n";
		 echo "<td align='right'>".number_format($precio,2,",",".")."</td>\n";
		if($getiva==1)
			echo "<td align='right'>".number_format($iva,2,",",".")."</td>\n";
		elseif($getiva==2)
			echo "<td align='right'><b><font color=blue>".number_format($iva,2,",",".")."</font></b></td>\n";
		 echo "<td align='right'><b><font size=2>".number_format($preciofinal,2,",",".")."</font></b></td>\n";
		 echo "<td align='center'>".$row["cod_barra"]."</td>\n";
		 if($row["cantidad"]==0)
		{
			 echo "<td align='center'><b><font color=red>AGOTADO</font></b></td>\n";
		}
		else
		{
			 echo "<td align='center'>".$row["cantidad"]."</td>\n";
		}
		  
	//	if($_SESSION['usuario_nivel']==2){		
		echo "<td align='center'><input name='editar' class='boton' type='button' value='Editar' onClick='abrirventana(\"../comercializacion/modtitulos.php\",\"titulosm\",500,700,\"$codigol\")' class='boton'></td>\n";
	//	}
		 echo "</tr>\n";
	   $totallibros=$totallibros+$row["cantidad"];

		$i++;    

	}	   
	 echo "</table>\n";

	 mysql_free_result($result);
}


// ************** bottom pager  **************************
 echo "<table width=\"100%\" border=\"0\">
				<tr>
				<td align=\"center\">\n";

 if (!empty($_GET['page']) && $_GET['page'] > 0)
 {
   $back_page = $_GET['page'] - $limit;
   $url = $_SERVER["PHP_SELF"]."?page=$back_page";

   if(!empty($_GET['buscar']))$url .= "&buscar=".$_GET['buscar']; // add buscar  
   
   
   echo "<a href=\"$url\">[<<]</a>    \n";
 }



 if($pages > 1)
 {
	 for ($i=1; $i <= $pages; $i++) 
	 {
	   $ppage = $limit*($i - 1);
	   if ($ppage == $_GET['page'])
			  echo("<b>$i</b> \n");
	   else
	   {
		  $url = $_SERVER["PHP_SELF"]."?page=$ppage";
		  
		  if(!empty($_GET['buscar']))$url .= "&buscar=".$_GET['buscar']; // add buscar 
	   }
	 }
 }

 if(((($_GET['page']+$limit) / $limit) < $pages) && $pages != 1) 
 {   
   $next_page = $_GET['page'] + $limit;// If last page don't give next link.
   $url = $_SERVER["PHP_SELF"]."?page=$next_page";
	
   if(!empty($_GET['buscar']))$url .= "&buscar=".$_GET['buscar'];// add buscar   
   
   echo "    <a href=\"$url\">[>>]</a>\n";
 }
echo "Cantidad Titulos: ".$num."  "."Cantidad Libros:".$totallibros;
echo "</td></tr></table>"; 
// ************** end of bottom pager **************************
?>
<a href='' onClick="javascript:window.close(this)" style="border:groove;background-color:#CCCCCC;" ><img src='../imagenes/salir.png' border="0"> Salir</a>
</body>
</html>
