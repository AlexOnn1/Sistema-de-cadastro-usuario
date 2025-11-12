// 1. Verificação do Envio do formulário
if (isset($_POST["submit"])) {
    // 2. Coleta de dados
    $email = htmlspecialchars($_POST["email"]);
    $confirmarEmail = htmlspecialchars($_POST["confirmarEmail"]);
    $senha = $_POST["senha"];
    $confirmarSenha = $_POST["confirmarSenha"];
}
    // 3. Validação do email
    $erros = [];
    if (empty($_POST['email'])) {
        $erros[] = "preecha o campo email.";
    }
    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $erros[] = "email Invalido";
    }
    // 4. Vaidação da senha
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];
    if ($senha !== $confirmarSenha) {
        $erros[] = "As senhas não são iguais.";
    }
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    // 5. Conexão com o Banco de Dados
     $host = "localhost";
     $database = "Projeto_Trabalho";
     $user = "alex"; 
     $pass = "Pato";
     try {
    
        $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("INSERT INTO usuarios (email, senha) VALUES (:email, :senha)"); 
    $stmt->execute(['$email', $senhaHash]);
    echo "<h1>Cadastro Realizado!</h1>";
    exit();
     }
    ?>
