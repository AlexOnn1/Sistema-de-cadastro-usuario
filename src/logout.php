<?php
// src/logout.php
session_start();

// Destrói todas as variáveis de sessão
session_unset();

// Destrói a sessão em si
session_destroy();

// Redireciona o usuário de volta para o login
header("Location: ../public/login.html");
exit();
?>