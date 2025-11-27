# Guia de Setup - Sistema de Cadastro e Gestão de Usuários

## Pré-requisitos

- **PHP 7.4+** com extensão PDO MySQL
- **MySQL 5.7+** ou MariaDB
- **Apache** (recomendado usar XAMPP)
- **Navegador moderno** (Chrome, Firefox, Edge)
- **(Opcional) ngrok** para acesso remoto durante desenvolvimento

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

### 2. Verificar a Tabela de Usuários

O arquivo `database.sql` já contém a tabela `usuarios` com a seguinte estrutura:

```sql
CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nome_completo VARCHAR(100),
    telefone VARCHAR(20),
    tipo_usuario ENUM('comum', 'admin') DEFAULT 'comum',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ativo BOOLEAN DEFAULT true
);
```

Se usou o arquivo `database.sql`, a tabela já foi criada automaticamente.

### 3. Criar Usuário MySQL (Opcional)

Se você não tem um usuário chamado `alex` com senha `Pato`, execute:

```sql
CREATE USER 'alex'@'localhost' IDENTIFIED BY 'Pato';
GRANT ALL PRIVILEGES ON Projeto_Trabalho.* TO 'alex'@'localhost';
FLUSH PRIVILEGES;
```

## Configuração do Servidor

### XAMPP (Recomendado)
1. Coloque a pasta do projeto em `C:\xampp\htdocs\Sistema-de-cadastro-usuario\`
2. Inicie **Apache** e **MySQL** no painel de controle do XAMPP
3. Acesse: http://localhost/Sistema-de-cadastro-usuario/

### Outro Servidor
Configure o virtual host para apontar para a pasta raiz do projeto.

## Acesso Remoto com ngrok

### Instalação
1. Baixe ngrok em: https://ngrok.com/download
2. Extraia o arquivo em um local acessível (ex: `C:\ngrok`)
3. Adicione à variável de ambiente PATH (opcional)

### Iniciando Túnel

1. **Abra o PowerShell/CMD no diretório do ngrok:**
   ```bash
   cd C:\ngrok
   ```

2. **Inicie o túnel:**
   ```bash
   .\ngrok http 80
   ```

3. **Copie a URL gerada** (ex: `https://abc123.ngrok.io`)

4. **Acesse remotamente:**
   ```
   https://abc123.ngrok.io/Sistema-de-cadastro-usuario/
   ```

### Compartilhando com Equipe
- Cada vez que ngrok é reiniciado, a URL muda
- Comunique a nova URL para os membros da equipe
- Use a URL pública para testes remotos

⚠️ **Nota:** ngrok é uma solução temporária. Para produção, será necessário um servidor dedicado/VPS.

## Testando a Conexão

### Verificar MySQL

1. Certifique-se de que o MySQL está rodando (painel do XAMPP)
2. Teste a conexão via terminal:
   ```bash
   mysql -u alex -p -h localhost
   ```
   Quando solicitado, digite: `Pato`

3. Dentro do MySQL, execute:
   ```sql
   USE Projeto_Trabalho;
   SHOW TABLES;
   SELECT * FROM usuarios;
   ```

### Verificar Credenciais

As credenciais padrão estão em `src/conexao.php`:
- **Host:** `localhost`
- **Database:** `Projeto_Trabalho`
- **User:** `alex`
- **Password:** `Pato`

### Testar Aplicação

1. Acesse: http://localhost/Sistema-de-cadastro-usuario/
2. Tente fazer um cadastro com um email novo
3. Se funcionar, verifique no MySQL:
   ```sql
   SELECT * FROM usuarios WHERE email='seu-email@test.com';
   ```

## Estrutura do Projeto

```
Sistema-de-cadastro-usuario/
├── index.html                    # Página de cadastro
├── database.sql                  # Script SQL para criar banco
├── README.md                     # Documentação principal
├── SETUP.md                      # Este arquivo
├── public/
│   ├── login.html               # Página de login
│   ├── perfil.html              # Página de perfil do usuário
│   ├── admin.html               # Painel administrativo
│   └── css/
│       └── style.css            # Estilos da aplicação
├── src/
│   ├── conexao.php              # Conexão com banco de dados
│   ├── register.php             # Backend do cadastro
│   ├── login.php                # Backend do login
│   ├── logout.php               # Backend do logout
│   ├── get_perfil.php           # Obter dados do perfil
│   ├── Edicao-de-dados.php      # Editar dados do usuário
│   ├── Exclusao-de-dados.php    # Deletar conta do usuário
│   ├── admin_listar.php         # Listar todos os usuários
│   ├── admin_alterar_tipo.php   # Alterar tipo de usuário
│   ├── admin_deletar.php        # Deletar usuário (admin)
│   └── Javascript/
│       └── index.js             # Validações client-side
└── docs/                        # Documentação adicional
```

## Segurança

- Senhas são hashadas com `password_hash()` (bcrypt)
- Dados são validados no lado do cliente e do servidor
- Emails são únicos (UNIQUE constraint)
- SQL Injection é prevenido com prepared statements

## Troubleshooting

### "Erro ao conectar ao banco de dados"
**Causas possíveis:**
- MySQL não está rodando
- Credenciais incorretas em `src/conexao.php`
- Banco de dados não foi criado

**Solução:**
1. Verifique se MySQL está ativo no XAMPP
2. Confirme as credenciais
3. Execute: `mysql -u root -p < database.sql`

### "Erro ao processar o cadastro"
**Solução:**
- Abra o console do navegador (F12 > Console) para ver detalhes
- Verifique se o arquivo `src/register.php` existe
- Verifique se a tabela `usuarios` foi criada

### "Este email já está cadastrado"
- O email já existe no banco de dados
- Use outro email ou delete o registro anterior

### "Os emails não correspondem"
- Digite exatamente o mesmo email nos dois campos

### "As senhas não são iguais"
- Digite a mesma senha nos dois campos

### "Página em branco ou erro 404"
- Verifique se o projeto está em `C:\xampp\htdocs\Sistema-de-cadastro-usuario\`
- Reinicie Apache no XAMPP
- Limpe o cache do navegador (Ctrl+Shift+Delete)

### "ngrok não funciona"
- Verifique se Apache está rodando
- Tente acessar `http://localhost` primeiro
- Reinicie o ngrok e verifique a URL gerada

### "Erro de permissão ao deletar usuário"
- Verifique se o usuário logado é admin
- Apenas admins podem deletar outros usuários
