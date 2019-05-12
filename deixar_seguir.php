<?php

    session_start();

    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php?erro=1');
        die();
    }

    require_once('db.class.php');

    $objDb = new Db();

    $conn = $objDb->conecta_mysql();

    $id_usuario = (isset($_POST['id_usuario'])) ? $_POST['id_usuario'] : 0;

    if ($id_usuario) {
        $sql = "DELETE FROM seguidores WHERE id_seguidor=$_SESSION[id] AND id_seguido=$id_usuario";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            echo 'Você deixou de seguir este usuário!';
        } else {
            echo 'Erro de SQL no delete.';
        }
    } else {
        echo 'O parâmetro "id_usuario" não pode ficar vazio.';
    }

    ?>