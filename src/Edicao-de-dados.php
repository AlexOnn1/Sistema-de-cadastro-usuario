<?php
session_start();
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 0); 

require_once 'conexao.php';

$erros = [];
$user_id = $_SESSION['user_id'] ?? null; 

if (!$user_id) { 
    echo json_encode(['sucesso' => false, 'erros' => ['Necessário estar logado']]);
    exit();
}

// 1. Recebendo os dados
$novoNome = trim($_POST['nome'] ?? '');
$novoSobrenome = trim($_POST['sobrenome'] ?? '');
$novaIdade = $_POST['idade'] ?? ''; 
$novoEmail = trim($_POST['novoEmail'] ?? ''); 
$ConfirmarNovoEmail = trim($_POST['ConfirmarNovoEmail'] ?? ''); 
$NovaSenha = $_POST['NovaSenha'] ?? '';
$ConfirmarNovaSenha = $_POST['ConfirmarNovaSenha'] ?? '';

// 2. Validações

// A. Nome (Se preenchido)
$atualizarNome = false;
if ($novoNome !== '') {
    if (strlen($novoNome) > 25) { $erros[] = "Nome muito longo (máx 25)."; }
    else { $atualizarNome = true; }
}

// B. Sobrenome (Se preenchido)
$atualizarSobrenome = false;
if ($novoSobrenome !== '') {
    if (strlen($novoSobrenome) > 25) { $erros[] = "Sobrenome muito longo (máx 25)."; }
    else { $atualizarSobrenome = true; }
}

// C. Idade (Se preenchido)
$atualizarIdade = false;
if ($novaIdade !== '') {
    $idadeInt = filter_var($novaIdade, FILTER_VALIDATE_INT);
    if (!$idadeInt || $idadeInt < 1 || $idadeInt > 120) { 
        $erros[] = "Idade inválida."; 
    } else { 
        $atualizarIdade = true; 
    }
}

// D. Email (Se preenchido)
$atualizarEmail = false;
if ($novoEmail !== '') { 
    $atualizarEmail = true;
    if (!filter_var($novoEmail, FILTER_VALIDATE_EMAIL)) { $erros[] = "Novo email inválido."; }
    elseif ($ConfirmarNovoEmail === '' || $novoEmail !== $ConfirmarNovoEmail) { $erros[] = "Os emails não correspondem."; }
}

// E. Senha (Se preenchido)
$atualizarSenha = false;
if ($NovaSenha !== '') {
    $atualizarSenha = true;
    if ($ConfirmarNovaSenha === '' || $NovaSenha !== $ConfirmarNovaSenha) { $erros[] = "As senhas não são iguais."; }
    elseif (strlen($NovaSenha) < 8 || strlen($NovaSenha) > 16) { $erros[] = "A senha deve ter entre 8 e 16 caracteres."; }
}

// Verifica se tem erros
if (!empty($erros)) { echo json_encode(['sucesso' => false, 'erros' => $erros]); exit(); }

// Verifica se PELO MENOS UM campo foi preenchido
if (!$atualizarNome && !$atualizarSobrenome && !$atualizarIdade && !$atualizarEmail && !$atualizarSenha) {
    echo json_encode(['sucesso' => false, 'erros' => ['Nenhum campo foi alterado.']]);
    exit();
}

try {
    $sqlparts = [];
    $params = ['id' => $user_id];

    // Montando a Query dinamicamente
    if ($atualizarNome) {
        $sqlparts[] = "nome = :nome";
        $params['nome'] = $novoNome;
    }

    if ($atualizarSobrenome) {
        $sqlparts[] = "sobrenome = :sobrenome";
        $params['sobrenome'] = $novoSobrenome;
    }

    if ($atualizarIdade) {
        $sqlparts[] = "idade = :idade";
        $params['idade'] = $novaIdade;
    }

    if ($atualizarEmail) { 
        $stmtVerify = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :novoEmail AND id != :id");
        $stmtVerify->execute(['novoEmail' => $novoEmail, 'id' => $user_id]); 
        
        if ($stmtVerify->fetchColumn() > 0) {
            echo json_encode(['sucesso' => false, 'erros' => ['Email já em uso por outro usuário.']]); 
            exit();
        }
        $sqlparts[] = "email = :novoEmail";
        $params['novoEmail'] = $novoEmail;
        $_SESSION['user_email'] = $novoEmail; 
    }

    if ($atualizarSenha) {
        $senhaHash = password_hash($NovaSenha, PASSWORD_DEFAULT);
        $sqlparts[] = "senha = :senhaHash"; 
        $params['senhaHash'] = $senhaHash; 
    }

    // Executa a atualização final
    if (!empty($sqlparts)) {
        $sql = "UPDATE usuarios SET " . implode(", ", $sqlparts) . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        echo json_encode(['sucesso' => true, 'mensagem' => 'Dados atualizados com sucesso!']);
        exit();
    }
    
} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'erros' => ['Erro no banco'], 'debug' => $e->getMessage()]);
    exit();
}
?>