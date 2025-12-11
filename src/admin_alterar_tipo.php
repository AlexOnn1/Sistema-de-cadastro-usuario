<?php
session_start();
header('Content-Type: application/json');
require_once 'conexao.php';

// Alterar tipo (apenas admin)
if (!isset($_SESSION['tp_usuario']) || $_SESSION['tp_usuario'] !== 'admin') {
    echo json_encode(['sucesso' => false, 'erro' => 'Acesso negado.']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$idAlvo = $input['id'] ?? null;
$novoTipo = $input['tipo'] ?? null;

if (!$idAlvo || !$novoTipo || !in_array($novoTipo, ['admin', 'comum'])) {
    echo json_encode(['sucesso' => false, 'erro' => 'Dados inválidos.']);
    exit();
}

if ($idAlvo == $_SESSION['user_id'] && $novoTipo === 'comum') {
    echo json_encode(['sucesso' => false, 'erro' => 'Não é possível remover seu próprio admin.']);
    exit();
}

try {
    $stmt = $pdo->prepare("UPDATE usuarios SET tp_usuario = :tipo WHERE id = :id");
    $stmt->execute(['tipo' => $novoTipo, 'id' => $idAlvo]);
    echo json_encode(['sucesso' => true]);
} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'erro' => 'Erro no banco.']);
}
?>
