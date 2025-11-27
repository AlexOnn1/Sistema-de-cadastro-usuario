<?php
session_start();
header('Content-Type: application/json');
require_once 'conexao.php';

if (!isset($_SESSION['tp_usuario']) || $_SESSION['tp_usuario'] !== 'admin') {
    echo json_encode(['sucesso' => false, 'erro' => 'Acesso negado.']);
    exit();
}

try {
    $stmt = $pdo->query("SELECT id, nome, sobrenome, email, tp_usuario FROM usuarios ORDER BY id DESC");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['sucesso' => true, 'dados' => $usuarios]);
} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'erro' => 'Erro ao buscar usuários.']);
}
?>