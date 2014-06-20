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

function cargarbl(){
	//donde se mostrará lo resultados
	div = document.getElementById('bl');
	//valores de los inputs
	cedu=document.bonolibro.cedula.value;
	lib=document.bonolibro.codsuc.value;
	clave=document.bonolibro.clavesuc.value;
	tarj=document.bonolibro.tarjetabl.value;
	isbn=document.bonolibro.isbn.value;
	if(document.bonolibro.monto1.value!="")monto=eval(parseFloat(document.bonolibro.monto1.value));
	else monto=0;

	//Enviar datos a Bono Libro
	if(monto!=null & monto!=0 & tarj!="" & lib!=""){
		
	/////////div.src="http://200.109.244.138:8081/BonoLibro/Afiliados/ingresosigal.php?libreria="+lib+"&clave="+clave+"&credencial="+tarj+"&monto="+monto+"&isbn="+isbn;	
	//libreria,clave,credencial,monto,isbn
	}else alert("Faltan datos por definir");

}