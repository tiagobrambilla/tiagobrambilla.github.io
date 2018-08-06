<?php
   include_once("validacao.php");
   include_once("conexao.php");
?>

<html >

<head>
	<title>Apuração</title>
	<meta charset="utf-8" />
    <link href="estilos.css" rel="stylesheet">
</head>

<body>
    <center>
	<h3>APURAÇÃO DA VOTAÇÃO</h3>
	
	<?php
	
	$sqlTotal = "select count(*) as total from votos";
	
	$resultado = mysqli_query($bd, $sqlTotal);
	
	$dados = mysqli_fetch_assoc($resultado);
	
	$total = $dados["total"];
	
	if ($total > 0) {
		
		$sql = "SELECT a.descr_area, p.descr_prioridade, COUNT( * ) AS votos
                FROM prioridades p, areas a, votos v
                WHERE p.id_area = a.id_area and p.id_prioridade = v.id_prioridade
                GROUP BY a.descr_area, p.descr_prioridade";
           
        $resultado = mysqli_query($bd, $sql);
        
        while ( $dados = mysqli_fetch_assoc($resultado)) {
			
			$perc = ($dados["votos"] / $total) * 100;
			
			echo "<fieldset class='fieldapuracao'>".$dados["descr_prioridade"]." - ".$dados["votos"]." votos (".round($perc,2)."%)</fieldset>";
			
		}
		
	} else {

		echo "<h5>NÃO EXISTEM VOTOS</h5>";
	}
	
	mysqli_close($bd);
	
	?>

	<br><br>

	<a href="menu.php"><img class="backimg" src="imagens/voltar.png"></a>
    </center>
	
</body>

</html>
