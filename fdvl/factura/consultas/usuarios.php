<? 
require("../admin/session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=2;// definir nivel de acceso para esta página.

if ($_SESSION['usuario_nivel'] < $nivel_acceso){

echo '<div align="center"><h1>Usted no tiene pérmiso para acceder a esta página</h1></div>';
echo '<div align="center"><input type="button" value="Salir" onClick="Javascript:window.close(this)" style="border:double;background-color:#990000;text-align:center;color:#FFFFFF;" ></div>';
/*echo '<script language="javascript">window.close(this)</script>';*/
//Header ("Location: ../admin/login.php?error_login=5");
//exit;
}else{
$obj=new manejadordb;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<META content="MyDB Studio" name=GENERATOR>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<title>Gesti&oacute;n de Usuarios</title>
<script type="text/javascript" src="../funciones/js/ajax.js"></script>
<script type="text/javascript" src="../jsefectos/prototype.js"></script>
<script type="text/javascript" src="../jsefectos/effects.js"></script>
<script type="text/javascript" src="../jsefectos/dragdrop.js"></script>
<script type="text/javascript" src="../jsefectos/litboxflash.js"></script>
<script type="text/javascript" src="../jsefectos/scriptaculous.js"></script>
<script type="text/javascript" src="../jsefectos/funciones.js"></script>
<script type="text/javascript" src="funciones/js/validacion.js"></script>
<script type="text/javascript" src="../funciones/js/sha1.js"></script>
<link rel="stylesheet" type="text/css" href="funciones/js/formulario.css">
<link rel="stylesheet" href="../styles/litbox.css" type="text/css" media="screen" />

<style type="text/css">
<!--
body {
        font-size: 11px;
        font-family: Tahoma,Arial,sans-serif;
}
a {
        font-family: Tahoma,Arial,sans-serif; 
        font-size: 12px;
        color: #0000FF;
        text-decoration: none;
}
a:hover {
        font-family: Tahoma, Arial, sans-serif; 
        font-size: 12px;
        color: #FF0000;
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
        background-color:#990000;
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
.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}


-->
</style>
<script>
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
function enviardatos(ced){
	window.location="../additemfactura.php?cliente="+ced;
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

</script>
</head>
<body>
<h1>Gesti&oacute;n de Usuarios</h1>


<!-- buscar engine -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" name="mform" id="mform">
<table width="200" border="0" cellpadding="0" cellspacing="0" class="buscarTable">
    <tr>
      <td nowrap> <b>Buscar:</b> 
   <input type="text" name="buscar" value="<?php if(!empty($_GET['buscar']))echo $_GET['buscar']; ?>"> 
   <input type="submit" value="Buscar">

      </td>
 
 </tr>
 
</table>
  <table width="200" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="47"><b>Sucursal:</b></td>
      <td width="137">
	
	  <select name="sucursal" id="sucursal" onChange="MM_jumpMenu('self',this,0)">

	<?	  
		
	  $sql="SELECT * FROM tbl_sucursal "; 
	   	 $sql.=" order by id_sucursal 	"; 
  
		$r = $obj->consultar($sql);

		if(!empty($_GET['sucursal']) && !empty($_GET['nomsuc'])){
	    echo '<option selected="selected" value='.$_GET['sucursal'].' >'.$_GET['nomsuc'].'</option>';
	 	}else echo '<option selected="selected" value="0" >Todas</option>';
		
     	while ($row = mysql_fetch_assoc($r)) 
     	{    
			
			$value="usuarios.php?sucursal=".$row["id_sucursal"]."&nomsuc=".$row["sucursal"]."";
			echo "<option value=\"".$value."\">".$row["sucursal"]."</option>";
		
		}	 
	   
	  ?>

      </select>
      </td>
    </tr>
  </table>
</form>
<!-- buscar engine -->


<?php


 $query = "SELECT 
                  *
           FROM
                  tbl_usuario";
 
 // ************* buscar *****************/
 if( isset($_GET['buscar']) && !empty($_GET['buscar']) && empty($_GET['sucursal']))  
 {
    // WHERE found ?
    if(!stristr($query,"WHERE "))
	 $query .= " WHERE (";
       
    // add field
     $query .= " us_login = '".trim(addslashes($_GET['buscar']))."' OR";
	 $query .= " cedula = ".trim($_GET['buscar'])."";

// delete last OR
//$query = substr($query,0,strlen($query)-3);
$query .= " ) "; 
}elseif (isset($_GET['sucursal']) && !empty($_GET['sucursal'])){
 
   if(!stristr($query,"WHERE "))
	 $query .= " WHERE (";
        
    // add field
     $query .= " us_sucursal = ".trim($_GET['sucursal'])." ";

 $query .= " ) order by us_login"; 
 }elseif($_GET['sucursal']==0){
     $query .= " order by us_login"; 
 }

//$query .= ") AND estatus=0 "; 

 // ************* end of buscar *****************/  
 
 $result = $obj->consultar($query);
 $numrows = mysql_num_rows($result); // result of count query


// ************** pager **************************
 $limit = 10; // Default results per-page.
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
     echo "<b>No Existe el Traslado</b>
         <br>
         <br>
         <a href=\"javascript:history.back();\">[Regresar]</a>\n";
 }
 else
 {

	$query = "SELECT
                       *
                FROM
                       tbl_usuario";

 // ************* buscar *****************/
 if( isset($_GET['buscar']) && !empty($_GET['buscar']) && empty($_GET['sucursal'])) 
 {
    // WHERE found ?
    if(!stristr($query,"WHERE "))
	 $query .= " WHERE (";
        
    // add field
     $query .= " us_login = '".trim(addslashes($_GET['buscar']))."' OR";
     $query .= " cedula = '".trim($_GET['buscar'])."' ";
// delete last OR
//$query = substr($query,0,strlen($query)-2);
$query .= " ) order by us_login"; 

 }elseif($_GET['sucursal']!=0 && !empty($_GET['sucursal'])){
 
   if(!stristr($query,"WHERE "))
	 $query .= " WHERE (";
        
    // add field
     $query .= " us_sucursal = ".trim($_GET['sucursal'])." ";

 $query .= ") order by us_login"; 
 }elseif($_GET['sucursal']==0){
     $query .= " order by us_login"; 
 }
 
//$query .= ") AND estatus=0 "; 
  
 // ************* end of buscar *****************/  
 
     $query .= " LIMIT ".$_GET['page'].", $limit"; // add query LIMIT
     $result = mysql_query($query) or die(mysql_error());
     $numrows = mysql_num_rows($result);
	/*echo $numrows;	
	echo $pages;
     echo $current;*/
     //echo our table
     echo "<table class=\"Mtable\" border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";     
         echo "<th>".ucfirst("Cédula")."</th>\n";
         echo "<th colspan='2'>".ucfirst("Usuario")."</th>\n";
         echo "<th>".ucfirst("Sucursal")."</th>\n";
         echo "<th>".ucfirst("Nivel")."</th>\n";
         echo "<th>".ucfirst("Estatus")."</th>\n";
         echo "<th>".ucfirst("Fecha de Ingreso")."</th>\n";
         echo "<th>".ucfirst("Opciones")."</th>\n";

     $i = 0;
     while ($row = mysql_fetch_assoc($result)) 
     {         
        // alternate color
				
        if($i%2 == 0)  
               echo "<tr class=\"TRalter\">\n";
        else
        echo "<tr>\n";
	  echo "<td align='left'>".$row["cedula"]."</td>\n";
         echo "<td align='left' colspan='2'>".$row["us_nombre"]." ".$row["us_apellido"]."</td>\n";
         echo "<td align='left'>".$obj->setsucursal($row["us_sucursal"])."</td>\n";
         echo "<td align='center'>".$obj->setnivel($row["us_nivel"])."</td>\n";
         echo "<td align='center'>".$obj->setestatus($row["us_estatus"])."</td>\n";
         echo "<td align='center'>".strftime("%d/%m/%Y",strtotime($row["us_fechaingreso"]))."</td>\n";
         echo "<td align='center'><input name='cargar' class='boton' type='button' value='Editar' onClick='editarusuario(".$row["id_usuario"].")'></td>\n";
        echo "</tr>\n";
        $i++;    
     }   
     echo "</table>\n";
     
     mysql_free_result($result);
 }

 echo "<table width=\"100%\" border=\"0\">
                <tr>
                <td align=\"center\">\n";

 if (!empty($_GET['page']) && $_GET['page'] > 0)
 {
   $back_page = $_GET['page'] - $limit;
   $url = $_SERVER["PHP_SELF"]."?sucursal=".$_GET['sucursal']."&page=$back_page&nomsuc=".$_GET['nomsuc']."";

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
                  $url = $_SERVER["PHP_SELF"]."?sucursal=".$_GET['sucursal']."&page=$ppage&nomsuc=".$_GET['nomsuc']."";
                  
                  if(!empty($_GET['buscar']))$url .= "&buscar=".$_GET['buscar']; // add buscar 
                  
                  //echo("<a href=\"$url\">$i</a> \n");
           }
         }
 }

 if(((($_GET['page']+$limit) / $limit) < $pages) && $pages != 1 && $numrows>=$current) 
 {   
   $next_page = $_GET['page'] + $limit;// If last page don't give next link.
   $url = $_SERVER["PHP_SELF"]."?sucursal=".$_GET['sucursal']."&page=$next_page&nomsuc=".$_GET['nomsuc']."";
    
   if(!empty($_GET['buscar']))$url .= "&buscar=".$_GET['buscar'];// add buscar   
   
   echo "    <a href=\"$url\">[>>]</a>\n";
 }
 echo "Cantidad: ".$num;
echo "</td>
     </tr>
	 
     </table>"; 

?>

<a href='#' onClick="new LITBox('../funciones/adduser.php',{type:'window',overlay:true,height:370, width:650});return false" style="border:groove;background-color:#CCCCCC;"><img src='../imagenes/newcliente.png' border="0"> Nuevo</a>
<a href='' onClick="javascript:window.close(this)"  style="border:groove;background-color:#CCCCCC;"><img src='../imagenes/salir.png' border="0"> Salir</a>

<hr>
</body>
</html>
<? }?>