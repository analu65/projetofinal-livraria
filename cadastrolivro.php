<?php
$conectar = mysql_connect('localhost','root','');
$banco    = mysql_select_db("livraria");

if (isset($_POST['gravar'])) {
    $codigo       = $_POST['codigo'];
    $titulo       = $_POST['titulo'];
    $nrpaginas    = $_POST['nrpaginas'];
    $ano          = $_POST['ano'];
    $codautor     = $_POST['codautor'];
    $codcategoria = $_POST['codcategoria'];
    $codeditora   = $_POST['codeditora'];
    $resenha      = $_POST['resenha'];
    $preco        = $_POST['preco'];

    $diretorio = "fotos/";
    $novo_nome1 = '';
    $novo_nome2 = '';

    if (isset($_FILES['fotocapa1']) && $_FILES['fotocapa1']['error'] == UPLOAD_ERR_OK) {
        $extensao1 = strtolower(pathinfo($_FILES['fotocapa1']['name'], PATHINFO_EXTENSION));
        $novo_nome1 = md5(time() . $_FILES['fotocapa1']['name']) . '.' . $extensao1;
        move_uploaded_file($_FILES['fotocapa1']['tmp_name'], $diretorio . $novo_nome1);
    }

    if (isset($_FILES['fotocapa2']) && $_FILES['fotocapa2']['error'] == UPLOAD_ERR_OK) {
        $extensao2 = strtolower(pathinfo($_FILES['fotocapa2']['name'], PATHINFO_EXTENSION));
        $novo_nome2 = md5(time() . $_FILES['fotocapa2']['name']) . '.' . $extensao2;
        move_uploaded_file($_FILES['fotocapa2']['tmp_name'], $diretorio . $novo_nome2);
    }

    $sql = "INSERT INTO livro (codigo, titulo, nrpaginas, ano, codautor, codcategoria, codeditora, resenha, preco, fotocapa1, fotocapa2)
            VALUES ('$codigo', '$titulo', '$nrpaginas', '$ano', '$codautor', '$codcategoria', '$codeditora', '$resenha', '$preco', '$novo_nome1', '$novo_nome2')";

    $resultado = mysql_query($sql);

    if ($resultado) {
        echo "Dados informados cadastrados com sucesso";
    } else {
        echo "Falha ao gravar os dados informados" . mysql_error();
    }
}
if (isset($_POST['excluir']))
{
     $codigo       = $_POST['codigo'];
     $titulo       = $_POST['titulo'];
     $nrpaginas    = $_POST['nrpaginas'];
     $ano          = $_POST['ano'];
     $codautor     = $_POST['codautor'];
     $codcategoria = $_POST['codcategoria'];
     $codeditora   = $_POST['codeditora'];
     $resenha      = $_POST['resenha'];
     $preco        = $_POST['preco'];

  $sql = "DELETE FROM livro WHERE codigo = '$codigo'";

  $resultado = mysql_query($sql);

  if ($resultado === TRUE)
  {
     echo 'Exclusao realizada com Sucesso';
  }
  else
  {
     echo 'Erro ao excluir dados.';
  }
}
if(isset($_POST['alterar'])) {
     $codigo       = $_POST['codigo'];
     $titulo       = $_POST['titulo'];
     $nrpaginas    = $_POST['nrpaginas'];
     $ano          = $_POST['ano'];
     $codautor     = $_POST['codautor'];
     $codcategoria = $_POST['codcategoria'];
     $codeditora   = $_POST['codeditora'];
     $resenha      = $_POST['resenha'];
     $preco        = $_POST['preco'];
 
     $sql = "UPDATE livro SET titulo = '$titulo', preco = '$preco' WHERE codigo = '$codigo'";
     $resultado = mysql_query($sql);
 
     if ($resultado === TRUE)
   {
      echo 'Dados alterados com Sucesso';
   }
   else
   {
      echo 'Erro ao alterar dados.';
   }
 }
?>
