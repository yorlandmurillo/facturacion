<?php
 session_start();
include("includes/sesiones.php");
include("conexion.php");
include("funciones.php");
//echo "Ususario:",$_SESSION['login_usuario'];
$numeros = new numeros();
$cod_proveedor="";


if(isset($_REQUEST['cdEditorial'])) 
    {$cod_proveedor=$_REQUEST["cdEditorial"];}

         $nombre= "";
         $direccion= "";
         $rif= "";
         $nit	= "";
         $telefono= "";
         $contacto= "";
		 $sql="";
		 
		 $sql      = "Select lib_codart,lib_descri,lib_exiact from inv_libros";	
         $Rs_Libros  = mysql_query($sql);
		 //$rows       = mysql_fetch_array($sql);
         
if($cod_proveedor != "")
    {
     $sql="";
	 $sql      = "Select * from inv_cliente where clt_codcli = ".$cod_proveedor;	
     $sql_ok   = mysql_query($sql);
     $prov_rows= mysql_num_rows($sql_ok);
	 $row      = mysql_fetch_array($sql_ok);
     if($prov_rows != 0)	
	    {	 
		 $nombre	= SiNulo($row["clt_nombre"],"");
         $direccion	= SiNulo($row["clt_direc"],"");
         $rif		= SiNulo($row["clt_rif"],"");
         $nit		= SiNulo($row["clt_nit"],"");
         $telefono	= SiNulo($row["clt_telef"],"");
         $contacto	= SiNulo($row["clt_contac"],"");
        }    	
    }
 function SiNulo($P_VALOR,$P_NUEVO)
    {$Valor = $P_VALOR;
     if(is_null($Valor))
       {$Valor =$P_NUEVO;}
     return $Valor;   
    }
     $sql_cantidad="select substring(lib_descri,'1','25') as e,lib_codart from inv_libros order by lib_descri";
     $cursor_cantidad=mysql_query($sql_cantidad);
  	 $num_cantidad=mysql_num_rows($cursor_cantidad);     

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type='text/css' media='screen'> 
p { border: dashed red 1px; }
#ver{
	display:none;
}
 </style>

 <style type='text/css' media='print'>
#ver {
	visibility:visible;
	display:block;

}
 .imprimir { display: some }
 .noimprimir { display: none }
 </style>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Solicitud de Pedido</title>

<script language="javascript">
var cdEditorial;

function VerificarMovimiento(transac,index)
 {   var preuni=0;
     var num=0;
     var intI = document.frmPedido.intRowCT.value;
     alert(index);
         for(i=0;i<intI;i++)
		     {
	         if(!EsNulo(document.forms[0].elements['xcantidad_' + (i+1)]))
			    {
			     num = document.forms[0].elements['xcantidad_' + (i+1)].value;
                 preuni += eval(num);		
                }
		     }
	     if ((preuni>0)&&(transac=="2003"))
		     {
		         alert("Tipo de transaccion invalido. Existen movimientos con precio mayor a cero");
			     document.frmPedido.transaccion.selectedIndex =document.getElementById("index_transac").value;
		         return;
		     }
		 if ((preuni==0.00)&&(transac!="2003")&&(document.frmPedido.cdLibro_1.selectedIndex!=0))
			{
		         alert("Tipo de transaccion invalido. Existen movimientos con precio cero");
			     document.frmPedido.transaccion.selectedIndex =document.getElementById("index_transac").value;
		         return;
		    }
}
function ValidarCantidad(Int)
 {
	 var valcant=true;
	 var codigo='cdLibro_'+Int;
	 var cantidad='cantidadH_'+Int;
	 var selecteditem=document.getElementById(codigo).value;
	 var CantidadSolicitada=document.getElementById(cantidad).value;
	<?PHP
	 $count= 0;
	 $y=0;
	 while($row = mysql_fetch_array($Rs_Libros)){
	?>
 
	x = <?PHP echo trim($y) ?>;
 
	subcat = new Array();
	subcatagorys = "<? echo $row[0] ?>";
	subid= "<? echo $row[2] ?>";
	subcat[x,0] = subcatagorys;
	subcat[x,1] = subid;
	if ((subcat[x,0] == selecteditem)&&(subcat[x,1] < eval(CantidadSolicitada))) {
       alert("Debe introducir una cantidad menor a: "+subcat[x,1]);
	   valcant=false;
		 }
	 <?PHP
	  $count = $count + 1;
	  $y = $y + 1;
	  }
	  ?>
	  return valcant;
}
 

function SoloDecimales(nombre_campo,Int) {
     var preuniV=nombre_campo;
	 var preuni= 'preuniH_'+Int;
     var JSValor=document.getElementById(preuniV).value;

	 if(EsNulo(document.getElementById(preuniV))){
	    document.getElementById(preuniV).value=FormatMoney(document.getElementById(preuni).value);
	    return false;
	 }
     JSRegExp=/^\d+(\,\d{2})?$/ ;
     if(JSRegExp.test(JSValor)) 
     {

	   out = ","; // reemplazar la ","
	   add = "."; // por el "."
	   temp = "" + JSValor;
	   while (temp.indexOf(out)>-1) {
			pos= temp.indexOf(out);
			temp = "" + (temp.substring(0, pos) + add + 
			temp.substring((pos + out.length), temp.length));
		}
		document.getElementById(preuni).value=temp;
 	    document.getElementById(preuniV).value=FormatMoney(temp);
	}else{
		 document.getElementById(preuniV).value="";
		 document.getElementById(preuniV).focus();
     } 
}

function CambioEditorial(){
   document.frmPedido.action="inventario.php?p=pedido";
   document.frmPedido.submit();
}

function EliminarFila() {
	var i=0;
	var intI = document.frmPedido.intRowCT.value;
    var sw = false;
    	for (i=intI; i>=1; i--) {
             if (document.frmPedido.elements['checkCT' + i].checked) {             
			     sw = true;
			     if (i!=1 || intI>1 ){
				     MoverFila(i, intI);
				     window.document.all('DETALLECT').deleteRow(window.document.all('DETALLECT').rows.length-1);
				     intI--;
				     document.frmPedido.intRowCT.value = intI;
                     document.frmPedido.Int.value = intI
			     }
			else {
				 document.frmPedido.elements['cdLibro_1'].selectedIndex = 0;
                 document.frmPedido.elements['nbLibro_1'].selectedIndex	= 0;
                 document.frmPedido.elements['preuni_1'].selectedIndex	= 0;
				 document.frmPedido.elements['preunit_1'].selectedIndex	= 0;
				 document.frmPedido.elements['cantidadExi_1'].value	= 0;
                 document.frmPedido.elements['preuniH_1'].value= '';
                 document.frmPedido.elements['cantidadH_1'].value= '';
                 document.frmPedido.elements['preuniV_1'].value= '';
                 document.frmPedido.elements['cantidad_1'].value= '';
                 document.frmPedido.elements['cantidadH_1'].value= '';
                 document.frmPedido.elements['xcantidad_1'].value= '';
                 document.frmPedido.elements['xcantidadV_1'].value= '';
                 document.frmPedido.elements['checkCT1'].checked= false;
				 document.frmPedido.intRowCT.value= 1;
                 document.frmPedido.Int.value= 1;
			}
		}
	RevisarTotales(intI)
    }
    if (!sw) {
		alert("Debe seleccionar al menos una fila.");
	}
}
function MoverFila(Inicio, Fin)
   {
	var k;
	var i;
	for ( i=Inicio; i < Fin; i++) 
	   {
	   k = i + 1;
                 document.frmPedido.elements['cdLibro_' +i].selectedIndex  = document.frmPedido.elements['cdLibro_' + k].selectedIndex;
                 document.frmPedido.elements['nbLibro_' +i].selectedIndex  = document.frmPedido.elements['nbLibro_' + k].selectedIndex;
                 document.frmPedido.elements['preuni_' +i].selectedIndex  = document.frmPedido.elements['preuni_' + k].selectedIndex;
				 document.frmPedido.elements['preunit_' +i].selectedIndex  = document.frmPedido.elements['preunit_' + k].selectedIndex;
				 document.frmPedido.elements['cantidadExi_' +i].value= document.frmPedido.elements['cantidadExi_'  + k].value;
				 document.frmPedido.elements['preuniV_' +i].value= document.frmPedido.elements['preuniV_'  + k].value;
                 document.frmPedido.elements['preuniH_' +i].value= document.frmPedido.elements['preuniH_' + k].value;
                 document.frmPedido.elements['cantidad_' +i].value= document.frmPedido.elements['cantidad_' + k].value;
                 document.frmPedido.elements['cantidadH_' +i].value= document.frmPedido.elements['cantidadH_' + k].value;
				 document.frmPedido.elements['cantidadExi_' +i].value= document.frmPedido.elements['cantidadExi_' + k].value;
				 document.frmPedido.elements['xcantidad_' +i].value= document.frmPedido.elements['xcantidad_'  + k].value;
                 document.frmPedido.elements['xcantidadV_' +i].value= document.frmPedido.elements['xcantidadV_'  + k].value;
                 document.frmPedido.elements['checkCT'+i].checked = false;                                                   
       }  
   }
