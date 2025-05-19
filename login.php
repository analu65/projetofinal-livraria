<?php
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db('livraria');

if(isset($_POST['gravar'])) {
    $codigo = $_POST['codigo'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $sql = "insert into usuario (codigo, login, senha) values ('$codigo', '$login', '$senha')";
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
        $login = $_POST['login'];
        $senha = $_POST['senha'];
        $sql = "delete from usuario where codigo = '$codigo'";
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
        $login = $_POST['login'];
        $senha = $_POST['senha'];
    
        $sql = "UPDATE usuario SET senha = '$senha' WHERE codigo = '$codigo'";
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