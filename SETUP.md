# Sistema de Cadastro de Usuário

## Pré-requisitos

1. **PHP 7.4+** com extensão PDO MySQL
2. **MySQL 5.7+** ou MariaDB
3. **Servidor HTTP** (Apache, Nginx, etc.)

## Setup do Banco de Dados

### 1. Criar o Banco de Dados

Você pode criar o banco de dados de duas formas:

#### Opção A: Usando phpMyAdmin
1. Abra http://localhost/phpmyadmin
2. Clique em "Novo"
3. Digite `Projeto_Trabalho` como nome do banco
4. Clique em "Criar"

#### Opção B: Usando MySQL Command Line
```bash
mysql -u root -p < database.sql
```

### 2. Criar a Tabela de Usuários

Se você usou phpMyAdmin, execute este SQL na aba "SQL":

```sql
CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Se usou o arquivo `database.sql`, ele já foi executado.

### 3. Criar Usuário MySQL (Opcional)

Se você não tem um usuário chamado `alex` com senha `Pato`, execute:

```sql
CREATE USER 'alex'@'localhost' IDENTIFIED BY 'Pato';
GRANT ALL PRIVILEGES ON Projeto_Trabalho.* TO 'alex'@'localhost';
FLUSH PRIVILEGES;
```

## Configuração do Servidor

### Se está usando XAMPP:
1. Coloque a pasta do projeto em `C:\xampp\htdocs\`
2. Inicie Apache e MySQL no painel do XAMPP
3. Acesse `http://localhost/Sistema-de-cadastro-usuario/index.html`

### Se está usando outro servidor:
Configure o virtual host para apontar para a pasta raiz do projeto.

## Testando a Conexão

Se receber erro "Erro ao conectar ao banco de dados":

1. Certifique-se de que o MySQL está rodando
2. Verifique as credenciais em `src/register.php`:
   - Host: `localhost`
   - Database: `Projeto_Trabalho`
   - User: `alex`
   - Password: `Pato`

3. Teste a conexão MySQL:
```bash
mysql -u alex -p -h localhost
(Digite a senha: Pato)
USE Projeto_Trabalho;
SHOW TABLES;
```

## Estrutura do Projeto

```
├── index.html              # Página de cadastro
├── login.html              # Página de login
├── database.sql            # Script SQL para criar o banco
├── public/
│   └── css/
│       └── style.css       # Estilos do projeto
└── src/
    ├── register.php        # Backend do cadastro
    └── Javascript/
        └── index.js        # Validações client-side
```

## Segurança

- Senhas são hashadas com `password_hash()` (bcrypt)
- Dados são validados no lado do cliente e do servidor
- Emails são únicos (UNIQUE constraint)
- SQL Injection é prevenido com prepared statements

## Troubleshooting

### "Erro ao processar o cadastro"
- Verifique se o MySQL está rodando
- Verifique o console do navegador (F12 > Console) para ver detalhes
- Abra `src/register.php` diretamente para ver a resposta JSON com mais detalhes

### "Este email já está cadastrado"
- O email já existe no banco de dados
- Use outro email

### "Os emails não correspondem"
- Digite o mesmo email nos dois campos

### "As senhas não são iguais"
- Digite a mesma senha nos dois campos de senha