function InsertarFila() {
     if(document.frmPedido.cdEditorial .selectedIndex	== 0){
         alert("Selecione una editorial");
         return;
     }
	
     var intI; 
                   
               
	document.frmPedido.intRowCT.value = eval(document.frmPedido.intRowCT.value) + 1;
    intI = document.frmPedido.intRowCT.value;
    if(intI<=20){
	 var fila = document.getElementById("DETALLECT").insertRow(-1);
     var columna = fila.insertCell(0);
	 var columna = fila.insertCell(1);               
	 var columna = fila.insertCell(2);               
     var columna = fila.insertCell(3);               
     var columna = fila.insertCell(4);               
     var columna = fila.insertCell(5);
     var strHTM = '';
	strHTM += '<tr id="Libro_'+ intI +'"><td><select name="cdLibro_'+ intI +'" id="cdLibro_'+ intI +'" onChange="llenarCombos_cdLibros('+ intI +');" style="border: none;"><option value="" selected >Seleccione</option>';
		  <?
              $lib_codart="";
              $sql_4="select * from inv_libros  where lib_exiact>0 order by lib_codart";
              $cursor_4=mysql_query($sql_4);
  			  $num_4=mysql_num_rows($cursor_4);    

			  for($j=0; $j<$num_4; $j++){
  			       $lib_codart = mysql_result($cursor_4,$j,"lib_codart");  
		   ?>        
				   strHTM += '<option value=<? echo "$lib_codart"; ?>><? echo "$lib_codart"; ?></option>';   
		  <?  
			   }
		  ?>       
       strHTM+= '</select>';
	   strHTM += '<select name="preuni_'+ intI +'" id="preuni_'+ intI +'" style="display:none"><option value="" selected>Seleccione</option> ';     
			 <? 
			     $lib_codart="";
                 $sql_4="select * from inv_libros  where lib_exiact>0 order by lib_codart";
                 $cursor_4=mysql_query($sql_4);
  				 $num_4=mysql_num_rows($cursor_4);    
					  
				 for($j=0; $j<$num_4; $j++){
				     $lib_preact  = mysql_result($cursor_4,$j,"lib_preact");     
			 ?>        
			     strHTM += '<option value=<? echo "$lib_preact"; ?>><? echo "$lib_preact"; ?></option>';   
		     <?  
				 }
		     ?>  
       strHTM+= '</select></td>';			 
       
    window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[0].align = 'center';
    window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[0].bgColor = '#ffffff';
    window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[0].innerHTML =strHTM;

    var strHTM = '';

	strHTM += '<td><select name="nbLibro_'+ intI +'" id="nbLibro_'+ intI +'" onChange="llenarCombos_nbLibros('+ intI +');" style="border: none;"> <option value="" selected >Seleccione</option>';
		  <?
		      
             $sql_4="select substring(lib_descri,'1','25') as e,lib_codart from inv_libros  where lib_exiact>0 order by lib_descri";
               	$cursor_4=mysql_query($sql_4);
  				$num_4=mysql_num_rows($cursor_4);    
                $lib_codart="";    
                $lib_descri="";    
				for($j=0; $j<$num_4; $j++){
     			    $lib_codart = mysql_result($cursor_4,$j,"lib_codart"); 
					$lib_descri = mysql_result($cursor_4,$j,"e"); 
		   ?>        
				   strHTM += '<option value=<? echo "$lib_codart"; ?>><? echo "$lib_descri"; ?></option>';
		 	<?  
			   }
		    ?>       
         strHTM += '</select>';

	     strHTM += '<select name="preunit_'+ intI +'" id="preunit_'+ intI +'" style="display:none"><option value="" selected>Seleccione</option> ';     
			 <? 
			     $sql_4="select substring(lib_descri,'1','25') as e,lib_codart,lib_preact from inv_libros  where lib_exiact>0 order by lib_descri";
                 $cursor_4=mysql_query($sql_4);
  				 $num_4=mysql_num_rows($cursor_4);    
					  
				 for($j=0; $j<$num_4; $j++){
				     $lib_preact  = mysql_result($cursor_4,$j,"lib_preact");     
			 ?>        
			     strHTM += '<option value=<? echo "$lib_preact"; ?>><? echo "$lib_preact"; ?></option>';   
		     <?  
				 }
		     ?>        
         strHTM+= '</select></td>';
		 
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[1].align = 'center';
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[1].bgColor = '#ffffff';
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[1].innerHTML =strHTM;

	 var strHTM = '';
     strHTM +='<td><input name="preuniH_'+ intI +'" type="hidden" id="preuniH_'+ intI +'">';
	 strHTM +='<input class ="field100pc" name="preuniV_'+ intI +'" type="text" id="preuniV_'+ intI +'"  size="10" readonly="true" style="border: none;" value=""></td>';

     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[2].align = 'center';
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[2].bgColor = '#ffffff';
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[2].innerHTML =strHTM;    
	 
     var IntF=eval(intI)-1;   
     var strHTM = '';
	 strHTM += '<td><input name="cantidadH_'+ intI +'" id="cantidadH_'+ intI +'" type="text" ';
	 strHTM += ' onChange="multUnidxCant(' + IntF + ');" size="10"';   
	 strHTM += ' onKeyPress=" javascript:isNumeric();" size="15" maxlength="10" class ="field100pc" style="border: none;">';    
     strHTM += '<input type="hidden" name="cantidad_' + intI + '" id="cantidad_' + intI + '"></td>';    
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[3].align = 'center';
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[3].bgColor = '#ffffff';
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[3].innerHTML =strHTM;
    
     var strHTM = '';
     strHTM +='<td align="center"><input size="13" class ="field100pc" type="text" id="xcantidadV_'+ intI +'" name="xcantidadV_'+ intI +'"readonly="true" value="" style="border: none;">';
	 strHTM +='<input name="cantidadExi_'+ intI +'" type="hidden" id="cantidadExi_'+ intI +'" value="">';
	 strHTM +='<input name="xcantidad_'+ intI +'" type="hidden" id="xcantidad_'+ intI +'" value=""></td>';
	
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[4].align = 'center';
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[4].bgColor = '#ffffff';
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[4].innerHTML =strHTM;
   
     var strHTM = '';
     strHTM +='<td><INPUT type="checkbox"  id="checkCT'+ intI +'"  name="checkCT'+ intI +'"   value="1" class ="field100pc"></td</tr>' ;
	 window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[5].align = 'center';
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[5].bgColor = '#ffffff';
     window.document.all('DETALLECT').rows[window.document.all('DETALLECT').rows.length-1].cells[5].innerHTML =strHTM;
	
	 document.frmPedido.intRowCT.value = intI;
     document.frmPedido.Int.value = intI;
   }
}

function EsNulo(Texto)
   {
   var reBlank = /^[ 	]+$/
    if(Texto.value.length==0) 	 
      {return true;}
    else if(Texto.value=="")  
      {return true;}
    else if(reBlank.test(Texto.value))  
      {return true;}
    else
      {return false;}
   } 

