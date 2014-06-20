var DEFAULT_EMPTY_OK = false;

String.prototype.reverse=function() { return this.split("").reverse().join(""); }
String.prototype.format=function(sepMil,sepDec) { 
	var partes=this.split(".");			//dividimos parte entera de decimal
	var parteEnt=partes[0].reverse().replace( /(\d{3})(?=\d)/g ,"$1"+sepMil).reverse();
	var parteDec=(partes[1]?partes[1]:"00");
	parteDec=parteDec.substring(0,2);
	parteDec=(parteDec.length==2)?parteDec:parteDec.concat("0"); 
	
	return parteEnt+sepDec+parteDec;
}
String.prototype.desFormat=function(sepMil,sepDec) {
	var reMil=new RegExp("\\"+sepMil,"g");		//para localizar los sepMil
	var reDec=new RegExp("\\"+sepDec);			//para localizar los sepDec
	return this.replace(reMil,"").replace(reDec,".").replace(/\s/g,"");
}
/*
Función: obtenerParametros
recibe: strURL   --> ejmp: www.loquesea.com?var1=valor1&var2=valor2&var3=valor3&...
retorna: parametros  --> arreglo con los parametros.  ejmp: parametros[0] contiene "var1=valor1"
*/
function obtenerParametros(strURL){
	var strQueryString="";
	var hasQueryString = strURL.indexOf('?');
	if (hasQueryString != -1)
	{
		strQueryString = strURL.substring(hasQueryString+1, strURL.length);
	}
	var parametros = strQueryString.split("&");
	return parametros;
}

//VARIABLE GLOBAL
var textoAnterior = '';

//ESTA FUNCIÓN DEFINE LAS REGLAS DEL JUEGO
function cumpleReglas(simpleTexto)
	{
		//la pasamos por una poderosa expresión regular
		var expresion = new RegExp("^(|([0-9]{1,2}(\\.([0-9]{1,2})?)?))$");

		//si pasa la prueba, es válida
		if(expresion.test(simpleTexto))
			return true;
		return false;
	}//end function checaReglas

//ESTA FUNCIÓN REVISA QUE TODO LO QUE SE ESCRIBA ESTÉ EN ORDEN
function revisaCadena(textItem)
	{
		//si comienza con un punto, le agregamos un cero
		if(textItem.value.substring(0,1) == '.') 
			textItem.value = '0' + textItem.value;

		//si no cumples las reglas, no te dejo escribir
		if(!cumpleReglas(textItem.value))
			textItem.value = textoAnterior;
		else //todo en orden
			textoAnterior = textItem.value;
	}//end function revisaCadena
		
var popupAutor;
/*
function nuevoAutor(){
    popupNuevoAutor = window.open("./nuevoAutor.php","nuevoAutor","width=450,height=450,scrollbars=yes");
    popupNuevoAutor.focus();
} */
function buscaAutor(){
    popupAutor = window.open("./buscaAutor.php","buscaAutor","width=520,height=500,scrollbars=yes");
    popupAutor.focus();
} 
function ponAutor(cod){
	opener.document.frmLibro.autor.value = cod;
    window.close();
}
function buscaProveedor(){
    popupProveedor = window.open("./buscaProveedor.php","buscaProveedor","width=800,height=500,scrollbars=yes");
    popupProveedor.focus();
} 
function ponProveedor(cod){
	//alert(cod);
	opener.document.frmLibro.editorial.value = cod;
	opener.document.frmLibro.submit();
    window.close();
}
function buscaProveedorP(fieldsFormatForm, form, num){
	if(checkFormatFields(fieldsFormatForm)){
		if((form.editorial.value!="0")&&(document.getElementById('tabDet').rows.length > 1)){
			if (confirm("Se eliminaran los articulos de la tabla ¿desea continuar?")) {
				for(var i = document.getElementById("tabDet").rows.length; i > 1;i--)
				{
					document.getElementById("tabDet").deleteRow(i -1);
				}
				var tabTotal = document.getElementById('tabTotal');
				tabTotal.rows[0].cells[3].childNodes[0].data = "0,00";
				tabTotal.rows[2].cells[2].childNodes[0].data = "0,00";
				if(num){
					popupProveedor = window.open("./buscaProveedorP.php","buscaProveedor","width=700,height=500,scrollbars=yes");
					popupProveedor.focus();
				}
			}
		}else{
			if(num){
				popupProveedor = window.open("./buscaProveedorP.php","buscaProveedor","width=700,height=500,scrollbars=yes");
				popupProveedor.focus();
			}
		}
	}
} 
function ponProveedorP(cod){
	opener.document.frmPedido.editorial.value = cod;
    window.close();
}
function buscaProveedorO(form, num){
	if((form.editorial.value!="0")&&(document.getElementById('tabDet').rows.length > 1)){
		if (confirm("Se eliminaran los articulos de la tabla ¿desea continuar?")) {
			for(var i = document.getElementById("tabDet").rows.length; i > 1;i--)
			{
				document.getElementById("tabDet").deleteRow(i -1);
			}
			var tabTotal = document.getElementById('tabTotal');
			tabTotal.rows[0].cells[3].childNodes[0].data = "0,00";
			tabTotal.rows[2].cells[2].childNodes[0].data = "0,00";
			if(num){
				popupProveedor = window.open("./buscaProveedorO.php","buscaProveedor","width=700,height=500,scrollbars=yes");
				popupProveedor.focus();
			}
		}
	}else{
		if(num){
			popupProveedor = window.open("./buscaProveedorO.php","buscaProveedor","width=700,height=500,scrollbars=yes");
			popupProveedor.focus();
		}
	}
} 
function ponProveedorO(cod){
	opener.document.frmCompra.editorial.value = cod;
	opener.document.frmCompra.submit();
    window.close();
}
function buscaArticulo(fieldsFormatForm, edit){
	if(checkFormatFields(fieldsFormatForm)){
		var leftVal = (500 - screen.width) / 2;
		var topVal = (500 - screen.height) / 2;

	    popupArticulo = window.open("./buscaArticulo.php?editorial="+edit,"buscaArticulo","width=1200,height=500,scrollbars=yes,left="+leftVal+",top="+topVal);
	    popupArticulo.focus();
	}
}


