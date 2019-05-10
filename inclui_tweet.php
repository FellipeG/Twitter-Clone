<?php

    session_start(); 

    require_once('db.class.php');

    $id = (isset($_SESSION['id'])) ? $_SESSION['id'] : 0;
    if ($id == 0) {
        echo 'Usuário não está logado!';
        die();
    }

    $texto_tweet = (isset($_POST['texto_tweet'])) ? $_POST['texto_tweet'] : '';

    $objDb = new Db();
    $conn = $objDb->conecta_mysql();

    if (!empty($texto_tweet)) {

        $sql = "INSERT INTO tweet (id_usuario, tweet) VALUES ($id, '$texto_tweet')";

        $inserir = mysqli_query($conn, $sql);

        echo ($inserir) ? 'Tweet inserido com sucesso!' : 'Erro ao inserir Tweet';

    }

?>