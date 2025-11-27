-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS projeto_trabalho;
USE projeto_trabalho;

-- Criar tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(75) UNIQUE NOT NULL,
    senha VARCHAR(50) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

