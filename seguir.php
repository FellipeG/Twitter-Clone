<?php

    session_start();

    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php?erro=1');
        die();
    }

    require_once('db.class.php');

    $objDb = new Db();

    $conn = $objDb->conecta_mysql();

    $id_seguido = (isset($_POST['id_seguido'])) ? $_POST['id_seguido'] : 0;

    if ($id_seguido) {
        $sql = "INSERT INTO seguidores (id_seguidor, id_seguido) VALUES ($_SESSION[id], $id_seguido)";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            echo 'Seguido com sucesso!';
        } else {
            echo 'Erro de SQL no insert.';
        }
    } else {
        echo 'O parâmetro "id_seguido" não pode ficar vazio.';
    }

    ?>