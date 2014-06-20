<?php
//
// Por Ricardo Costa - ricardo.community@globo.com - 2002
// Classe para insercao e exibicao do log
//
//  log
//    +---- log( Nome do arquivo de log ) // Inicializa o log passando o nome do arquivo
//    +---- addLog( String para insercao, Tipo de mensagem [error, sucess] )  //  Adicionar uma linha ao arquivo de Log
//    +---- show() //  Exibir a o conteudo do log
//
//

class log
{
   var $filename; // Caminho e nome do arquivo de log



   # Inicializa o log passando o nome do arquivo ############################################# Revisão 02/09/2002 #
   function log($filename = NULL) {

      if (!$GLOBALS["nyear"]) 
         $this->filename = date("Y.m.d").".log";
      else	
         $this->filename = $GLOBALS["nyear"].".".mformat(2, $GLOBALS["nmonth"]).".".mformat(2, $GLOBALS["nday"]).".log";
   }
   # Inicializa o log passando o nome do arquivo ############################################# Revisão 02/09/2002 #




   # Adicionar uma linha ao arquivo de Log ################################################### Revisão 02/09/2002 #
   function addLog($text, $type) {

      $log_file = @fopen($this->filename, "a+");
      if ($log_file) {
         
		 //$log = fread($log_file, filesize($log_file));
         $content = $log;
         $ini = strlen($GLOBALS["REQUEST_URI"]) - 40;
         $content .= "<span class=\"$type\"> - ".
                       date("d.m.Y ..... H:m:s")." ..... ".
                       str_pad(substr($GLOBALS["REMOTE_ADDR"]." ", 0, 15), 20, ".", STR_PAD_RIGHT)." ".
                       str_pad($GLOBALS["user_name"], 25, ".", STR_PAD_RIGHT).
                       str_pad(substr($GLOBALS["PHP_SELF"], strrpos($GLOBALS["PHP_SELF"], "/"), strlen($GLOBALS["PHP_SELF"])), 30, ".", STR_PAD_RIGHT).
                        " $text</span><br>\n";
         fputs($log_file, $content);
         fclose($log_file);
      }
   }
   # Adicionar uma linha ao arquivo de Log ################################################### Revisão 02/09/2002 #




   # Exibir a o conteudo do log ############################################################## Revisão 02/09/2002 #
   function show() {

	  if ($log_file = @fopen($this->filename, "r")) {

         while (!feof ($log_file)) {
            $buffer = fgets($log_file, 4096);
            if (strpos($buffer, $GLOBALS["nday"].".".mformat(2, $GLOBALS["nmonth"]).".".$GLOBALS["nyear"]) > 1) {
               $buffer = str_replace("\\\"", "\"", $buffer);
               print($buffer);
               flush();
            }
         }

         fclose ($log_file);
      }
      else
          print("Erro ao tentar abriar o log \"$this->filename\"");
   }
   # Exibir a o conteudo do log ############################################################## Revisão 02/09/2002 #



} # Final da Classe
?>