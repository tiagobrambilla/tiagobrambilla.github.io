<?php

    include_once("validacao.php");
    include_once("conexao.php");

    $sql = "delete from votos ; ";
    
    if ( ! mysqli_query($bd, $sql) ) 
			 $mensagem = "NÃO FOI POSSÍVEL INICIALIZAR A VOTAÇÃO";
	else {
       
        $arquivo = fopen("votos.txt","w"); //a->append r->read w->write
        fclose($arquivo);
        
        $mensagem = "VOTAÇÃO INICIALIZADA COM SUCESSO!";
        
	}
	
    session_destroy();
    header("location: index.php?mensagem=$mensagem");
	

?>
