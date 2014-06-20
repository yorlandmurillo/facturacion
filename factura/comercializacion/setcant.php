<?
require("../admin/session.php"); // incluir motor de autentificación.
//variables POST
$id=$_POST['id'];
//creamos el objeto 
//y usamos su método crear
$obj=new manejadordb;
if(!empty($id)){

		$query = "SELECT * FROM tbl_itemsolicitud where id=$id ";
		
		$result = $obj->consultar($query);
		$row = mysql_fetch_assoc($result);
		$cant=$row['cantidad']-$row['cantdist'];
		$i=0;
		echo '<td>Cantidad:<select name="cant" id="cant">';
		while($i<=$cant){
		echo '<option value='.$i.'>'.$i.'</option>';
		$i++;
		}
		echo '</select></td>';		
		
}
?>