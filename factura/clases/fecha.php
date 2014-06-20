<?php
class fecha {
var $year;
var $month;
var $day;
var $hour;
var $minute;
var $second;
    
public function getyear(){
return $this->year=date(Y);
}
public function getmonth(){
return $this->year=date(m);
}
public function getday(){
return $this->year=date(d);
}

public function gethour(){
return $this->year=date(H)-1;
}
public function getminute(){
return $this->year=date(i);
}
public function getsecond(){
return $this->year=date(s);
}
	
   function fechaa() {
		echo "Fecha: ".$this->getday()."/".$this->getmonth()."/".$this->getyear();
   }


	function datedif($fecha1,$fecha2)
    {
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$año1)=split("/",$fecha1);

      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$año1)=split("-",$fecha1);

      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$año2)=split("/",$fecha2);

      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
        list($dia2,$mes2,$año2)=split("-",$fecha2);

        $dif = mktime(0,0,0,$mes1,$dia1,$año1) - mktime(0,0,0,$mes2,$dia2,$año2);
	    $ndias=floor($dif/(24*60*60));
    	return($ndias);
	}

}
?>