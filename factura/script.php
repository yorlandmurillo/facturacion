<html>
<head>
<script type="text/javascript">
var xmlDoc;
var navegador;
function cargaDocumento() {
// code for IE
if (window.ActiveXObject){
xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
navegador = "IE";
consola("IE")
}
// code for Mozilla, Firefox, Opera, etc.
else if (document.implementation && document.implementation.createDocument) {
xmlDoc=document.implementation.createDocument("","",null);
navegador = "FI";
consola("Mozilla, Firefox u Opera")
// Error
} else {
consola("Este navegador no soporta DOM");
}
consola(xmlDoc);
}
function consola(txt){
var con = document.getElementById("consola");
con.innerHTML += txt + "<br> ";
}
</script>
</head>
<body onLoad="cargaDocumento()">
<div id="consola"></div>
</body>
</html>
