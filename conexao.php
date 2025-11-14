<?php 
    $sql = new mysqli("localhost", "root", "", "meu_banco_de_dados");
    if ($sql->connect_error) {
        die("Falha na conexão: " . $sql->connect_error);
    }
    else {
        echo "Conexão bem-sucedida ao banco de dados.";
    }
?>