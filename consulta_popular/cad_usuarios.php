<?php
    include_once("validacao.php");
    include_once("conexao.php");
    
    $mensagem = "";

    $login = "";
    $nome = "";
    $senha = "";
    $tipo = "";
    
    // Essas variáveis servem para indicar qual dos dois radios estarão marcados
    $tAdm = "";
    $tEleitor = "";
    
    if ( ! isset($_POST["acao"]) )
        $descr_acao = "INCLUIR";
    else {
        $acao = $_POST["acao"];
        
        if (strtoupper($acao) == "INCLUIR" || strtoupper($acao) == "SALVAR") {
            
            $login = mysqli_real_escape_string($bd, $_POST["login"]);
            $nome = mysqli_real_escape_string($bd, $_POST["nome"]);
            $senha = mysqli_real_escape_string($bd, $_POST["senha"]);
            $tipo = mysqli_real_escape_string($bd, $_POST["tipo"]);   
        }  
        
        if (strtoupper($acao) == "INCLUIR") {
            
            $sql = "insert into usuarios (login, nome, senha, tipo)
                        values ('$login', '$nome', '$senha', '$tipo')";
            
            if (! mysqli_query($bd, $sql)) {
                if (mysqli_errno($bd) == 1062)
                    $mensagem = "O login informado '$login' já existe, tente outro!";
                else
                    $mensagem = "<h3>OCORREU UM ERRO AO INSERIR OS DADOS</h3>
                                <h3>Erro: ".mysqli_error($bd)."</h3>
                                <h3>Código: ".mysql_errno($bd)."</h3>";
                
                $descr_acao = "INCLUIR";
            } else
                $descr_acao = "SALVAR";
            
        }
        
        if (strtoupper($acao) == "SALVAR") {
            
            $descr_acao = "SALVAR";
            
            $sql = " update usuarios
                     set
                        nome = '$nome',
                        senha = '$senha',
                        tipo = '$tipo'
                     where
                        login = '$login' ";
            
            if ( ! mysqli_query($bd, $sql) ){
                $mensagem = "<h3>Ocorreu um erro ao alterar os dados</h3>
                <h3>".mysqli_error($bd)."</h3>".$sql."<h4>".mysqli_errno($bd)."</h4>";
            }
        }
        
        if (strtoupper($acao) == "EXCLUIR") {
            
            $login = $_POST["login"];
            
            $descr_acao = "INCLUIR";
            
            $sql = "delete from usuarios where login = '$login'";
            
            mysqli_query($bd, $sql);
            
            $login = "";       
        }
        
        if (strtoupper($acao) == "BUSCAR") {
            
            $login = $_POST["login"];
            
            $descr_acao = "SALVAR";
            
            $sql = "select login, nome, senha, tipo
                    from usuarios
                    where login = '$login'"; 
            
            $resultado = mysqli_query($bd, $sql);
            
            if (mysqli_num_rows($resultado) == 1) {
                
                $dados = mysqli_fetch_assoc($resultado);
                
                $login = $dados["login"];
                $nome = $dados["nome"];
                $senha = $dados["senha"];
                $tipo = $dados["tipo"];
            }
        }
    }

        if ($tipo == "A")
            $tAdm = "checked";
        else
            $tEleitor = "checked";

        $sql_listar = "select login, nome, tipo from usuarios order by nome";
        
        $lista = mysqli_query($bd, $sql_listar);
        
        if (mysqli_num_rows($lista) > 0) {
            
            $tabela = "<table class='cadtable'>";
            $tabela = $tabela."<tr><th>Login</th><th>Nome</th><th>Tipo</th><th>Alterar</th><th>Excluir</th></tr>";
            
            while ( $dados = mysqli_fetch_assoc($lista) ) {
                
                $vlogin = $dados["login"];
                $vnome = $dados["nome"];
                $vtipo = $dados["tipo"];
                
                $alterar = "<form class='formcad' method='POST'>
                                <input type='hidden' name='login' value='$vlogin'>
                                <input type='hidden' name='acao' value='BUSCAR'>
                                <input type='image' src='./imagens/alterar.png'>
                            </form>";
                
                $excluir = "<form class='formcad' method='POST'>
                                <input type='hidden' name='login' value='$vlogin'>
                                <input type='hidden' name='acao' value='EXCLUIR'>
                                <input type='image' src='./imagens/excluir.png'>
                            </form>";
                
                $tabela = $tabela."<tr><td>$vlogin</td><td>$vnome</td><td>$vtipo</td><td>$alterar</td><td>$excluir</td></tr>";    
            }
                
            $tabela = $tabela."</table>";
            
        } else
            $tabela = "não há dados para listar";
    


    
?>

<html>

<head>
	<title>Cadastro de Usuários</title>
	<meta charset="utf-8" />
    <link href="estilos.css" rel="stylesheet">
</head>

<body>
    <center>
	<h3>CADASTRO DE USUÁRIOS</h3>
    
    <?php echo $mensagem ?>

    <fieldset class="fieldcad1">
        <legend><h5>DADOS DO USUÁRIO</h5></legend>
        
        <form action="cad_usuarios.php" method="post">
            Login <input class="cadcampo" type="text" name="login" value="<?php echo $login; ?>"><br><br>
            Nome <input class="cadcampo" type="text" name="nome" value="<?php echo $nome; ?>"><br><br>
            Senha <input class="cadcampo" type="password" name="senha" value="<?php echo $senha; ?>"><br><br>
            Tipo: <input type="radio" name="tipo" value="E" <?php echo $tEleitor; ?>> Eleitor
                  <input type="radio" name="tipo" value="A" <?php echo $tAdm; ?>> Administrador
            <br><br>
            <input type="submit" class="cadbotao" value="NOVO">
            <input type="submit" name="acao" class="cadbotao" value="<?php echo $descr_acao; ?>">
        </form>
    </fieldset>
    
    <fieldset class="fieldcad2">
        <legend><h5>USUÁRIOS CADASTRADOS</h5></legend>
        
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
