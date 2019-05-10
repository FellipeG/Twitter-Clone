<?php

    session_start();

    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php?erro=1');
        die();
    }

    require_once('db.class.php');

    $objDb = new Db();
    $conn = $objDb->conecta_mysql();

    $id_usuario = $_SESSION['id'];

    $sql = "SELECT * FROM tweet WHERE id_usuario=$id_usuario ORDER BY data_inclusao DESC";
    $query = mysqli_query($conn, $sql);
    if ($query) {

        $arr = array();

        while ($linha = $query->fetch_array(MYSQLI_ASSOC)){
            $arr[] = $linha;
        }

        if (count($arr) != 0) {
            foreach ($arr AS $tweet) {
                $data =  date("d-m-Y H:i:s", strtotime($tweet['data_inclusao']));
                echo "<p>$data<hr />$tweet[tweet]</p>";
            }
        }

    } else {
        echo 'Erro de SQL';
    }




?>