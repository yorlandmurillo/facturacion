<?php
include_once "conexion.php";
require('fpdf/mc_table.php');

$pdf=new PDF_MC_Table();
$pdf->AddPage();
$pdf->SetWidths(array(10,23,75,60,75,14,16,14,18,18));
$total_cantidad=0;
$total_monto=0;

$sql_sucursal="select distinct(tbl_sucursal.sucursal)
from tbl_distinventario,tbl_sucursal
where tbl_distinventario.sucursal=tbl_sucursal.id_sucursal
limit 0,1";
$result_sucursal = mysql_query($sql_sucursal) or die("Busca sucursal<br>".mysql_error());
do 
{
	$libreria=$row_sucursal[0];
} while ($row_sucursal = mysql_fetch_array($result_sucursal));

$sql_editorial="select editorial
from tbl_editorial
where id_editorial='4444'";
$result_editorial = mysql_query($sql_editorial) or die("Busca editorial<br>".mysql_error());
do 
{
	$editorial=$row_editorial[0];
} while ($row_editorial = mysql_fetch_array($result_editorial));



$sql_inventario="SELECT tbl_distinventario.cod_producto, tbl_distinventario.descripcion, tbl_distinventario.autor, tbl_distinventario.editorial,cantidad,precio,
				iva
				FROM tbl_distinventario,tbl_inventario
				where tbl_distinventario.cod_producto=tbl_inventario.cod_producto
				and tbl_distinventario.cod_producto like '4444%'";
//die($sql_inventario);
	$result_inventario = mysql_query($sql_inventario) or die("Busca registro inventario<br>".mysql_error());
	$nf_inventario=mysql_num_rows($result_inventario);
	if ($myrow = mysql_fetch_array($result_inventario)) 
	{	
		$n=1;
		$pdf->SetFont('Arial','B',12);
		$pdf->Text(100,8,$libreria." ".$editorial." ".date("d-m-Y h:i:s",time()));
		$pdf->SetFont('Arial','B',10);
		$pdf->Row(array("","CODIGO","TITULO","AUTOR","EDITORIAL","CANT","PRECIO","IVA","PRECIO FINAL","MONTO"));
		$pdf->SetFont('Arial','',10);
		do 
		{
			$fecha1=substr ($myrow[10], 0,10);
			$hora1=substr ($myrow[10], 10,20);
			$fecha4=explode("-", $fecha1);
			$fecha_ingreso=$fecha4[2]."/".$fecha4[1]."/".$fecha4[0].$hora1;
			$cantidad=$myrow[4];
			$precio=$myrow[5];
			if($myrow[6]==1)
			{
				$iva=0;
			}
			if($myrow[6]==2)
			{
				$iva=$precio*0.12;
			}
			$precio_final=$precio+$iva;
			$monto=$cantidad*$precio_final;
			$pdf->Row(array($n,$myrow[0],$myrow[1],$myrow[2],$myrow[3],$myrow[4],number_format($precio,2,",","."),number_format($iva,2,",","."),number_format($precio_final,2,",","."),number_format($monto,2,",",".")));
			$total_monto=$total_monto+$monto;
			$total_cantidad=$total_cantidad+$cantidad;
			
			$n++;
		} while ($myrow = mysql_fetch_array($result_inventario));
		
	}
	else
	{
		$y=$pdf->GetY();
		$pdf->Text(90,$y+10,"NO SE ENCONTRARON RESULTADOS PARA ESTA CONSULTA");
	}
	$y=$pdf->GetY();
	$pdf->SetFont('Arial','B',14);
	$pdf->Text(20,$y+10,"Total articulos: ".$total_cantidad);
	$pdf->Text(20,$y+20,"Monto total: ".number_format($total_monto,2,",",".")." Bolivares");
$pdf->Output("inventario.pdf","F");
?>
