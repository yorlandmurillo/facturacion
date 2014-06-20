<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

 <?
  $usuario=$_SESSION['Nusuario'];
      ?> 
      
<div id="navegador">
	<p>
	<SPAN class='texto_original'>
					<a href="#"></a> SISTEMA DE INVENTARIO | OPERATIVO | <? echo "$usuario"; ?>
		<a href="#"></a></SPAN>

  </p>
</div>

<style type="text/css">
A:link {
	text-decoration: none;
	color:#900;
}
A:visited {text-decoration: none}
A:active {text-decoration: none}
A:hover {text-decoration: underline;
color:#999;

}
</style>

  
<link href="alberto.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="">

</script>
</head>
<script>
function scr(){
	vrequerimiento=window.open("","vrequerimiento","top=0,left=0,width=1008,height=708,channelmode=0,dependent=0,directories=0,fullscreen=0,location=0,menubar=0,resizable=1,scrollbars=1,status=0,toolbar=0");
	vrequerimiento.location="";
}
</script>

<script>
function planilla(){
	vpan=window.open("","vpan","top=0,left=0,width=1008,height=708,channelmode=0,dependent=0,directories=0,fullscreen=0,location=0,menubar=0,resizable=1,scrollbars=1,status=0,toolbar=0");
	vpan.location="";
}
</script>


<body leftmargin="0" topmargin="0" rightmargin="0" marginwidth="0" marginheight="0">
<table border="1" width="100%" id="table1" style="border-width: 0px" height="198">
	<tr>
		<td height="15" colspan="2" align="left" valign="top" bgcolor="#999999" style="border-style: none; border-width: medium">
		<p style="margin-top: 0; margin-bottom: 0"><b>
	  <font face="Verdana" style="font-size: 8pt" color="#FFFFFF"> Modulo de Operativo </font></b></td>
	</tr>
	<tr>
    
      
            
	  <td height="15" align="left" valign="top" bgcolor="#FFFFFF" style="border-style: none; border-width: medium"><ul>
				
                
                <li class="CIREDLista"><a class="CIREDLista" href="inventario.php?p=librosConsulta" ><span class="CIREDContenidoTabla" ><span class="CIREDLink">Consulta de Libros </span></span></a>
                <li class="CIREDLista"><a class="CIREDLista" href="inventario.php?p=Pedido"><span class="CIREDContenidoTabla"><span class="CIREDLink">Pedido</span></span></a>
          <li class="CIREDLista"><a class="CIREDLista" href="inventario.php?p=reimpresion"><span class="CIREDContenidoTabla"><span class="CIREDLink">Consulta de Nota de Entrega, Pedido y Control Perceptivo</span></span></a>
          <li class="CIREDLista"><a class="CIREDLista" href="inventario.php?p=RecepcionLS" ><span class="CIREDContenidoTabla" ><span class="CIREDLink">Procesar el Control Perceptivo</span></span></a>
  
     <li class="CIREDLista"><a class="CIREDLista" href="inventario.php?p=actualizar" ><span class="CIREDContenidoTabla" ><span class="CIREDLink">Actualización de Libros</span></span></a>
  
    <li class="CIREDLista"><a class="CIREDLista" href="inventario.php?p=estadisticaslb"><span class="CIREDContenidoTabla"><span class="CIREDLink">Monitoreo de Notas de Entrega</span></span></a>
    
      <li class="CIREDLista"><a class="CIREDLista" href="inventario.php?p=devolucion"><span class="CIREDContenidoTabla"><span class="CIREDLink">Devoluciones </span></span></a>
      
  <li class="CIREDLista"><a class="CIREDLista" href="inventario.php?p=cambiacbarra" ><span class="CIREDContenidoTabla" ><span class="CIREDLink">Modificar el Código de Barra de los Artículos</span></span></a>
  

        </ul>
  <p>&nbsp;</p></td>
		<td height="15" align="right" valign="top" bgcolor="#FFFFFF" style="border-style: none; border-width: medium"><img src="images/body1.jpg" width="183" height="164" align="top" /></td>
	</tr>
	<tr>
		<td style="border-style: none; border-width: medium" align="left" valign="top">
		<img src="" width="183" height="1" alt=""></td>
		<td style="border-style: none; border-width: medium" align="left" valign="top">&nbsp;</td>
	</tr>
</table>
</body>
</html>

