var DEFAULT_EMPTY_OK = false;

String.prototype.reverse=function() { return this.split("").reverse().join(""); }
String.prototype.format=function(sepMil,sepDec) { 
	var partes=this.split(".");			//dividimos parte entera de decimal
	var parteEnt=partes[0].reverse().replace( /(\d{3})(?=\d)/g ,"$1"+sepMil).reverse();
	var parteDec=(partes[1]?((partes[1].length==2)?partes[1]:partes[1].concat("0")):"00"); 
	return parteEnt+sepDec+parteDec;
}
String.prototype.desFormat=function(sepMil,sepDec) {
	var reMil=new RegExp("\\"+sepMil,"g");		//para localizar los sepMil
	var reDec=new RegExp("\\"+sepDec);			//para localizar los sepDec
	return this.replace(reMil,"").replace(reDec,".").replace(/\s/g,"");
}

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
    popupProveedor = window.open("./buscaProveedor.php","buscaProveedor","width=600,height=500,scrollbars=yes");
    popupProveedor.focus();
} 
function ponProveedor(cod){
	opener.document.frmLibro.editorial.value = cod;
	opener.document.frmLibro.submit();
    window.close();
}
function buscaProveedorP(){
    popupProveedor = window.open("./buscaProveedorP.php","buscaProveedor","width=600,height=500,scrollbars=yes");
    popupProveedor.focus();
} 
function ponProveedorP(cod){
	opener.document.frmLibro.editorial.value = cod;
    window.close();
}
function buscaArticulo(edit){
    popupArticulo = window.open("./buscaArticulo.php","buscaArticulo","width=700,height=500,scrollbars=yes");
    popupArticulo.focus();
} 
function ponArticulo(cod,titulo,autor,formato,precio){

	if (cod=="") cod="-";
	if (titulo=="") titulo="-";
	if (autor=="") autor="-";
	if (formato=="") formato="-";
	if (precio=="") precio="0,00";
	
	var table        = opener.document.getElementById("tabDet");
    var tr           = opener.document.createElement("tr");
	
    var tdCod     = opener.document.createElement("td");
    var tdTitulo   = opener.document.createElement("td");
    var tdAutor     = opener.document.createElement("td");
    var tdFormato   = opener.document.createElement("td");
    var tdprecioUni   = opener.document.createElement("td");
    var tdCantidad     = opener.document.createElement("td");
    var tdPrecioExt   = opener.document.createElement("td");
   
   //<input type="text" id="tlf" name="tlf" value="<?php echo($tlf); ?>" size="15" class="inputCodigo">
   
	var tbody        = opener.document.createElement("tbody");
	
	tdprecioUni.setAttribute("align","right");
	tdCantidad.setAttribute("align","center");
	tdPrecioExt.setAttribute("align","right");
	
	tdCod.innerHTML = cod;
	tdTitulo.innerHTML = titulo;
	tdAutor.innerHTML = autor;
	tdFormato.innerHTML = formato;
	tdprecioUni.innerHTML = precio;
	tdCantidad.innerHTML = "<input type='text' size='3' maxlength='5' onKeyPress='isNumeric();' onChange='calcularPrecio(this);'>";
	tdPrecioExt.innerHTML = "0,00";
	
	tbody.setAttribute("id","tbody");
        
	tr.appendChild(tdCod);
	tr.appendChild(tdTitulo);
	tr.appendChild(tdAutor);
	tr.appendChild(tdFormato);
	tr.appendChild(tdprecioUni);
	tr.appendChild(tdCantidad);
	tr.appendChild(tdPrecioExt);
	
	tbody.appendChild(tr);
	
	table.appendChild(tbody);
        
}
function calcularPrecio(inputCant){
	
	//var table = this.document.getElementById("tabDet");
	//var td=getElementById('tabDet')[0].firstChild.data;
	//alert(table.length);
	//var listTr = table.childNodes[];
	//var table = document.getElementById('tabDet').rows.length;
	//titulo = document.getElementById('tabDet').rows[i].cells[3].childNodes[0].data; 
	var precioTotal = 0;
	//alert(titulo);
	tdCant=inputCant.parentNode;
	tdPrecUni=tdCant.previousSibling;
	tdPrecExt=tdCant.nextSibling;
	
	cantidad=inputCant.value;
	precioUnit=tdPrecUni.firstChild.data;
	
	cantidad=parseFloat(cantidad);
	precioUnit=parseFloat(precioUnit.desFormat(".",","));
	
	precio = precioUnit*cantidad;
	tdPrecExt.firstChild.data = precio.toString().format(".",",");
	
	for (i=1; i<document.getElementById('tabDet').rows.length; i++) {
		strPrecioExt = document.getElementById('tabDet').rows[i].cells[6].childNodes[0].data;
		precExt=parseFloat(strPrecioExt.desFormat(".",","));
		precioTotal=precioTotal+precExt;
		//alert(precExt);
	}
	tdPrecioTotal = document.getElementById('tabTotal');
	tdPrecioTotal.rows[0].cells[1].childNodes[0].data = precioTotal.toString().format(".",",");
	//tdPrecExt.firstChild.data = precio.toString().format(".",",");
	//alert(precioTotal);
	/*
	var element  = client.responseXML.documentElement;
        alert(element);
    var tr,td;
        
	var iChildren = element.getElementsByTagName('cliente').length;
        for(i=0;i<iChildren;i++)
        {
          tr = document.createElement ("tr");
          tr.className="rows";
          tr.onmouseover = function(){this.className = "hiliterows"};
          tr.onmouseout = function(){ this.className = "rows" };
            
          td = document.createElement ("td");
          td.innerHTML = element.getElementsByTagName('nombre')[i].firstChild.data;
          tr.appendChild (td);
          td = document.createElement ("td");
          td.innerHTML = element.getElementsByTagName('apellido')[i].firstChild.data;
          tr.appendChild (td);
          td = document.createElement ("td");
          td.innerHTML = element.getElementsByTagName('cedula')[i].firstChild.data;
          tr.appendChild (td);
          td = document.createElement ("td");
          td.innerHTML = element.getElementsByTagName('fechaNacimiento')[i].firstChild.data;          
          tr.appendChild (td);
          tbody.appendChild (tr);
        }
		*/
	
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
function isNumeric(){
	if (event.keyCode < 48 || event.keyCode > 57) {
		event.returnValue = false;
	}	
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
	var decimalPointDelimiter='.'

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
					setFocus(idField);
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
						setFocus(idField);
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
							setFocus(idField);
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
						setFocus(idField);
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
							setFocus(idField);
							return false;
						}
					}
				}
				break;				
			case "DECIMAL":
				if (empty=="NO")		/* Si el campo no debe ser vacio se valida que el valor efectivamente sea de tipo float */
				{
					if (!isFloat(idField))
					{
						messageOperation = getMessageTypeOperations(typeOperation);
						messageError = messageOperation[0]+messageField+messageOperation[1]
						alert (messageError);						
						setFocus(idField);
						return false;
					}
				}
				else
				{
					if (!isEmpty(objField))
					{
						if (!isFloat(idField))
						{
							messageOperation = getMessageTypeOperations(typeOperation);
							messageError = messageOperation[0]+messageField+messageOperation[1]
							alert (messageError);
							setFocus(idField);
							return false;
						}
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
						setFocus(idField);
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
							setFocus(idField);
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
						setFocus(idField);
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
							setFocus(idField);
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
						setFocusSelect(idField);
						return false;
					}
				}
		}
	}	
	return true;
}

