<?php
class BAR_GRAPH {

	var $type = 'hBar';                       
	var $values;                              

	var $labels;                              
	var $labelColor = 'black';                
	var $labelBGColor = '#C0E0FF';            
	var $labelBorder = '2px groove white';    
	var $labelFont = 'Arial, Helvetica';      
	var $labelSize = 12;                      

	var $barWidth = 20;                       
	var $barLength = 1.0;                     
	var $barColor;                            
	var $barBGColor;                          
	var $barBorder = '2px outset white';      
	var $barLevelColor;                       

	var $showValues = 0;                      
	var $absValuesColor;                      
	var $absValuesBGColor;                    
	var $absValuesBorder;                     
	var $absValuesFont = 'Arial, Helvetica';  
	var $absValuesSize = 12;                  
	var $percValuesColor = 'black';           
	var $percValuesFont = 'Arial, Helvetica'; 
	var $percValuesSize = 12;                 
	var $percValuesDecimals = 0;              

	var $charts = 1;                          

	// hBar/vBar only:
	var $legend;                              
	var $legendColor = 'black';               
	var $legendBGColor = '#F0F0F0';           
	var $legendBorder = '2px groove white';   
	var $legendFont = 'Arial, Helvetica';     
	var $legendSize = 12;                     

	var $debug = false;

	var $colors = array('#336699', '#FF0000', '#00E000', '#A0A0FF', '#FFA0A0', '#00A000');

	var $err_type = 'ERROR: Type must be "hBar", "vBar" or "pBar"';

	var $clsBAR;
	var $clsBARBG;
	var $clsLABEL;
	var $clsLABELBG;
	var $clsLEGEND;
	var $clsLEGENDBG;
	var $clsABSVALUES;
	var $clsPERCVALUES;

	//----------------------------------------------------------------------------------------------------
	// 
	//----------------------------------------------------------------------------------------------------
	function BAR_GRAPH($type = '') {
	  global $graphstyle_nr;

	  if($type) $this->type = $type;
	  if(!$graphstyle_nr) $graphstyle_nr = 1;
	  $this->clsBAR = 'clsBAR' . $graphstyle_nr;
	  $this->clsBARBG = 'clsBARBG' . $graphstyle_nr;
	  $this->clsLABEL = 'clsLABEL' . $graphstyle_nr;
	  $this->clsLABELBG = 'clsLABELBG' . $graphstyle_nr;
	  $this->clsLEGEND = 'clsLEGEND' . $graphstyle_nr;
	  $this->clsLEGENDBG = 'clsLEGENDBG' . $graphstyle_nr;
	  $this->clsABSVALUES = 'clsABSVALUES' . $graphstyle_nr;
	  $this->clsPERCVALUES = 'clsPERCVALUES' . $graphstyle_nr;
	  $graphstyle_nr++;
	}

