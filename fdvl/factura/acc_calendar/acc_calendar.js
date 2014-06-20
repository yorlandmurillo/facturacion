/* acc-calendar v 1.0 /  Calendario accesible en javascript.
   Copyright (C) 2007  Jorge Rumoroso
   http://www.niquelao.net

   This library is free software; you can redistribute it and/or
   modify it under the terms of the GNU Lesser General Public
   License as published by the Free Software Foundation; either
   version 2.1 of the License, or (at your option) any later version.
   
   This library is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
   Lesser General Public License for more details.
   
   You should have received a copy of the GNU Lesser General Public
   License along with this library; if not, write to the Free Software
   Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
*/
var formato = 'd/mm/y';
var preposiciones = {
	es : new Array('de','para'),
	en : new Array('of','to')
	};
var Meses = {
	es : new Array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'),
	en : new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')
	};
var encabezados = {
	es : new Array('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'),
	en : new Array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
	};
var texto_enlace = {
	es : 'Calendario',
	en : 'Calendar'
	};
var title_enlace = {
	es : 'Desplegar para seleccionar la Fecha',
	en : 'Unfold to select date to'
	};
var go_month = {
	es : 'Acceder al mes',
	en : 'Go to month'
	};
var go_year = {
	es : 'Acceder al año',
	en : 'Go to year'
	};
var summary = {
	es : 'Calendario con los días disponibles correspondientes al mes de',
	en : 'Calendar with the available days of'
	};
var close_text = {
	es : 'Cerrar el calendario',
	en : 'Close calendar'
	};
var tit_dia = {
	es : 'Seleccionar esta fecha',
	en : 'Select this date'
	};
var label_mes = {
	es : 'Mes',
	en : 'Month'
	};
var label_year = {
	es : 'Año',
	en : 'Year'
	};
var niquelao = {
	es : 'Acerca de',
	en : 'About'
	};
var lang = document.getElementsByTagName('html')[0].getAttribute('lang');
if(!lang) 
	var lang = document.getElementsByTagName('html')[0].getAttribute('xml:lang');
if(!lang)
	lang = 'es';
else
	lang = lang.toLowerCase();
if(lang.substr(0,2) != 'es' && lang.substr(0,2) != 'en')
	var lang = 'es';