function buscaArticulo2(fieldsFormatForm, edit){
	if(checkFormatFields(fieldsFormatForm)){
		var leftVal = (500 - screen.width) / 2;
		var topVal = (500 - screen.height) / 2;

	    popupArticulo = window.open("./buscaArticulo2.php?editorial="+edit,"buscaArticulo2","width=1200,height=500,scrollbars=yes,left="+leftVal+",top="+topVal);
	    popupArticulo.focus();
	}
}



function buscaArticulo3(fieldsFormatForm, edit){
	if(checkFormatFields(fieldsFormatForm)){
		var leftVal = (500 - screen.width) / 2;
		var topVal = (500 - screen.height) / 2;

	    popupArticulo = window.open("./buscaArticulo3.php?editorial="+edit,"buscaArticulo3","width=1200,height=500,scrollbars=yes,left="+leftVal+",top="+topVal);
	    popupArticulo.focus();
	}
}


function imprimirPagina(){
	focus(); 
	print();
}
function guardarPedido(fieldsFormatForm, form, pagina){
	var codArticulo = new Array();
    var precioUni = new Array();
    var cantidad = new Array();
	var strDesc = form.desc.value;
    var table	= document.getElementById("tabDet");
	
	for (var i=table.rows.length; i > 1; i--) {
		if(table.rows[i-1].cells[6].childNodes[0].value == 0){
			if(!confirm("Se eliminara el articulo "+ table.rows[i-1].cells[0].childNodes[0].data +" por tener cantidad cero (0) o vacio\n¿desea continuar?")){
				return;
			}else{
				table.deleteRow(i-1);
			}
		}
	}
	
	if(checkFormatFields(fieldsFormatForm)){
		//focus(); 
		//print();
		if(table.rows.length > 1){
			for (i=1; i<table.rows.length; i++) {
				codArticulo[i-1]=table.rows[i].cells[0].childNodes[0].data;
				precioUni[i-1]=table.rows[i].cells[5].childNodes[0].data;
				cantidad[i-1]=table.rows[i].cells[6].childNodes[0].value;
			}
			
			form.cod_libro.value = codArticulo.toString();
			form.precio_libro.value = precioUni.join("+");
			form.cant_libro.value = cantidad.toString();
			
			form.desc.value = parseFloat(strDesc.desFormat(".",","));
			form.action = pagina; 
			form.submit();
		}else{
			alert("Debe seleccionar al menos un (1) articulo");
		}
	}
}
function guardarEntrega(fieldsFormatForm, form, pagina){
	var codArticulo = new Array();
    var precioUni = new Array();
    var cantidad = new Array();
	var cantidad2 = new Array();
	var strDesc = form.desc.value;
    var table	= document.getElementById("tabDet");
	
	if(checkFormatFields(fieldsFormatForm)){
		//focus(); 
		//print();
		if(table.rows.length > 1){
			for (i=1; i<table.rows.length; i++) {
				codArticulo[i-1]=table.rows[i].cells[0].childNodes[0].data;
				precioUni[i-1]=table.rows[i].cells[5].childNodes[0].data;
				cantidad[i-1]=table.rows[i].cells[6].childNodes[0].data;
				cantidad2[i-1]=table.rows[i].cells[7].childNodes[0].value;
			}
			
			form.cod_libro.value = codArticulo.toString();
			form.precio_libro.value = precioUni.join("+");
			form.cant_libro.value = cantidad.toString();
			form.cant_libro2.value = cantidad2.toString();
			
			form.desc.value = parseFloat(strDesc.desFormat(".",","));
			form.action = pagina; 
			form.submit();
		}else{
			alert("Debe seleccionar al menos un (1) articulo");
		}
	}
}







