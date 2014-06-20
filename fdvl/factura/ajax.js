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

function PressEnter(oEvento, oFormulario,campo){
     var iAscii;
	 
     if (oEvento.keyCode)
         iAscii = oEvento.keyCode;
     else if (oEvento.which)
         iAscii = oEvento.which;
     else
         return false;

     if (iAscii == 13){ 
	 alert(campo)
	 }
		return true;
} 

function aceptardev(campos){
	div = document.getElementById('valores');
for(var i=0;i<campos;i++){

	enviardev(i);
	div.innerHTML= '<img src="imagenes/loader.gif">';
}
alert("listo")
//location.reload(true);
div.innerHTML= '';

}


function mostrardetalle(id,cod){
	//donde se mostrará lo resultados

	divResultado = document.getElementById('procesado'+id);
	titulo = document.getElementById('titulo'+id);
	tomo = document.getElementById('tomo'+id);
	formato = document.getElementById('formato'+id);
	editorial = document.getElementById('editorial'+id);
	
	div = document.getElementById('valores');
	//valores de los inputs
	cod=document.getElementById("codigo"+id).value;
	cant=document.getElementById("cantidad"+id).value;
	//instanciamos el objetoAjax

	ajax=objetoAjax();
	ajax.open("POST","add_devolucion.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			//alert(ajax.responseText);
		//	refres();
	        var respuesta=ajax.responseXML;
            titulo.value=respuesta.getElementsByTagName("titulo")[0].childNodes[0].data;
            tomo.value=respuesta.getElementsByTagName("tomo")[0].childNodes[0].data; 
			formato.value=respuesta.getElementsByTagName("formato")[0].childNodes[0].data; 
			editorial.value=respuesta.getElementsByTagName("editorial")[0].childNodes[0].data; 
			
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("&codigo="+cod+"&cantidad="+cant)
	//divResultado = document.getElementById('procesado'+i);	
	divResultado.innerHTML= '<img src="imagenes/ok.png">';


//alert(cant)
	//}else alert("Ingrese un código valido");
}



function enviardev(id){
	//donde se mostrará lo resultados

	divResultado = document.getElementById('procesado'+id);
	titulo = document.getElementById('titulo'+id);
	tomo = document.getElementById('tomo'+id);
	formato = document.getElementById('formato'+id);
	editorial = document.getElementById('editorial'+id);
	
	div = document.getElementById('valores');
	//valores de los inputs
	cod=document.getElementById("codigo"+id).value;
	cant=document.getElementById("cantidad"+id).value;
	//instanciamos el objetoAjax

	ajax=objetoAjax();
	ajax.open("POST","add_devolucion.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			//alert(ajax.responseText);
		//	refres();
	        var respuesta=ajax.responseXML;
            titulo.value=respuesta.getElementsByTagName("titulo")[0].childNodes[0].data;
            tomo.value=respuesta.getElementsByTagName("tomo")[0].childNodes[0].data; 
			formato.value=respuesta.getElementsByTagName("formato")[0].childNodes[0].data; 
			editorial.value=respuesta.getElementsByTagName("editorial")[0].childNodes[0].data; 
	      	divResultado.innerHTML= '<img src="imagenes/ok.png">';	
		}else if(ajax.readyState==1){
               	divResultado.innerHTML= '';
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("&codigo="+cod+"&cantidad="+cant)
	//divResultado = document.getElementById('procesado'+i);	
//alert(cant)
	//}else alert("Ingrese un código valido");
}

function verificarcampos(id){
var resp=null;	
titulo = document.getElementById('titulo'+id);
tomo = document.getElementById('tomo'+id);
formato = document.getElementById('formato'+id);
editorial = document.getElementById('editorial'+id);
cant=document.getElementById("cantidad"+id).value;

		if(titulo!='' & tomo!='' & formato!='' & editorial!='' & cant!=''){
		resp= true;
		}else resp=false;

return resp;

}