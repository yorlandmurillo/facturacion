//@import url(sha1.js);

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

function anulafact()
{
	var codf=document.anulafactura.codf.value;
	var vend=document.anulafactura.vend.value;
	var suc=document.anulafactura.suc.value;
	var fecha=document.anulafactura.fecha.value;
	divResultado = document.getElementById('resultado');
	ajax=objetoAjax();
	
	confirmar=confirm("Desea anular la factura "+codf);
	if (confirmar)
	{	
		ajax.open("POST","../anulafactura.php",true);
		ajax.onreadystatechange=function() {
	  if (ajax.readyState==4) {
	  //mostrar resultados en esta capa
		document.muestrafactura.fecha_factura.disabled="true";
		document.muestrafactura.efectivo.disabled="true";
		document.muestrafactura.cheque.disabled="true";
		document.muestrafactura.tdb.disabled="true";
		document.muestrafactura.tdc.disabled="true";
		document.muestrafactura.cesta_ticket.disabled="true";
		document.muestrafactura.bl.disabled="true";
		document.muestrafactura.mto_iva.disabled="true";
		document.muestrafactura.fecha_factura.disabled="true";
		document.muestrafactura.fecha_factura.disabled="true";
		document.muestrafactura.fecha_factura.disabled="true";
		document.muestrafactura.fecha_factura.disabled="true";
		document.muestrafactura.Actualizar.style="display:none";
		divResultado.innerHTML = ajax.responseText;
		ocultardiv();
		}
	  }

	  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	  //enviando los valores
	  ajax.send("codf="+codf+"&vend="+vend+"&suc="+suc+"&fecha="+fecha)
		
	}
	else
	{
		return false;
	}
}


function ocultardiv() {
			div = document.getElementById('anula');
			div.style.display ='none';	
}


function nuevocliente(){
  //donde se mostrará lo resultados
  divResultado = document.getElementById('resultado');
//  divResultado.innerHTML= '<img src="anim.gif">';
  //valores de las cajas de texto
	cedula=document.clientes.clicedula.value;
	nom=document.clientes.clinombre.value;
	
	if(document.clientes.clibl.value=="")
	bl=0;
    else bl=document.clientes.clibl.value;
		
	sexo=document.clientes.sexo.value;
	
	if(document.clientes.clidireccion.value=="")
	dir="S/D";
	else dir=document.clientes.clidireccion.value;
	
	if(document.clientes.clitelefono.value=="")
	tel=0;
    else tel=document.clientes.clitelefono.value;
	
	if(document.clientes.clicelular.value=="")
	cel=0;
	else cel=document.clientes.clicelular.value;
	
	if(document.clientes.cliempresa.value=="")
	emp="NINGUNA";
	else emp=document.clientes.cliempresa.value;
	correo=document.clientes.clicorreo.value;
	pbl=document.clientes.pbl.value;


//instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medoto POST
  //archivo que realizará la operacion
  //registro.php
  if(cedula!="" && nom!="" && cedula!=0){
  ajax.open("POST","../funciones/procesarregistro.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos();

	document.mform.buscar.value=cedula
	document.mform.submit() 
	}
  }

  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("clicedula="+cedula+"&clinombre="+nom+"&clibl="+bl+"&sexo="+sexo+"&clidireccion="+dir+"&clitelefono="+tel+"&clicelular="+cel+"&cliempresa="+emp+"&clicorreo="+correo+"&pbl="+pbl)
  }else divResultado.innerHTML = "<strong>los Campos con (*) son obligatorios</strong>"
}


function modcliente(){
  //donde se mostrará lo resultados
  divResultado = document.getElementById('resultado');
//  divResultado.innerHTML= '<img src="anim.gif">';
  //valores de las cajas de texto
	cedula=document.clientes.clicedula.value;
	nom=document.clientes.clinombre.value;
	bl=document.clientes.clibl.value;
	sexo=document.clientes.sexo.value;
	dir=document.clientes.clidireccion.value;
	tel=document.clientes.clitelefono.value;
	cel=document.clientes.clicelular.value;
	emp=document.clientes.cliempresa.value;
	correo=document.clientes.clicorreo.value;
	pbl=document.clientes.pbl.value;
	
	 
//instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medoto POST
  //archivo que realizará la operacion
  //registro.php
  ajax.open("POST","../funciones/modclientes.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
//  LimpiarCampos();
  }
  }

  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("clicedula="+cedula+"&clinombre="+nom+"&clibl="+bl+"&sexo="+sexo+"&clidireccion="+dir+"&clitelefono="+tel+"&clicelular="+cel+"&cliempresa="+emp+"&clicorreo="+correo+"&pbl="+pbl)
}