function guardarRecepcion(fieldsFormatForm, form, pagina){
	var codArticulo = new Array();
    var precioUni = new Array();
    var cantidad = new Array();
	var cantidad2 = new Array();
	var cisbn = new Array();
	var cbarra = new Array();
	var ctitulo = new Array();
	var cautor = new Array();
	
    var strDesc = form.desc.value;
    var table	= document.getElementById("tabDet");
	
	if(checkFormatFields(fieldsFormatForm)){
		//focus(); 
		//print();
		if(table.rows.length > 1){
			for (i=1; i<table.rows.length; i++) {

codArticulo[i-1]=table.rows[i].cells[0].childNodes[0].data;
ctitulo[i-1]=table.rows[i].cells[1].childNodes[0].data;
cautor[i-1]=table.rows[i].cells[2].childNodes[0].data;
cisbn[i-1]=table.rows[i].cells[3].childNodes[0].data;
cbarra[i-1]=table.rows[i].cells[4].childNodes[0].data;
		cantidad2[i-1]=table.rows[i].cells[7].childNodes[0].value;	
			}
form.cod_libro.value = codArticulo.toString();
form.cod_titulo.value = ctitulo.toString();
form.cod_autor.value = cautor.toString();
form.cod_isbn.value = cisbn.toString();
form.cod_Barra.value = cbarra.toString();
form.cant_libro2.value = cantidad2.toString();


			
			form.desc.value = parseFloat(strDesc.desFormat(".",","));
			form.action = pagina; 
			form.submit();
			
			
			
		}else{
			alert("Debe seleccionar al menos un (1) articulo");
		}
	}
}






function limpiarPagina(pagina){
	if(confirm('¿Seguro desea limpiar esta pagina?')) 
		window.location.href=pagina;
}
function elimArticulos(){
	var table = document.getElementById("tabDet");
	if (confirm("¿Seguro desea eliminar los articulos seleccionados?")) {
		for (i=1; i<table.rows.length; i++) {
			checkValue = table.rows[i].cells[8].childNodes[0].checked;
			if(checkValue){
				table.deleteRow(i);
			}
		}
		calcularPrecioTotal(7);
	}
	
}


function ponArticulo(cod,titulo,autor,numTomo,formato,precio,exist,tipoP){
	var p="";
	var params = obtenerParametros(opener.document.URL);
	var pmt1 = params[0].split("=");
	if(pmt1[0]=='p') p=pmt1[1];
	
	if (cod=="") cod="-";
	if (titulo=="") titulo="-";
	if (autor=="") autor="-";
	if (numTomo=="") numTomo="-";
	if (formato=="") formato="-";
	if (precio=="") precio="0,00";
	
	var table        = opener.document.getElementById("tabDet");
	var strFlag = 0;
	
	for (i=1; i<table.rows.length; i++) {
		strCod = table.rows[i].cells[0].childNodes[0].data;
		if (strCod == cod) {
			strFlag = 1;
			alert("El articulo ya se encuentra en la lista");
		}
	}
		if(!strFlag){
    var tr           = opener.document.createElement("tr");
	
    var tdCod     = opener.document.createElement("td");
    var tdTitulo   = opener.document.createElement("td");
    var tdAutor     = opener.document.createElement("td");
    var tdTomo   = opener.document.createElement("td");
	var tdFormato   = opener.document.createElement("td");
    var tdprecioUni   = opener.document.createElement("td");
    var tdCantidad     = opener.document.createElement("td");
    var tdPrecioExt   = opener.document.createElement("td");
	var tdCheckEli   = opener.document.createElement("td");
   
   //<input type="text" id="tlf" name="tlf" value="<?php echo($tlf); ?>" size="15" class="inputCodigo">
   
	var tbody        = opener.document.createElement("tbody");
	
	tdprecioUni.setAttribute("align","right");
	tdCantidad.setAttribute("align","center");
	tdPrecioExt.setAttribute("align","right");
	tdCheckEli.setAttribute("align","center");
	tdCheckEli.setAttribute("class","noimprimir");
	
	tdCod.innerHTML = cod;
	tdTitulo.innerHTML = titulo;
	tdAutor.innerHTML = autor;
	tdTomo.innerHTML = numTomo;
	tdFormato.innerHTML = formato;
	tdprecioUni.innerHTML = precio;
	if (p=="compra"){
		tdCantidad.innerHTML = "<input type='text' size='3' maxlength='6' onKeyPress=\"return esNumero(event,'d',this);\" onChange='calcularPrecio2(this,1);'><input type='hidden' value='"+exist+"'><input type='hidden' value='"+tipoP+"'>";
	}else{
		tdCantidad.innerHTML = "<input type='text' size='3' maxlength='6' onKeyPress=\"return esNumero(event,'d',this);\" onChange='calcularPrecio(this);'><input type='hidden' value='"+exist+"'><input type='hidden' value='"+tipoP+"'>";
	}
	tdPrecioExt.innerHTML = "0,00";
	tdCheckEli.innerHTML = "<input type='checkbox' name='checkEli'>";
	
	tbody.setAttribute("id","tbodyDet");
        
	tr.appendChild(tdCod);
	tr.appendChild(tdTitulo);
	tr.appendChild(tdAutor);
	tr.appendChild(tdTomo);
	tr.appendChild(tdFormato);
	tr.appendChild(tdprecioUni);
	tr.appendChild(tdCantidad);
	tr.appendChild(tdPrecioExt);
	tr.appendChild(tdCheckEli);
	
	tbody.appendChild(tr);
	
	table.appendChild(tbody);
		}
        
}


