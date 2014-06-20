<?php
//  connection
//    +---- application     // Nome da aplicacao
//    +---- host            // IP ou Nome do servidor MySQL
//    +---- login           // Login MySql
//    +---- senha           // Senha MySQL
//    +---- db              //Base de dados que sera selecionada
//    +---- admMail         // E-mail do administrador
//    +---- log             // Instancia da classe log
//    +---- conID           // ID da conexao
//    +---- connection()    // Inicializa instancia do objeto de log e conecta a base de dados
//    +---- connect()       // Conecta com o servidor MySQL e seleciona uma base de dados
//    +---- close()         // Fecha a conexão MySQL

require("class.log.php");

class connection {

   var $application = "Example Application";  
   var $host =  "localhost"; 
   var $login = "sigal"; 
   var $senha = "120842ma"; 
   var $db = "pglibreria"; 
   var $admMail = "yonyace@cantv.net"; 
   var $log = NULL;
   var $conID = NULL; 



   # Armazena a instancia do objeto de log
   function connection() {
      $this->log = new log();
	  $this->connect();
   }
   # Armazena a instancia do objeto de log



   # Conectar com o servidor MySQL e selecionar uma base de dados ############################## Revisão 27/08/2002 #
   function connect() {
      $err = "<font size='2' face='Verdana,Arial'><b> $this->application <br><br> <font color='#FF0000'>- Erro ao tentar conectar-se com o servidor de banco de dados.</font></b><br><br>Favor <a href='mailto:$this->admMail'>entrar em contato</a> com o administrador do site.";

      $connection = @mysql_connect($this->host,$this->login,$this->senha);
      if (!$connection) {
         $this->log->addLog("Erro ao tentar Conexão MySQL com o servidor \"$this->host\"", "error");
         print($err);
         exit;
      }
      else
         $this->log->addLog("<font color='0B8514'>Conexão MySQL aberta com o servidor \"$this->host\"</font>", "sucess");

      $err = "<font size='2' face='Verdana,Arial'><b> $this->application <br><br> - Conectado ao servidor de banco de dados. <br> <font color='#FF0000'>- Erro ao tentar selecionar a base de dados.</font></b><br><br>Favor <a href='mailto:$this->admMail'>entrar em contato</a> com o administrador do site.";
      $database = @mysql_select_db($this->db);

      if (!$database) {
         $this->log->addLog("Erro ao selecionar a Base de dados \"$this->db\"", "error");
         $this->close($connection);
		 print($err);
         exit;
      }
      else {
         $this->log->addLog("Base de dados \"$this->db\" selecionada", "sucess");
      }

      $this->conID = $connection;
   }
   # Conectar com o servidor MySQL e selecionar uma base de dados ############################## Revisão 27/08/2002 #

   # Fechar a conexão MySQL #################################################################### Revisão 27/08/2002 #
   function close() {
      mysql_close($this->conID);
      $this->log->addLog("<font color='0B8514'>Conexão MySQL Fechada</font>", "sucess");
   }
   # Fechar a conexão MySQL #################################################################### Revisão 27/08/2002 #

} # Final da Classe
?>
