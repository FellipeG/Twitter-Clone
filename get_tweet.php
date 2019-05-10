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

    $sql = "SELECT DATE_FORMAT(t.data_inclusao, '%d %b %Y %T') AS data_inclusao_f, t.tweet, u.usuario FROM tweet t INNER JOIN usuarios u ON t.id_usuario = u.id WHERE t.id_usuario=$id_usuario ORDER BY t.data_inclusao DESC";
    $query = mysqli_query($conn, $sql);
    if ($query) {

        while ($linha = $query->fetch_array(MYSQLI_ASSOC)){
           
            echo '<a href="#" class="list-group-item">';
            echo "<h4 class='list-group-item-heading'>$linha[usuario] <small>$linha[data_inclusao_f]</small></h4>";
            echo "<p>$linha[tweet]</p>";
            echo '</a>';
        }

    } else {
        echo 'Erro de SQL';
    }




?>