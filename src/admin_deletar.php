<?php
session_start();
header('Content-Type: application/json');
require_once 'conexao.php';

if (!isset($_SESSION['tp_usuario']) || $_SESSION['tp_usuario'] !== 'admin') {
    echo json_encode(['sucesso' => false, 'erro' => 'Acesso negado.']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$idParaDeletar = $input['id'] ?? null;

if (!$idParaDeletar) {
    echo json_encode(['sucesso' => false, 'erro' => 'ID não fornecido.']);
    exit();
}

if ($idParaDeletar == $_SESSION['user_id']) {
    echo json_encode(['sucesso' => false, 'erro' => 'Você não pode se auto-excluir pelo painel.']);
    exit();
}

try {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->execute(['id' => $idParaDeletar]);
    echo json_encode(['sucesso' => true]);
} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'erro' => 'Erro ao deletar usuário.']);
}
?>