/////// aqui para las devoluciones ///////////


function ponArticulo2(cod,titulo,autor,numTomo,formato,precio,exist,tipoP){
	var p="";
	var params = obtenerParametros(opener.document.URL);
	var pmt1 = params[0].split("=");
	if(pmt1[0]=='p') p=pmt1[1];
	
	if (cod=="") cod="-";
	if (titulo=="") titulo="-";
	if (autor=="") autor="-";
	if (numTomo=="") numTomo="-";
	if (formato=="") formato="-";
	if (precio=="") precio="0,00";
	
	var table        = opener.document.getElementById("tabDet");
	var strFlag = 0;
	
	for (i=1; i<table.rows.length; i++) {
		strCod = table.rows[i].cells[0].childNodes[0].data;
		if (strCod == cod) {
			strFlag = 1;
			alert("El articulo ya se encuentra en la lista");
		}
	}
		if(!strFlag){
    var tr           = opener.document.createElement("tr");
	
    var tdCod     = opener.document.createElement("td");
    var tdTitulo   = opener.document.createElement("td");
    var tdAutor     = opener.document.createElement("td");
    var tdTomo   = opener.document.createElement("td");
	var tdFormato   = opener.document.createElement("td");
    var tdprecioUni   = opener.document.createElement("td");
    var tdCantidad     = opener.document.createElement("td");
    var tdPrecioExt   = opener.document.createElement("td");
	var tdCheckEli   = opener.document.createElement("td");
   
   //<input type="text" id="tlf" name="tlf" value="<?php echo($tlf); ?>" size="15" class="inputCodigo">
   
	var tbody        = opener.document.createElement("tbody");
	
	tdprecioUni.setAttribute("align","right");
	tdCantidad.setAttribute("align","center");
	tdPrecioExt.setAttribute("align","right");
	tdCheckEli.setAttribute("align","center");
	tdCheckEli.setAttribute("class","noimprimir");
	
	tdCod.innerHTML = cod;
	tdTitulo.innerHTML = titulo;
	tdAutor.innerHTML = autor;
	tdTomo.innerHTML = numTomo;
	tdFormato.innerHTML = formato;
	tdprecioUni.innerHTML = precio;
	if (p=="compra"){
		tdCantidad.innerHTML = "<input type='text' size='3' maxlength='6' onKeyPress=\"return esNumero(event,'d',this);\" onChange='calcularPrecio22(this,1);'><input type='hidden' value='"+exist+"'><input type='hidden' value='"+tipoP+"'>";
	}else{
		tdCantidad.innerHTML = "<input type='text' size='3' maxlength='6' onKeyPress=\"return esNumero(event,'d',this);\" onChange='calcularPrecio22(this);'><input type='hidden' value='"+exist+"'><input type='hidden' value='"+tipoP+"'>";
	}
	tdPrecioExt.innerHTML = "0,00";
	tdCheckEli.innerHTML = "<input type='checkbox' name='checkEli'>";
	
	tbody.setAttribute("id","tbodyDet");
        
	tr.appendChild(tdCod);
	tr.appendChild(tdTitulo);
	tr.appendChild(tdAutor);
	tr.appendChild(tdTomo);
	tr.appendChild(tdFormato);
	tr.appendChild(tdprecioUni);
	tr.appendChild(tdCantidad);
	tr.appendChild(tdPrecioExt);
	tr.appendChild(tdCheckEli);
	
	tbody.appendChild(tr);
	
	table.appendChild(tbody);
		}
        
}


/////// tambien para las devoluciones ///////////


function calcularPrecio22(inputCant){
	var tdCant=inputCant.parentNode;
	var tdPrecUni=tdCant.previousSibling;
	var tdPrecExt=tdCant.nextSibling;
	var cantidad=inputCant.value;
	var existencia=inputCant.nextSibling.value;
	var tipoProv=inputCant.nextSibling.nextSibling.value;
	var precioUnit=tdPrecUni.firstChild.data;
	var table = document.getElementById("tabDet");
	var indiceFila = tdCant.parentNode.rowIndex;
	
	cantidad=(esEntero(cantidad))?cantidad:"0";
	cantidad=parseInt(cantidad);
	existencia=parseInt(existencia);
	
	precioUnit=parseFloat(precioUnit.desFormat(".",","));	
	precio = precioUnit*cantidad;
	
	tdPrecExt.firstChild.data = precio.toString().format(".",",");
	calcularPrecioTotal(7);
}





