<? 
require("../admin/session.php");

	function codigoinv($resp,$sucursal){
    $year=date('Y');
	$month=date('m');
	$day=date('d');
	$hour=date('H')-1;
	$minute=date('i');
	$second=date('s');
	$cadena="INV-";
	$fecha=$year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
	$codigof=new  manejadordb;
//Selecciono el ultimo correlativo de las facturas
	$row = mysql_fetch_assoc($codigof->consultar("select correlativo from tbl_audinventario order by correlativo desc"));
	$cod=$row['correlativo'];
//Selecciono el correlativo de la factura actual
	$row2 = mysql_fetch_assoc($codigof->consultar("select correlativo from tbl_audinventario where sucursal=$sucursal and estatus=6"));
	$cod2=$row2['correlativo'];
	$codinvactual=$cadena.$cod2;
	
	if($cod=="")$cod=1;else $cod+=1;
	$codinv=$cadena.$cod;
	
	if(mysql_num_rows($codigof->consultar("select * from tbl_audinventario where sucursal=$sucursal and estatus=6 "))==0){
	$codigof->query("INSERT INTO tbl_audinventario (cod_invent,f_inventario,responsable,sucursal,estatus,correlativo)VALUES('$codinv','$fecha',$resp,$sucursal,6,$cod);");
	return $codinv;
   	}else return $codinvactual;
   
   }


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<HTML>
<HEAD>
<TITLE>Inventario de Libros</TITLE>
<script type="text/javascript"  language="javascript"  src="js/ajax.js"></script>
<SCRIPT language="javascript">
var counter = 0
var cantlib = 0
var flag = 0
var counter2 = 1
function addRow(id,nota){

nota=document.getElementById(nota).value
if(counter>0 && verificarcampos(counter-1)==false){
 alert("Debe llenar los datos del libro a inventariar");
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
input1.setAttribute("onkeypress","PressEnter(event,document.inventario,this.value,counter-1,document.inventario.sucursal.value)"); 

td1.appendChild(input1);

var td2 = document.createElement("TD");
var input2 = document.createElement("INPUT")
input2.setAttribute("type","text");
input2.setAttribute("name","titulo"+counter);
//input2.setAttribute("value","TextFGHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH box"+counter);
input2.setAttribute("id","titulo"+counter);
input2.setAttribute("readonly","true");
input2.setAttribute("size",20);
td2.appendChild(input2);

var td3 = document.createElement("TD");
var input3 = document.createElement("INPUT");
input3.setAttribute("type","text");
input3.setAttribute("name","tomo"+counter);
//input3.setAttribute("value","Text box "+counter);
input3.setAttribute("id","tomo"+counter);
input3.setAttribute("readonly","true");
input3.setAttribute("size",2);
td3.appendChild(input3);

var td4 = document.createElement("TD");
var input4 = document.createElement("INPUT");
input4.setAttribute("type","text");
input4.setAttribute("name","formato"+counter);
//input4.setAttribute("value","Text box "+counter);
input4.setAttribute("id","formato"+counter);
input4.setAttribute("readonly","true");
input4.setAttribute("size",10);
td4.appendChild(input4);


var td5 = document.createElement("TD");
var input5 = document.createElement("INPUT");
input5.setAttribute("type","text");
input5.setAttribute("name","editorial"+counter);
//input5.setAttribute("value","-");
input5.setAttribute("id","editorial"+counter);
input5.setAttribute("readonly","true");
input5.setAttribute("size",50);
td5.appendChild(input5);


var td6 = document.createElement("TD");
var input6 = document.createElement("INPUT");
input6.setAttribute("style","text-align:right;");
input6.setAttribute("type","text");
input6.setAttribute("name","cantidads"+counter);
//input6.setAttribute("value","-");
input6.setAttribute("id","cantidads"+counter);
input6.setAttribute("readonly","true");
input6.setAttribute("size",5);
td6.appendChild(input6);

var td7 = document.createElement("TD");
var input7 = document.createElement("INPUT");
input7.setAttribute("style","text-align:right;");
input7.setAttribute("type","text");
input7.setAttribute("name","cantidadf"+counter);
//input6.setAttribute("value","-");
input7.setAttribute("id","cantidadf"+counter);
input7.setAttribute("size",5);
td7.appendChild(input7);

var td8 = document.createElement("TD");
var input8 = document.createElement("select");
input8.setAttribute("name","condicion"+counter);
input8.setAttribute("id","condicion"+counter);
opcioncur = document.createElement("OPTION");
opcioncur.innerHTML = 'Consignaci&oacute;n DN';
opcioncur.value = '3';
input8.appendChild(opcioncur);


<?

$condicion= array('Firme','Consignaci&oacute;n','Consignaci&oacute;n DN');

for($i=0;$i<sizeof($condicion);$i++){
echo "opcion".$i." = document.createElement('OPTION');";
echo "opcion".$i.".innerHTML = '".$condicion[$i]."';";
echo "opcion".$i.".value = '".($i+1)."';";
//echo "opcion".$i.".setAttribute(\"onClick\",\"javascript:alert(this.value)\");";
echo "input8.appendChild(opcion".$i.");";

} 

?>

td8.appendChild(input8);


var td9 = document.createElement("TD");
var input9 = document.createElement("div");
//input9.setAttribute("width","20");
//input9.setAttribute("height","16");
//input9.setAttribute("src","imagenes/cal.png");
input9.setAttribute("id","procesado"+counter);
td9.setAttribute("class","celda");
td9.appendChild(input9);

var td10 = document.createElement("TD");
var input10 = document.createElement("INPUT");
input10.setAttribute("type","text");
input10.setAttribute("name","notaent"+counter);
input10.setAttribute("value",nota);
input10.setAttribute("id","notaent"+counter);
input10.setAttribute("readonly","true");
input10.setAttribute("size",50);
td10.appendChild(input10);


/*var td10 = document.createElement("TD");
var input10 = document.createElement("button");
input10.setAttribute("onClick","rlibro(event,document.inventario,this.value,counter-1,document.inventario.sucursal.value)"); 
input10.setAttribute("id","procesado"+counter);
td10.appendChild(input10);
*/
row.appendChild(td1);
row.appendChild(td2);
row.appendChild(td3);
row.appendChild(td4);
row.appendChild(td5);
row.appendChild(td6);
row.appendChild(td7);
row.appendChild(td8);
row.appendChild(td9);
row.appendChild(td10);
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

}else{
alert ('No existen titulos para borrar')
}
if(cantlib>0){
cantlib--; 
}

document.getElementById("num").value=cantlib;

}

