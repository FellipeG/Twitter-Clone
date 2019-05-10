<?php

    session_start();

    require_once ('db.class.php');

    $usuario = $_POST['usuario'];
    $senha = md5($_POST['senha']);

    $objDb = new Db();
    $conn = $objDb->conecta_mysql();

    $sql = "SELECT id, usuario, email FROM usuarios WHERE usuario='$usuario' AND senha='$senha'";
    $resultado_id = mysqli_query($conn, $sql);

    if ($resultado_id) {
        $dados = $resultado_id->fetch_array();
        if(isset($dados['usuario'])) {

            $_SESSION['id'] = $dados['id'];
            $_SESSION['usuario'] = $dados['usuario'];
            $_SESSION['email'] = $dados['email'];

            header('Location: home.php');
        } else {
            header('Location: index.php?erro=1');
        }
    } else {
        echo 'Erro na execução do SQL.';
    }

?>