<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once 'conexao.php';

$erros = [];

$nome = trim($_POST['nome'] ?? '');
$sobrenome = trim($_POST['sobrenome'] ?? '');
$idade = filter_input(INPUT_POST, 'idade', FILTER_VALIDATE_INT);
$email = trim($_POST['email'] ?? '');
$confirmarEmail = trim($_POST['confirmarEmail'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmarSenha = $_POST['confirmarSenha'] ?? '';

if (empty($nome) || strlen($nome) > 25) { $erros[] = "Nome inválido (máx 25 caracteres)."; }
if (empty($sobrenome) || strlen($sobrenome) > 25) { $erros[] = "Sobrenome inválido (máx 25 caracteres)."; }
if (!$idade || $idade < 1 || $idade > 120) { $erros[] = "Idade inválida."; }

if ($email === '') { $erros[] = "Preencha o campo email."; }
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $erros[] = "Email inválido."; }

if ($confirmarEmail === '' || $email !== $confirmarEmail) { $erros[] = "Os emails não correspondem."; }

if ($senha === '' || $confirmarSenha === '') { $erros[] = "Preencha os campos de senha."; }
elseif ($senha !== $confirmarSenha) { $erros[] = "As senhas não são iguais."; }
elseif (strlen($senha) < 8 || strlen($senha) > 16) { $erros[] = "A senha deve ter entre 8 e 16 caracteres."; }

if (!empty($erros)) {
    echo json_encode(['sucesso' => false, 'erros' => $erros]);
    exit();
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {
    $stmtVerify = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
    $stmtVerify->execute(['email' => $email]);

    if ($stmtVerify->fetchColumn() > 0) {
        echo json_encode(['sucesso' => false, 'erros' => ['Este email já está cadastrado.']]);
        exit();
    }

    $sql = "INSERT INTO usuarios (nome, sobrenome, idade, email, senha, tp_usuario) 
            VALUES (:nome, :sobrenome, :idade, :email, :senha, 'comum')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nome' => $nome,
        'sobrenome' => $sobrenome,
        'idade' => $idade,
        'email' => $email,
        'senha' => $senhaHash
    ]);

    echo json_encode(['sucesso' => true, 'mensagem' => 'Cadastro realizado com sucesso!']);
    exit();
} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'erros' => ['Erro no banco de dados'], 'debug' => $e->getMessage()]);
    exit();
}
?>