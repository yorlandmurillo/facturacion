<?php
function multiplo($limt,$num1){
$salir=0;

while($salir!=1){

for($j=1;$j<10;$j++){
$mresult=$num1%$j;

if($mresult==$limt){ 
$salir=1;
return true;

}else{
$salir=0;
return false;

}
}

}

}

$mult=30;
$num=120;


if(multiplo($mult,$num)==true){
echo "es multiplo";

}else echo "no  es multiplo";

?>