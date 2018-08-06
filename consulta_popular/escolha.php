<?php

    include_once("validacao.php");
    include_once("funcoes.php");
    include_once("conexao.php");


    if ( isset($_POST["area"] ) )
        $area = $_POST["area"];
    else
        header("location: area.php");
      

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
    <form action="voto.php" method="post">
        <?php echo"<input type='text' disabled class='visitante' value='$login'>"?>
        <fieldset class="fieldescolha">
            <legend><h5>ESCOLHA A SUA PRIORIDADE</h5></legend>
            <br>
            <select class="select" name="prioridade">
                <?php 
                    echo montaSelectBD($bd, "select id_prioridade, descr_prioridade 
                                             from prioridades where id_area = $area", "", false);
        
                    mysqli_close($bd);
                ?>
            </select>
            <br><br>
            <input class="botao" type="submit" value="OK">
        </fieldset>
    </form>
    </center>	
	
</body>

</html>
