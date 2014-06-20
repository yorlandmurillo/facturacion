<?php
require('../fpdf/fpdf.php');
require("../admin/session.php"); // incluir motor de autentificación.
$obj=new manejadordb();

class PDF extends FPDF
{

//Cabecera de página
  function Header(){
    //Superior Derecha
    $this->SetFont('Arial','B',14);
	$this->cell(0,5,'REPORTE WEB DE FACTURACION',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','BI',10);	
	$this->cell(0,5,'REPORTE WEB DE FACTURACION',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','B',15);
    //Título
    $this->Cell(0,10,manejadordb::setsucursal($_SESSION['usuario_sucursal']),0,0,'L');	
	$this->Cell(0,10,'Pre Cierre de Caja: '.manejadordb::setuser($_SESSION['usuario_id']),0,0,'R');	
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
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
  }
}

$fecha=date('Y-m-d');
$sucursal=$_SESSION['usuario_sucursal'];
$vendedor=$_SESSION['usuario_id'];

$f=date('d')."/".date('m')."/".date('Y');
$h=date('H').":".date('i');
//$factura=new factura();

$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();

$sql="SELECT * from tbl_precierrecaja where fecha='$fecha' and cod_sucursal=$sucursal and vendedor=$vendedor";
$result=$obj->consultar($sql);
$num=mysql_num_rows($result);
$cant=30;
for($i=0;$i<$num && $row=mysql_fetch_assoc($result);$i++){
	if(bcmod($i,$cant)==0){
		$pdf->AddPage('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu);
	  	//Superior Izquierda
    	$pdf->SetFont('Arial','B',5);
		$pdf->SetY(7);
		$pdf->SetX(12);
		$pdf->cell(0,5,$min,0,0,'L');
    	$pdf->Ln(5);
		$pdf->SetY(13);
		$pdf->SetX(12);
		$pdf->cell(0,5,$ent,0,0,'L');
		$pdf->Line(12,30,210,30);
		$pdf->SetFont('Helvetica','',8);
		$pdf->SetY(35);
		$pdf->SetX(12);
		$pdf->Cell(50,0,"Clientes",0,1,'L');
		$pdf->SetX(20);
		$pdf->Cell(25,0,"Ejemplares",0,1,'C');
		$pdf->SetX(39);
		$pdf->Cell(25,0,"TDC",0,1,'C');
		$pdf->SetX(60);
		$pdf->Cell(25,0,"TDB",0,1,'C');
		$pdf->SetX(78);
		$pdf->Cell(25,0,"Efectivo",0,1,'C');
		$pdf->SetX(97);
		$pdf->Cell(25,0,"Cheque",0,1,'C');
		$pdf->SetX(117);
		$pdf->Cell(25,0,"Especial",0,1,'C');
		$pdf->SetX(139);
		$pdf->Cell(25,0,"CestaTicket",0,1,'C');
		$pdf->SetX(160);
		$pdf->Cell(25,0,"Otra Moneda",0,1,'C');
		$pdf->SetX(187);
		$pdf->Cell(25,0,"BonoLibro",0,1,'C');


	}
	$pdf->SetFont('Arial','',5);
	$pdf->SetFont('Arial','',5);
	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(12);
	$pdf->Cell(50,0,$row['total_clientes'],0,1,'L');	
	$pdf->SetX(32);
	$pdf->Cell(25,0,$row['total_ejemplares'],0,1,'L');
	$pdf->SetX(25);
	$pdf->Cell(35,0,number_format($row['total_credito'],2,',','.'),0,1,'R');
	$pdf->SetX(55);
	$pdf->Cell(25,0,number_format($row['total_debito'],2,',','.'),0,1,'R');
	$pdf->SetX(75);
	$pdf->Cell(25,0,number_format($row['total_efectivo'],2,',','.'),0,1,'R');
	$pdf->SetX(94);
	$pdf->Cell(25,0,number_format($row['total_cheques'],2,',','.'),0,1,'R');
	$pdf->SetX(114);
	$pdf->Cell(25,0,number_format($row['total_especiales'],2,',','.'),0,1,'R');
	$pdf->SetX(137);
	$pdf->Cell(25,0,number_format($row['total_cestatikets'],2,',','.'),0,1,'R');
	$pdf->SetX(169);
	$pdf->Cell(25,0,number_format($row['total_omoneda'],2,',','.'),0,1,'C');
	$pdf->SetX(193);
	$pdf->Cell(25,0,number_format($row['total_bonolibro'],2,',','.'),0,1,'C');

	$totalmonto=$row['total_credito']+$row['total_debito']+$row['total_efectivo']+$row['total_cheques']+$row['total_especiales']+$row['total_omoneda']+$row['total_bonolibro'];
}
	$pdf->SetY(249);
	$pdf->SetX(150);
	$pdf->Cell(25,0,"Monto Total:",0,1,'L');
	$pdf->SetY(249);
	$pdf->SetX(185);
	$pdf->Cell(25,0,number_format($totalmonto,2,',','.'),0,1,'C');

//if(!ereg("MSIE",$_SERVER["HTTP_USER_AGENT"]))	
//	$pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu,'credenciales_activadas.pdf','D');
//else
 $pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.manejadordb::setuser($_SESSION['usuario_id']));
?>