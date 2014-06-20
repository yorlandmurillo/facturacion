<?

?>


<?
include('class.ezpdf.php');
require("../admin/session.php"); // incluir motor de autentificación.

function multiplo($limt,$num1){
$salir=0;
$i=1;

while($salir!=1){
$mresult=$i%$num1;
if($mresult==$limt){ 
$salir=1;
}else{
$salir=0;
}
if($salir==1)return true;
else return false;
$i++;
}

}

$pdf =& new Cezpdf('letter');
$obj =& new manejadordb();
$pdf -> ezSetMargins(50,70,50,50);

$all = $pdf->openObject();

$pdf->closeObject();
// note that object can be told to appear on just odd or even pages by changing 'all' to 'odd'
// or 'even'.
$pdf->addObject($all,'all');

//$pdf->ezSetDy(-100);

$lista= $obj->consultar("select * from tbl_inventario");


$pdf->selectFont('./fonts/Helvetica');
$pdf->ezStartPageNumbers(500,30,10,'','',0);
$pdf->getFontHeight(1);
$datacreator = array (
                    'Title'=>'Listado de Inventario',

                    'Author'=>'Yony Acevedo',

                    'Subject'=>'listado',

                    'Creator'=>'yacevedo@libreriasdelsur.gob.ve',

                    'Producer'=>'http://www.libreriasdelsur.gob.ve'
                    );

$pdf->addInfo($datacreator);
$anio=date('Y');
$limite=160;
$i=0;
$n[]=array(1,2,3,4,5,6,7,8,9);

while($row = mysql_fetch_array($lista) and $i<$limite){
$data[$i] = array('cant'=>$i+1,'num'=>$row['cod_producto'], 'mes'=>$row['descripcion'],'anio'=>$row['precio']);
if($i>69){
//if(multiplo($limite,$i)==true){
//$pdf->ezNewPage();
$data[$i] = array('cant'=>$i+1,'num'=>$row['cod_producto'], 'mes'=>$row['descripcion'],'anio'=>$row['precio']);
//}
}
$i++;
}

$titles = array('cant'=>'Nro','num'=>'Código', 'mes'=>'Titulo','anio'=>'Precio');

//$pdf->ezText("Meses en PHP\n",16);
//$pdf->ezText("Listado de Meses\n",8);
$pdf->ezTable($data,$titles,'Listado de Libros',$options );
$pdf->ezText("\n\n\n",1);
//$pdf->ezText("Fecha: ".date("d/m/Y"),10);
//$pdf->ezText("Hora: ".date("H:i:s")."\n\n",10);
$pdf->ezText(sizeof($data),1);
$pdf->ezStream();
?>