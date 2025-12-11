<?php
// executar_migracao.php

// ATENÇÃO: ESTE ARQUIVO DEVE SER DELETADO IMEDIATAMENTE APÓS O USO!

require_once 'conexao.php'; // Usa a conexão PDO já configurada com os secrets

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
    // 1. Executa o script SQL
    $pdo->exec("USE projeto_trabalho;");
    $pdo->exec($sql);

    // 2. Cria um usuário admin de teste (se quiser)
    // Para funcionar com VARCHAR(16), a senha é gravada em texto puro
    $senha_admin = 'desenrolado';
    $email_admin = 'admin@teste.com';
    
    // Verifica se já existe um admin para evitar duplicidade
    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
    $stmt_check->execute([$email_admin]);
    
    if ($stmt_check->fetchColumn() == 0) {
        $stmt_insert = $pdo->prepare("INSERT INTO usuarios (nome, sobrenome, idade, email, senha, tp_usuario) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_insert->execute(['Admin', 'Sistema', 30, $email_admin, $senha_admin, 'admin']);
        echo "Usuário Admin de teste ('admin@teste.com') criado com sucesso! <br>";
    }


    echo "Migração (Criação da tabela usuarios com VARCHAR(16)) concluída com sucesso! <br>";

} catch (PDOException $e) {
    echo "ERRO DURANTE A MIGRAÇÃO: <br>" . $e->getMessage() . "<br>";
    echo "Verifique se a senha foi definida como VARCHAR(16) no banco, causando Truncation." ;
}
?>