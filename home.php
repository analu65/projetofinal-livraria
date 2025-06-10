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
                <form action="home.php" method="get">
                    <input type="text" name="q" placeholder="Buscar por livro, autor ou editora..." required>
                    <input type="submit" value="Ir" class="botao">
                </form>
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
$busca = isset($_GET['q']) ? trim($_GET['q']) : '';

    if (!empty($busca)) {
        $busca = mysql_real_escape_string($busca); // certo para mysql antigo

        $sql = "
            SELECT livro.*, autor.nome AS autor_nome, editora.nome AS editora_nome 
            FROM livro
            JOIN autor ON livro.codautor = autor.codigo
            JOIN editora ON livro.codeditora = editora.codigo
            WHERE livro.titulo LIKE '%$busca%'
            OR autor.nome LIKE '%$busca%'
            OR editora.nome LIKE '%$busca%'
        ";

        $result = mysql_query($sql);

        if (mysql_num_rows($result) > 0) {
            echo "<div class='titulo-menor'>Resultados para: <em>" . htmlspecialchars($busca) . "</em></div>";
            echo "<div class='livroscontainer'>";
            while ($livro = mysql_fetch_assoc($result)) {
                echo "<div class='livroscard'>";
                echo "<img src='fotos/{$livro['fotocapa1']}' width='120' height='180'>";
                echo "<h3>{$livro['titulo']}</h3>";
                echo "<p>{$livro['autor_nome']}</p>";
                echo "<p>{$livro['editora_nome']}</p>";
                echo "<p class='preco'>R$ {$livro['preco']}</p>";
                echo '<button class="botaocomprar" type="submit">Comprar</button>';
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>Nenhum resultado encontrado para <strong>" . htmlspecialchars($busca) . "</strong>.</p>";
        }
        }
        ?>
    <div class="slider">
        <input type="radio" name="slider" id="slide1" checked>
        <input type="radio" name="slider" id="slide2">
        <input type="radio" name="slider" id="slide3">
        <input type="radio" name="slider" id="slide4">

        <div class="slides">
            <div class="slide"><img src="fotosprodutos/slider1real.jpg" alt="Slide 1"></div>
            <div class="slide"><img src="fotosprodutos/slider1.png" alt="Slide 2"></div>
            <div class="slide"><img src="fotosprodutos/slider2.jpg" alt="Slide 3"></div>
            <div class="slide"><img src="fotosprodutos/slider4.png" alt="Slide 4"></div>
        </div>

        <div class="controls">
            <label for="slide1"></label>
            <label for="slide2"></label>
            <label for="slide3"></label>
            <label for="slide4"></label>
        </div>
        </div>

        <script>
            const radios = document.querySelectorAll('input[name="slider"]');
            let current = 0;
            const total = radios.length;

            function nextSlide() {
            current = (current + 1) % total;
            radios[current].checked = true;
            }

            setInterval(nextSlide, 6000);

            radios.forEach((radio, index) => {
            radio.addEventListener('change', () => {
                current = index;
            });
            });
        </script>
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