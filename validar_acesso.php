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
        var_dump($dados);
    } else {
        echo 'Erro na execução do SQL.';
    }

?>