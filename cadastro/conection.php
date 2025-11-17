<?php 
// Conexão com o banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "projetopratico";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
else {
    echo "Conexão bem-sucedida!";
}
?>
