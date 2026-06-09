<?php
$acao = $_GET['acao'] ?? 'listar';
$id   = isset($_GET['id']) ? (int)$_GET['id'] : null;
$erro = '';

if ($acao === 'apagar' && $id) {
    $db->executeQuery("DELETE FROM precos WHERE id = :id", ['id' => $id]);
    header('Location: ../../index.php?p=crud&secao=precos&res=apagado');
    exit;
}

if ($acao === 'criar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $origem       = trim($_POST['idioma_origem']  ?? '');
    $destino      = trim($_POST['idioma_destino'] ?? '');
    $precoPalavra = (float)str_replace(',', '.', $_POST['preco_palavra'] ?? 0);

    if (empty($origem) || empty($destino) || $precoPalavra <= 0) {
        $erro = 'Todos os campos são obrigatórios e o preço deve ser maior que 0.';
    } else {
        $res = $db->executeQuery(
            "INSERT INTO precos (idioma_origem, idioma_destino, preco_palavra)
             VALUES (:origem, :destino, :preco)",
            ['origem' => $origem, 'destino' => $destino, 'preco' => $precoPalavra]
        );
        if ($res['status'] === 'success') {
            header('Location: ../../index.php?p=crud&secao=precos&res=criado');
            exit;
        }
        $erro = 'Erro ao criar preço.';
    }
}

if ($acao === 'editar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $origem       = trim($_POST['idioma_origem']  ?? '');
    $destino      = trim($_POST['idioma_destino'] ?? '');
    $precoPalavra = (float)str_replace(',', '.', $_POST['preco_palavra'] ?? 0);

    if (empty($origem) || empty($destino) || $precoPalavra <= 0) {
        $erro = 'Todos os campos são obrigatórios e o preço deve ser maior que 0.';
    } else {
        $res = $db->executeQuery(
            "UPDATE precos SET idioma_origem=:origem, idioma_destino=:destino, preco_palavra=:preco
             WHERE id=:id",
            ['origem' => $origem, 'destino' => $destino, 'preco' => $precoPalavra, 'id' => $id]
        );
        if ($res['status'] === 'success') {
            header('Location: ../../index.php?p=crud&secao=precos&res=editado');
            exit;
        }
        $erro = 'Erro ao editar preço.';
    }
}

ob_start();

if ($acao === 'criar' || $acao === 'editar') {
    $precoEditar = null;
    if ($acao === 'editar' && $id) {
        $res         = $db->fetchQuery("SELECT * FROM precos WHERE id = :id", ['id' => $id]);
        $precoEditar = !empty($res['data']) ? $res['data'][0] : null;
    }
    ?>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <h4><?php echo $acao === 'criar' ? 'Novo Preço' : 'Editar Preço' ?></h4>

    <form method="POST" class="mt-3" style="max-width:400px">
        <div class="mb-3">
            <label class="form-label">Idioma Origem *</label>
            <input type="text" name="idioma_origem" class="form-control" required
                   value="<?php echo htmlspecialchars($precoEditar['idioma_origem'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Idioma Destino *</label>
            <input type="text" name="idioma_destino" class="form-control" required
                   value="<?php echo htmlspecialchars($precoEditar['idioma_destino'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="mb-4">
            <label class="form-label">Preço por Palavra (€) *</label>
            <input type="number" name="preco_palavra" class="form-control"
                   step="0.01" min="0.01" required
                   value="<?php echo $precoEditar['preco_palavra'] ?? '' ?>">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <?php echo $acao === 'criar' ? 'Criar' : 'Guardar' ?>
            </button>
            <a href="../../index.php?p=crud&secao=precos" class="btn btn-primary">Cancelar</a>
        </div>
    </form>

<?php } else {
    $res    = $db->fetchQuery("SELECT * FROM precos ORDER BY idioma_origem, idioma_destino", []);
    $precos = $res['status'] === 'success' ? $res['data'] : [];
    ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Preços por Par de Idiomas</h4>
        <a href="../../index.php?p=crud&secao=precos&acao=criar" class="btn btn-primary">+ Novo</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th><th>Idioma Origem</th><th>Idioma Destino</th><th>Preço / Palavra</th><th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($precos as $p): ?>
                    <tr>
                        <td><?php echo $p['id'] ?></td>
                        <td><?php echo htmlspecialchars($p['idioma_origem'],  ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?php echo htmlspecialchars($p['idioma_destino'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?php echo number_format($p['preco_palavra'], 2, ',', '.') ?> €</td>
                        <td class="d-flex gap-1">
                            <a href="../../index.php?p=crud&secao=precos&acao=editar&id=<?php echo $p['id'] ?>"
                               class="btn btn-warning btn-sm">Editar</a>
                            <a href="../../index.php?p=crud&secao=precos&acao=apagar&id=<?php echo $p['id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Apagar este preço?')">Apagar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php } ?>