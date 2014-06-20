<script language="JavaScript" type="text/javascript">
function esc(){
	window.close(this);
}
</script>
<?
include_once("manejadordb.php");
$obj=new manejadordb;
//Datos POST
$cod_factura=$_POST["cod_factura"];
$sucursal=$_POST["sucursal"];
$fecha_factura=$_POST["fecha_factura"];
$fechacorta=substr($fecha_factura,0,10);
$efectivo=$_POST["efectivo"];
$cheque=$_POST["cheque"];
$tdb=$_POST["tdb"];
$tdc=$_POST["tdc"];
$cesta_ticket=$_POST["cesta_ticket"];
$bl=$_POST["bl"];
$mto_iva=$_POST["mto_iva"];
$sub_total=$efectivo+$cheque+$tdb+$tdc+$cesta_ticket+$bl;
$mto_total=$sub_total+$mto_iva;
$link_Busca = mysql_connect("localhost","inventa_bd","Valenta@04") or die ("-1->".mysql_error());  
mysql_select_db("inventa_pglibreria",$link_Busca);

//Se actualiza la tabla factura con los datos enviadps
$sql_update="update tbl_facturas set fecha_factura='$fecha_factura',
efectivo='$efectivo',
cheque='$cheque',
tdb='$tdb',
tdc='$tdc',
cesta_ticket='$cesta_ticket',
bl='$bl',
mto_iva='$mto_iva',
sub_total='$sub_total',
mto_total='$mto_total'
where cod_factura='$cod_factura' and sucursal='$sucursal'
and estatus_factura=3
";

//se analiza la situacion si se trata de anular la factura
if($estatus_factura==5)
{
	//Se busca el detallado correspondiente a la factura
	$busca_itemfactura="select * from tbl_itemfactura where cod_factura='$cod_factura' and sucursal='$sucursal' and estatus_cancelacion=3";
	//$result_item=mysql_query($busca_itemfactura,$link_Busca) or die($busca_itemfactura."<br>-2->".mysql_error());
	$result_item=$obj->consultar($busca_itemfactura);
	if ($rowitem= mysql_fetch_array($result_item)) 
	{
		do 
		{
			$cod_pro=$rowitem['cod_producto'];
			$descripcion=$rowitem['descripcion'];
			$cif=$rowitem['cif'];
			$cic=$rowitem['cic'];
			$cidn=$rowitem['cidn'];
			$existencia=$rowitem['existencia'];
			$cantidad=$rowitem['cantidad'];
			$descuento=$rowitem['descuento'];
			
			//Se buscan los datos faltantes del articulo en tbl_inventario
			$busca_bienes="select cod_barra,aut_nombre,tbl_editorial.editorial,precio,iva
							from tbl_inventario, tbl_editorial, tbl_autor
							where cod_producto='$cod_pro'
							and tbl_inventario.aut_codigo=tbl_autor.id_autor
							and tbl_inventario.editorial=tbl_editorial.id_editorial
							order by descripcion";
			$result_bienes = mysql_query($busca_bienes,$link_Busca) or die($busca_bienes."<br>-3->".mysql_error());
			if ($myrow= mysql_fetch_array($result_bienes)) 
			{
				do 
				{
					$cod_barra=$myrow['cod_barra'];
					$autor=$myrow['aut_nombre'];
					$editorial=$myrow['editorial'];
				} while ($myrow= mysql_fetch_array($result_bienes));
			}
			else
			{
				echo "<b><div align='center'><font  size='5'>No se encontraron resultados para esta consulta</font></div></b><BR>";
			}
			
		//	$link_remoto = mysql_connect("190.202.94.42","inventa_bd","Valenta@04") or die ("-4->".mysql_error());
			if($link_remoto=mysql_connect("10.0.0.20","inventa_bd","Valenta@04"))
			{
				mysql_select_db("inventa_pglibreria",$link_remoto);
				
				//Se busca el articulo en distinventario
				$sql_distinventario="select * from tbl_distinventario where cod_producto='$cod_pro'";
				$result_distinv = mysql_query($sql_distinventario,$link_Busca) or die($sql_distinventario."<br>-5->".mysql_error());
				if ($row_distinv= mysql_fetch_array($result_distinv)) 
				{//die("me quede aqui");
					//Si existe se actualiza la informacion de la cantidad
					do 
					{
						$sql_update_distinv="update tbl_distinventario set cantidad=cantidad + '$cantidad' where cod_producto='$cod_pro'";
						$result_updt_distinv=mysql_query($sql_update_distinv,$link_remoto) or die($sql_update_distinv."<br>-6->".mysql_error());
					} while ($row_distinv= mysql_fetch_array($result_distinv));
				}
				else
				{
					echo "<b><div align='center'><font  size='5'>No se encontraron resultados para esta consulta</font></div></b><BR>";
				}
			}
			else
			{
				die("No es posible conectarse al servidor remoto");
			}
			//Actualizar informacion en tbl_itemfactura
			$sql_update_item="update tbl_itemfactura set existencia=existencia+ '$cantidad',estatus_cancelacion='5' where cod_producto='$cod_pro' and cod_factura='$cod_factura' and sucursal='$sucursal'";
			//die($sql_update_item);
			$obj->consultar($sql_update_item);
			$obj->consultar_remoto($sql_update_item);
			//$result_updt_item=mysql_query($sql_update_item,$link_Busca) or die(($sql_update_item."<br>-7->".mysql_error());
			
		
		} while ($rowitem= mysql_fetch_array($result_item));
	}
	else
	{
		echo "<b><div align='center'><font  size='5'>No se encontraron resultados para esta consulta</font></div></b><BR>";
	}
}


//if(@mysql_query($sql_update,$link_Busca))
if($obj->consultar($sql_update))
{
	$obj->consultar_remoto($sql_update);
	
	if($estatus_factura==5)
		echo "<div align=center><b><font size=5 color=red>La factura ".$cod_factura." ha sido anulada</font></b></div><br>";
	else
		echo "<div align=center><b><font size=5 color=blue>La factura ".$cod_factura." ha sido actualizada</font></b></div><br>";
	
	//Abre el cierre del día nuevamente para reprocesarlo
	$sql_update_cierre="update tbl_cierre set estatus=6 where fecha='$fechacorta'";
	$result_updt_cierre=mysql_query($sql_update_cierre,$link_Busca) or die($sql_update_cierre."<br>-8->".mysql_error());

} 
else
{
	"No se pudo actualizar la factura<br>";
}
?>
<form action=""  method="post">  
<div align='center'><input name="salir" type="button" class="botones" onclick="esc()" value="Salir" /></div>
 </form>


