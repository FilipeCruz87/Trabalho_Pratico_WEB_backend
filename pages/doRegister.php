<?php


require_once '../db/Database.php';
$db = new Database();

if (!isset($_POST['nome']) ||!isset($_POST['email']) || !isset($_POST['password'])) {
    header('Location: ?p=register&res=error');
    exit;
}

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($nome) ||empty($email) || empty($password)) {
    header('Location: ?p=register&res=error');
    exit;
}

$sql = "INSERT INTO utilizadores (nome,email,password) VALUES (:nome, :email, :password)";
$result = $db->executeQuery($sql, ['nome' => $nome,'email' => $email, 'password' => $password]);

if ($result['status'] === 'success') {
    header('Location: ../index.php?p=login&res=ok');
} else {
    header('Location: ../index.php?p=register&res=error');
}
