<?
include_once("manejadordb.php");
//variables POST

function validaCorreo($valor)
{
	if(eregi("([a-zA-Z0-9._-]{1,30})@([a-zA-Z0-9.-]{1,30})", $valor)) return TRUE;
	else return FALSE;
}

$cedula=$_POST['clicedula'];
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

if(trim($cedula)!="" && trim($nom)!="" && $cedula!="0")
{

	if($band==1)
	{
		if(empty($clicorreo)){$clicorreo="-";}		
		if ($obj->editarcliente_remoto("update tbl_cliente set cli_nombre='$nom',cli_direccion='$clidireccion',cli_telefonohab='$clitelefono',cli_celular='$clicelular',cli_bonolibro=$pbl,cli_correo='$clicorreo',cli_tarjetabl='$bl',cli_empresa='$cliempresa',cli_sexo='$sexo' where cli_cedula='$cedula' ")==true)
		{
			echo "<strong>Cliente modificado correctamente</strong>";
				
		}
		else
		{
			echo "<strong>Error de grabaci&oacute;n</strong>";
		}
			
	}
	else echo utf8_encode("<strong>Debe especificar una dirección de correo válida</strong>");

}else {echo "<strong>Los campos con (*) son obligatorios</strong>";}

?>