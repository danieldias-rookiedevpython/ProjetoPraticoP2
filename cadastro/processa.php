<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conection.php';

$nome     = $_POST['nome'];
$email    = $_POST['email'];
$senha    = $_POST['senha'];
$confirma = $_POST['confirmar-senha'];

// validação da senha
if ($senha !== $confirma) {
    header("Location: senha_incorreta.php");
    exit();
}

// inserir
$sql = "INSERT INTO cadastro (nome, email, senha) 
        VALUES ('$nome', '$email', '$senha')";

if (mysqli_query($conn, $sql)) {
    header("Location: cadastro_sucesso.php");
    exit();
} else {
    echo "Erro no cadastro: " . mysqli_error($conn);
}

mysqli_close($conn);
