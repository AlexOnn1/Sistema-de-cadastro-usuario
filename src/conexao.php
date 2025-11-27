<?php
// Configurações do Banco de Dados
$host = "localhost";
$database = "projeto_trabalho"; // Verifique se o nome é 'projeto_trabalho' ou 'Projeto_Trabalho' (Linux diferencia maiúsculas)
$user = "gilma";
$pass = "1234";

try {
    // Cria a conexão PDO
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $pass);
    
    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Opcional: Configura o modo de fetch padrão para array associativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se der erro na conexão, retorna JSON e para tudo.
    header('Content-Type: application/json');
    echo json_encode([
        'sucesso' => false, 
        'erros' => ['Erro fatal: Não foi possível conectar ao banco de dados.'],
        'debug' => $e->getMessage() // Remova isso em produção!
    ]);
    exit();
}
?>