/////// termina las devoluciones ///////////














function calcularPrecio(inputCant){
	var tdCant=inputCant.parentNode;
	var tdPrecUni=tdCant.previousSibling;
	var tdPrecExt=tdCant.nextSibling;
	var cantidad=inputCant.value;
	var existencia=inputCant.nextSibling.value;
	var tipoProv=inputCant.nextSibling.nextSibling.value;
	var precioUnit=tdPrecUni.firstChild.data;
	var table = document.getElementById("tabDet");
	var indiceFila = tdCant.parentNode.rowIndex;
	
	cantidad=(esEntero(cantidad))?cantidad:"0";
	cantidad=parseInt(cantidad);
	existencia=parseInt(existencia);
	
	if (existencia < 1){
		alert("Este articulo no se encuentra en existencia");
		inputCant.value=0;
		cantidad=0;
		table.deleteRow(indiceFila);
	}else{
		if (((existencia - cantidad) < 30)&&(tipoProv=="P")){
			if ((existencia-30) < 1){
				alert("La existencia se encuentra por debajo de la reserva");
				inputCant.value=0;
				cantidad=0;
				table.deleteRow(indiceFila);
			}else{
				alert("Solo puede seleccionar maximo "+(existencia-30)+" unidades de este articulo");
				inputCant.value=existencia-30;
				cantidad=existencia-30;
			}
		}else{
			if (cantidad > existencia){
				alert("Solo puede seleccionar maximo "+existencia+" unidades de este articulo");
				inputCant.value=existencia;
				cantidad=existencia;
			}
		}
	}
	precioUnit=parseFloat(precioUnit.desFormat(".",","));	
	precio = precioUnit*cantidad;
	
	tdPrecExt.firstChild.data = precio.toString().format(".",",");
	calcularPrecioTotal(7);
}
function n_sibling(obj){
	var sibling = obj.nextSibling;
	while (sibling && sibling.nodeType != 1) {
		sibling = sibling.nextSibling;
	}
	return sibling;
}
function p_sibling(obj){
	var sibling = obj.previousSibling;
	while (sibling && sibling.nodeType != 1) {
		sibling = sibling.previousSibling;
	}
	return sibling;
}
function calcularPrecio2(inputCant,tipTabla){
	var tdCant=inputCant.parentNode;
	var cantidad=inputCant.value;
	var tdCantPed="";
	var tdPrecUni="";
	var tdPrecExt=n_sibling(tdCant);

	cantidad=parseInt(cantidad);
	
	if(tipTabla==1){
		tdPrecUni=p_sibling(tdCant);
		//alert("tdPrecUni"+tdPrecUni.firstChild.data);
		trPrecio=7;
	}else{
		tdCantPed=p_sibling(tdCant);
		tdPrecUni=p_sibling(p_sibling(tdCant));
		trPrecio=8;
		
		var cantPed=tdCantPed.firstChild.data;
		cantPed=parseInt(cantPed);
		
		if (cantidad > cantPed){
			alert("La cantidad no puede ser mayor al numero de articulos solicitados");
			inputCant.value=cantPed;
			cantidad=cantPed;
		}
	}
	
	var precioUnit=tdPrecUni.firstChild.data;
	
	precioUnit=parseFloat(precioUnit.desFormat(".",","));	
	precio = precioUnit*cantidad;
	tdPrecExt.firstChild.data = precio.toString().format(".",",");
	//tdPrecExt.firstChild.innerHTML = "12345";
	calcularPrecioTotal(trPrecio);
}
function calcularPrecioTotal(trPrecio){
	var precioTotal = 0;
	var canLibTotal = 0;
	var table = document.getElementById("tabDet");
	var tabTotal = document.getElementById('tabTotal');
	for (i=1; i<table.rows.length; i++) {
		strPrecioExt = table.rows[i].cells[trPrecio].childNodes[0].data;
		if(table.rows[i].cells[trPrecio-1].childNodes[0].nodeType == 1)
			cantLib = table.rows[i].cells[trPrecio-1].childNodes[0].value;
		else
			cantLib = table.rows[i].cells[trPrecio-1].childNodes[0].data;
		precExt=parseFloat(strPrecioExt.desFormat(".",","));
		cantLib=(esEntero(cantLib))?cantLib:"0";
		cantLib=parseInt(cantLib);
		precioTotal=precioTotal+precExt;
		canLibTotal=canLibTotal+cantLib;
	}
	tabTotal.rows[0].cells[3].childNodes[0].data = precioTotal.toString().format(".",",") + " Bs.";
	tabTotal.rows[0].cells[2].childNodes[0].data = canLibTotal.toString() + " Uni.";
	calcularTotalGeneral();
}
function calcularTotalGeneral(){
	var tabTotal = document.getElementById('tabTotal');
	var tdTotal = tabTotal.rows[0].cells[3].childNodes[0].data;
	var inputDescuento = tabTotal.rows[1].cells[2].childNodes[0].value;
	
	precioTotal=parseFloat(tdTotal.desFormat(".",","));
	inputDescuento=inputDescuento?inputDescuento:"0";
	descuento=parseFloat(inputDescuento.desFormat(".",","));
	totalGeneral = redondear(precioTotal*(1-(descuento/100)),1);
	
	tabTotal.rows[2].cells[2].childNodes[0].data = totalGeneral.toString().format(".",",") + " Bs.";
}
function v_camposIguales(form, fieldsFormatForm, act, pagina){
	if(form.pwd2.value == form.pwd.value)	{ 
		f_process(form, fieldsFormatForm, act, pagina); 
	}else{
		alert("La repetición de la contraseña no coincide.");
		form.pwd2.value = ""; form.pwd.focus(); return true;
	}
}
function buscaCliente(){
    popupCliente = window.open("./buscaCliente.php","buscaCliente","width=520,height=500,scrollbars=yes");
    popupCliente.focus();
} 
function ponCliente(cod){
	opener.document.frmPedido.cliente.value = cod;
    opener.document.frmPedido.submit();
    window.close();
}
function f_process_ubi(form, fieldsFormatForm, act, pagina){
		form.local_.value=form.local.options[form.local.selectedIndex].text;
		form.salon_.value=form.salon.options[form.salon.selectedIndex].text;
		form.color_.value=form.color.options[form.color.selectedIndex].text;
		form.estante_.value=form.estante.options[form.estante.selectedIndex].text;
		form.pasillo_.value=form.pasillo.options[form.pasillo.selectedIndex].text;
		f_process(form, fieldsFormatForm, act, pagina); 
}
function f_process(form, fieldsFormatForm, act, pagina){
		if((act=="E")||checkFormatFields(fieldsFormatForm)){
			form.accion.value = act;
			form.action = pagina; 
			form.submit();
		}
}
function v_select(form, busq, pagina){
	form.var_busq.value = busq;
	form.action = pagina;
	form.submit(); 
}
function v_listar(form, pagina){
	form.accion.value = "Listar";
	form.action = pagina;
	form.submit(); 
}
function bloqDesbloq()
{
a = login.usuario.value
if (a != "") { a = true; }
else { a = false; }
if (a == true) { login.clave.disabled = false; }
else { login.clave.disabled = true; }
}
function f_select(vCedula)
{
	alert(vCedula);
}
function textCounter(field, countField, maxLimit) 
{
	if (field.value.length > maxLimit)
	{
		field.value = field.value.substring(0, maxLimit);
	}	
	else
	{
		countField.value = maxLimit - field.value.length;
	}
}
var ARRAY_TYPE_MESSAGE_OPERATIONS = Array(new Array("VACIO", "El campo ", " es requerido"),
										  new Array("ENTERO", "El campo ", " debe ser un número"), 
										  new Array("FECHA", "El campo ", " es requerido"), 
										  new Array("DECIMAL","El campo ", " debe ser un valor decimal. Ejemplo: 1234XX.4XX"),
										  new Array("CI", "El campo "," debe tener mas de 5 dígitos y ser un número para ser un cedula valida"),
									      new Array("EMAIL", "El campo ", " no es un email valido. El formato debe ser: XXXX@YYY.ZZZ"),
										  new Array("NUMERO_TELEFONICO", " El campo ", " no es un número telefonico valido. El formato debe ser: 416xxxxxxx. 212xxxxxxx"),
										  new Array("TEXTO","El campo ", " debe tener solo letra"), 
  										  new Array("ALFANUMERICO","El campo ", " debe tener solo letras y números."),
										  new Array("SELECTED_OPTION","Debe seleccionar una opcion de la lista desplegable ", " "),
										  new Array("RADIO_BUTTON_LIST_SELECTED","Debe seleccionar una de las opciones de la lista ", " "),
										  new Array("LIST_MULTIPLE_SELECTED","Debe asociar al menos un ", " "),
										  new Array("HEXADECIMAL","El campo ", " debe ser un valor hexadecimal"));
