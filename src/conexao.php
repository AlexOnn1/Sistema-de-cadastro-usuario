<?php
// src/conexao.php

// Se existir a variável de ambiente DB_HOST (Docker), usa ela. Se não, usa localhost (XAMPP).
$host = getenv('DB_HOST') ?: "localhost";
$database = getenv('DB_NAME') ?: "projeto_trabalho";
$user = getenv('DB_USER') ?: "root"; // No Docker configurei como root
$pass = getenv('DB_PASS') ?: "";     // No Docker a senha é root, no XAMPP costuma ser vazio

// Ajuste fino para a senha no Docker vs XAMPP
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