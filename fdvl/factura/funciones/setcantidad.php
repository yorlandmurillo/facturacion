<?
require("../admin/session.php"); // incluir motor de autentificación.
//variables POST

$id=$_POST['id'];
$suc=$_SESSION['usuario_sucursal'];
//creamos el objeto 
//y usamos su método crear
$obj=new manejadordb;
if(!empty($id)){

		$query = "SELECT * FROM tbl_itemfactura where id_itemfactura=$id and sucursal=$suc ";
		$result = $obj->consultar($query);
		$row = mysql_fetch_assoc($result);
		$cant=$row['cif']+$row['cic']+$row['cicdn'];
		$i=0;
		echo '<td><select name="cantdev" id="cantdev">';
		while($i<=$cant){
		echo '<option value='.$i.'>'.$i.'</option>';
		$i++;
		}
		echo '</select></td>';		
	
		/*$j=0;
		echo '<td>Consig.: <select name="cantf" id="cantf">';
		while($j<=$row['cic']){
		echo '<option value='.$j.'>'.$j.'</option>';
		$j++;
		}
		echo '</select></td>';		
		$k=0;
		echo '<td>Consig. DN: <select name="cantf" id="cantf">';
		while($k<=$row['cicdn']){
		echo '<option value='.$k.'>'.$k.'</option>';
		$k++;
		}
		echo '</select></td>';*/		
		
		
}
?>