function editarcliente(cliente){
new LITBox('../funciones/editarcliente.php?cliente='+cliente,{type:'window',overlay:false,height:370, width:550})
}


function printPage() { 

	//print(document); 

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

function validarrif(obj,valores){
	if(valores==1)
		cadena="JGPjgp-0123456789"
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

function nuevousuario(){
  //donde se mostrará lo resultados

divResultado = document.getElementById('resultado');

  //valores de las cajas de texto
	cedula=document.usuario.uscedula.value;
	nom=document.usuario.usnombre.value;
	apell=document.usuario.usapellido.value;
	suc=document.usuario.sucursal.value;
	login=document.usuario.uslogin.value;
	niv=document.usuario.nivel.value;
	pwd=hex_sha1(document.usuario.uspassword.value);
	pwdc=hex_sha1(document.usuario.uspasswordc.value);

	if(cedula=="" || nom=="" || apell=="" || login=="" || pwd=="" || pwdc==""){
		  divResultado.innerHTML = "<strong>Recuerde que todos los campos son obligatorios</strong>";
	}
//instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medoto POST
  //archivo que realizará la operacion
if(cedula!="" & nom!="" & apell!="" & login!="" & pwd!="" & pwdc!=""){
	
  ajax.open("POST","../funciones/procesarregistrouser.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
	LimpiarCamposuser();
}
  }

  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("uscedula="+cedula+"&usnombre="+nom+"&usapellido="+apell+"&sucursal="+suc+"&uslogin="+login+"&usnivel="+niv+"&uspassword="+pwd+"&uspasswordc="+pwdc)
  
}

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

function cambiarclave(){
  //donde se mostrará lo resultados
	divResultado=document.getElementById('respuesta');
  //valores de las cajas de texto
	login=document.usuarios.uslogin.value;
	
	if(document.usuarios.pwd.value!="")
	pwd=hex_sha1(document.usuarios.pwd.value);
	else pwd="";

	if(document.usuarios.pwd2.value!="")
	pwdc=hex_sha1(document.usuarios.pwd2.value);
	else pwdc="";


	if(pwd=="" || pwdc==""){
		  divResultado.innerHTML = "<strong>La contraseña esta en blanco</strong>";
	}
//instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medoto POST
  //archivo que realizará la operacion
if(pwd!="" & pwdc!=""){
	
  ajax.open("POST","../funciones/cambiarclave.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
//	LimpiarCamposuser();
	document.usuarios.pwd.value="";
	document.usuarios.pwd2.value="";
	}
}

  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("uslogin="+login+"&uspassword="+pwd+"&uspasswordc="+pwdc)
  
}

}

function modusuario(){

divResultado = document.getElementById('resultado');
divResultado.innerHTML ="";
  //valores de las cajas de texto
	nom=document.usuario.usnombre.value;
	apell=document.usuario.usapellido.value;
	suc=document.usuario.sucursal.value;
	niv=document.usuario.nivel.value;
	id=document.usuario.usid.value;
	est=document.usuario.estatus.value;
	
	if(nom=="" || apell==""){
		  divResultado.innerHTML = "<strong>Recuerde que todos los campos son obligatorios</strong>";
	}
//instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medoto POST
  //archivo que realizará la operacion
if(nom!="" & apell!=""){
	
  ajax.open("POST","../funciones/modusuario.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
	divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
	}
  }

  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("&usnombre="+nom+"&usapellido="+apell+"&sucursal="+suc+"&usnivel="+niv+"&usestatus="+est+"&usid="+id)
  
}

}

function editarusuario(usuario){
new LITBox('../funciones/editarusuario.php?usuario='+usuario,{type:'window',overlay:true,height:370, width:650})
}

function LimpiarCampos(){
   	document.clientes.clicedula.value="0";
	document.clientes.clinombre.value="";
	document.clientes.clibl.value="0";
	document.clientes.sexo.value="";
	document.clientes.clidireccion.value="";
	document.clientes.clitelefono.value="0";
	document.clientes.clicelular.value="0";
	document.clientes.cliempresa.value="";
	document.clientes.clicorreo.value="";
	document.clientes.clicedula.focus();
}
function LimpiarCamposuser(){
	document.usuario.uscedula.value=0;
	document.usuario.usnombre.value="";
	document.usuario.usapellido.value="";
	document.usuario.uslogin.value="";
	document.usuario.uspassword.value="";
	document.usuario.uspasswordc.value="";
	document.usuario.uscedula.focus();
}
function limpiarclave(){
	document.usuarios.uslogin.value="";
	document.usuarios.pwd.value="";
	document.usuarios.pwd2.value="";
}

