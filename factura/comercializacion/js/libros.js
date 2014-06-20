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
function asignartraslado(){
	//donde se mostrará lo resultados
	var tipor=1;
	divResultado = document.getElementById('detallet');
	//valores de los inputs
	codt=document.form1.solicitud.value;
	cods=document.form1.solicitud.value;
	codp=document.form1.codigo.value;
	titulo=document.form1.titulo.value;
	cant=eval(parseInt(document.form1.cantidad.value));
	costo=eval(parseFloat(document.form1.costo.value));
	totalgen=eval(parseInt(document.form1.totalgen.value));
	monto=eval(cant*costo);
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(cods!="" & codp!="" & titulo!="" & cant > 0 ){
		
	ajax.open("POST","registrar.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			document.form1.totalgen.value=totalgen+monto;
			llamarasincrono('consultar.php','resultado');	
	//llamar a funcion para limpiar los inputs
			limpiarcampos();
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("solicitud="+cods+"&codigo="+codp+"&titulo="+titulo+"&cantidad="+cant+"&costo="+costo+"&montosol="+monto+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
	}else alert("Faltan campos por definir");
}

function borraritemsol(){
	//donde se mostrará lo resultados
	divResultado = document.getElementById('resultado');
	var op=1;
	//	
	if(document.form1.listado.length>1){
	for (i=0;i<document.form1.listado.length;i++){
       if (document.form1.listado[i].checked)
        	iditem = eval(document.form1.listado[i].value);  
	   }
	}else{
	   if (document.form1.listado.checked){
        iditem = eval(document.form1.listado.value); 	
	   }
	} 	
//valores de los inputs
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//eliminar.php
	
	if(iditem!=null & document.form1.listado.checked!=0 || document.form1.listado[i].checked!=0){
	confir=confirm("¿Esta seguro de eliminar el registro?")
	if(confir){
	ajax.open("POST","eliminar.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			iditem=null;
			//llamar a funcion para limpiar los inputs
			llamarasincrono('consultar.php','resultado');	
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("id="+iditem+"&op="+op)
	}
	
	}else alert("Debe seleccionar un registro")
}


function aceptarsol(){
	//donde se mostrará lo resultados
	var tipor=2;
//	divResultado = document.getElementById('resultado');
	//valores de los inputs
	cods=document.form1.solicitud.value;
	prov=document.form1.proveedor.value;
	cond=document.form1.condicion.value;
	formap=document.form1.formapago.value;
	fechae=document.form1.fechae.value;
	fechav=document.form1.fechav.value;
	fechavc=document.form1.fechavc.value;
	monto=eval(parseFloat(document.form1.totalgen.value));

	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(formap!=0 & fechae!="" & fechav!=""){
	confir=confirm("Va ha aceptar una Solicitud, ¿Esta seguro?")
	if(confir){	
	ajax.open("POST","registrar.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
		//	document.form1.totalgen.value=totalgen+monto;
	//		llamarasincrono('consultar.php','resultado');	
	//llamar a funcion para limpiar los inputs
			location.reload(true);
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores

	ajax.send("solicitud="+cods+"&proveedor="+prov+"&formap="+formap+"&cond="+cond+"&fechae="+fechae+"&fechav="+fechav+"&fechavc="+fechavc+"&monto="+monto+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
	}
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

function limpiarcampos(){
	document.form1.codigo.value="";
	document.form1.titulo.value="";
	document.form1.autor.value="";
	document.form1.editorial.value="";
	document.form1.cantidad.value=0;
	document.form1.costo.value=0;
}
