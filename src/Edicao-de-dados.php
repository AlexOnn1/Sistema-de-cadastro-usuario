<?php
// src/Edicao-de-dados.php - AJUSTADO PARA VARCHAR(16) / TEXTO PURO
session_start();
require_once 'conexao.php';

header('Content-Type: application/json');

// Verifica se está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não autenticado.']);
    exit();
}

$userId = $_SESSION['user_id'];
$dados = json_decode(file_get_contents('php://input'), true);

if (!$dados) {
    // Fallback para POST form-data se não for JSON
    $dados = $_POST;
}

$nome = trim($dados['nome'] ?? '');
$sobrenome = trim($dados['sobrenome'] ?? '');
$email = trim($dados['email'] ?? '');
$novaSenha = $dados['senha'] ?? ''; // Campo da nova senha

// Validações Básicas
if (empty($nome) || empty($sobrenome) || empty($email)) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.']);
    exit();
}

try {
    // Prepara a query base
    $sql = "UPDATE usuarios SET nome = :nome, sobrenome = :sobrenome, email = :email";
    $params = [
        'nome' => $nome,
        'sobrenome' => $sobrenome,
        'email' => $email,
        'id' => $userId
    ];

    // Lógica da Senha (A MUDANÇA ESTÁ AQUI)
    if (!empty($novaSenha)) {
        // Valida tamanho para não quebrar o banco
        if (strlen($novaSenha) > 16) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'A nova senha deve ter no máximo 16 caracteres.']);
            exit();
        }

        // Adiciona a senha à query SEM HASH (Texto Puro)
        $sql .= ", senha = :senha";
        $params['senha'] = $novaSenha; 
    }

    $sql .= " WHERE id = :id";

    // Executa
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Atualiza a sessão se mudou o nome/email
    $_SESSION['user_name'] = $nome;
    $_SESSION['user_email'] = $email;

    echo json_encode(['sucesso' => true, 'mensagem' => 'Dados atualizados com sucesso!']);

} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar: ' . $e->getMessage()]);
}
?>