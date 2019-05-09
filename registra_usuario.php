<?php

    require_once ('db.class.php');

    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    $objDb = new Db();
    $conn = $objDb->conecta_mysql();

    $usuario_existe = false;
    $email_existe = false;

    $sql = "SELECT usuario FROM usuarios WHERE usuario='$usuario'";
    $exec = mysqli_query($conn, $sql);
    if ($exec) {

        $dados = $exec->fetch_array();
        if(isset($dados['usuario'])) {
            $usuario_existe = true;
        } 

    } else {
        echo 'Erro de SQL ao localizar registro de usuário';
    }

    $sql = "SELECT email FROM usuarios WHERE email='$email'";
    $exec = mysqli_query($conn, $sql);
    if ($exec) {

        $dados = $exec->fetch_array();
        if(isset($dados['email'])) {
            $email_existe = true;
        }

    } else {
        echo 'Erro de SQL ao localizar registro de email';
    }

    if ($usuario_existe || $email_existe) {

        $retorno_get = '';

        if ($usuario_existe) {
            $retorno_get .= 'erro_usuario=1&';
        }

        if ($email_existe) {
            $retorno_get .= 'erro_email=1&';
        }

        header('Location: inscrevase.php?'.$retorno_get);
        die();
    }

    $sql = "INSERT INTO usuarios (usuario, email, senha) VALUES ('$usuario','$email','$senha')";
    echo (mysqli_query($conn, $sql)) ? 'Usuário inserido com sucesso' : 'Erro ao inserir usuário';

?>