function isEmpty(field)
{
	switch(field.type) 
	{
		case "select-one":
			if (field.selectedIndex == -1 || field.options[field.selectedIndex].text == "" || field.value == "")
			{
				return true;
			}
			break;
		case "select-multiple":
			if (field.selectedIndex == -1)
			{
				return true;
			}
			break;
		case "text":
		case "password":
		case "textarea":
			if (field.value == "" || field.value == null)
			{
				return true;
			}
			break;
			default:
	}
	return false;
}
function isDigit (fieldValue)
{	
	return ((fieldValue >= "0") && (fieldValue <= "9"))
}

function esEntero (s)
   {
      var i;

      if (esVacio(s))
      if (esEntero.arguments.length == 1) return 0;
      else return (esEntero.arguments[1] == true);

      for (i = 0; i < s.length; i++)
      {
         var c = s.charAt(i);

         if (!isDigit(c)) return false;
      }

      return true;
   }

   function esVacio(s)
   {
      return ((s == null) || (s.length == 0))
   }

function isNumeric(event){
	opc = true;
	var tecla = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	//if (event.keyCode < 48 || event.keyCode > 57) {
	if (tecla < 48 || tecla > 57) {
		opc = false;
	}
	return opc;
}
/*function isNumeric(){
	if (event.keyCode < 48 || event.keyCode > 57) {
		event.returnValue = false;
	}	
}*/
function esNumero(e,tipo,obj){
	var opc = false;
	var tecla = (window.event) ? e.keyCode : e.which;
	
	if ((tecla==0)||(tecla==8)||(tecla >= 48 && tecla <= 57))
		opc = true;
	if (tipo == "f")
		if (obj.value.search("[,*]") == -1 && obj.value.length != 0)
			if (tecla == 44)
				opc = true;
	return opc;
}
function isFloat2(aEvent){
	var key = null;
	opc = true;

	if (window.event) {//ie
		key = window.event.keyCode;
	} else if (aEvent.which) {
		key = aEvent.which;
	}
	//alert(key);
	if ((key < 48 || key > 57) &&(key != 44)) {
		opc = false;
	}
	return opc;
}
function isLetter (fieldValue)
{
    return( ( uppercaseLetters.indexOf(fieldValue) != -1 ) ||
            ( lowercaseLetters.indexOf(fieldValue) != -1 ) )
}
function isInteger (idField)
{   
	var i;
	var objField = document.getElementById(idField);	
    if (isEmpty(objField)) 
       if (isInteger.arguments.length == 1) return DEFAULT_EMPTY_OK;
       else return (isInteger.arguments[1] == true);
    
    for (i = 0; i < objField.value.length; i++)
    {   
        var c = objField.value.charAt(i);
        if( i != 0 ) 
		{
            if (!isDigit(c)) return false;
        } else 
		{ 
            if (!isDigit(c) && (c != "-") || (c == "+")) return false;
        }
    }
    return true;
}
function isFloat (idField)
{   
	var i;
    var seenDecimalPoint = false;
	var objField = document.getElementById(idField);
	var decimalPointDelimiter=','

    if (isEmpty(objField)) 
       if (isFloat.arguments.length == 1) return DEFAULT_EMPTY_OK;
       else return (isFloat.arguments[1] == true);

    if (objField.value == decimalPointDelimiter) return false;

    for (i = 0; i < objField.value.length; i++)
    {   
        var c = objField.value.charAt(i);

        if ((c == decimalPointDelimiter) && !seenDecimalPoint)
		{
			seenDecimalPoint = true;
		} 		
        else if (!isDigit(c)) 
		{
			return false;
		}
    }	
    return true;
}
function minLength(inputString,inputLength)
{
  return (inputString.length >= inputLength);
}
function isCI (idField)
{
	var longMin = 5;
	var objField = document.getElementById(idField);
	if (minLength(objField.value,longMin) && isInteger(idField))
	{
		return true;
	}		
}
function isAlphanumeric (idField)
{   
	var i;
	var objField = document.getElementById(idField);
	
    if (isEmpty(objField)) 
       if (isAlphanumeric.arguments.length == 1) return DEFAULT_EMPTY_OK;
       else return (isAlphanumeric.arguments[1] == true);

    for (i = 0; i < objField.value.length; i++)
    {   
        var c = objField.value.charAt(i);
        if (! (isLetter(c) || isDigit(c) ) )
		{
			return false;
		}
    }
    return true;
}
function isSelectedOption (idField)
{
	var objField = document.getElementById(idField);	
	//alert ("num " + objField.length)
	if ((objField.value =='0') && (objField.length > 1))
	{
		return false;			
	}
	else
	{
		return true;
	}
}
function isDate (field)
{
	var strFecha = field.value;	
	var fecha = strFecha.split ("/");
	var dia = fecha[0];
	var mes = fecha[1];
	var ano = fecha[2];

	if ((dia.length != 2) || (mes.length != 2) || (ano.length != 4))
	{return false;}
	
	if ((dia =='00') || (mes =='00') || (ano =='0000'))
	{return false;}
	else
	{return true;}
}
function getMessageTypeOperations(typeOperation)
{
	var arrayOperation;
	var message = new Array();
	
	for (i=0; i<ARRAY_TYPE_MESSAGE_OPERATIONS.length; i++) 	
	{
		arrayOperation=ARRAY_TYPE_MESSAGE_OPERATIONS[i];
		if (arrayOperation[0]==typeOperation)
		{
				message=[arrayOperation[1],arrayOperation[2]];
		}
	}
	return message;
}
function checkFormatFields (arrayFormFields) 
{
	var arrayField = new Array();	 
	var idField;
	var typeOperation;
	var messageOperation= new Array;
	var empty;
	var objField;
	var messageField;
	var messageError;
	
	for (i=0; i<arrayFormFields.length; i++)
	{
		arrayField=arrayFormFields[i];
		idField = arrayField[0];
		empty =arrayField[1];
		typeOperation=arrayField[2];
		objField = document.getElementById(idField);
		messageField=arrayField[3];
		switch(typeOperation) 
		{
			case "VACIO":
				if (isEmpty(objField))
				{
					messageOperation = getMessageTypeOperations(typeOperation);					
					messageError = messageOperation[0]+messageField+messageOperation[1]
					alert (messageError);
					//setFocus(idField);
					return false;
				}
				break;
			case "ENTERO":
				if (empty=="NO")		/* Si el campo no debe ser vacio se valida que el valor efectivamente sea de tipo entero */
				{
					if (!isInteger(idField))
					{
						messageOperation = getMessageTypeOperations(typeOperation);
						messageError = messageOperation[0]+messageField+messageOperation[1]
						alert (messageError);
						//setFocus(idField);
						return false;
					}
				}
				else
				{
					if (!isEmpty(objField))
					{
						if (!isInteger(idField))
						{
							messageOperation = getMessageTypeOperations(typeOperation);
							messageError = messageOperation[0]+messageField+messageOperation[1]
							alert (messageError);
							//setFocus(idField);
							return false;
						}
					}
				}
				break;				
			case "FECHA":
				if (empty=="NO")		/* "NOT NULL" Si el campo no debe ser vacio se valida que el valor efectivamente sea de tipo entero */
				{
					if (!isDate(objField))
					{
						messageOperation = getMessageTypeOperations(typeOperation);
						messageError = messageOperation[0]+messageField+messageOperation[1]
						alert (messageError);
						//setFocus(idField);
						return false;
					}
				}
				else
				{
					if (!isEmpty(objField))
					{
						if (!isDate(objField))
						{
							messageOperation = getMessageTypeOperations(typeOperation);
							messageError = messageOperation[0]+messageField+messageOperation[1]
							alert (messageError);
							//setFocus(idField);
							return false;
						}
					}
				}
				break;				
			case "DECIMAL":
				if (empty=="NO")		/* Si el campo no debe ser vacio se valida que el valor efectivamente sea de tipo float */
				{
					var strDesc = objField.value;
					objField.value = parseFloat(strDesc.desFormat(".",","));
					/*
					if (!isFloat(idField))
					{
						messageOperation = getMessageTypeOperations(typeOperation);
						messageError = messageOperation[0]+messageField+messageOperation[1]
						alert (messageError);						
						//setFocus(idField);
						return false;
					}*/
				}
				else
				{
					if (!isEmpty(objField))
					{
						var strDesc = objField.value;
						objField.value = parseFloat(strDesc.desFormat(".",","));
						/*
						if (!isFloat(idField))
						{
							messageOperation = getMessageTypeOperations(typeOperation);
							messageError = messageOperation[0]+messageField+messageOperation[1]
							alert (messageError);
							//setFocus(idField);
							return false;
						}*/
					}
				}
				break;
			case "CI":
				if (empty=="NO")		/* Si el campo no debe ser vacio se valida que el valor efectivamente una CI valida */
				{
					if (!isCI(idField))
					{
						messageOperation = getMessageTypeOperations(typeOperation);
						messageError = messageOperation[0]+messageField+messageOperation[1]
						alert (messageError);
						//setFocus(idField);
						return false;
					}
				}
				else
				{
					if (!isEmpty(objField))
					{
						if (!isCI(idField))
						{
							messageOperation = getMessageTypeOperations(typeOperation);
							messageError = messageOperation[0]+messageField+messageOperation[1]
							alert (messageError);
							//setFocus(idField);
							return false;
						}
					}
				}
				break;
			case "ALFANUMERICO":
				if (empty=="NO")		/* Si el campo no debe ser vacio se valida que el valor efectivamente sea alfanumerico */
				{
					if (!isAlphanumeric(idField))
					{
						messageOperation = getMessageTypeOperations(typeOperation);
						messageError = messageOperation[0]+messageField+messageOperation[1]
						alert (messageError);
						//setFocus(idField);
						return false;
					}
				}
				else
				{
					if (!isAlphanumeric(objField))
					{
						if (!isAlphabetic(idField))
						{
							messageOperation = getMessageTypeOperations(typeOperation);
							messageError = messageOperation[0]+messageField+messageOperation[1]
							alert (messageError);
							//setFocus(idField);
							return false;
						}
					}
				}
				break;
				case "SELECTED_OPTION":
				if (empty=="NO")		/* Si el campo no debe ser vacio se valida que el valor efectivamente sea alfanumerico */
				{
					if (!isSelectedOption(idField))
					{
						messageOperation = getMessageTypeOperations(typeOperation);
						messageError = messageOperation[0]+messageField+messageOperation[1]
						alert (messageError);
						//setFocusSelect(idField);
						return false;
					}
				}
		}
	}	
	return true;
}
function redondear(num, dec){
    num = parseFloat(num);
    dec = parseFloat(dec);
    dec = (!dec ? 2 : dec);
    return Math.round(num * Math.pow(10, dec)) / Math.pow(10, dec);
} 