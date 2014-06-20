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
function agregartitulo(){
	//donde se mostrará lo resultados
	var tipor=1;
	divResultado = document.getElementById('resultado');
	//valores de los inputs
	codt=document.titulos.codigo.value;
	aut=document.titulos.autor.value;
	prov=document.titulos.proveedor.value;
	edit=document.titulos.editorial.value;
	tem=document.titulos.tema.value;
	stem=document.titulos.subtema.value;
	
	if(document.titulos.isbn.value==""){
	isbn=0;	
	}else isbn=document.titulos.isbn.value;

	if(document.titulos.codbarra.value==""){
	codb=0;	
	}else codb=document.titulos.codbarra.value;
	
	
	col=document.titulos.coleccion.value;
	titulo=document.titulos.titulo.value;
	pvp=eval(parseFloat(document.titulos.pvp.value));
	
	if((parseFloat(document.titulos.costo.value)==0) || (parseFloat(document.titulos.costo.value)=="")){
	costo=eval(parseFloat(document.titulos.pvp.value));
	}else costo=eval(parseFloat(document.titulos.costo.value));
	exit=eval(parseInt(document.titulos.existencia.value));

	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(codt!="" & aut!="" & titulo!="" & pvp > 0 & costo > 0 & prov!=0){
		
	ajax.open("POST","registrartitulo.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			//llamar a funcion para limpiar los inputs
			confir=confirm("¿Desea distribuirlo para todas las sucursales?")
			if(confir){
			distribuirtitulo(codt,titulo,aut,isbn,codb,exit);

			}else location.reload(true);

		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	
	ajax.send("codigo="+codt+"&titulo="+titulo+"&autor="+aut+"&proveedor="+prov+"&editorial="+edit+"&tema="+tem+"&subtema="+stem+"&isbn="+isbn+"&codbarra="+codb+"&coleccion="+col+"&pvp="+pvp+"&costo="+costo+"&existencia="+exit+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
	}else alert("Faltan campos por definir");
}

function modificartitulo(){
//donde se mostrará lo resultados
	var tipor=7;
	divResultado = document.getElementById('resultado');
	//valores de los inputs
	codt=document.ftitulos.codigo.value;
	aut=document.ftitulos.autor.value;
	prov=document.ftitulos.proveedor.value;
	edit=document.ftitulos.editorial.value;
	tem=document.ftitulos.tema.value;
	stem=document.ftitulos.subtema.value;
	isbn=document.ftitulos.isbn.value;
	codb=document.ftitulos.codbarra.value;
	col=document.ftitulos.coleccion.value;
	titulo=document.ftitulos.titulo.value;
	condicion=document.ftitulos.condicion.value;
	sucursal=document.ftitulos.sucursal.value;	
	pvp=eval(parseFloat(document.ftitulos.pvp.value));
	costo=eval(parseFloat(document.ftitulos.costo.value));
	exit=eval(parseInt(document.ftitulos.existencia.value));
	deplegal=document.ftitulos.deplegal.value;
	formato=document.ftitulos.formato.value;
	volumen=document.ftitulos.volumen.value;
	nedicion=document.ftitulos.nedicion.value;
	ncoleccion=document.ftitulos.ncoleccion.value;
	tomo=document.ftitulos.tomo.value;


	if(document.ftitulos.masl.value=="")masl=0;
	else masl=eval(parseInt(document.ftitulos.masl.value));
	
	if(document.ftitulos.menosl.value=="")menosl=0;
	else menosl=eval(parseInt(document.ftitulos.menosl.value));



	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php

	
	if(codt!="" & aut!="" & titulo!="" & pvp > 0 & costo > 0 & condicion!="" & condicion!=0 & sucursal!=""){
	conf=confirm("¿Seguro desea modificar el registro?");
	if(conf){
	ajax.open("POST","registrartitulo.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			//llamar a funcion para limpiar los inputs
			location.reload(true);

		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	
	ajax.send("codigo="+codt+"&titulo="+titulo+"&autor="+aut+"&proveedor="+prov+"&editorial="+edit+"&tema="+tem+"&subtema="+stem+"&isbn="+isbn+"&codbarra="+codb+"&coleccion="+col+"&pvp="+pvp+"&costo="+costo+"&existencia="+exit+"&condicion="+condicion+"&sucursal="+sucursal+"&menosl="+menosl+"&masl="+masl+"&tipor="+tipor+"&deplegal="+deplegal+"&formato="+formato+"&volumen="+volumen+"&nedicion="+nedicion+"&ncoleccion="+ncoleccion+"&tomo="+tomo)


//	llamarasincrono('consulta.php','contenidos');	
		}
	}else alert("Faltan campos por definir");
}

function aplicardesc(){
//donde se mostrará lo resultados
	var tipor=8;
	divResultado = document.getElementById('resultado');
	//valores de los inputs
	codt=document.ftitulos.codigo.value;
	sucursal=document.ftitulos.sucursal.value;	
	if(document.ftitulos.descuent.value=="")desc=0;
	else desc=eval(parseFloat(document.ftitulos.descuent.value));
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php

	
	if(codt!="" & sucursal!=""){
	conf=confirm("¿Seguro desea aplicar el descuento?");
	if(conf){
	ajax.open("POST","registrartitulo.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			//llamar a funcion para limpiar los inputs
			location.reload(true);

		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	
	ajax.send("codigo="+codt+"&sucursal="+sucursal+"&desc="+desc+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
		}
	}else alert("Faltan campos por definir");
}


function distribuirtitulo(codt,titulo,autor,isbn,codb,exit){
	//donde se mostrará lo resultados
	var tipor=2;
	divResultado = document.getElementById('resultado');
	//valores de los inputs

	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(codt!="" & titulo!="" & autor!="" & isbn!="" & codb!=""){
	ajax.open("POST","registrartitulo.php",true);
	ajax.onreadystatechange=function() {
	
	if(ajax.readyState==1){
                divResultado.innerHTML = "Distribuyendo libro por favor espere...";
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
	ajax.send("codigo="+codt+"&titulo="+titulo+"&autor="+aut+"&isbn="+isbn+"&codbarra="+codb+"&existencia="+exit+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
	}else alert("Faltan campos por definir");
}

function cargardetalle(){
	divResultado = document.getElementById('resultado');
	cods=document.forms[0].codigo.value;
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//solicitud.php

	if(cods!=null & cods!=""){
	ajax.open("POST","solicitud.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==1){
			divResultado.innerHTML = "Cargando Solicitud por favor espere...";	
		}else if (ajax.readyState==4){
			//mostrar resultados en esta capa
		divResultado.innerHTML = ajax.responseText	
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("cods="+cods)
	}
}

function cancelarsol(){
	//valores de los inputs
	//instanciamos el objetoAjax
	cods=document.form1.solicitud.value;
	var op=2;
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//eliminar.php
	
	if(cods!=null & cods!=""){
	confir=confirm("¿Esta seguro que desea salir y cancelar la solicitud?")
	if(confir){
	ajax.open("POST","eliminar.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			//llamar a funcion para limpiar los inputs
			cerrarventana();
			//window.blur()
			//window.close()
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("cods="+cods+"&op="+op)
	}
	
	}
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
//	window.location.reload(this);
}
// todo es correcto y ha llegado el momento de poner la información requerida
// en su sitio en la pagina xhtml
function cargarpagina (pagina_requerida, id_contenedor)
{
    if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
    document.getElementById (id_contenedor).innerHTML = pagina_requerida.responseText;
}

function agregareditorial(){
	//donde se mostrará lo resultados
	var tipor=3;
	divResultado = document.getElementById('resultado');
	//valores de los inputs
	editorial=document.feditorial.editorial.value;

	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(editorial!=""){
		
	ajax.open("POST","registrartitulo.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			//llamar a funcion para limpiar los inputs
		window.opener.location.reload(true)
		document.feditorial.editorial.value="";

		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("editorial="+editorial+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
	}else alert("Faltan campos por definir");
}

function agregarcoleccion(){
	//donde se mostrará lo resultados
	var tipor=4;
	divResultado = document.getElementById('resultado');
	//valores de los inputs
	coleccion=document.fcoleccion.coleccion.value;

	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(coleccion!=""){
		
	ajax.open("POST","registrartitulo.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			//llamar a funcion para limpiar los inputs
//			location.reload(true);
		window.opener.location.reload(true)
		document.fcoleccion.coleccion.value="";
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("coleccion="+coleccion+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
	}else alert("Faltan campos por definir");
}

function agregartema(){
	//donde se mostrará lo resultados
	var tipor=5;
	divResultado = document.getElementById('resultado');
	//valores de los inputs
	tema=document.ftema.tema.value;

	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(tema!=""){
		
	ajax.open("POST","registrartitulo.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			//llamar a funcion para limpiar los inputs
			window.opener.location.reload(true)
			document.ftema.tema.value="";
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("tema="+tema+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
	}else alert("Faltan campos por definir");
}

function agregarstema(){
	//donde se mostrará lo resultados
	var tipor=6;
	divResultado = document.getElementById('resultado');
	//valores de los inputs
	tema=document.fsubtema.tema.value;
	subtema=document.fsubtema.subtema.value;

	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(tema!="" & subtema!="" & tema!=0){
		
	ajax.open("POST","registrartitulo.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			//llamar a funcion para limpiar los inputs
			window.opener.location.reload(true)
			document.fsubtema.subtema.value="";
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("tema="+tema+"&subtema="+subtema+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
	}else alert("Faltan campos por definir");
}

var agregar
function abrirventana(ventana,nombre,alto,ancho){
   agregar=window.open(ventana,nombre,'width='+ancho+',height='+alto+',top='+((screen.height/2)-(180.5))+',left='+((screen.width/2)-(310.5))+',toolbar=no,scrollbars=yes,resizable=no,menubar=no,status=no,directories=no,location=no')
  
}

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}
