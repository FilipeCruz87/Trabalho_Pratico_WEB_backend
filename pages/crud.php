<?php

require_once __DIR__ . '/../db/Database.php';

$db = new Database();

if (!isset($_SESSION['email']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: ../index.php?p=login');
    exit;
}

$secao = $_GET['secao'] ?? 'utilizadores';

// Gera o conteúdo da secção
ob_start();
if ($secao === 'utilizadores') {
    include __DIR__ . '/crud/utilizadores.php';
} elseif ($secao === 'precos') {
    include __DIR__ . '/crud/precos.php';
}
$conteudo = ob_get_clean();
?>

<main class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Gestão CRUD</h2>
        <a href="../index.php?p=admin" class="btn btn-primary">Painel Admin</a>
    </div>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link <?php echo $secao === 'utilizadores' ? 'active' : '' ?>"
               href="../index.php?p=crud&secao=utilizadores">
                Utilizadores
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $secao === 'precos' ? 'active' : '' ?>"
               href="../index.php?p=crud&secao=precos">
                Preços
            </a>
        </li>
    </ul>

    <?php if (isset($_GET['res'])): ?>
        <?php $msgs = [
            'criado'  => ['success', 'Criado com sucesso!'],
            'editado' => ['success', 'Editado com sucesso!'],
            'apagado' => ['success', 'Apagado com sucesso!'],
            'error'   => ['danger',  'Ocorreu um erro.'],
        ]; ?>
        <?php if (isset($msgs[$_GET['res']])): ?>
            <div class="alert alert-<?php echo $msgs[$_GET['res']][0] ?>">
                <?php echo $msgs[$_GET['res']][1] ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php echo $conteudo ?>
    </main>