<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript"  language="javascript"  src="ajax.js"></script>
<script type="text/javascript"  language="javascript"  src="jquery.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>

<script type="text/javascript">

function lookup(ci,nom,apel) {
   
   alert(ci,nom,apel)

    $.post("untitled3.php", {ci: ""+ci+""  , nom: ""+nom+"" , apel: ""+apel+""},function(data){
   			//if(data.length >0) {
                 $('#contenidos').html(data);
				 
 			//}
 
        });
   
	

} // lookup



</script>

<form id="enviar" name="enviar" method="post" action="untitled2.php">
<table width="520" border="1" align="center">
  <tr>
    <td colspan="16">&nbsp;</td>
    </tr>
  
  <tr>
    <td height="26" colspan="14">Cedula:
      <input type="text" name="ci[]" id="ci[]" /></td>
    <td width="202">Nombre:
      <input type="text" name="nom[]" id="nom[]" /></td>
    <td width="202">Apellido:
      <input type="text" name="apel[]" id="apel[]" /></td>
  </tr>
  <tr>
    <td height="45" colspan="14">Cedula:
      <input type="text" name="ci[]" id="ci[]" /></td>
    <td>Nombre:
      <input type="text" name="nom[]" id="nom[]" /></td>
    <td>Apellido:
      <input type="text" name="apel[]" id="apel[]" /></td>
  </tr>
  <tr>
    <td height="45" colspan="14">Cedula:
      <input type="text" name="ci[]" id="ci[]" /></td>
    <td>Nombre:
      <input type="text" name="nom[]" id="nom[]" /></td>
    <td>Apellido:
      <input type="text" name="apel[]" id="apel[]" /></td>
  </tr>
  <tr>
    <td height="45" colspan="14">Cedula:
      <input type="text" name="ci[]" id="ci[]" /></td>
    <td>Nombre:
      <input type="text" name="nom[]" id="nom[]" /></td>
    <td>Apellido:
      <input type="text" name="apel[]" id="apel[]" /></td>
  </tr>
  <tr>
    <td height="45" colspan="14">Cedula:
      <input type="text" name="ci[]" id="ci[]" /></td>
    <td>Nombre:
      <input type="text" name="nom[]" id="nom[]" /></td>
    <td>Apellido:
      <input type="text" name="apel[]" id="apel[]" /></td>
  </tr>
  <tr>
    <td height="45" colspan="14">Cedula:
      <input type="text" name="ci[]" id="ci[]" /></td>
    <td>Nombre:
      <input type="text" name="nom[]" id="nom[]" /></td>
    <td>Apellido:
      <input type="text" name="apel[]" id="apel[]" /></td>
  </tr>
  <tr>
    <td height="45" colspan="14">Cedula:
      <input type="text" name="ci[]" id="ci[]" /></td>
    <td>Nombre:
      <input type="text" name="nom[]" id="nom[]" /></td>
    <td>Apellido:
      <input type="text" name="apel[]" id="apel[]" /></td>
  </tr>
  
  <tr>
    <td height="45" colspan="14">Cedula:
      <input type="text" name="ci[]" id="ci[]" /></td>
    <td>Nombre:
      <input type="text" name="nom[]" id="nom[]" /></td>
    <td>Apellido:
      <input type="text" name="apel[]" id="apel[]" /></td>
  </tr>
  
  
  <tr>
    <td colspan="16"><button type="button" id="benviar" onclick="lookup(document.getElementsByTagName('ci').value,document.getElementsByTagName('input').value,document.getElementsByTagName('input').value)" > Enviar </button></td>
	<td colspan="16"><input type="submit" name='submit' value="Enviar1" /></td>
    </tr>
  <tr>
    <td colspan="16">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="16"><div id="contenidos"></div></td>
  </tr>
</table>
</form>
</body>
</html>
