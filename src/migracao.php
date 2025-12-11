<?php
// Migração: apagar após uso
require_once 'conexao.php';

$sql = "
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(25) NOT NULL,
    sobrenome VARCHAR(25) NOT NULL,
    idade INT NOT NULL,
    email VARCHAR(75) NOT NULL UNIQUE,
    senha VARCHAR(16) NOT NULL,
    tp_usuario VARCHAR(10) NOT NULL DEFAULT 'comum',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";

try {
    $pdo->exec("USE projeto_trabalho;");
    $pdo->exec($sql);

    $senha_admin = 'desenrolado';
    $email_admin = 'admin@teste.com';

    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
    $stmt_check->execute([$email_admin]);

    if ($stmt_check->fetchColumn() == 0) {
        $stmt_insert = $pdo->prepare("INSERT INTO usuarios (nome, sobrenome, idade, email, senha, tp_usuario) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_insert->execute(['Admin', 'Sistema', 30, $email_admin, $senha_admin, 'admin']);
        echo "Usuário Admin criado!<br>";
    }

    echo "Migração concluída.<br>";
} catch (PDOException $e) {
    echo "ERRO DURANTE A MIGRAÇÃO: <br>" . $e->getMessage() . "<br>";
}
?>
