<?php
// src/admin_alterar_senha.php
session_start();
header('Content-Type: application/json');
require_once 'conexao.php';

// 1. Segurança: Só Admin pode acessar
if (!isset($_SESSION['tp_usuario']) || $_SESSION['tp_usuario'] !== 'admin') {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Acesso negado. Apenas administradores.']);
    exit();
}

// 2. Recebe os dados (JSON)
$dados = json_decode(file_get_contents('php://input'), true);
$idUsuario = $dados['id'] ?? null;
$novaSenha = $dados['novaSenha'] ?? '';

// 3. Validações
if (!$idUsuario) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'ID do usuário não fornecido.']);
    exit();
}

if (strlen($novaSenha) < 8 || strlen($novaSenha) > 16) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'A senha deve ter entre 8 e 16 caracteres.']);
    exit();
}

try {
    // 4. Atualiza a senha no banco (Texto Puro conforme sua configuração atual)
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
    $stmt->execute([
        'senha' => $novaSenha,
        'id' => $idUsuario
    ]);

    echo json_encode(['sucesso' => true, 'mensagem' => 'Senha alterada com sucesso!']);

} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro no banco de dados.']);
}
?>