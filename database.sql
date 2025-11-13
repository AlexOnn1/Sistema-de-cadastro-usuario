<<<<<<< HEAD
CREATE DATABASE IF NOT EXISTS Projeto_Trabalho;
USE Projeto_Trabalho;

=======
-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS Projeto_Trabalho;
USE Projeto_Trabalho;

-- Criar tabela de usuários
>>>>>>> 6e3c964ce8d640b6b31de08d74f7aa73e6842929
CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
<<<<<<< HEAD
=======

-- Criar usuário MySQL (opcional - se precisar)
-- CREATE USER 'alex'@'localhost' IDENTIFIED BY 'Pato';
-- GRANT ALL PRIVILEGES ON Projeto_Trabalho.* TO 'alex'@'localhost';
-- FLUSH PRIVILEGES;
>>>>>>> 6e3c964ce8d640b6b31de08d74f7aa73e6842929
