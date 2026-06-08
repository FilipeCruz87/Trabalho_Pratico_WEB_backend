<?php

require_once '../db/Database.php';
$db = new Database();

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header('Location: ?p=login');
    exit;
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header('Location: ?p=login');
    exit;
}

$sql = "SELECT * FROM utilizadores WHERE email = :email AND password = :password";
$result = $db->executeQuery($sql, ['email' => $email, 'password' => $password]);
if ($result['status'] === 'success') {
    session_start();
    $_SESSION['email'] = $email;
    header('Location: ../index.php?p=simulacoes');
} else {
    header('Location: ../index.php?p=login&res=error');
}
exit;
