<?php
   
   function validarEmail($email) {
	   
       //Procura quantos @ (arrobas) tem no e-mail
       $arrobas = 0;
       $espacos = 0;   
	   for ($x=0; $x<strlen($email); $x++) {
		   if ( substr($email, $x, 1) == "@" )
		      $arrobas++;

	       if ( substr($email, $x, 1) == " " )
	          $espacos++; 		      
	   }
	   
	   if ($arrobas != 1)
	       return false;
	       
	   if ($espacos > 0)
	       return false;
	   
	   $pontos = 0; 
	   for ($x = strpos($email, '@')+1; $x<strlen($email); $x++) {
	       if ( substr($email, $x, 1) == "." )
	          $pontos++;
       }
       
       if ($pontos == 0)
           return false;
           
       if (strlen($email) < 6)
           return false;    
       
       if ( substr($email, 0, 1) == "@" )
           return false;
           
       if ( substr($email, 0, 1) == "." )
           return false; 
       
       if ( substr($email, strlen($email)-1, 1) == "." )
           return false; 

	   return true;
   }
   
   function enviarEmail($para, $nome, $assunto, $mensagem) {
	   
	   require_once("phpmailer/PHPMailerAutoload.php");
	   
	   date_default_timezone_set("America/Sao_Paulo");
	   
	   $Email = new PHPMailer();
	   $Email->isSMTP();
	   $Email->SMTPDebug = 0;
	   $Email->SMTPAuth = true;
	   $Email->SMTPSecure = 'tls';
	   $Email->Host = 'smtp.gmail.com';
	   $Email->Port = 587;
	   $Email->Username = 'seu_login_no_gmail';
	   $Email->Password = 'sua_senha_do_gmail';
	   $Email->SetLanguage("br");
	   $Email->FromName = $nome;
	   $Email->AddAddress($para);
	   $Email->Subject = $assunto;
	   $Email->Body = $mensagem;
	   
	   if (! $Email->Send() )
	       return "A mensagem não foi enviada. Erro:".$Email->ErrorInfo;
	   else
	       return "Mensagem enviada!";
   }
   
    function montaSelectBD($bd, $sql, $valor_atual, $aceita_nulos) {
        
        $opcoes = "";
       
        if ($aceita_nulos == true)
            $opcoes = "<option value=''></option>";
        
        $resultado = mysqli_query($bd, $sql);
       
        if (mysqli_num_rows($resultado) > 0) {
            $selecionado = "";
           
            while ( $dados = mysqli_fetch_row($resultado) ) {
                if ($dados[0] == $valor_atual)
                    $selecionado = " selected";
                else
                    $selecionado = "";
                
                $opcoes = $opcoes."<option value='".$dados[0]."' $selecionado>".$dados[1]."</option>";
            }
        }
        
        return $opcoes;
    }
          
       

?>










