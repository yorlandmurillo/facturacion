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

function agregarproveedor(){
	//donde se mostrará lo resultados
	var tipor=1;
	divResultado = document.getElementById('resultado');
	//valores de los inputs
	nom=document.proveedor.nombre.value;
	cont=document.proveedor.contacto.value;
	telf=document.proveedor.telefono.value;
	fax=document.proveedor.fax.value;
	cel=document.proveedor.cel.value;
	dir=document.proveedor.direccion.value;
	rif=document.proveedor.rif.value;
	tipo=document.proveedor.tipo.value;

	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(nom!="" & cont!="" & dir!="" & tipo!="" & tipo!=0){
		
	ajax.open("POST","registrarproveedor.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			//llamar a funcion para limpiar los inputs
		window.opener.location.reload(true)
		document.proveedor.nombre.value="";
		document.proveedor.contacto.value="";
		document.proveedor.telefono.value="";
		document.proveedor.fax.value="";
		document.proveedor.cel.value="";
		document.proveedor.direccion.value="";
		document.proveedor.rif.value="";
		
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	
	ajax.send("nombre="+nom+"&contacto="+cont+"&telefono="+telf+"&fax="+fax+"&celular="+cel+"&direccion="+dir+"&rif="+rif+"&tipo="+tipo+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
	}else alert("Faltan campos por definir");
}

function modificartitulo(){
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
	ajax.open("POST","modificar.php",true);
	ajax.onreadystatechange=function(){
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

var agregar
function abrirventana(ventana,nombre,alto,ancho){
   agregar=window.open(ventana,nombre,'width='+ancho+',height='+alto+',top='+((screen.height/2)-(180.5))+',left='+((screen.width/2)-(310.5))+',toolbar=no,scrollbars=yes,resizable=no,menubar=no,status=no,directories=no,location=no')
  
}
