<?php

//  recordSet
//    +---- numFields // Número de campos na consulta
//    +---- checkSql( Sentença SQL, Modo [select, execute] )
//    +---- select( Sentença SQL )
//    +---- setRow( MySQL Result )
//    +---- getLastID( Conexão )
//    +---- getFieldName( MySQL Result, Indice )
//    +---- fieldsCount ( MySQL Result )
//    +---- recordCount( MySQL Result )
//    +---- exec( Sentença SQL )
//    +---- erase( ID do Registro, Nome do Campo Chave, Entidade )
//    +---- erases( Lista de ID´s dos Registros, Nome do Campo Chave, Entidade )
//    +---- comboBox( Sentença SQL, ID para Seleção )
//    +---- comboBoxBin( Sentença SQL, ID para Seleção )
//    +---- insert( Entidade )
//    +---- update( Entidade, Campo Chave, Valor do Campo Chave )
//    +---- getForm(Lista de Campos, Lista de Valores)
//

require("class.connection.php");

class recordSet extends connection {

   var $numFields;

   # Validar caracteres maliciosos na sentença SQL ############################################# Revisão 26/08/2002 #
   function checkSql($sql, $mode) {

      $valid = true;
      $sql = strtolower($sql);

      if ($mode == "execute")
         $dic = array ("alter table", "create table", "drop table", "alter database", "create database", "drop database", "rename table", "drop index");
      else
         $dic = array ("alter table", "create table", "drop table", "alter database", "create database", "drop database", "rename table", "drop index", "delete");

      while(list($id, $word) = each($dic))
         if (strpos($sql, $word) !== false) $valid = false;
      
	  return $valid;
   }
   # Validar caracteres maliciosos na sentença SQL ############################################# Revisão 26/08/2002 #



   # executa uma consulta a base de dados MySQL ################################################ Revisão 26/08/2002 #
   function select($sql) {

      if ($this->checkSql($sql, "select")) {
         $err = "<font size='2' face='Verdana,Arial'><b> $this->application <br><br> - Conectado ao servidor de banco de dados. <br> - Base de dados selecionada. <font color='#FF0000'><br>- Erro ao consultar na base de dados.</font></b><br><br>Favor <a href='mailto:$this->admMail'>entrar em contato</a> com o administrador do site.";
         $result = @mysql_query($sql, $this->conID);

         if (!$result) {
            $this->log->addLog("Erro ao Selecionar - \"$sql\"", "error");
            $this->close();
            print($err);
            exit;
         }
         else {
            $this->log->addLog("Seleção - \"$sql\"", "sucess");
            $this->numFields = @mysql_num_fields($result);
			return $result;
         }
      }
      else {
          $this->log->addLog("Seleção - \"$sql\"", "error");
          $this->close();
          print($err);
          exit;
      }
   }
   # executa uma consulta a base de dados MySQL ################################################ Revisão 26/08/2002 #



   # Retorna uma matriz da consulta MySQL ###################################################### Revisão 26/08/2002 #
   function setRow($result) {
   
     return @mysql_fetch_array($result);
   }
   # Retorna uma matriz da consulta MySQL ###################################################### Revisão 26/08/2002 #

   
   
   # Retorna o ultimo Id gerado por um campo auto incremento ########################################################
   function getLastID() {
   
     return @mysql_insert_id($this->conID);
   }
   # Retorna o ultimo Id gerado por um campo auto incremento ########################################################

   
   
   # Retorna o nome do campo #######################################################################################
   function getFieldName($result, $index) {
   
     return @mysql_field_name($result, $index);
   }
   # Retorna o nome do campo #######################################################################################


   
   # Retorna o nome do campo #######################################################################################
   function fieldsCount($result) {
   
     return @mysql_num_fields($result);
   }
   # Retorna o nome do campo #######################################################################################

   

   # Retorna o número de registros de uma consulta MySQL ############################################################
   function recordCount($result) {
   
     return @mysql_num_rows($result);
   }
   # Retorna o número de registros de uma consulta MySQL ############################################################



