<?php
    include_once("validacao.php");
    include_once("conexao.php");
    include_once("funcoes.php");
    
    $mensagem = "";
    
    //Passo 1 - Uma variavel para cada campo da tabela.
    $id_prioridade = "";
    $descr_prioridade = "";
    $id_area = "";
    
    if ( ! isset($_POST["acao"]) )
        $descr_acao = "INCLUIR";
    else {
        $acao = $_POST["acao"];
        
        if (strtoupper($acao) == "INCLUIR" || strtoupper($acao) == "SALVAR") {
            
            $id_prioridade = mysqli_real_escape_string($bd, $_POST["id_prioridade"]);
            $descr_prioridade = mysqli_real_escape_string($bd, $_POST["descr_prioridade"]);
            $id_area = mysqli_real_escape_string($bd, $_POST["id_area"]);
        }  
        
        if (strtoupper($acao) == "INCLUIR") {
            
            $sql = "insert into prioridades (descr_prioridade, id_area) 
                    values ('$descr_prioridade', $id_area)";
            
            if (! mysqli_query($bd, $sql)) {
               
                $mensagem = "<h3>OCORREU UM ERRO AO INSERIR OS DADOS</h3>
                                <h3>Erro: ".mysqli_error($bd)."</h3>
                                <h3>Erro: $sql</h3>
                                <h3>Código: ".mysqli_errno($bd)."</h3>";
                
                $descr_acao = "INCLUIR";
            } else {
                $descr_acao = "SALVAR";
                
                $id_prioridade = mysqli_insert_id($bd);
            }
        }
        
        if (strtoupper($acao) == "SALVAR") {
            
            $descr_acao = "SALVAR";
            
            $sql = " update prioridades
                     set
                        descr_prioridade = '$descr_prioridade',
                        id_area = $id_area
                     where
                        id_prioridade = $id_prioridade";
            
            if ( ! mysqli_query($bd, $sql) ){
                $mensagem = "<h3>Ocorreu um erro ao alterar os dados</h3>
                <h3>".mysqli_error($bd)."</h3>".$sql."<h4>".mysqli_errno($bd)."</h4>";
            }
        }
        
        if (strtoupper($acao) == "EXCLUIR") {
            
            $id_prioridade = $_POST["id_prioridade"];
            
            $descr_acao = "INCLUIR";
            
            $sql = "delete from prioridades where id_prioridade = $id_prioridade";
            
            mysqli_query($bd, $sql);
            
            $id_prioridade = "";       
        }
        
        if (strtoupper($acao) == "BUSCAR") {
            
            $id_prioridade = $_POST["id_prioridade"];
            
            $descr_acao = "SALVAR";
            
            $sql = "select id_prioridade, descr_prioridade, id_area
                    from prioridades
                    where id_prioridade = $id_prioridade"; 
            
            $resultado = mysqli_query($bd, $sql);
            
            if (mysqli_num_rows($resultado) == 1) {
                
                $dados = mysqli_fetch_assoc($resultado);
                
                $id_prioridade = $dados["id_prioridade"];
                $descr_prioridade = $dados["descr_prioridade"];
                $id_area = $dados["id_area"];
                
            }
        }
    }

        $sql_listar = "select 
                            p.id_prioridade, p.descr_prioridade, 
                            a.id_area, a.descr_area 
                       from 
                            prioridades p, areas a
                       where 
                            p.id_area = a.id_area
                       order by 
                            descr_prioridade";
        
        $lista = mysqli_query($bd, $sql_listar);
        
        if (mysqli_num_rows($lista) > 0) {
            
            $tabela = "<table class='cadtable'>";
            $tabela = $tabela."<tr><th>Código</th><th>Prioridade</th><th>Área</th><th>Alterar</th><th>Excluir</th></tr>";
            
            while ( $dados = mysqli_fetch_assoc($lista) ) {
                
                $vid_prioridade = $dados["id_prioridade"];
                $vdescr_prioridade = $dados["descr_prioridade"];
                $vid_area = $dados["id_area"];
                $vdescr_area = $dados["descr_area"];
                
                
                $alterar = "<form class='formcad' method='POST'>
                                <input type='hidden' name='id_prioridade' value='$vid_prioridade'>
                                <input type='hidden' name='acao' value='BUSCAR'>
                                <input type='image' src='./imagens/alterar.png'>
                            </form>";
                
                $excluir = "<form class='formcad' method='POST'>
                                <input type='hidden' name='id_prioridade' value='$vid_prioridade'>
                                <input type='hidden' name='acao' value='EXCLUIR'>
                                <input type='image' src='./imagens/excluir.png'>
                            </form>";
                
                $tabela = $tabela."<tr><td>$vid_prioridade</td><td>$vdescr_prioridade</td><td>$vdescr_area</td><td>$alterar</td><td>$excluir</td></tr>";    
            }
                
            $tabela = $tabela."</table>";
            
        } else
            $tabela = "Não há dados para listar."; 
?>

<html>

<head>
	<title>Cadastro de Prioridades</title>
	<meta charset="utf-8" />
    <link href="estilos.css" rel="stylesheet">
</head>

<body>
    <center>
	<h3>CADASTRO DE PRIORIDADES</h3>
    
    <?php echo $mensagem ?>

    <fieldset class="fieldcad1">
        <legend><h5>DADOS DA PRIORIDADE</h5></legend>
        
        <form action="cad_prioridades.php" method="post">
            <input class="cadcampo" type="hidden" name="id_prioridade" value="<?php echo $id_prioridade;?>"><br><br>
            Descrição da Prioridade<br><input class="cadcampo" type="text" name="descr_prioridade" value="<?php echo $descr_prioridade;?>"><br><br>
            Área<br><select class="cadcampo" name="id_area">
            <?php
            echo montaSelectBD($bd, "select id_area, descr_area from areas order by descr_area", $id_area, false);
            ?>
            </select>
            <br><br>
            <input type="submit" class="cadbotao" value="NOVO">
            <input type="submit" name="acao" class="cadbotao" value="<?php echo $descr_acao; ?>">
        </form>
    </fieldset>
    
    <fieldset class="fieldcad3">
        <legend><h5>PRIORIDADES CADASTRADAS</h5></legend>
        
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