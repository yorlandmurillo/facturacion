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
//	$this->cell(0,5,'SIGAL',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','BI',10);	
//	$this->cell(0,5,'version 1.0',0,0,'R');
	$this->Image('../imagenes/logogobierno.jpg',12,1,100,13,'');
	$this->Image('../imagenes/logolibsurdoc.jpg',180,1,30,22,'','http://www.libreriasdelsur.gob.ve');
    $this->Ln(5);
    $this->SetFont('Arial','B',13);
    //Título
	$this->Cell(0,0,'DOCUMENTO DE DISTRIBUCION',0,0,'L');
    $this->Ln(6);
	    $this->SetFont('Arial','',13);
    $this->Cell(0,0,'Fundación Librerías del Sur',0,0,'L');	
    $this->SetFont('Arial','B',10);
	$this->Cell(5,0,'Nº DE TRASLADO:'.$_GET['codigol'],0,0,'R');	

    $this->Ln(8);
	
  }
  //Pie de página 
  function Footer($fecha='',$hora='',$usuario='')
  {
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial Negrita 8
    $this->SetFont('Arial','',8);
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

$h=cambiahraanormal(date('H')).":".date('i')." ".date('a');

$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();

$sql="SELECT tbl_traslados.cod_traslado AS codigo, tbl_itemtraslado.cod_l AS libro, tbl_itemtraslado.titulo AS titulo, tbl_itemtraslado.editorial AS editorial, tbl_itemtraslado.precio AS precio, tbl_itemtraslado.sucursal AS sucursal, tbl_itemtraslado.cantidad AS cantidad, tbl_itemtraslado.condicion AS condicion, tbl_itemtraslado.solicitud, tbl_traslados.incluidopor, tbl_traslados.fechainclusion, tbl_traslados.estatus, tbl_traslados.observaciones FROM tbl_traslados INNER JOIN tbl_itemtraslado ON tbl_traslados.cod_traslado = tbl_itemtraslado.cod_t WHERE (((tbl_traslados.cod_traslado)='".$_GET['codigol']."')) ORDER BY tbl_itemtraslado.sucursal;";

$result=$obj->consultar($sql);
$num=mysql_num_rows($result);
$cant=35;

for($i=0;$i<$num && $row=mysql_fetch_assoc($result);$i++){
	if(bcmod($i,$cant)==0){
		
		$pdf->AddPage('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$obj->setuser($_SESSION['usuario_id']));

	if($i<$cant){
	$y=107; 	
    $pdf->SetFont('Arial','B',10);
	$pdf->MultiCell(200,4,'ORIGEN: '.'Fundación Librerías del Sur Calle Hípica con Av. La Guairita, Edif. Fundación Librerías del Sur PB Apto. U, Las Mercedes, Caracas/Venezuela');	
    $pdf->Ln(5);
	$pdf->Cell(5,0,'DESTINO: '.'['.$obj->setsucursal($obj->getattrtraslado($_GET['codigol'],"sucursal")).']',0,0,'L');	
    $pdf->Ln(7);
	$pdf->Cell(5,0,'Nº DE SOLICITUD: '.'['.$obj->getattrtraslado($_GET['codigol'],"solicitud").']',0,0,'L');	
	$pdf->SetX(82);
	$pdf->Cell(5,0,'ESTATUS DEL DESPACHO: '.'['.$obj->setestatus($obj->getattrtraslado($_GET['codigol'],"estatus")).']',0,0,'L');	
	$pdf->Ln(7);
	$pdf->Cell(5,0,'ELABORADO POR: '.'['.$obj->setuser($obj->getattrtraslado($_GET['codigol'],"incluidopor")).']',0,0,'L');	
	$pdf->SetX(75);
	$pdf->Cell(5,0,'FECHA ELABORACION: '.'['.cambiafanormal($obj->getattrtraslado($_GET['codigol'],"fechainclusion")).']',0,0,'L');	
	$pdf->SetX(139);
	$pdf->Cell(5,0,'FECHA RECEPCION: '.'[_______________]',0,0,'L');	
	$pdf->Ln(7);
	$pdf->MultiCell(200,4,'OBSERVACIONES: '.'['.$obj->getattrtraslado($_GET['codigol'],"observaciones").']');	
	}else $y=46;
	
		//
		$pdf->Line(10,30,212,30);
		$pdf->SetFont('Helvetica','',8);
		$pdf->SetY($y-8);
		$pdf->SetX(12);
		$pdf->Cell(12,5,"Nº",1,0,'C');
		$pdf->SetX(24);
		$pdf->Cell(18,5,"CODIGO",1,0,'L');
		$pdf->SetX(42);
		$pdf->Cell(111,5,"TITULO",1,0,'C');
		$pdf->SetX(153);
		$pdf->Cell(15,5,"CANT.",1,0,'C');
		$pdf->SetX(168);
		$pdf->Cell(20,5,"PRECIO",1,0,'C');
		$pdf->SetX(188);
		$pdf->Cell(20,5,"TOTAL Bs.F",1,0,'C');

	}
	$pdf->SetFont('Arial','',6);
	$pdf->SetY($y+bcmod($i,$cant)*4);
	$pdf->SetX(12);
	$pdf->Cell(12,0,$i+1,0,1,'L');	
	$pdf->SetX(24);
	$pdf->Cell(50,0,$row['libro'],0,1,'L');	
	$pdf->SetX(42);

	if(strlen(strlen($row['titulo'])>82)){
	$pts="...";
	}else $pts="";

	$pdf->Cell(25,0,substr($row['titulo'],0,82).$pts,0,1,'L');
	$pdf->SetX(143);
	$pdf->Cell(35,0,$row['cantidad'],0,1,'C');
	$pdf->SetX(163);
	$pdf->Cell(25,0,number_format($row['precio'],2,',','.'),0,1,'R');
	$pdf->SetX(183);
	$pdf->Cell(25,0,number_format($row['precio']*$row['cantidad'],2,',','.'),0,1,'R');

	$totalmonto+=$row['precio']*$row['cantidad'];
	$totallib+=$row['cantidad'];
}
    $pdf->SetFont('Arial','B',6);
	$pdf->SetY($y+bcmod($i,$cant)*5);
	$pdf->SetX(132);
	$pdf->Cell(25,0,"TOTAL CANTIDAD: ",0,1,'L');
	$pdf->SetY($y+bcmod($i,$cant)*5);
	$pdf->SetX(148);
	$pdf->Cell(25,0,$totallib,0,1,'C');
	$pdf->SetY($y+bcmod($i,$cant)*5);
	$pdf->SetX(175);
	$pdf->Cell(25,0,"TOTAL BS.F: ",0,1,'L');
	$pdf->SetY($y+bcmod($i,$cant)*5);
	$pdf->SetX(183);
	$pdf->Cell(25,0,number_format($totalmonto,2,',','.'),0,1,'R');

    $pdf->SetFont('Arial','B',10);
	$pdf->SetY($y+bcmod($i,$cant)*5);
	$pdf->Ln(15);
	$pdf->Ln(15);
    $pdf->SetFont('Arial','B',10);
	$pdf->SetX(90);
	$pdf->Cell(35,5,'Dpto. de Compras','T',0,'C');	



 $pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$obj->setuser($_SESSION['usuario_id']));
?>