   # executa uma sentença SQL #######################################################################################
   function exec($sql) {
   
      if ($this->checkSql($sql, "execute")) {
          $err = "<font size='2' face='Verdana,Arial'><b> $this->application <br><br> - Conectado ao servidor de banco de dados. <br> - Base de dados selecionada. <font color='#FF0000'><br>- Erro ao executar a sentença SQL na base de dados.</font></b><br><br>Favor <a href='mailto:$this->admMail'>entrar em contato</a> com o administrador do site.";
		  
          if (!mysql_query($sql, $this->conID)) {
             $this->log->addLog("executar - \"$sql\"", "error");
             $this->close();
             print($err);
             exit;
          }
          else
             $this->log->addLog("Executar - \"$sql\"", "sucess");
      }
      else {
         $this->log->addLog("Executar - \"$sql\"", "error");
         $this->close();
         print($err);
         exit;
      }
   }
   # executa uma sentença SQL #######################################################################################



   # Deleta um registro #############################################################################################
   function erase($id, $idFieldName, $table) {
   
     $sql = "Delete From $table Where $idFieldName = $id";
     $this->exec($sql);
   }
   # Deleta um registro #############################################################################################



   # Deleta registros com ID dentro do array ########################################################################
   function erases($array, $idFieldName, $table) {
   
      sort(&$array);
      $array_ids = join(",",$array);
      $sql = "Delete From $table Where $idFieldName In ($array_ids)";
      $this->exec($sql);
   }
   # Deleta registros com ID dentro do array ########################################################################



   # Escreve os items de um <input select> de acordo com o SQL ######################################################
   function comboBox($sql, $selected){
   
      $result = $this->select($sql);

      while($table = $this->SetRow($result)) {
         if($selected == $table[0])
            print("<option value='".$table[0]."' selected>".$table[1]."</option>");
         else
            print("<option value='".$table[0]."'>".$table[1]."</option>");
      }
   }
   # Escreve os items de um <input select> de acordo com o SQL ######################################################



   # Escreve os items de um <input select> de acordo com o SQL em binário ##########################################
   function comboBoxBin($sql, $selected) {
     $result = $this->select($sql);

     while($table = $this->SetRow($result)) {
       if($selected == $table[0])
         print("<option value='".decbin($table[0])."' selected>".$table[1]."</option>");
       else
         print("<option value='".decbin($table[0])."'>".$table[1]."</option>");
     }
   }
   # Escreve os items de um <input select> de acordo com o SQL em binário ##########################################



   # Gera uma string SQL insert ########################################################################################
   function insert($dbTableName) {
   
      $this->getForm($dbFieldNames, $dbFieldValues);
      $sql_fields = join($dbFieldNames, ",");
      $sql_values = join($dbFieldValues, ",");

      $this->exec("insert Into $dbTableName ($sql_fields) Values ($sql_values)");
   }
   # Gera uma string SQL insert ########################################################################################



   # Gera uma string SQL update ########################################################################################
   function update($dbTableName, $idFieldName, $idFieldValue) {
   
      $this->getForm($dbFieldNames, $dbFieldValues);
   
      while(list($index, $nome) = each($dbFieldNames)) {
	  
         $fields .= $nome." = ".$dbFieldValues[$index];
         if ($index < count($dbFieldNames)) $fields .= ", ";
      }

      $fields = substr($fields, 0, strlen($fields) - 2);
	  $this->exec("update $dbTableName Set $fields Where $idFieldName = $idFieldValue");
   }
   # Gera uma string SQL update ########################################################################################



   # Trata os campos HTML ##############################################################################################
   function getForm(&$dbFields, &$dbValues) {

      $index = 0;

      while(list($form_field_name, $form_field_value) = each($GLOBALS["HTTP_POST_VARS"])) {

		 if (substr($form_field_name, 0, 3) == "f__") {
			$dbField["name"][$index] = substr($form_field_name, 7, strlen($form_field_name) - 7);
            $form_field_type = substr($form_field_name, 3, 3);
            if ($form_field_type == "str")
               $dbField["value"][$index] = "\"".$form_field_value."\"";
            else
               if ($form_field_type == "dat")
                  $dbField["value"][$index] = "\"".substr($form_field_value,6,4)."-".substr($form_field_value,3,2)."-".substr($form_field_value,0,2)."\"";
               else
                  $dbField["value"][$index] = $form_field_value;
            $index++;
         }
      }

	  $dbFields = $dbField["name"];
      $dbValues = $dbField["value"];
   }
   # Trata os campos HTML ##############################################################################################



} # Final da Classe
?>