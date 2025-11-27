<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['sucesso' => false, 'erro' => 'Usuário não autenticado']);
    exit();
}

echo json_encode([
    'sucesso' => true,
    'nome' => $_SESSION['user_name'] ?? 'Usuário',
    'tp_usuario' => $_SESSION['tp_usuario'] ?? 'comum'
]);
?>