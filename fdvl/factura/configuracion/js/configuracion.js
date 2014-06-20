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

function validateIp(idForm)
{
    //Creamos un objeto 
    object=document.getElementById(idForm);
    valueForm=object.value;

    // Patron para la ip
    var patronIp=new RegExp("^([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3})$");
    //window.alert(valueForm.search(patronIp));
    // Si la ip consta de 4 pares de números de máximo 3 dígitos
    if(valueForm.search(patronIp)==0)
    {
        // Validamos si los números no son superiores al valor 255
        valores=valueForm.split(".");
        if(valores[0]<=255 && valores[1]<=255 && valores[2]<=255 && valores[3]<=255)
        {
            //Ip correcta
           // object.style.color="#000";
            return true;
        }
    }
    //Ip incorrecta
//    object.style.color="#f00";
    return false;
}


function modificarconfiguracion(){
//donde se mostrará lo resultados
	
	var tipor=2;
	divResultado = document.getElementById('resultado');
	//valores de los inputs
	iplocal=document.configuracion.iplocal.value;
	ipremota=document.configuracion.ipservidor.value;
	puerto=document.configuracion.ptoimpresora.value;
	sucursal=document.configuracion.sucursal_id.value;
	tiempo=document.configuracion.tiemposincro.value;
	lpf=document.configuracion.libros_pf.value;
	lpfm=document.configuracion.libros_pfm.value;
	cantfact=document.configuracion.cant_facturas.value;
	version=document.configuracion.version.value;

	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php

	
	if(ipremota!="" & puerto!="" & tiempo!="" & lpf >=0 & lpfm >=0 & cantfact > 0 & cantfact <= 2){
	
//	if(validateIp(ipremota)){
	conf=confirm("¿Seguro desea modificar el registro?");
	if(conf){
	
	
	ajax.open("POST","operaciones.php",true);
	ajax.onreadystatechange=function(){

	if(ajax.readyState==1){
                divResultado.innerHTML = "Actualizando la Configuración por favor espere...";
                        //modificamos el estilo de la div, mostrando una imagen de fondo
				}else if(ajax.readyState==4){
                        if(ajax.status==200){
                                //mostramos los datos dentro de la div
                                divResultado.innerHTML = "";
                                alert(ajax.responseText);
								location.reload(true);
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
	
	ajax.send("iplocal="+iplocal+"&ipremota="+ipremota+"&puerto="+puerto+"&sucursal="+sucursal+"&tiempo="+tiempo+"&lpf="+lpf+"&lpfm="+lpfm+"&cantfact="+cantfact+"&version="+version+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
		}

	}else alert("Faltan campos por definir");
	//}else alert("La Dirección IP es Invalidad");	
}

function agregarconfiguracion(){
//donde se mostrará lo resultados
	var tipor=1;
	divResultado = document.getElementById('resultado');
	//valores de los inputs
	iplocal=document.configuracion.iplocal.value;
	ipremota=document.configuracion.ipservidor.value;
	puerto=document.configuracion.ptoimpresora.value;
	sucursal=document.configuracion.sucursal_id.value;
	tiempo=document.configuracion.tiemposincro.value;
	lpf=document.configuracion.libros_pf.value;
	lpfm=document.configuracion.libros_pfm.value;
	cantfact=document.configuracion.cant_facturas.value;
	version=document.configuracion.version.value;

	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php

	
	if(ipremota!="" & puerto!="" & tiempo!="" & lpf >=0 & lpfm >=0 & cantfact > 0 & cantfact <= 2){
	conf=confirm("¿Seguro desea agregar el registro?");
	if(conf){
	
//	if(validateIp(ipremota)){
	ajax.open("POST","operaciones.php",true);
	ajax.onreadystatechange=function(){

	if(ajax.readyState==1){
                divResultado.innerHTML = "Agregando una nueva Configuración por favor espere...";
                        //modificamos el estilo de la div, mostrando una imagen de fondo
				}else if(ajax.readyState==4){
                        if(ajax.status==200){
                                //mostramos los datos dentro de la div
                                divResultado.innerHTML = "";
                                alert(ajax.responseText);
								location.reload(true);
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
	
	ajax.send("iplocal="+iplocal+"&ipremota="+ipremota+"&puerto="+puerto+"&sucursal="+sucursal+"&tiempo="+tiempo+"&lpf="+lpf+"&lpfm="+lpfm+"&cantfact="+cantfact+"&version="+version+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
		}
	//}else alert("La Dirección IP es Invalidad");	
	}else alert("Faltan campos por definir");
}

