<?php
require_once __DIR__ . '/../db/Database.php';
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

$sql = "SELECT * FROM utilizadores WHERE email = :email";
$result = $db->fetchQuery($sql, ['email' => $email]);

if ($result['status'] === 'success' && !empty($result['data'])) {
    $user = $result['data'][0];
    if (!password_verify($password, $user['password'])) {
        header('Location: ../index.php?p=login&res=error');
        exit;
    }

    session_start();
    $_SESSION['email'] = $user['email'];
    $_SESSION['tipo']  = $user['tipo'];
    $_SESSION['nome']  = $user['nome'];
    if ($user['tipo'] === 'admin') {
        header('Location: ../index.php?p=admin');
    } else {
        header('Location: ../index.php?p=simulacoes');
    }
} else {
    header('Location: ../index.php?p=login&res=error');
}
exit;