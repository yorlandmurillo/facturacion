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
//$sql="SELECT * FROM tbl_facturas where tbl_facturas.sucursal=$sucursal and tbl_facturas.estatus_factura=3 and fecha_factura > '$fechadesde' and fecha_factura < '$fechahasta' ORDER BY tbl_facturas.vendedor asc;"; 

$sql="

SELECT tbl_sucursal.id_sucursal AS ID, tbl_sucursal.sucursal AS SUCURSAL, ROUND( SUM( tbl_facturas.efectivo - tbl_facturas.cambio ) , 6 ) AS EFECTIVO, ROUND( SUM( tbl_facturas.cheque ) , 6 ) AS CHEQUE, ROUND( SUM( tbl_facturas.tdb ) , 6 ) TARJETA_DE_DEBITO, ROUND( SUM( tbl_facturas.tdc ) , 6 ) AS TARJETA_DE_CREDITO, ROUND( SUM( tbl_facturas.bl ) , 6 ) AS BONO_LIBRO, ROUND( SUM( tbl_facturas.cesta_ticket ) , 6 ) AS CESTA_TICKET, 
ROUND( SUM( tbl_facturas.`mto_iva` ) , 6 ) AS IVA,
ROUND( SUM(tbl_facturas.mto_total),6) as TOTAL
FROM tbl_facturas
LEFT JOIN tbl_sucursal ON tbl_facturas.sucursal = tbl_sucursal.id_sucursal
WHERE tbl_facturas.fecha_factura >= '$fechadesde'
AND tbl_facturas.fecha_factura <= '$fechahasta'
and tbl_facturas.estatus_factura=3
GROUP BY tbl_sucursal.id_sucursal
ORDER BY TOTAL desc

";



$result=$obj->consultar($sql);
$num=mysql_num_rows($result);
$cant=30;
$record=10000000;
$contador=0;
$total_total = 0;

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
		$pdf->SetX(55);
		$pdf->Cell(25,0,"Efectivo",0,1,'C');
		$pdf->SetX(73);
		$pdf->Cell(25,0,"Cheque",0,1,'C');
		$pdf->SetX(90);
		$pdf->Cell(25,0,"Tarj/Deb.",0,1,'C');
		$pdf->SetX(110);
		$pdf->Cell(25,0,"Tarj/Cred.",0,1,'C');
		$pdf->SetX(128);
		$pdf->Cell(25,0,"B/Libro.",0,1,'C');
		$pdf->SetX(145);
		$pdf->Cell(25,0,"C/Ticket.",0,1,'C');
		$pdf->SetX(164);
		$pdf->Cell(25,0,"I.V.A",0,1,'C');
		$pdf->SetX(181);
		$pdf->Cell(25,0,"Total",0,1,'C');
	}

	$pdf->SetFont('Arial','',7);
	$pdf->SetY(42+bcmod($i,$cant)*7);
	$pdf->SetX(12);
	if($contador++<$record){
	$pdf->SetFont('Arial','I',8);
//	$pdf->SetTextColor(144,30,30);
	$pdf->Cell(25,0,number_format($contador, 0, ',', '.'),0,0,'L');
	$pdf->SetX(18);
	$pdf->Cell(25,0,substr($row['SUCURSAL'],0,40).$pts,0,1,'L');
	$pdf->SetX(60);
	$pdf->Cell(25,0,number_format($row['EFECTIVO'], 2, ',', '.'),0,0,'L');
	$pdf->SetX(80);
	$pdf->Cell(25,0,number_format($row['CHEQUE'], 2, ',', '.'),0,0,'L');
	$pdf->SetX(95);
	$pdf->Cell(25,0,number_format($row['TARJETA_DE_DEBITO'], 2, ',', '.'),0,0,'L');
	$pdf->SetX(115);
	$pdf->Cell(25,0,number_format($row['TARJETA_DE_CREDITO'], 2, ',', '.'),0,0,'L');
	$pdf->SetX(135);
	$pdf->Cell(25,0,number_format($row['BONO_LIBRO'], 2, ',', '.'),0,0,'L');
	$pdf->SetX(152);
	$pdf->Cell(25,0,number_format($row['CESTA_TICKET'], 2, ',', '.'),0,0,'L');
	$pdf->SetX(172);
	$pdf->Cell(25,0,number_format($row['IVA'], 2, ',', '.'),0,0,'L');
	$pdf->SetX(190);
	$pdf->SetTextColor(144,30,30);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(25,0,number_format($row['TOTAL'], 2, ',', '.'),0,0,'L');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','I',8);
	$total_total = $total_total + $row['TOTAL'];

//   	$pdf->Line(30,30,30,30);
	}else{
	

	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50,0,$row['cod_producto'],0,1,'L');	
	$pdf->SetX(38);
	$pdf->Cell(25,0,strtoupper($row['SUCURSAL']),0,1,'C');

	}

	$totalvendido+=$row['cantidad'];
	
	//$pdf->SetX(155);
	//$pdf->Cell(0,0,substr(manejadordb::getautor($row['cod_producto']),0,52),0,1,'L');

	}	
	$pdf->SetFont('Helvetica','',14);
	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(140);
	$pdf->Cell(25,0,"Total Vendidos:",0,1,'L');
	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(178);
	$totalvendido = number_format($total_total, 2, ',', '.');
	$pdf->Cell(25,0,$totalvendido,0,1,'L');

//if(!ereg("MSIE",$_SERVER["HTTP_USER_AGENT"]))	
//	$pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu,'credenciales_activadas.pdf','D');
//else
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
  <h6 class="Estilo7">REPORTE DE MONITOREO POR SUCURSALES</h6>
  <table width="323" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" class="tabla" >
    <tr>
      <td colspan="4" class="boton"><span class="celdac">Periodo: </span></td>
    </tr> 
<tr>
      <td><span class="celdac">Desde:</span></td>
	<td><span class="Estilo5">
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
      <td><span class="celdac">Hasta:</span></td>
      <td><span class="Estilo5">
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
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><span class="Estilo5"></span></td>
  <td><span class="Estilo5"></span></td>
  <td><span class="Estilo5"></span></td>
  <td><span class="Estilo5"></span></td>
</tr>
	<tr>
	  <td colspan="4"><span class="Estilo5"></span></td>
    </tr>
	<tr>
	  <td colspan="4" class="boton"><span class="celdac"><strong>Agrupar Por: 
      </strong></span></td>
    </tr>
	
	<tr>
	  <td colspan="4"><span class="celdac"><strong>
	    <input name="orden" type="radio" value="fecha" checked="checked" />
Fecha</strong></span></td>
    </tr>
	<tr align="center" class="button">
	  <td colspan="4"><span class="Estilo14">Ayuda y Soporte Tecnico: Alberto Romero </span></td>
    </tr>
	<tr align="center" class="button">
	  <td colspan="4"><span class="Estilo14">Telf 0426.512.95.79</span></td>
    </tr>
	<tr>
      <td colspan="4"><div align="right" class="Estilo5">
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
