<?php
// src/login.php
session_start();
require_once 'conexao.php';

// Recebe os dados
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    // Se faltar dados, volta pro login com erro
    header('Location: ../public/login.html?erro=campos_vazios');
    exit();
}

try {
    // 1. Busca o usuário pelo email
    $stmt = $pdo->prepare("SELECT id, email, senha FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch();

    // 2. Verifica se usuário existe E se a senha bate com o hash
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        
        // SUCESSO! Salva na sessão
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_email'] = $usuario['email'];

        // Redireciona para a página de perfil (que vamos criar a seguir)
        header('Location: ../public/perfil.html'); 
        exit();

    } else {
        // FALHA (Senha errada ou email não existe)
        // Por segurança, não diga qual dos dois está errado
        header('Location: ../public/login.html?erro=credenciais_invalidas');
        exit();
    }

} catch (PDOException $e) {
    // Erro de banco
    header('Location: ../public/login.html?erro=banco');
    exit();
}
?>