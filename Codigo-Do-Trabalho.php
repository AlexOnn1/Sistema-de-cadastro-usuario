// 1. Verificação do Envio do formulário
if (isset($_POST["submit"])) {
    // 2. Coleta de dados
    $email = htmlspecialchars($_POST["email"]);
    $confirmarEmail = htmlspecialchars($_POST["confirmarEmail"]);
    $senha = $_POST["senha"];
    $confirmarSenha = $_POST["confirmarSenha"];
    // 3. Validação do email
    $erros = [];
    if (empty($_POST['email'])) {
        $erros[] = "preecha o campo email.";
    }
    elseif (!filter_var($_POST['email'], filter_validate_email)) {
        $erros[] = "email Invalido"
    }
    // 4. Vaidação da senha
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];
    if ($senha !== $confirmarSenha) {
        $erros[] = "As senhas não são iguais.";
    }
    // Estudar senha em hash & Armazenar Os Dados .