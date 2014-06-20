<? 
require("../admin/session.php");
tipo
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>B&uacute;squeda de Solicitudes</title>

<script language="JavaScript">

function enviarcodigo(codigo){
    window.opener.document.forms[0].codigo.value = codigo;
	window.opener.cargardetalle(codigo);
	//return window.opener.cerrarbuscarsol();
}

function cerrarventana(){
	this.close();
}


</script> 
<style type="text/css">

.tabla{
-moz-border-radius: 5px;
background-color : #F5F5F5;
border : 2px solid #990000;
font-family : Arial, Verdana, Helvetica, sans-serif;
font-size : 12px;
padding-left : 0px;
padding-right : 0px;
border-color:#990000;
}

.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix;
-moz-border-radius:5px;
}
.celdal {
	BORDER-RIGHT: #990000 thin solid;
    BORDER-TOP: #990000 thin solid;
    BORDER-LEFT: #990000 thin solid;
    BORDER-BOTTOM: #990000 thin solid;
    PADDING-RIGHT: 0px;
    PADDING-LEFT: 0px;
    PADDING-TOP: 0px;
    PADDING-BOTTOM: 0px;
    FONT-FAMILY: Verdana, Arial;
    color: #000000;
    FONT-SIZE: 9pt;
    BACKGROUND-COLOR: #FFFFFF;
}
.bordes{
	text-decoration: none;
	background-color: #FFFFFF;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #990000;
	border-right-color: #990000;
	border-bottom-color: #990000;
	border-left-color: #990000;
	text-align:right;
}
.selecionada:hover{
	background:#CCCCCC;
	color:#990000;
	cursor:pointer;
}

</style>

</head>
<body>

<!-- buscar engine -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" name="mform" id="mform">
  <table width="200" border="0" cellpadding="0" cellspacing="0" class="tabla">
    <tr>
      <td nowrap> <b>Buscar:</b> 
   <input type="text" name="buscar" value="<?php if(!empty($_GET['buscar']))echo $_GET['buscar']; ?>"> 
   <input type="submit" value="Buscar" class="boton">
   <input type="submit" value="Ver Todos" onClick="document.mform.buscar.value='';" class="boton">
   <input type="button" name="salir" value="Salir" onclick="cerrarventana()" class="boton"/>
      </td>
 </tr>
</table>
</form>
<!-- buscar engine -->


<?

//include_once("../manejadordb.php");
$obj=new manejadordb;


 $query = "SELECT 
                  *
           FROM
                  tbl_solicitud";
 
 // ************* buscar *****************/
 if( isset($_GET['buscar']) && !empty($_GET['buscar']))  
 {
    // WHERE found ?
    if(!stristr($query,"WHERE "))
	 $query .= " WHERE (";
    else
	 $query .= " AND (";
        
    // add field
     $query .= " codigo = '".addslashes($_GET['buscar'])."' OR";
 
// delete last OR

$query .= ") ";
 }

if(isset($_GET['order']) && !empty($_GET['order'])){  

$forma=0;
if($_GET['forma']==0){$ord="asc";$forma=1;}else{$ord="desc";$forma=0;} 

$query .= " order by ".$_GET['order']." $ord ";

}
 // ************* buscar *****************/
 $result = $obj->consultar($query);
 $numrows = mysql_num_rows($result); // result of count query
// ************** pager **************************
 $limit = 20; // Default results per-page.
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
 
 $query = "SELECT 
                  *
           FROM
                  tbl_solicitud";
 
 // ************* buscar *****************/
 if( isset($_GET['buscar']) && !empty($_GET['buscar']))  
 {
    // WHERE found ?
    if(!stristr($query,"WHERE "))
	 $query .= " WHERE (";
    else
	 $query .= " AND (";
        
    // add field
     $query .= " codigo = '".addslashes($_GET['buscar'])."' OR";

// delete last OR
$query = substr($query,0,strlen($query)-1);
$query .= ") ";
}

if(isset($_GET['order']) && !empty($_GET['order'])){  

$forma=0;
if($_GET['forma']==0){$ord="asc";$forma=1;}else{$ord="desc";$forma=0;} 

$query .= " order by ".$_GET['order']." $ord ";

}

 // ************* end of buscar *****************/  
     $query .= " LIMIT ".$_GET['page'].", $limit"; // add query LIMIT
     $result = mysql_query($query) or die(mysql_error());
     $numrows = mysql_num_rows($result);

     
     //echo our table
     echo "<table class=\"tabla\" border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";     
     echo "<th class=\"celdal\"><a href=".$_SERVER['PHP_SELF']."?order=cod_producto"."&"."forma=".$forma.">".ucfirst("C&oacute;digo")."</a></th>\n";
         echo "<th class=\"celdal\"><a href=".$_SERVER['PHP_SELF']."?order=autor"."&"."forma=".$forma.">".ucfirst("Fecha Entrega")."</th>\n";
         echo "<th class=\"celdal\"><a href=".$_SERVER['PHP_SELF']."?order=isbn"."&"."forma=".$forma.">".ucfirst("Fecha Vencimiento")."</th>\n";
         echo "<th class=\"celdal\"><a href=".$_SERVER['PHP_SELF']."?order=costo"."&"."forma=".$forma.">".ucfirst("Vencimiento Consig.")."</th>\n";
          $i = 0;
     while ($row = mysql_fetch_assoc($result)) 
     {         
   		 if(strlen(strlen($row['descripcion'])>10 || strlen($row['autor'])>10)){
		 $pts="...";
	 }else $pts="";
		
        echo "<tr class=\"selecionada\" onclick=\"enviarcodigo('".$row["codigo"]."')\">\n";
         echo "<td>".$row["codigo"]."</td>\n";
         echo "<td align='center'>".cambiafanormal($row["fecha_entrega"])."</td>\n";
         echo "<td align='center'>".cambiafanormal($row["fecha_venc"])."</td>\n";
         echo "<td align='center'>".cambiafanormal($row["fecha_vencconsig"])."</td>\n";
        
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
 
 // loop through each page and give link to it.
 // no page when only one page
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
// ************** FIN PAGINADOR **************************
?>
</body>
</html>