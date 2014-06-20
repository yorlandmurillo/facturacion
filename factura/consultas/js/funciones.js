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

function consultai(){
	//donde se mostrará lo resultados
	divResultado = document.getElementById('resultado');
	divProgress = document.getElementById('cargando');
	//valores de los inputs
	codf=document.facturas.codfactura.value;
	facturamanual=document.facturas.facturamanual.value;
	fecha1=document.facturas.fecha1.value;
	fecha2=document.facturas.fecha2.value;
	suc=document.facturas.sucursal.value;
	vend=document.facturas.vendedor.value;
	cedula=document.facturas.cedula.value;
	//instanciamos el objetoAjax

	if (cedula!="" || codf!="" || facturamanual!="" || fecha1!="" || fecha2!=""){
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registro.php

	ajax.open("POST","verfacturas.php",true);
	ajax.onreadystatechange=function() {
		
	if(ajax.readyState==1){

         		divProgress.innerHTML= '<img src="../imagenes/cargando.gif">'; 
		        divResultado.innerHTML= ""; 
                
				}else if(ajax.readyState==4){
                        if(ajax.status==200){

				         		divProgress.innerHTML= ""; 
								divResultado.innerHTML = ajax.responseText;
						        LimpiarCampos();
								
					}else if(ajax.status==404){
                                divResultado.innerHTML = "La página no existe";
                        }else{
                                //mostramos el posible error
                                divResultado.innerHTML = "Error:".ajax.status; 
			                       alert(ajax.responseText);
					   }
       			}
			
	}
	
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("codf="+codf+"&facturamanual="+facturamanual+"&fecha1="+fecha1+"&fecha2="+fecha2+"&suc="+suc+"&vend="+vend+"&ced="+cedula)
//	llamarasincrono('consulta.php','contenidos');	
	LimpiarCampos();
	}else alert("Debe ingresar un dato para la búsqueda")
}
function consultaa(){
	//donde se mostrará lo resultados
	divResultado = document.getElementById('resultado');
	divProgress = document.getElementById('cargando');
	//valores de los inputs
	hoy=1;
	suc=document.facturas.sucursal.value;
	vend=document.facturas.vendedor.value;

	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registro.php
	ajax.open("POST","verfacturas.php",true);
	ajax.onreadystatechange=function() {
		
		if(ajax.readyState==1){

         		divProgress.innerHTML= '<img src="../imagenes/cargando.gif">'; 
		        divResultado.innerHTML= ""; 
                
				}else if(ajax.readyState==4){
                        if(ajax.status==200){

				         		divProgress.innerHTML= ""; 
								divResultado.innerHTML = ajax.responseText;
						        LimpiarCampos();
								
					}else if(ajax.status==404){
                                divResultado.innerHTML = "La página no existe";
                        }else{
                                //mostramos el posible error
                                divResultado.innerHTML = "Error:".ajax.status; 
			                       alert(ajax.responseText);
					   }
       			}

	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("hoy="+hoy+"&suc="+suc+"&vend="+vend)
//	llamarasincrono('consulta.php','contenidos');	
	LimpiarCampos();

}

function consultag(){
	//donde se mostrará lo resultados
	divResultado = document.getElementById('resultado');
	divProgress = document.getElementById('cargando');
	
	//valores de los inputs
	suc=document.facturas.sucursal.value;
	vend=document.facturas.vendedor.value;
	todas=1;
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registro.php
	ajax.open("POST","verfacturas.php",true);
	ajax.onreadystatechange=function() {
		
		if(ajax.readyState==1){

         		divProgress.innerHTML= '<img src="../imagenes/cargando.gif">'; 
		        divResultado.innerHTML= ""; 
                
				}else if(ajax.readyState==4){
                        if(ajax.status==200){

				         		divProgress.innerHTML= ""; 
								divResultado.innerHTML = ajax.responseText;
						        LimpiarCampos();
								
					}else if(ajax.status==404){
                                divResultado.innerHTML = "La página no existe";
                        }else{
                                //mostramos el posible error
                                divResultado.innerHTML = "Error:".ajax.status; 
			                       alert(ajax.responseText);
					   }
       			}
			
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("suc="+suc+"&vend="+vend+"&todas="+todas)
//	llamarasincrono('consulta.php','contenidos');	
	LimpiarCampos();

}

function llamarasincrono (url, id_contenedor)
{
    var pagina_requerida = false;
    if (window.XMLHttpRequest)
    {
        // Si es Mozilla, Safari etc
        pagina_requerida = new XMLHttpRequest ();
    } else if (window.ActiveXObject)
    {
        // pero si es IE
        try 
        {
            pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            // en caso que sea una versión antigua
            try
            {
                pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP");
            }
            catch (e)
            {
            }
        }
    } 
    else
    return false;
    pagina_requerida.onreadystatechange = function ()
    {
        // función de respuesta
        cargarpagina (pagina_requerida, id_contenedor);
    }
    pagina_requerida.open ('GET', url, true); // asignamos los métodos open y send
    pagina_requerida.send (null);
	window.location.reload(this);
}
// todo es correcto y ha llegado el momento de poner la información requerida
// en su sitio en la pagina xhtml
function cargarpagina (pagina_requerida, id_contenedor)
{
    if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
    document.getElementById (id_contenedor).innerHTML = pagina_requerida.responseText;
}


function LimpiarCampos(){
	document.facturas.codfactura.value="";
	document.facturas.fecha1.value="";
	document.facturas.fecha2.value="";
	document.facturas.codfactura.focus();
}



function iSubmitEnter(oEvento, oFormulario){
     var iAscii;
	 cliente=document.ventas.cliente.value;
     if (oEvento.keyCode)
         iAscii = oEvento.keyCode;
     else if (oEvento.which)
         iAscii = oEvento.which;
     else
         return false;

     if (iAscii == 13 & cliente!=""){ 
	 agregaritem();
	 LimpiarCampos();
     llamarasincrono('consulta.php','contenidos');	

}

	return true;
	
} 

function validarnum(obj,valores){
	if(valores==1)
		cadena="0123456789-Jj"
	else if(valores==2)
	    	cadena=" abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.,"
	var val2=obj.value.length
	for(i=0;(i<obj.value.length)&&(val2==obj.value.length);i++){
		var car=obj.value.substr(i,1)
		val=0
		for(j=0;(j<cadena.length)&&(val==0);j++)
			if(car==cadena.substr(j,1)) val=1
		if(val==0)
			val2=i;
	}
	obj.value=obj.value.substr(0,val2)
}

function validacorreo(valor)
{
	var reg=/(^[a-zA-Z0-9._-]{1,30})@([a-zA-Z0-9.-]{1,30}$)/;
	
	if(reg.test(valor)){ 
	
	return true;
	
	}else{
	document.clientes.clicorreo.value="";
	alert("Direccion de correo invalida");
	document.clientes.clicorreo.focus();
	} 
}

function verfactura(codf,suc,vend) {
window.location.href="../funciones/printfactura.php?codf="+codf+"&vend="+vend+"&suc="+suc;
}

function editfactura(codf,suc,vend) {
window.location.href="../funciones/editfactura.php?codf="+codf+"&vend="+vend+"&suc="+suc;
}

function devfactura(codf,suc,vend,cliente) {
window.location.href="../funciones/devoluciones.php?codf="+codf+"&vend="+vend+"&suc="+suc+"&cliente="+cliente;
}


function imprimirf(codf) {
	suc=document.facturas.sucursal.value;
	vend=document.facturas.vendedor.value;
	verfactura(codf,suc,vend);
}

function editarf(codf) {
	suc=document.facturas.sucursal.value;
	vend=document.facturas.vendedor.value;
	editfactura(codf,suc,vend);
}

function devolucion(codf,cliente) {
	suc=document.facturas.sucursal.value;
	vend=document.facturas.vendedor.value;
	devfactura(codf,suc,vend,cliente);
}


function esc(){
	window.close(this);
}
function pagina(nropagina){
	//donde se mostrará los registros
	divContenido = document.getElementById('resultado');
	
	ajax=objetoAjax();
	//uso del medoto GET
	//indicamos el archivo que realizará el proceso de paginar
	//junto con un valor que representa el nro de pagina
	ajax.open("GET", "verfacturas.php?pag="+nropagina);
//	divContenido.innerHTML= '<img src="anim.gif">';
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			divContenido.innerHTML = ajax.responseText
		}
	}
	//como hacemos uso del metodo GET
	//colocamos null ya que enviamos 
	//el valor por la url ?pag=nropagina
	ajax.send(null)
}

			