//document.getElementById("titulo0").value='10';

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
font-size:11px;
border: solid #BD0F20 1px;
}
table{
-moz-border-radius:6px;
}
</style>

<BODY>



<FORM name="inventario" id="inventario">
  <table width="859" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid #990000;">
    <tr>
      <td colspan="2" bgcolor="#990000"><div align="center" class="Estilo2">INVENTARIO DE LIBROS </div></td>
    </tr>
    <tr>
      <td colspan="2" ></td>
    </tr>
    <tr>
	<td width="672" > Sucursal: 
	<select name="sucursal" id="sucursal" >

	<?	  
		
	  $sql="SELECT * FROM tbl_sucursal where id_sucursal<>0"; 
	   	 $sql.=" order by id_sucursal 	"; 
  
		$r = $obj->consultar($sql);

		if(!empty($_GET['sucursal']) && !empty($_GET['nomsuc'])){
	    echo '<option selected="selected" value='.$_GET['sucursal'].' >'.$_GET['nomsuc'].'</option>';
	 	}else echo '<option selected="selected" value="0" >Todas</option>';
		
     	while ($row = mysql_fetch_assoc($r)) 
     	{    
			
			$value=$row["id_sucursal"];
			echo "<option value=\"".$value."\">".utf8_decode($row["sucursal"])."</option>";
		
		}	 
	   
	  ?>
	  </select><input  type="hidden" name="resp" id="resp" />
	   
