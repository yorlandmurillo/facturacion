<?php
require('../fpdf/fpdf.php');
require("../admin/session.php"); // incluir motor de autentificación.
require("../clases/calculo.php"); // incluir motor de autentificación.

$calculo=new calculo();
$calculo->cerrardia($_SESSION['usuario_id'],$_SESSION['usuario_sucursal']);
$obj=new manejadordb();

class PDF extends FPDF
{

//Cabecera de página
  function Header(){
    //Superior Derecha
    $this->SetFont('Arial','B',14);
	$this->cell(0,5,'SIGAL',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','BI',10);	
	$this->cell(0,5,'version 1.0',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','B',15);
    //Título
    $this->Cell(1,10,manejadordb::setsucursal($_SESSION['usuario_sucursal']),0,0,'L');	
	if(isset($_POST['fechab']) && !empty($_POST['fechab'])){
	$this->Cell(0,10,'Fecha: '.date('d/m/Y'),0,0,'C');	
	}
	$this->Cell(0,10,'Así Vamos',0,0,'R');	
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

$sql="SELECT * from tbl_cierre where cod_sucursal=$sucursal and estatus=6 and fecha='$fecha'";

$result=$obj->consultar($sql);
$num=mysql_num_rows($result);
$cant=30;
for($i=0;$i<$num && $row=mysql_fetch_assoc($result);$i++){
	if(bcmod($i,$cant)==0){
		$pdf->AddPage('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu);
	  	//Superior Izquierda
    	
    	$pdf->Ln(5);
		$pdf->SetY(13);
		$pdf->SetX(12);
		$pdf->cell(0,5,$ent,0,0,'L');
		$pdf->Line(12,30,210,30);
		$pdf->SetFont('Helvetica','',8);
		$pdf->SetY(35);
		$pdf->SetX(12);
		$pdf->Rect(12,30,198,8);
		$pdf->Cell(50,0,"Clientes",0,1,'L');
		$pdf->SetX(20);
		$pdf->Cell(25,0,"Ejemplares",0,1,'C');
		$pdf->SetX(39);
		$pdf->Cell(25,0,"TDC",0,1,'C');
		$pdf->SetX(60);
		$pdf->Cell(25,0,"TDB",0,1,'C');
		$pdf->SetX(75);
		$pdf->Cell(25,0,"Efectivo",0,1,'C');
		$pdf->SetX(90);
		$pdf->Cell(25,0,"Cheque",0,1,'C');
		$pdf->SetX(110);
		$pdf->Cell(25,0,"Especial",0,1,'C');
		$pdf->SetX(139);
		$pdf->Cell(25,0,"CestaTicket",0,1,'C');
		$pdf->SetX(160);
		$pdf->Cell(25,0,"Otra Moneda",0,1,'C');
		$pdf->SetX(187);
		$pdf->Cell(25,0,"BonoLibro",0,1,'C');


	}
	$pdf->SetFont('Arial','',6);
	$pdf->SetFont('Arial','',6);
	$pdf->SetY(42+bcmod($i,$cant)*7);
	$pdf->Rect(12,39+bcmod($i,$cant)*7,198,6);
	$pdf->SetX(15);
	$pdf->Cell(50,0,$row['total_clientes'],0,1,'L');	
	$pdf->SetX(20);
	$pdf->Cell(25,0,$row['total_ejemplares'],0,1,'C');
	$pdf->SetX(22);
	$pdf->Cell(35,0,number_format($row['total_credito'],2,',','.'),0,1,'R');
	$pdf->SetX(52);
	$pdf->Cell(25,0,number_format($row['total_debito'],2,',','.'),0,1,'R');
	$pdf->SetX(70);
	$pdf->Cell(25,0,number_format($row['total_efectivo'],2,',','.'),0,0,'R');
	$pdf->SetX(88);
	$pdf->Cell(25,0,number_format($row['total_cheques'],2,',','.'),0,1,'R');
	$pdf->SetX(108);
	$pdf->Cell(25,0,number_format($row['total_especiales'],2,',','.'),0,1,'R');
	$pdf->SetX(137);
	$pdf->Cell(25,0,number_format($row['total_cestatikets'],2,',','.'),0,1,'R');
	$pdf->SetX(157);
	$pdf->Cell(25,0,number_format($row['total_omoneda'],2,',','.'),0,1,'R');
	$pdf->SetX(183);
	$pdf->Cell(25,0,number_format($row['total_bonolibro'],2,',','.'),0,1,'R');

	$totalmonto=$row['total_credito']+$row['total_debito']+$row['total_efectivo']+$row['total_cheques']+$row['total_especiales']+$row['total_omoneda']+$row['total_bonolibro'];
	$totalcierre+=$totalmonto;
}
	$pdf->SetFont('Arial','U',10);
	$pdf->SetY(42+bcmod($i,$cant)*7);
	$pdf->SetX(150);
	$pdf->Cell(25,0,"Monto Total:",0,1,'L');
	$pdf->SetY(42+bcmod($i,$cant)*7);
	$pdf->SetX(183);
	$pdf->Cell(25,0,number_format($totalcierre,2,',','.'),0,1,'R');

//if(!ereg("MSIE",$_SERVER["HTTP_USER_AGENT"]))	
//	$pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu,'credenciales_activadas.pdf','D');
//else
 $pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.manejadordb::setuser($_SESSION['usuario_id']));
?>