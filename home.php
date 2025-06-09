<?php
$conectar = mysql_connect('localhost', 'root', '', 'livraria');
mysql_set_charset('utf8', $conectar);
$db = mysql_select_db('livraria')
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <div class="layout">
            <nav>
                <img src="fotos/logo-livraria-cultura.webp" height="78" width="78">
                    <div class="pesquisa">
                <input type="text" size="65" name="nome_livro" placeholder="Pesquisar">
                <input type="submit" name="ir" value="Ir" class="botao">
                </div>
                <div class="separador"></div>
                <div class="login">
                    <img src="fotos/usuario.png" height="40" width="40">
                    <a href="login.html" class="botaocabecalho"><b>Bem vindo(a)</b><br>Faça seu Login</a>
                </div>
                <div class="separador"></div>
                <img src="fotos/icone-de-panier-gris.png" height="40" width="40">
            </nav>
        </div>
    </header>
    <div class="linha">
    <br>
    <div id="principal">
    <aside class="sidebar">
        <div class="titulo-menor">Pesquisar por:</div>
        <form name="formulario" method="post" action="home.php">
            <div class="categoria-checkboxes">
                <?php
                $query = mysql_query("SELECT codigo, nome from categoria");
                while($categorias = mysql_fetch_array($query)) { ?>
                    <div class="checkbox-item">
                        <input type="checkbox" 
                               name="categoria[]" 
                               value="<?php echo $categorias['codigo']?>" 
                               id="cat_<?php echo $categorias['codigo']?>">
                        <label for="cat_<?php echo $categorias['codigo']?>">
                            <?php echo $categorias['nome']?>
                        </label>
                    </div>
                <?php } ?>
            </div>
            <input type="submit" name="buscar" value="Buscar">
        </form>
    </aside>
    
    <main class="conteudo">
        <?php
        if(isset($_POST['buscar'])) {
            $categorias_selecionadas = isset($_POST['categoria']) ? $_POST['categoria'] : array();
            
            if (!empty($categorias_selecionadas)) {
                $categorias_limpa = array_map('intval', $categorias_selecionadas);
                $categorias_string = implode(',', $categorias_limpa);
                
                $sql_produtos = "SELECT livro.codigo, livro.titulo, livro.nrpaginas, livro.ano, 
                                livro.resenha, livro.preco, livro.fotocapa1, livro.fotocapa2, 
                                autor.nome AS nome_autor, editora.nome AS nome_editora 
                                FROM livro 
                                JOIN categoria ON livro.codcategoria = categoria.codigo 
                                JOIN autor ON livro.codautor = autor.codigo 
                                JOIN editora ON livro.codeditora = editora.codigo 
                                WHERE categoria.codigo IN ($categorias_string)";
                
                $seleciona_produtos = mysql_query($sql_produtos);
                
                if(mysql_num_rows($seleciona_produtos) == 0) {
                    echo '<h1>Desculpe, mas sua busca não retornou resultados...</h1>';
                } else {
                    echo "<div class='titulo-menor'>RESULTADOS <br><br></div>";
                    echo "<div class='livroscontainer'>";
                    
                    while ($dados = mysql_fetch_object($seleciona_produtos)) {
                        echo "<div class='livroscard'>";
                        echo "<img src='fotos/$dados->fotocapa1' width='120' height='180'>";
                        echo "<h3>$dados->titulo</h3>";
                        echo "<p>$dados->nome_autor</p>";
                        echo "<p>$dados->nome_editora</p>";
                        echo "<p class='preco'>R$ $dados->preco</p>";
                        echo '<button class="botaocomprar" type="submit">Comprar</button>';
                        echo "</div>";
                    }
                    echo "</div>";
                }
            } else {
                echo '<h1>Por favor, selecione pelo menos uma categoria.</h1>';
            }
        }
        ?>
   </main>
</div>
</body>
</html>