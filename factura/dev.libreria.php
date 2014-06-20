<HTML>
<HEAD>
<TITLE>Devoluci&oacute;n de Libros</TITLE>
<script type="text/javascript"  language="javascript"  src="ajax.js"></script>
<SCRIPT language="javascript">
var counter = 0
var cantlib = 0
var flag = 0
var counter2 = 1
function addRow(id){

if(counter>0 && verificarcampos(counter-1)==false){
 alert("Debe llenar los datos del libro a devolver");
return false;
}

if (flag==1){
counter++;
flag=0;
}

var tbody = document.getElementById(id).getElementsByTagName("TBODY")[0];
var row = document.createElement("TR");
row.setAttribute("id","tr"+counter); // set ID of the row
var td1 = document.createElement("TD");

var input1 = document.createElement("INPUT")
input1.setAttribute("type","text");
input1.setAttribute("name","codigo"+counter);
input1.setAttribute("id","codigo"+counter);
input1.setAttribute("size",10);
input1.setAttribute("onkeypress","PressEnter(event,document.devolucion,this.value,'codigo'+counter)"); 
td1.appendChild(input1);

var td2 = document.createElement("TD");
var input2 = document.createElement("INPUT")
input2.setAttribute("type","text");
input2.setAttribute("name","titulo"+counter);
//input2.setAttribute("value","TextFGHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH box"+counter);
input2.setAttribute("id","titulo"+counter);
//input2.setAttribute("readonly","true");
input2.setAttribute("size",20);
td2.appendChild(input2);

var td3 = document.createElement("TD");
var input3 = document.createElement("INPUT");
input3.setAttribute("type","text");
input3.setAttribute("name","tomo"+counter);
//input3.setAttribute("value","Text box "+counter);
input3.setAttribute("id","tomo"+counter);
input3.setAttribute("size",2);
td3.appendChild(input3);

var td4 = document.createElement("TD");
var input4 = document.createElement("INPUT");
input4.setAttribute("type","text");
input4.setAttribute("name","formato"+counter);
//input4.setAttribute("value","Text box "+counter);
input4.setAttribute("id","formato"+counter);
input4.setAttribute("size",10);
td4.appendChild(input4);


var td5 = document.createElement("TD");
var input5 = document.createElement("INPUT");
input5.setAttribute("type","text");
input5.setAttribute("name","editorial"+counter);
//input5.setAttribute("value","-");
input5.setAttribute("id","editorial"+counter);
input5.setAttribute("size",50);
td5.appendChild(input5);


var td6 = document.createElement("TD");
var input6 = document.createElement("INPUT");
input6.setAttribute("style","text-align:right;");
input6.setAttribute("type","text");
input6.setAttribute("name","cantidad"+counter);
//input6.setAttribute("value","-");
input6.setAttribute("id","cantidad"+counter);
input6.setAttribute("size",5);
td6.appendChild(input6);

var td7 = document.createElement("TD");
td7.setAttribute("align","center");
var input7 = document.createElement("select");
input7.setAttribute("name","traslado"+counter);
input7.setAttribute("id","traslado"+counter);
opcioncur = document.createElement("OPTION");
opcioncur.innerHTML = '[Traslado]';
opcioncur.value = '0';
input7.appendChild(opcioncur);

<?

$traslado= array('traslado1','traslado2','traslado3','traslado4');

for($i=0;$i<sizeof($traslado);$i++){
echo "opcion".$i." = document.createElement('OPTION');";
echo "opcion".$i.".innerHTML = '".$traslado[$i]."';";
echo "opcion".$i.".value = '".$traslado[$i]."';";
echo "opcion".$i.".setAttribute(\"onClick\",\"javascript:alert(this.value)\");";
echo "input7.appendChild(opcion".$i.");";
} 
?>

td7.appendChild(input7);

var td8 = document.createElement("TD");
var input8 = document.createElement("select");
input8.setAttribute("name","motivo"+counter);
input8.setAttribute("id","motivo"+counter);
opcioncur = document.createElement("OPTION");
opcioncur.innerHTML = '[Motivo de Devolución]';
opcioncur.value = '0';
input8.appendChild(opcioncur);


<?

$motivos= array('Motivo1','Motivo2','Motivo3','Motivo4');

for($i=0;$i<sizeof($motivos);$i++){
echo "opcion".$i." = document.createElement('OPTION');";
echo "opcion".$i.".innerHTML = '".$motivos[$i]."';";
echo "opcion".$i.".value = '".$motivos[$i]."';";
echo "opcion".$i.".setAttribute(\"onClick\",\"javascript:alert(this.value)\");";
echo "input8.appendChild(opcion".$i.");";

} 

?>

td8.appendChild(input8);


var td9 = document.createElement("TD");
var input9 = document.createElement("td");
//input9.setAttribute("width","20");
//input9.setAttribute("height","16");
//input9.setAttribute("src","imagenes/cal.png");
input9.setAttribute("name","procesado"+counter);
input9.setAttribute("id","procesado"+counter);
td9.setAttribute("class","celda");
td9.appendChild(input9);


row.appendChild(td1);
row.appendChild(td2);
row.appendChild(td3);
row.appendChild(td4);
row.appendChild(td5);
row.appendChild(td6);
row.appendChild(td7);
row.appendChild(td8);
row.appendChild(td9);
tbody.appendChild(row);

cantlib++;
counter++;
counter2++;

document.getElementById("num").value=cantlib;


}