</td>
	<td width="227" >N&deg; Inventario: 
	  
	    <input type="text" name="codinv" id="codinv" value="<? echo codigoinv($_SESSION['usuario_id'],$_SESSION['usuario_sucursal']); ?>" readonly="true" size="30" style="text-align:right;"/>

	  </td>

    </tr>

<tr>
<td>
N&deg; Nota Ent.: 
	    <input type="text" name="notaentrega" id="notaentrega" value="DEVOLUCION FERIA PZA LOS MUSEOS" size="30" style="text-align:right;"/>
</td>

</tr>
	<tr>
	<td colspan="9">&nbsp;</td>
	</tr>
    <tr>
      <td colspan="2"><button type="button" onClick="addRow('myTable','notaentrega');">[+]</button>        
        <button type="button"   onClick="delRows('myTable');">[-]</button>        
        <!-- <img  src="imagenes/14_2.png"  onClick="delRows('myTable');"></img>-->    
        <button type="button" onClick="aceptarinv(document.getElementById('num').value);">Aceptar</button>
		<button type="button" onClick="salir();">Cancelar</button>
		<?
		if ($_SESSION['usuario_nivel']==2){
		 echo'<button type="button" onClick="fininv();" >Finalizar</button>';
		}elseif($_SESSION['usuario_nivel']!=2){
		 echo'<button type="button" onClick="fininv();" disabled>Finalizar</button>';
		}
		
		?>
		
		
		</td>
    </tr>
	
    <tr>
	
      <td colspan="2"><TABLE border="0" cellSpacing="0" id="table" align="center"  >
       
        <TABLE border="0" cellSpacing="0" id="myTable" align="center"  width="100%">
          <TBODY>
            <TR>
              <td height="27" class="celda"><div align="center">C&oacute;digo</div></td>
              <td  class="celda"><div align="center">Tit&uacute;lo</div></td>
              <td class="celda"><div align="center">Tomo</div></td>
              <td class="celda"><div align="center">Formato</div></td>
              <td  class="celda"><div align="center">Editorial</div></td>
              <td class="celda"><div align="center">Cant. Sist.</div></td>
          <td class="celda"><div align="center">Cant. Fis.</div></td>
              <td width="99" class="celda"><div align="center">Condici&oacute;n</div></td>
               <td width="99" class="celda"><div align="center">Procesado</div></td>
              <td width="99" class="celda"><div align="center">NotaEnt</div></td>

            </TR>
          </TBODY>
          <TR>
            <td class="celda" colspan="10" align="right">Cantidad de Titulos:
                <div id="valores" align="center"></div><INPUT NAME="num" id="num" TYPE="text" size="5"  value="0" style="text-align:right;"></td>
          </TR>
          <tr>
      <td colspan="9"><button type="button" onClick="addRow('myTable','notaentrega');">[+]</button>        
        <button type="button"   onClick="delRows('myTable');">[-]</button>        
        <!-- <img  src="imagenes/14_2.png"  onClick="delRows('myTable');"></img>-->    
        <button type="button" onClick="aceptarinv(document.getElementById('num').value);">Aceptar</button>
		<button type="button" onClick="salir();">Cancelar</button>
		<?
		if ($_SESSION['usuario_nivel']==2){
		 echo'<button type="button" onClick="fininv();" >Finalizar</button>';
		}elseif($_SESSION['usuario_nivel']!=2){
		 echo'<button type="button" onClick="fininv();" disabled>Finalizar</button>';
		}
		
		?>
		
		
		</td>
    </tr>
        </TABLE>
      </TABLE></td>
    </tr>
  </table>
</FORM>

</BODY>
</HTML>
