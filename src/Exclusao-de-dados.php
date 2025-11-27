<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once 'conexao.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(['sucesso' => false, 'erros' => ['Você precisa estar logado.']]);
    exit();
}

try {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->execute(['id' => $user_id]);

    if ($stmt->rowCount() > 0) {
        session_unset();
        session_destroy();
        echo json_encode(['sucesso' => true, 'mensagem' => 'Conta excluída!']);
    } else {
        echo json_encode(['sucesso' => false, 'erros' => ['Erro ao excluir conta.']]);
    }
} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'erros' => ['Erro no banco'], 'debug' => $e->getMessage()]);
}
?>