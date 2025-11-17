<?php
include 'conection.php';

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$email = $_POST['email'];
$senha = $_POST['senha'];

$stmt = $conn->prepare("SELECT senha FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($senha_hash);
    $stmt->fetch();

    if (password_verify($senha, $senha_hash)) {
        echo "<h2>Login realizado com sucesso!</h2>";
    } else {
        echo "<h2>Senha incorreta!</h2>";
    }

} else {
    echo "<h2>Email não encontrado!</h2>";
}

$stmt->close();
$conn->close();
?>
