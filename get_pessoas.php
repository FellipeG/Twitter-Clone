<?php

    session_start();

    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php?erro=1');
        die();
    }

    require_once('db.class.php');

    $objDb = new Db();

    $conn = $objDb->conecta_mysql();

    $nome_pessoa = (isset($_POST['nome_pessoa'])) ? $_POST['nome_pessoa'] : '';

    if (!empty($nome_pessoa)) {
        $sql = "SELECT * FROM usuarios WHERE usuario LIKE '%$nome_pessoa%' AND id <> $_SESSION[id]";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            if ($query->num_rows > 0) {
                while ($linha = $query->fetch_array(MYSQLI_ASSOC)){
                    echo '<a href="#" class="list-group-item">';
                    echo "<strong>$linha[usuario]</strong> <small> - $linha[email]</small>";
                    echo '<p class="list-group-item-text pull-right">';
                    echo "<button id='btn_seguir$linha[id]' class='btn btn-default btn_seguir' data-id_usuario='$linha[id]'>Seguir</button>";
                    echo "<button style='display: none;' id='btn_deixarDeSeguir$linha[id]' class='btn btn-primary btn_deixarDeSeguir' data-id_usuario='$linha[id]'>Deixar de seguir</button>";
                    echo '</p>';
                    echo '<div class="clearfix"></div>';
                    echo '</a>';
                }
            } else {
                echo '<center>Nenhum usuário encontrado com base na sua pesquisa.</center>';
            }
        } else {
            echo '<center>Erro de SQL na consulta.</center>';
        }
    } else {
        echo '<center>O parâmetro "nome" não pode ficar vazio.</center>';
    }

    ?>