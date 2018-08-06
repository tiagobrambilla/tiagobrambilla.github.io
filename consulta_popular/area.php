<?php
    include_once("validacao.php");
    include_once("funcoes.php");
    include_once("conexao.php");
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

    <form action="escolha.php" method="post">
        <?php echo"<input type='text' disabled class='visitante' value='$login'>"?>
        <fieldset class="fieldarea">
            <legend><h5>ESCOLHA A ÁREA PRIORITÁRIA</h5></legend>
            <br>
            <select class="select" name="area">
                <?php
                    echo montaSelectBD($bd, "select id_area, descr_area from areas order by descr_area", "", false);
        
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
