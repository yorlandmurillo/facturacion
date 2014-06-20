function init() {
	mensaje();
	shortcut.add("esc", function() {
		window.location.href="../additemfactura.php";
	});
	shortcut.add("F10", function() {
		printPage();
	});
	
}
window.onload=init;


