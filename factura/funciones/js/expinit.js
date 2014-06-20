function init() {
	mensaje();
	shortcut.add("esc", function() {
		window.location.href="../expoventas.php";
	});
	shortcut.add("F10", function() {
		printPage();
	});
	
}
window.onload=init;


