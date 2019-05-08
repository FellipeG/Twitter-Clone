<?php

    require_once ('db.class.php');

    $usuario = $_POST['usuario'];
    $senha = md5($_POST['senha']);

    $objDb = new Db();
    $conn = $objDb->conecta_mysql();

    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND senha='$senha'";
    $resultado_id = mysqli_query($conn, $sql);

    if ($resultado_id) {
        $dados = $resultado_id->fetch_array();
        if(isset($dados['usuario'])) {
            echo 'Usuário existe!';
        } else {
            header('Location: index.php?erro=1');
        }
    } else {
        echo 'Erro na execução do SQL.';
    }

?>