<?php
session_start();
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 0); 

require_once 'conexao.php'; // <--- IMPORTANTE: Conexão centralizada

$erros = [];
$user_id = $_SESSION['user_id'] ?? null; 

if (!$user_id) { 
    echo json_encode(['sucesso' => false, 'erros' => ['Necessário estar logado']]);
    exit();
}

// ... (Sua lógica de recebimento de dados continua aqui) ...
$novoEmail = trim($_POST['novoEmail'] ?? ''); 
$ConfirmarNovoEmail = trim($_POST['ConfirmarNovoEmail'] ?? ''); 
$NovaSenha = $_POST['NovaSenha'] ?? '';
$ConfirmarNovaSenha = $_POST['ConfirmarNovaSenha'] ?? '';

// ... (Suas validações IF/ELSE continuam aqui, não mudei nada na lógica) ...
$atualizarEmail = false;
if ($novoEmail !== '') { 
    $atualizarEmail = true;
    if (!filter_var($novoEmail, FILTER_VALIDATE_EMAIL)) { $erros[] = "Novo email inválido."; }
    elseif ($ConfirmarNovoEmail === '' || $novoEmail !== $ConfirmarNovoEmail) { $erros[] = "Os emails não correspondem."; }
}

$atualizarSenha = false;
if ($NovaSenha !== '') {
    $atualizarSenha = true;
    if ($ConfirmarNovaSenha === '' || $NovaSenha !== $ConfirmarNovaSenha) { $erros[] = "As senhas não são iguais."; }
    elseif (strlen($NovaSenha) < 8 || strlen($NovaSenha) > 16) { $erros[] = "A senha deve ter entre 8 e 16 caracteres."; }
}

if (!$atualizarEmail && !$atualizarSenha) { $erros[] = "Nenhum campo foi preenchido."; }
if (!empty($erros)) { echo json_encode(['sucesso' => false, 'erros' => $erros]); exit(); }

try {
    // Usando $pdo do conexao.php
    $sqlparts = [];
    $params = ['id' => $user_id];

    if ($atualizarEmail) { 
        $stmtVerify = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :novoEmail AND id != :id");
        $stmtVerify->execute(['novoEmail' => $novoEmail, 'id' => $user_id]); 
        
        if ($stmtVerify->fetchColumn() > 0) {
            echo json_encode(['sucesso' => false, 'erros' => ['Email já em uso.']]); 
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

    if (!empty($sqlparts)) {
        $sql = "UPDATE usuarios SET " . implode(", ", $sqlparts) . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        echo json_encode(['sucesso' => true, 'mensagem' => 'Dados atualizados!']);
        exit();
    }
    
} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'erros' => ['Erro no banco'], 'debug' => $e->getMessage()]);
    exit();
}
?>