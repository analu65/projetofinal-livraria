<?php
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db('livraria');

if(isset($_POST['gravar'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];
    $pais = $_POST['pais'];
    $sql = "insert into autor (codigo, nome, pais) values ('$codigo', '$nome', '$pais')";
    $resultado = mysql_query($sql);
    if($resultado == TRUE) {
        echo "Dados cadastrados com sucesso.";
    }
    else {
        echo "erro ao gravar os dados";
    }
    }
    if(isset($_POST['excluir'])) {
        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];
        $sql = "delete from autor where codigo = '$codigo'";
        $resultado = mysql_query($sql);
        if ($resultado == TRUE) {
            echo "dados excluidos com sucesso.";
        }
        else {
            echo "erro ao excluir os dados.";
        }
    }

    if(isset($_POST['alterar'])) {
        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];
    
        $sql = "UPDATE autor SET nome = '$nome' WHERE codigo = '$codigo'";
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