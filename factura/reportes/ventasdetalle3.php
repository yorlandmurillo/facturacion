<?php
require('../fpdf/fpdf.php');
require("../admin/session.php"); // incluir motor de autentificación.
$obj=new manejadordb();

class PDF extends FPDF
{
//Cabecera de página
  function Header(){
  
  	$sucursal2 = $_POST['sucursal'];
 $link = mysql_connect("localhost","inventa_bd","Valenta@04") or die (mysql_error());  
    mysql_select_db("inventa_pglibreria",$link);
	$result = mysql_query("
select *
from tbl_editorial
WHERE id_editorial ='$sucursal2'
",$link); 
$row=mysql_fetch_array($result); 

$sucursal_muestra=$row["editorial"];

if ($sucursal2 == 0)
{
$sucursal_muestra = 'TODAS LAS SUCURSALES';
}

    //Superior Derecha
    $this->SetFont('Arial','B',14);
	$this->cell(0,5,'Fundación Librerías del Sur',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','BI',9);	
	
	
	 $this->Cell(0,5,'SUCURSAL:'." ".strtoupper($sucursal_muestra),0,0,'R');
$FECHA_UNO = $_POST['fechad'];
$FECHA_DOS = $_POST['fechah'];
$FECHA_SOLA = $_POST['fechab'];


    $this->Ln(1);
    $this->SetFont('Arial','BI',9);
    //Título
	 $this->Cell(0,10,'DESDE:'." ".strtoupper($FECHA_UNO),0,0,'R');
    $this->Ln(2);
    $this->SetFont('Arial','BI',9);
    //Título
	 $this->Cell(0,12,'HASTA:'." ".strtoupper($FECHA_DOS),0,0,'R');

    $this->Ln(5);
    $this->SetFont('Arial','B',15);
    //Título
	
    $this->Cell(0,10,'REPORTE DE MONITOREO POR SUCURSALES',0,0,'C');	
    //Salto de línea
    $this->Ln(10);
  }
  //Pie de página 
  function Footer($fecha='',$hora='',$usuario='')
  {
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
	//datos de pie de pagina, fecha y hora de impresion y usuario que mando a imprimir
	$this->Cell(0,10,$fecha.'                  '.$hora.'                  '.$usuario,0,0,'L');
    //Número de página
    $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'R');
  }
}

if(isset($_POST['fechab']) && !empty($_POST['fechab']) || isset($_POST['fechad']) && !empty($_POST['fechad']) && isset($_POST['fechah']) && !empty($_POST['fechah']) && isset($_POST['orden']) && !empty($_POST['orden'])){
$sucursal=$_POST['sucursal'];
$f=date('d')."/".date('m')."/".date('Y');
$h=date('H').":".date('i');
//$min=date('i');
//$sec=date('s');
if(isset($_POST['fechab']) && !empty($_POST['fechab']) && empty($_POST['fechad']) && empty($_POST['fechah'])){
$date=cambiafamysql($_POST['fechab']);
$date1=cambiafamysql($_POST['fechab']);
}elseif (empty($_POST['fechab']) && !empty($_POST['fechad']) && !empty($_POST['fechah'])){
$date=cambiafamysql($_POST['fechad']);
$date1=cambiafamysql($_POST['fechah']);
}

$fechadesde=$date." 00:00:00";
$fechahasta=$date1." 23:59:59";


$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();

$sql="SELECT tbl_sucursal.id_sucursal AS ID, tbl_sucursal.sucursal AS SUCURSAL, 
COUNT(tbl_facturas.cod_factura) as CLIENTES_ATENDIDOS,
ROUND( SUM( tbl_facturas.`mto_iva` ) , 6 ) AS IVA,
ROUND( SUM(tbl_facturas.mto_total),6) as TOTAL
FROM tbl_facturas
LEFT JOIN tbl_sucursal ON tbl_facturas.sucursal = tbl_sucursal.id_sucursal
WHERE tbl_facturas.fecha_factura >= '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and tbl_facturas.estatus_factura=3
GROUP BY tbl_sucursal.id_sucursal
ORDER BY SUCURSAL";
////////////////////////////////

$link = mysql_connect("localhost","inventa_bd","Valenta@04") or die (mysql_error());  
 mysql_select_db("inventa_pglibreria",$link);
	$result2 = mysql_query("

SELECT SUM(CANTIDAD) AS CANTIDAD_LIBROS,tbl_sucursal.id_sucursal AS ID, tbl_sucursal.sucursal AS SUCURSAL
FROM tbl_facturas
LEFT JOIN tbl_sucursal 
ON tbl_facturas.sucursal = tbl_sucursal.id_sucursal
LEFT JOIN tbl_itemfactura 
ON tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
AND tbl_facturas.SUCURSAL = tbl_itemfactura.SUCURSAL
WHERE tbl_facturas.fecha_factura >= '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and tbl_facturas.estatus_factura=3
GROUP BY tbl_facturas.SUCURSAL
ORDER BY SUCURSAL  ",$link); 


$result3 = mysql_query("
select ROUND( SUM(tbl_facturas.mto_total),6) as TOTAL_GLOBAL
FROM tbl_facturas
LEFT JOIN tbl_sucursal ON tbl_facturas.sucursal = tbl_sucursal.id_sucursal
WHERE tbl_facturas.fecha_factura >= '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and tbl_facturas.estatus_factura=3",$link); 


$query4="SELECT distinct(tbl_inventario.lib_articulo),SUM(CANTIDAD) AS CANTIDAD_LIBROS
from tbl_facturas,tbl_itemfactura,tbl_inventario
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_itemfactura.cod_producto = tbl_inventario.cod_producto 
and tbl_facturas.fecha_factura >=  '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and estatus_factura=3 
and estatus_cancelacion=3
and tbl_inventario.lib_articulo='C'
group by tbl_inventario.lib_articulo";
//die($query4);
$result4 = mysql_query($query4,$link) or die($query4."<br>".mysql_error());
$row4=mysql_fetch_array($result4); 
$CD = $row4['CANTIDAD_LIBROS'];
///////////////////////////////
$result5 = mysql_query("
SELECT distinct(tbl_inventario.lib_articulo),SUM(CANTIDAD) AS CANTIDAD_LIBROS
from tbl_facturas,tbl_itemfactura,tbl_inventario
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_itemfactura.cod_producto = tbl_inventario.cod_producto 
and tbl_facturas.fecha_factura >=  '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and estatus_factura=3 
and estatus_cancelacion=3
and tbl_inventario.lib_articulo='D'
group by tbl_inventario.lib_articulo
",$link); 
$row5=mysql_fetch_array($result5); 
$DVD = $row5['CANTIDAD_LIBROS'];
///////////////////////////////
$result6 = mysql_query("
SELECT distinct(tbl_inventario.lib_articulo),SUM(CANTIDAD) AS CANTIDAD_LIBROS
from tbl_facturas,tbl_itemfactura,tbl_inventario
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_itemfactura.cod_producto = tbl_inventario.cod_producto 
and tbl_facturas.fecha_factura >=  '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and estatus_factura=3 
and estatus_cancelacion=3
and tbl_inventario.lib_articulo='L'
group by tbl_inventario.lib_articulo
",$link); 
$row6=mysql_fetch_array($result6); 
$LIBROS = $row6['CANTIDAD_LIBROS'];
///////////////////////////////////////////////




///////////////////////////////
$result7 = mysql_query("
SELECT distinct(tbl_inventario.lib_articulo),SUM(CANTIDAD) AS CANTIDAD_LIBROS
from tbl_facturas,tbl_itemfactura,tbl_inventario
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_itemfactura.cod_producto = tbl_inventario.cod_producto 
and tbl_facturas.fecha_factura >=  '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and estatus_factura=3 
and estatus_cancelacion=3
and tbl_inventario.lib_articulo='P'
group by tbl_inventario.lib_articulo
",$link); 
$row7=mysql_fetch_array($result7); 
$PERIODICOS = $row7['CANTIDAD_LIBROS'];
///////////////////////////////////////////////
///////////////////////////////
$result8 = mysql_query("
SELECT distinct(tbl_inventario.lib_articulo),SUM(CANTIDAD) AS CANTIDAD_LIBROS
from tbl_facturas,tbl_itemfactura,tbl_inventario
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_itemfactura.cod_producto = tbl_inventario.cod_producto 
and tbl_facturas.fecha_factura >=  '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and estatus_factura=3 
and estatus_cancelacion=3
and tbl_inventario.lib_articulo='F'
group by tbl_inventario.lib_articulo
",$link); 
$row8=mysql_fetch_array($result8); 
$FOLLETOS = $row8['CANTIDAD_LIBROS'];
///////////////////////////////////////////////
///////////////////////////////
$result9 = mysql_query("
SELECT distinct(tbl_inventario.lib_articulo),SUM(CANTIDAD) AS CANTIDAD_LIBROS
from tbl_facturas,tbl_itemfactura,tbl_inventario
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_itemfactura.cod_producto = tbl_inventario.cod_producto 
and tbl_facturas.fecha_factura >=  '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and estatus_factura=3 
and estatus_cancelacion=3
and tbl_inventario.lib_articulo='R'
group by tbl_inventario.lib_articulo
",$link); 
$row9=mysql_fetch_array($result9); 
$REVISTA = $row9['CANTIDAD_LIBROS'];
///////////////////////////////////////////////

$result10 = mysql_query("
SELECT distinct(tbl_inventario.lib_articulo),SUM(CANTIDAD) AS CANTIDAD_LIBROS
from tbl_facturas,tbl_itemfactura,tbl_inventario
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_itemfactura.cod_producto = tbl_inventario.cod_producto 
and tbl_facturas.fecha_factura >=  '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and estatus_factura=3 
and estatus_cancelacion=3
and tbl_inventario.lib_articulo='A'
group by tbl_inventario.lib_articulo
",$link); 
$row10=mysql_fetch_array($result10); 
$ARTESANIA = $row10['CANTIDAD_LIBROS'];
///////////////////////////////////////////////

$result11 = mysql_query("
SELECT distinct(tbl_inventario.lib_articulo),SUM(CANTIDAD) AS CANTIDAD_LIBROS
from tbl_facturas,tbl_itemfactura,tbl_inventario
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_itemfactura.cod_producto = tbl_inventario.cod_producto 
and tbl_facturas.fecha_factura >=  '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and estatus_factura=3 
and estatus_cancelacion=3
and tbl_inventario.lib_articulo='JU'
group by tbl_inventario.lib_articulo
",$link); 
$row11=mysql_fetch_array($result11); 
$JUEGO = $row11['CANTIDAD_LIBROS'];
///////////////////////////////////////////////

$result12 = mysql_query("

SELECT distinct(tbl_inventario.lib_articulo),SUM(CANTIDAD) AS CANTIDAD_LIBROS
from tbl_facturas,tbl_itemfactura,tbl_inventario
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_itemfactura.cod_producto = tbl_inventario.cod_producto 
and tbl_facturas.fecha_factura >=  '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and estatus_factura=3 
and estatus_cancelacion=3
and tbl_inventario.lib_articulo='PA'
group by tbl_inventario.lib_articulo
",$link); 
$row12=mysql_fetch_array($result12); 
$PAPELERIA = $row12['CANTIDAD_LIBROS'];
///////////////////////////////////////////////

$result13 = mysql_query("

SELECT distinct(tbl_inventario.lib_articulo),SUM(CANTIDAD) AS CANTIDAD_LIBROS
from tbl_facturas,tbl_itemfactura,tbl_inventario
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_itemfactura.cod_producto = tbl_inventario.cod_producto 
and tbl_facturas.fecha_factura >=  '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and estatus_factura=3 
and estatus_cancelacion=3
and tbl_inventario.lib_articulo='POS'
group by tbl_inventario.lib_articulo
",$link); 
$row13=mysql_fetch_array($result13); 
$POSTALES = $row13['CANTIDAD_LIBROS'];


$result14 = mysql_query("
SELECT distinct(tbl_inventario.lib_articulo),SUM(CANTIDAD) AS CANTIDAD_LIBROS
from tbl_facturas,tbl_itemfactura,tbl_inventario
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_itemfactura.cod_producto = tbl_inventario.cod_producto 
and tbl_facturas.fecha_factura >=  '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and estatus_factura=3 
and estatus_cancelacion=3
and tbl_inventario.lib_articulo='AF'
group by tbl_inventario.lib_articulo
",$link);

$row14=mysql_fetch_array($result14); 
$AFICHES = $row14['CANTIDAD_LIBROS'];
///////////////////////////////////////////////


$result=$obj->consultar($sql);
$num=mysql_num_rows($result);


$row3=mysql_fetch_array($result3); 
$porcentaje = $row3['TOTAL_GLOBAL'];

$cant=30;
$record=10000000;
$contador=0;
$total_total = 0;

	$promed = $row['TOTAL'];



for($i=0;$i<$num && $row=mysql_fetch_assoc($result);$i++){
	
	if(bcmod($i,$cant)==0){
		$pdf->AddPage('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.manejadordb::setuser($_SESSION['usuario_id']));
	  	//Superior Izquierda
    					
    $pdf->Ln(5);
		$pdf->SetY(13);
		$pdf->SetX(12);
		$pdf->cell(0,5,$ent,0,0,'L');
		$pdf->Line(12,30,210,30);
		$pdf->SetFont('Helvetica','',10);
		$pdf->SetY(35);
		$pdf->SetX(2);
		$pdf->Cell(25,0,"Nº",0,1,'C');
		$pdf->SetX(13);
		$pdf->Cell(25,0,"Sucursal",0,1,'C');
		$pdf->SetX(57);
		$pdf->Cell(25,0,"Total Ventas",0,1,'C');
		$pdf->SetX(100);
		$pdf->Cell(25,0,"Clientes Atendidos",0,1,'C');
		$pdf->SetX(140);
		$pdf->Cell(25,0,"Bienes Culturales",0,1,'C');
	}

	$pdf->SetFont('Arial','',7);
	$pdf->SetY(42+bcmod($i,$cant)*7);
	$pdf->SetX(12);
	if($contador++<$record){
	$pdf->SetFont('Arial','I',8);

$row2=mysql_fetch_array($result2); 

	$pdf->Cell(25,0,number_format($contador, 0, ',', '.'),0,0,'L');
	$pdf->SetX(18);
	$pdf->Cell(25,0,substr($row['SUCURSAL'],0,40).$pts,0,1,'L');
	$pdf->SetX(65);
	$pdf->Cell(25,0,number_format($row['TOTAL'], 2, ',', '.'),0,0,'L');
	$pdf->SetX(110);
	$pdf->Cell(25,0,number_format($row['CLIENTES_ATENDIDOS'], 0, ',', '.'),0,0,'L');
	$pdf->SetX(150);
	$pdf->Cell(25,0,number_format($row2['CANTIDAD_LIBROS'], 0, ',', '.'),0,0,'L');
	$pdf->SetX(185);
	

	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','I',8);
	$total_total = $total_total + $row['TOTAL'];
	$total_totalc = $total_totalc + $row['CLIENTES_ATENDIDOS'];
	$total_totall = $total_totall + $row2['CANTIDAD_LIBROS'];


	}else{
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50,0,$row['cod_producto'],0,1,'L');	
	$pdf->SetX(38);
	$pdf->Cell(25,0,strtoupper($row['SUCURSAL']),0,1,'C');
	}

	$totalvendido+=$row['cantidad'];
	$pdf->SetX(155);
	}	
	$pdf->SetFont('Helvetica','',14);

	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(140);
	$pdf->Cell(25,0,"Total Ventas:",0,1,'L');

	$pdf->SetY(55+bcmod($i,$cant)*7);
	$pdf->SetX(140);
	$pdf->Cell(25,0,"Total Clientes:",0,1,'L');

	$pdf->SetY(63+bcmod($i,$cant)*7);
	$pdf->SetX(140);
	$pdf->Cell(25,0,"Total Bienes:",0,1,'L');


	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(178);
	$totalvendido = number_format($total_total, 2, ',', '.');
	$pdf->Cell(25,0,$totalvendido,0,1,'L');

	$pdf->SetY(55+bcmod($i,$cant)*7);
	$pdf->SetX(178);
	$totalvendidoc = number_format($total_totalc, 0, ',', '.');
	$pdf->Cell(25,0,$totalvendidoc,0,1,'L');

	$pdf->SetY(63+bcmod($i,$cant)*7);
	$pdf->SetX(178);
	$totalvendidol = number_format($total_totall, 0, ',', '.');
	$pdf->Cell(25,0,$totalvendidol,0,1,'L');

$pdf->SetY(80+bcmod($i,$cant)*7);
	$pdf->SetX(5);
	$CD = number_format($CD, 0, ',', '.');
	$DVD = number_format($DVD, 0, ',', '.');
	$LIBROS = number_format($LIBROS, 0, ',', '.');
	$PERIODICOS = number_format($PERIODICOS, 0, ',', '.');
	$FOLLETOS = number_format($FOLLETOS, 0, ',', '.');
	$REVISTA = number_format($REVISTA, 0, ',', '.');
	$ARTESANIA = number_format($ARTESANIA, 0, ',', '.');
	$JUEGO = number_format($JUEGO, 0, ',', '.');
	$PAPELERIA = number_format($PAPELERIA, 0, ',', '.');
	$POSTALES = number_format($POSTALES, 0, ',', '.');

$pdf->SetFont('Helvetica','',7);
$pdf->Cell(25,0,"TOTAL (LIBROS:$LIBROS) - (CD:$CD) - (DVD:$DVD) - (PERIODICOS:$PERIODICOS) - (REVISTAS:$REVISTA) - (FOLLETOS:$FOLLETOS)" ,0,1,'L');
$pdf->SetY(90+bcmod($i,$cant)*7);
$pdf->Cell(25,0,"TOTAL (ARTESANIA:$ARTESANIA) - (JUEGO:$JUEGO)- (PAPELERIA:$PAPELERIA) - (POSTALES:$POSTALES) - (AFICHES:$AFICHES)" ,0,1,'L');

//$y=$pdf->GetY();

//$pdf->Text(5,$y+10,"TOTAL DE BIENES CULTURALES = ".$totalvendidol);
	

 $pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.manejadordb::setuser($_SESSION['usuario_id']));

}
?>

<script type="text/javascript" src="../consultas/calendar/calendar.js"></script>
<script type="text/javascript" src="../consultas/calendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="../consultas/calendar/calendar-setup.js"></script>

<style type="text/css">
@import url(../consultas/calendar/calendar-win2k-1.css);
</style>
<style type="text/css">
	
.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #333333; background-color: #ECE9D8; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}
.MultiPage {  background-color:White;
  border: 0px solid #919B9C;
  width:100%;
  position:relative;
  padding:10px;
  top:-3px;
  z-index:98;
  display:block;
}
body{
	margin:0px;
	text-align:center;
	background-image: url();
	}
	
	#mainContentainer{
		width:760px;
		margin:0 auto;
		text-align:left;
	}
	#mainContent{
		border:1px solid #000;
	}
	#textContent{
		height:400px;
		overflow:auto;
		padding-left:5px;
		padding-right:5px;
		word-spacing:inherit
	}
	#menuDiv{
		width:100%;
		overflow:hidden;
	}
	pre{
		color:#F00;
	}
	p,pre{

	}

.celda {
	font-weight: bold;
	font-size: 10px;
	
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
.celdac {
	color:  #990000;
	font-weight: bold;
	font-size: 12px;
	border:inherit;
}
.celdad {
	color:  #990000;
	font-weight: bold;
	font-size: 12px;

white-space:nowrap;
border-bottom:dotted;
background:#FFFFFF;
	
}

    .bordes {
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
}
    #Layer1 {
	position:absolute;
	left:328px;
	top:124px;
	width:274px;
	height:178px;
	z-index:1;
}
    #Layer2 {
	position:absolute;
	left:134px;
	top:144px;
	width:450px;
	height:188px;
	z-index:1;
}
.tabla{
-moz-border-radius: 5px;
border : 5px solid #CCCCCC;
}
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #333333; background-color: #ECE9D8; border-color: #FFFFFF; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix; font-weight: bold; }
.Estilo5 {color: #EEEEEE}
.Estilo7 {font-size: 9pt; background-color: #ECE9D8; border-color: #FFFFFF; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix; font-family: Verdana, Arial, Helvetica, sans-serif;}
.Estilo14 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #990000; }
</style>
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="mform" id="mform">
  <img src="../../imagenes/cabeceramia.jpg" width="760" height="75">
  <h6 class="Estilo7">REPORTE DE GLOBAL POR SUCURSALES</h6>
  <table width="323" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" class="tabla" >
    <tr>
      <td colspan="4" bgcolor="#FF9933" class="boton"><span class="celdac">Periodo: </span></td>
    </tr> 
<tr>
      <td bgcolor="#FF9933"><span class="celdac">Desde:</span></td>
	<td bgcolor="#FF9933"><span class="Estilo5">
	  <input type="text" name="fechad" id="fechad" value="<?php if(!empty($_POST['fechad']))echo $_POST['fechad']; ?>" size="10" readonly="true">
	  <img src="../imagenes/calendar.png" id="trigger1"
     style='cursor: pointer; border: 0px solid red;'
     title='Selector de fecha'
     onmouseover="this.style.background='white';"
     onmouseout="this.style.background=''"/>
	  <script type="text/javascript">
  Calendar.setup(
    {
      inputField  : 'fechad',         // ID of the input field
      align          :    'Tr',
      singleClick    :    false,
      ifFormat    : '%d/%m/%Y',    // the date format
      button      : 'trigger1'       // ID of the button
    }
  );
      </script>
	</span></td>
      <td bgcolor="#FF9933"><span class="celdac">Hasta:</span></td>
      <td bgcolor="#FF9933"><span class="Estilo5">
        <input type="text" name="fechah" id="fechah" value="<?php if(!empty($_POST['fechah']))echo $_POST['fechah']; ?>" size="10" readonly="true">
        <img src="../imagenes/calendar.png" id="trigger2"
     style='cursor: pointer; border: 0px solid red;'
     title='Selector de fecha'
     onmouseover="this.style.background='white';"
     onmouseout="this.style.background=''" />
              <script type="text/javascript">
  Calendar.setup(
    {

	  inputField  : 'fechah',         // ID of the input field
      align          :    'Tr',
      singleClick    :    false,
      ifFormat    : '%d/%m/%Y',    // the date format
      button      : 'trigger2'       // ID of the button
	  }
	
  );
              </script>
      </span></td>  
</tr>

<tr>
  <td bgcolor="#FF9933">&nbsp;</td>
  <td bgcolor="#FF9933">&nbsp;</td>
  <td bgcolor="#FF9933">&nbsp;</td>
  <td bgcolor="#FF9933">&nbsp;</td>
</tr>
<tr>
  <td bgcolor="#FF9933"><span class="Estilo5"></span></td>
  <td bgcolor="#FF9933"><span class="Estilo5"></span></td>
  <td bgcolor="#FF9933"><span class="Estilo5"></span></td>
  <td bgcolor="#FF9933"><span class="Estilo5"></span></td>
</tr>
	<tr>
	  <td colspan="4" bgcolor="#FF9933"><span class="Estilo5"></span></td>
    </tr>
	<tr>
	  <td colspan="4" bgcolor="#FF9933" class="boton"><span class="celdac"><strong>Agrupar Por: 
      </strong></span></td>
    </tr>
	
	<tr>
	  <td colspan="4" bgcolor="#FF9933"><span class="celdac"><strong>
	    <input name="orden" type="radio" value="fecha" checked="checked" />
Fecha</strong></span></td>
    </tr>
	<tr>
      <td colspan="4" bgcolor="#FF9933"><div align="right" class="Estilo5">
        <input name="submit" type="submit" class="Estilo7" value="Consultar" />        
        <input name="button" type="button" class="Estilo7" onclick="javascript:window.close(this)" value="Salir" />
      </div></td>
    </tr>
</table>
</form>
<style>
SELECT {
border: solid #336666 1px; FONT-SIZE: 11px; BACKGROUND: #CCCCCC; COLOR: #333333; FONT-FAMILY: Trebuchet MS, Arial, Geneva; TEXT-DECORATION: none

}
</style>
