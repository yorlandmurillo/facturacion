<html><head>
<title>Agregar fila de campos DINAMICOS</title>

<script type="text/javascript">
function adicionarFila(){
var cont = document.getElementById("cont");
var filas = document.getElementById("filas");
cont.setAttribute("value", parseInt(cont.value,0)+1);
var tabla = document.getElementById("contenido").tBodies[0];
var fila = document.createElement("TR");
fila.setAttribute("align","center");

var celda1 = document.createElement("TD");
var codigo = document.createElement("INPUT");
codigo.setAttribute("type","text");
codigo.setAttribute("size","8");
codigo.setAttribute("maxlength","20");
codigo.setAttribute("name","codigo" + cont.value);
codigo.setAttribute("value",cont.value);
celda1.appendChild(codigo);

var celda2 = document.createElement("TD");
var sel = document.createElement("SELECT");
sel.setAttribute("size","1");
sel.setAttribute("name","sel" + cont.value);
opcioncur = document.createElement("OPTION");
opcioncur.innerHTML = '';
opcioncur.value = '';
sel.appendChild(opcioncur);

opcion1 = document.createElement("OPTION");
opcion1.innerHTML = "este Select depende de lo que";
opcion1.value = "este Select depende de lo que";
sel.appendChild(opcion1);

opcion2 = document.createElement("OPTION");
opcion2.innerHTML = "se ponga en el anterior campo";
opcion2.value = "se ponga en el anterior campo";
sel.appendChild(opcion2);

celda2.appendChild(sel);


var celda6 = document.createElement('TD');
var boton = document.createElement('INPUT');
boton.setAttribute('type','button');
boton.setAttribute('value','borrar');
boton.onclick=function(){borrarFila(this);}
celda6.appendChild(boton);

fila.appendChild(celda1);
fila.appendChild(celda2);
fila.appendChild(celda6);

tabla.appendChild(fila);
}
function borrarFila(button){
var filaborrada=button.parentNode.parentNode;
var fila = button.parentNode.parentNode;
var tabla = document.getElementById('contenido').getElementsByTagName('tbody')[0];
tabla.removeChild(fila);
alert(button);
}

</script>
</head>
<body >
<Form name="detalle" action="./tablas.jsp" method="get">
<input name="cont" type="text" id="cont" value="0" >
<input name="filas" type="text" id="filas" value="" >

<select name="firstCombo" onChange="detalle.submit();">
<option>-- Select One --</option>
<option>country</option>
<option>state</option>
</select>
<br>


<br>

<table align=center width=20% cellpadding=0 cellspacing=0 id="contenido" border="1">
<tr align="center">
<td height="64">codigo</td>
<td>C</td>
<td> </td>
</tr>
</table>
<table align=center width=20% cellpadding=0 cellspacing=0 border="1">
<tr>
<td> </td>
</tr>
<tr align="center">
<td align="CENTER"><input name="enviar" type="submit" id="enviar" value="enviar" onClick="filas.value=cont.value, cont.value=0">
<input name="nueva_fila" type="button" id="nueva_fila" value="nueva fila" onClick="adicionarFila()"></td>
</tr>
</table>
</form>
</body>
</html>