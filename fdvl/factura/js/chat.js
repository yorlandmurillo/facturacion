// JavaScript Document
var UltFec;

function objetoAjax(){
	var xmlhttp=false;
	try{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}catch(e){
		try{
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(E){
			xmlhttp = false;
  		}
	}

	if(!xmlhttp && typeof XMLHttpRequest!='undefined'){
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function enviarMensaje(){
	
	men=document.chatinterno.mensaje.value;
	userd=getCheckedValue(document.chatinterno.elements['opcionuser']);
	
	ajax=objetoAjax();
	ajax.open("POST", "r_mensaje.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			consultaMensajes();
			document.chatinterno.mensaje.value="";
			document.chatinterno.mensaje.focus();
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("&mensaje="+men+"&userdest="+userd)
}



function consultaMensajes(){
	divResultado = document.getElementById('pagina');
	ajax=objetoAjax();
	ajax.open("GET", "chat.php?ultfec="+UltFec,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//divResultado.innerHTML=ajax.responseText;
			var datos=ajax.responseXML.documentElement;
			for (i = 0; i < datos.getElementsByTagName('elemento').length; i++){
				var item = datos.getElementsByTagName('elemento')[i];
				var class = item.getElementsByTagName('clase')[0].firstChild.data;
				var usu = item.getElementsByTagName('usuario')[0].firstChild.data;
				var men = item.getElementsByTagName('mensaje')[0].firstChild.data;

				var linea='<th class="c_usuario">'+usu+'</th><th class="c_mensaje">'+men+'</th>';
				
				CrearCaja(linea,class);
			} 
			//si ultima fecha esta definida se usará
			//caso contrario se dejara con su valor anterior
			if(typeof fec!='undefined'){
				UltFec=fec;
			}
		}
		
	}
	ajax.send(null)
	//cada 3 segundos consulta por nuevos mensajes
	setTimeout('consultaMensajes();',3000);
}

window.onload = function (){
	consultaMensajes();
}
