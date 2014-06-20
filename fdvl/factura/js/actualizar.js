 var RequestObject = false;
 var Archivo = 'http://localhost/atlas/datos.php'; //directorio donde tenemos el archivo ajax.php
 window.setInterval("actualizacion_reloj()",2000); // el tiempo X que tardará en actualizarse
 if (window.XMLHttpRequest) //
 RequestObject = new XMLHttpRequest();
 if (window.ActiveXObject)
 RequestObject = new ActiveXObject("Microsoft.XMLHTTP");
 function ReqChange() {
 // Si se ha recibido la información correctamente
 if (RequestObject.readyState==4) {
 // si la información es válida
 if (RequestObject.responseText.indexOf('invalid') == -1)
 {
 // obtener la respuesta
 var msgs = RequestObject.responseText.split('|');
 // Buscamos la div con id online
 document.getElementById("online").innerHTML = msgs[0];
 }
 else {
 // Por si hay algun error
 document.getElementById("online").innerHTML = "Error llamando";
 }
 }
 }
 function llamadaAjax() {
 // Mensaje a mostrar mientras se obtiene la información remota...
 document.getElementById("online").innerHTML = "";
 // Preparamos la obtención de datos
 RequestObject.open("GET", Archivo , true);
 RequestObject.onreadystatechange = ReqChange;
 // Enviamos
 RequestObject.send(null);
 }
 function actualizacion_reloj() {
 llamadaAjax();
 }

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

