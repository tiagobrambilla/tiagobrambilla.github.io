<?php

  $msg = "";

  if ( isset( $_GET["mensagem"] ) )
    $msg = $_GET["mensagem"];
    
    
  $num = 1;

  if ( isset( $_COOKIE["visitas"] ) ) {
     $num = $_COOKIE["visitas"];
     $num = $num + 1;
  }
  
  //setCookie("visitas"); //se você não passar o valor, o COOKIE será excluído
  
  //setCookie("visitas", $num);
  
  date_default_timezone_set('America/Sao_Paulo');
  
  setCookie("visitas", $num, time() + 21 * 60 * 60);
  
  
?>

<html>
<head>
	<title>Consulta Popular</title>
	<meta charset="utf-8" />
    <link href="estilos.css" rel="stylesheet">
</head>
<body>

   <center>
   <table class="logo">
        <tr>
            <td><img src="imagens/consulta.png"></td>
        </tr>
    </table>
    </center>
    <form action="login.php" method="post">
        <center>
        <fieldset>
            <legend><h5>IDENTIFIQUE-SE</h5></legend>
            Login<br>
            <input class="login" type="text" name="login">
            <br><br>
            Senha<br>
            <input class="senha" type="password" name="senha">
            <br><br>
            <input class="botao" type="submit" value="OK">
        </fieldset>
        </center>
        <?php   
            echo "<input type='text' disabled class='alerta' value='$msg'>";
            
            echo "<input type='text' disabled class='visita' value='VISITA DE NÚMERO $num'>";
        ?>
        
        
    </form>
   
   	
</body>

</html>
