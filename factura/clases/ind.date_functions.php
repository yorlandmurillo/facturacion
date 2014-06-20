<?php
// array com a data atual
$arr_day = getdate();

// definição de variaveis
$sec = $arr_day["minutes"];
$mi = $arr_day["seconds"];
$hour = $arr_day["hour"];
$day = $arr_day["mday"];
$day_week = $arr_day["wday"];
$day_week_ext = $days_week[$arr_day["wday"]];
$month = $arr_day["mon"];
$month_ext = $month_year[$mes];
$year = $arr_day["year"];

// array com os meses do ano
$month_year = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");

// array com dias da semana
$days_week = array(0 => "Domingo", 1 => "Segunda-feira", 2 => "Ter&ccedil;a-feira", 3 => "Quarta-feira", 4 => "Quinta-feira", 5 => "Sexta-feira", 6 => "S&aacute;bado");


function mformat($zeros,$num)
{
  for($i = 1; $i <= $zeros - strlen($num); $i++) $num = "0".$num;
  return $num;
}


function mno_zero($num)
{
  if (substr($num,0,1) == "0")
    return substr($num,1,1);
  else
    return $num;
}


function mdia_semana($formato,$data)
{
  $d = date("w",mktime (0,0,0,mno_zero(substr($data,5,2)),mno_zero(substr($data,8,2)),substr($data,0,4)));
  $arr_d = $GLOBALS["days_week"];
  if ($formato == "t") return $arr_d[$d]; else return $d-1;
}


function mdata_atual($sep)
{
  return $GLOBALS["year"].$sep.mformat(2,$GLOBALS["month"]).mformat(2,$sep.$GLOBALS["day"]);
}


function mdata_ext($data)
{
  $arr_m = $GLOBALS["month_year"];
  return mdia_semana("t",$data).", ".substr($data,8,2)." de ".$arr_m[date("n",mktime (0,0,0,mno_zero(substr($data,5,2)),mno_zero(substr($data,8,2)),substr($data,0,4)))]." de ".substr($data,0,4);
}


function mdata_br($data,$sep)
{
  if($data != "0000-00-00" && $data != "0000-00-00 00:00:00" && $data != "") return substr($data,8,2).$sep.substr($data,5,2).$sep.substr($data,0,4);
}


function mdata_mysql($data)
{
  if($data != "00/00/0000" && $data != "") return substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
}
?>