function llenarCombos_cdLibros(num){
var num = num;
var cdLibro;
RevisarCodigo(num);
document.getElementById("index_transac").value=document.getElementById("transaccion").selectedIndex;
	 

if(num == 1){
		cdLibro = document.forms[0].cdLibro_1[document.forms[0].cdLibro_1.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_1.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_1.options[i].value){
			   document.forms[0].nbLibro_1.options[i].selected = true;
			   document.forms[0].preunit_1.options[i].selected = true;
			   document.forms[0].preuniH_1.value = document.forms[0].preunit_1[i].value;
			   document.forms[0].preuniV_1.value = FormatMoney(document.forms[0].preunit_1[i].value);
		     }
		 }	
	}else if(num == 2){
		cdLibro = document.forms[0].cdLibro_2[document.forms[0].cdLibro_2.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_2.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_2.options[i].value){
			   document.forms[0].nbLibro_2.options[i].selected = true;
			   	document.forms[0].preunit_2.options[i].selected = true;
				document.forms[0].preuniH_2.value = document.forms[0].preunit_2[i].value;				    			
				document.forms[0].preuniV_2.value = FormatMoney(document.forms[0].preunit_2[i].value);
		     }
		}	
	}else if(num == 3){
		cdLibro = document.forms[0].cdLibro_3[document.forms[0].cdLibro_3.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_3.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_3.options[i].value){
			   document.forms[0].nbLibro_3.options[i].selected = true;
			   document.forms[0].preunit_3.options[i].selected = true;
			   document.forms[0].preuniH_3.value = document.forms[0].preunit_3[i].value;
			   document.forms[0].preuniV_3.value = FormatMoney(document.forms[0].preunit_3[i].value);  
		    }
		}	
	}else if(num == 4){
		cdLibro = document.forms[0].cdLibro_4[document.forms[0].cdLibro_4.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_4.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_4.options[i].value){
			   document.forms[0].nbLibro_4.options[i].selected = true;
			   document.forms[0].preunit_4.options[i].selected = true;
			   document.forms[0].preuniH_4.value = document.forms[0].preunit_4[i].value;
			   document.forms[0].preuniV_4.value = FormatMoney(document.forms[0].preunit_4[i].value);  
		    }
		}	
	}else if(num == 5){
		cdLibro = document.forms[0].cdLibro_5[document.forms[0].cdLibro_5.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_5.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_5.options[i].value){
			   document.forms[0].nbLibro_5.options[i].selected = true;
			   document.forms[0].preunit_5.options[i].selected = true;
			   document.forms[0].preuniH_5.value = document.forms[0].preunit_5[i].value;
			   document.forms[0].preuniV_5.value = FormatMoney(document.forms[0].preunit_5[i].value);
		     }
		}	
	}else if(num == 6){
		cdLibro = document.forms[0].cdLibro_6[document.forms[0].cdLibro_6.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_6.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_6.options[i].value){
			   document.forms[0].nbLibro_6.options[i].selected = true;
			   document.forms[0].preunit_6.options[i].selected = true;
			   document.forms[0].preuniH_6.value = document.forms[0].preunit_6[i].value;
			   document.forms[0].preuniV_6.value = FormatMoney(document.forms[0].preunit_6[i].value);		
			}
		 }	
	}else if(num == 7){
		cdLibro = document.forms[0].cdLibro_7[document.forms[0].cdLibro_7.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_7.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_7.options[i].value){
			   document.forms[0].nbLibro_7.options[i].selected = true;
			   document.forms[0].preunit_7.options[i].selected = true;
			   document.forms[0].preuniH_7.value = document.forms[0].preunit_7[i].value;
			   document.forms[0].preuniV_7.value = FormatMoney(document.forms[0].preunit_7[i].value);		
			 }
		 }	
	}else if(num == 8){
		cdLibro = document.forms[0].cdLibro_8[document.forms[0].cdLibro_8.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_8.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_8.options[i].value){
			   document.forms[0].nbLibro_8.options[i].selected = true;
			   document.forms[0].preunit_8.options[i].selected = true;
			   document.forms[0].preuniH_8.value = document.forms[0].preunit_8[i].value;
			   document.forms[0].preuniV_8.value = FormatMoney(document.forms[0].preunit_8[i].value);				
			 }
		 }	
	}else if(num == 9){
		cdLibro = document.forms[0].cdLibro_9[document.forms[0].cdLibro_9.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_9.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_9.options[i].value){
			   document.forms[0].nbLibro_9.options[i].selected = true;
			   document.forms[0].preunit_9.options[i].selected = true;
			   document.forms[0].preuniH_9.value = document.forms[0].preunit_9[i].value;
			   document.forms[0].preuniV_9.value = FormatMoney(document.forms[0].preunit_9[i].value);		
		     }
		 }	
	}else if(num == 10){
		cdLibro = document.forms[0].cdLibro_10[document.forms[0].cdLibro_10.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_10.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_10.options[i].value){
			   document.forms[0].nbLibro_10.options[i].selected = true;
			   document.forms[0].preunit_10.options[i].selected = true;
			   document.forms[0].preuniH_10.value = document.forms[0].preunit_10[i].value;
			   document.forms[0].preuniV_10.value = FormatMoney(document.forms[0].preunit_10[i].value);				
			 }
		 }	
	}else if(num == 11){
		cdLibro = document.forms[0].cdLibro_11[document.forms[0].cdLibro_11.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_11.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_11.options[i].value){
			   document.forms[0].nbLibro_11.options[i].selected = true;
			   document.forms[0].preunit_11.options[i].selected = true;
			   document.forms[0].preuniH_11.value = document.forms[0].preunit_11[i].value;
			   document.forms[0].preuniV_11.value = FormatMoney(document.forms[0].preunit_11[i].value);				
			 }
		}	
	}else if(num == 12){
		cdLibro = document.forms[0].cdLibro_12[document.forms[0].cdLibro_12.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_12.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_12.options[i].value){
			   document.forms[0].nbLibro_12.options[i].selected = true;
			   document.forms[0].preunit_12.options[i].selected = true;
			   document.forms[0].preuniH_12.value = document.forms[0].preunit_12[i].value;
			   document.forms[0].preuniV_12.value = FormatMoney(document.forms[0].preunit_12[i].value);				
			 }
		}	
	}else if(num == 13){
		cdLibro = document.forms[0].cdLibro_13[document.forms[0].cdLibro_13.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_13.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_13.options[i].value){
			   document.forms[0].nbLibro_13.options[i].selected = true;
			   document.forms[0].preunit_13.options[i].selected = true;
			   document.forms[0].preuniH_13.value = document.forms[0].preunit_13[i].value;
			   document.forms[0].preuniV_13.value = FormatMoney(document.forms[0].preunit_13[i].value);						
			 }
		}	
	}else if(num == 14){
		cdLibro = document.forms[0].cdLibro_14[document.forms[0].cdLibro_14.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_14.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_14.options[i].value){
			   document.forms[0].nbLibro_14.options[i].selected = true;
			   document.forms[0].preuni_14.options[i].selected = true;
			   document.forms[0].preuniH_14.value = document.forms[0].preuni_1[i].value;
			   document.forms[0].preuniV_14.value = FormatMoney(document.forms[0].preuni_1[i].value);						
			 }
		}	
	}else if(num == 15){
		cdLibro = document.forms[0].cdLibro_15[document.forms[0].cdLibro_15.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_15.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_15.options[i].value){
			   document.forms[0].nbLibro_15.options[i].selected = true;
			   document.forms[0].preunit_15.options[i].selected = true;
			   document.forms[0].preuniH_15.value = document.forms[0].preunit_15[i].value;
			   document.forms[0].preuniV_15.value = FormatMoney(document.forms[0].preunit_15[i].value);				
		     }
		}	
	}else if(num == 16){
		cdLibro = document.forms[0].cdLibro_16[document.forms[0].cdLibro_16.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_16.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_16.options[i].value){
			   document.forms[0].nbLibro_16.options[i].selected = true;
			   document.forms[0].preunit_16.options[i].selected = true;
			   document.forms[0].preuniH_16.value = document.forms[0].preunit_16[i].value;
			   document.forms[0].preuniV_16.value = FormatMoney(document.forms[0].preunit_16[i].value);				
		     }
		}	
	}else if(num == 17){
		cdLibro = document.forms[0].cdLibro_17[document.forms[0].cdLibro_17.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_17.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_17.options[i].value){
			   document.forms[0].nbLibro_17.options[i].selected = true;
			   document.forms[0].preunit_17.options[i].selected = true;
			   document.forms[0].preuniH_17.value = document.forms[0].preunit_17[i].value;
			   document.forms[0].preuniV_17.value = FormatMoney(document.forms[0].preunit_17[i].value);				
		     }
		 }	
	}else if(num == 18){
		cdLibro = document.forms[0].cdLibro_18[document.forms[0].cdLibro_18.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_18.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_18.options[i].value){
			   document.forms[0].nbLibro_18.options[i].selected = true;
			   document.forms[0].preunit_18.options[i].selected = true;
			   document.forms[0].preuniH_18.value = document.forms[0].preunit_18[i].value;
			   document.forms[0].preuniV_18.value = FormatMoney(document.forms[0].preunit_18[i].value);						
			 }
		 }	
	}else if(num == 19){
		cdLibro = document.forms[0].cdLibro_19[document.forms[0].cdLibro_19.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_19.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_19.options[i].value){
			   document.forms[0].nbLibro_19.options[i].selected = true;
			   document.forms[0].preunit_19.options[i].selected = true;
			   document.forms[0].preuniH_19.value = document.forms[0].preunit_19[i].value;
			   document.forms[0].preuniV_19.value = FormatMoney(document.forms[0].preunit_19[i].value);				
		     }
		 }	
	}else if(num == 20){
		cdLibro = document.forms[0].cdLibro_20[document.forms[0].cdLibro_20.selectedIndex].value;
		num_nbLibro = document.forms[0].nbLibro_20.length;
		for(i=0;i<num_nbLibro;i++){
			if(cdLibro == document.forms[0].nbLibro_20.options[i].value){
			   document.forms[0].nbLibro_20.options[i].selected = true;
			   document.forms[0].preunit_20.options[i].selected = true;
			   document.forms[0].preuniH_20.value = document.forms[0].preunit_20[i].value;
			   document.forms[0].preuniV_20.value = FormatMoney(document.forms[0].preunit_20[i].value);						           }
		 }	
	 } 
	 
	 var precio='preunit_' +num;
	 var codigo='cdLibro_' +num;
	 var precioH='preuniH_' +num;
	 var precioV='preuniV_' +num;
    // alert(document.getElementById(codigo).value);
    //alert(document.getElementById(precio).value);
    //alert(document.getElementById("transaccion").value);
   var intI = document.frmPedido.intRowCT.value;
   if ((document.getElementById(precio).value=="0.00")&&(document.getElementById("transaccion").value!="2003"))
   {
     alert("Articulo sin precio.\n Tipo de transaccion diferente a Donacion");
	 document.frmPedido.elements['cdLibro_' +num].selectedIndex =0;
	 document.frmPedido.elements['nbLibro_' +num].selectedIndex =0;
	 document.frmPedido.elements['preunit_' +num].selectedIndex =0;
	 document.getElementById(precioH).value=0;
	 document.getElementById(precioV).value="";
	 RevisarTotales(intI);
	 return;
   }
 
   if ((document.getElementById(precio).value !="0.00")&&(document.getElementById("transaccion").value=="2003"))
   {
     alert("Articulo con precio.\n Tipo de transaccion igual a Donacion");
	 document.frmPedido.elements['cdLibro_' +num].selectedIndex =0;
	 document.frmPedido.elements['nbLibro_' +num].selectedIndex =0;
	 document.frmPedido.elements['preunit_' +num].selectedIndex =0;
	 document.getElementById(precioH).value=0;
	 document.getElementById(precioV).value="";
	  RevisarTotales(intI);
	 return;
   }
	 
	 
	 
	if(document.forms[0].elements['preuniH_' + (num)].value!=""){
	   multUnidxCant(num-1);
	}
}

