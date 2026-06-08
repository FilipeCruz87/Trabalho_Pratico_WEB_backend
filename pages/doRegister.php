<?php
require_once __DIR__ . '/../db/Database.php';
$db = new Database();

if (!isset($_POST['nome']) || !isset($_POST['email']) || !isset($_POST['password'])) {
    header('Location: ../index.php?p=register&res=error');
    exit;
}

$nome  = $_POST['nome']  ?? '';
$email = $_POST['email'] ?? '';

if (empty($nome) || empty($email) || empty($_POST['password'])) {
    header('Location: ../index.php?p=register&res=error');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../index.php?p=register&res=error');
    exit;
}

$passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO utilizadores (nome, email, password) VALUES (:nome, :email, :password)";
$result = $db->executeQuery($sql, [
    'nome'     => $nome,
    'email'    => $email,
    'password' => $passwordHash
]);

if ($result['status'] === 'success') {
    header('Location: ../index.php?p=login&res=ok');
} else {
    header('Location: ../index.php?p=register&res=error');
}
