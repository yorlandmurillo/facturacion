<?
require('../fpdf/fpdf.php');
require("../admin/session.php"); // incluir motor de autentificación.
//require_once("../admin/manejadordb.php");
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

if(isset($_POST['fechad']) && !empty($_POST['fechad']) && isset($_POST['fechah']) && !empty($_POST['fechah']))
{
	$sucursal=$_SESSION['usuario_sucursal'];
	$f=date('d')."/".date('m')."/".date('Y');
	$h=date('H').":".date('i');
	$date=cambiafamysql($_POST['fechad']);
	$date1=cambiafamysql($_POST['fechah']);
	

	if($sucursal==0)
		$condicion="";
	else
		$condicion="and tbl_facturas.sucursal='$sucursal'";
	
	
	$fecha_inicio=$date." 00:00:00";
	$fecha_final=$date1." 23:59:59";
	
$f=date('d')."/".date('m')."/".date('Y');
$h=date('H').":".date('i');

$pdf=new PDF('L','mm','letter');
$pdf->AliasNbPages();
$fechaa=date('Y-m-d')." 00:00:00";//"2007-11-09 00:00:00";
$sucursal=$_SESSION['usuario_sucursal'];

$sql="SELECT tbl_itemfactura.cod_producto, tbl_itemfactura.descripcion,aut_nombre, Sum(tbl_itemfactura.cantidad) AS cantidad 
		FROM tbl_facturas,tbl_itemfactura,tbl_inventario, tbl_autor
		WHERE fecha_factura between'$fecha_inicio' and '$fecha_final' ".$condicion."
		and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
		and tbl_itemfactura.cod_producto=tbl_inventario.cod_producto
		and tbl_inventario.aut_codigo=tbl_autor.id_autor
		 and (((tbl_facturas.sucursal)=$sucursal) AND ((tbl_facturas.estatus_factura)=3)) 
		GROUP BY tbl_itemfactura.cod_producto, tbl_itemfactura.descripcion 
		ORDER BY Sum(tbl_itemfactura.cantidad) DESC;";
//die($sql);
$result=$obj->consultar($sql);
$num=mysql_num_rows($result);
$cant=20;
$record=10;
$contador=0;
for($i=0;$i<$num && $row=mysql_fetch_assoc($result);$i++)
{
	if(bcmod($i,$cant)==0)
	{
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
	if($contador++<$record)
	{
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(20,0,$row['cod_producto'],0,1,'L');	
		
		$pdf->SetX(38);
		if(strlen($row['descripcion'])>60){
		$pts="...";
		}else $pts="";	
		$pdf->Cell(0,0,substr($row['descripcion'],0,60).$pts,0,1,'L');
		
		$pdf->SetX(150);
		if(strlen($row['aut_nombre'])>60){
		$pts="...";
		}else $pts="";	
		$pdf->Cell(0,0,substr($row['aut_nombre'],0,60).$pts,0,1,'L');
		
		$pdf->SetX(240);
		$pdf->Cell(25,0,$row['cantidad'],0,1,'R');
	}
	else
	{
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(50,0,$row['cod_producto'],0,1,'L');	
		$pdf->SetX(40);
		$pdf->Cell(25,0,$row['fecha_factura'],0,1,'C');
		
		$pdf->SetX(38);
		if(strlen($row['descripcion'])>60){
		$pts="...";
		}else $pts="";	
		$pdf->Cell(0,0,substr($row['descripcion'],0,60).$pts,0,1,'L');
		
		$pdf->SetX(150);
		if(strlen($row['aut_nombre'])>60){
		$pts="...";
		}else $pts="";	
		$pdf->Cell(0,0,substr($row['aut_nombre'],0,60).$pts,0,1,'L');
		
		
		$pdf->SetX(240);
		$pdf->Cell(25,0,$row['cantidad'],0,1,'R');
	}

	$totalvendido+=$row['cantidad'];
	
	$pdf->SetX(155);
	$pdf->Cell(0,0,substr(manejadordb::getautor_remoto($row['cod_producto']),0,52),0,1,'L');

}	
	$pdf->SetFont('Arial','B',14);
	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(150);
	$pdf->Cell(25,0,"Total Vendidos:   ".$totalvendido,0,1,'L');
/*	$pdf->SetY(47+bcmod($i,$cant)*7);
	$pdf->SetX(285);
	$pdf->Cell(25,0,$totalvendido,0,1,'C');*/


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
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #C2382B; border-color: #FFFFFF; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix; font-weight: bold; }
</style>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="mform" id="mform">
  <p class="Estilo3">LOS BIENES MAS VENDIDOS</p>
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
<tr><td colspan="4" class="celdac">Sucursal: </td></tr>
<tr>
	<td colspan="4"><span class="Estilo5">

        <select id="sucursal" name="sucursal">
	        <option value="0">Todas</option>
	        <?php					
				$query="select tbl_sucursal.id_sucursal, rtrim(tbl_sucursal.sucursal) 
						from tbl_facturas,tbl_sucursal
					where tbl_facturas.sucursal = tbl_sucursal.id_sucursal
					GROUP BY tbl_sucursal.id_sucursal
					ORDER BY tbl_sucursal.sucursal";
				
				$result=$obj->consultar($query);
				$num=mysql_num_rows($result);
				while($row = mysql_fetch_array($result)) {
					if($row[0]==$vendedor){
						printf("<option value='%s' selected>%s - %s</option> ", $row[0],$row[0], utf8_decode($row[1]));
					}else{
						printf("<option value='%s'>%s - %s</option> ", $row[0],utf8_decode($row[1]), $row[0]);
					}
				}
				$sucursal2= $row[1];
				?>
        </select>
        </span></td>
    </tr>


<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
	
	<tr>
      <td colspan="4"><div align="right">
        <input name="submit" type="submit" class="boton" value="Consultar" />        
        <input name="button" type="button" class="boton" onclick="javascript:window.close(this)" value="Salir" />
      </div></td>
    </tr>
</table>
</form>