function llenarCombos_nbLibros(num){
     RevisarCodigo(num);
     var num = num;
     var nbLibro;

	if(num == 1){
		nbLibro = document.forms[0].nbLibro_1[document.forms[0].nbLibro_1.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_1.length;
		for(i=0;i<num_cdLibro;i++){	
			if(nbLibro == document.forms[0].cdLibro_1.options[i].value){
			   document.forms[0].cdLibro_1.options[i].selected = true;
			   document.forms[0].preuni_1.options[i].selected = true;
			   document.forms[0].preuniH_1.value = document.forms[0].preuni_1[i].value;  
			   document.forms[0].preuniV_1.value = FormatMoney(document.forms[0].preuni_1[i].value);  
		     }
		 }	
	}else if(num == 2){
		nbLibro = document.forms[0].nbLibro_2[document.forms[0].nbLibro_2.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_2.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_2.options[i].value){
			   document.forms[0].cdLibro_2.options[i].selected = true;
			   document.forms[0].preuni_2.options[i].selected = true;
			   document.forms[0].preuniH_2.value = document.forms[0].preuni_2[i].value;  
			   document.forms[0].preuniV_2.value = FormatMoney(document.forms[0].preuni_2[i].value);  
		    }
		 }	
	}else if(num == 3){
		nbLibro = document.forms[0].nbLibro_3[document.forms[0].nbLibro_3.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_3.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_3.options[i].value){
			   document.forms[0].cdLibro_3.options[i].selected = true;
			   document.forms[0].preuni_3.options[i].selected = true;
			   document.forms[0].preuniH_3.value = document.forms[0].preuni_3[i].value;
			   document.forms[0].preuniV_3.value = FormatMoney(document.forms[0].preuni_3[i].value);  
		     }	   
		 }	
	}else if(num == 4){
		nbLibro = document.forms[0].nbLibro_4[document.forms[0].nbLibro_4.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_4.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_4.options[i].value){
			   document.forms[0].cdLibro_4.options[i].selected = true;
			   document.forms[0].preuni_4.options[i].selected = true;
			   document.forms[0].preuniH_4.value = document.forms[0].preuni_4[i].value;
			   document.forms[0].preuniV_4.value = FormatMoney(document.forms[0].preuni_4[i].value);  
		     }
		 }	
	}else if(num == 5){
		nbLibro = document.forms[0].nbLibro_5[document.forms[0].nbLibro_5.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_5.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_5.options[i].value){
			   document.forms[0].cdLibro_5.options[i].selected = true;			   
			   document.forms[0].preuni_5.options[i].selected = true;
			   document.forms[0].preuniH_5.value = document.forms[0].preuni_5[i].value;  
			   document.forms[0].preuniV_5.value = FormatMoney(document.forms[0].preuni_5[i].value);		
			 }
		 }	
	}else if(num == 6){
		nbLibro = document.forms[0].nbLibro_6[document.forms[0].nbLibro_6.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_6.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_6.options[i].value){
			   document.forms[0].cdLibro_6.options[i].selected = true;
			   document.forms[0].preuni_6.options[i].selected = true;
			   document.forms[0].preuniH_6.value = document.forms[0].preuni_6[i].value;  
			   document.forms[0].preuniV_6.value = FormatMoney(document.forms[0].preuni_6[i].value);
		     }
		 }	
	}else if(num == 7){
		nbLibro = document.forms[0].nbLibro_7[document.forms[0].nbLibro_7.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_7.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_7.options[i].value){
			   document.forms[0].cdLibro_7.options[i].selected = true;
			   document.forms[0].preuni_7.options[i].selected = true;
			   document.forms[0].preuniH_7.value = document.forms[0].preuni_7[i].value;  
			   document.forms[0].preuniV_7.value = FormatMoney(document.forms[0].preuni_7[i].value);
		     }
		 }	
	}else if(num == 8){
		nbLibro = document.forms[0].nbLibro_8[document.forms[0].nbLibro_8.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_8.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_8.options[i].value){
			   document.forms[0].cdLibro_8.options[i].selected = true;
			   document.forms[0].preuni_8.options[i].selected = true;
			   document.forms[0].preuniH_8.value = document.forms[0].preuni_8[i].value;  
			   document.forms[0].preuniV_8.value = FormatMoney(document.forms[0].preuni_8[i].value);
		     }
		 }	
	}else if(num == 9){
		nbLibro = document.forms[0].nbLibro_9[document.forms[0].nbLibro_9.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_9.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_9.options[i].value){
			   document.forms[0].cdLibro_9.options[i].selected = true;
			   document.forms[0].preuni_9.options[i].selected = true;
			   document.forms[0].preuniH_9.value = document.forms[0].preuni_9[i].value;  
			   document.forms[0].preuniV_9.value = FormatMoney(document.forms[0].preuni_9[i].value);
		     }
		 }	
	}else if(num == 10){
		nbLibro = document.forms[0].nbLibro_10[document.forms[0].nbLibro_10.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_10.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_10.options[i].value){
			   document.forms[0].cdLibro_10.options[i].selected = true;
			   document.forms[0].preuni_10.options[i].selected = true;
			   document.forms[0].preuniH_10.value = document.forms[0].preuni_10[i].value;  
			   document.forms[0].preuniV_10.value = FormatMoney(document.forms[0].preuni_10[i].value);
		     }
		 }	
	}else if(num == 11){
		nbLibro = document.forms[0].nbLibro_11[document.forms[0].nbLibro_11.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_11.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_11.options[i].value){
			   document.forms[0].cdLibro_11.options[i].selected = true;
			   document.forms[0].preuni_11.options[i].selected = true;
			   document.forms[0].preuniH_11.value = document.forms[0].preuni_11[i].value;  
			   document.forms[0].preuniV_11.value = FormatMoney(document.forms[0].preuni_11[i].value);
		     }
		 }	
	}else if(num == 12){
		nbLibro = document.forms[0].nbLibro_12[document.forms[0].nbLibro_12.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_12.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_12.options[i].value){
			   document.forms[0].cdLibro_12.options[i].selected = true;
			   document.forms[0].preuni_12.options[i].selected = true;
			   document.forms[0].preuniH_12.value = document.forms[0].preuni_12[i].value;  
			   document.forms[0].preuniV_12.value = FormatMoney(document.forms[0].preuni_12[i].value);
		     }
		 }	
	}else if(num == 13){
		nbLibro = document.forms[0].nbLibro_13[document.forms[0].nbLibro_13.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_13.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_13.options[i].value){
			   document.forms[0].cdLibro_13.options[i].selected = true;
			   document.forms[0].preuni_13.options[i].selected = true;
			   document.forms[0].preuniH_13.value = document.forms[0].preuni_13[i].value;  
			   document.forms[0].preuniV_13.value = FormatMoney(document.forms[0].preuni_13[i].value);
		     }
		 }	
	}else if(num == 14){
		nbLibro = document.forms[0].nbLibro_14[document.forms[0].nbLibro_14.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_14.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_14.options[i].value){
			   document.forms[0].cdLibro_14.options[i].selected = true;
			   document.forms[0].preuni_14.options[i].selected = true;
			   document.forms[0].preuniH_14.value = document.forms[0].preuni_14[i].value;  
			   document.forms[0].preuniV_14.value = FormatMoney(document.forms[0].preuni_14[i].value);
		     }
		 }	
	}else if(num == 15){
		nbLibro = document.forms[0].nbLibro_15[document.forms[0].nbLibro_15.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_15.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_15.options[i].value){
			   document.forms[0].cdLibro_15.options[i].selected = true;
			   document.forms[0].preuni_15.options[i].selected = true;
			   document.forms[0].preuniH_15.value = document.forms[0].preuni_15[i].value;  
			   document.forms[0].preuniV_15.value = FormatMoney(document.forms[0].preuni_15[i].value);
		     }
		 }	
	}else if(num == 16){
		nbLibro = document.forms[0].nbLibro_16[document.forms[0].nbLibro_16.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_16.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_16.options[i].value){
			   document.forms[0].cdLibro_16.options[i].selected = true;
			   document.forms[0].preuni_16.options[i].selected = true;
			   document.forms[0].preuniH_16.value = document.forms[0].preuni_16[i].value;  
			   document.forms[0].preuniV_16.value = FormatMoney(document.forms[0].preuni_16[i].value);
		     }
		 }	
	}else if(num == 17){
		nbLibro = document.forms[0].nbLibro_17[document.forms[0].nbLibro_17.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_17.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_17.options[i].value){
			   document.forms[0].cdLibro_17.options[i].selected = true;
			   document.forms[0].preuni_17.options[i].selected = true;
			   document.forms[0].preuniH_17.value = document.forms[0].preuni_17[i].value;  
			   document.forms[0].preuniV_17.value = FormatMoney(document.forms[0].preuni_17[i].value);
		     }
		 }	
	}else if(num == 18){
		nbLibro = document.forms[0].nbLibro_18[document.forms[0].nbLibro_18.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_18.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_18.options[i].value){
			   document.forms[0].cdLibro_18.options[i].selected = true;
			   document.forms[0].preuni_18.options[i].selected = true;
			   document.forms[0].preuniH_18.value = document.forms[0].preuni_18[i].value;  
			   document.forms[0].preuniV_18.value = FormatMoney(document.forms[0].preuni_18[i].value);
		     }
		 }	
	}else if(num == 19){
		nbLibro = document.forms[0].nbLibro_19[document.forms[0].nbLibro_19.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_19.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_19.options[i].value){
			   document.forms[0].cdLibro_19.options[i].selected = true;
			   document.forms[0].preuni_19.options[i].selected = true;
    		   document.forms[0].preuniH_19.value = document.forms[0].preuni_19[i].value;  
			   document.forms[0].preuniV_19.value = FormatMoney(document.forms[0].preuni_19[i].value);
		     }
		 }	
	}else if(num == 20){
		nbLibro = document.forms[0].nbLibro_20[document.forms[0].nbLibro_20.selectedIndex].value;
		num_cdLibro = document.forms[0].nbLibro_20.length;
		for(i=0;i<num_cdLibro;i++){
			if(nbLibro == document.forms[0].cdLibro_20.options[i].value){
			   document.forms[0].cdLibro_20.options[i].selected = true;
			   document.forms[0].preuni_20.options[i].selected = true;
			   document.forms[0].preuniH_20.value = document.forms[0].preuni_20[i].value;  
			   document.forms[0].preuniV_20.value = FormatMoney(document.forms[0].preuni_20[i].value);
		     }
		 }	
	 }
	 
	 var precio='preuni_' +num;
	 var codigo='cdLibro_' +num;
	 var precioH='preuniH_' +num;
	 var precioV='preuniV_' +num;
    // alert(document.getElementById(codigo).value);
    //alert(document.getElementById(precio).value);
    //alert(document.getElementById("transaccion").value);
   var intI = document.frmPedido.intRowCT.value;
   if ((document.getElementById(precio).value=="0.00")&&(document.getElementById("transaccion").value!="2003"))
   {
     alert("Articulo sin precio.\n Tipo de transaccion diferente a Donacion");
	 document.frmPedido.elements['cdLibro_' +num].selectedIndex =0;
	 document.frmPedido.elements['nbLibro_' +num].selectedIndex =0;
	 document.frmPedido.elements['preuni_' +num].selectedIndex =0;
	 document.getElementById(precioH).value=0;
	 document.getElementById(precioV).value="";
	 
	 RevisarTotales(intI);
	 return;
   }
 
   if ((document.getElementById(precio).value !="0.00")&&(document.getElementById("transaccion").value=="2003"))
   {
     alert("Articulo con precio.\n Tipo de transaccion igual a Donacion");
	 document.frmPedido.elements['cdLibro_' +num].selectedIndex =0;
	 document.frmPedido.elements['nbLibro_' +num].selectedIndex =0;
	 document.frmPedido.elements['preuni_' +num].selectedIndex =0;
	 document.getElementById(precioH).value=0;
	 document.getElementById(precioV).value="";
	  RevisarTotales(intI);
	 return;
   }
	 
    RevisarCodigo(num);
	if(document.forms[0].elements['preuniH_' + (num)].value!=""){
	   multUnidxCant(num-1);
	}
}

