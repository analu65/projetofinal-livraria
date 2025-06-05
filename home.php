<?php
$conectar = mysql_connect('localhost', 'root', '', 'livraria');
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
                <button class="botao">Buscar</button>
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
            <div class="titulo-sidebar">Menu</div>
            <div class="titulo-menor">Pesquisar por:</div>
            <form name="formulario" method="post" action="home.php">
            <select name="categoria">
                <option value="" selected="selected"> Categoria
                </option>
                <?php
            $query = mysql_query("SELECT codigo, nome from categoria");
            while($categorias = mysql_fetch_array($query)) { ?>
                <option value="<?php echo $categorias['codigo']?>">
                    <?php echo $categorias['nome']?>
                </option>
            <?php } ?>
            </select>
            <input type="submit" name="buscar" value="Buscar">
        </aside>
        <main class="conteudo">
        <div id="slider" style="width:850px; height:260px; overflow:hidden;">
            <img id="slideImg" src="fotosprodutos/slider1real.jpg" width="850" height="260" alt="slide">
            </div>

            <script>
            const images = [
                'fotosprodutos/slider1real.jpg',
                'fotosprodutos/slider4.png',
                'fotosprodutos/slider2.jpg'
            ];
            let current = 0;
            const slideImg = document.getElementById('slideImg');

            setInterval(() => {
                current = (current + 1) % images.length;
                slideImg.src = images[current];
            }, 5000);
            </script>
        <?php
        if(isset($_POST['buscar'])) {
            $categoria      = (empty($_POST['categoria']))? 'null' : $_POST['categoria'];

            if ($categoria <> 'null')
            {
                $sql_produtos = "SELECT livro.codigo, livro.titulo, livro.nrpaginas, livro.ano, livro.resenha, livro.preco, livro.fotocapa1, livro.fotocapa2, autor.nome AS nome_autor, editora.nome AS nome_editora FROM livro JOIN categoria ON livro.codcategoria = categoria.codigo JOIN autor ON livro.codautor = autor.codigo JOIN editora ON livro.codeditora = editora.codigo WHERE categoria.codigo = '$categoria' ";

                $seleciona_produtos = mysql_query($sql_produtos);
            }
            if(mysql_num_rows($seleciona_produtos) == 0)
            {
                echo '<h1>Desculpe, mas sua busca nao retornou resultados ... </h1>';
            }
            else
            {
                echo " <div class='titulo-sidebar'>RESULTADOS <br><br></div>";
                echo "<div class='livroscontainer'>";
                while ($dados = mysql_fetch_object($seleciona_produtos))
                {
                    echo "<div class='livroscard'>";
                    echo "<img src='fotos/$dados->fotocapa1' width= '120' height= '180' >";
                    echo "<h3>$dados->titulo</h3>";
                    echo "<p> $dados->nome_autor</p>";
                    echo "<p> $dados->nome_editora</p>";
                    echo "<p class='preco'>R$ $dados->preco</p>";
                    echo '<button class="botaocomprar" type="submit">Comprar</button>';
                    echo "</div>";
                    echo "</div>";
                    
                }
                }
            }

        ?>
        </main>
</div>
    </div>

</body>
</html> 