// JavaScript Document

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

function cargarpagina (pagina_requerida, id_contenedor)
{
    if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
    document.getElementById (id_contenedor).innerHTML = pagina_requerida.responseText;
}

function refres(){
   location.reload(true);
}

function vertraslado(cod) {
	window.location.href="funciones/printfactura.php?codf="+codf+"&vend="+vend+"&suc="+suc;
}

function cargartraslado(codt){
	//donde se mostrará lo resultados
	divResultado=document.getElementById('progreso');

	divtabla=document.getElementById('tabla1');
	
	msg=confirm("¿Esta seguro de cargar el traslado?");
	
	if(msg){
	//instanciamos el objetoAjax
	ajax=objetoAjax();
 
	ajax.open("POST","../traslados/procesartraslados.php",true);

	ajax.onreadystatechange=function() {
		if(ajax.readyState==1){
                divResultado.innerHTML = "Cargando Traslados "+codt+" Por favor espere...";
                        //modificamos el estilo de la div, mostrando una imagen de fondo
                			
				divResultado.style.border="outset"; 
                divtabla.style.display="none";
			
				}else if(ajax.readyState==4){
                        if(ajax.status==200){
                                //mostramos los datos dentro de la div
                    //            divResultado.style.background = "url('') no-repeat";
		                        divResultado.innerHTML = "";
								divResultado.style.border="none"; 
                                alert(ajax.responseText);
								divtabla.style.display="block";
								refres();
					}else if(ajax.status==404){
                                divResultado.innerHTML = "La página no existe";
                        }else{
                                //mostramos el posible error
                                divResultado.innerHTML = "Error:".ajax.status; 
                        }
       }
	}

	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("codt="+codt)
	}

}

function borrartraslado(codt){
	//donde se mostrará lo resultados
   	msg=confirm("¿Esta seguro de borrar el traslado?");
	
	if(msg){
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registro.php
	ajax.open("POST","../funciones/borrartraslado.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
				alert(ajax.responseText);
			//llamar a funcion para limpiar los inputs
		refres();
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("codt="+codt)
	}

}

function anulartraslado(codt){
	//donde se mostrará lo resultados
   divResultado=document.getElementById('progreso');
   
   msg=confirm("¿Esta seguro de anular el traslado Nº: "+codt+"?");
	
	if(msg){
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registro.php
	ajax.open("POST","../traslados/anular_traslado.php",true);
	ajax.onreadystatechange=function() {
		
	if(ajax.readyState==1){
                divResultado.innerHTML = "Anulando Traslado "+codt+" Por favor espere...";
                        //modificamos el estilo de la div, mostrando una imagen de fondo
                			
				divResultado.style.border="outset"; 
                divtabla.style.display="none";
			
				}else if(ajax.readyState==4){
                        if(ajax.status==200){
                                //mostramos los datos dentro de la div
                    //            divResultado.style.background = "url('') no-repeat";
		                        divResultado.innerHTML = "";
								divResultado.style.border="none"; 
                                alert(ajax.responseText);
								divtabla.style.display="block";
								refres();
					}else if(ajax.status==404){
                                divResultado.innerHTML = "La página no existe";
                        }else{
                                //mostramos el posible error
                                divResultado.innerHTML = "Error:".ajax.status; 
                        }
       }
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("codt="+codt)
	}

}
