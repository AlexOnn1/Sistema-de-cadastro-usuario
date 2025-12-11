<?php
session_start();
header('Content-Type: application/json');
require_once 'conexao.php';

// Alterar senha (apenas admin)
if (!isset($_SESSION['tp_usuario']) || $_SESSION['tp_usuario'] !== 'admin') {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Acesso negado.']);
    exit();
}

$dados = json_decode(file_get_contents('php://input'), true);
$idUsuario = $dados['id'] ?? null;
$novaSenha = $dados['novaSenha'] ?? '';

if (!$idUsuario) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'ID não fornecido.']);
    exit();
}

if (strlen($novaSenha) < 8 || strlen($novaSenha) > 16) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Senha inválida.']);
    exit();
}

try {
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
    $stmt->execute(['senha' => $novaSenha, 'id' => $idUsuario]);
    echo json_encode(['sucesso' => true, 'mensagem' => 'Senha alterada.']);
} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro no banco.']);
}
?>
