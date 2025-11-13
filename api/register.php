<?php
// 1. Verificação do Envio do formulário
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Ativar relatório de erros para debug (comentar em produção)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Não exibir HTML, apenas JSON

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
$host = getenv('DB_HOST') ?? "localhost";
$database = getenv('DB_NAME') ?? "Projeto_Trabalho";
$user = getenv('DB_USER') ?? "gilma";
$pass = getenv('DB_PASS') ?? "1234";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se o email já existe
    $stmtVerify = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
    $stmtVerify->execute(['email' => $email]);
    $emailExiste = $stmtVerify->fetchColumn();

    if ($emailExiste > 0) {
        echo json_encode(['sucesso' => false, 'erros' => ['Este email já está cadastrado.']]);
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO usuarios (email, senha) VALUES (:email, :senha)");
    $stmt->execute(['email' => $email, 'senha' => $senhaHash]);

    echo json_encode(['sucesso' => true, 'mensagem' => 'Cadastro realizado com sucesso!']);
    exit();
} catch (PDOException $e) {
    // Log do erro (opcional - salvar em arquivo)
    // error_log("Erro PDO: " . $e->getMessage());
    
    $erros[] = "Erro ao conectar ao banco de dados. Verifique se o servidor MySQL está rodando.";
    echo json_encode(['sucesso' => false, 'erros' => $erros, 'debug' => $e->getMessage()]);
    exit();
}