function isNumeric(){
	if (event.keyCode < 48 || event.keyCode > 57) {
		event.returnValue = false;
	}	
}

var WGdc=",";  var WGgc=".";  var WGnc="-";  var WGcs="";
function FormatMoney(A,W) {
	   var N=Math.round(Math.abs(A*100));
	   var S=((N<10)?"00":((N<100)?"0":""))+N;
	   S=WGcs+((A<0)?WGnc:"")+WGgroup(S.substring(0,(S.length-2)))+WGdc+S.substring((S.length-2),S.length)+((A<0&&WGnc=="(")?")":"");
	   return (S.length>W)?"Over":S;
	}
	
function WGgroup(S) {
		return (S.length<4)?S:(WGgroup(S.substring(0,S.length-3))+WGgc+S.substring(S.length-3,S.length));
	}

	
function inicializar(Int,num) {	
    var preuni = cant = reslt =0;
	var cantidad_Total = 0;
	var xcantidad_Total = 0;
    var cant = 0;
    var preuni = 0;
	       document.forms[0].elements['cantidadH_' + (num+1)].value="";
		   document.forms[0].elements['xcantidadV_' + (num+1)].value="";
  		   document.forms[0].elements['xcantidad_' + (num+1)].value=0;
           preuni=0;
		   cant=0;
           for(i=0;i<Int;i++){
		      if(!EsNulo(document.forms[0].elements['cantidadH_' + (i+1)])){
			      num=	(document.forms[0].elements['cantidadH_' + (i+1)].value);
			     cant = eval(cant)+eval(num);
	         }
		      if(!EsNulo(document.forms[0].elements['xcantidad_' + (i+1)])){
			     num = document.forms[0].elements['xcantidad_' + (i+1)].value;
                 preuni += eval(num);		
            }
	        document.forms[0].elements['cantidad_' + (i+1)].value=document.forms[0].elements['cantidadH_' + (i+1)].value;
	     }
		  if(cant>0){
	         document.forms[0].cantidad_Total.value = cant;
	         document.forms[0].xcantidad_Total.value = FormatMoney(preuni);
	     }else{
	         document.forms[0].cantidad_Total.value = "";
	         document.forms[0].xcantidad_Total.value = 0;
	     }
		   return;
	}		
	
	
