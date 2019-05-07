<?php

    require_once ('db.class.php');

    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    $objDb = new Db();
    $conn = $objDb->conecta_mysql();

    $sql = "INSERT INTO usuario (usuario, email, senha) VALUES ('$usuario','$email','$senha')";
    echo (mysqli_query($conn, $sql)) ? 'Usuário inserido com sucesso' : 'Erro ao inserir usuário';

?>