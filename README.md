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
 # Sistema de Cadastro e Gestão de Usuários

 Aplicação web acadêmica que oferece registro, autenticação e painel de administração para usuários.

 ## Índice

 - [Visão geral](#visão-geral)
 - [Status do projeto](#status-do-projeto)
 - [Funcionalidades](#funcionalidades)
 - [Arquitetura e fluxo](#arquitetura-e-fluxo)
 - [Estrutura do repositório](#estrutura-do-repositório)
 - [Instalação (local)](#instalação-local)
 - [Executando com Docker](#executando-com-docker)
 - [Banco de dados / Migração](#banco-de-dados--migração)
 - [Testes e debug](#testes-e-debug)
 - [Segurança e recomendações](#segurança-e-recomendações)
 - [Deploy (observações)](#deploy-observações)
 - [Contribuição](#contribuição)
 - [Licença](#licença)

 ## Visão geral

Aplicação completa para cadastro, login, edição e exclusão de contas, além de painel administrativo para gestão de usuários (promoção/rebaixamento e exclusão).

Desenvolvida para fins acadêmicos, com foco em boas práticas de organização de código e comunicação entre front-end e back-end via JSON/API.

 ## Status do projeto

- Estado: funcional (cadastro, login, perfil, edição, exclusão, painel admin)
- Script de migração e arquivo SQL incluídos para criar a tabela `usuarios`.

 ## Funcionalidades

- Cadastro de usuários com validações front-end e back-end.
- Login e sessão com PHP.
- Perfil do usuário: visualizar, editar, alterar senha e excluir conta.
- Painel administrativo (lista de usuários, promover/rebaixar, excluir).
- Endpoints JSON para operações administrativas.

 ## Arquitetura e fluxo

- Front-end: HTML/CSS nas páginas públicas e JavaScript (fetch) para chamadas AJAX.
- Back-end: PHP (PDO) para acesso ao MySQL.
- Comunicação: formulários via POST e chamadas `fetch` retornando JSON.

Fluxo resumido:

1. Registro em `index.html` → `src/register.php`.
2. Login em `public/login.html` → `src/login.php` (sessão iniciada).
3. Acesso ao `public/perfil.html` ou `public/admin.html` conforme tipo.

 ## Estrutura do repositório

```
Sistema-de-cadastro-usuario/
├── index.html                  # Página de cadastro
├── public/                     # Páginas públicas
│   ├── login.html
│   ├── perfil.html
│   ├── admin.html
│   └── css/style.css
├── src/                        # Back-end PHP e scripts
│   ├── conexao.php
│   ├── register.php
│   ├── login.php
│   ├── logout.php
│   ├── get_perfil.php
│   ├── Edicao-de-dados.php
│   ├── Exclusao-de-dados.php
│   ├── admin_listar.php
│   ├── admin_alterar_tipo.php
│   ├── admin_deletar.php
│   ├── admin_alterar_senha.php
│   ├── admin_alterar_tipo.php
│   ├── migracao.php
│   └── Javascript/index.js
├── database.sql
├── Dockerfile
├── fly.toml
└── README.md
```

 ## Instalação (local)

Pré-requisitos:

- PHP 7.4+ com extensão `pdo_mysql`
- MySQL / MariaDB
- Apache (XAMPP recomendado)

Passos rápidos:

```powershell
# copie o projeto para a pasta pública do servidor (exemplo XAMPP)
Copy-Item -Path . -Destination 'C:\xampp\htdocs\Sistema-de-cadastro-usuario' -Recurse
# importe o banco
mysql -u root -p < database.sql
```

Ou rode a migração via navegador (uso único):

```
http://localhost/Sistema-de-cadastro-usuario/src/migracao.php
```

Ajuste `src/conexao.php` conforme credenciais do seu ambiente.

 ## Executando com Docker

O `Dockerfile` presente cria uma imagem baseada em `php:8.2-apache`.

Exemplo:

```bash
docker build -t sistema-cadastro .
docker run --rm -p 8080:8080 -v $(pwd):/var/www/html sistema-cadastro

# acessar
http://localhost:8080
```

 ## Banco de dados / Migração

- `database.sql` cria a tabela `usuarios`.
- `src/migracao.php` pode ser usado uma vez para criar a tabela e adicionar um admin de teste.

Esquema (resumo):

```sql
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(25) NOT NULL,
  sobrenome VARCHAR(25) NOT NULL,
  idade INT NOT NULL,
  email VARCHAR(75) NOT NULL UNIQUE,
  senha VARCHAR(16) NOT NULL,
  tp_usuario VARCHAR(10) NOT NULL DEFAULT 'comum',
  data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

 ## Testes e debug

- `tests/test_runner.php` existe para testes básicos; execute via PHP CLI ou browser conforme o script.
- Use o painel de Network do navegador para inspecionar respostas JSON das requisições.

 ## Segurança e recomendações

Notas importantes antes de produção:

1. Senhas: atualmente o projeto usa `VARCHAR(16)` e salva senhas compatíveis com esse tamanho. Em produção troque para `VARCHAR(255)` e armazene hashes usando `password_hash()` e `password_verify()`.

```php
$hash = password_hash(
    'sua_senha', PASSWORD_BCRYPT
);
```

2. Configure HTTPS e cookies de sessão com `secure` e `httponly`.
3. Adicione proteção CSRF em formulários sensíveis.
4. Sanitização: valide e sanitize todas as entradas no servidor.

 ## Deploy (observações)

- Para deploy em serviços como Fly.io, configure variáveis de ambiente: `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`.
- Garanta que o banco esteja em uma instância gerenciada ou privada.
- Observação importante: para a aplicação rodar remotamente via Fly.io, ambos os serviços devem estar ativos — o app de banco e o app da aplicação. Verifique que os links abaixo estão em execução:
  - [Aplicação](https://sistema-de-cadastro.fly.dev)
  - [Banco de dados](https://sistema-de-cadastro-db.fly.dev)

 


