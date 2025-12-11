<?php
session_start();
header('Content-Type: application/json');
require_once 'conexao.php';

$erros = [];
$nome = trim($_POST['nome'] ?? '');
$sobrenome = trim($_POST['sobrenome'] ?? '');
$idade = filter_input(INPUT_POST, 'idade', FILTER_VALIDATE_INT);
$email = trim($_POST['email'] ?? '');
$confirmarEmail = trim($_POST['confirmarEmail'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmarSenha = $_POST['confirmarSenha'] ?? '';

if (empty($nome) || strlen($nome) > 25) { $erros[] = "Nome inválido."; }
if (empty($sobrenome) || strlen($sobrenome) > 25) { $erros[] = "Sobrenome inválido."; }
if (!$idade || $idade < 1 || $idade > 120) { $erros[] = "Idade inválida."; }
if ($email === '') { $erros[] = "Preencha o email."; } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $erros[] = "Email inválido."; }
if ($confirmarEmail === '' || $email !== $confirmarEmail) { $erros[] = "Emails não correspondem."; }
if ($senha === '' || $confirmarSenha === '') { $erros[] = "Preencha as senhas."; } elseif ($senha !== $confirmarSenha) { $erros[] = "Senhas não são iguais."; } elseif (strlen($senha) < 8 || strlen($senha) > 16) { $erros[] = "Senha deve ter 8-16 caracteres."; }

if (!empty($erros)) { echo json_encode(['sucesso' => false, 'erros' => $erros]); exit(); }

$senhaParaSalvar = $senha;

try {
    $stmtVerify = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
    $stmtVerify->execute(['email' => $email]);

    if ($stmtVerify->fetchColumn() > 0) {
        echo json_encode(['sucesso' => false, 'erros' => ['Este email já está cadastrado.']]);
        exit();
    }

    $sql = "INSERT INTO usuarios (nome, sobrenome, idade, email, senha, tp_usuario) VALUES (:nome, :sobrenome, :idade, :email, :senha, 'comum')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nome' => $nome, 'sobrenome' => $sobrenome, 'idade' => $idade, 'email' => $email, 'senha' => $senhaParaSalvar]);

    echo json_encode(['sucesso' => true, 'mensagem' => 'Cadastro realizado com sucesso!']);
    exit();
} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'erros' => ['Erro no banco de dados: ' . $e->getMessage()]]);
    exit();
}
?>
