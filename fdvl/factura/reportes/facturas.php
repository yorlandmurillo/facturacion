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
	$this->cell(0,5,'FUNDACION LIBRERIAS DEL SUR',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','B',15);
    //Título
    $this->Cell(0,10,'Reporte de ventas por sucursal',0,0,'C');	
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

$sucursal=$_SESSION['usuario_sucursal'];//$_GET['suc'];
$f=date('d')."/".date('m')."/".date('Y');
$h=date('H').":".date('i');
//$min=date('i');
//$sec=date('s');

$fechadesde=date('Y-m-d')." 00:00:00";
$fechahasta=date('Y-m-d')." 11:59:59";


$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();


$sql="SELECT * FROM tbl_facturas where tbl_facturas.sucursal=$sucursal and tbl_facturas.estatus_factura=3 and tbl_facturas.fecha_factura > '$fechadesde' And tbl_facturas.fecha_factura < '$fechahasta' ORDER BY tbl_facturas.fecha_factura DESC,tbl_facturas.vendedor asc;"; 
$result=$obj->consultar($sql);
$num=mysql_num_rows($result);
$cant=25;
for($i=0;$i<$num && $row=mysql_fetch_assoc($result);$i++){
	if(bcmod($i,$cant)==0){
		$pdf->AddPage('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu);
	  	//Superior Izquierda
    	$pdf->SetFont('Arial','B',12);
    	$pdf->Ln(5);
		$pdf->SetY(13);
		$pdf->SetX(12);
		$pdf->cell(0,5,$ent,0,0,'L');
		$pdf->Line(12,30,210,30);
		$pdf->SetFont('Helvetica','',13);
		$pdf->SetY(35);
		$pdf->SetX(12);
		$pdf->Cell(50,0,"Factura",0,1,'L');
		$pdf->SetX(40);
		$pdf->Cell(25,0,"Fecha Factura",0,1,'C');
		$pdf->SetX(120);
		$pdf->Cell(25,0,"Monto",0,1,'C');
		$pdf->SetX(175);
		$pdf->Cell(25,0,"Efectivo",0,1,'C');

	}
	$pdf->SetFont('Arial','',7);
	$pdf->SetY(43+bcmod($i,$cant)*7);
	$pdf->SetX(12);
	$pdf->Cell(50,0,$row['cod_factura'],0,1,'L');	
	$pdf->SetX(40);
	$pdf->Cell(25,0,$row['fecha_factura'],0,1,'C');
	$pdf->SetX(105);
	$pdf->Cell(25,0,number_format($row['mto_total'],2,',','.'),0,1,'C');
	$pdf->SetX(105);
	$pdf->Cell(25,0,number_format($row['mto_total'],2,',','.'),0,1,'C');
	$pdf->SetX(105);
	$pdf->Cell(25,0,number_format($row['mto_total'],2,',','.'),0,1,'C');
	$pdf->SetX(105);
	$pdf->Cell(25,0,number_format($row['mto_total'],2,',','.'),0,1,'C');
	$pdf->SetX(105);
	$pdf->Cell(25,0,number_format($row['mto_total'],2,',','.'),0,1,'C');
	$pdf->SetX(180);
	$pdf->Cell(25,0,$obj->setuser($row['vendedor']),0,1,'R');

	$totallibrosvendidos+=$row['mto_total'];
	$totalvendido+=$row['mto_total'];
}
	$pdf->SetFont('Arial','',12);
	$pdf->SetY(249);
	$pdf->SetX(150);
	$pdf->Cell(25,0,"Total Vendido:",0,1,'L');
	$pdf->SetY(249);
	$pdf->SetX(185);
	$pdf->Cell(25,0,number_format($totalvendido,2,',','.'),0,1,'C');

//if(!ereg("MSIE",$_SERVER["HTTP_USER_AGENT"]))	
//	$pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu,'credenciales_activadas.pdf','D');
//else
 $pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu);
?>