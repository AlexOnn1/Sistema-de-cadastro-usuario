// 1. Verificação do Envio do formulário
<?php
session_start();
header('Content-Type: application/json');

$erros = [];
$email = trim($_POST['email'] ?? '');
$confirmarEmail = trim($_POST['confirmarEmail'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmarSenha = $_POST['confirmarSenha'] ?? '';

if ($email === '') {
    $erros[] = "Preencha o campo email.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "Email inválido.";
}

if ($confirmarEmail === '' || $email !== $confirmarEmail) {
    $erros[] = "Os emails não correspondem.";
}

// 4. Validação da senha
if ($senha === '' || $confirmarSenha === '') {
    $erros[] = "Preencha os campos de senha.";
} elseif ($senha !== $confirmarSenha) {
    $erros[] = "As senhas não são iguais.";
} elseif (strlen($senha) < 8 || strlen($senha) > 16) {
    $erros[] = "A senha deve ter entre 8 e 16 caracteres.";
}

if (!empty($erros)) {
    echo json_encode(['sucesso' => false, 'erros' => $erros]);
    exit();
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// 5. Conexão com o Banco de Dados
$host = "localhost";
$database = "Projeto_Trabalho";
$user = "alex";
$pass = "Pato";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("INSERT INTO usuarios (email, senha) VALUES (:email, :senha)");
    $stmt->execute(['email' => $email, 'senha' => $senhaHash]);

    echo json_encode(['sucesso' => true, 'mensagem' => 'Cadastro realizado com sucesso!']);
    exit();
} catch (PDOException $e) {
    $erros[] = "Erro ao cadastrar. Tente novamente mais tarde.";
    echo json_encode(['sucesso' => false, 'erros' => $erros]);
    exit();
}
