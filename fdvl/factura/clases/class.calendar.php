<?php
//
// By Ricardo Costa - ricardo@icorp.com.br - 2002
// Classe para exibição de calendário
//
//  calendar
//    +---- calendar()
//    +---- show()
//
//

class calendar {

   var $content;   // Conteudo HTML formatado
   var $page;   // Página para link
   var $month_name;   // Nome do mês
   var $year_bgcolor = "CCCCCC"; // Cor de fundo do ano
   var $month_bgcolor = "CCCCCC"; // Cor de fundo do mês
   var $days_bgcolor = "8D9ABA"; // Cor de fundo dos dias da semana
   var $day_color = "E9EBF1"; // Cor de fundo dos dias
   var $day_today_color = "FF9999"; // Cor de fundo de hoje
   var $font_color = "4C5B7D"; // Cor da fonte
   var $bg_color = "E9EBF1"; // Cor de fundo
   var $event_bgcolor = "FFCC99"; // Cor de fundo dos compromissos
   var $events = ""; // Array de eventos


   
   # Inicializar variáveis ################################################################### Revisão 09/09/2002 #
   function calendar() {

      $this->page = $GLOBALS["PHP_SELF"];

      if ($GLOBALS["nyear"]) $GLOBALS["year"] = $GLOBALS["nyear"]; else $GLOBALS["nyear"] = $GLOBALS["year"];
      if ($GLOBALS["nmonth"]) $GLOBALS["month"] = $GLOBALS["nmonth"]; else $GLOBALS["nmonth"] = $GLOBALS["month"];
      if ($GLOBALS["nday"]) $GLOBALS["day"] = $GLOBALS["nday"]; else $GLOBALS["nday"] = $GLOBALS["day"];

      if ($GLOBALS["nmonth"] == 0) {
         $GLOBALS["nyear"] --;
         $GLOBALS["nmonth"] = 12;
      }
      elseif ($GLOBALS["nmonth"] == 13) {
         $GLOBALS["nyear"] ++;
         $GLOBALS["nmonth"] = 1;
      }

      $this->month_name = $GLOBALS["month_year"];
      $this->month_name = $this->month_name[$GLOBALS["nmonth"]];
   }
   # Inicializar variáveis ################################################################### Revisão 09/09/2002 #



   # Exibir Calendário ####################################################################### Revisão 16/09/2002 #
   function show($year = 1, $month = 1, $today = 1) {

      $this->content = "<style type='text/css'>
                        <!--
                        .calendar_font {  font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #".$this->font_color."; text-decoration: none}
                        .calendar_font:hover {  font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #".$this->font_color."; text-decoration: underline}
                         -->
                        </style>
                        <table width='140' border='0' cellspacing='0' cellpadding='0' class='calendar_font'>";

      if ($year == 1) {
	    $this->content .= "<tr align='center'>
                           <td width='20' bgcolor='#".$this->year_bgcolor."' height='14'><b><a href='".$this->page."?nmonth=".$GLOBALS["nmonth"]."&nyear=".($GLOBALS["nyear"] - 1)."&nday=".$GLOBALS["nday"]."' class='calendar_font'>&#139;&#139;</a></b></td>
                           <td colspan='5' bgcolor='#".$this->year_bgcolor."' height='14'><b>".$GLOBALS["nyear"]."</b></td>
                           <td width='20' bgcolor='#".$this->year_bgcolor."' height='14'><b><a href='".$this->page."?nmonth=".$GLOBALS["nmonth"]."&nyear=".($GLOBALS["nyear"] + 1)."&nday=".$GLOBALS["nday"]."' class='calendar_font'>&#155;&#155;</a></b></td>
                           </tr>";
      } 
    
	  if ($month == 1) {
	    $this->content .= "<tr align='center'>
                           <td width='20' bgcolor='#".$this->month_bgcolor."' height='18'><b><a href='".$this->page."?nmonth=".($GLOBALS["nmonth"] - 1)."&nyear=".$GLOBALS["nyear"]."&nday=".$GLOBALS["nday"]."' class='calendar_font'>&#139;</a></b></td>
                           <td colspan='5' bgcolor='#".$this->month_bgcolor."' height='18'><b>".$this->month_name."</b></td>
                           <td width='20' bgcolor='#".$this->month_bgcolor."' height='18'><b><a href='".$this->page."?nmonth=".($GLOBALS["nmonth"] + 1)."&nyear=".$GLOBALS["nyear"]."&nday=".$GLOBALS["nday"]."' class='calendar_font'>&#155;</a></b></td>
                           </tr>
						   <tr align='center'>
                           <td width='20' bgcolor='#000000' height='1'></td>
                           <td colspan='5' bgcolor='#000000' height='1'></td>
                           <td width='20' bgcolor='#000000' height='1'></td>
                           </tr>";
	  }

 
      $this->content .= "<tr align='center' bgcolor='#".$this->days_bgcolor."'>
                         <td width='20' height='14'><b>D</b></td>
                         <td width='20' height='14'><b>S</b></td>
                         <td width='20' height='14'><b>T</b></td>
                         <td width='20' height='14'><b>Q</b></td>
                         <td width='20' height='14'><b>Q</b></td>
                         <td width='20' height='14'><b>S</b></td>
                         <td width='20' height='14'><b>S</b></td>
                         </tr>";

      $cont_day = 1;
      for( $l = 1; $l <= 6; $l++) {

         $this->content .= "<tr>";

         for($c = 0; $c <= 6 ; $c++) {
            $xday = date("w",mktime (0,0,0, $GLOBALS["nmonth"],$cont_day, $GLOBALS["nyear"]));
 
		   if (in_array($cont_day, $this->events) && $cont_day != $GLOBALS["nday"])
		      $bg = $this->event_bgcolor;
           else { 
              if ($cont_day != $GLOBALS["nday"])
			     $bg = $this->day_color;
   			  else 
			      $bg = $this->day_today_color;
		   }
			
            if (checkdate($GLOBALS["nmonth"], $cont_day, $GLOBALS["nyear"]) & $xday == $c) {
               $this->content .= "<td align='center' width='20' bgcolor='#".$bg."'><a href='".$this->page."?nmonth=".$GLOBALS["nmonth"]."&nyear=".$GLOBALS["nyear"]."&nday=".$cont_day."' class='calendar_font'>".$cont_day."</a></td>";
               $cont_day++;
            }
            else {
               $this->content .= "<td align='center' width='20' bgcolor='#".$this->bg_color."'>&nbsp;</td>";
            }
	     }
    
         $this->content .= "</tr>";
         if (!checkdate($GLOBALS["nmonth"], $cont_day, $GLOBALS["nyear"])) break;
      }
   
	  if ($today == 1) {
	    $this->content .= "</table>
                           <table width='140' border='0' cellspacing='0' cellpadding='0' class='calendar_font'>
                           <tr><td align='center' bgcolor=#".$this->year_bgcolor."><b><a href='".$this->page."?nmonth=".date("n")."&nyear=".date("Y")."&nday=".date("d")."' class='calendar_font'>Hoje</a></b></td></tr>
                           <tr height='10'><td></td></tr></table>";
      }
	  
	  $this->content .= "</table>";
     
      print($this->content);
   }
   # Exibir Calendário ####################################################################### Revisão 16/09/2002 #



} # Final da Classe
?>