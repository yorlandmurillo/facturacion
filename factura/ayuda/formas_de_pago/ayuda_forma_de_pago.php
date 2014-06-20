<?php
if(isset($_GET['efect']))
{
?>
	<p><div align=center><font size=5 color=blue><b>Pago solo en efectivo</b></font></div></p>
	<div align=center><font size=5>Se hace clic en la casilla de efectivo y automáticamente se coloca el monto.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_solo_efectivo.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Una vez verificado el pago se clic en aceptar</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_solo_efectivo_aceptar.jpg" alt="" width="75%"/></div>
	
	<div align=center><font size=5><a href="ayuda_forma_de_pago.php"><b>REGRESA AL MENU</a></b></font></div>
<?
}
elseif(isset($_GET['efect_cambio']))
{
?>
	<p><div align=center><font size=5 color=blue><b>Pago solo en efectivo con cambio</b></font></div></p>
	<div align=center><font size=5>Se hace clic en la casilla de efectivo y automáticamente se coloca el monto.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_solo_efectivo.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Se coloca en la casilla de efectivo el monto real que pagara el cliente, al hacer clic en calcular se mostrara el cambio</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_cambio.jpg" alt="" width="75%"/></div>
	<br><br>
	
	<div align=center><img src="imagenes/forma_de_pago_efectivo_cambio_aceptar.jpg" alt="" width="75%"/></div>
	
	
	<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php"><b>REGRESA AL MENU</a></b></font></div>
<?
}
elseif(isset($_GET['efect_debito']))
{
?>
	<p><div align=center><font size=5 color=blue><b>Pago en efectivo y débito</b></font></div></p>
	<p><div align=center><font><b>(También aplicable a cualqueir forma de pago que involucre a efectivo junto a otra modalidad)</b></font></div></p>
	<br><br>
	<div align=center><font size=5>Se le pregunta a la persona cuánto va a cancelar en efectivo y cuánto en débito.</b></font></div>
	<br><br>

	
	<br><br>
	<div align=center><font size=5>Se hace clic en la casilla de efectivo y automáticamente se coloca el monto.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_solo_efectivo.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Se le resta al efectivo la cantidad que se pagara en débito</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_1.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Luego se hace clic en débito y automáticamente se colocara la cantidad restante para totalizar el monto de la factura.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_2.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Una vez verificado el pago se clic en aceptar</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_aceptar.jpg" alt="" width="75%"/></div>
	<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php"><b>REGRESA AL MENU</a></b></font></div>
<?
}
elseif(isset($_GET['efect_debito_cambio']))
{
?>
	<p><div align=center><font size=5 color=blue><b>Pago en efectivo y débito con cambio</b></font></div></p>
	<p><div align=center><font><b>(También aplicable a cualqueir forma de pago que involucre a efectivo junto a otra modalidad)</b></font></div></p>
	<div align=center><font size=5>Se le pregunta a la persona cuánto va a cancelar en efectivo y cuánto en débito.</b></font></div>
	
	<br><br>
	<div align=center><font size=5>Se hace clic en la casilla de efectivo y automáticamente se coloca el monto.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_solo_efectivo.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Se le resta al efectivo la cantidad que se pagara en débito</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_cambio_1.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Luego se hace clic en débito y automáticamente se colocara la cantidad restante para totalizar el monto de la factura.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_cambio_2.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Se coloca en la casilla de efectivo el monto real que pagara el cliente, al hacer clic en calcular se mostrara el cambio</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_cambio_3.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Una vez verificado el pago se clic en aceptar</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_cambio_aceptar.jpg" alt="" width="75%"/></div>
	<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php"><b>REGRESA AL MENU</a></b></font></div>
<?
}
elseif(isset($_GET['debito_credito']))
{
?>
	<p><div align=center><font size=5 color=blue><b>Pago en débito y crédito</b></font></div></p>
	<div align=center><font size=5>Se le pregunta al cliente cuánto cancelara por cada modalidad, en este caso se sugiere anotar las formas de pago con sus montos en un papel para luego pasarlo al sistema.</b></font></div>

	<br><br>
	<div align=center><font size=5>Se hace clic en la casilla de efectivo y automáticamente se coloca el monto.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_solo_efectivo.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Se le resta al efectivo la cantidad que se pagara en crédito</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_1.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Se hace clic en crédito para que se coloque automáticamente la cantidad correspondiente.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_credito_1.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Ahora en la casilla de efectivo se coloca la cantidad cero (0.00)</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_debito_credito_2.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Luego se hace clic en débito y automáticamente se colocara la cantidad restante para totalizar el monto de la factura.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_debito_credito_3.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Una vez verificado el pago se clic en aceptar</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_debito_credito_aceptar.jpg" alt="" width="75%"/></div>
	
	
	
	<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php"><b>REGRESA AL MENU</a></b></font></div>
<?
}
elseif(isset($_GET['efectivo_debito_credito']))
{
?>
	<p><div align=center><font size=5><b>Pago en efectivo,debito y crédito</b></font></div></p>
	<div align=center><font size=5>Se le pregunta al cliente cuánto cancelara por cada modalidad, en este caso se sugiere anotar las formas de pago con sus montos en un papel para luego pasarlo al sistema.</b></font></div>

	<br><br>
	<div align=center><font size=5>Se hace clic en la casilla de efectivo y automáticamente se coloca el monto.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_solo_efectivo.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Se le resta al efectivo la cantidad que se pagara en débito</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_credito_1.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Se hace clic en débito para que se coloque automáticamente la cantidad correspondiente.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_credito_2.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Se le resta al efectivo la cantidad que se pagara en crédito</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_credito_3.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Luego se hace clic en crédito y automáticamente se colocara la cantidad restante para totalizar el monto de la factura.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_credito_4.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Una vez verificado el pago se clic en aceptar</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_debito_credito_aceptar.jpg" alt="" width="75%"/></div>
	<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php"><b>REGRESA AL MENU</a></b></font></div>
<?
}
elseif(isset($_GET['efectivo_bonolibro']))
{
?>
	<p><div align=center><font size=5><b>Pago en efectivo y débito</b></font></div></p>
	<p><div align=center><font><b>(También aplicable a cualqueir forma de pago que involucre a efectivo junto a otra modalidad)</b></font></div></p>
	<div align=center><font size=5>Se le pregunta a la persona cuánto va a cancelar en efectivo y cuánto en bonolibro.</b></font></div>
	<br><br>
	<div align=center><font size=5>Se hace clic en la casilla de efectivo y automáticamente se coloca el monto.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_solo_efectivo.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Se le resta al efectivo la cantidad que se pagara en bonolibro</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_bonolibro_1.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Luego se hace clic en bonolibro y automáticamente se colocara la cantidad restante para totalizar el monto de la factura.</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_bonolibro_2.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Una vez verificado el pago se clic en aceptar</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_efectivo_bonolibro_aceptar.jpg" alt="" width="75%"/></div>
	<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php"><b>REGRESA AL MENU</a></b></font></div>
<?
}
elseif(isset($_GET['cheque']))
{
?>
	<p><div align=center><font size=5 color=blue><b>Pago solo en cheque</b></font></div></p>
	<br><br>
	<div align=left><font size=5>Se hace clic en la casilla de cheque y automáticamente se coloca el monto. Se rellenan las casillas con los datos del cheque y del Banco emisor</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_cheque.jpg" alt="" width="75%"/></div>
	<br><br>
	<div align=center><font size=5>Una vez verificado el pago se clic en aceptar</b></font></div>
	<div align=center><img src="imagenes/forma_de_pago_cheque_aceptar.jpg" alt="" width="75%"/></div>
	
	<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php"><b>REGRESA AL MENU</a></b></font></div>
<?
}
else
{
?>
<html>
<head>
<link href="js/css_intra/datepickercontrol.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/js_intra/datepickercontrol.js"></script>

</head>
<body>
<div align=center><font size=5><b>Formas de pago de la factura</a></b></font></div>
<div align=center><img src="imagenes/forma_de_pago_en_cero.jpg" alt="" width="50%"/></div>
 <br><br>

<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php?efect=1"><b>Pago solo en efectivo</a></a></b></font></div>
<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php?efect_cambio=1"><b>Pago solo en efectivo con cambio</a></a></b></font></div>
<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php?efect_debito=1"><b>Pago en efectivo y débito</a></b></font></div>
<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php?efect_debito_cambio=1"><b>Pago en efectivo y débito con cambio</a></b></font></div>
<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php?debito_credito=1"><b>Pago en débito y crédito</a></b></font></div>
<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php?efectivo_debito_credito=1"><b>Pago en efectivo,debito y crédito</a></b></font></div>
<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php?efectivo_bonolibro="><b>Pago en efectivo y bonolibro</a></b></font></div>
<div align=center><font size=5 color=blue><a href="ayuda_forma_de_pago.php?cheque=1"><b>Pago en cheque</a></b></font></div>
   


</body>
</html>
<?
}
?>
