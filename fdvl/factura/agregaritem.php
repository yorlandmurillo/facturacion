
<?php
include_once("manejadordb.php");
//variables POST
$obj=new manejadordb;

$codp=$obj->setcodp_remoto(trim(str_replace("\n","",$_POST['codp'])));
$precio=$obj->setprecio_remoto($codp);
//echo $precio;
$codf=trim($_POST['codf']);
$cant=trim($_POST['cant']);
$string = str_replace("\n","",$string);
$suc=trim($_POST['suc']);
$vend=trim($_POST['vend']);
$valor=0;
$valor2=0;
$vcantf=0;
$vcantc=0;
$vcantcdn=0;
$vif=0;
$vic=0;
$vicdn=0;
//Revisamos si hay mas de un libro con el mismo código de barra
$queryduplicado =$obj->codbarraduplicado_remoto(trim(str_replace("\n","",$_POST['codp'])));

if($queryduplicado==1 || $queryduplicado==0)
{
	if($precio>0)
	{
	
		//Se revisa el limite de items por factura
	/*	$querylimite = "SELECT * FROM tbl_itemfactura WHERE cod_factura = '".addslashes($codf)."' and cod_producto<> '".addslashes($codp)."' 
						and estatus_cancelacion=0 and sucursal=$suc and vendedor=$vend";

		$itemlimite=$obj->consultar($querylimite);
		$rowlimite = mysql_num_rows($itemlimite);
		/*if(getpreferencia($suc,'libros_pf')==10)
		{
			//El limite array lo determina la funcion getpreferencia
			$limite_array=getpreferencia($suc,'libros_pf')-1;
		}
		elseif(getpreferencia($suc,'libros_pf')==0)
		{*/
			$limite_array=$rowlimite+1;
		//} 
		if($rowlimite<=$limite_array)
		{//die("-*->Estoy en el primer paso");
			//Se verifica si el articulo existe en la tabla inventario
			$laexistencia=$obj->verificarexist_remoto($codp);
			if($obj->verificarexist_remoto($codp)>0)
			{//die("-*->Estoy en el if que verifica la existencia:".$laexistencia);
				//Se busca el articulo en tbl_distinventario
				$querya = "SELECT Sum(cantidad) AS cantidad  FROM tbl_distinventario WHERE cod_producto ='".addslashes($codp)."' and sucursal=$suc and condicion=1
				GROUP BY tbl_distinventario.cod_producto, tbl_distinventario.sucursal";
				//die($querya);
				$result=$obj->consultar_remoto($querya);
				$f=mysql_fetch_assoc($result);
				$cantf=$f['cantidad'];
				//Se busca el articulo en tbl_distinventario condiciones diferentes a 1
				$queryb = "SELECT * FROM tbl_distinventario WHERE cod_producto ='".addslashes($codp)."' and sucursal=$suc and condicion=2";
				$result=$obj->consultar_remoto($queryb);
				$f=mysql_fetch_assoc($result);
				$cantc=$f['cantidad'];
				$queryc = "SELECT * FROM tbl_distinventario WHERE cod_producto ='".addslashes($codp)."' and sucursal=$suc and condicion=3";
				$result=$obj->consultar_remoto($queryc);
				$f=mysql_fetch_assoc($result);
				$cantcdn=$f['cantidad'];
				//Se suma las cantidades halladas y se guarda en la variable $inv
				$inv=$cantf+$cantc+$cantcdn;
				
				//Se busca el detalle de la factura que se esta procesando para saber si ya el libro había sido agregado
				$query1 = "SELECT * FROM tbl_itemfactura WHERE cod_factura = '".addslashes($codf)."' and cod_producto= '".addslashes($codp)."' 
							and estatus_cancelacion=0 and sucursal=$suc and vendedor=$vend";
				$item=$obj->consultar($query1);
				$row = mysql_num_rows($item);

				if($row==0)
				{//die("No existe en itemfactura=>".$cant."-*-".$inv);
					//El libro no ha sido agregado aún
					if($cant <= $inv)
					{
						//La cantidad requerida es menor o igual que la existente en tbl_distinventario
						if($cantf>=0 && $cant>0)
						{
							//La cantidad de libros en condicion firme es mayor de cero y la cantidad pedida es mayor de cero
							if($cantf>=$cant)
							{
								//La cantidad de libros en condicion firme es mayor que la cantidad requerida
								//Se descuenta la cantidad requerida de la existente en tbl_distinventario
								$queryupdate="update tbl_distinventario set cantidad=cantidad-$cant WHERE cod_producto ='".addslashes($codp)."' 
												and sucursal=$suc and condicion=1 ORDER BY cantidad,FECHA_NOTA_ENTREGA DESC LIMIT 1 ";

								$vif=$cant;
							}
							else
							{
								$valor=$cant-$cantf;
								$vcantf=$cantf;
								$vif=$cantf;
								$queryupdate="update tbl_distinventario set cantidad=0 WHERE cod_producto ='".addslashes($codp)."' and sucursal=$suc and condicion=1";
							}
						}

						if($cantc>=0 && $valor>0)
						{
							if($cantc>=$valor)
							{
								$queryupdate="update tbl_distinventario set cantidad=cantidad-$valor WHERE cod_producto ='".addslashes($codp)."' 
												and sucursal=$suc and condicion=2 ";
								$vic=$valor;
							}
							else
							{
								$valor2=$valor-$cantc;
								$vcantc=$cantc;
								$vic=$cantc;
								$queryupdate="update tbl_distinventario set cantidad=0 WHERE cod_producto ='".addslashes($codp)."' and sucursal=$suc and condicion=2 LIMIT 1";
							}
						}
						if($cantcdn>=0 && $valor2>0)
						{
							if($cantcdn>=$valor2)
							{
								$queryupdate="update tbl_distinventario set cantidad=cantidad-$valor2 WHERE cod_producto ='".addslashes($codp)."' 
												and sucursal=$suc and condicion=3 LIMIT 1";

								$vicdn=$valor2;
							}
						}
						
						//Se busca el articulo en tbl_inventario
						$query = "SELECT * FROM tbl_inventario WHERE cod_producto= '".addslashes($codp)."' or cod_barra = '".addslashes($codp)."' ";
						if($obj->consultar_remoto($query)!=false)
						{//die("Buscando el articulo ".$codp." en tbl_inventario");
							//Si existe el articulo se consulta nuevamente su existencia
							 $inventario=$obj->consultar_remoto($query);
							 $row = mysql_fetch_array($inventario);
							 $codigo=$row['cod_producto'];
							 //Se dtermina el precio que aparecera en la factura
							 $preciounid=round($obj->setprecio_remoto($row['cod_producto'])-($obj->setprecio_remoto($row['cod_producto'])*$obj->setdescuento_remoto($row['cod_producto'],$suc)),4);
							//Se determina la nueva existencia del libro
							$existencia=($obj->getexistencia_remoto($codigo,$suc))-$cant;
							 $descripcion=$row['descripcion'];   
							 $isbn=$row['isbn'];
							 $descuento=$obj->setdescuento_remoto($row['cod_producto'],$suc);
							 $precio_sd=round($obj->setprecio_remoto($row['cod_producto']),4);
							 $iva=$obj->setiva_remoto($codigo);
							//die("-*->".$iva);
							//Se crea el item en la factura
							if($obj->crearitem($codigo,$codf,$cant,$preciounid,$existencia,$descripcion,$vend,$suc,$isbn,$vif,$vic,$vicdn,$descuento,$precio_sd,$iva)==true)
							{//die("Se creo el item en la factura");
								//$obj->query($queryupdate);//Se conecta al servidor local
								$obj->query_remoto($queryupdate);//Se conecta al servidor remoto
							}
						}
						//echo utf8_encode("Se Anexó a la factura");
						echo "1";
					}
					else 
						echo "No se pueden vender mas libros de los que hay en inventario";


				}
				elseif($row>0)
				{
					//El libro ya había sido agregado a la factura
					if($cant <= $inv)
					{
						if($cantf>=0 && $cant>0)
						{
							//La cantidad de libros en condicion firme es mayor de cero y la cantidad pedida es mayor de cero
							if($cantf>=$cant)
							{
								//La cantidad de libros en condicion firme es mayor que la cantidad requerida
								//Se descuenta la cantidad requerida de la existente en tbl_distinventario
								$queryupdate2="update tbl_distinventario set cantidad=cantidad-$cant WHERE cod_producto ='".addslashes($codp)."' 
								and sucursal=$suc and condicion=1 ORDER BY cantidad,FECHA_NOTA_ENTREGA DESC LIMIT 1";
								$vif=$cant;
							}
							else
							{
								$valor=$cant-$cantf;
								$vcantf=$cantf;
								$vif=$cantf;
								$queryupdate2="update tbl_distinventario set cantidad=0 WHERE cod_producto ='".addslashes($codp)."' and sucursal=$suc and condicion=1 ";
							}
						}
						if($cantc>=0 && $valor>0)
						{
							if($cantc>=$valor)
							{
								$queryupdate2="update tbl_distinventario set cantidad=cantidad-$valor WHERE cod_producto ='".addslashes($codp)."' and sucursal=$suc and condicion=2";
								$vic=$valor;
							}
							else
							{
								$valor2=$valor-$cantc;
								$vcantc=$cantc;
								$vic=$cantc;
								$queryupdate2="update tbl_distinventario set cantidad=0 WHERE cod_producto ='".addslashes($codp)."' and sucursal=$suc and condicion=2";
							}
						}
						if($cantcdn>=0 && $valor2>0)
						{
							if($cantcdn>=$valor2)
							{
								$queryupdate2="update tbl_distinventario set cantidad=cantidad-$valor2 WHERE cod_producto ='".addslashes($codp)."' and sucursal=$suc and condicion=3";
								$vicdn=$valor2;
							}
						}
						//Se agrega la cantidad requerida a la ya existente en el detalle de la factura
						if($obj->query("update tbl_itemfactura set cantidad=cantidad+$cant,existencia=existencia-$cant,cif=cif+$vif,cic=cic+$vic,cicdn=cicdn+$vicdn WHERE cod_factura = '".addslashes($codf)."' and cod_producto= '".addslashes($codp)."' and estatus_cancelacion=0 and sucursal=$suc and vendedor=$vend ORDER BY cantidad DESC LIMIT 1")==true)
						{
							//$obj->query($queryupdate2);//Se conecta al servidor local
							$obj->query_remoto($queryupdate2);
							echo utf8_encode("Se sumo a la factura");
						} 

					}
					else 
						echo "No se pueden vender mas libros de los que hay en inventario";
				}
			}
			else 
				echo utf8_encode("No existe el código en el inventario");
		}
		else 
			echo "No se pueden cargar más de 10 titulos a la factura";
		}
		else 
		echo "El precio del articulo debe ser mayor que cero";
}
else 
{
	//Existe mas deun libro con el mismo código de barra
	echo "2".$_POST['codp'];			
}

?>
