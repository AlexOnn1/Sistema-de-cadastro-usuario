<?php
session_start();
require_once 'conexao.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não autenticado.']);
    exit();
}

$userId = $_SESSION['user_id'];
$dados = json_decode(file_get_contents('php://input'), true);
if (!$dados) { $dados = $_POST; }

$nome = trim($dados['nome'] ?? '');
$sobrenome = trim($dados['sobrenome'] ?? '');
$email = trim($dados['email'] ?? '');
$novaSenha = $dados['senha'] ?? '';

if (empty($nome) || empty($sobrenome) || empty($email)) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Preencha os campos obrigatórios.']);
    exit();
}

try {
    $sql = "UPDATE usuarios SET nome = :nome, sobrenome = :sobrenome, email = :email";
    $params = ['nome' => $nome, 'sobrenome' => $sobrenome, 'email' => $email, 'id' => $userId];

    if (!empty($novaSenha)) {
        if (strlen($novaSenha) > 16) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Senha muito longa.']);
            exit();
        }
        $sql .= ", senha = :senha";
        $params['senha'] = $novaSenha;
    }

    $sql .= " WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $_SESSION['user_name'] = $nome;
    $_SESSION['user_email'] = $email;

    echo json_encode(['sucesso' => true, 'mensagem' => 'Dados atualizados.']);
} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar: ' . $e->getMessage()]);
}
?>
