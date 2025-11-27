# Sistema de Cadastro de Usuários

Este é um projeto acadêmico de um **Sistema de Cadastro e Gestão de Usuários**, desenvolvido como parte das atividades do 2º Período. O objetivo é criar uma aplicação web completa que permita o cadastro, login, edição de dados, exclusão de contas, listagem de usuários e gerenciamento administrativo, seguindo os requisitos funcionais e não funcionais definidos.

## 📋 Status do Projeto

O projeto está em desenvolvimento ativo com as seguintes funcionalidades implementadas:

✅ **Implementado:**
- Cadastro de usuários com validação
- Sistema de login/logout
- Página de perfil com edição de dados
- Exclusão de contas de usuário
- Painel administrativo com listagem de usuários
- Alteração de tipo de usuário (admin/comum)
- Banco de dados MySQL com tabela de usuários
- Autenticação com sessões PHP
- Senhas criptografadas com bcrypt

## 📋 Gerenciamento do Projeto

Todo o gerenciamento de tarefas e o acompanhamento do status do projeto estão sendo realizados através do Trello.

* [Acesse nosso board no Trello](https://trello.com/invite/b/60490ec46dc3ea8994766a4d/ATTI9a52c5663ea47447b15e84a49dd4964352BC61F9/projeto-engenharia-de-software)


## 🚀 Funcionalidades (Requisitos)

### Requisitos Funcionais

* **Cadastro de Usuário:** Permitir que um novo usuário se cadastre com e-mail e senha.
* **Login de Usuário:** Permitir que usuários façam login usando e-mail e senha.
* **Página de Informações:** Após o login, direcionar o usuário para uma página com suas informações.
* **Edição de Dados:** Permitir que o usuário edite seus próprios dados na página de informações.
* **Exclusão de Usuário:** Permitir que o usuário exclua seu cadastro.
* **Listagem de Usuários:** Permitir listar todos os usuários cadastrados (para fins administrativos).

### Requisitos Não Funcionais

* **Desempenho:** A página de login deve carregar em até 3 segundos.
* **Segurança:** Senhas devem ser armazenadas criptografadas no banco de dados MySQL.
* **Usabilidade/Responsividade:** A interface deve ser intuitiva, responsiva e compatível com diferentes navegadores.
* **Disponibilidade:** O sistema deve funcionar nos navegadores Chrome, Firefox, Edge e Opera GX.
* **Manutenção:** O código do sistema deve ser organizado e comentado, facilitando futuras alterações.

## 🛠️ Stack de Tecnologias

* **Front-End:** HTML5, CSS3, JavaScript
* **Back-End:** PHP 7.4+
* **Banco de Dados:** MySQL 5.7+ / MariaDB
* **Servidor:** Apache (XAMPP)
* **Autenticação:** Sessões PHP + Bcrypt (password_hash)

## 📁 Estrutura do Projeto

```
Sistema-de-cadastro-usuario/
├── index.html                    # Página de cadastro
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
├── database.sql                 # Script SQL para criar banco
├── README.md                    # Este arquivo
└── SETUP.md                     # Guia de setup e troubleshooting
```

## ⚙️ Instalação e Setup

### Pré-requisitos

- **PHP 7.4+** com extensão PDO MySQL
- **MySQL 5.7+** ou MariaDB
- **Apache** (recomendado usar XAMPP)
- **Navegador moderno** (Chrome, Firefox, Edge)

### Instalação Local

1. **Colocar pasta no servidor:**
   ```
   C:\xampp\htdocs\Sistema-de-cadastro-usuario\
   ```

2. **Iniciar MySQL e Apache no XAMPP**

3. **Criar banco de dados:**
   ```bash
   mysql -u root -p < database.sql
   ```

4. **Criar usuário MySQL (se necessário):**
   ```sql
   CREATE USER 'alex'@'localhost' IDENTIFIED BY 'Pato';
   GRANT ALL PRIVILEGES ON Projeto_Trabalho.* TO 'alex'@'localhost';
   FLUSH PRIVILEGES;
   ```

5. **Acessar localmente:**
   - http://localhost/Sistema-de-cadastro-usuario/

### Acesso Remoto (Desenvolvimento)

Atualmente, o projeto está disponível remotamente através do **ngrok** para fins de desenvolvimento e testes em equipe.

#### Setup do ngrok

1. **Instalar ngrok:**
   - Baixar em https://ngrok.com/download

2. **Iniciar túnel ngrok:**
   ```bash
   ngrok http 80
   ```

3. **Copiar URL pública gerada** (ex: `https://abc123.ngrok.io`)

4. **Acessar através da URL pública:**
   - https://abc123.ngrok.io/Sistema-de-cadastro-usuario/

⚠️ **Nota:** O ngrok é uma solução temporária para desenvolvimento. A URL é redefinida a cada reinício.

### 🎯 Próximas Etapas

**Sprint Seguinte:** Implementar solução de hospedagem 100% online para produção (servidor dedicado, VPS ou serviço de cloud hosting).

Para mais detalhes, consulte [SETUP.md](SETUP.md)

## 🗃️ Modelo de Dados

O projeto utiliza um banco de dados MySQL com a seguinte estrutura:

### Modelo Físico (Tabela `usuarios`)

| Coluna | Tipo | Restrições |
| :--- | :--- | :--- |
| id | INT | PRIMARY KEY, AUTO_INCREMENT |
| email | VARCHAR(75) | UNIQUE, NOT NULL |
| senha | VARCHAR(50) | NOT NULL |
| data_criacao | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP |

**Banco de Dados:** `Projeto_Trabalho`

## 🚀 Como Usar

### Acesso Rápido

1. **Página Inicial:** http://localhost/Sistema-de-cadastro-usuario/
2. **Cadastro:** Preencha o formulário na página inicial
3. **Login:** Clique em "Já tem uma conta?" na página inicial
4. **Painel Admin:** Acesse com uma conta de tipo `admin`

### Fluxo da Aplicação

1. Usuário acessa a página inicial
2. Cadastra-se com email e senha
3. Realiza login com suas credenciais
4. Acessa o perfil para visualizar/editar dados
5. Admin pode gerenciar todos os usuários

## 👥 Equipe do Projeto

* **Front-End:** Alexsander
* **Back-End:** Luis, Fayrlysson, João
* **Design:** Victor

