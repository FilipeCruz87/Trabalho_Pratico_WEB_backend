<?php

$page = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['p'] ?? 'home');

$paginasPermitidas = [
    'home',
    'login',
    'logout',
    'register',
    'simulacoes',
    'resultado',
    'historico',
    'admin',
    'crud',
    'doLogin',
    'doRegister',
    'doSimulacao',
    'doEnviarSimulacao',
    'contacto',
    'historico',
    'lusilocs',
    'portfolio',
    'sobre',
    'index',
    'perfil'
];

if (!in_array($page, $paginasPermitidas)) {
    include 'pages/home.php';
    exit;
}

if (file_exists("pages/$page.php")) {
    include "pages/$page.php";
} else {
    include 'pages/home.php';
}