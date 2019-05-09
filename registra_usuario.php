<?php

    require_once ('db.class.php');

    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    $objDb = new Db();
    $conn = $objDb->conecta_mysql();

    $sql = "SELECT usuario FROM usuarios WHERE usuario='$usuario'";
    $exec = mysqli_query($conn, $sql);
    if ($exec) {

        $dados = $exec->fetch_array();
        if(isset($dados['usuario'])) {
            echo 'Esse nome de usuário já existe, utilize outro.';
        } else {
            echo 'Usuário ok.';
        }

    } else {
        echo 'Erro de SQL ao localizar registro de usuário';
    }

    $sql = "SELECT email FROM usuarios WHERE email='$email'";
    $exec = mysqli_query($conn, $sql);
    if ($exec) {

        $dados = $exec->fetch_array();
        if(isset($dados['email'])) {
            echo 'Esse email já existe, utilize outro.';
        } else {
            echo 'Email ok.';
        }

    } else {
        echo 'Erro de SQL ao localizar registro de email';
    }

    die();

    $sql = "INSERT INTO usuarios (usuario, email, senha) VALUES ('$usuario','$email','$senha')";
    echo (mysqli_query($conn, $sql)) ? 'Usuário inserido com sucesso' : 'Erro ao inserir usuário';

?>