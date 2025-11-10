# Sistema de Gestão de Usuários

Este é um projeto acadêmico de um Sistema de Gestão de Usuários, desenvolvido como parte das atividades do 2º Período. O objetivo é criar uma aplicação web que permita o cadastro, login, edição, exclusão e listagem de usuários, seguindo os requisitos funcionais e não funcionais definidos.

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
* **Back-End:** PhP
* **Banco de Dados:** Mysql

## 🗃️ Modelo de Dados

O projeto conta com um modelo conceitual e um modelo físico para o banco de dados.

### Modelo Físico (Tabela `Usuario`)

| Coluna | Tipo | Restrições |
| :--- | :--- | :--- |
| id_nome | int | (PK) |
| nome_comp | varchar(75) | |
| nome | varchar(25) | |
| sobrenome | varchar(25) | |
| idade | int(3) | |
| email | varchar(75) | |
| senha | varchar(50) | |
| dt_criacao | datetime | |
| tipo_usuario | enum('comum', 'admin')| |

## 👥 Equipe do Projeto

* **Front-End:** Alexsander
* **Back-End:** Luis, Fayrlysson, João
* **Design:** Victor

