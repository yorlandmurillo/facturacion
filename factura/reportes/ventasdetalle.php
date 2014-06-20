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
	$this->cell(0,5,'SIGAL',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','BI',10);	
	$this->cell(0,5,'version 1.0',0,0,'R');
    $this->Ln(5);
    $this->SetFont('Arial','B',12);
    //Título
    $this->Cell(1,10,manejadordb::setsucursal($_SESSION['usuario_sucursal']),0,0,'L');	
    $this->Cell(0,10,'Detalle de Facturas',0,0,'C');	
    $this->Cell(0,10,'Fecha: '.$_POST['fechab'],0,0,'R');
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

if(isset($_POST['fechad']) && !empty($_POST['fechad']) && isset($_POST['fechah']) && !empty($_POST['fechah']) && isset($_POST['orden']) && !empty($_POST['orden']))
{
	$sucursal=$_SESSION['usuario_sucursal'];
	$f=date('d')."/".date('m')."/".date('Y');
	$h=date('H').":".date('i');
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
	$sql="SELECT tbl_facturas.cod_factura, tbl_facturas.fecha_factura, tbl_facturas.cod_cliente, tbl_facturas.vendedor, tbl_facturas.sucursal, 
		tbl_facturas.efectivo, tbl_facturas.cheque, tbl_facturas.tdb, tbl_facturas.tdc, tbl_facturas.bl, tbl_facturas.cesta_ticket, tbl_facturas.pago_especial, 
		tbl_facturas.otra_moneda,tbl_facturas.cambio,tbl_facturas.mto_total, tbl_facturas.estatus_factura,tbl_facturas.vendedor  
		FROM tbl_facturas 
		WHERE (((tbl_facturas.sucursal)=$sucursal) AND ((tbl_facturas.estatus_factura)=3) 
		AND ((tbl_facturas.fecha_factura) Between '$fechadesde' And '$fechahasta')) ORDER BY ";

		if($_POST['orden']=='fecha'){
		$sql.=" tbl_facturas.fecha_factura desc;";
		}elseif($_POST['orden']=='usuario'){
		$sql.=" tbl_facturas.vendedor desc;";
		}


	$result=$obj->consultar($sql);
	$num=mysql_num_rows($result);
	$cant=28;
	$cont=0;
	$total=0;
	for($i=0;$i<$num+$cont && $row=mysql_fetch_assoc($result);$i++){

		$efectivo+=$row['efectivo']-$row['cambio'];
		$especial+=$row['pago_especial'];
		$omoneda+=$row['otra_moneda'];
		$cesta+=$row['cesta_ticket'];
		$cheque+=$row['cheque'];
		$tdb+=$row['tdb'];
		$tdc+=$row['tdc'];
		$bl+=$row['bl'];

		$totalvendido+=$row['mto_total'];//$efectivo+$especial+$omoneda+$cesta+$cheque+$tdb+$tdc+$bl;

		if(bcmod($i,$cant)==0){
			$pdf->AddPage('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.manejadordb::setuser($_SESSION['usuario_id']));
			//Superior Izquierda
				$pdf->SetFont('Arial','B',9);
			$pdf->Ln(5);
			$pdf->Line(12,30,210,30);
			$pdf->SetFont('Helvetica','',9);
			$pdf->SetY(35);
			$pdf->SetX(12);
			$pdf->Cell(50,0,"Factura",0,1,'L');
			$pdf->SetX(32);
			$pdf->Cell(25,0,"Fecha y Hora",0,1,'C');
			$pdf->SetX(55);
			$pdf->Cell(25,0,"Efectivo",0,1,'C');
			$pdf->SetX(73);
			$pdf->Cell(25,0,"Cheque",0,1,'C');
			$pdf->SetX(90);
			$pdf->Cell(25,0,"Tarj/Deb.",0,1,'C');
			$pdf->SetX(107);
			$pdf->Cell(25,0,"Tarj/Cred.",0,1,'C');
			$pdf->SetX(123);
			$pdf->Cell(25,0,"B/Libro",0,1,'C');
			$pdf->SetX(138);
			$pdf->Cell(25,0,"C/Ticket",0,1,'C');
			$pdf->SetX(153);
			$pdf->Cell(25,0,"Especial",0,1,'C');
			$pdf->SetX(172);
			$pdf->Cell(25,0,"O/Mda",0,1,'C');
			$pdf->SetX(193);
			$pdf->Cell(25,0,"Total",0,1,'C');
		}

		if(bcmod($i,$cant)<$cant-1){
		
		if($_POST['orden']=='fecha'){
		//substr_count($origen,"login.php")==0

			if($agrupar!=cambiafanormal(substr($row['fecha_factura'],0,10))){
			//muestra el siguiente usuario
			$agrupar=cambiafanormal(substr($row['fecha_factura'],0,10));
			$pdf->SetY(40+bcmod($i,$cant)*7);
			$pdf->SetFont('Arial','',7);
			$pdf->SetX(12);
			
			$pdf->Cell(28,5,"Fecha:",1,1,'L');
			
			$pdf->SetY(40+bcmod($i,$cant)*7);
			$pdf->SetX(40);
			$pdf->Cell(170,5,$agrupar,1,1,'L');
			$pdf->SetY(43+bcmod($i,$cant)*7);
			$pdf->SetX(59);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierrexfecha($row['sucursal'],"efectivo",substr($row['fecha_factura'],0,10)),2,',','.'),0,1,'R');
			$pdf->SetX(76);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierrexfecha($row['sucursal'],"cheque",substr($row['fecha_factura'],0,10)),2,',','.'),0,1,'R');
			$pdf->SetX(94);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierrexfecha($row['sucursal'],"tdb",substr($row['fecha_factura'],0,10)),2,',','.'),0,1,'R');
			$pdf->SetX(111);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierrexfecha($row['sucursal'],"tdc",substr($row['fecha_factura'],0,10)),2,',','.'),0,1,'R');
			$pdf->SetX(126);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierrexfecha($row['sucursal'],"bl",substr($row['fecha_factura'],0,10)),2,',','.'),0,1,'R');
			$pdf->SetX(142);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierrexfecha($row['sucursal'],"cesta_ticket",substr($row['fecha_factura'],0,10)),2,',','.'),0,1,'R');
			$pdf->SetX(157);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierrexfecha($row['sucursal'],"pago_especial",substr($row['fecha_factura'],0,10)),2,',','.'),0,1,'R');
			$pdf->SetX(175);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierrexfecha($row['sucursal'],"otra_moneda",substr($row['fecha_factura'],0,10)),2,',','.'),0,1,'R');
			$pdf->SetX(194);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierrexfecha($row['sucursal'],"mto_total",substr($row['fecha_factura'],0,10)),2,',','.'),0,1,'R');

			$i++;
			$cont++;
		}

		}elseif($_POST['orden']=='usuario'){
		
		if($agrupar!=strtoupper(manejadordb::setuser($row['vendedor']))){
			//muestra el siguiente usuario
			$agrupar=strtoupper(manejadordb::setuser($row['vendedor']));
			$pdf->SetY(40+bcmod($i,$cant)*7);
			$pdf->SetFont('Arial','',7);
			$pdf->SetX(12);
			
			$pdf->Cell(28,5,"Caja/Usuario:",1,1,'L');
			
			$pdf->SetY(40+bcmod($i,$cant)*7);
			$pdf->SetX(40);
			$pdf->Cell(170,5,$agrupar,1,1,'L');
			$pdf->SetY(43+bcmod($i,$cant)*7);
			$pdf->SetX(59);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierre($row['vendedor'],$row['sucursal'],"efectivo",$fechadesde,$fechahasta),2,',','.'),0,1,'R');
			$pdf->SetX(76);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierre($row['vendedor'],$row['sucursal'],"cheque",$fechadesde,$fechahasta),2,',','.'),0,1,'R');
			$pdf->SetX(94);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierre($row['vendedor'],$row['sucursal'],"tdb",$fechadesde,$fechahasta),2,',','.'),0,1,'R');
			$pdf->SetX(111);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierre($row['vendedor'],$row['sucursal'],"tdc",$fechadesde,$fechahasta),2,',','.'),0,1,'R');
			$pdf->SetX(126);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierre($row['vendedor'],$row['sucursal'],"bl",$fechadesde,$fechahasta),2,',','.'),0,1,'R');
			$pdf->SetX(142);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierre($row['vendedor'],$row['sucursal'],"cesta_ticket",$fechadesde,$fechahasta),2,',','.'),0,1,'R');
			$pdf->SetX(157);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierre($row['vendedor'],$row['sucursal'],"pago_especial",$fechadesde,$fechahasta),2,',','.'),0,1,'R');
			$pdf->SetX(175);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierre($row['vendedor'],$row['sucursal'],"otra_moneda",$fechadesde,$fechahasta),2,',','.'),0,1,'R');
			$pdf->SetX(194);
			$pdf->Cell(16,0,number_format(manejadordb::setmontoprecierre($row['vendedor'],$row['sucursal'],"mto_total",$fechadesde,$fechahasta),2,',','.'),0,1,'R');

			$i++;
			$cont++;
		}
		}	
		}
		$pdf->SetFont('Arial','',6);
		$pdf->SetY(42+bcmod($i,$cant)*7);
		$pdf->SetX(12);
		$pdf->Cell(50,0,$row['cod_factura'],0,1,'L');	
		$pdf->SetX(33);
		$pdf->Cell(25,0,$row['fecha_factura'],0,1,'L');
		$pdf->SetX(50);
		$pdf->Cell(25,0,number_format($row['efectivo']-$row['cambio'],2,',','.'),0,1,'R');
		$pdf->SetX(67);
		$pdf->Cell(25,0,number_format($row['cheque'],2,',','.'),0,1,'R');
		$pdf->SetX(85);
		$pdf->Cell(25,0,number_format($row['tdb'],2,',','.'),0,1,'R');
		$pdf->SetX(102);
		$pdf->Cell(25,0,number_format($row['tdc'],2,',','.'),0,1,'R');
		$pdf->SetX(117);
		$pdf->Cell(25,0,number_format($row['bl'],2,',','.'),0,1,'R');
		$pdf->SetX(132);
		$pdf->Cell(25,0,number_format($row['cesta_ticket'],2,',','.'),0,1,'R');
		$pdf->SetX(147);
		$pdf->Cell(25,0,number_format($row['pago_especial'],2,',','.'),0,1,'R');
		$pdf->SetX(166);
		$pdf->Cell(25,0,number_format($row['otra_moneda'],2,',','.'),0,1,'R');
		$pdf->SetX(185);
		$pdf->Cell(25,0,number_format($row['mto_total'],2,',','.'),0,1,'R');
		
	}
		$pdf->SetFont('Arial','UB',6);
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
		$pdf->Cell(25,0,number_format($totalvendido,2,',','.'),0,1,'C');

	  $pdf->Output('Fecha de Emisión: '.$f,'Hora de Emisión: '.$h,'Usuario: '.manejadordb::setuser($_SESSION['usuario_id']),'detalledeventas'.'.pdf','D');

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
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #C2382B; border-color: #FFFFFF; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix; font-weight: bold; }
</style>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="mform" id="mform">
  <p class="Estilo3">REPORTE DETALLADO DE FACTURACI&Oacute;N </p>
  <table width="323" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla" >
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
      <td><input type="text" name="fechah" id="fechah" value="<?php if(!empty($_POST['fechah']))echo $_POST['fechah']; ?>" size="10" readonly="true"><img src="../imagenes/calendar.png" id="trigger2"
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
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
	<tr>
	  <td colspan="4" class="boton"><strong>Agrupar Por: 
      </strong></td>
    </tr>
	<tr>
	  <td colspan="4"><strong>
	    <input name="orden" type="radio" value="usuario" checked="checked" />
Usuario</strong></td>
    </tr>
	<tr>
	  <td colspan="4"><strong>
	    <input name="orden" type="radio" value="fecha" />
Fecha</strong></td>
    </tr>
	<tr>
      <td colspan="4"><div align="right">
        <input name="submit" type="submit" class="boton" value="Consultar" />        
        <input name="button" type="button" class="boton" onclick="javascript:window.close(this)" value="Salir" />
      </div></td>
    </tr>
</table>
</form>