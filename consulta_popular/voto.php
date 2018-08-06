<?php

    include_once("validacao.php");
    include_once("funcoes.php");
    include_once("conexao.php");

    if ( isset($_POST["prioridade"] ) )
       $voto = $_POST["prioridade"];
    else
       header("location: escolha.php");
    
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d H:i');

    $mensagem = "";

    $sql = "insert into votos (login, id_prioridade) values ('$login', $voto) ";
    
    if ( ! mysqli_query($bd, $sql) ) 
			 $mensagem = "NÃO FOI POSSÍVEL REGISTRAR O VOTO, ELEITOR JÁ VOTOU!";
	else {
       
        $arquivo = fopen("votos.txt","a"); //a->append r->read w->write
        fwrite($arquivo, $data.";".$voto.";".$login."\r\n");
        fclose($arquivo);
        enviarEmail($login, "SVOnLine", "Consulta Popular", utf8_decode("Obrigado por participar da votação!"));
        
        $mensagem = "OBRIGADO POR VOTAR!";
        
	}
	
    session_destroy();
    header("location: index.php?mensagem=$mensagem");
	

?>