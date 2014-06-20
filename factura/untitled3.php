<?

$ci=array ('ci'=>explode(",",$_POST['ci']),'nom'=>explode(",",$_POST['nom']),'apel'=>explode(",",$_POST['apel']));


$element=(sizeof($_POST['ci'])+sizeof($_POST['nom'])+sizeof($_POST['apel']));

for($i=0;$i<$element;$i++){

echo "C.I.: ".$ci['ci'][$i]."  | "." "."Nombre: ".$ci['nom'][$i]." "."  | "." "."Apellido: ".$ci['apel'][$i]." "."<br>";

}



?>