function delRows() {

if(counter2>1){
flag=1;
if (counter > 0){
document.getElementById("myTable").deleteRow(document.getElementById("tr"+counter--).rowIndex);
counter2--;
}else if (counter==0){
document.getElementById("myTable").deleteRow(document.getElementById("tr"+counter).rowIndex);
flag=0;
counter2--;
}

}else alert ('No existen titulos para borrar')

cantlib--; 
document.getElementById("num").value=cantlib;

}

//document.getElementById("titulo0").value='10';
function salir(){
window.close();
//alert(window.name)
}
//window.name='devoluciones';

</SCRIPT>
<style type="text/css">
<!--
.Estilo2 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
</HEAD>

<style type="text/css">
	
button {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #990000; border-color: #FFFFFF ; border-top-width: 2pix; border-right-width: 2pix; border-bottom-width: 2pix; border-left-width: 2pix}
.MultiPage {  background-color:White;
  border: 0px solid #919B9C;
  width:100%;
  position:relative;
  padding:10px;
  top:-3px;
  z-index:98;
  display:block;
  	
}

.celda {
	font-weight: bold;
	border:solid #999999 1px;
	font-size:xx-small;
	
}
input{
font-size:xx-small;
border: solid #BD0F20 1px;
}
table{
-moz-border-radius:6px;
}
</style>

<BODY>



<FORM name="devolucion" id="devolucion">
  <table width="839" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid #990000;">
    <tr>
      <td bgcolor="#990000"><div align="center" class="Estilo2">DEVOLUCI&Oacute;N DE LIBROS </div></td>
    </tr>
    <tr>
      <td></td>
    </tr>
    
    <tr>
      <td><button type="button" onClick="addRow('myTable');">[+]</button>        
        <button type="button"   onClick="delRows('myTable');">[-]</button>        
        <!-- <img  src="imagenes/14_2.png"  onClick="delRows('myTable');"></img>-->    
        <button type="button" onClick="aceptardev(document.getElementById('num').value);">Aceptar</button>
		<button type="button" onClick="salir();">Cancelar</button></td>
    </tr>
    <tr>
      <td><TABLE border="0" cellSpacing="0" id="table" align="center"  >
       
        <TABLE border="0" cellSpacing="0" id="myTable" align="center"  width="100%">
          <TBODY>
            <TR>
              <td height="27" class="celda"><div align="center">C&oacute;digo</div></td>
              <td  class="celda"><div align="center">Tit&uacute;lo</div></td>
              <td class="celda"><div align="center">Tomo</div></td>
              <td class="celda"><div align="center">Formato</div></td>
              <td  class="celda"><div align="center">Editorial</div></td>
              <td class="celda"><div align="center">Cant.</div></td>
          <td class="celda"><div align="center">Traslado</div></td>
              <td width="99" class="celda"><div align="center">Motivo</div></td>
               <td width="99" class="celda"><div align="center">Procesado</div></td>
            </TR>
          </TBODY>
          <TR>
            <td class="celda" colspan="9" align="right">Cantidad de Titulos:
                <div id="valores" align="center"></div><INPUT NAME="num" id="num" TYPE="text" size="5"  value="0" style="text-align:right;"></td>
          </TR>
        </TABLE>
      </TABLE></td>
    </tr>
  </table>
</FORM>

</BODY>
</HTML>