	function set_style() {
	  $style = '<style> .' . $this->clsBAR . ' { ';
	  if($this->barBorder) $style .= 'border: ' . $this->barBorder . '; ';
	  $style .= '} .' . $this->clsBARBG . ' { ';
	  if($this->barBGColor) $style .= 'background-color: ' . $this->barBGColor . '; ';
	  $style .= '} .' . $this->clsLABEL . ' { ';
	  if($this->labelColor) $style .= 'color: ' . $this->labelColor . '; ';
	  if($this->labelBGColor) $style .= 'background-color: ' . $this->labelBGColor . '; ';
	  if($this->labelBorder) $style .= 'border: ' . $this->labelBorder . '; ';
	  if($this->labelFont) $style .= 'font-family: ' . $this->labelFont . '; ';
	  if($this->labelSize) $style .= 'font-size: ' . $this->labelSize . 'px; ';
	  $style .= '} .' . $this->clsLABELBG . ' { ';
	  if($this->labelBGColor) $style .= 'background-color: ' . $this->labelBGColor . '; ';
	  $style .= '} .' . $this->clsLEGEND . ' { ';
	  if($this->legendColor) $style .= 'color: ' . $this->legendColor . '; ';
	  if($this->legendFont) $style .= 'font-family: ' . $this->legendFont . '; ';
	  if($this->legendSize) $style .= 'font-size: ' . $this->legendSize . 'px; ';
	  $style .= '} .' . $this->clsLEGENDBG . ' { ';
	  if($this->legendBGColor) $style .= 'background-color: ' . $this->legendBGColor . '; ';
	  if($this->legendBorder) $style .= 'border: ' . $this->legendBorder . '; ';
	  $style .= '} .' . $this->clsABSVALUES . ' { ';
	  if($this->absValuesColor) $style .= 'color: ' . $this->absValuesColor . '; ';
	  if($this->absValuesBGColor) $style .= 'background-color: ' . $this->absValuesBGColor . '; ';
	  if($this->absValuesBorder) $style .= 'border: ' . $this->absValuesBorder . '; ';
	  if($this->absValuesFont) $style .= 'font-family: ' . $this->absValuesFont . '; ';
	  if($this->absValuesSize) $style .= 'font-size: ' . $this->absValuesSize . 'px; ';
	  $style .= '} .' . $this->clsPERCVALUES . ' { ';
	  if($this->percValuesColor) $style .= 'color: ' . $this->percValuesColor . '; ';
	  if($this->percValuesFont) $style .= 'font-family: ' . $this->percValuesFont . '; ';
	  if($this->percValuesSize) $style .= 'font-size: ' . $this->percValuesSize . 'px; ';
	  $style .= '} </style>';
	  return $style;
	}

	function level_color($value, $color) {
	  if($this->barLevelColor) {
		if(($this->barLevelColor[0] > 0 && $value >= $this->barLevelColor[0]) ||
		   ($this->barLevelColor[0] < 0 && $value <= $this->barLevelColor[0])) {
		  $color = $this->barLevelColor[1];
		}
	  }
	  return $color;
	}

	function draw_bar($width, $height, $color) {
	  $bar = '<table border=0 cellspacing=0 cellpadding=0><tr>';
	  $bar .= '<td class="' . $this->clsBAR . '" bgcolor=' . $color . '>';
	  $bar .= '<table border=0 cellspacing=0 cellpadding=0><tr>';
	  $bar .= '<td width=' . $width . ' height=' . $height . '></td>';
	  $bar .= '</tr></table>';
	  $bar .= '</td></tr></table>';
	  return $bar;
	}

	function show_value($val, $max_dec, $sum = 0, $align = '') {
	  $val = $max_dec ? sprintf('%.' . $max_dec . 'f', $val) : $val;
	  if($sum) $sum = $max_dec ? sprintf('%.' . $max_dec . 'f', $sum) : $sum;
	  $value = '<td class="' . $this->clsABSVALUES . '"';
	  if($align) $value .= ' align=' . $align;
	  $value .= ' nowrap>';
	  $value .= '&nbsp;' . $val . ($sum ? ' / ' . $sum : '') . '&nbsp;</td>';
	  return $value;
	}

	function build_legend($barColors) {
	  $legend = '<table border=0 cellspacing=0 cellpadding=0><tr>';
	  $legend .= '<td class="' . $this->clsLEGENDBG . '">';
	  $legend .= '<table border=0 cellspacing=4 cellpadding=0>';
	  $l = (is_array($this->legend)) ? $this->legend : explode(',', $this->legend);

	  for($i = 0; $i < count($barColors); $i++) {
		$legend .= '<tr>';
		$legend .= '<td class="' . $this->clsBAR . '" bgcolor=' . $barColors[$i] . ' nowrap>&nbsp;&nbsp;&nbsp;</td>';
		$legend .= '<td class="' . $this->clsLEGEND . '" nowrap>' . trim($l[$i]) . '</td>';
		$legend .= '</tr>';
	  }
	  $legend .= '</table></td></tr></table>';
	  return $legend;
	}

