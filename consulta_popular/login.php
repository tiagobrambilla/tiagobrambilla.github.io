<?php
   include_once("validacao.php");
   include_once("funcoes.php");
   include_once("conexao.php");
   
   if ( isset($_POST["login"]) )
      $login = $_POST["login"];
   else
      $login = "";
   
   if ( isset($_POST["senha"]) )
      $senha = $_POST["senha"];
   else
      $senha = "";

   $sql = "select tipo from usuarios where login = '$login' and senha = '$senha' ";

   $resultado = mysqli_query($bd,$sql);

   if ( mysqli_num_rows($resultado) == 1 ) {

      $dados = mysqli_fetch_assoc($resultado);

      $tipo = $dados["tipo"];

      session_start();
        
      $_SESSION["login"] = $login;
      $_SESSION["hora"] = time();

      if ($tipo == "A") 
            header("location: menu.php");
        else
            header("location: area.php");
      
   }else 
       header("location: index.php?mensagem=SENHA OU LOGIN INCORRETOS!");
     

?>


















