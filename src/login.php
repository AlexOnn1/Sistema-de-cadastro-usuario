<?php
session_start();
require_once 'conexao.php';

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    header('Location: ../public/login.html?erro=campos_vazios');
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT id, nome, email, senha, tp_usuario FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch();

    if ($usuario && $senha === $usuario['senha']) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nome'];
        $_SESSION['user_email'] = $usuario['email'];
        $_SESSION['tp_usuario'] = $usuario['tp_usuario'];

        if ($usuario['tp_usuario'] === 'admin') {
            header('Location: ../public/admin.html');
        } else {
            header('Location: ../public/perfil.html');
        }
        exit();
    } else {
        header('Location: ../public/login.html?erro=credenciais_invalidas');
        exit();
    }
} catch (PDOException $e) {
    header('Location: ../public/login.html?erro=banco');
    exit();
}
?>
