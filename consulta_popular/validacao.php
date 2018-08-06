<?php

  session_start();
  
  if ( ! isset( $_SESSION["login"] ) )
     header("location: index.php?mensagem=VOCÊ NÃO TEM AUTORIZAÇÃO PARA ACESSAR ESTA PÁGINA");
  
  $login = $_SESSION["login"];

?>
