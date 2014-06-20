//@import url(sha1.js);


function imprimirPagina(){
	focus(); 
	print();
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



function printfactura(factura,vend,sucursal,consultando)
{
	document.print.imprimir.disabled=true;

 //alert(factura+" "+vend+" "+sucursal+" "+consultando);
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registro.php
	ajax.open("POST","printfacturalp.php",true);

	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa
			var respuesta=ajax.responseXML;
			resp=respuesta.getElementsByTagName("resp")[0].childNodes[0].data;
			
			if(resp=="true"){
				window.close()
			}else alert("No se pudo procesar la impresión")

		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("codf="+factura+"&vend="+vend+"&suc="+sucursal+"&consultando="+consultando)


}

//Editar la factura

function editafactura(factura,vend,sucursal){

//	document.print.imprimir.disabled=true;

	alert(factura+" "+vend+" "+sucursal);

	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registro.php
	ajax.open("POST","editfacturalp.php",true);

	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			//mostrar resultados en esta capa

			var respuesta=ajax.responseXML;
			resp=respuesta.getElementsByTagName("resp")[0].childNodes[0].data;
			
			if(resp=="true"){
				window.close()
			}else alert("No se pudo procesar la impresión")

		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("codf="+factura+"&vend="+vend+"&suc="+sucursal)

}


