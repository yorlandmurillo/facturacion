<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>SIGESLIB CATALOGO DE LIBROS</title>

  <script type="text/javascript" language="JavaScript" src="js/prototype.js"></script>
  <script type="text/javascript" language="JavaScript" src="js/table_orderer.js"></script>
  <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="css/tableorderer.css" type="text/css" media="screen" />

</head>
<body>

<div id="main">
<div id="maincontainer">
<h1>Inventario</h1>
<div id="container8"></div>
<?
include "creararraylibros.php";
$valor=10;
?>
<script>
var opciones =<? if ($valor==0){echo '<td id="opciones" class="opciones">Modificar</td>';}else{echo '<td id="opciones" class="opciones">Modificar</td>';}?>

var habilitado= <? if ($valor==0){echo 'disabled="disabled=true"';}else{echo 'disabled=""';}?>

var libros = <?php print(json_encode(arreglo_libros())); ?>

new TableOrderer('container8',{data : libros,search : 'top',paginate : 'bottom', pageCount:10});
</script></div>
</div>
</div>
</body>
</html>

