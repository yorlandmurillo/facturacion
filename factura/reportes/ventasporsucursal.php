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
    $this->Cell(1,10,manejadordb::setsucursal($_POST['sucursal']),0,0,'L');	
    $this->Cell(0,10,'REPORTE DE VENTAS POR EDITORIAL',0,0,'R');	
    //$this->Cell(0,10,'Fecha: '.$_POST['fechab'],0,0,'R');
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

if(isset($_POST['sucursal']) && !empty($_POST['sucursal'])){
$sucursal=$_POST['sucursal'];//$_GET['suc'];
$f=date('d')."/".date('m')."/".date('Y');
$h=date('H').":".date('i');
//$min=date('i');
//$sec=date('s');
//$date=cambiafamysql($_POST['fechab']);//date('Y-m-d');
//$fechadesde=$date." 00:00:00";
//$fechahasta=$date." 23:59:59";

$pdf=new PDF('L','mm','letter');
$pdf->AliasNbPages();



$sql="SELECT tbl_itemfactura.cod_producto, tbl_itemfactura.descripcion, Sum(tbl_itemfactura.cantidad) AS cantidad, 
tbl_inventario.precio,tbl_itemfactura.precio_unid, tbl_itemfactura.descuento, tbl_inventario.costo, tbl_editorial.editorial
FROM tbl_facturas INNER JOIN ((tbl_itemfactura INNER JOIN tbl_inventario ON tbl_itemfactura.cod_producto = tbl_inventario.cod_producto) 
INNER JOIN tbl_editorial ON tbl_inventario.editorial = tbl_editorial.id_editorial) ON tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
WHERE (((tbl_itemfactura.sucursal)=$sucursal) AND ((tbl_facturas.estatus_factura)=3) ";

if(isset($_POST['editorial']) && !empty($_POST['editorial'])!=0){
$sql.=" AND ((tbl_inventario.editorial)=".$_POST['editorial'].")) GROUP BY tbl_itemfactura.cod_producto, tbl_itemfactura.descripcion, tbl_inventario.precio, tbl_itemfactura.precio_unid,tbl_itemfactura.descuento, tbl_inventario.costo, tbl_editorial.editorial ORDER BY tbl_editorial.editorial;"; 

}else {
$sql.=" ) GROUP BY tbl_itemfactura.cod_producto, tbl_itemfactura.descripcion, tbl_inventario.precio, tbl_itemfactura.precio_unid,tbl_itemfactura.descuento, tbl_inventario.costo, tbl_editorial.editorial ORDER BY tbl_editorial.editorial;"; 

}


//
//	$sql.="  ";
//}else{
//$sql.=" )";
//}

//sql.=" ";




$result=$obj->consultar($sql);
$num=mysql_num_rows($result);
$cant=18;
$cont=0;
$total=0;
$descuento=0;
$vendido=0;
for($i=0;$i<$num+$cont && $row=mysql_fetch_assoc($result);$i++){
//	$cantidad=0;

/*	$canttotal+=$row['cantidad'];
	$especial+=$row['pago_especial'];
	$omoneda+=$row['otra_moneda'];
	$cesta+=$row['cesta_ticket'];
	$cheque+=$row['cheque'];
	$tdb+=$row['tdb'];
	$tdc+=$row['tdc'];
	$bl+=$row['bl'];*/





	if(bcmod($i,$cant)==0){
		$pdf->AddPage('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.manejadordb::setuser($_SESSION['usuario_id']));
	  	//Superior Izquierda
    		$pdf->SetFont('Arial','B',9);
		$pdf->Ln(5);
		$pdf->Line(12,30,210,30);
		$pdf->SetFont('Helvetica','',9);
		$pdf->SetY(35);
		$pdf->SetX(12);
		$pdf->Cell(50,0,"CODIGO",0,1,'L');
		$pdf->SetX(27);
		$pdf->Cell(25,0,"TITULO",0,1,'C');
		$pdf->SetX(93);
		$pdf->Cell(25,0,"CANT.",0,1,'C');
/*		$pdf->SetX(111);
		$pdf->Cell(25,0,"PRECIO",0,1,'C');*/
		$pdf->SetX(134);
		$pdf->Cell(25,0,"PVP",0,1,'C');
/*		$pdf->SetX(147);
		$pdf->Cell(25,0,"%DESC.",0,1,'C');*/
/*		$pdf->SetX(168);
		$pdf->Cell(25,0,"DESCUENTO",0,1,'C');*/
/*		$pdf->SetX(190);
		$pdf->Cell(25,0,"COSTO",0,1,'C');*/
		$pdf->SetX(215);
		$pdf->Cell(25,0,"TOTAL VENDIDO",0,1,'C');
	/*	$pdf->SetX(245);
		$pdf->Cell(25,0,"TOTAL COSTO",0,1,'C');*/

	}

	

	
	if(bcmod($i,$cant)<$cant-1){


	/*$descuento=(($row['precio'])*($row['descuento']*100)/100)*$row['cantidad'];
	if(($row['descuento']*100)==10){
	$vendido=$row['precio_unid']*$row['cantidad'];
	
	}elseif(($row['descuento']*100)==20){
	$vendido=($row['precio_unid']*$row['cantidad'])+($descuento/2);
	$cantidad+=$row['cantidad'];
	$totalvendido+=$vendido;
	
	}else{
	$vendido=$row['precio']*$row['cantidad'];
	$cantidad+=$row['cantidad'];
	$totalvendido+=$vendido;
	
	}*/

	
	

	if($edit!=strtoupper($row['editorial'])){
//	$montovendido=0;
	$vendido+=$row['precio_unid']*$row['cantidad'];
	
		//muestra el siguiente usuario
		$edit=strtoupper($row['editorial']);
		$pdf->SetY(40+bcmod($i,$cant)*7);
		$pdf->SetFont('Arial','',7);
		$pdf->SetX(12);
		$pdf->Cell(15,5,"EDITORIAL:",1,1,'L');
		$pdf->SetY(40+bcmod($i,$cant)*7);
		$pdf->SetX(27);
		$pdf->Cell(243,5,$edit,1,1,'L');
		$pdf->SetY(43+bcmod($i,$cant)*7);
		$pdf->SetX(92);
		$pdf->Cell(16,0,$cantidad,0,1,'R');
		$pdf->SetX(114);
		//$pdf->Cell(16,0,number_format($montoprecio+=,2,',','.'),0,1,'R');
		$pdf->Cell(16,0,"",0,1,'R');
	/*	$pdf->SetX(134);
		$pdf->Cell(16,0,number_format($montopvp,2,',','.'),0,1,'R');*/
/*		$pdf->SetX(176);
		$pdf->Cell(16,0,number_format($montodescuento,2,',','.'),0,1,'R');
		$pdf->SetX(194);
		$pdf->Cell(16,0,number_format($costolibro,2,',','.'),0,1,'R');*/
		/*$pdf->SetX(225);
		$pdf->Cell(16,0,number_format($vendido,2,',','.'),0,1,'R');*/
/*		$pdf->SetX(254);
		$pdf->Cell(16,0,number_format($montocosto,2,',','.'),0,1,'R');*/
		$i++;
		$cont++;
		
	}
	}
	
	
	$pdf->SetFont('Arial','',6);
	$pdf->SetY(42+bcmod($i,$cant)*7);
	$pdf->SetX(12);
	$pdf->Cell(50,0,$row['cod_producto'],0,1,'L');	
	$pdf->SetX(33);
	$pdf->Cell(95,0,substr($row['descripcion'],0,50),0,1,'L');
	$pdf->SetX(94);
	$pdf->Cell(25,0,$row['cantidad'],0,1,'C');
/*	$pdf->SetX(105);
	$pdf->Cell(25,0,number_format($row['precio'],2,',','.'),0,1,'R');*/
	$pdf->SetX(125);
	$pdf->Cell(25,0,number_format($row['precio_unid'],2,',','.'),0,1,'R');
/*	$pdf->SetX(148);
	$pdf->Cell(25,0,$row['descuento']*100,0,1,'C');
	$pdf->SetX(167);
	$pdf->Cell(25,0,number_format($descuento,2,',','.'),0,1,'R');
	$pdf->SetX(185);
	$pdf->Cell(25,0,number_format($row['costo'],2,',','.'),0,1,'R');*/
	$pdf->SetX(216);
	$pdf->Cell(25,0,number_format($row['precio_unid']*$row['cantidad'],2,',','.'),0,1,'R');
/*	$pdf->SetX(245);
	$pdf->Cell(25,0,number_format($row['costo']*$row['cantidad'],2,',','.'),0,1,'R');*/

}


/*	$pdf->SetFont('Arial','UB',6);
	$pdf->SetY(53+bcmod($i,$cant)*7);
	$pdf->SetX(30);
	$pdf->Cell(25,0,"SUB TOTALES:",0,1,'L');
	$pdf->SetX(50);
	$pdf->Cell(25,0,number_format($efectivo,2,',','.'),0,1,'R');
	$pdf->SetX(67);
	$pdf->Cell(25,0,number_format($cheque,2,',','.'),0,1,'R');
	$pdf->SetX(85);
	$pdf->Cell(25,0,number_format($tdb,2,',','.'),0,1,'R');
	$pdf->SetX(102);
	$pdf->Cell(25,0,number_format($tdc,2,',','.'),0,1,'R');
	$pdf->SetX(117);
	$pdf->Cell(25,0,number_format($bl,2,',','.'),0,1,'R');
	$pdf->SetX(132);
	$pdf->Cell(25,0,number_format($cesta,2,',','.'),0,1,'R');
	$pdf->SetX(147);
	$pdf->Cell(25,0,number_format($especial,2,',','.'),0,1,'R');
	$pdf->SetX(166);
	$pdf->Cell(25,0,number_format($omoneda,2,',','.'),0,1,'R');
	

	$pdf->SetFont('Arial','',12);
	$pdf->SetY(58+bcmod($i,$cant)*7);
	$pdf->SetX(150);
	$pdf->Cell(25,0,"Total Vendido:",0,1,'L');
	$pdf->SetY(58+bcmod($i,$cant)*7);
	$pdf->SetX(183);
	$pdf->Cell(25,0,number_format($totalvendido,2,',','.'),0,1,'C');*/

//if(!ereg("MSIE",$_SERVER["HTTP_USER_AGENT"]))	
//	$pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.$usu,'credenciales_activadas.pdf','D');
//else
 $pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.manejadordb::setuser($_SESSION['usuario_id']));
}
?>
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
.Estilo1 {color: #990000}
.tabla{
-moz-border-radius: 5px;
border : 5px solid #CCCCCC;

}

</style>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="mform" id="mform">
  <table width="400" border="0" cellpadding="0" cellspacing="0" class="buscarTable">
    <tr>
      <td><strong>Sucursal:</strong> 
	<select name="sucursal" id="sucursal">
	<?	  
	  $sql="SELECT * FROM tbl_sucursal where id_sucursal<>0 "; 
	   	 $sql.=" order by sucursal 	"; 
        	$r = $obj->consultar($sql);
     	while ($row = mysql_fetch_assoc($r)) 
     	{    
			echo '<option value='.$row["id_sucursal"].' >'.$row["sucursal"].'</option>';
		}	 
	   
	  ?>
      </select>    

<strong>Editorial:</strong> 
	<select name="editorial" id="editorial">
	<?	  
	  $sql2="SELECT * FROM tbl_editorial where id_editorial>1 "; 
	   	 $sql2.=" order by editorial 	"; 
        	$r2 = $obj->consultar($sql2);
	echo '<option value="0" selected="selected" >-Seleccione la Editorial-</option>';
     	while ($row2 = mysql_fetch_assoc($r2)) 
     	{    
			echo '<option value='.$row2["id_editorial"].' >'.$row2["editorial"].'</option>';
		}	 
	   
	  ?>
      </select>    


     <input type="submit" value="Ok" class="boton">
	 <input type="button" value="Salir" onclick="javascript:window.close(this)" class="boton">
  </td>
 </tr>


</table>
</form>
