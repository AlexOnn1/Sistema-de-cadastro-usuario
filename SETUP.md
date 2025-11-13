# 📋 Sistema de Cadastro de Usuário

## 📋 Índice
- [Pré-requisitos](#pré-requisitos)
- [Setup do Banco de Dados](#setup-do-banco-de-dados)
- [Configuração do Servidor](#configuração-do-servidor)
- [Testando a Conexão](#testando-a-conexão)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Segurança](#segurança)
- [Troubleshooting](#troubleshooting)

## 📦 Pré-requisitos

- **PHP 7.4+** com extensão PDO MySQL
- **MySQL 5.7+** ou MariaDB
- **Servidor HTTP** (Apache, Nginx, etc.)

## 🗄️ Setup do Banco de Dados

### 1️⃣ Criar o Banco de Dados

Escolha uma das opções abaixo:

#### Opção A: Usando phpMyAdmin
1. Abra `http://localhost/phpmyadmin`
2. Clique em "Novo"
3. Digite `Projeto_Trabalho` como nome do banco
4. Clique em "Criar"

#### Opção B: Usando MySQL Command Line
```bash
mysql -u root -p < database.sql
```

### 2️⃣ Criar a Tabela de Usuários

Se utilizou **phpMyAdmin**, execute este SQL na aba "SQL":

```sql
CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Se usou o **arquivo `database.sql`**, a tabela já foi criada automaticamente.

### 3️⃣ Criar Usuário MySQL (Opcional)

Se não possui um usuário chamado `gilma` com senha `1234`, execute:

```sql
CREATE USER 'gilma'@'localhost' IDENTIFIED BY '1234';
GRANT ALL PRIVILEGES ON Projeto_Trabalho.* TO 'gilma'@'localhost';
FLUSH PRIVILEGES;
```

> ⚠️ **Aviso de Segurança**: Altere a senha padrão em produção!

## ⚙️ Configuração do Servidor

### Se está usando XAMPP:
1. Coloque a pasta do projeto em `C:\xampp\htdocs\`
2. Inicie **Apache** e **MySQL** no painel do XAMPP
3. Acesse `http://localhost/Sistema-de-cadastro-usuario/index.html`

### Se está usando outro servidor:
Configure o virtual host para apontar para a pasta raiz do projeto.

## 🔗 Testando a Conexão

Se receber o erro **"Erro ao conectar ao banco de dados"**:

1. ✅ Certifique-se de que o MySQL está rodando
2. ✅ Verifique as credenciais em `src/register.php`:
   - **Host**: `localhost`
   - **Database**: `Projeto_Trabalho`
   - **User**: `gilma`
   - **Password**: `1234`

3. ✅ Teste a conexão MySQL via terminal:
```bash
mysql -u alex -p -h localhost
(Digite a senha: Pato)
USE Projeto_Trabalho;
SHOW TABLES;
```

## 📁 Estrutura do Projeto

```
Sistema-de-cadastro-usuario/
├── index.html              # Página de cadastro
├── login.html              # Página de login
├── database.sql            # Script SQL para criar o banco
├── SETUP.md                # Guia de setup (este arquivo)
├── README.md               # Documentação principal
├── public/
│   └── css/
│       └── style.css       # Estilos do projeto
└── src/
    ├── register.php        # Backend do cadastro
    └── Javascript/
        └── index.js        # Validações client-side
```

## 🔒 Segurança

- ✅ Senhas são hashadas com `password_hash()` (bcrypt)
- ✅ Dados são validados no lado do cliente e do servidor
- ✅ Emails são únicos (UNIQUE constraint)
- ✅ SQL Injection é prevenido com prepared statements
- ⚠️ **Nunca** exponha credenciais em ambiente de produção

## 🐛 Troubleshooting

### ❌ "Erro ao processar o cadastro"
- Verifique se o MySQL está rodando
- Verifique o console do navegador (`F12 > Console`) para ver detalhes
- Abra `src/register.php` diretamente para ver a resposta JSON com mais informações

### ❌ "Este email já está cadastrado"
- O email já existe no banco de dados
- Use outro email para o cadastro

### ❌ "Os emails não correspondem"
- Digite o mesmo email nos dois campos
- Verifique se não há espaços em branco

### ❌ "As senhas não são iguais"
- Digite a mesma senha nos dois campos de senha
- Verifique se não há espaços em branco ou maiúsculas/minúsculas diferentes

### ❌ Erro de permissão ao conectar
- Verifique se o usuário MySQL `alex` tem as permissões corretas
- Execute novamente os comandos de criação de usuário (seção 3️⃣)

---

**Versão**: 1.0  
**Última atualização**: 12 de novembro de 2025
