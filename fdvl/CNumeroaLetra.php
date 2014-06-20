<?php
class CNumeroaLetra{
	private $numero=0;
	private $genero=1;
	private $moneda="Bolivares";
	private $prefijo="(**";
	private $sufijo="**)";
	private $mayusculas=1;
	//textos
	private $textos_posibles= array(
	0 => array ('UNA ','DOS ','TRES ','CUATRO ','CINCO ','SEIS ','SIETE ','OCHO ','NUEVE ','UN '),
	1 => array ('ONCE ','DOCE ','TRECE ','CATORCE ','QUINCE ','DIECISEIS ','DIECISIETE ','DIECIOCHO ','DIECINUEVE ',''),
	2 => array ('DIEZ ','VEINTE ','TREINTA ','CUARENTA ','CINCUENTA ','SESENTA ','SETENTA ','OCHENTA ','NOVENTA ','VEINTI'),
	3 => array ('CIEN ','DOSCIENTAS ','TRESCIENTAS ','CUATROCIENTAS ','QUINIENTAS ','SEISCIENTAS ','SETECIENTAS ','OCHOCIENTAS ','NOVECIENTAS ','CIENTO '),
        4 => array ('CIEN ','DOSCIENTOS ','TRESCIENTOS ','CUATROCIENTOS ','QUINIENTOS ','SEISCIENTOS ','SETECIENTOS ','OCHOCIENTOS ','NOVECIENTOS ','CIENTO '),
	5 => array ('MIL ','MILLON ','MILLONES ','CERO ','Y ','UNO ','DOS ','CON ','','')
	);
	private $aTexto;
	function __construct(){
		for($i=0; $i<6;$i++)
   			for($j=0;$j<10;$j++)
				$this->aTexto[$i][$j]=$this->textos_posibles[$i][$j];
	}

	function setNumero($num){
		$this->numero=(double)$num;
	}

	function setPrefijo($pre){
		$this->prefijo=$pre;
	}

	function setSufijo($sub){
		$this->sufijo=$sub;
	}

	function setMoneda($mon){
		$this->moneda=$mon;
	}

	function setGenero($gen){
		$this->genero=(int)$gen;
	}

	function setMayusculas($may){
		$this->mayusculas=(int)$may;
	}

	function letra(){
		if($this->genero==1){ //masculino
			$this->aTexto[0][0]=$this->textos_posibles[5][5];
			for($j=0;$j<9;$j++)
            	$this->aTexto[3][$j]= $this->aTexto[4][$j];

		}else{//femenino
			$this->aTexto[0][0]=$this->textos_posibles[0][0];
			for($j=0;$j<9;$j++)
            	$this->aTexto[3][$j]= $this->aTexto[3][$j];
		}

		$cnumero=sprintf("%015.2f",$this->numero);
		$texto="";
		if(strlen($cnumero)>15){
			$texto="Excede tama�o permitido";
		}else{
			$hay_significativo=false;
			for ($pos=0; $pos<12; $pos++){
				// Control existencia D�gito significativo 
   				if (!($hay_significativo)&&(substr($cnumero,$pos,1) == '0')) ;
   				else $hay_dignificativo = true;

   				// Detectar Tipo de D�gito 
   				switch($pos % 3) {
   					case 0: $texto.=$this->letraCentena($pos,$cnumero); break;
   					case 1: $texto.=$this->letraDecena($pos,$cnumero); break;
   					case 2: $texto.=$this->letraUnidad($pos,$cnumero); break;
				}
			}
   			// Detectar caso 0 
   			if ($texto == '') $texto = $this->aTexto[5][3];
			if($this->mayusculas){//mayusculas
				$texto=strtoupper($this->prefijo.$texto." ".$this->moneda." ".substr($cnumero,-2)."/100 ".$this->sufijo);	
			}else{//minusculas
				$texto=strtolower($this->prefijo.$texto." ".$this->moneda." ".substr($cnumero,-2)."/100 ".$this->sufijo);	
			}
		}
		return $texto;

	}

	public function __toString() {
		return $this->letra();
	}

	//traducir letra a unidad
	private function letraUnidad($pos,$cnumero){
		$unidad_texto="";
   		if( !((substr($cnumero,$pos,1) == '0') || 
               (substr($cnumero,$pos - 1,1) == '1') ||
               ((substr($cnumero, $pos - 2, 3) == '001') &&  (($pos == 2) || ($pos == 8)) ) 
             )
		  ){ 
			if((substr($cnumero,$pos,1) == '1') && ($pos <= 6)){
   				$unidad_texto.=$this->aTexto[0][9]; 
			}else{
				$unidad_texto.=$this->aTexto[0][substr($cnumero,$pos,1) - 1];
			}
		}
   		if((($pos == 2) || ($pos == 8)) && 
		   (substr($cnumero, $pos - 2, 3) != '000')){//miles
			if(substr($cnumero,$pos,1)=='1'){
				if($pos <= 6){
					$unidad_texto=substr($unidad_texto,0,-1)." ";
				}else{
					$unidad_texto=substr($unidad_texto,0,-2)." ";
				}
				$unidad_texto.= $this->aTexto[5][0]; 
			}else{
				$unidad_texto.=$this->aTexto[5][0]; 
			}
		}
        if($pos == 5 && substr($cnumero, 0, 6) != '000000'){
			if(substr($cnumero, 0, 6) == '000001'){//millones
			  $unidad_texto.=$this->aTexto[5][1];
			}else{
				$unidad_texto.=$this->aTexto[5][2];
			}
		}
		return $unidad_texto;
	}
	//traducir digito a decena
	private function letraDecena($pos,$cnumero){
		$decena_texto="";
   		if (substr($cnumero,$pos,1) == '0'){
			return;
		}else if(substr($cnumero,$pos + 1,1) == '0'){ 
   			$decena_texto.=$this->aTexto[2][substr($cnumero,$pos,1)-1];
		}else if(substr($cnumero,$pos,1) == '1'){ 
   			$decena_texto.=$this->aTexto[1][substr($cnumero,$pos+ 1,1)- 1];
		}else if(substr($cnumero,$pos,1) == '2'){
   			$decena_texto.=$this->aTexto[2][9];
		}else{
   			$decena_texto.=$this->aTexto[2][substr($cnumero,$pos,1)- 1] . $this->aTexto[5][4];
		}
		return $decena_texto;
   	}
	//traducir digito centena
   	private function letraCentena($pos,$cnumero){
		$centena_texto="";
   		if (substr($cnumero,$pos,1) == '0') return;
   		$pos2 = 3;
		if((substr($cnumero,$pos,1) == '1') && (substr($cnumero,$pos+ 1, 2) != '00')){
   			$centena_texto.=$this->aTexto[$pos2][9];
   		}else{
   			$centena_texto.=$this->aTexto[$pos2][substr($cnumero,$pos,1) - 1];
		}
		return $centena_texto;
	}

}