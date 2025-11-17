<?php 
    $sql = new mysqli("localhost", "root", "", "projetopratico");
    if ($sql->connect_error) {
        die("Falha na conexão: " . $sql->connect_error);
    }
    else {
        echo "Conexão bem-sucedida ao banco de dados.";
    }

    // Definir o conjunto de caracteres para UTF-8
    $sql->set_charset("utf8mb4");
    $conn = $sql;

    // Configurar o fuso horário para São Paulo
    date_default_timezone_set('America/Sao_Paulo');

    // Iniciar a sessão
    session_start();

    // Definir a constante BASE_URL
    define('BASE_URL', 'http://localhost/ProjetoPraticoP2/');

    // Função para redirecionar o usuário
    function redirect($url) {
        header("Location: " . $url);
        exit();
    }

    // Função para escapar strings para evitar SQL Injection
    function escapeString($conn, $string) {
        return $conn->real_escape_string($string);
    }

    // Função para verificar se o usuário está logado
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Função para obter os dados do usuário logado
    function getLoggedInUser($conn) {   
        if (isLoggedIn()) {
            $user_id = $_SESSION['user_id'];
            $result = $conn->query("SELECT * FROM usuarios WHERE id = " . intval($user_id));
            return $result->fetch_assoc();
        }
        return null;
    }
?>