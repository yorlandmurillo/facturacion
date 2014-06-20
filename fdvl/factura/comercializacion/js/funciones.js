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
function agregaritem(){
	//donde se mostrará lo resultados
	var tipor=1;
	divResultado = document.getElementById('resultado');
	//valores de los inputs
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


function borraritemt(){
	//donde se mostrará lo resultados
	divResultado = document.getElementById('resultado');
	var op=3;
	//	
	if(document.traslado.itemt.length>1){
	for (i=0;i<document.traslado.itemt.length;i++){
       if (document.traslado.itemt[i].checked)
        	iditem = eval(document.traslado.itemt[i].value);  
	   }
	}else{
	   if (document.traslado.itemt.checked){
        iditem = eval(document.traslado.itemt.value); 	
	   }
	} 	
	codt=document.traslado.codigot.value;
	cods=document.forms[0].codigo.value;
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//eliminar.php
	
	if(iditem!=null & codt!="" & document.traslado.itemt.checked!=0 || document.traslado.itemt[i].checked!=0){
	confir=confirm("¿Esta seguro de eliminar el registro?")
	if(confir){
	ajax.open("POST","eliminar.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			iditem=null;
			cargardetalle(cods)
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("id="+iditem+"&op="+op+"&codt="+codt)
	}
	
	}else alert("Debe seleccionar un registro")
}

function cancelartraslado(){
	var op=4;
	//	
	codt=document.traslado.codigot.value;
	cods=document.forms[0].codigo.value;
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//eliminar.php
	
	confir=confirm("¿Esta seguro de salir y cancelar el traslado?")
	if(confir){
	ajax.open("POST","eliminar.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			alert(ajax.responseText)
			window.close(this);
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("cods="+cods+"&op="+op+"&codt="+codt)
	}
}

function aceptarsol(){
	//donde se mostrará lo resultados
	var tipor=2;
	//divResultado = document.getElementById('resultado');
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
			//mostrar resultados en mensaje
			alert(ajax.responseText)
			prints=confirm("¿Desea imprimir la solicitud?")
			if(prints){
			abrirventana("printsolicitud.php","reportesolicitud",800,700,cods)
			location.reload(true);
			}else location.reload(true);
		//	document.form1.totalgen.value=totalgen+monto;
		//	llamarasincrono('consultar.php','resultado');	
		//  llamar a funcion para limpiar los inputs
			
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores

	ajax.send("solicitud="+cods+"&proveedor="+prov+"&formap="+formap+"&cond="+cond+"&fechae="+fechae+"&fechav="+fechav+"&fechavc="+fechavc+"&monto="+monto+"&tipor="+tipor)
//	llamarasincrono('consulta.php','contenidos');	
	}
	}else alert("Faltan campos por definir");
}


function aceptart(){
	//donde se mostrará lo resultados
	var tipor=3;
	//divResultado = document.getElementById('resultado');
	//valores de los inputs
	codt=document.traslado.codigot.value;
	cods=document.traslado.codigo.value;
	ob=document.traslado.observaciones.value;
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(codt!="" & cods!=""){
	confir=confirm("Va ha aceptar un Traslado, ¿Esta seguro?")
	if(confir){	
	ajax.open("POST","registrar.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
		alert(ajax.responseText)
		mensj=confirm("¿Desea imprimir el traslado?")
		if(mensj){
		abrirventana("printtraslado.php","reportetraslado",800,700,codt)
		location.reload(true);
		}else location.reload(true);
				
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("codt="+codt+"&tipor="+tipor+"&cods="+cods+"&ob="+ob)
//	llamarasincrono('consulta.php','contenidos');	
	}
	}else alert("Faltan campos por definir");
}


function modificartraslado(){
	//donde se mostrará lo resultados
	var tipor=4;
	//divResultado = document.getElementById('resultado');
	//valores de los inputs
	codt=document.traslado.codigot.value;
	cods=document.traslado.codigo.value;
	ob=document.traslado.observaciones.value;
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(codt!="" & cods!=""){
	confir=confirm("Va ha modificar un Traslado, ¿Esta seguro?")
	if(confir){	
	ajax.open("POST","registrar.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
		alert(ajax.responseText)
		mensj=confirm("¿Desea imprimir el traslado?")
		if(mensj){
		abrirventana("printtraslado.php","reportetraslado",800,700,codt)
		window.close(this);
		}else location.reload(true);
				
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("codt="+codt+"&tipor="+tipor+"&cods="+cods+"&ob="+ob)
//	llamarasincrono('consulta.php','contenidos');	
	}
	}else alert("Faltan campos por definir");
}


function cargardetalle(codigo){
	divResultado = document.getElementById('resultado');
	divcantidad = document.getElementById('cantidad');
	codt=document.traslado.codigot.value;
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
		divcantidad.innerHTML=null
		actualizart()
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("cods="+codigo)
	}
}

function cantidad(id){

  divResultado = document.getElementById('cantidad');

  ajax=objetoAjax();
  ajax.open("POST","setcant.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
	divResultado.innerHTML = ajax.responseText
	//llamar a funcion para limpiar los inputs
	}
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("&id="+id)

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

function actualizart(){
	//donde se mostrará lo resultados
	divResultado = document.getElementById('detallet');
	divcantidad = document.getElementById('cantidad');
	//valores de los inputs
	codt=document.traslado.codigot.value;
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//listado.php
	ajax.open("POST","listado.php",true);
	ajax.onreadystatechange=function() {
		if(ajax.readyState==1){
		divResultado.innerHTML = "Cargando traslado por favor espere...";	
		}else if (ajax.readyState==4){
			//mostrar resultados en esta capa
			divResultado.innerHTML = ajax.responseText	
			divcantidad.innerHTML=null
			iditem=null
			suc=0
			cant=0
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("codt="+codt)
//	llamarasincrono('consulta.php','contenidos');	
}

function asignartraslado(){
	//donde se mostrará lo resultados
	divResultado = document.getElementById('detallet');
	divcantidad = document.getElementById('cantidad');

	//valores de los inputs
	if(document.traslado.listado.length>1){
	for (i=0;i<document.traslado.listado.length;i++){
       if (document.traslado.listado[i].checked)
        	iditem = eval(document.traslado.listado[i].value);  
	   }
	}else{
	   if (document.traslado.listado.checked){
        iditem = eval(document.traslado.listado.value); 	
	   }
	}
	codt=document.traslado.codigot.value;
	suc=document.traslado.sucursal.value;
	cods=document.traslado.codigo.value;
	cant=document.traslado.cant.value;
	cond=document.traslado.condicion.value;
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(codt!="" & cods!="" & iditem!=null & suc > 0 & cant > 0 & cond!=null){

	ajax.open("POST","listado.php",true);
	ajax.onreadystatechange=function() {
		
		if(ajax.readyState==1){
		divResultado.innerHTML = "Asignando traslado por favor espere...";	
		}else if (ajax.readyState==4){
			//mostrar resultados en esta capa
			divResultado.innerHTML = ajax.responseText	
			divcantidad.innerHTML=null
			cargardetalle(cods)
			iditem=null
			suc=0
			cant=0
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("cods="+cods+"&codt="+codt+"&suc="+suc+"&cant="+cant+"&iditem="+iditem+"&cond="+cond)
//	llamarasincrono('consulta.php','contenidos');	
	}else alert("Faltan campos por definir");
}


function asignartodo(){
	//donde se mostrará lo resultados
	divResultado = document.getElementById('detallet');
	divcantidad = document.getElementById('cantidad');
	var todos=1;
	//valores de los inputs
	codt=document.traslado.codigot.value;
	suc=document.traslado.sucursal.value;
	cods=document.traslado.codigo.value;
	cond=document.traslado.condicion.value;
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registrar.php
	if(codt!="" & cods!="" & suc > 0 & cond!=null){

	ajax.open("POST","listado.php",true);
	ajax.onreadystatechange=function() {
		
		if(ajax.readyState==1){
		divResultado.innerHTML = "Asignando traslado por favor espere...";	
		}else if (ajax.readyState==4){
			//mostrar resultados en esta capa
			divResultado.innerHTML = ajax.responseText	
			divcantidad.innerHTML=null
			cargardetalle(cods)
			suc=0
			cant=0
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("cods="+cods+"&codt="+codt+"&suc="+suc+"&cond="+cond+"&todos="+todos)
//	llamarasincrono('consulta.php','contenidos');	
	}else alert("Faltan campos por definir");
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
var ventana
function abrirventana(pagina,nombre,alto,ancho,parametro){
   ventana=window.open(pagina+"?codigol="+parametro,nombre,'width='+ancho+',height='+alto+',top='+((screen.height/2)-(180.5))+',left='+((screen.width/2)-(310.5))+',toolbar=no,scrollbars=yes,resizable=no,menubar=no,status=no,directories=no,location=no')
  
}
