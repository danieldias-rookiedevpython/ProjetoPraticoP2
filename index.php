<?php 
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if ($senha !== $confirma_senha) {
        die("As senhas não coincidem. Por favor, tente novamente.");
    }
    else {
        // Aqui você pode adicionar código para salvar os dados no banco de dados
        // ou realizar outras ações necessárias.
    }
    echo "Olá, " . htmlspecialchars($nome) . "! Bem-vindo ao nosso site.";
?>