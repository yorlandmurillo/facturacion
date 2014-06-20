<?php
  class Item
    {
    	var $prd_id;
    	var $prd_desc;
    	var $code;
    	var $image;
    	var $price;
    	var $quantity;

    	function setPrd_Id($valor)
    	  {$this->prd_id = $valor;}
    	function getPrd_Id()
    	  {return $this->prd_id;}  
    	  
    	function setPrd_Desc($valor)
    	  {$this->prd_desc = $valor;}
    	function getPrd_Desc()
    	  {return $this->prd_desc;}  

    	function setCode($valor)
    	  {$this->code = $valor;}
    	function getCode()
    	  {return $this->code;}  

    	function setImage($valor)
    	  {$this->image = $valor;}
    	function getImage()
    	  {return $this->image;}  

    	function setPrice($valor)
    	  {$this->price = $valor;}
    	function getPrice()
    	  {return $this->price;}  

    	function setQuantity($valor)
    	  {$this->quantity = $valor;}
    	function getQuantity()
    	  {return $this->quantity;}  
    	
    }
	
	class numeros
 {
     function formatear($numero,$cantDec,$moneda,$sepMil=true){
         $posPunto = strrpos($numero, ".");  //obtengo la pos del punto (separador de decimales
   
         /*if($posPunto===false){
             //no tiene decimales
             return $moneda." ".(($sepMil)?numeros::sepMil($numero):$numero);
         }else{
             //tiene decimales
             $num = explode(".",$numero);
             $entera = ($sepMil)?numeros::sepMil($num[0]):$num[0];
             $decimal = ($cantDec)?numeros::sepDec($num[1],$cantDec):"";
             return $moneda." ".$entera.$decimal;
         }*/
		 if($posPunto==false or $posPunto==""){
			 $numero=$numero.'.00';
         }
             $num = explode(".",$numero);
             $entera = ($sepMil)?numeros::sepMil($num[0]):$num[0];
             $decimal = ($cantDec)?numeros::sepDec($num[1],$cantDec):"";
             return $moneda." ".$entera.$decimal;
         
     }
     
     function sepMil($numero){
         return strrev(wordwrap(strrev($numero),3,".",1));
     }
     
     function sepDec($numero,$cantDec){
         $cant = strlen($numero);
         if($cant > 2)
             return ",".substr($numero,0,$cantDec);
         elseif($cant<2)
             return ",".$numero."0";
         else
             return ",".$numero;
     }
 }
 

	
//	 $cItem = new Item();
//                 $cItem->setPrd_Id($v['prd_id']);
  Function Acentos($P_VALOR)
    {$Valor = $P_VALOR;
     $Valor = str_replace("á" ,"&aacute;",$Valor);
     $Valor = str_replace("é" ,"&eacute;",$Valor);
     $Valor = str_replace("í" ,"&iacute;",$Valor);
     $Valor = str_replace("ó" ,"&oacute;",$Valor);
     $Valor = str_replace("ú" ,"&uacute;",$Valor);
     $Valor = str_replace("ñ" ,"&ntilde;",$Valor);
     $Valor = str_replace("Á" ,"&Aacute;",$Valor);
     $Valor = str_replace("É" ,"&Eacute;",$Valor);
     $Valor = str_replace("Í" ,"&Iacute;",$Valor);
     $Valor = str_replace("Ó" ,"&Oacute;",$Valor);
     $Valor = str_replace("Ú" ,"&Uacute;",$Valor);
     $Valor = str_replace("Ü" ,"&Uuml;"  ,$Valor);
     $Valor = str_replace("ü" ,"&uuml;"  ,$Valor);
     $Valor = str_replace("\"", "&quot;" ,$Valor);
     $Valor = str_replace("\'", "&quot;" ,$Valor);
     return $Valor;   
    }
  Function FTarget()
    {$hoy = date("YmdHis");                           
     return $hoy;
    }  
  Function SendEmail($Correo, $Asunto, $Para, $De, $Alias, $cc)
    {$Temp = $Correo;
     $Temp = str_replace("images","http://www.tornillosyalgomas.com/images",$Temp);
     $Temp = str_replace("sdisabled","readonly",$Temp);
     $Temp = str_replace("sfinal","disabled",$Temp);
     $Body   =  "";
     $Body  .= "<HTML>";
     $Body  .= "  <Head>";
     $Body  .= "    <TITLE>TYAM Tornillos</TITLE>";
     $Body  .= "     <LINK href='http://www.tornillosyalgomas.com/estilo.css' type='text/css' rel='stylesheet'>";
     //$Body  .= "     <SCRIPT type='text/javascript' language='javascript' src='http://www.tornillosyalgomas.com/Carro.js'></script>";
     $Body  .= "  </Head>";
     $Body  .= "  <BODY bgcolor=#FFFFFF text=#000000  leftmargin=0 topmargin=0 marginwidth=20 marginheight=0> ";
     $Body  .= "    <TABLE width='60%' border='0' cellspacing='0' cellpadding='0' align='center'>";
     $Body  .= "      <TR><TD width='100%'>&nbsp;</TD></TR>";
     $Body  .= "      <TR><TD width='100%' align='center'><IMG src='http://www.tornillosyalgomas.com/images/titulo_index.gif' border='0' width='400' height='100'></TD></TR>";
     $Body  .= "      <TR><TD width='100%' align='center' class='Negro'>&nbsp;</TD></TR>";
     $Body  .= "      <TR><TD width='100%'>";
     $Body  .= $Temp ;
     $Body  .= "      </TD></TR>";
     $Body  .= "    </TABLE>";
     $Body  .= "  </BODY>";
     $Body  .= "</HTML>". "\r\n";

     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
     $headers .= 'To: '.$Para. "\r\n";
     $headers .= 'From: ' . $Alias . ' <'.$De.'>' . "\r\n";
     $headers .= 'CC: '.$cc."\r\n";


     mail($Para, $Asunto, $Body, $headers);     
    }  
?>				
