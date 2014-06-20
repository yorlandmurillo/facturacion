<?
include_once("manejadordb.php"); 


function validaCorreo($valor)
{
	if(eregi("([a-zA-Z0-9._-]{1,30})@([a-zA-Z0-9.-]{1,30})", $valor)) return TRUE;
	else return FALSE;
}

$cedula=trim($_POST['clicedula']);
$nom=utf8_decode($_POST['clinombre']);
$bl=$_POST['clibl'];
$sexo=$_POST['sexo'];
$clidireccion=utf8_decode($_POST['clidireccion']);
$clitelefono=$_POST['clitelefono'];
$clicelular=$_POST['clicelular'];
$cliempresa=utf8_decode($_POST['cliempresa']);
$clicorreo=$_POST['clicorreo'];
$pbl=$_POST['pbl'];
//creamos el objeto 
//y usamos su método crear

$obj=new manejadordb;

$band=1;

if(!empty($clicorreo)){
	if(validaCorreo($clicorreo)==false){
		$band=0;
	}else {$band=1;}
}

if($cedula!="" && trim($nom)!="" && $cedula!="0"){

if($band==1){

if(empty($clicorreo)){$clicorreo="user@dominio.ext";}
		if ($obj->existencia_remoto($cedula)==false){
		
		if ($obj->insertarcliente_remoto("INSERT INTO tbl_cliente 			(cli_cedula,cli_nombre,cli_direccion,cli_telefonohab,cli_celular,cli_bonolibro,cli_correo,cli_tarjetabl,cli_empresa,cli_sexo,fecha_inclusion)
	 VALUES ('$cedula','$nom','$clidireccion','$clitelefono','$clicelular',$pbl,'$clicorreo','$bl','$cliempresa','$sexo','".$obj->getfechamysql()."')")==true){
	echo "<strong>Cliente grabado correctamente</strong>";
		}else{echo "<strong>Error de grabaci&oacute;n</strong>";}

		}else {echo "<strong>Este Registro ya existe</strong>";}
	
}else echo utf8_encode("<strong>Debe especificar una dirección de correo válida</strong>");

}else {echo "<strong>Los campos con (*) son obligatorios</strong>";}
?>