<?
require("../admin/session.php");// // incluir motor de autentificación.
$pag=$_SERVER['PHP_SELF'];  // el nombre y ruta de esta misma página.
$nivel_acceso=1;// definir nivel de acceso para esta página.

if ($_SESSION['usuario_nivel'] < $nivel_acceso)
{
	Header ("Location: ../admin/login.php?error_login=5");
	exit;
}

function array_insert($array,$pos,$val)
{

    $array2 = array_splice($array,$pos);
    $array[] = $val;
    $array = array_merge($array,$array2);
  
    return $array;
}	

function fecha($fecha)
{
	if ($fecha)
	{
		$p=split(" ",$fecha);
		$f=split("-",$p[0]);
		$h=split(":",$p[1]);

		//cambio de fecha
		$nummes=(int)$f[1];
		$mes1="0-Ene-Feb-Mar-Abr-May-Jun-Jul-Agos-Sept-Oct-Nov-Dic";
		$mes1=split("-",$mes1);

		//cambio de hora

		$numhora=(int)$h[0];
		$momento = 'a.m.';
		if ($numhora >= 13)
		{
			$numhora = $numhora - 12;
			$momento = 'p.m.';
		}

		$desfechahora="$mes1[$nummes] $f[2] de $f[0] $numhora:$h[1] $momento";
		return $desfechahora;
	}
}



@ $fact= $_POST['codf'];
@ $vend= $_POST['vend'];
@ $suc= $_POST['suc'];
@ $consultando= $_POST['consultando'];

$lineas= $_POST['lineas'];


