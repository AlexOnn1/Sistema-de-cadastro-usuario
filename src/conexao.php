<?php
// Conexão PDO
$host = getenv('DB_HOST') ?: "localhost";
$database = getenv('DB_NAME') ?: "projeto_trabalho";
$user = getenv('DB_USER') ?: "root";
$pass = getenv('DB_PASS') ?: "";

if ($host === 'db' && $pass === "") {
    $pass = "root";
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['sucesso' => false, 'erros' => ['Erro de conexão: ' . $e->getMessage()]]);
    exit();
}
?>