function multUnidxCant(num){
	var num = num;
	var preuni = cant = reslt =0;
	var cantidad_Total = 0;
	var xcantidad_Total = 0;
    var cant = 0;
    var preuni = 0;
	var cw=0;
	
    var Int = document.frmPedido.intRowCT.value;
	var cantidad= 'cantidadH_'+Int;
    var monto='xcantidad_'+Int;
    preuni=document.forms[0].elements['preuniH_' + (num+1)].value
	cant  =document.forms[0].elements['cantidadH_' + (num+1)].value;
	cantexist  =document.forms[0].elements['cantidadExi_' + (num+1)].value;
	 
     if(EsNulo(document.forms[0].elements['preuniH_' + (num+1)])){
        alert("Seleccione un articulo");
        document.forms[0].elements['cantidadH_' + (num+1)].value="";
		return;		
	 } 
	 else
	    {
		 if(!ValidarCantidad(num+1)){  //valida que la catidad introducida sea menor a la existencia actual
		   inicializar(Int,num)
		   return;
		 }
	    if((!EsNulo(document.forms[0].elements['cantidadH_' + (num+1)]))&&(document.forms[0].elements['cantidadH_' + (num+1)].value==0) ||((EsNulo(document.forms[0].elements['cantidadH_' + (num+1)]))&&(!EsNulo(document.forms[0].elements['xcantidadV_' + (num+1)])))){
		   alert("La cantidad a solicitar debe ser mayor");
		   document.forms[0].elements['cantidadH_' + (num+1)].value="";
		   document.forms[0].elements['xcantidadV_' + (num+1)].value="";
  		   document.forms[0].elements['xcantidad_' + (num+1)].value=0;
           preuni=0;
		   cant=0;
           for(i=0;i<Int;i++){
		      if(!EsNulo(document.forms[0].elements['cantidadH_' + (i+1)])){
			     num=	(document.forms[0].elements['cantidadH_' + (i+1)].value);
			     cant = eval(cant)+eval(num);
	         }
		      if(!EsNulo(document.forms[0].elements['xcantidad_' + (i+1)])){
			     num = parseFloat(document.forms[0].elements['xcantidad_' + (i+1)].value);
                 preuni += eval(num);		
            }
	          document.forms[0].elements['cantidad_' + (i+1)].value=document.forms[0].elements['cantidadH_' + (i+1)].value;
	     }
		  if(cant>0){
	         document.forms[0].cantidad_Total.value = cant;
	         document.forms[0].xcantidad_Total.value = FormatMoney(preuni);
	     }else{
	         document.forms[0].cantidad_Total.value = "";
	         document.forms[0].xcantidad_Total.value = "";
	     }
		   return;
		}
	 }
	reslt = preuni * cant;
	if (reslt>0){
	document.forms[0].elements['xcantidad_' + (num+1)].value= reslt;
	document.forms[0].elements['xcantidadV_' + (num+1)].value= FormatMoney(reslt);
	}else{
		document.forms[0].elements['xcantidad_' + (num+1)].value="";
	    document.forms[0].elements['xcantidadV_' + (num+1)].value= FormatMoney(cw);;
	}
	cant=0;
	preuni=0;
	for(i=0;i<Int;i++){
		  if(!EsNulo(document.forms[0].elements['cantidadH_' + (i+1)])){
			     num=	(document.forms[0].elements['cantidadH_' + (i+1)].value);
			     cant = eval(cant)+eval(num);
	         }
		      if(!EsNulo(document.forms[0].elements['xcantidad_' + (i+1)])){
			     num = parseFloat(document.forms[0].elements['xcantidad_' + (i+1)].value);
                 preuni += eval(num);		
            }
	  document.forms[0].elements['cantidad_' + (i+1)].value=document.forms[0].elements['cantidadH_' + (i+1)].value;
	 }
	 
	 if(cant>0){
	    document.forms[0].cantidad_Total.value = cant;
	    document.forms[0].xcantidad_Total.value = FormatMoney(preuni);
	}
}
function  RevisarTotales(intR){
var num=0;
var preuni=0;		
var cant=0;		
             for(i=0;i<intR;i++){
			             if(!EsNulo(document.forms[0].elements['cantidadH_' + (i+1)])){
			                 num=	(document.forms[0].elements['cantidadH_' + (i+1)].value);
			                 cant = eval(cant)+eval(num);
	                     }
		                 if(!EsNulo(document.forms[0].elements['xcantidad_' + (i+1)])){
			                 num = (document.forms[0].elements['xcantidad_' + (i+1)].value);
                             preuni = eval(preuni)+eval(num);		
                         }
	                     document.forms[0].elements['cantidad_' + (i+1)].value=document.forms[0].elements['cantidadH_' + (i+1)].value;
	                }
					if(cant>0){
	                     document.forms[0].cantidad_Total.value = cant;
	                     document.forms[0].xcantidad_Total.value = FormatMoney(preuni);
	                }else{
	                  document.forms[0].cantidad_Total.value = "";
	                  document.forms[0].xcantidad_Total.value = "";
	                }
}
function RevisarCodigo(IntP)
             {
             var intR = window.document.all('DETALLECT').rows.length-1;;
             var intI = 0;
             var intD = 0;
             var num = 0;
			 var cant = 0;
             var preuni=0;
	         var Pos = IntP;

             if(!EsNulo(document.forms[0].elements['cdLibro_' + Pos])){
                    {for(intI=1;intI <= intR; intI++)
                       {
                       if(document.frmPedido.elements['cdLibro_' +intI].selectedIndex==document.frmPedido.elements['cdLibro_' + Pos].selectedIndex)
                        {intD++;}   
                       }
                    }
                if(intD > 1)
                  {
				     alert("Ya hay un registro con ese codigo de libro");
                     document.frmPedido.elements['cdLibro_'+Pos].selectedIndex = 0;
                     document.frmPedido.elements['nbLibro_'+Pos].selectedIndex= 0;
                     document.frmPedido.elements['preuni_'+Pos].selectedIndex	= 0;
					 document.frmPedido.elements['preunit_'+Pos].selectedIndex	= 0;
			         document.frmPedido.elements['cantidadExi_'+Pos].value= '';
					 document.frmPedido.elements['preuniH_'+Pos].value= '';
                     document.frmPedido.elements['preuniV_'+Pos].value= '';
                     document.frmPedido.elements['cantidadH_'+Pos].value= '';
                     document.frmPedido.elements['cantidad_'+Pos].value= '';
                     document.frmPedido.elements['xcantidadV_'+Pos].value= '';
                     document.frmPedido.elements['xcantidad_'+Pos].value= '';
                     document.frmPedido.elements['checkCT'+Pos].checked= false;
                     for(i=0;i<intR;i++){
		                  if(!EsNulo(document.forms[0].elements['cantidadH_' + (i+1)])){
			                 num=	(document.forms[0].elements['cantidadH_' + (i+1)].value);
			                 cant = eval(cant)+eval(num);
	                     }
		                 if(!EsNulo(document.forms[0].elements['xcantidad_' + (i+1)])){
			                 num = parseFloat(document.forms[0].elements['xcantidad_' + (i+1)].value);
                             preuni = eval(preuni)+eval(num);		
                         }
	                     document.forms[0].elements['cantidad_' + (i+1)].value=document.forms[0].elements['cantidadH_' + (i+1)].value;
	                }
                 if(cant>0){
	                 document.forms[0].cantidad_Total.value = cant;
	                 document.forms[0].xcantidad_Total.value = FormatMoney(preuni);
	             }else{
	              document.forms[0].cantidad_Total.value = "";
	              document.forms[0].xcantidad_Total.value = "";
	             }
                 return;
                  }  
             }
}
function Limpiar(){
	 var Int=document.forms[0].Int.value;
     for (var i = 0; i < Int; i++ ) {
                document.frmPedido.elements['checkCT'+(i+1)].checked= true;
     }
     EliminarFila() ;
     document.frmPedido.Int.value= 1; 
     document.frmPedido.intRowCT.value= 1;
     document.forms[0].cantidad_Total.value = "";
	 document.forms[0].xcantidad_Total.value = "";
     document.forms[0].xcantidad_Total.value = "";
     document.frmPedido.cdEditorial.selectedIndex	= 0;
     document.forms[0].prv_direc_1.value = "";
     document.forms[0].prv_rif_1.value = "";
     document.forms[0].prv_nit_1.value = "";
     document.forms[0].prv_telef_1.value = "";
     document.forms[0].prv_contac_1.value = "";
     document.forms[0].solicitado.value = "";
     document.forms[0].aceptado.value = "";   
	 document.frmPedido.transaccion.selectedIndex	= 0;   	 
}

function Guardar(){
     var Int=document.forms[0].Int.value;
	 var IntD=0;
	 for(i=0;i<Int;i++){
	      if(document.forms[0].elements['nbLibro_' + (i+1)].selectedIndex=="")
		     {
		          var tex='Libro_'+(i+1);
				  IntD+=1;
	              document.frmPedido.elements['checkCT'+(i+1)].checked= true;
		          EliminarFila() ;
	    }
	 }
     if(document.frmPedido.cdEditorial .selectedIndex	== 0){
         alert("Selecione una editorial");
         return;
     }
	 if(document.frmPedido.transaccion.selectedIndex==0){
	    alert("Suministre el tipo de transaccion");
		return;
	 }
	 if((Int==IntD)||(EsNulo(document.forms[0].cantidad_Total))||(EsNulo(document.forms[0].xcantidad_Total))){
	    alert("Suministre todos los datos del detalle del pedido");
		return;
	 }
	 if((EsNulo(document.forms[0].solicitado))){
	    alert("Seleccione un vendedor");
		return;
	 }
	 
	 if((EsNulo(document.forms[0].aceptado))){
		alert("Suministre el nombre de la persona que genera el pedido");
		return;
	 }
	 
	 
	logomenu.style.display="none";
	cabecera.style.display="none";
	Botones.style.display="none";
	focus();
	print();
	document.forms[0].action = "actualizar_pedido.php";
	document.forms[0].submit();
}

