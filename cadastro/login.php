<?php
    include 'conection.php';

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM cadastro WHERE email = '$email' AND senha = '$senha'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        header("Location: ../login.html?status=ok");
        exit();
    } else {
        header("Location: ../login.html?status=error");
        exit();
    }
?>