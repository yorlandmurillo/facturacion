<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?
$variablexx = 'NE2010010101';
$correo = isset($_POST['Correo'])?$_POST['Correo']:'';
	$copia = "aromero@distribuidoradellibro.gob.ve";
 $dest = $correo; 
 $head = "From: FUNDACION DISTRIBUIDORA VENEZOLANA DEL LIBRO".$_POST['aromero@distribuidoradellibro.gob.ve']."\r\n";
 $variable = "NOTA DE ENTREGA  ".$variablexx."\r\n";
 $head.= utf8_decode("Mediante el presente correo electrónico, adjunto la información generada por nuestro Sistema en la Fundación Distribuidora Venezolana del Libro");
 // Ahora creamos el cuerpo del mensaje
 $msg = "------------------------------------------------------------------------------------- \n";
 $msg.=utf8_decode("                        DESCRIPCIÓN DE LA NOTA DE ENTREGA                             \n");
 $msg.= "------------------------------------------------------------------------------------- \n";
 $msg.= utf8_decode("NOMBRE:   ".$variablexx." ".$variablexx."\n");
 $msg.= utf8_decode("EMAIL:    ".$_POST['Correo']."\n");
 $msg.= "HORA:     ".date("h:i:s a ")."\n";
 $msg.= "FECHA:    ".date("D, d M Y")."\n";
 $msg.= "------------------------------------------------------------------------------------- \n\n";
 $msg.= utf8_decode("En caso de Fallas de envió comuníquese al Teléfono 0424.160.96.85"."\n");
 $msg.= "------------------------------------------------------------------------------------- \n\n";
 $msg.= "Mensaje Enviado desde www.distribuidoradellibro.gob.ve\n";
 // Finalmente enviamos el mensaje
 if (mail("$dest,$copia",$variable, $msg, $head)) {


?>
 <script>alert('SE ENVIO EL ARCHIVO POR CORREO'); history.back(); </script>  
    <? 

 } else {
?>
      <script>alert('Error al momento de enviar la Nota de Entrega al Librero por favor comuníquese con Alberto Romero'); history.back(); </script>  
    <?
 }
?>

</head>

