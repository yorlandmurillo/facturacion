<? 
require("../admin/session.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title>Consulta de Inventario</title>
<style type="text/css">
<!--
td1:hover{
	background:#CCCCCC;
	color:#990000;
	cursor:pointer;
}
.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}

a {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 12px;
		color: #990000;
        text-decoration: none;

}
a:hover {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 12px;
        color: #FFFFFF;
        text-decoration: none;
}
h1 {
        font-family: Tahoma, Arial, sans-serif;
        font-size: 16px;
        font-weight: bold;
}
table{
        padding: 5;
	 border: 1px solid;
	  
}
th {
        font-size : 11px;
        font-family : Tahoma, Arial, sans-serif;
        color : #FFFFFF;
        text-align : center;
        font-weight : bold;
        background-color : #990000;
}
tr:hover {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 11px;
		color:#FFFFFF;
        background-color :#990000; 

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
		cursor:pointer;
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
<!--
function enviarcodigo(codigo){
//alert(codigo+"-*-"+window.opener.document);
    window.opener.document.ventas.codproducto.value=codigo;
	window.opener.agregaritem();
	return cerrarventana();
}

function maximizar(){
window.resizeTo(screen.width -100,screen.height-200);
document.mform.buscar.focus();
}

function cerrarventana(){
	this.close();
}
-->
</script>

</head>
<body onLoad="maximizar()">
<h1>Inventario</h1>


<!-- buscar engine -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" name="mform" id="mform">
  <table width="313" border="0" cellpadding="0" cellspacing="0" class="buscarTable">
    <tr>
      <td nowrap> <b>Buscar:</b> 
        <input type="text" name="buscar" value="<?php if(!empty($_GET['buscar']))echo $_GET['buscar']; ?>"> 
   <input type="submit" class="boton" value="Buscar">
   <input type="submit" class="boton" onClick="document.mform.buscar.value='';" value="Todos">
   <input name="submit" type="submit" class="boton" onClick="cerrarventana()" value="Salir">      </td>
 </tr>
</table>
</form>
<!-- buscar engine -->


<?php

//include_once("../manejadordb.php");
$obj=new manejadordb;


$query = "SELECT *
FROM tbl_distinventario
WHERE (((tbl_distinventario.sucursal)=".$_SESSION['usuario_sucursal'].")) 
GROUP BY tbl_distinventario.cod_producto, tbl_distinventario.sucursal ";

if(isset($_GET['buscar']) && !empty($_GET['buscar'])){

$query.=" HAVING (((tbl_distinventario.cod_producto)='".addslashes($_GET['buscar'])."')) OR (((tbl_distinventario.descripcion) like '%".addslashes($_GET['buscar'])."%')) OR (((tbl_distinventario.autor) like '%".addslashes($_GET['buscar'])."%')) OR (((tbl_distinventario.isbn)='".addslashes($_GET['buscar'])."')) OR (((tbl_distinventario.cod_barra)='".addslashes($_GET['buscar'])."'))";

}

 // ************* buscar *****************/

//die($query);
 //$result = $obj->consultar($query);//Se conecta al servidor local
 $result = $obj->consultar_remoto($query);//Se conecta al servidor remoto
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
 if($numrows == 0)
 {
     echo "<b>No Existe el Producto</b>
         <br>
         <br>
         <a href=\"javascript:history.back();\">[Regresar]</a>\n";
 }
 else
 {
 
$query = "SELECT *
FROM tbl_distinventario
WHERE (((tbl_distinventario.sucursal)=".$_SESSION['usuario_sucursal'].")) 
GROUP BY tbl_distinventario.cod_producto, tbl_distinventario.sucursal ";

if(isset($_GET['buscar']) && !empty($_GET['buscar'])){

$query.=" HAVING (((tbl_distinventario.cod_producto)='".addslashes($_GET['buscar'])."')) OR (((tbl_distinventario.descripcion) like '%".addslashes($_GET['buscar'])."%')) OR (((tbl_distinventario.autor) like '%".addslashes($_GET['buscar'])."%')) OR (((tbl_distinventario.isbn)='".addslashes($_GET['buscar'])."')) OR (((tbl_distinventario.cod_barra)='".addslashes($_GET['buscar'])."'))";

}
 // ************* buscar *****************/

 // ************* end of buscar *****************/  
     $query .= " LIMIT ".$_GET['page'].", $limit"; // add query LIMIT
     $result = mysql_query($query) or die(mysql_error());
     $numrows = mysql_num_rows($result);

     
     //echo our table
     echo "<table border=\"0\" width=\"100%\" cellpadding=\"1\" cellspacing=\"1\">\n";     

         echo "<th>".ucfirst("C&oacute;digo")."</th>\n";
         echo "<th>".ucfirst("Descripci&oacute;n")."</th>\n";
         echo "<th>".ucfirst("Autor")."</th>\n";
         echo "<th>".ucfirst("Editorial")."</th>\n";
		 echo "<th>".ucfirst("Tomo")."</th>\n";
         echo "<th>".ucfirst("Presentacion")."</th>\n";
         echo "<th>".ucfirst("Precio")."</th>\n";
	echo "<th>".ucfirst("Iva")."</th>\n";
	echo "<th>".ucfirst("Precio Final")."</th>\n";
	 echo "<th>".ucfirst("Existencia")."</th>\n";
     $i = 0;
     while ($row = mysql_fetch_assoc($result)) 
     {       
	$precio=$obj->setprecio_remoto($row["cod_producto"]);
			$getiva=$obj->setiva_remoto($row["cod_producto"]);
			
			if($getiva==1)
				$iva=0;
			elseif($getiva==2)
				$iva=$precio*0.12;
			
			$preciofinal=$precio+$iva;
				  
         echo "<tr class=\"TRalter\" onclick=\"enviarcodigo('".$row["cod_producto"]."')\">\n";
         echo "<td>".$row["cod_producto"]."</td>\n";
         echo "<td>".strtoupper($row["descripcion"])."</td>\n";
         echo "<td>".strtoupper($row["autor"])."</td>\n";
		 echo "<td>".strtoupper($row["editorial"])."</td>\n";
 		 echo "<td>".strtoupper($row["tomo"])."</td>\n";
		 echo "<td>".strtoupper($row["presentacion"])."</td>\n";
         echo "<td align='right'>".number_format($precio,2,",",".")."</font></b></td>\n";
	if($getiva==1)
		 echo "<td align='right'>".number_format($iva,2,",",".")."</td>\n";
	elseif($getiva==2)
		 echo "<td align='right'><b><font color=blue>".number_format($iva,2,",",".")."</font></b></td>\n";
	echo "<td align='right'><b><font size=2>".number_format($preciofinal,2,",",".")."</font></b></td>\n";
         echo "<td align='center'>".$row["cantidad"]."</td>\n";
        echo "</tr>\n";
        $i++;    
     }   
     echo "</table>\n";
     
     mysql_free_result($result);
 }


// ************** bottom pager  **************************
 echo "<table width=\"100%\" border=\"0\">
                <tr >
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
                  
               //   echo("<a href=\"$url\">$i</a> \n");
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
  echo "Cantidad: ".$num;
echo "</td>
     </tr>
     </table>"; 
// ************** end of bottom pager **************************
?>
</body>
</html>
