<?php

require_once __DIR__ . '/../db/Database.php';

$db = new Database();

if (!isset($_SESSION['email']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: ../index.php?p=login');
    exit;
}

if (isset($_POST['apagar_id'])) {
    $apagarId = (int)$_POST['apagar_id'];
    $db->executeQuery("DELETE FROM simulacoes WHERE utilizador_id = :id", ['id' => $apagarId]);
    $db->executeQuery("DELETE FROM utilizadores WHERE id = :id", ['id' => $apagarId]);
    header('Location: ../index.php?p=admin&res=apagado');
    exit;
}

$filtroId = isset($_GET['utilizador_id']) ? (int)$_GET['utilizador_id'] : null;

$resultUsers = $db->fetchQuery(
    "SELECT * FROM utilizadores WHERE tipo = 'cliente' ORDER BY nome",
    []
);
$utilizadores = ($resultUsers['status'] === 'success') ? $resultUsers['data'] : [];

if ($filtroId) {
    $sqlSims = "SELECT s.*, u.nome, u.email 
                FROM simulacoes s 
                JOIN utilizadores u ON s.utilizador_id = u.id 
                WHERE s.utilizador_id = :id
                ORDER BY s.criado_em DESC";
    $resultSims = $db->fetchQuery($sqlSims, ['id' => $filtroId]);
} else {
    $sqlSims = "SELECT s.*, u.nome, u.email 
                FROM simulacoes s 
                JOIN utilizadores u ON s.utilizador_id = u.id 
                ORDER BY s.criado_em DESC";
    $resultSims = $db->fetchQuery($sqlSims, []);
}
$simulacoes = ($resultSims['status'] === 'success') ? $resultSims['data'] : [];

$utilizadorDetalhe = null;
if ($filtroId) {
    foreach ($utilizadores as $u) {
        if ((int)$u['id'] === $filtroId) {
            $utilizadorDetalhe = $u;
            break;
        }
    }
}
?>

<main class="container py-5">

    <div class="text-end mb-3">
        <a href="../index.php?p=crud" class="btn btn-primary me-2">Gestão CRUD</a>
    <a href="?p=logout" class="btn btn-primary">
        Logout
    </a>
</div>


    <h2 class="mb-4">Painel de Administração</h2>

    <?php if (isset($_GET['res']) && $_GET['res'] === 'apagado'): ?>
        <div class="alert alert-success">Dados apagados com sucesso.</div>
    <?php endif; ?>

    <div class="row gap-4">

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Clientes</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php if (empty($utilizadores)): ?>
                            <li class="list-group-item text-muted">Nenhum cliente registado.</li>
                        <?php else: ?>
                            <li class="list-group-item">
                                <a href="../index.php?p=admin" class="text-decoration-none <?php echo !$filtroId ? 'fw-bold' : '' ?>">
                                    Todos os clientes
                                </a>
                            </li>
                            <?php foreach ($utilizadores as $u): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center
                                    <?php echo $filtroId === (int)$u['id'] ? 'bg-light' : '' ?>">
                                    <a href="../index.php?p=admin&utilizador_id=<?php echo $u['id'] ?>"
                                       class="text-decoration-none flex-grow-1">
                                        <?php echo htmlspecialchars($u['nome'], ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                    <form method="POST" onsubmit="return confirm('Apagar <?php echo htmlspecialchars($u['nome'], ENT_QUOTES, 'UTF-8') ?> e todo o seu histórico?')">
                                        <input type="hidden" name="apagar_id" value="<?php echo $u['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">✕</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col">

            <?php if ($utilizadorDetalhe): ?>
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Informações do Cliente</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th>Nome</th>
                                <td><?php echo htmlspecialchars($utilizadorDetalhe['nome'], ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo htmlspecialchars($utilizadorDetalhe['email'], ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <tr>
                                <th>Telefone</th>
                                <td><?php echo htmlspecialchars($utilizadorDetalhe['telefone'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <tr>
                                <th>Registado em</th>
                                <td><?php echo date('d/m/Y H:i', strtotime($utilizadorDetalhe['criado_em'])) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <?php echo $filtroId ? 'Simulações de ' . htmlspecialchars($utilizadorDetalhe['nome'], ENT_QUOTES, 'UTF-8') : 'Todas as Simulações' ?>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($simulacoes)): ?>
                        <p class="p-3 text-muted mb-0">Nenhuma simulação encontrada.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <?php if (!$filtroId): ?>
                                            <th>Cliente</th>
                                        <?php endif; ?>
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
                                            <td><?php echo $s['id'] ?></td>
                                            <?php if (!$filtroId): ?>
                                                <td><?php echo htmlspecialchars($s['nome'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <?php endif; ?>
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
                </div>
            </div>

        </div>
    </div>

</main>