<?php

require_once __DIR__ . '/../db/Database.php';

$db = new Database();

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php?p=login');
    exit;
}

$sqlUser = "SELECT id FROM utilizadores WHERE email = :email";
$resultUser = $db->fetchQuery($sqlUser, ['email' => $_SESSION['email']]);

if ($resultUser['status'] !== 'success' || empty($resultUser['data'])) {
    header('Location: ../index.php?p=login');
    exit;
}

$utilizadorId = $resultUser['data'][0]['id'];

$sql = "SELECT * FROM simulacoes WHERE utilizador_id = :id ORDER BY criado_em DESC";
$result = $db->fetchQuery($sql, ['id' => $utilizadorId]);

$simulacoes = ($result['status'] === 'success') ? $result['data'] : [];
?>

<main class="container py-5">

    <h2 class="mb-4">Histórico de Simulações</h2>

    <?php if (isset($_GET['res']) && $_GET['res'] === 'enviado'): ?>
        <div class="alert alert-success">Simulação enviada com sucesso ao admin!</div>
    <?php endif; ?>

    <?php if (empty($simulacoes)): ?>
        <div class="alert alert-info">Ainda não tens simulações.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Palavras</th>
                        <th>Preço Total</th>
                        <th>Observações</th>
                        <th>Estado</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($simulacoes as $s): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($s['idioma_origem'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?php echo htmlspecialchars($s['idioma_destino'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?php echo $s['numero_palavras'] ?></td>
                            <td><?php echo number_format($s['preco_total'], 2, ',', '.') ?> €</td>
                            <td><?php echo htmlspecialchars($s['observacoes'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <?php if ($s['enviada']): ?>
                                    <span class="badge bg-success">Enviada</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Por enviar</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($s['criado_em'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a href="../index.php?p=simulacoes" class="btn btn-primary mt-3 mx-1">Nova Simulação</a>
    <a href="?p=logout" class="btn btn-primary mt-3 mx-1">Logout</a>

</main>