function Inicio(){
	document.forms[0].action = "inventario.php";
	document.forms[0].submit();
}
</script>
</head>
<body>
    <form action="actualizar_pedido.php" name="frmPedido" method="post">
    <?
	$sql_0 = 'SELECT CURDATE( ) as fecha'; 
	$cursor_0=mysql_query($sql_0);
  	$num_0=mysql_num_rows($cursor_0);  
    
   	for($g=0; $g<$num_0; $g++){
     $fecha= mysql_result($cursor_0,$g,"fecha");
	}
	
	$fechaV=implode("-",array_reverse(preg_split("/\D/",$fecha)));
	
	$sql="SELECT concat('PE',EXTRACT(YEAR_MONTH FROM sysdate())) AS E";
  	$cursor=mysql_query($sql);
  	$num=mysql_num_rows($cursor);  
    
   	for($i=0; $i<$num; $i++){
     $OC_fecha_1= mysql_result($cursor,$i,"E");
	}
	
	$sql="SELECT (MAX(SUBSTRING(ped_numped, 9, 12)) + 1) AS E FROM  inv_pedidc";
  	$cursor=mysql_query($sql);
  	$num=mysql_num_rows($cursor);  
    if(mysql_result($cursor,0,"E")){

		for($i=0; $i<$num; $i++){ 
			$E = mysql_result($cursor,$i,"E");
			$E_2 = strlen($E);
				if($E_2==1){
					$E_3 = '000'.$E;				
				}												
				if($E_2==2){
					$E_3 = '00'.$E;				
				}												
				if($E_2==3){
					$E_3 = '0'.$E;				
				}												
				if($E_2==4){
					$E_3 = $E;				
				}												
		}
		$OC_Compra = $OC_fecha_1.$E_3;		
	}else{
		$OC_Compra = $OC_fecha_1.'0000';
		$sql= "INSERT INTO inv_pedidc (ped_numped) VALUES ('$OC_Compra')";	
		$cursor=mysql_query($sql);
	
	    $sql="SELECT (MAX(SUBSTRING(ped_numped, 9, 12)) + 1)/1000 AS E FROM  inv_pedidc";
		$cursor=mysql_query($sql);
		$num=mysql_num_rows($cursor);  
			for($i=0; $i<$num; $i++){ 
				$E = mysql_result($cursor,$i,"E");
				$E_2 = explode(".","$E"); 			
					$C1=$E_2[0]; // Imprime "mes"
					$C2=$E_2[1]; // Imprime "dia" 
				 $E_3=$C1.$C2;
			}
			$OC_Compra = $OC_fecha_1.$E_3;
	}
?>
<div id="ver">
 <tr> 
    <td width="256"><img src="images/logolateral.jpg" border=0></td>
</tr>
</div>
<center><h3><font color="#990000" size="3"><strong><font face="Verdana">SOLICITUD PEDIDO</font></strong></font></h3>
<table width="570" height="122" border="0" bordercolor="#000000" cellpadding="2" cellspacing="0">
  <tr>
    <td  align="left" >
	  <table width="590" border="1" align="center" cellspacing="0" cellpadding="0" bordercolor="#000000">
          <tr>
			<td width="150" class="TituloInforme">N&ordm;. Pedido:</td>
			<td width="178" class="ContenidoTextInforme"><? echo "$OC_Compra"; ?>
			      <input type="hidden" name ="OC_Compra" value = "<? echo "$OC_Compra"; ?>">
			</td>
            <td width="51" class="TituloInforme">Fecha:</td>
                <td width="105" class="ContenidoTextInforme"><? echo $fechaV; ?>
			         <input type="hidden" name ="OC_fecha_Compra" value = "<? echo $fecha; ?>">
			</td>
          </tr>
        </table>
		<br>
        <table width="590" border="1" align="center" cellspacing="0" cellpadding="0" bordercolor="#000000">
          <tr>
            <td width="76" class="TituloInforme">Cliente:</td>
			<td width="323" >
                 <SELECT name="cdEditorial" id="cdEditorial" size="1" style="FONT-SIZE: 11px; WIDTH: 400px; COLOR: #000000; FONT-FAMILY: verdana, helvetica, arial; BACKGROUND-COLOR: #ffffff" onChange="CambioEditorial();">
                   <Option Value="" <?PHP  echo ($cod_proveedor == ""  ? "selected" :"");?>>Seleccione</Option>	
					<?PHP
	   				$sql_4="SELECT * from inv_cliente";
	   				$cursor_4=mysql_query($sql_4);
	   				while($row = mysql_fetch_array($cursor_4))
            		{?>
              		<Option Value="<?PHP echo $row[0]?>" <?PHP  echo ($cod_proveedor == $row[0]  ? "selected" :"");?>><?PHP echo $row[0],"   -  ",$row[1]?></Option>	
					<?PHP    
            		}
					?>
             	</SELECT>
			</td>			
          </tr>
        </table>
		<table width="590" border="0" align="center" cellspacing="05" cellpadding="0"><tr><td></td></tr></table>
   	    <table width="590" border="1" align="center" cellspacing="0" cellpadding="0" bordercolor="#000000">
          <tr>
            <td width="98" class="TituloInforme">Direcci&oacute;n</td>
            <td width="486" class="ContenidoTextInforme">
              	 <input class="ContenidoTextInforme" name="prv_direc_1" type="text" size="65" readonly="text" value="<?php echo $direccion; ?>" style="border: none;">
			</td>
          </tr>
        </table>
		<table width="590" border="0" align="center" cellspacing="05" cellpadding="0"><tr><td></td></tr></table>
   	   <table width="590" border="1" align="center" cellspacing="0" cellpadding="0" bordercolor="#000000">
  <tr>
            <td width="58"  class="TituloInforme" >R.I.F.:</td>
            <td width="142">
				<input name="prv_rif_1" type="text" class="ContenidoTextInforme"  value="<?php echo $rif; ?>" size="15" readonly="text" style="border: none;">
		    </td>
            <td width="60"  class="TituloInforme">N.I.T.:</td>
            <td width="97">
             	 <input name="prv_nit_1" type="text"  value="<?php echo $nit; ?>" class="ContenidoTextInforme" size="15" readonly="text" style="border: none;">
	  		  </td>
            <td width="72"  class="TituloInforme">Tel&eacute;fono:</td>
            <td width="147">
            	<input name="prv_telef_1" value="<?php echo $telefono; ?>" type="text" class="ContenidoTextInforme" size="15" readonly="text" style="border: none;">
	  		  </td>
          </tr>
        </table>
		<table width="590" border="0" align="center" cellspacing="05" cellpadding="0"><tr><td></td></tr></table>
		<table width="590" border="1" align="center" cellspacing="0" cellpadding="0" bordercolor="#000000">
          <tr>
             <td width="62" class="TituloInforme">Contacto:</td>
             <td width="168"> 
             		<input class="ContenidoTextInforme" name="prv_contac_1" type="text" size="30" readonly="text" value="<?php echo $contacto; ?>" style="border: none;">
			</td>
			<td width="76" class="TituloInforme">Transacci&oacute;n:</td>
			<td width="274"> 
                 <select name="transaccion" id="transaccion"   onchange="VerificarMovimiento(this.value,this.selectedIndex);" style=" border: none; font-size:10px; width:255px; color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; background-color:#FFFFFF">
				 <option value="" selected >Seleccione</option>                     
		         <? 
		         $sql_4="select * from inv_transac where trs_tiptrs='S' order by trs_codtrs";
  			     $cursor_4=mysql_query($sql_4);
  			     $num_4=mysql_num_rows($cursor_4);    
			     $cod_vendedor = "";
			     $nmbr_vendedor="";	  
			     for($j=0; $j<$num_4; $j++){
  			         $cod_transaccion = mysql_result($cursor_4,$j,"trs_codtrs");  
				     $des_transaccion = mysql_result($cursor_4,$j,"trs_descrip");         
				     echo "<option value='$cod_transaccion'>$cod_transaccion - $des_transaccion</option>";	
		 	     }
		   ?>       
       </select>
       <input name="index_transac"  id="index_transac" type="hidden">
	  		  	   
			</td>
          </tr>
        </table>	
		  
		<table width="590" border="0" align="center" cellspacing="05" cellpadding="0"><tr><td></td></tr></table>			
    <tr>
<td>
 <table width="590"  border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td width="590" class="TituloTabla">DETALLE DE LOS ARTICULOS (LIBROS) A SOLICITAR</td></tr>
  </table> 
