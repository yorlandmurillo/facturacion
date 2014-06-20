<html>
<head>
<script language="javascript">
function recarga(){
setTimeout('carga()',50000);
}
function carga(){
alert("ejemplo");
recarga();
}
</script>
</head>
<body onLoad="recarga()">

<form name="enviador" method="post" action="http://201.249.236.118/sigal/clases/recibe.php" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="0">
Archivo: <input type="file" name="archivo">
<input type="submit">

</form>
</body>
</html>