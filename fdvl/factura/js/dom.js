// JavaScript Document
function CrearCaja(texto,class){
	//contenedor principal
	var pagina=document.getElementById('pagina');
	
	//creando nuevo div
	var cajaNueva=document.createElement('div');
	//creando texto del div con mensaje de la caja de texto
	
	//asignandoles atributos
	cajaNueva.setAttribute('className',class); //para IE
	cajaNueva.setAttribute("class",class);
	
	//llenando la caja nueva
	cajaNueva.innerHTML=texto;
	
	//insertar antes del primer elemento de pagina
	pagina.insertBefore(cajaNueva,pagina.firstChild);
	
	//elimiar el ultimo elemento
	EliminarCaja();
}

//remueve el ultimo elementos si estos superan los 10
function EliminarCaja(){
	var pagina=document.getElementById('pagina');
	elementos=pagina.childNodes;
	if(elementos.length>5){
		pagina.removeChild(pagina.lastChild);
	}
}

function omchat(id){
mostrado=0;

	elem = document.getElementById(id);
		if(elem.style.display=='block')mostrado=1;
			elem.style.display='none';
		if(mostrado!=1)elem.style.display='block';

}

function vermensajes(sucursal,usuario,alto,ancho,nombre){
var pagina="mensajes.php";
ventana=window.open(pagina+"?sucursal="+sucursal+"&usuario="+usuario,nombre,'width='+ancho+',height='+alto+',top='+((screen.height/2)-(180.5))+',left='+((screen.width/2)-(310.5))+',toolbar=no,scrollbars=yes,resizable=no,menubar=no,status=no,directories=no,location=no')
  
}

contenido_textarea = ""
num_caracteres_permitidos = 250
function valida_longitud(){
	num_caracteres = document.forms[0].mensaje.value.length
	
	if (num_caracteres <= num_caracteres_permitidos){
		contenido_textarea = document.forms[0].mensaje.value	
	}else{
		document.forms[0].mensaje.value = contenido_textarea
	}
	
	if (num_caracteres >= num_caracteres_permitidos){
		document.forms[0].caracteres.style.color="#ff0000";
	}else{
		document.forms[0].caracteres.style.color="#000000";
	}
	
	cuenta()
}
function cuenta(){
	document.forms[0].caracteres1.value=num_caracteres_permitidos 
	document.forms[0].caracteres.value=document.forms[0].mensaje.value.length
	document.forms[0].caracteres1.value=document.forms[0].caracteres1.value-document.forms[0].mensaje.value.length

}

function saltodelinea(){
texto = document.chatinterno.mensaje.value.length;
cant = document.chatinterno.mensaje.cols;

//alert(cant)

limite = cant;
	
	if(texto == cant) {
		limite = cant;
	}
	else {
		for(i=1;i<31;i++) {
			if(texto == (cant*i)) {
				limite = (cant*i);
			}
		}
	}
	if((texto == limite)||(event.KeyCode==13)) {
		mensaje.rows = mensaje.rows+1;
	}
}

