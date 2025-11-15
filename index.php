<?php
// index.php
// Processa o formulário de cadastro enviado via AJAX
// 1. Define o cabeçalho para JSON
    include 'conexao.php'; // Arquivo com a conexão ao banco de dados
    header('Content-Type: application/json');

// 2. Verifica se a requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Filtra e pega os dados
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha']; 
    $confirmarSenha = $_POST['confirmar-senha']; 

    // Validação básica do lado do servidor
    if (!$nome || !$email || ($senha !== $confirmarSenha)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Dados inválidos ou senhas não conferem.']);
        exit;
    }
    
    try {
        // Exemplo: Hash da senha antes de salvar
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        
        include 'conexao.php'; // Arquivo com a conexão ao banco de dados
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senhaHash);
        
        // Se o cadastro for bem-sucedido:
        http_response_code(200); // OK
        echo json_encode(['status' => 'success', 'message' => 'Usuário cadastrado com sucesso!']);
        
    } catch (Exception $e) {
        // Se houver qualquer erro durante o processamento (ex: falha no DB)
        http_response_code(500); // Internal Server Error
        echo json_encode(['status' => 'error', 'message' => 'Erro interno ao tentar salvar o usuário.']);
    }
    // ------------------------------------------------------------------
    
} else {
    // Requisição não é POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Método de requisição não permitido.']);
}

exit; // Garante que o script pare de executar e não envie output extra
?>