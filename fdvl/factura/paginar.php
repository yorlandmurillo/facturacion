<?php
#
# 17 de Febrero de 2005
# - Ejemplo practico: Como paginar un array
# By Yosolito, www.ohycu.net
#

$paginar = array("aki","ponemos","lo","que","sea","o","un","array","cualquiera","sin","importar","lo","que","tenga"); //el array a paginar
$mostrar = 5; //numero de elementos por pagina
$cuantos = count($paginar); //para saber cuantos elementos tiene el array
$paginar = array_reverse($paginar); //para que muestre los nuevos primeros. Totalmente opcional
$paginas = $cuantos / $mostrar; //numero de paginas

if (!isset($mostrar) or empty($mostrar) or !is_int($mostrar)) {
    $mostrar = 5; //por si se te olvid?clarar $mostrar o no es entero le damos de valor 5
}
if (empty($_GET["pagina"])) { //si no hay pagina...
    $desde = 0; //principio de la primera pagina
    $hasta = $desde + $mostrar; //fin de la primera pagina
}
if (!empty($_GET["pagina"])) { //si estamos en una pagina distinta de la primera...
    $desde = (int)$_GET["pagina"]; //principio de la pagina X
    if ($desde + $mostrar < $cuantos) { //si principio + 10 no es mayor a la cantidad de elementos
        $hasta = $desde + $mostrar; //fin de la pagina X
}else{
    $hasta = $desde + ($cuantos - $desde); //por si $principio + 10 es superior al numero de elementos
}
}


for ($i=$desde; $i<$hasta; $i++) {
    echo $paginar[$i].'<br/>'; //mostramos los elementos de la pagina en la que estamos. Aqui que cada uno lo haga como buenamente pueda. xD
}

for ($p=0; $p<=$paginas; $p++) {
$dexde = $p * $mostrar; //para marcar el inicio de la siguiente pagina
echo '<a href="paginar.php?pagina='.$dexde.'">'.$p.'</a> - '; //mostramos la lista de paginas. Que cada uno las muestre como quiera
}
?>
