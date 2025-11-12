// 1. Verificação do Envio do formulário
<?php
session_start();
if (isset($_POST["submit"])) {
    // 2. Coleta de dados
    $email = htmlspecialchars($_POST["email"]);
    $confirmarEmail = htmlspecialchars($_POST["confirmarEmail"]);
    $senha = $_POST["senha"];
    $confirmarSenha = $_POST["confirmarSenha"];
}
    // 3. Validação do email
    $erros = [];
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmarSenha = $_POST['confirmarSenha'] ?? '';

if ($email === '') {
    $erros[] = "Preencha o campo email.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "Email inválido.";
}

// 4. Validação da senha
if ($senha === '' || $confirmarSenha === '') {
    $erros[] = "Preencha os campos de senha.";
} elseif ($senha !== $confirmarSenha) {
    $erros[] = "As senhas não são iguais.";
}

if (!empty($erros)) {
    foreach ($erros as $err) {
        echo "<p>" . htmlspecialchars($err) . "</p>";
    }
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

    echo "<h1>Cadastro Realizado!</h1>";
    exit();
} catch (PDOException $e) {
    // Não exponha mensagens sensíveis em produção — aqui para debug
    echo "<h1>Erro ao cadastrar</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
    exit();
}
// PHP e muito dificil.
