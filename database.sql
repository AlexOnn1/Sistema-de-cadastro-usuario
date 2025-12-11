-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS projeto_trabalho;
USE projeto_trabalho;

-- Criar tabela de usuários
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

