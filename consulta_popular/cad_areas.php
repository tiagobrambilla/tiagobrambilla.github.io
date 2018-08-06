<?php
    include_once("validacao.php");
    include_once("conexao.php");
    
    $mensagem = "";

    $id_area = "";
    $descr_area = "";
    
    if ( ! isset($_POST["acao"]) )
        $descr_acao = "INCLUIR";
    else {
        $acao = $_POST["acao"];
        
        if (strtoupper($acao) == "INCLUIR" || strtoupper($acao) == "SALVAR") {
            
            $id_area = mysqli_real_escape_string($bd, $_POST["id_area"]);
            $descr_area = mysqli_real_escape_string($bd, $_POST["descr_area"]);
        }  
        
        if (strtoupper($acao) == "INCLUIR") {
            
            $sql = "insert into areas (descr_area) values ('$descr_area')";
            
            if (! mysqli_query($bd, $sql)) {
               
                $mensagem = "<h3>OCORREU UM ERRO AO INSERIR OS DADOS</h3>
                                <h3>Erro: ".mysqli_error($bd)."</h3>
                                <h3>Código: ".mysqli_errno($bd)."</h3>";
                
                $descr_acao = "INCLUIR";
            } else {
                $descr_acao = "SALVAR";
                
                $id_area = mysqli_insert_id($bd);
            }
        }
        
        if (strtoupper($acao) == "SALVAR") {
            
            $descr_acao = "SALVAR";
            
            $sql = " update areas
                     set
                        descr_area = '$descr_area'
                     where
                        id_area = '$id_area'";
            
            if ( ! mysqli_query($bd, $sql) ){
                $mensagem = "<h3>Ocorreu um erro ao alterar os dados</h3>
                <h3>".mysqli_error($bd)."</h3>".$sql."<h4>".mysqli_errno($bd)."</h4>";
            }
        }
        
        if (strtoupper($acao) == "EXCLUIR") {
            
            $id_area = $_POST["id_area"];
            
            $descr_acao = "INCLUIR";
            
            $sql = "delete from areas where id_area = '$id_area'";
            
            if ( ! mysqli_query($bd, $sql)) {
                if (mysqli_errno($bd) == 1451) {
                    $mensagem = "<h3>Não é possível excluir uma área enquanto houverem prioridades relacionadas a ela!</h3>";
                }
            }
            
            mysqli_query($bd, $sql);
            
            $id_area = "";       
        }
        
        if (strtoupper($acao) == "BUSCAR") {
            
            $id_area = $_POST["id_area"];
            
            $descr_acao = "SALVAR";
            
            $sql = "select id_area, descr_area
                    from areas
                    where id_area = '$id_area'"; 
            
            $resultado = mysqli_query($bd, $sql);
            
            if (mysqli_num_rows($resultado) == 1) {
                
                $dados = mysqli_fetch_assoc($resultado);
                
                $id_area = $dados["id_area"];
                $descr_area = $dados["descr_area"];
            }
        }
    }

        $sql_listar = "select id_area, descr_area from areas order by descr_area";
        
        $lista = mysqli_query($bd, $sql_listar);
        
        if (mysqli_num_rows($lista) > 0) {
            
            $tabela = "<table class='cadtable'>";
            $tabela = $tabela."<tr><th>Código</th><th>Área</th><th>Alterar</th><th>Excluir</th></tr>";
            
            while ( $dados = mysqli_fetch_assoc($lista) ) {
                
                $vid_area = $dados["id_area"];
                $vdescr_area = $dados["descr_area"];
                
                $alterar = "<form class='formcad' method='POST'>
                                <input type='hidden' name='id_area' value='$vid_area'>
                                <input type='hidden' name='acao' value='BUSCAR'>
                                <input type='image' src='./imagens/alterar.png'>
                            </form>";
                
                $excluir = "<form class='formcad' method='POST'>
                                <input type='hidden' name='id_area' value='$vid_area'>
                                <input type='hidden' name='acao' value='EXCLUIR'>
                                <input type='image' src='./imagens/excluir.png'>
                            </form>";
                
                $tabela = $tabela."<tr><td>$vid_area</td><td>$vdescr_area</td><td>$alterar</td><td>$excluir</td></tr>";    
            }
                
            $tabela = $tabela."</table>";
            
        } else
            $tabela = "Não há dados para listar."; 
?>

<html>

<head>
	<title>Cadastro de Áreas Prioritárias</title>
	<meta charset="utf-8" />
    <link href="estilos.css" rel="stylesheet">
</head>

<body>
    <center>
	<h3>CADASTRO DE ÁREAS PRIORITÁRIAS</h3>
    
    <?php echo $mensagem ?>

    <fieldset class="fieldcad1">
        <legend><h5>DADOS DA ÁREA</h5></legend>
        
        <form action="cad_areas.php" method="post">
            <input class="cadcampo" type="hidden" name="id_area" value="<?php echo $id_area; ?>"><br><br>
            Nome da Área<br><input class="cadcampo" type="text" name="descr_area" value="<?php echo $descr_area; ?>"><br><br>
            <br><br>
            <input type="submit" class="cadbotao" value="NOVO">
            <input type="submit" name="acao" class="cadbotao" value="<?php echo $descr_acao; ?>">
        </form>
    </fieldset>
    
    <fieldset class="fieldcad2">
        <legend><h5>ÁREAS CADASTRADAS</h5></legend>
        
        <?php echo "<center>$tabela</center>" ?>

    </fieldset>

	<br><br>
	<a href="menu.php"><img class="backimg" src="imagens/voltar.png"></a>
    </center>
</body>

</html>

<?php
  
  mysqli_close($bd);

?>