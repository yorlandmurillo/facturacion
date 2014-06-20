<?php
//  mysql To xml
//    +---- recordSet    // Instancia de recordSet
//    +---- xml          // Instancia de XMLFile
//    +---- mysql2xml()  // Inicia as Instancias de recordset e XMLFile
//    +---- convertToXML( Seltença SQL, Nome do Arquivo )
//    +---- insertIntoMySQL( Nome do Arquivo, Nome da Tabela) {
//
//

require("class.recordset.php");
require("class.xml.php");
require("../admin/manejadordb.php");// // incluir motor de autentificación.



class mysql2xml {

   var $recordSet; 
   var $registrar; 
   var $xml; 
   var $charspecial = array("&","<");
   var $charsreplace = array("&amp;","&lt;");
   # Inicializa criando os membros
   function mysql2xml() {
      $this->recordSet = new recordSet();
	  $this->xml = new XMLFile();
	  $this->registrar = new manejadordb();
      
   }
   # Inicializa criando os membros

   
   
   # Convert a query em XML
   function convertToXML($sql, $filename) {

      $result = $this->recordSet->select($sql);
      $this->xml->create_root();
      $this->xml->roottag->name = "table";
   
      while ($list_result = $this->recordSet->setRow($result)) {

      $this->xml->roottag->add_subtag("ROW", array());
      $tag = &$this->xml->roottag->curtag;
   	     
		 for ($i = 0; $i <= $this->recordSet->fieldsCount($result)- 1; $i++){
	   	    $tag->add_subtag($this->recordSet->getFieldName($result, $i), array());
			$tag->curtag->cdata = utf8_encode(str_replace($this->charspecial,$this->charsreplace,$list_result[$i]));
         }
	  }
	
	  $xml_file = fopen($filename, "w" );
      
	  if($this->xml->write_file_handle( $xml_file )==true)
		  return true;
			else return false;
   }
   # Convert a query em XML

   # Inseri XML em tabela
   function insertIntoMySQL($filename, $tablename) {
      $xml_file = fopen($filename, "r"); 
      $this->xml->read_file_handle($xml_file);
          
      $numRows = $this->xml->roottag->num_subtags();
	  
      for ($i = 0; $i < $numRows; $i++) {
           $arrFields = null;
		   $arrValues = null; 

		   $row = $this->xml->roottag->tags[$i];
           $numFields = $row->num_subtags();

           for ($ii = 0; $ii < $numFields; $ii++) {
 	          $field = $row->tags[$ii];
              $arrFields[] = $field->name;
              $arrValues[] = "\"".utf8_decode($field->cdata)."\"";
           }
           $fields = join($arrFields, ", ");
           $values = join($arrValues, ", ");


//         $this->recordSet->exec("Insert Into $tablename ($fields) Values ($values)");
    	   $this->registrar->query("Insert Into $tablename ($fields) Values ($values)");


      }
   }
   # Inseri XML em tabela


} # Final da Classe
?>