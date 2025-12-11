<?php
// src/get_perfil.php
session_start();
header('Content-Type: application/json');
require_once 'conexao.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Não autenticado']);
    exit();
}

try {
    $id = $_SESSION['user_id'];
    // Buscamos TODOS os dados que queremos mostrar no formulário
    $stmt = $pdo->prepare("SELECT nome, sobrenome, email, idade, tp_usuario FROM usuarios WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        echo json_encode([
            'sucesso' => true,
            'nome' => $usuario['nome'],
            'sobrenome' => $usuario['sobrenome'],
            'email' => $usuario['email'],
            'idade' => $usuario['idade'],
            'tp_usuario' => $usuario['tp_usuario']
        ]);
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não encontrado']);
    }

} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro no banco']);
}
?>