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
$sql="SELECT tbl_traslados.cod_traslado, tbl_itemtraslado.cod_l, tbl_itemtraslado.titulo, tbl_itemtraslado.autor, tbl_itemtraslado.cantidad, tbl_itemtraslado.sucursal, tbl_traslados.estatus, tbl_traslados.fechainclusion FROM tbl_traslados INNER JOIN tbl_itemtraslado ON tbl_traslados.cod_traslado=tbl_itemtraslado.cod_t WHERE (((tbl_itemtraslado.sucursal)=64) AND ((tbl_traslados.estatus)=8));"; 
$result=$obj->consultar($sql);
$num=mysql_num_rows($result);
$cant=25;

$cont=0;
$total=0;
for($i=0;$i<$num+$cont && $row=mysql_fetch_assoc($result);$i++){
	if(bcmod($i,$cant)==0){
		$pdf->AddPage('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu);
	  	//Superior Izquierda
    	$pdf->SetFont('Arial','B',12);
		$pdf->SetY(7);
		$pdf->SetX(12);
		$pdf->cell(0,5,$min,0,0,'L');
    	$pdf->Ln(5);
		$pdf->SetY(13);
		$pdf->SetX(12);
		$pdf->cell(0,5,$ent."- Departamento:".$dep."- Cargo:".$car,0,0,'L');
		$pdf->SetY(19);
		$pdf->SetX(12);
		$pdf->cell(0,5,mysql_result($b->getresult(),$i-$cont,"rif"),0,0,'L');
		$pdf->Line(12,30,267,30);
		$pdf->SetFont('Helvetica','',13);
		$pdf->SetY(35);
		$pdf->SetX(12);
		$pdf->Cell(50,0,"Código",0,1,'L');
		$pdf->SetX(32);
		$pdf->Cell(50,0,"Nombre",0,1,'L');
		$pdf->SetX(102);
		$pdf->Cell(80,0,"Afiliado",0,1,'L');
		$pdf->SetX(137);
		$pdf->Cell(25,0,"Fecha",0,1,'C');
		$pdf->SetX(162);
		$pdf->Cell(25,0,"ISBN",0,1,'C');
		$pdf->SetX(242);
		$pdf->Cell(25,0,"Compra",0,1,'C');
	}
	$pdf->SetFont('Arial','BUI',11);
	if(bcmod($i,$cant)<$cant-1)
    if($entidad!=mysql_result($b->getresult(),$i-$cont,"nombre_corto")){
		$entidad=mysql_result($b->getresult(),$i-$cont,"nombre_corto");
		//muestra la entidad
		$pdf->SetY(47+bcmod($i,$cant)*7);
		$pdf->SetX(12);
		$pdf->Cell(50,0,$entidad,0,1,'L');
		$departamento="-1";
		$cargo="-1";	
		$i++;$cont++;
	}
	if(bcmod($i,$cant)<$cant-1)
	if($departamento!=mysql_result($b->getresult(),$i-$cont,4)){
		//muestra el siguiente departamento
		$departamento=mysql_result($b->getresult(),$i-$cont,4);
		$pdf->SetY(47+bcmod($i,$cant)*7);
		$pdf->SetX(12);
		$pdf->Cell(50,0,"Departamento:",0,1,'L');
		$pdf->SetX(62);
		$pdf->Cell(50,0,$departamento,0,1,'L');
		$i++;$cont++;
	}
	if(bcmod($i,$cant)<$cant-1)
	if($cargo!=mysql_result($b->getresult(),$i-$cont,3)){
		//muestra el siguiente cargo
		$cargo=mysql_result($b->getresult(),$i-$cont,3);
		$pdf->SetY(47+bcmod($i,$cant)*7);
		$pdf->SetX(12);
		$pdf->Cell(50,0,"Cargo:",0,1,'L');
		$pdf->SetX(62);
		$pdf->Cell(50,0,$cargo,0,1,'L');
		$i++;$cont++;
	}
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(12);
	$pdf->Cell(50,0,mysql_result($b->getresult(),$i-$cont,"ci"),0,1,'L');	
	$pdf->SetX(32);
	$pdf->Cell(50,0,mysql_result($b->getresult(),$i-$cont,"nombres")." ".mysql_result($b->getresult(),$i-$cont,"apellidos"),0,1,'L');	
	$pdf->SetX(137);
	$fv=mysql_result($b->getresult(),$i-$cont,"fecha");
	$fechaasignacion=$fv[8].$fv[9]."-".$fv[5].$fv[6]."-".$fv[0].$fv[1].$fv[2].$fv[3];
	$pdf->Cell(25,0,$fechaasignacion,0,1,'C');	
	$pdf->SetX(242);
	$pdf->Cell(25,0,mysql_result($b->getresult(),$i-$cont,"monto"),0,1,'C');
	$total+=mysql_result($b->getresult(),$i-$cont,"monto");
	$pdf->SetFont('Arial','',8);
	$pdf->SetX(102);
	$afiliado=mysql_result($b->getresult(),$i-$cont,"razon_social");
	$af1="";
	$af2="";
	for($j=0;$j<strlen($afiliado);$j++){
		if($j<22) $af1.=$afiliado[$j];
		else $af2.=$afiliado[$j];
	}
	if($af2!=""){
		$pdf->SetY(45+bcmod($i,$cant)*7);
		$pdf->SetX(102);
		$pdf->Cell(50,0,$af1,0,1,'L');
		$pdf->SetY(49+bcmod($i,$cant)*7);
		$pdf->SetX(102);
		$pdf->Cell(50,0,$af2,0,1,'L');
	}else{
		$pdf->Cell(50,0,$af1,0,1,'L');
	}
	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(162);
	$observacion=mysql_result($b->getresult(),$i-$cont,"Observacion");
	$ob1="";
	$ob2="";
	for($j=0;$j<strlen($observacion);$j++){
		if($j<50) $ob1.=$observacion[$j];
		else $ob2.=$observacion[$j];
	}
	if($ob2!=""){
		$pdf->SetY(45+bcmod($i,$cant)*7);
		$pdf->SetX(162);
		$pdf->Cell(50,0,$ob1,0,1,'L');
		$pdf->SetY(49+bcmod($i,$cant)*7);
		$pdf->SetX(162);
		$pdf->Cell(50,0,$ob2,0,1,'L');
	}else{
		$pdf->Cell(50,0,$ob1,0,1,'L');
	}
}
$pdf->SetFont('Arial','',11);
$pdf->SetY(47+bcmod($i,$cant)*7);
$pdf->SetX(222);
$pdf->Cell(40,0,"Total:".$total,0,1,'R');
$pdf->SetY(48+bcmod($i-1,$cant)*7);
$pdf->SetX(242);
$pdf->Cell(25,0,"________________",0,1,'C');




/*for($i=0;$i<$num && $row=mysql_fetch_assoc($result);$i++){
	if(bcmod($i,$cant)==0){
		$pdf->AddPage('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu);
	  	//Superior Izquierda
    	$pdf->SetFont('Arial','B',12);
		$pdf->SetY(7);
		$pdf->SetX(12);
		$pdf->cell(0,5,$min,0,0,'L');
    	$pdf->Ln(5);
		$pdf->SetY(13);
		$pdf->SetX(12);
		$pdf->cell(0,5,$ent,0,0,'L');
		$pdf->Line(12,30,210,30);
		$pdf->SetFont('Helvetica','',13);
		$pdf->SetY(35);
		$pdf->SetX(12);
		$pdf->Cell(50,0,"Factura",0,1,'L');
		$pdf->SetX(39);
		$pdf->Cell(25,0,"Fecha",0,1,'C');
		$pdf->SetX(80);
		$pdf->Cell(25,0,"Sucursal",0,1,'C');
		$pdf->SetX(125);
		$pdf->Cell(25,0,"Vendedor",0,1,'C');
		$pdf->SetX(155);
		$pdf->Cell(25,0,"Monto",0,1,'C');
		$pdf->SetX(187);
		$pdf->Cell(25,0,"Estatus",0,1,'C');
	}
	$pdf->SetFont('Arial','',9);
	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(12);
	$pdf->Cell(50,0,$row['cod_factura'],0,1,'L');	
	$pdf->SetX(40);
	$pdf->Cell(25,0,$row['fecha_factura'],0,1,'C');
	$pdf->SetX(80);
	$pdf->Cell(25,0,$obj->setsucursal($row['sucursal']),0,1,'C');
	$pdf->SetX(125);
	$pdf->Cell(25,0,$obj->setuser($row['vendedor']),0,1,'C');
	$pdf->SetX(155);
	$pdf->Cell(25,0,number_format($row['mto_total'],2,',','.'),0,1,'C');
	$pdf->SetX(187);
	$pdf->Cell(25,0,$obj->setestatus($row['estatus_factura']),0,1,'C');
	$totalvendido+=$row['mto_total'];
	$totalatendidos++;

}
	$pdf->SetFont('Arial','',12);
	$pdf->SetY(249);
	$pdf->SetX(150);
	$pdf->Cell(25,0,"Total Vendido:",0,1,'L');
	$pdf->SetY(249);
	$pdf->SetX(185);
	$pdf->Cell(25,0,number_format($totalvendido,2,',','.'),0,1,'C');
*/
//if(!ereg("MSIE",$_SERVER["HTTP_USER_AGENT"]))	
//	$pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu,'credenciales_activadas.pdf','D');
//else
 $pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu);
?>