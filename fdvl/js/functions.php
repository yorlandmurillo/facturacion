<?php
include("conexion.php");
function cambia_a_american($valor){
	return str_replace(',','.',str_replace('.','',$valor));
}
//////////////////////////////////////////////////// 
//Convierte fecha de mysql a normal 
//////////////////////////////////////////////////// 
function cambiaf_a_normal($fecha){ 
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); 
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]; 
    return $lafecha; 
} 

//////////////////////////////////////////////////// 
//Convierte fecha de normal a mysql 
//////////////////////////////////////////////////// 
function cambiaf_a_mysql($fecha){ 
    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha); 
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]; 
    return $lafecha; 
} 

function f_select_vendedor(&$cod_vend,&$vend,&$tlf,&$mail)
{
	//include("includes/conexion.php");
	$link=conectarse();
	$result=mysql_query("select * from inv_vende where ven_codven = '".$cod_vend ."'",$link);
	if($row = mysql_fetch_array($result))
	{
		$vend=$row["ven_nombre"];
		$tlf=$row["ven_telef"];
		$mail=$row["ven_mail"];
	}
	mysql_free_result($result);
	mysql_close($link);
}
function f_select_transaccion(&$cod_trans,&$trans,&$tipo_trans)
{
	//include("includes/conexion.php");
	$link=conectarse();
	$result=mysql_query("select * from inv_transac where trs_codtrs = '".$cod_trans ."'",$link);
	if($row = mysql_fetch_array($result))
	{
		$trans=$row["trs_descrip"];
		$tipo_trans=$row["trs_tiptrs"];
	}
	mysql_free_result($result);
	mysql_close($link);
}
function f_select_autor(&$cod_autor,&$autor,&$pais)
{
	//include("includes/conexion.php");
	$link=conectarse();
	$result=mysql_query("select * from inv_autor where aut_codigo = '".$cod_autor ."'",$link);
	if($row = mysql_fetch_array($result))
	{
		$autor=strtoupper($row["aut_nombre"]);
		$pais=$row["aut_pais"];
	}
	mysql_free_result($result);
	mysql_close($link);
}
function f_select_empaque(&$cod_empaque,&$empaque)
{
	//include("includes/conexion.php");
	$link=conectarse();
	$result=mysql_query("select * from inv_empaque where emp_codemp = '".$cod_empaque ."'",$link);
	if($row = mysql_fetch_array($result))
	{
		$empaque=$row["emp_descrip"];
	}
	mysql_free_result($result);
	mysql_close($link);
}
function f_select_usuario(&$cedula,&$nombre,&$login)
{
	//include("includes/conexion.php");
	$link=conectarse();
	$result=mysql_query("select * from inv_user where usr_cedula = '".$cedula ."'",$link);
	if($row = mysql_fetch_array($result))
	{
		$nombre=$row["usr_user"];
		$login=$row["usr_login"];
	}
	mysql_free_result($result);
	mysql_close($link);
}
function f_select_proveedor(&$cod_prov, &$prov, &$direccion, &$pto_ref, &$tlf, &$fax, &$rif, &$nit, &$web, &$contacto, &$mail, &$tipo_edi, &$id_corta)
{
	//include("includes/conexion.php");
	$link=conectarse();
	$result=mysql_query("select * from inv_provee where prv_codpro = '".$cod_prov ."'",$link);
	if($row = mysql_fetch_array($result))
	{
		$prov=$row["prv_nombre"];
		$direccion=$row["prv_direc"];
		$pto_ref=$row["prv_ptoref"];
		$tlf=$row["prv_telef"];
		$fax=$row["prv_fax"];
		$rif=$row["prv_rif"];
		$nit=$row["prv_nit"];
		$web=$row["prv_web"];
		$contacto=$row["prv_contac"];
		$mail=$row["prv_mail"];
		$tipo_edi=$row["prv_tipop"];
		$id_corta=$row["prv_id"];
	}
	mysql_free_result($result);
	mysql_close($link);
}						
function f_select_cliente(&$cod_cliente, &$cliente, &$direccion, &$pto_ref, &$tlf, &$fax, &$rif, &$nit, &$web, &$contacto, &$mail, &$tipo_lib, &$id_corta)
{
	//include("includes/conexion.php");
	$link=conectarse();
	$result=mysql_query("select * from inv_cliente where clt_codcli = '".$cod_cliente ."'",$link);
	if($row = mysql_fetch_array($result))
	{
		$cliente=utf8_decode($row["clt_nombre"]);
		$direccion=utf8_decode($row["clt_direc"]);
		$pto_ref=utf8_decode($row["clt_ptoref"]);
		$tlf=$row["clt_telef"];
		$fax=$row["clt_fax"];
		$rif=$row["clt_rif"];
		$nit=$row["clt_nit"];
		$web=$row["clt_web"];
		$contacto=utf8_decode($row["clt_contac"]);
		$mail=$row["clt_mail"];
		$tipo_lib=$row["clt_tipoc"];
		$id_corta=$row["clt_id"];
	}
	mysql_free_result($result);
	mysql_close($link);
}						
function f_select_ubicacion(&$cod_ubic, &$ubic, &$local, &$salon, &$pasillo, &$color, &$estante)
{
	//include("includes/conexion.php");
	$link=conectarse();
	$result=mysql_query("select * from inv_ubicac where ubi_codigo = '".$cod_ubic ."'",$link);
	if($row = mysql_fetch_array($result))
	{
		$ubic=$row["ubi_descri"];
		$local=$row["ubi_local"];
		$salon=$row["ubi_salon"];
		$pasillo=$row["ubi_pasillo"];
		$color=$row["ubi_color"];
		$estante=$row["ubi_estante"];
	}
	mysql_free_result($result);
	mysql_close($link);
}						
function f_select_libro(&$cod_libro, &$cod_isbn, &$autor, &$empaque, &$fch_creacion, &$stock_min, &$stock_max, &$observaciones, 
						&$titulo, &$editorial, &$cta_contable, &$cta_presup, &$ubi_almacen, &$saldo_cierre, &$exist1, &$costo1, 
						&$costo_p1, &$precio1, &$precio_p1, &$fch_compra1, &$exist2, &$costo2, &$costo_p2, &$precio2, &$precio_p2, 
						&$fch_compra2, &$formato, &$coleccion, &$num_tomo, &$num_libsur, &$tema, &$ano_pub, &$cant_pag, &$serie,&$lib_codbarra,&$iva, &$t_articulo, &$tema2)
{
	$link=conectarse();
	$result=mysql_query("select * from inv_libros where lib_codart = '".$cod_libro ."'",$link);
	if($row = mysql_fetch_array($result))
	{
		$cod_isbn=$row["lib_codsib"];
		$lib_codbarra=$row["lib_codbarra"];
		$titulo=$row["lib_descri"];
		$empaque=$row["lib_coduni"];
		$fch_creacion=$row["lib_fchlib"];
		$autor=$row["aut_codigo"];
		$editorial=$row["prv_codpro"];
		$stock_min=$row["lib_stomin"];
		$stock_max=$row["lib_stomax"];
		$exist1=$row["lib_exiant"];
		$costo1=number_format($row["lib_cosant"],2,',','.');
		$costo_p1=number_format($row["lib_cospan"],2,',','.');
		$precio1=number_format($row["lib_preant"],2,',','.');
		$precio_p1=number_format($row["lib_prepan"],2,',','.');
		$fch_compra1=$row["lib_fchcan"];
		$exist2=$row["lib_exiact"];
		$costo2=number_format($row["lib_cosact"],2,',','.');
		$costo_p2=number_format($row["lib_cospac"],2,',','.');
		$precio2=number_format($row["lib_preact"],2,',','.');
		$precio_p2=number_format($row["lib_prepac"],2,',','.');
		$fch_compra2=$row["lib_fchcac"];
		$cta_presup=$row["lib_ctapre"];
		$cta_contable=$row["lib_ctacon"];
		$ubi_almacen=$row["lib_ubicac"];
		$observaciones=utf8_decode($row["lib_observ"]);
		$saldo_cierre=$row["lib_saldan"];
		$formato=$row["lib_present"];
		$coleccion=$row["col_colecc"];
		$num_tomo=$row["lib_numedit"];
		$num_libsur=$row["lib_numkuai"];
		$tema=utf8_decode($row["lib_tema"]);
		$tema2=utf8_decode($row["lib_tema"]);
		$ano_pub=$row["lib_anopub"];
		$cant_pag=utf8_decode($row["lib_canpag"]);
		$serie=$row["ser_serie"];

		$t_articulo=$row["lib_articulo"];
		$iva=$row["lib_iva"];

	}
	mysql_free_result($result);
	mysql_close($link);
}						
?>
