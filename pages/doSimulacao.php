<?php
session_start();
require_once __DIR__ . '/../db/Database.php';
$db = new Database();

// Verifica sessão
if (!isset($_SESSION['email'])) {
    header('Location: ../index.php?p=login');
    exit;
}

// Verifica POST
if (!isset($_POST['origem'], $_POST['destino'], $_POST['numero_palavras'])) {
    header('Location: ../index.php?p=simulacoes&res=error');
    exit;
}

$origem        = $_POST['origem'];
$destino       = $_POST['destino'];
$numeroPalavras = (int)$_POST['numero_palavras'];
$observacoes   = $_POST['observacoes'] ?? '';

// Busca o preço
$sqlPreco = "SELECT preco_palavra FROM precos 
             WHERE idioma_origem = :origem 
             AND idioma_destino = :destino";

$resultPreco = $db->fetchQuery($sqlPreco, [
    'origem'  => $origem,
    'destino' => $destino
]);

if ($resultPreco['status'] !== 'success' || empty($resultPreco['data'])) {
    header('Location: ../index.php?p=simulacoes&res=error');
    exit;
}

$precoPalavra = $resultPreco['data'][0]['preco_palavra'];
$precoTotal   = $numeroPalavras * $precoPalavra;

// Busca o ID do utilizador
$sqlUser = "SELECT id FROM utilizadores WHERE email = :email";
$resultUser = $db->fetchQuery($sqlUser, ['email' => $_SESSION['email']]);

if ($resultUser['status'] !== 'success' || empty($resultUser['data'])) {
    header('Location: ../index.php?p=login');
    exit;
}

$utilizadorId = $resultUser['data'][0]['id'];

// Insere a simulação
$sqlInsert = "INSERT INTO simulacoes 
              (utilizador_id, idioma_origem, idioma_destino, numero_palavras, preco_total, observacoes)
              VALUES (:utilizador_id, :origem, :destino, :numero_palavras, :preco_total, :observacoes)";

$result = $db->executeQuery($sqlInsert, [
    'utilizador_id'  => $utilizadorId,
    'origem'         => $origem,
    'destino'        => $destino,
    'numero_palavras' => $numeroPalavras,
    'preco_total'    => $precoTotal,
    'observacoes'    => $observacoes
]);

if ($result['status'] === 'success') {
    $simulacaoId = $result['lastID'];
    header('Location: ../index.php?p=resultado&id=' . $simulacaoId);
}
exit;