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
	$this->cell(0,5,'SIGESLIB',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','BI',10);	
	$this->cell(0,5,'version 3.0',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','B',15);
    //Título
    $this->Cell(0,10,'Reporte de libros poca existencia',0,0,'C');	
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
	$this->Cell(0,10,$fecha.'                  '.$hora.'                  '.manejadordb::setuser($_SESSION['usuario_id']),0,0,'L');
    //Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
  }
}
$sucursal=$_SESSION['usuario_sucursal'];

$f=date('d')."/".date('m')."/".date('Y');
$h=date('H').":".date('i');
$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
//and cantidad<6 and tbl_distinventario.descripcion like 'municipio%'
$sql="SELECT tbl_distinventario.cod_producto, tbl_distinventario.descripcion, tbl_distinventario.autor, tbl_distinventario.cod_barra, Sum( tbl_distinventario.cantidad ) AS cantidad FROM tbl_distinventario GROUP BY tbl_distinventario.cod_producto, tbl_distinventario.descripcion, tbl_distinventario.autor, tbl_distinventario.cod_barra, tbl_distinventario.sucursal HAVING (((tbl_distinventario.sucursal) =$sucursal)) ORDER BY cantidad ASC ";
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
		$pdf->Cell(50,0,"Código",0,1,'L');
		$pdf->SetX(39);
		$pdf->Cell(25,0,"Titulo",0,1,'C');
		$pdf->SetX(100);
		$pdf->Cell(25,0,"Editorial",0,1,'C');
		$pdf->SetX(179);
		$pdf->Cell(25,0,"Cantidad",0,1,'C');
		$pdf->SetX(194);
		$pdf->Cell(25,0,"Precio",0,1,'C');
	}
	$pdf->SetFont('Arial','',4);
	$pdf->SetY(42+bcmod($i,$cant)*7);
	$pdf->SetX(12);
	$pdf->Cell(50,0,$row['cod_producto'],0,1,'L');	
	$pdf->SetX(30);
	$pdf->Cell(25,0,manejadordb::seteditorial_remoto($row['cod_producto']),0,70),0,1,'L');
	$pdf->SetX(100);
	$pdf->Cell(35,0,$row['autor'],0,1,'L');
	$pdf->SetX(179);
	$pdf->Cell(25,0,$row['cantidad'],0,1,'C');
	$pdf->SetX(186);
	$pdf->Cell(25,0,number_format(manejadordb::setprecio_remoto($row['cod_producto']),2,',','.'),0,1,'R');
	$totallibros++;
}

	$pdf->SetFont('Arial','',10);

	$pdf->SetY(249);
	$pdf->SetX(150);
	$pdf->Cell(25,0,"Total Libros:",0,1,'L');
	$pdf->SetY(249);
	$pdf->SetX(185);
	$pdf->Cell(25,0,$totallibros,0,1,'C');

//if(!ereg("MSIE",$_SERVER["HTTP_USER_AGENT"]))	
//	$pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu,'credenciales_activadas.pdf','D');
//else
 $pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.manejadordb::setuser($_SESSION['usuario_id']));
?>