var DiasPorMes = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
var tope;
var destino;
var tope_mes = true;
var todact;
var Hoy_real = new Date();
var labels = document.getElementsByTagName('label');
var inputs = document.getElementsByTagName('input');
var nav = navigator.userAgent.toLowerCase(); 
this.nav = nav;
var destino;
var comp = 1900;
if(nav.indexOf("msie") != -1) {
	comp = 0;
}
document.onkeydown = teclado;
var contador = 1;
function teclado(event){
	var key;
    if (!event)
      var event = window.event;
    if (window.event)
       key = window.event.keyCode;
    else if (event.which)
       key = event.which;
    else
       return true;
    if (!key)
       return true;
    if (key == 27 || key == 32){
		cierra(destino)
		return false;	  
	}
    return true;
}
function insertAfter(previo,nodo) {
	var parent_previo = previo.parentNode;
	if (previo.nextSibling) {
		parent_previo.insertBefore(nodo, previo.nextSibling)
	} else {
		parent_previo.appendChild(nodo);
	}
}
function cierra(destino) {
	if(document.getElementById('bio_calendar')){
		document.getElementById('bio_calendar').parentNode.removeChild(document.getElementById('bio_calendar'));
		if(destino)
			document.getElementById(destino).focus()
	}
}
function padre(element,tag) {
	if (element == null)
		return null;
	else if (element.nodeType == 1 && element.tagName.toLowerCase() == tag.toLowerCase())
		return (element)
	else
		return padre(element.parentNode,tag);
}
function zindex(element) {
	if (element == null)
		return null;
	else if (element.nodeType == 1 && element.tagName.toLowerCase() != 'body')
		element.parentNode.style.zIndex = 1000 + contador;
	else
		return zindex(element.parentNode)
}
function obten_texto(element) {
	if (element.nodeType == 3) return element.nodeValue;
	var texto = new Array(),i=0;
	while(element.childNodes[i]) {
		texto[texto.length] = obten_texto(element.childNodes[i]);
		i++;
	}
	return texto.join("");
}
function carga_links() {
	var scripts = document.getElementsByTagName('script');
	for (var i = 0; i < scripts.length; i++) {
		if(scripts[i].src.indexOf('acc_calendar.js') > -1) {
			var ruta = scripts[i].src.replace('.js','.css');
			var link_style = document.createElement('link');
			link_style.setAttribute('rel','stylesheet');
			link_style.setAttribute('type','text/css');
			link_style.setAttribute('href',ruta);
			insertAfter(scripts[i],link_style)
		}
	}
	for (var i = 0; i < labels.length; i++) {
		var asociado = labels[i].htmlFor;
		var elasociado = document.getElementById(asociado);
		if(elasociado.type == 'text' && elasociado.className.indexOf('fecha') != -1) {
			var dest = elasociado.id;
			var enl_cal = document.createElement('a');
			enl_cal.className = 'enl_cal';
			enl_cal.id = 'cal_' + dest;
			var rango = 0;
			if(elasociado.className.indexOf('rang') != -1) {
				var jar = elasociado.className.split('rang');
				var fin = jar[1].indexOf(' ');
				if (fin != -1)
					rango = jar[1].substr(0,fin);
				else
					rango = jar[1];
			}
			if(elasociado.className.indexOf('todnact') != -1)
				todact = false
			else
				todact = true;
			enl_cal.setAttribute('href','#');
			enl_cal.onclick = function() {
				rango = rango * 1;
				calendario(todact,Hoy_real.getMonth(),"","", this.id.replace('cal_',''), rango);
				return false;
			}
			
			enl_cal.setAttribute('title',title_enlace[lang.substr(0,2)] + ' ' + obten_texto(labels[i]));
			if(padre(elasociado,'label'))
				insertAfter(padre(elasociado,'label'),enl_cal);
			else
				insertAfter(elasociado,enl_cal);
			if(!enl_cal.parentNode.style.position)
				enl_cal.parentNode.style.position = 'relative';
			enl_cal.style.marginLeft = '-20px';
			enl_cal.style.position = 'absolute';
			enl_cal.style.left = elasociado.offsetLeft + elasociado.offsetWidth + 'px'
			enl_cal.style.top = elasociado.offsetTop +'px'
			enl_cal.style.height = elasociado.offsetHeight + 'px'
			enl_cal.style.backgroundPosition = '0 ' + ((elasociado.offsetHeight - 15)/2) + 'px ! important';
			var enl_cal_text = document.createTextNode(texto_enlace[lang.substr(0,2)]);
			enl_cal.appendChild(enl_cal_text);
		}
	}
}
function calendario(todact,mes,year,nuevo,id,rango,dia) {
	if(id != destino) cierra()
	destino = id;
	var Hoy = new Date();
	var calendar = document.getElementById('bio_calendar')
	if (calendar){
		var all_el = new Array('nav_mes','label_Meses');
		for(i = 0; i < all_el.length ; i++) {
			if(document.getElementById(all_el[i]))
				calendar.removeChild(document.getElementById(all_el[i]));
		}
		if(rango > 0) {
			calendar.removeChild(document.getElementById('nav_year'));
			calendar.removeChild(document.getElementById('label_year'));
		}
		document.getElementById('calendario').removeChild(document.getElementById('caption'));
		document.getElementById('calendario').removeChild(document.getElementById('tbody'));
	}else{
		calendar = document.createElement('div');
	}
	if(document.getElementById(id).className.indexOf('post') != -1) {
		tope = 2;
	}else if(document.getElementById(id).className.indexOf('prev') != -1) {
		tope = 1;
	} else{
		tope = 0;
	}
	calendar.id = 'bio_calendar';
	if(!(mes+1)){
		mes = Hoy.getMonth();
	}
	if(!year){
		year = Hoy.getYear()
	}
	Hoy.setMonth(mes);
	Hoy.setYear(year+comp);
	Anyo = Hoy.getYear()+comp;
	if (((Anyo % 4 == 0) && (Anyo % 100 != 0)) || (Anyo % 400 == 0)){
    	DiasPorMes[1] = 29;
	}else{
    	DiasPorMes[1] = 28;
	}
	NDias =DiasPorMes[Hoy.getMonth()];
	PrimerDia = Hoy;
	PrimerDia.setDate(1);
	if(lang == 'en-us')
		PrimerDia.setDate(2);
	Comienzo = PrimerDia.getDay();
	if(Comienzo == 0) {
		Comienzo = 7;
	}
	var total = Comienzo+NDias;
	var celda = new Array();
	for(var i = 0; i < Comienzo-1; i++){
		celda[i] = '';
	}
	for(var i = Comienzo-1; i < total-1; i++){
		celda[i] = i-Comienzo+2;
	}
	var resto = 7 - (i % 7);
	if(resto < 7){
		var white = celda.length+resto;
		for(var cont = celda.length; cont < white; cont++){
			celda[cont] = '';
		}
	}
	var semanas = (celda.length/7)-1;
	var calendario_tbody_tr_td = new Array();
	for(var i = 0; i < celda.length; i++){
		calendario_tbody_tr_td[i] = document.createElement('td');
		var calendario_tbody_tr_td_text = document.createTextNode(celda[i]);
		var enl_dia = document.createElement('a');
		enl_dia.id = 'dat_' + celda[i];
		enl_dia.setAttribute('href','#');
		enl_dia.onclick = function() {
			send_date(todact,this.childNodes[0].nodeValue + '/' + (Hoy.getMonth()+1) + '/' + (Hoy.getYear()+comp),id , rango)
			return false;
		}
		enl_dia.setAttribute('title',tit_dia[lang.substr(0,2)]);
		if(celda[i] == Hoy_real.getDate() && mes == Hoy_real.getMonth() && year == Hoy_real.getYear()) {
			var strong = document.createElement('strong');
			calendario_tbody_tr_td[i].className = 'hoy';
			if(todact) {
				enl_dia.appendChild(calendario_tbody_tr_td_text);
				strong.appendChild(enl_dia);
				calendario_tbody_tr_td[i].className = 'act';
			}else{
				strong.appendChild(calendario_tbody_tr_td_text);
				calendario_tbody_tr_td[i].className = 'inact';
			}
			calendario_tbody_tr_td[i].appendChild(strong);
		}else if(celda[i] > 0){
			if((((celda[i] < Hoy_real.getDate()) && (mes == Hoy_real.getMonth() && year == Hoy_real.getYear())) || (mes < Hoy_real.getMonth() && year == Hoy_real.getYear())  || (year < Hoy_real.getYear())) && celda[i] >0){
				if( tope != 2){
					enl_dia.appendChild(calendario_tbody_tr_td_text);
					calendario_tbody_tr_td[i].appendChild(enl_dia);
					calendario_tbody_tr_td[i].className = 'act';
				}else{
					calendario_tbody_tr_td[i].appendChild(calendario_tbody_tr_td_text);
					calendario_tbody_tr_td[i].className = 'inact';
				}
			} else {
				if( tope != 1){
					enl_dia.appendChild(calendario_tbody_tr_td_text);
					calendario_tbody_tr_td[i].appendChild(enl_dia);
					calendario_tbody_tr_td[i].className = 'act';
				}else{
					calendario_tbody_tr_td[i].appendChild(calendario_tbody_tr_td_text);
					calendario_tbody_tr_td[i].className = 'inact';
				}
			}
		} else {
			calendario_tbody_tr_td[i].appendChild(calendario_tbody_tr_td_text);
		}
		if(celda[i] == dia)
			calendario_tbody_tr_td[i].className = 'elect ' + calendario_tbody_tr_td[i].className;
	}
	if(!document.getElementById('calendario')) {
		var calendario = document.createElement('table');
		calendario.id = 'calendario';
	}else{
		calendario = document.getElementById('calendario')
	}
	calendario.setAttribute('summary',summary[lang.substr(0,2)] + ' ' + Meses[lang.substr(0,2)][Hoy.getMonth()] + ' ' + preposiciones[lang.substr(0,2)][0] + ' ' + Anyo);
	var calendario_caption = document.createElement('caption');
	calendario_caption.id = 'caption';
	var texto_caption = document.createTextNode( Meses[lang.substr(0,2)][Hoy.getMonth()] + ' ' + (year+comp));
	calendario_caption.appendChild(texto_caption);
	calendario.appendChild(calendario_caption);
	if(lang != 'en-us' && !document.getElementById('calendario')) {
		var nor_day = document.createElement('colgroup');
		nor_day.setAttribute('span','5');
		var week_day = document.createElement('colgroup');
		week_day.className = 'end';
		week_day.setAttribute('span','2');
		calendario.appendChild(nor_day);
		calendario.appendChild(week_day);
	}
	var calendario_thead = document.createElement('thead');
	var calendario_thead_tr = document.createElement('tr');
	for (var i = 0; i < encabezados[lang.substr(0,2)].length; i++) {
		var calendario_thead_tr_th = document.createElement('th');
		calendario_thead_tr_th.setAttribute('scope','col');
		var calendario_thead_tr_th_abbr = document.createElement('abbr');
		var n = i;
		if(lang == 'en-us') {
			n = i - 1;
			if(n == -1)
				n = 6;
			else if(n+1 == encabezados.length)
				n = 0;
		}
		calendario_thead_tr_th_abbr.setAttribute('title',encabezados[lang.substr(0,2)][n]);
		var calendario_thead_tr_th_abbr_text = document.createTextNode(encabezados[lang.substr(0,2)][n].substr(0,3));
		calendario_thead_tr_th_abbr.appendChild(calendario_thead_tr_th_abbr_text);
		calendario_thead_tr_th.appendChild(calendario_thead_tr_th_abbr);
		calendario_thead_tr.appendChild(calendario_thead_tr_th);
	}
	calendario_thead.appendChild(calendario_thead_tr);
	if(!document.getElementById('calendario'))
		calendario.appendChild(calendario_thead);
	var calendario_tbody = document.createElement('tbody');
	calendario_tbody.id = 'tbody';
	for(var i = 0; i <= semanas; i++){
		var calendario_tbody_tr = document.createElement('tr');
		for(a = 0; a < 7; a++){
			if(calendario_tbody_tr_td[(i*7)+a]) {
				if(a == 5) 
					calendario_tbody_tr_td[(i*7)+a].className = 'sat ' + calendario_tbody_tr_td[(i*7)+a].className;
				else if (a == 6)
					calendario_tbody_tr_td[(i*7)+a].className = 'sun ' + calendario_tbody_tr_td[(i*7)+a].className;
				calendario_tbody_tr.appendChild(calendario_tbody_tr_td[(i*7)+a]);
			}
		}
		calendario_tbody.appendChild(calendario_tbody_tr);
	}
	calendario.appendChild(calendario_tbody);
	if(!document.getElementById('calendario')){
		insertAfter(document.getElementById('cal_' + id),calendar);
		zindex(calendar);
		contador = contador + 1;
		calendar.style.top = (document.getElementById(id).offsetHeight + document.getElementById(id).offsetTop) + 'px';
		calendar.style.left = (document.getElementById('cal_' + id).offsetLeft-2*(calendar.offsetWidth/3)) + 'px';
	}
	crea_nav_year_select(todact,mes,year,id,rango);
	crea_nav_mes_select(todact,mes,year,id,rango);
	calendar.appendChild(calendario);
	crea_nav_mes(todact,mes,year,id,rango);
	crea_nav_year(todact,mes,year,id,rango);
	if(!document.getElementById('close_it')) {
		var close_it = document.createElement('div');
		close_it.id = 'close_it';
		var close_it_enl = document.createElement('a');
		var close_it_enl_text = document.createTextNode(close_text[lang.substr(0,2)]);
		close_it_enl.setAttribute('href','#');
		close_it_enl.onclick = function() {
			cierra(id)
			return false;
		}
		close_it_enl.appendChild(close_it_enl_text);
		close_it.appendChild(close_it_enl);
		calendar.appendChild(close_it);
	}
	if(!document.getElementById('niquelao')) {
		var niquelao = document.createElement('img');
		niquelao.id = 'niquelao';
		niquelao.src = 'acc_calendar/niquelao.png';
		niquelao.setAttribute('alt',niquelao[lang.substr(0,2)]);
		niquelao.onclick = function() {
			alert("acc_calendar_v.1 by http://www.niquelao.net")
		}
//		calendar.appendChild(niquelao);
	}
	if(document.getElementById('nav_year_select')) {
		if(rango == 0)
			document.getElementById('nav_mes_select').focus();
		else
			document.getElementById('nav_year_select').focus();
	}
}
function crea_nav_mes(todact,mes,year,id,rango){
	var nav_mes = document.createElement('ul');
	nav_mes.id = 'nav_mes';
	var nav_mes_li = document.createElement('li');
	if(mes-1 == -1) {
		var prev_mes = 11;
		var prev_year = year-1;
	}else{
		var prev_mes = mes-1;
		var prev_year = year;
	}
	var nav_mes_li_text = document.createTextNode(Meses[lang.substr(0,2)][prev_mes]);
	var nav_mes_li_a = document.createElement('a');
	nav_mes_li_a.setAttribute('href','#');
	nav_mes_li_a.onclick = function() {
		calendario(todact,prev_mes,prev_year,"",id,rango)
		return false;
	}
	nav_mes_li_a.appendChild(nav_mes_li_text);
	nav_mes_li_a.setAttribute('title',go_month[lang.substr(0,2)]);
	nav_mes_li.appendChild(nav_mes_li_a);
	var nav_mes_post_li = document.createElement('li');
	nav_mes_li.className = 'post';
	if(mes == 11) {
		var next_mes = 0;
		var next_year = year+1;
	}else{
		var next_mes = mes+1;
		var next_year = year;
	}
	var nav_mes_post_li_text = document.createTextNode(Meses[lang.substr(0,2)][next_mes]);
	var nav_mes_post_li_a = document.createElement('a');
	nav_mes_post_li_a.setAttribute('href','#');
	nav_mes_post_li_a.onclick = function() {
		calendario(todact,next_mes,next_year,"",id,rango)
		return false;
	}

	nav_mes_post_li_a.appendChild(nav_mes_post_li_text);
	nav_mes_post_li_a.setAttribute('title',go_month[lang.substr(0,2)]);
	nav_mes_post_li.appendChild(nav_mes_post_li_a);
	switch ( tope ) { 
		case 0:
			if(prev_year >= (Hoy_real.getYear()-rango))
				nav_mes.appendChild(nav_mes_li);
			if(next_year <= (Hoy_real.getYear()+rango))
				nav_mes.appendChild(nav_mes_post_li);
			break
		case 1:
			if(prev_year >= (Hoy_real.getYear()-rango))
				nav_mes.appendChild(nav_mes_li);
			if(next_year <= (Hoy_real.getYear()+1) && next_year <= (Hoy_real.getYear()+rango)){
				if((tope_mes && next_mes <= Hoy_real.getMonth()) || next_year < Hoy_real.getYear()){
					nav_mes.appendChild(nav_mes_post_li);
				}
			}
			break
		case 2:
			if(prev_year >= Hoy_real.getYear() && prev_year >= (Hoy_real.getYear()-rango)){
				if((tope_mes && prev_mes >= Hoy_real.getMonth()) || next_year > Hoy_real.getYear()){
					nav_mes.appendChild(nav_mes_li);
				}
			}
			if(next_year <= (Hoy_real.getYear()+rango))
				nav_mes.appendChild(nav_mes_post_li);
			break
	}
	document.getElementById('bio_calendar').appendChild(nav_mes);
}
function crea_nav_mes_select(todact,mes,year,id,rango){
	var nav_mes_select = document.createElement('select');
	nav_mes_select.id = 'nav_mes_select';
	var nav_mes_select_label = document.createElement('label');
	nav_mes_select_label.htmlFor =  'nav_mes_select';
	nav_mes_select_label.id =  'label_Meses';
	var nav_mes_select_label_text = document.createTextNode(label_mes[lang.substr(0,2)]);
	if(year == Hoy_real.getYear()) {
		switch ( tope ) {
			case 0:
				var from = 0;
				var to = Meses[lang.substr(0,2)].length;
				break
			case 1:
				var from = 0;
				var to = Hoy_real.getMonth();
				break
			case 2:
				var from = Hoy_real.getMonth();
				var to = Meses[lang.substr(0,2)].length;
				break
		}
	}else{
		var from = 0;
		var to = Meses[lang.substr(0,2)].length;
	}
	for(i = from; i < to; i++){
		var nav_mes_select_opt = document.createElement('option');
		if(i == mes){
			nav_mes_select_opt.setAttribute('selected','selected');
		}
		nav_mes_select_opt.innerHTML = Meses[lang.substr(0,2)][i];
		nav_mes_select.appendChild(nav_mes_select_opt)
	}
	nav_mes_select.onchange = function() {
		switch ( tope ) {
			case 0:
				calendario(todact,nav_mes_select.selectedIndex ,year,'',id,rango)
				break
			case 1:
				if((tope_mes && year == Hoy_real.getYear() && nav_mes_select.selectedIndex < Hoy_real.getMonth()) || year < Hoy_real.getYear()){
					calendario(todact,nav_mes_select.selectedIndex ,year,'',id,rango)
				}else{
					nav_mes_select.selectedIndex = mes
				}
				break
			case 2:
				if((tope_mes && year == Hoy_real.getYear() && nav_mes_select.selectedIndex >= Hoy_real.getMonth()) || year > Hoy_real.getYear()){
					calendario(todact,nav_mes_select.selectedIndex ,year,'',id,rango)
				}else{
					nav_mes_select.selectedIndex = mes
				}
				break
		}
		document.getElementById('nav_mes_select').focus();
	}
	nav_mes_select_label.appendChild(nav_mes_select_label_text);
	nav_mes_select_label.appendChild(nav_mes_select);
	if(to-from)
		document.getElementById('bio_calendar').appendChild(nav_mes_select_label);
}
function crea_nav_year(todact,mes,year,id,rango){
	var nav_year = document.createElement('ul');
	nav_year.id = 'nav_year';
	var nav_year_li = document.createElement('li');
	nav_year_li.className = 'post';
	var nav_year_li_text = document.createTextNode(year+comp-1);
	var nav_year_li_a = document.createElement('a');
	nav_year_li_a.setAttribute('title',go_year[lang.substr(0,2)]);
	var nav_year_post_li = document.createElement('li');
	var nav_year_post_li_text = document.createTextNode(year+comp+1);
	var nav_year_post_li_a = document.createElement('a');
	nav_year_post_li_a.setAttribute('title',go_year[lang.substr(0,2)]);
	if(!mes) mes = '""';
	nav_year_li_a.appendChild(nav_year_li_text);
	nav_year_li.appendChild(nav_year_li_a);
	nav_year_post_li_a.appendChild(nav_year_post_li_text);
	nav_year_post_li.appendChild(nav_year_post_li_a);
	switch ( tope ) { 
		case 0:
			nav_year_li_a.setAttribute('href','#');
			nav_year_li_a.onclick = function() {
				calendario(todact,mes,(year-1),"",id,rango)
				return false;
			}
			nav_year_post_li_a.setAttribute('href','#');
			nav_year_post_li_a.onclick = function() {
				calendario(todact,mes,(year+1),"",id,rango)
				return false;
			}
			if((year-1) >= (Hoy_real.getYear() - rango))
				nav_year.appendChild(nav_year_li);
			if(year+1 <= Hoy_real.getYear() + rango)
				nav_year.appendChild(nav_year_post_li);
			break
		case 1:
			nav_year_li_a.setAttribute('href','#');
			nav_year_li_a.onclick = function() {
				calendario(todact,mes,(year-1),"",id,rango)
				return false;
			}
			if(tope_mes && mes <= Hoy_real.getMonth()){
				nav_year_post_li_a.setAttribute('href','#');
				nav_year_post_li_a.onclick = function() {
					calendario(todact,mes,(year+1),"",id,rango)
					return false;
				}
			}else{
				nav_year_post_li_a.setAttribute('href','#');
				nav_year_post_li_a.onclick = function() {
					calendario(todact,Hoy_real.getMonth(),(year+1),"",id,rango)
					return false;
				}
			}
			if((year-1) >= (Hoy_real.getYear() - rango))
				nav_year.appendChild(nav_year_li);
			if(year+1 <= Hoy_real.getYear())
				nav_year.appendChild(nav_year_post_li);
			break
		case 2:
			if(tope_mes && mes >= Hoy_real.getMonth()){
				nav_year_li_a.setAttribute('href','#');
				nav_year_li_a.onclick = function() {
					calendario(todact,mes,(year-1),"",id,rango)
					return false;
				}
			}else{
				nav_year_li_a.setAttribute('href','#');
				nav_year_li_a.onclick = function() {
					calendario(todact,Hoy_real.getMonth(),(year-1),"",id,rango)
					return false;
				}
			}
			nav_year_post_li_a.setAttribute('href','#');
			nav_year_post_li_a.onclick = function() {
				calendario(todact,mes,(year+1),"",id,rango)
				return false;
			}
			if(year-1 >= Hoy_real.getYear())
				nav_year.appendChild(nav_year_li);
			if((year+1) <= (Hoy_real.getYear() + rango))
				nav_year.appendChild(nav_year_post_li);
			break
	}
	if(rango > 0) 
		document.getElementById('bio_calendar').appendChild(nav_year);
}
function crea_nav_year_select(todact,mes,year,id,rango){
	var nav_year_select = document.createElement('select');
	nav_year_select.id = 'nav_year_select';
	var nav_year_select_label = document.createElement('label');
	nav_year_select_label.htmlFor =  'nav_year_select';
	nav_year_select_label.id =  'label_year';
	var nav_year_select_label_text = document.createTextNode(label_year[lang.substr(0,2)]);
	var tope_pre = Hoy_real.getYear() - rango;
	var tope_post = Hoy_real.getYear() + rango;
	if ( tope ==  1)
		tope_post = Hoy_real.getYear();
	else if(tope == 2)
		tope_pre = Hoy_real.getYear();
	tope_pre = tope_pre + comp;
	tope_post = tope_post + comp;
	for(i = tope_pre; i<=tope_post; i++){
		var nav_year_select_opt = document.createElement('option');
		if(i == (year + comp) ){
			nav_year_select_opt.setAttribute('selected','selected');
		}
		nav_year_select_opt.innerHTML = i;
		nav_year_select.appendChild(nav_year_select_opt)
	}
	nav_year_select.onchange = function() {
		switch ( tope ) { 
			case 0:
				calendario(todact,mes ,nav_year_select.options[nav_year_select.selectedIndex].text-comp,"",id,rango)
				break
			case 1:
				if(tope_mes && mes <= Hoy_real.getMonth()){
					calendario(todact,mes ,nav_year_select.options[nav_year_select.selectedIndex].text-comp,"",id,rango)
				}else{
					calendario(todact,Hoy_real.getMonth() ,nav_year_select.options[nav_year_select.selectedIndex].text-comp,"",id,rango)
				}
				break
			case 2:
				if(tope_mes && mes >= Hoy_real.getMonth()){
					calendario(todact,mes ,nav_year_select.options[nav_year_select.selectedIndex].text-comp,"",id,rango)
				}else{
					calendario(todact,Hoy_real.getMonth() ,nav_year_select.options[nav_year_select.selectedIndex].text-comp,"",id,rango)
				}
				break
		}
	}
	nav_year_select_label.appendChild(nav_year_select_label_text);
	nav_year_select_label.appendChild(nav_year_select);
	if(rango > 0)
		document.getElementById('bio_calendar').appendChild(nav_year_select_label);
}
function send_date(todact,date,destino,rango) {
		var fecha = date.split('/');
		var day =fecha[0];
		var month =fecha[1];
		var year =fecha[2];
		var long_dia = formato.lastIndexOf('d')- formato.indexOf('d') +1;
		var long_mes = formato.lastIndexOf('m')- formato.indexOf('m') +1;
		var long_year = formato.lastIndexOf('y')- formato.indexOf('y') +1;
		var fecha_format = formato;
		if(fecha[0].length == 1 && long_dia >= 2)
			fecha[0] = '0' + fecha[0]
		fecha_format = fecha_format.replace('d',fecha[0]);
		for(i = 0; i <= long_dia; i++) 
			fecha_format = fecha_format.replace('d','');
		if(fecha[1].length == 1 && long_mes >= 2)
			fecha[1] = '0' + fecha[1]
		fecha_format = fecha_format.replace('m',fecha[1]);
		for(i = 0; i <= long_mes; i++) 
			fecha_format = fecha_format.replace('m','');
		fecha_format = fecha_format.replace('y',fecha[2]);
		for(i = 0; i <= long_year; i++) 
			fecha_format = fecha_format.replace('y','');
		document.getElementById(destino).value = fecha_format;
		document.getElementById('cal_' + destino).onclick = function() {
			calendario(todact,(fecha[1]-1),(fecha[2]-comp),"",destino ,rango,fecha[0])
			return false;
		}
		cierra(destino);
}
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}
addLoadEvent(carga_links);