	function create() {
	  global $graphstyle_nr;
	  error_reporting(E_WARNING);

	  $this->type = strtolower($this->type);
	  $d = (is_array($this->values)) ? $this->values : explode(',', $this->values);
	  if(is_array($this->labels)) $r = $this->labels;
	  else $r = (strlen($this->labels) > 1) ? explode(',', $this->labels) : array();
	  if($this->barColor) $drf = (is_array($this->barColor)) ? $this->barColor : explode(',', $this->barColor);
	  else $drf = array();
	  $val = $bc = array();
	  if($this->barLength < 0.1) $this->barLength = 0.1;
	  else if($this->barLength > 2.9) $this->barLength = 2.9;
	  $bars = (count($d) > count($r)) ? count($d) : count($r);

	  if(!$this->absValuesColor) $this->absValuesColor = $this->labelColor;
	  if(!$this->absValuesBGColor) $this->absValuesBGColor = $this->labelBGColor;
	  if(!$this->absValuesBorder) $this->absValuesBorder = $this->labelBorder;

	  if($this->type == 'pbar') {
		if(!$this->barBGColor) $this->barBGColor = $this->labelBGColor;
		if($this->labelBGColor == $this->barBGColor) {
		  $this->labelBGColor = '';
		  $this->labelBorder = '';
		}
	  }

	  if($this->legend && $this->type != 'pbar')
		$graph .= '<table border=0 cellspacing=0 cellpadding=0><tr valign=top><td>';

	  if($this->charts > 1) {
		$divide = ceil($bars / $this->charts);
		$graph .= '<table border=0 cellspacing=0 cellpadding=6><tr valign=top><td>';
	  }
	  else $divide = 0;

	  for($i = $sum = $max = $max_neg = $max_dec = $ccnt = $lcnt = $chart = 0; $i < $bars; $i++) {
		if($divide && $i && !($i % $divide)) {
		  $lcnt = 0;
		  $chart++;
		}
		$drw = explode(';', $d[$i]);

		for($j = $dec = 0; $j < count($drw); $j++) {
		  $val[$chart][$lcnt][$j] = $v = (float)trim($drw[$j]);

		  if($v > $max) $max = $v;
		  else if($v < $max_neg) $max_neg = $v;

		  if($v < 0) $v *= -1;
		  $sum += $v;

		  if(strstr($v, '.')) {
			$dec = strlen(substr($v, strrpos($v, '.') + 1));
			if($dec > $max_dec) $max_dec = $dec;
		  }

		  if(!$bc[$j]) {
			if($ccnt >= count($this->colors)) $ccnt = 0;
			$bc[$j] = (!$drf[$j] || strlen($drf[$j]) < 3) ? $this->colors[$ccnt++] : trim($drf[$j]);
		  }
		}
		$lcnt++;
	  }

	  $border = (int)$this->barBorder;
	  $mPerc = $sum ? round($max * 100 / $sum) : 0;
	  if($this->type == 'pbar') $mul = 2;
	  else $mul = $mPerc ? 100 / $mPerc : 1;
	  $mul *= $this->barLength;

	  if($this->showValues < 2) {
		if($this->type == 'hbar')
		  $valSpace = ($this->percValuesDecimals * ($this->percValuesSize / 1.7)) + ($this->percValuesSize * 2.2);
		else $valSpace = $this->percValuesSize * 1.2;
	  }
	  else $valSpace = $this->percValuesSize;
	  $spacer = $maxSize = round($mPerc * $mul) + $valSpace + ($border * 2);

	  if($max_neg) {
		$mPerc_neg = $sum ? round(-$max_neg * 100 / $sum) : 0;
		$spacer_neg = round($mPerc_neg * $mul) + $valSpace + ($border * 2);
		$maxSize += $spacer_neg;
	  }

	  for($chart = $lcnt = 0; $chart < count($val); $chart++) {
		$graph .= '<table border=0 cellspacing=2 cellpadding=0>';

		if($this->type == 'hbar') {
		  for($i = 0; $i < count($val[$chart]); $i++, $lcnt++) {
			$label = ($lcnt < count($r)) ? trim($r[$lcnt]) : $lcnt+1;
			$rowspan = count($val[$chart][$i]);
			$graph .= '<tr><td class="' . $this->clsLABEL . '"' . (($rowspan > 1) ? ' rowspan=' . $rowspan : '') . ' align=center>';
			$graph .= '&nbsp;' . $label . '&nbsp;</td>';

			for($j = 0; $j < count($val[$chart][$i]); $j++) {
			  $percent = $sum ? $val[$chart][$i][$j] * 100 / $sum : 0;
			  $bColor = $this->level_color($val[$chart][$i][$j], $bc[$j]);

			  if($this->showValues == 1 || $this->showValues == 2)
				$graph .= $this->show_value($val[$chart][$i][$j], $max_dec, 0, 'right');

			  $graph .= '<td class="' . $this->clsBARBG . '" height=100% width=' . $maxSize . '>';
			  $graph .= '<table border=0 cellspacing=0 cellpadding=0 height=100%><tr>';

			  if($percent < 0) {
				$percent *= -1;
				$graph .= '<td class="' . $this->clsLABELBG . '" height=' . $this->barWidth . ' width=' . round(($mPerc_neg - $percent) * $mul + $valSpace) . ' align=right nowrap>';
				if($this->showValues < 2) $graph .= '<span class="' . $this->clsPERCVALUES . '">' . number_format($percent, $this->percValuesDecimals) . '%</span>';
				$graph .= '&nbsp;</td><td class="' . $this->clsLABELBG . '">';
				$graph .= $this->draw_bar(round($percent * $mul), $this->barWidth, $bColor);
				$graph .= '</td><td width=' . $spacer . '></td>';
			  }
			  else {
				if($max_neg) {
				  $graph .= '<td class="' . $this->clsLABELBG . '" width=' . $spacer_neg . '>';
				  $graph .= '<table border=0 cellspacing=0 cellpadding=0><tr><td></td></tr></table></td>';
				}
				if($percent) {
				  $graph .= '<td>';
				  $graph .= $this->draw_bar(round($percent * $mul), $this->barWidth, $bColor);
				  $graph .= '</td>';
				}
				else $graph .= '<td height=' . ($this->barWidth + ($border * 2)) . '></td>';
				$graph .= '<td class="' . $this->clsPERCVALUES . '" width=' . round(($mPerc - $percent) * $mul + $valSpace) . ' nowrap>';
				if($this->showValues < 2) $graph .= '&nbsp;' . number_format($percent, $this->percValuesDecimals) . '%';
				$graph .= '&nbsp;</td>';
			  }
			  $graph .= '</tr></table></td></tr>';
			  if($j < count($val[$chart][$i]) - 1) $graph .= '<tr>';
			}
		  }
		}
		else if($this->type == 'vbar') {
		  $graph .= '<tr align=center valign=bottom>';
		  for($i = 0; $i < count($val[$chart]); $i++) {

			for($j = 0; $j < count($val[$chart][$i]); $j++) {
			  $percent = $sum ? $val[$chart][$i][$j] * 100 / $sum : 0;
			  $bColor = $this->level_color($val[$chart][$i][$j], $bc[$j]);

			  $graph .= '<td class="' . $this->clsBARBG . '">';
			  $graph .= '<table border=0 cellspacing=0 cellpadding=0 width=100%><tr align=center>';

			  if($percent < 0) {
				$percent *= -1;
				$graph .= '<td height=' . $spacer . '></td></tr><tr align=center valign=top><td class="' . $this->clsLABELBG . '">';
				$graph .= $this->draw_bar($this->barWidth, round($percent * $mul), $bColor);
				$graph .= '</td></tr><tr align=center valign=top>';
				$graph .= '<td class="' . $this->clsLABELBG . '" height=' . round(($mPerc_neg - $percent) * $mul + $valSpace) . ' nowrap>';
				$graph .= ($this->showValues < 2) ? '<span class="' . $this->clsPERCVALUES . '">' . number_format($percent, $this->percValuesDecimals) . '%</span>' : '&nbsp;';
				$graph .= '</td>';
			  }
			  else {
				$graph .= '<td class="' . $this->clsPERCVALUES . '" valign=bottom height=' . round(($mPerc - $percent) * $mul + $valSpace) . ' nowrap>';
				if($this->showValues < 2) $graph .= number_format($percent, $this->percValuesDecimals) . '%';
				$graph .= '</td>';
				if($percent) {
				  $graph .= '</tr><tr align=center valign=bottom><td>';
				  $graph .= $this->draw_bar($this->barWidth, round($percent * $mul), $bColor);
				  $graph .= '</td>';
				}
				else $graph .= '</tr><tr><td width=' . ($this->barWidth + ($border * 2)) . '></td>';
				if($max_neg) {
				  $graph .= '</tr><tr><td class="' . $this->clsLABELBG . '" height=' . $spacer_neg . '>';
				  $graph .= '<table border=0 cellspacing=0 cellpadding=0><tr><td></td></tr></table></td>';
				}
			  }
			  $graph .= '</tr></table></td>';
			}
		  }
		  if($this->showValues == 1 || $this->showValues == 2) {
			$graph .= '</tr><tr align=center>';
			for($i = 0; $i < count($val[$chart]); $i++) {
			  for($j = 0; $j < count($val[$chart][$i]); $j++) {
				$graph .= $this->show_value($val[$chart][$i][$j], $max_dec);
			  }
			}
		  }
		  $graph .= '</tr><tr align=center>';
		  for($i = 0; $i < count($val[$chart]); $i++, $lcnt++) {
			$label = ($lcnt < count($r)) ? trim($r[$lcnt]) : $lcnt+1;
			$colspan = count($val[$chart][$i]);
			$graph .= '<td class="' . $this->clsLABEL . '"' . (($colspan > 1) ? ' colspan=' . $colspan : '') . '>';
			$graph .= '&nbsp;' . $label . '&nbsp;</td>';
		  }
		  $graph .= '</tr>';
		}
		else if($this->type == 'pbar') {
		  for($i = 0; $i < count($val[$chart]); $i++, $lcnt++) {
			$label = ($lcnt < count($r)) ? trim($r[$lcnt]) : '';
			$graph .= '<tr>';

			if($label) {
			  $graph .= '<td class="' . $this->clsLABEL . '" align=right>';
			  $graph .= '&nbsp;' . $label . '&nbsp;</td>';
			}
			$sum = (float)$val[$chart][$i][1];
			$percent = $sum ? $val[$chart][$i][0] * 100 / $sum : 0;

			if($this->showValues == 1 || $this->showValues == 2)
			  $graph .= $this->show_value($val[$chart][$i][0], $max_dec, $sum, 'right');

			$graph .= '<td class="' . $this->clsBARBG . '">';

			if($percent) {
			  $this->barColor = $drf[$i] ? trim($drf[$i]) : $this->colors[0];
			  $bColor = $this->level_color($val[$chart][$i][0], $this->barColor);
			  $graph .= '<table border=0 cellspacing=0 cellpadding=0><tr><td>';
			  $graph .= $this->draw_bar(round($percent * $mul), $this->barWidth, $bColor);
			  $graph .= '</td><td width=' . round((100 - $percent) * $mul) . '></td>';
			  $graph .= '</tr></table>';
			}
			$graph .= '</td>';
			if($this->showValues < 2) $graph .= '<td class="' . $this->clsPERCVALUES . '" nowrap>&nbsp;' . number_format($percent, $this->percValuesDecimals) . '%</td>';
			$graph .= '</tr>';
		  }
		}
		else $graph .= '<tr><td>' . $this->err_type . '</td></tr>';

		$graph .= '</table>';

		if($chart < $this->charts - 1 && count($val[$chart+1])) {
		  $graph .= '</td>';
		  if($this->type == 'vbar') $graph .= '</tr><tr valign=top>';
		  $graph .= '<td>';
		}
	  }

	  if($this->charts > 1) $graph .= '</td></tr></table>';

	  if($this->legend && $this->type != 'pbar') {
		$graph .= '</td><td width=10>&nbsp;</td><td>';
		$graph .= $this->build_legend($bc);
		$graph .= '</td></tr></table>';
	  }

	  if($this->debug) {
		$graph .= "<br>sum=$sum max=$max max_neg=$max_neg mPerc=$mPerc ";
		$graph .= "mPerc_neg=$mPerc_neg mul=$mul valSpace=$valSpace";
	  }

	  $graph .= $this->set_style();

	  return $graph;
	}
}
?>