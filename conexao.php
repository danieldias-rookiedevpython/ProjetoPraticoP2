<?php 
    $sql = new mysqli("localhost", "root", "", "projetopratico");
    if ($sql->connect_error) {
        die("Falha na conexão: " . $sql->connect_error);
    }
    else {
        echo "Conexão bem-sucedida ao banco de dados.";
    }
?>