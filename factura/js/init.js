function markCalled(id) {
	alert(id);
}
function init() {
	
	shortcut.add("esc", function() {
		esc();
	});
	shortcut.add("F9", function() {
		ventas("consultas/clientes.php","clientes");
	});
	shortcut.add("F10", function() {
		ventas("consultas/facturas.php","facturas");
	});
	shortcut.add("CTRL+F2", function() {
		consulta("consultas/inventario.php","libros");
	});

	recarga();
	ip();

}
window.onload=init;

var miPopup
function ventas(ventana,nombre){
	miPopup = window.open(ventana,nombre,'width=900,height=800,top='+((screen.height/2)-(280.5))+',left='+((screen.width/2)-(470.5))+',toolbar=no,scrollbars=yes,resizable=no,menubar=no,status=no,directories=no,location=no')
	miPopup.focus()
}
function ventana(ventana,nombre,alto,ancho){
	miPopup = window.open(ventana,nombre,'width='+ancho+',height='+alto+',top='+((screen.height/2)-(280.5))+',left='+((screen.width/2)-(470.5))+',toolbar=no,scrollbars=yes,resizable=no,menubar=no,status=no,directories=no,location=no')
	miPopup.focus()
}
function consulta(ventana,nombre){
	miPopup = window.open(ventana,nombre,'width=900,height=800,top='+((screen.height/2)-(280.5))+',left='+((screen.width/2)-(470.5))+',toolbar=no,scrollbars=yes,resizable=no,menubar=no,status=no,directories=no,location=no')
	miPopup.focus()
}
function clave(ventana,nombre){
	miPopup = window.open(ventana,nombre,'width=300,height=200,top='+((screen.height/2)-(180.5))+',left='+((screen.width/2)-(100.5))+',toolbar=no,scrollbars=yes,resizable=no,menubar=no,status=no,directories=no,location=no')
	miPopup.focus()
}