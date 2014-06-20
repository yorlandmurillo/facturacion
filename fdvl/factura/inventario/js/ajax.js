function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function PressEnter(oEvento,oFormulario,campo,id,suc){
     var iAscii;
	 
     if (oEvento.keyCode)
         iAscii = oEvento.keyCode;
     else if (oEvento.which)
         iAscii = oEvento.which;
     else
         return false;

     if (iAscii == 13){ 
//	 alert(campo)
	 mostrardetalle(id,campo,suc);
	 }
		return true;
} 

function aceptarinv(campos){
	enviarinv(campos);
//	div.innerHTML= '<img src="../imagenes/loader.gif">';
//}
//alert("listo")
//location.reload(true);
//div.innerHTML= '';

}


function mostrardetalle(id,cod,suc){
	//donde se mostrará lo resultados
alert(cod)
	divResultado = document.getElementById('procesado'+id);
	div = document.getElementById('valores');
	codigo = document.getElementById('codigo'+id);
	titulo = document.getElementById('titulo'+id);
	tomo = document.getElementById('tomo'+id);
	formato = document.getElementById('formato'+id);
	editorial = document.getElementById('editorial'+id);
	cants=document.getElementById("cantidads"+id);
	cond= document.getElementById('condicion'+id).value;
	codinv = document.getElementById('codinv').value;
	resp = document.getElementById('resp');
	nota=document.getElementById('notaent'+id).value;


	//instanciamos el objetoAjax

	ajax=objetoAjax();
	ajax.open("POST","detalle_libro.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			
						
			var error=ajax.responseXML;
			
			var valor1=error.getElementsByTagName("codigo")[0].childNodes[0].data;
			var valor2=error.getElementsByTagName("sucursal")[0].childNodes[0].data;
            		var valor3=error.getElementsByTagName("codinv")[0].childNodes[0].data; 
			var valor4=error.getElementsByTagName("condicion")[0].childNodes[0].data; 
			resp.value=error.getElementsByTagName("respuesta")[0].childNodes[0].data; 
			//alert(resp.value)
			
		if(resp.value=="false"){
			alert('El libro ya fue registrado con esa condición')
			confirmar=confirm('¿Desea sumar la cantidad al inventario?')
				if(confirmar){
					
					respuesta=prompt('Ingrese la cantidad:')
					//cants.value=respuesta;
					if(respuesta!="" && respuesta!=null){
						sumarlibroinv(valor1,respuesta,valor4,valor3,valor2,nota);
						codigo.value="";
						
					}else{
						alert('No ingreso ninguna cantidad');
						codigo.value="";
					}
				}else codigo.value="";
		
		}else{
			var respuesta=ajax.responseXML;
			codigo.value=respuesta.getElementsByTagName("codigo")[0].childNodes[0].data;
			titulo.value=respuesta.getElementsByTagName("titulo")[0].childNodes[0].data;
            		tomo.value=respuesta.getElementsByTagName("tomo")[0].childNodes[0].data; 
			formato.value=respuesta.getElementsByTagName("formato")[0].childNodes[0].data; 
			editorial.value=respuesta.getElementsByTagName("editorial")[0].childNodes[0].data; 
			cants.value=respuesta.getElementsByTagName("cantidad")[0].childNodes[0].data; 
			
		}
	
			
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("&codigo="+cod+"&sucursal="+suc+"&codinv="+codinv+"&cond="+cond+"&notaent="+nota)
	//divResultado = document.getElementById('procesado'+i);	
	//divResultado.innerHTML= '<img src="../imagenes/ok.png">';


//alert(cant)
	//}else alert("Ingrese un código valido");
}

function limpiar(id){
	
	codigo = document.getElementById('codigo'+id);
	titulo = document.getElementById('titulo'+id);
	tomo = document.getElementById('tomo'+id);
	formato = document.getElementById('formato'+id);
	editorial = document.getElementById('editorial'+id);
	cants=document.getElementById("cantidads"+id);
	cantf=document.getElementById("cantidadf"+id);
	
			codigo.value="";
			titulo.value="";
            tomo.value="";
			formato.value="";
			editorial.value="";
			cants.value="";
			cantf.value="";
}


function sumarlibroinv(cod,cant,cond,codinv,suc,nota){
	
	//instanciamos el objetoAjax

	ajax=objetoAjax();
	ajax.open("POST","suml_inventario.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert (ajax.responseText);
		//	refres();
	        //var respuesta=ajax.responseXML;
        }
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("&codigo="+cod+"&cant="+cant+"&cond="+cond+"&codinv="+codinv+"&suc="+suc+"&notaent="+nota)
	//if(parseInt(resp)==1 && resp!=null){
		
}

function borrarlibroinv(id){
	
	codigo = document.getElementById('codigo'+id).value;
	cond= document.getElementById('condicion'+id).value;
	codinv = document.getElementById('codinv').value;
	suc = document.getElementById('sucursal').value;

	//instanciamos el objetoAjax
alert(id);
	ajax=objetoAjax();
	ajax.open("POST","dell_inventario.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert (ajax.responseText);
		//	refres();
	        //var respuesta=ajax.responseXML;
        }
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("&codigo="+codigo+"&cond="+cond+"&codinv="+codinv+"&suc="+suc)
	//if(parseInt(resp)==1 && resp!=null){
		
}

function enviarinv(campos){
	
	div = document.getElementById("valores");
	//var resp=null;
	suc=document.getElementById("sucursal").value;
	codinv=document.getElementById("codinv").value;


for(var i=0;i<campos;i++){
	
	//donde se mostrará lo resultados

	divResultado = document.getElementById("procesado"+i);
	//valores de los inputs
	cod=document.getElementById("codigo"+i).value;
	titulo = document.getElementById("titulo"+i).value;
	tomo = document.getElementById("tomo"+i).value;
	formato = document.getElementById("formato"+i).value;
	editorial = document.getElementById("editorial"+i).value;
	cants=document.getElementById("cantidads"+i).value;
	cantf=document.getElementById("cantidadf"+i).value;
	cond=document.getElementById("condicion"+i).value;
	nota=document.getElementById("notaent"+i).value;

	//instanciamos el objetoAjax

	ajax=objetoAjax();
	ajax.open("POST","reg_inventario.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			//resp=ajax.responseText;
		//	refres();
	        //var respuesta=ajax.responseXML;
        }
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("&codigo="+cod+"&titulo="+titulo+"&tomo="+tomo+"&formato="+formato+"&edit="+editorial+"&cants="+cants+"&cantf="+cantf+"&cond="+cond+"&sucursal="+suc+"&codinv="+codinv+"&notaent="+nota)
	//if(parseInt(resp)==1 && resp!=null){
		divResultado.innerHTML= '<img src="../imagenes/ok.png">';	
		//resp=null;
	//}else if(parseInt(resp)==0 && resp!=null){ 
		//divResultado.innerHTML= '<img src="../imagenes/cancelar.png">';	
		//resp=null;
	//}
	

}

}

function verificarcampos(id){
var resp=null;	
titulo = document.getElementById('titulo'+id);
tomo = document.getElementById('tomo'+id);
formato = document.getElementById('formato'+id);
editorial = document.getElementById('editorial'+id);
cants=document.getElementById("cantidads"+id).value;
cantf=document.getElementById("cantidadf"+id).value;
suc=document.getElementById("sucursal").value;
cond=document.getElementById("condicion"+id).value;
nota=document.getElementById("notaent"+id).value;
		
		if(titulo!='' & tomo!='' & formato!='' & editorial!='' & cants!='' & cantf!='' & suc!=0 & cond!=0 & nota!=''){
		resp= true;
		}else resp=false;

		return resp;

}
function salir(){
window.close();
//alert(window.name)
}
