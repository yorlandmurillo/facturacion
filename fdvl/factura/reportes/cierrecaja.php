<?
require('../fpdf/fpdf.php');
require("../admin/session.php"); // incluir motor de autentificaci�n.
$obj=new manejadordb();

class PDF extends FPDF
{

//Cabecera de p�gina
  function Header(){
    //Superior Derecha
    $this->SetFont('Arial','B',14);
	$this->cell(0,5,'SIGAL',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','BI',10);	
	$this->cell(0,5,'version 1.0',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','B',15);
    //T�tulo
    $this->Cell(1,10,manejadordb::setsucursal($_SESSION['usuario_sucursal']),0,0,'L');	

	if(isset($_POST['fechab']) && !empty($_POST['fechab']) && $_POST['fechab']!="todos"){
	$this->Cell(0,10,'Fecha: '.$_POST['fechab'],0,0,'C');	
	}

	$this->Cell(0,10,'Cierre de Ventas ',0,0,'R');	
    //Salto de l�nea
    $this->Ln(10);
  }
  //Pie de p�gina 
  function Footer($fecha='',$hora='',$usuario='')
  {
    //Posici�n: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
	//datos de pie de pagina, fecha y hora de impresion y usuario que mando a imprimir
	$this->Cell(0,10,$fecha.'                  '.$hora.'                  '.$usuario,0,0,'L');
    //N�mero de p�gina
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
  }
}


if(isset($_POST['fechab']) && !empty($_POST['fechab']) || isset($_POST['fechad']) && !empty($_POST['fechad']) || isset($_POST['fechah']) && !empty($_POST['fechah'])){


$fecha=date('Y-m-d');
$sucursal=$_SESSION['usuario_sucursal'];
$vendedor=$_SESSION['usuario_id'];
$fdesde=cambiafamysql($_POST['fechad']);
$fhasta=cambiafamysql($_POST['fechah']);
$fechab=cambiafamysql($_POST['fechab']);
$f=date('d')."/".date('m')."/".date('Y');
$h=date('H').":".date('i');


//$factura=new factura();

$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();


$sql="SELECT * from tbl_cierre where cod_sucursal=$sucursal and estatus=7 ";


if(!empty($_POST['fechab']) && $_POST['fechab']!='todos'){
$sql.=" and fecha='$fechab' ";
}

if(!empty($_POST['fechad']) && !empty($_POST['fechah']) && empty($_POST['fechab'])){
$sql.=" and fecha >= '$fdesde' and fecha <= '$fhasta' ";
}


$result=$obj->consultar($sql);
$num=mysql_num_rows($result);
$cant=24;
$cont=0;
$total=0;

for($i=0;$i<$num+$cont && $row=mysql_fetch_assoc($result);$i++){

	$clientes+=$row['total_clientes'];
	$tdc+=$row['total_credito'];
	$tdb+=$row['total_debito'];
	$efectivo+=$row['total_efectivo'];
	$cheques+=$row['total_cheques'];
	$especiales+=$row['total_especiales'];
	$omoneda+=$row['total_omoneda'];
	$bonolibro+=$row['total_bonolibro'];
	$cesta+=$row['total_cestatikets'];
	$ejemplares+=$row['total_ejemplares'];

	if(bcmod($i,$cant)==0){
		$pdf->AddPage('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu);
	  	//Superior Izquierda
    	
    	$pdf->Ln(5);
		$pdf->SetY(13);
		$pdf->SetX(12);
		$pdf->cell(0,5,$ent,0,0,'L');
		$pdf->Line(12,30,210,30);
		$pdf->SetFont('Helvetica','',6);
		$pdf->SetY(35);
		$pdf->SetX(12);
		$pdf->Rect(12,30,198,8);
		$pdf->Cell(50,0,"CLIENTES",0,1,'L');
		$pdf->SetX(20);
		$pdf->Cell(25,0,"EJEMPLARES",0,1,'C');
		$pdf->SetX(39);
		$pdf->Cell(25,0,"TDC",0,1,'C');
		$pdf->SetX(57);
		$pdf->Cell(25,0,"TDB",0,1,'C');
		$pdf->SetX(75);
		$pdf->Cell(25,0,"EFECTIVO",0,1,'C');
		$pdf->SetX(94);
		$pdf->Cell(25,0,"CHEQUE",0,1,'C');
		$pdf->SetX(112);
		$pdf->Cell(25,0,"ESPECIAL",0,1,'C');
		$pdf->SetX(131);
		$pdf->Cell(25,0,"C/TICKET",0,1,'C');
		$pdf->SetX(150);
		$pdf->Cell(25,0,"O/MONEDA",0,1,'C');
		$pdf->SetX(170);
		$pdf->Cell(25,0,"BONOLIBRO",0,1,'C');
		$pdf->SetX(189);
		$pdf->Cell(25,0,"TOTAL CIERRE",0,1,'C');

	}

	if(bcmod($i,$cant)<$cant-1 && $fechacierre!=$row['fecha']){
	//if(){
		
		$fechacierre=$row['fecha'];
		$pdf->SetY(40+bcmod($i,$cant)*7);
		$pdf->SetFont('Arial','',7);
		$pdf->SetX(12);
		$pdf->Cell(28,5,"Fecha: ".cambiafanormal($fechacierre),1,1,'L');
		$i++;
		$cont++;
	//}	
	}



	$totalmonto=$row['total_credito']+$row['total_debito']+$row['total_efectivo']+$row['total_cheques']+$row['total_especiales']+$row['total_omoneda']+$row['total_bonolibro'];

	$pdf->SetFont('Arial','',6);
	$pdf->SetFont('Arial','',6);
	$pdf->SetY(42+bcmod($i,$cant)*7);
	$pdf->Rect(12,39+bcmod($i,$cant)*7,198,6);
	$pdf->SetX(15);
	$pdf->Cell(50,0,$row['total_clientes'],0,1,'L');	
	$pdf->SetX(20);
	$pdf->Cell(25,0,$row['total_ejemplares'],0,1,'C');
	$pdf->SetX(20);
	$pdf->Cell(35,0,number_format($row['total_credito'],2,',','.'),0,1,'R');
	$pdf->SetX(48);
	$pdf->Cell(25,0,number_format($row['total_debito'],2,',','.'),0,1,'R');
	$pdf->SetX(68);
	$pdf->Cell(25,0,number_format($row['total_efectivo'],2,',','.'),0,0,'R');
	$pdf->SetX(87);
	$pdf->Cell(25,0,number_format($row['total_cheques'],2,',','.'),0,1,'R');
	$pdf->SetX(106);
	$pdf->Cell(25,0,number_format($row['total_especiales'],2,',','.'),0,1,'R');
	$pdf->SetX(125);
	$pdf->Cell(25,0,number_format($row['total_cestatikets'],2,',','.'),0,1,'R');
	$pdf->SetX(145);
	$pdf->Cell(25,0,number_format($row['total_omoneda'],2,',','.'),0,1,'R');
	$pdf->SetX(165);
	$pdf->Cell(25,0,number_format($row['total_bonolibro'],2,',','.'),0,1,'R');
	$pdf->SetX(185);
	$pdf->Cell(25,0,number_format($totalmonto,2,',','.'),0,1,'R');

	$totalcierre+=$totalmonto;
}



	$pdf->SetFont('Arial','B',7);
	$pdf->SetY(41+bcmod($i,$cant)*7);
	$pdf->SetX(11);
	$pdf->SetFillColor(255,0,0); 
	$pdf->Cell(50,0,"TOTALES",0,1,'L');


	$pdf->SetFont('Arial','B',7);
	$pdf->SetTextColor(185,1,1,1);
	//$pdf->SetFont('Arial','',6);
	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->Rect(12,43+bcmod($i,$cant)*7,198,6);
	$pdf->SetX(15);
	$pdf->SetFillColor(255,0,0); 
	$pdf->Cell(50,0,$clientes,0,1,'L');	
	$pdf->SetX(20);
	$pdf->Cell(25,0,$ejemplares,0,1,'C');
	$pdf->SetX(20);
	$pdf->Cell(35,0,number_format($tdc,2,',','.'),0,1,'R');
	$pdf->SetX(48);
	$pdf->Cell(25,0,number_format($tdb,2,',','.'),0,1,'R');
	$pdf->SetX(68);
	$pdf->Cell(25,0,number_format($efectivo,2,',','.'),0,0,'R');
	$pdf->SetX(87);
	$pdf->Cell(25,0,number_format($cheques,2,',','.'),0,1,'R');
	$pdf->SetX(106);
	$pdf->Cell(25,0,number_format($especiales,2,',','.'),0,1,'R');
	$pdf->SetX(125);
	$pdf->Cell(25,0,number_format($cesta,2,',','.'),0,1,'R');
	$pdf->SetX(145);
	$pdf->Cell(25,0,number_format($omoneda,2,',','.'),0,1,'R');
	$pdf->SetX(165);
	$pdf->Cell(25,0,number_format($bonolibro,2,',','.'),0,1,'R');
	$pdf->SetX(185);
	$pdf->Cell(25,0,number_format($totalcierre,2,',','.'),0,1,'R');
	$pdf->SetTextColor(0,0,0,0);

//if(!ereg("MSIE",$_SERVER["HTTP_USER_AGENT"]))	
//	$pdf->Output('Fecha de Emisi�n: '.$f,'Hora de Emisi�n: '.$h,'Usuario: '.$usu,'credenciales_activadas.pdf','D');
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
	
.boton {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #C2382B; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}
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


.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 24px;
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
.style5 {color: #FFFFFF}
.tabla{
-moz-border-radius: 5px;
border : 5px solid #CCCCCC;


}

.Estilo1 {
	color: #990000;
	font-weight: bold;
}
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #C2382B; border-color: #FFFFFF; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix; font-weight: bold; }
</style>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="mform" id="mform">
  <p class="Estilo3">REPORTE DE CIERRES DE FACTURACI&Oacute;N</p>
  <table width="333" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla">
<tr>
      <td colspan="4" class="boton"><strong>Periodo: </strong></td>
    </tr> 
<tr>
      <td>Desde:</td>
	<td><input type="text" name="fechad" id="fechad" value="<?php if(!empty($_POST['fechad']))echo $_POST['fechad']; ?>" size="10" readonly="true"><img src="../imagenes/calendar.png" id="trigger1"
     style='cursor: pointer; border: 0px solid red;'
     title='Selector de fecha'
     onmouseover="this.style.background='white';"
     onmouseout="this.style.background=''"/><script type="text/javascript">
  Calendar.setup(
    {
      inputField  : 'fechad',         // ID of the input field
      align          :    'Tr',
      singleClick    :    false,
      ifFormat    : '%d/%m/%Y',    // the date format
      button      : 'trigger1'       // ID of the button
    }
  );
      </script></td>
      <td>Hasta:</td>
      <td><input type="text" name="fechah"  id="fechah" value="<?php if(!empty($_POST['fechah']))echo $_POST['fechah']; ?>" size="10" readonly="true"><img src="../imagenes/calendar.png" id="trigger2"
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
        </script></td>  
</tr>

<tr>
      <td colspan="4" class="boton"><strong>Por Fecha: </strong></td>
</tr>

<tr>
	<td>Fecha:</td>
	<td colspan="3"><input type="text" name="fechab" id="fechab" value="<?php if(!empty($_POST['fechab']))echo $_POST['fechab']; ?>" size="10" readonly="true"><img src="../imagenes/calendar.png" id="trigger3"
     style='cursor: pointer; border: 0px solid red;'
     title='Selector de fecha'
     onmouseover="this.style.background='white';"
     onmouseout="this.style.background=''" />
              <script type="text/javascript">
  Calendar.setup(
    {

	  inputField  : 'fechab',         
      align          :    'Tr',
      singleClick    :    false,
      ifFormat    : '%d/%m/%Y',    
      button      : 'trigger3'     
	  }
	
  );
        </script></td>
</tr>

<tr>
  <td colspan="4" align="right">&nbsp;</td>
</tr>
<tr>
      <td colspan="4" align="right">
	 <input type="submit" value="Consultar" class="boton">
	 <input type="submit" value="Todos" class="boton" onclick="document.mform.fechab.value='todos'">
	 <input type="button" value="Salir" onclick="javascript:window.close(this)" class="boton">      </td>
 </tr>
</table>
</form>