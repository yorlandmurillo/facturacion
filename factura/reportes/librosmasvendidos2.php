<?
require('../fpdf/fpdf.php');
require("../admin/session.php"); // incluir motor de autentificación.
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
    $this->Cell(0,10,'Reporte de libros vendidos',0,0,'C');	
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
$f=date('d')."/".date('m')."/".date('Y');
$h=date('H').":".date('i');

$pdf=new PDF('L','mm','letter');
$pdf->AliasNbPages();
$fechaa=date('Y-m-d')." 00:00:00";//"2007-11-09 00:00:00";
$sucursal=$_SESSION['usuario_sucursal'];
//$sql="SELECT tbl_itemfactura.cod_producto, tbl_itemfactura.descripcion, Sum(tbl_itemfactura.cantidad) AS cantidad FROM tbl_itemfactura WHERE (((tbl_itemfactura.sucursal)=64)) GROUP BY tbl_itemfactura.cod_producto, tbl_itemfactura.descripcion ORDER BY Sum(tbl_itemfactura.cantidad) DESC;";
//$sql="SELECT tbl_itemfactura.cod_producto, tbl_itemfactura.descripcion, Sum(tbl_itemfactura.cantidad) AS cantidad FROM tbl_facturas INNER JOIN tbl_itemfactura ON tbl_facturas.cod_factura = tbl_itemfactura.cod_factura WHERE (((tbl_itemfactura.sucursal)=64) AND ((tbl_facturas.fecha_factura)>'$fechaa')) GROUP BY tbl_itemfactura.cod_producto, tbl_itemfactura.descripcion ORDER BY Sum(tbl_itemfactura.cantidad) DESC; "; 

$sql="SELECT tbl_itemfactura.cod_producto, tbl_itemfactura.descripcion, Sum(tbl_itemfactura.cantidad) AS cantidad FROM tbl_facturas INNER JOIN tbl_itemfactura ON tbl_facturas.cod_factura = tbl_itemfactura.cod_factura  FROM tbl_facturas WHERE (((tbl_facturas.sucursal)='$sucursal') AND ((tbl_facturas.estatus_factura)=3) AND ((tbl_facturas.fecha_factura) Between '$fechadesde' And '$fechahasta')) ";
$result=$obj->consultar($sql);
$num=mysql_num_rows($result);
$cant=20;
$record=10;
$contador=0;
for($i=0;$i<$num && $row=mysql_fetch_assoc($result);$i++){
	if(bcmod($i,$cant)==0){
		$pdf->AddPage('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.manejadordb::setuser($_SESSION['usuario_id']));
	  	//Superior Izquierda
    	
    	$pdf->Ln(5);
		$pdf->SetY(13);
		$pdf->SetX(12);
		$pdf->cell(0,5,$ent,0,0,'L');
		$pdf->Line(12,30,210,30);
		$pdf->SetFont('Helvetica','',13);
		$pdf->SetY(35);
		$pdf->SetX(12);
		$pdf->Cell(50,0,"Codigo",0,1,'L');
		$pdf->SetX(39);
		$pdf->Cell(25,0,"Descripción",0,1,'C');
		$pdf->SetX(150);
		$pdf->Cell(25,0,"Autor",0,1,'C');
		$pdf->SetX(242);
		$pdf->Cell(25,0,"Vendidos",0,1,'C');
	}

	$pdf->SetFont('Arial','',8);
	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(12);
	if($contador++<$record){
	$pdf->SetFont('Arial','U',8);
//	$pdf->SetTextColor(144,30,30);
	$pdf->Cell(20,0,$row['cod_producto'],0,1,'L');	
	$pdf->SetX(38);
	
	if(strlen($row['descripcion'])>60){
	$pts="...";
	}else $pts="";	

	$pdf->Cell(0,1,substr($row['descripcion'],0,60).$pts,0,1,'L');
	$pdf->SetX(240);
	$pdf->Cell(25,0,$row['cantidad'],0,1,'R');
//   	$pdf->Line(30,30,30,30);
	}else{
	

	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50,0,$row['cod_producto'],0,1,'L');	
	$pdf->SetX(40);
	$pdf->Cell(25,0,$row['fecha_factura'],0,1,'C');
	$pdf->SetX(38);
	if(strlen($row['descripcion'])>60){
	$pts="...";
	}else $pts="";	

	$pdf->Cell(0,0,substr($row['descripcion'],0,60).$pts,0,1,'L');
	$pdf->SetX(240);
	$pdf->Cell(25,0,$row['cantidad'],0,1,'R');
	}

	$totalvendido+=$row['cantidad'];
	
	$pdf->SetX(155);
	$pdf->Cell(0,0,substr(manejadordb::getautor_remoto($row['cod_producto']),0,52),0,1,'L');

	}	

	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(150);
	$pdf->Cell(25,0,"Total Vendidos:",0,1,'L');
	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(285);
	$pdf->Cell(25,0,$totalvendido,0,1,'C');

//if(!ereg("MSIE",$_SERVER["HTTP_USER_AGENT"]))	
//	$pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu,'credenciales_activadas.pdf','D');
//else
 $pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.manejadordb::setuser($_SESSION['usuario_id']));
?>