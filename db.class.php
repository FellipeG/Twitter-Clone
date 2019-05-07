<?php

    class Db {

        // host
        private $host = 'localhost';
        // usuario
        private $usuario = 'root';
        // senha
        private $senha = '';
        // banco de dados
        private $bd = 'twitter_clone';

        private $porta = 3307;

        public function conecta_mysql() {

            // faz a conexão
            $conn = mysqli_connect($this->host, $this->usuario, $this->senha, $this->bd, $this->porta);
            mysqli_set_charset($conn, 'utf8');

            // Verifica se houve erro de conexão
            if (mysqli_connect_errno()) {
                echo 'Houve um erro ao tentar se conectar ao BD: '.mysqli_connect_error();
            }

            return $conn;
        }
    }

?>