function selectradio(id){

divResultado = document.getElementById('cantidad');

if(document.devolucion.items.length>1){
	for (i=0;i<document.devolucion.items.length;i++){

		if (document.devolucion.items.checked){
        	//document.devolucion.items[i].checked=0;
			divResultado.innerHTML="";
  	   }else{ 
			document.devolucion.items.checked=1;
			cantidad(id);
	   }
	}
} 
}

function devolveritem(){
  //valores de las cajas de texto
	if(document.devolucion.items.length>1){
	for (i=0;i<document.devolucion.items.length;i++){
       if (document.devolucion.items[i].checked)
        	iditem = eval(document.devolucion.items[i].value);  
	
    }
	}else{
		iditem = eval(document.devolucion.items.value);  	
	} 
	
	cant=document.devolucion.cantdev.value;
	//iditem = document.devolucion.items.value 
	codf=document.devolucion.codf.value;
	conf=confirm("¿Esta seguro de devolver el articulo?");
//instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medoto POST
  //archivo que realizará la operacion
//if(iditem!=null){
if(conf){
 
  ajax.open("POST","../funciones/devolveritem.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
	alert(ajax.responseText);
	//llamar a funcion para limpiar los inputs
	location.reload(true);
	//llamar a funcion para limpiar los inputs
	}
  }

  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("&codf="+codf+"&item="+iditem+"&cant="+cant)
}
//}else alert("No ha seleccionado ningun articulo");
}

