<?php
// processa.php

// Só aceita POST — se não, interrompe (evita renderizar processamento sem dados)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // método não permitido
    exit('Método de requisição inválido.');
}

// Inclui a conexão com o banco
require_once 'conection.php';
require_once 'login.php';

// Verifica se $conn existe e é um objeto mysqli válido
if (!isset($conn) || !($conn instanceof mysqli)) {
    // Log do erro (arquivo protegido no servidor)
    error_log("[processa.php] Falha na conexão: \$conn não existe ou não é mysqli\n", 3, __DIR__ . '/error_log.txt');
    die("Ocorreu um erro no servidor. Tente novamente mais tarde.");
}

// Verifica se houve erro na conexão
if (isset($conn->connect_error) && $conn->connect_error) {
    error_log("[processa.php] connect_error: " . $conn->connect_error . "\n", 3, __DIR__ . '/error_log.txt');
    die("Ocorreu um erro na conexão com o banco. Tente novamente mais tarde.");
}

// Recebe e saneia os dados
$nome  = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$senha_raw = isset($_POST['senha']) ? $_POST['senha'] : '';

// Validações básicas
$erros = [];

if ($nome === '') {
    $erros[] = 'O campo nome é obrigatório.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = 'Informe um e-mail válido.';
}
if ($senha_raw === '' || strlen($senha_raw) < 6) {
    $erros[] = 'A senha deve ter pelo menos 6 caracteres.';
}

// Se houver erros de validação, mostra para o usuário
if (!empty($erros)) {
    $mensagemErro = implode('<br>', array_map('htmlspecialchars', $erros));
    $sucesso = false;
    // fecha conexão e renderiza a página abaixo com a mensagem
} else {
    // Verifica se o e-mail já existe (prevenção amigável)
    $checkStmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    if ($checkStmt) {
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();
        if ($checkStmt->num_rows > 0) {
            $sucesso = false;
            $mensagemErro = 'Este e-mail já está cadastrado.';
            $checkStmt->close();
            // fecha conexao mais abaixo
        } else {
            $checkStmt->close();

            // Hash da senha
            $senhaHash = password_hash($senha_raw, PASSWORD_BCRYPT);

            // Prepara inserção
            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            if (!$stmt) {
                // Log técnico
                error_log("[processa.php] prepare INSERT falhou: " . $conn->error . "\n", 3, __DIR__ . '/error_log.txt');
                $sucesso = false;
                $mensagemErro = 'Erro ao salvar seus dados. Tente novamente mais tarde.';
            } else {
                $stmt->bind_param("sss", $nome, $email, $senhaHash);
                $executou = $stmt->execute();
                if ($executou) {
                    $sucesso = true;
                } else {
                    // Se for erro UNIQUE por qualquer razão, já tratamos antes, mas aqui logamos
                    error_log("[processa.php] execute INSERT falhou: " . $stmt->error . "\n", 3, __DIR__ . '/error_log.txt');
                    $sucesso = false;
                    $mensagemErro = 'Erro ao salvar seus dados. Tente novamente mais tarde.';
                }
                $stmt->close();
            }
        }
    } else {
        // Falha ao preparar o SELECT
        error_log("[processa.php] prepare SELECT falhou: " . $conn->error . "\n", 3, __DIR__ . '/error_log.txt');
        $sucesso = false;
        $mensagemErro = 'Erro no servidor. Tente novamente mais tarde.';
    }
}

// Fecha conexão
$conn->close();