</td>
</tr>
<tr>
<td>
<table width="590"id="DETALLECT" border="1" bordercolor="#000000" align="center" cellspacing="0" cellpadding="0">
<center>
<tr bgcolor="#999999" >
	<td width="88"  class="TituloInforme_2">CODIGO </td>
	<td width="130" class="TituloInforme_2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TITULO DEL LIBRO</td>
	<td width="146" class="TituloInforme_2">PRECIO UNIT.
(Bs F.)</td>
	<td width="98"  class="TituloInforme_2">CANTIDAD SOLICITADA</td>
	<td width="146" class="TituloInforme_2">PRECIO EXTEND.
(Bs F.)</td>
	<td width="05"  class="TituloInforme_2">ELI</td>
</tr>

<tr id="Libro_1">
	<td >
	 <select name="cdLibro_1" id="cdLibro_1" onChange="llenarCombos_cdLibros(1);" style="border: none;">
          <option value="" selected >Seleccione</option>                     
		  <? 
		      $sql_4="select * from inv_libros  where IFNULL(lib_exiact,0)>0 order by lib_codart";
  			  $cursor_4=mysql_query($sql_4);
  			  $num_4=mysql_num_rows($cursor_4);    
					  
			   for($j=0; $j<$num_4; $j++){
  			       $lib_codart = mysql_result($cursor_4,$j,"lib_codart");         
				   echo "<option value='$lib_codart'>$lib_codart</option>";	
		 	   }
		   ?>       
       </select> 
	    <select name="preuni_1" id="preuni_1" style="display:none">
		     <option value="" selected>Seleccione</option>      
			 <? 
			    $sql_4="select * from inv_libros where IFNULL(lib_exiact,0)>0 order by lib_codart";
  				 $cursor_4=mysql_query($sql_4);
  				 $num_4=mysql_num_rows($cursor_4);    
					  
				 for($j=0; $j<$num_4; $j++){
				     $lib_preact  = mysql_result($cursor_4,$j,"lib_preact");     
				     echo "<option value='$lib_preact'>$lib_preact</option>";
				 }
		      ?>        
         </select> 
		 
	</td>
	<td>
	    <select name="nbLibro_1" id="nbLibro_1" onChange="llenarCombos_nbLibros(1);" >
            <option value="" selected>Seleccione</option>                     
			<? 
			    $sql_4="select substring(lib_descri,'1','25') as e,lib_codart from inv_libros  where IFNULL(lib_exiact,0)>0 order by substring(lib_descri,'1','25') ";
  				$cursor_4=mysql_query($sql_4);
  				$num_4=mysql_num_rows($cursor_4);    
					  
				for($j=0; $j<$num_4; $j++){
     			    $lib_codart = mysql_result($cursor_4,$j,"lib_codart"); 
					$lib_descri = mysql_result($cursor_4,$j,"e");        
					echo "<option value='$lib_codart'>$lib_descri</option>";	 			 
		 		 }
			?>        
         </select>                
	 	 <select name="preunit_1" id="preunit_1" style="display:none ">
		     <option value="" selected>Seleccione</option>      
			 <? 
			    $sql_4="select substring(lib_descri,'1','25') as e,lib_codart,IFNULL(lib_preact,0) as lib_preact from inv_libros  where IFNULL(lib_exiact,0)>0 order by substring(lib_descri,'1','25') ";
  				 $cursor_4=mysql_query($sql_4);
  				 $num_4=mysql_num_rows($cursor_4);    
					  
				 for($j=0; $j<$num_4; $j++){
				     $lib_preact  = mysql_result($cursor_4,$j,"lib_preact");     
				     echo "<option value='$lib_preact'>$lib_preact</option>";
				 }
		      ?>        
         </select>
        </td>
	<td align="center">
	     <input class ="field100pc" name="preuniV_1" type="text" id="preuniV_1"  size="10" style="border: none;" value="" onchange="SoloDecimales(this.name,1),multUnidxCant(0);"
		 onBlur="multUnidxCant(0);" readonly="true" maxlength="10"> 
		 <input name="preuniH_1" type="hidden" id="preuniH_1"> 
	  </td>
	  <!--Cantidad a solicitar -->
	  <td align="center">
		      <input name="cantidadH_1" id="cantidadH_1" type="text" onChange="multUnidxCant(0);"
		  onKeyPress=" javascript:isNumeric();" size="10" maxlength="10" class ="field100pc" style="border: none;"> 
		  <input type="hidden" name="cantidad_1" id="cantidad_1" > 
	  </td>
	  <td align="center">
	      <input class ="field100pc" name="xcantidadV_1" type="text" id="xcantidadV_1" value="" size="13"readonly="true" style="border: none;"	> </td>
          <input name="cantidadExi_1" type="hidden" id="cantidadExi_1" value="" >
		  <input name="xcantidad_1" type="hidden" id="xcantidad_1" value="" >
	  <td >
	      <INPUT type="checkbox"  id="checkCT1"  name="checkCT1"   value="1" class ="field100pc">      </td>		  
      </tr>
	  </center>
</table><!--fin de la tabla-->
</td>
</tr>
<tr><td>
<table width="590" border="1" bordercolor="#000000" align="center" cellspacing="0" cellpadding="0">
 <center>
 <tr style="display:none" >
	<td width="86">CODIGO </td>
	<td width="120"> TITULO DEL LIBRO</td>
	<td width="168">PRECIO UNIT.(Bs F.)</td>
	<td width="80">CANTIDAD SOLICITADA</td>
	<td width="102">PRECIO EXTEN.(Bs F.)</td>
	<td width="20">ELI</td>
</tr>
<tr>
	<td width="374" height="28" colspan="3"   class="TituloTotalGeneral">Total General</td>
	<td width="80"  align="center">
	  <input name="cantidad_Total" type="text" size="10" style="border: none;" readonly="true">	</td>
	<td width="122"  align="center">
	    <input name="xcantidad_Total" type="text" size="18" readonly="true" style="border: none;">   </td>
</tr>
</center>
</table></td></tr>
   <input name="Int" id="Int" type="hidden" value="1">
   <input type="hidden"   id="intRowCT"   name="intRowCT"    value="1">
</table>
<tr><td>
  <table id="Botones2">
<tr width="500">
	<td align="center"><p class='noimprimir'><input id='insertar'  type='button' name='insertar' value='Agregar' onClick="InsertarFila();"></p></td>
	<td align="center"><p class='noimprimir'><input name="eliminar" type="button"  value="Eliminar" onClick="EliminarFila();"></p></td>
</tr>
</table>
</td></tr>
<BR>
<table width="590" border="1" align="center" cellspacing="0" cellpadding="0" bordercolor="#000000">
         <tr>
             <td class="TextFielBold">Vendedor:</td>
                <td>
			     <!--<input class="TextFiel" type="text" name="solicitado" id="solicitado" size="30" style="border: none;">-->
				 
		<select name="solicitado" id="solicitado" style="FONT-SIZE: 11px; WIDTH: 200px; COLOR: #000000; FONT-FAMILY: verdana, helvetica, arial; BACKGROUND-COLOR: #ffffff;" style="border: none;">
          <option value="" selected >Seleccione</option>                     
		  <? 
		      $sql_4="select * from inv_vende order by ven_codven";
  			  $cursor_4=mysql_query($sql_4);
  			  $num_4=mysql_num_rows($cursor_4);    
			  $cod_vendedor = "";
			  $nmbr_vendedor="";	  
			   for($j=0; $j<$num_4; $j++){
  			       $cod_vendedor = mysql_result($cursor_4,$j,"ven_codven");  
				   $nmbr_vendedor = mysql_result($cursor_4,$j,"ven_nombre");         
				   echo "<option value='$cod_vendedor'>$cod_vendedor - $nmbr_vendedor</option>";	
		 	   }
		   ?>       
       </select> 

	       </td>
             <td class="TextFielBold">Cliente:</td>
             <td>
			     <input class="TextFiel" type="text" name="aceptado" id="aceptado" size="35" style="border: none;">
	       </td>
         </tr>
    </table>
<BR>
<table id="Botones">
<tr width="500">
	<td align="center"><p class='noimprimir'><input id='inicio' type='button' name='inicio' value='Inicio' onClick="javascript:Inicio();"></p></td>
	<td align="center"><p class='noimprimir'><input type="button" onClick="javascript:Limpiar();" value="Limpiar"></p></td>
	<td align="center"><p class='noimprimir'><input name="eliminar" type="button"  value="Eliminar" onClick="EliminarFila();"></p></td>
	<td align="center"><p class='noimprimir'><input name="Submit" type="button" id="Submit"  value="Guardar" onClick="javascript:Guardar();"></p></td>
	
	
</tr>
</table>
</center>
</form>
</body>
</html>
<?PHP
  mysql_close($link);
?>			