<? 
require("../clases/class.xml.php");
require("../clases/class.mysql_xml.php");
require("envios.php");

//set_time_limit(1000);
@ini_set("max_execution_time", "1000");
@ini_set("memory_limit","128M");


$envios=new envios();
$conv = new mysql2xml;


//definimos el path de acceso
$path="";

$i=0;

while($i < sizeof($envios->carpetas)){

	$result=manejadordb::consultar("select * from tbl_sucursal where id_sucursal>0");

	while($row=mysql_fetch_assoc($result)){

		$filesource="/".$row['id_sucursal'];
		
		$path=$_SERVER['DOCUMENT_ROOT']."/clients/client1/web1/web/envios/".$envios->carpetas[$i]."/".$row['id_sucursal'];
		$respl=$_SERVER['DOCUMENT_ROOT']."/clients/client1/web1/web/respaldo/".$envios->carpetas[$i]."/".$row['id_sucursal'];
//instanciamos el objeto
		if(!file_exists($path)){
		mkdir($path);
		chmod($path,0777);
		$dir=dir($path);
		}else{
		$dir=dir($path);
		}
		
		//Mostramos las informaciones

		while ($elemento = $dir->read())
		{
		if ( ($elemento != '.') and ($elemento != '..'))
		{   
		$file= $path."/".$elemento;

		if(substr_count($file,"procesado")==0){
				$conv->insertIntoMySQL($file, $envios->tablas[$i]);
				$marca="procesado";
				$filesource=$path."/".$marca.$elemento;
				$filedest = $file;
				if(rename($filedest,$filesource)){
				$destino=$respl."/".$marca.$elemento;
				$envios->mover($filesource,$destino);
				}
		//echo "Carpeta: ".$envios->carpetas[$i]." "."Sucursal: ".manejadordb::setsucursal($row['id_sucursal'])." "."Archivo: ".$elemento."<br>";
		}//else echo "Archivo: $elemento ya fue procesado"."<br>";
		}
		}
		//Cerramos el directorio
		$dir->close();
	}
$i++;
}
//echo sizeof($envios->carpetas);
?>