<? 
class reconversion{

	function __reconversion(){

	}

		function conversion($valor){
		return $valor/1000;
		}
	
		function redondeado($numero,$decimales){
			$factor = pow(10, $decimales);
   			return (round($numero*$factor)/$factor); 
		}
		
		function redondear_dos_decimal($valor) {
			$monto=$valor/1000;
  			$float_redondeado=round($monto * 100) / 100;
		   	return $float_redondeado;
		}  
}
?>