function cantidad(id){

  divResultado = document.getElementById('cantidad');

  ajax=objetoAjax();
  ajax.open("POST","setcantidad.php",true);
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

function procesardev(){
  //valores de las cajas de texto
  divResultado = document.getElementById('devolucion');
  	codf = document.devolucion.codf.value;  
	suc = document.devolucion.sucursal.value;  	
	user=document.devolucion.usid.value;
	conf=confirm("¿Esta seguro de procesar la devolución?");
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medoto POST
  //archivo que realizará la operacion
if(conf){
  ajax.open("POST","../funciones/procesardev.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
	divResultado.innerHTML = ajax.responseText
	//llamar a funcion para limpiar los inputs
	location.reload(true);
	//llamar a funcion para limpiar los inputs
	}
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("&codf="+codf+"&suc="+suc+"&user="+user)
}
}

function agregaritem(){
	//donde se mostrará lo resultados
	divResultado = document.getElementById('resultado');
	//valores de los inputs
	codp=document.devolucion.codp.value;
	codfdv=document.devolucion.codfdv.value;
	cant=document.devolucion.cantitems.value;
	vend=document.devolucion.usid.value;
	suc=document.devolucion.sucursal.value;
	//instanciamos el objetoAjax

	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registro.php
	if(codp!=""){
	if(cant>0){
	ajax.open("POST","../agregaritem.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			alert(ajax.responseText);
			refres();
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("codp="+codp+"&codf="+codfdv+"&cant="+cant+"&suc="+suc+"&vend="+vend)

		
	}else alert("Especifique la cantidad");

	}else alert("Ingrese un código valido");
}

function borraritem(iditem,cod,cant,suc){
	//usaremos un cuadro de confirmacion	
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		//instanciamos el objetoAjax
		ajax=objetoAjax();
		//uso del medotod POST
		//indicamos el archivo que realizará el proceso de eliminación
		ajax.open("POST", "../borraritem.php",true);
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				//mostrar resultados en esta capa
				alert(ajax.responseText);
			refres();
			}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		//como hacemos uso del metodo POST
		ajax.send("codp="+iditem+"&cod="+cod+"&cant="+cant+"&suc="+suc)
	}
}
function cancelaritems(){
	//donde se mostrará lo resultados
	//valores de los inputs
	codf=document.devolucion.codfdv.value;
	vend=document.devolucion.usid.value;
	suc=document.devolucion.sucursal.value;
	//instanciamos el objetoAjax

	confir=confirm("¿Desea cancelar la devolución?");
ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registro.php
	if(confir){
	ajax.open("POST","../borraritemdev.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			//alert(ajax.responseText);
			//llamar a funcion para limpiar los inputs
			window.location.href="../consultas/facturas.php";
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("codf="+codf+"&vend="+vend+"&suc="+suc)
	}
}


function iSubmitEnter(oEvento, oFormulario){
     var iAscii;
     if (oEvento.keyCode)
         iAscii = oEvento.keyCode;
     else if (oEvento.which)
         iAscii = oEvento.which;
     else
         return false;

     if (iAscii == 13){ 
	 agregaritem();
}
return true;
} 
function refres(){
   location.reload(true);
}
function esc(){
	cancelaritems();
}

function aceptardev(){

	montototal=parseFloat(document.devolucion.montototal1.value);
	codf=document.devolucion.codfdv.value;
	cliente=document.devolucion.cliente.value;
	vend=document.devolucion.usid.value;
	total=parseFloat(document.devolucion.diferencia.value);
	subt=parseFloat(document.devolucion.diferencia.value);
	mtoiva=parseFloat(document.devolucion.iva1.value);
	iva=document.devolucion.iva.value;	
	suc=document.devolucion.sucursal.value;
	dif=parseFloat(document.devolucion.diferencia.value);
	devuelto=parseFloat(document.devolucion.montodev.value);
	
	if(document.devolucion.efectivo.value=="")efec=0;
	else efec=parseFloat(document.devolucion.efectivo.value);
	
	if(document.devolucion.tdb.value=="")tdb=0;
	else tdb=parseFloat(document.devolucion.tdb.value);

	if(document.devolucion.tdc.value=="")tdc=0;
	else tdc=parseFloat(document.devolucion.tdc.value);

	if(document.devolucion.bl.value=="")bl=0;
	else bl=parseFloat(document.devolucion.bl.value);

	if(document.devolucion.especial.value=="")esp=0;
	else esp=parseFloat(document.devolucion.especial.value);

	if(document.devolucion.cheque.value=="")mtocheque=0;
	else mtocheque=parseFloat(document.devolucion.cheque.value);

	if(document.devolucion.omoneda.value=="")omonto=0;
	else omoneda=parseFloat(document.devolucion.omoneda.value);

	if(document.devolucion.cesta.value=="")cesta=0;
	else cesta=parseFloat(document.devolucion.cesta.value);

	if(document.devolucion.nrocheque.value=="")nrocheque=0;
	else nrocheque=document.devolucion.nrocheque.value;

	if(document.devolucion.nrocuenta.value=="")nrocta=0;
	else nrocta=document.devolucion.nrocuenta.value;

	if(document.devolucion.bancos.value=="")banco=0;
	else banco=document.devolucion.bancos.value;

	if(document.devolucion.nroconf.value=="")nroconf=0;
	else nroconf=document.devolucion.nroconf.value;
	
	totalp=eval(efec+tdb+tdc+bl+esp+mtocheque+omoneda+cesta);

	cambio=totalp-dif;

	msg=confirm("Va a procesar una factura ¿Esta Seguro?");
	
	if(msg){
	if(codf!="Devuelta"){
	//if(efec > 0 || tdb > 0 || tdc > 0 || bl > 0 || mtocheque > 0 || esp > 0 || omoneda > 0 || cesta > 0 & dif>=0){
	if(montototal>=devuelto){
	
	if(totalp>dif || totalp==dif){
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registro.php
	ajax.open("POST","../funciones/creardevolucion.php",true);

	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
//			alert(ajax.responseText);
			//llamar a funcion para limpiar los inputs
			verfactura(codf,suc,vend);
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("codf="+codf+"&cliente="+cliente+"&vend="+vend+"&total="+total+"&subt="+subt+"&mtoiva="+mtoiva+"&iva="+iva+"&efec="+efec+"&tdb="+tdb+"&tdc="+tdc+"&bl="+bl+"&esp="+esp+"&mtocheque="+mtocheque+"&nrocheque="+nrocheque+"&nrocta="+nrocta+"&banco="+banco+"&nroconf="+nroconf+"&suc="+suc+"&omoneda="+omoneda+"&cesta="+cesta+"&cambio="+cambio)
	}else alert("Debe cancelar el monto total de la factura");
}else alert("La Factura debe ser por el monto devuelto o mayor");
}else alert("La factura ya fue devuelta");
}
}

function verfactura(codf,suc,vend) {
	window.location.href="../funciones/printfactura.php?codf="+codf+"&vend="+vend+"&suc="+suc;
}
