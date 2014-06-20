// JavaScript Document
var formatoFecha;
var wCalendario;
// Permite definir el formato de la fecha  y el campo que se quiere llenar
function elegirFecha(formatoFechaCampo,campo) {
  formatoFecha = formatoFechaCampo
	var hoy = new Date();
	var annioFinal = hoy.getFullYear();
	var annioInicial = annioFinal - 100;
  var fechaIni = (eval(campo).value=="") ? fechaFormateada(hoy.getDate(),hoy.getMonth()+1,
        hoy.getFullYear()) : eval(campo).value;
	cerrarCalendario(wCalendario);
	var wCalendario = window.open("Fecha.htm?formato="+formatoFecha+
      "&control="+campo+"&annioInicial="+annioInicial+"&annioFinal="+
      annioFinal+"&fechaInicial="+fechaIni+"&titulo="
      +escape("Seleccionar fecha"),"fecha","status=no");
}
// Formatea la fecha con el formato que se ha definido
function fechaFormateada(Dia,Mes,Annio) {
	sDia = "0"+Dia;
	sDia = sDia.substring(sDia.length-2);
	sMes = "0"+Mes;
	sMes = sMes.substring(sMes.length-2);
	sAnnio = Annio.toString();
	if (formatoFecha=="DD/MM/YYYY") {
		return sDia + "/" + sMes + "/" + sAnnio;
	}
	else if (formatoFecha=="MM/DD/YYYY") {
		return sMes + "/" + sDia + "/" + sAnnio;
	}
}
// Establece la fecha inicial del calendario
function fechaMostrada(fechaInicial) {
	var sDia;
	var sMes;
	var sAnnio;
	if (formatoFecha=="DD/MM/YYYY") {
		sDia = fechaInicial.split("/")[0];
		sMes = fechaInicial.split("/")[1];
		sAnnio = fechaInicial.split("/")[2];
	}
	else if (formatoFecha=="MM/DD/YYYY") {
		sDia = fechaInicial.split("/")[1];
		sMes = fechaInicial.split("/")[0];
		sAnnio = fechaInicial.split("/")[2];
	}
	var fecha = new Date();
	fecha.setFullYear(sAnnio);
	fecha.setMonth(sMes-1);
	fecha.setDate(sDia);
	fecha.setMonth(sMes-1);
	return fecha;
}
// Cierra la ventana del Calendario
function cerrarCalendario(ventCalen) {
	if (ventCalen && !ventCalen.closed)
		ventCalen.close();
}
