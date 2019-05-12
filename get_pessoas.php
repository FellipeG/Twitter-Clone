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

        $sql = "SELECT u.*, S.* FROM usuarios u LEFT JOIN seguidores s
                ON (s.id_seguidor=$_SESSION[id] AND u.id = s.id_seguido)
                WHERE u.usuario LIKE '%$nome_pessoa%' 
                AND u.id <> $_SESSION[id] ORDER BY s.id_seguidor DESC";

        $query = mysqli_query($conn, $sql);
        if ($query) {
            if ($query->num_rows > 0) {
                while ($linha = $query->fetch_array(MYSQLI_ASSOC)){
                    if ((isset($linha['id_seguido'])) && (!empty($linha['id_seguido']))) {
                        $btn_seguir = "display: none;";
                        $btn_deixar_seguir = "display: inline-block;;";
                    } else {
                        $btn_seguir = "display: inline-block;;";
                        $btn_deixar_seguir = "display: none;";
                    }
                    echo '<a href="#" class="list-group-item">';
                    echo "<strong>$linha[usuario]</strong> <small> - $linha[email]</small>";
                    echo '<p class="list-group-item-text pull-right">';
                    echo "<button style='$btn_seguir' id='btn_seguir$linha[id]' class='btn btn-default btn_seguir' data-id_usuario='$linha[id]'>Seguir</button>";
                    echo "<button style='$btn_deixar_seguir' id='btn_deixarDeSeguir$linha[id]' class='btn btn-primary btn_deixarDeSeguir' data-id_usuario='$linha[id]'>Deixar de seguir</button>";
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