$link_Busca = mysql_connect("localhost","inventa_bd","Valenta@04") or die (mysql_error());  
mysql_select_db("inventa_pglibreria",$link_Busca);
$resultFac = @mysql_query("
select *
FROM tbl_facturas 
WHERE cod_factura ='$fact' ",$link_Busca); 
$rowFac=mysql_fetch_array($resultFac); 
$sucursal =$rowFac["sucursal"];



$obj=new manejadordb;

$query="SELECT tbl_itemfactura.cod_factura AS factura, 
tbl_facturas.fecha_factura AS fecha, 
tbl_facturas.mto_total AS monto, 
tbl_facturas.efectivo AS efec, 
tbl_facturas.cheque AS cheque, 
tbl_facturas.tdb AS tdb, 
tbl_facturas.tdc AS tdc, 
tbl_facturas.bl AS bl, 
tbl_facturas.cesta_ticket AS cesta, 
tbl_facturas.pago_especial AS esp, 
tbl_facturas.otra_moneda AS omoneda, 
tbl_facturas.sub_total as sub_total,
tbl_facturas.mto_total as mto_total,
tbl_facturas.cambio AS cambio,
tbl_facturas.mto_iva,
tbl_facturas.codfacturamanual ,
tbl_facturas.numtalonario,
tbl_itemfactura.cod_producto AS producto, 
tbl_itemfactura.descripcion AS descripcion, 
tbl_itemfactura.cantidad AS cant, 
tbl_itemfactura.precio_unid AS precio, 
tbl_itemfactura.descuento AS descuento,
tbl_itemfactura.iva AS bien_iva,  
cod_cliente AS cedula, 
tbl_usuario.us_login AS vendedor, 
tbl_sucursal.sucursal AS sucursal,tbl_sucursal.telefono AS telefono
From tbl_facturas,tbl_itemfactura,tbl_usuario,tbl_sucursal
where tbl_facturas.sucursal = tbl_itemfactura.sucursal
and tbl_facturas.cod_factura = tbl_itemfactura.cod_factura
and tbl_facturas.vendedor = tbl_usuario.id_usuario
and tbl_facturas.sucursal = tbl_sucursal.id_sucursal
and tbl_facturas.cod_factura='$fact' AND tbl_facturas.sucursal='$suc'
AND tbl_facturas.estatus_factura=3";

$result = $obj->consultar($query);
 // result of count query
$filas = mysql_fetch_assoc($result);
$cedula=$filas["cedula"];
$query_cliente="select cli_nombre from tbl_cliente where cli_cedula='$cedula' limit 0,1";
$result_cliente = $obj->consultar_remoto($query_cliente);
 // result of count query
 $filas_cliente = mysql_fetch_assoc($result_cliente);
 $nombre=$filas_cliente["cli_nombre"];



$efectivo=$filas["efec"];
$cheque=$filas["cheque"];
$tdb=$filas["tdb"];
$tdc=$filas["tdc"];

$bl=$filas["bl"];
$cesta=$filas["cesta"];
$esp=$filas["esp"];

$sub_total=$filas["sub_total"];
$mto_iva=$filas["mto_iva"];
$descuento=$filas["descuento"];

$encabezado="Fundacion Librerias del Sur";
$direccion="Calle Hipica con Av. La Guairita, Edif. Fundacion Librerias del Sur PB Apto. U, Las Mercedes, Caracas/Venezuela";
$rif="RIF: G-20007995-9";
$oficina=$filas["sucursal"];
$vendedor=$filas["vendedor"];
$telefono=$filas["telefono"];
$factura=$fact;
$codfactm=$filas["codfacturamanual"];
$numtalonario=$filas["numtalonario"];
$CIRIF=$filas["cedula"];
$NOMB=$filas["nombre"];
$fecha=$filas["fecha"];
$contrib='"Contribuyente Formal"';
$div="----------------------------------------";
$filas="#  Descrip.	Cant.	PVP	I.V.A";
//$iva=12/100;
//$iva="0.00";
//$dcto=20/100;
$libros=array();


/*Lleno el array de los libros en la factura*/
 $result2 = $obj->consultar($query);

  $z = 0;
  $counter=0;	
  $pts="";


 while ($row = mysql_fetch_assoc($result2))
 {         
	 if($row["bien_iva"]>0){
		 $iva=$row["bien_iva"]*$row["cant"];
		 $mensaje="VENTAS POR CTA DE TERCEROS SEGUN ART. 10"."\n";
		 $intro="\n\n\n\n\n";
		 $counter=1;	
	}
	else
	{
		 $iva="0.00";
		 $mensaje="";
		 $intro="\n\n\n\n\n\n";
	} 
	 
	if($counter>0)
	{
		 $mensaje="VENTAS POR CTA DE TERCEROS SEGUN ART. 10"."\n";
		 $intro="\n\n\n\n\n";
	} 


	$libros[$z]=array(substr($row["descripcion"],0,10),$row["cant"],$row["precio"],$iva,$row["descuento"],$row["producto"]);	
	$z++;    
 }   

/*Fin de llenado*/

$limite_array=$z;//sizeof($libros);

if($codfactm!="" && $codfactm>0)
{
	$lim=1;
}
else
{
	if($consultando==1)
		$lim=1;
	else
		$lim=2;
}

//$lim=2;//Numero de copias requeridas
$ult=$lim-1;//Total de copias menos 1

for ($c=0;$c<$lim;$c++)
{
	$sumaarray=0;
	$sumaiva=0;
	$sumadcto=0;
	$librosvendidos=0;


	$texto ="Libreria del Sur: ".$oficina."\n"."".$rif."\n"."Vendedor:".$vendedor."\n"."Telefono: ".$telefono."\n";
	
	if($codfactm=="" || $codfactm==0)
	{
		$texto.="# Factura Contado: ".$factura."\n";
	}
	
	if($codfactm!="" && $codfactm>0)
	{
		$texto.="# Carga de talonario\n";
		$texto.="Cod fact talonario: ".$codfactm."\n"."Num talonario: ".$numtalonario."\n";
	}
	
	
	
	$texto.="C.I/RIF: ".$CIRIF."\n"."Cliente: ".$nombre."\n"."Fecha:	".fecha($fecha)."\n"."\t".$contrib."\n".$div."\n".$filas."\n".$div."\n"; 
	
	for ($i=0;$i<sizeof($libros) && sizeof($libros) <= $limite_array;$i++)
	{

		$sumaarray+=($obj->setprecio_remoto($libros[$i][5])*$libros[$i][1]);
		$sumaiva+=($obj->setprecio_remoto($libros[$i][5]))*$libros[$i][3];
		$sumadcto+=($obj->setprecio_remoto($libros[$i][5])*$libros[$i][4])*$libros[$i][1];
		$librosvendidos+=$libros[$i][1];


			$texto.=$i+1;
			$texto.="  ".$libros[$i][0]."\t";
			$texto.=$libros[$i][1]."\t";
			$texto.=number_format($libros[$i][2]+($libros[$i][2]*$libros[$i][4]),2,'.','')."\t";
			
			if($libros[$i][3]==0){
				$texto.="(E)";
			}elseif($libros[$i][3]>0){
				$texto.="(12%)";
			}
			$texto.="\n";

	}
		
	if(sizeof($libros)<$limite_array)
	{
		for ($n=0;$n<$limite_array-sizeof($libros);$n++){
			$texto.="\n";
		}
	}


	$texto.="\n"; 
	$texto.="Sub Total:	".number_format($sub_total,2,'.','')."\n";
	$texto.="I.V.A(12%):	".number_format($mto_iva,2,'.','')."\t"; 
	$texto.="Desc:	".number_format($descuento,2,'.','')."\n";
	$texto.="Total Cancelar:	".number_format(($sub_total+$mto_iva)-($descuento),2,'.','')." BsF."."\n";
	$texto.="Libros Vendidos:	".$librosvendidos."\n";
	if($c==0)$validez="          ";elseif($c==1)$validez="       ";
	$texto.=$mensaje;
	$texto.="FORMA DE PAGO:   ".$validez.""."\n";

	if($efectivo>0)
	{
		$texto.="Efectivo:	".number_format($efectivo,2,',','.')."\n";
	}
	if($cheque>0)
	{
		$texto.="Cheque:	".number_format($cheque,2,',','.')."\n";
	}
	if($tdb>0)
	{
		$texto.="Tarj. Dbo:	".number_format($tdb,2,',','.')."\n";
	}
	if($tdc>0)
	{
		$texto.="Tarj. Cre:	".number_format($tdc,2,',','.')."\n";
	}


	if($bl>0)
	{
		$texto.="BonoLibro:	".number_format($bl,2,',','.')."\n";
	}
	if($cesta>0)
	{
		$texto.="Cesta Ticket:	".number_format($cesta,2,',','.')."\n";
	}
	if($esp>0)
	{
		$texto.="Monto Especial:	".number_format($esp,2,',','.')."\n";
	}

	$texto.="NO SE ACEPTAN DEVOLUCIONES   ".$validez.""."\n";
	$texto.=$intro;

	//$texto=$query;
	//$texto= $_POST['codf']."-*-".$_POST['vend']."-*-".$_POST['suc']."-*-".$_POST['consultando'];

	if($c==0)$letra="O";elseif($c==1)$letra="C";

	$archivo = fopen("facturas_lp/".$factura.$letra, "w+");
	fwrite($archivo, $texto);
	fclose($archivo);   

	//shell_exec("cat facturas_lp/".$factura.$letra."> /dev/usb/lp0");
	shell_exec("cat facturas_lp/".$factura.$letra."> /dev/lp0");
	shell_exec("rm facturas_lp/".$factura.$letra);
	if($c != $ult)
	{
		sleep(10);
	}
}

$msj="true";
$xml="<?xml version='1.0' encoding='UTF-8'?>";
$xml.="<respuesta>";
$xml.="<resp><![CDATA[$msj]]></resp>";
$xml.="</respuesta>";
header("Content-type: text/xml");

echo $xml; 
?>
