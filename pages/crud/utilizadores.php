<?php
$acao = $_GET['acao'] ?? 'listar';
$id   = isset($_GET['id']) ? (int)$_GET['id'] : null;
$erro = '';

if ($acao === 'apagar' && $id) {
    $db->executeQuery("DELETE FROM simulacoes   WHERE utilizador_id = :id", ['id' => $id]);
    $db->executeQuery("DELETE FROM utilizadores WHERE id = :id",            ['id' => $id]);
    header('Location: ../../index.php?p=crud&secao=utilizadores&res=apagado');
    exit;
}

if ($acao === 'criar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = trim($_POST['nome']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $tipo     = $_POST['tipo']          ?? 'cliente';

    if (empty($nome) || empty($email)) {
        $erro = 'Nome e email são obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Email inválido.';
    } else {
        $hash = password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT);
        $res  = $db->executeQuery(
            "INSERT INTO utilizadores (nome, email, password, telefone, tipo)
             VALUES (:nome, :email, :password, :telefone, :tipo)",
            ['nome' => $nome, 'email' => $email, 'password' => $hash,
             'telefone' => $telefone, 'tipo' => $tipo]
        );
        if ($res['status'] === 'success') {
            header('Location: ../../index.php?p=crud&secao=utilizadores&res=criado');
            exit;
        }
        $erro = 'Erro ao criar. O email pode já estar em uso.';
    }
}

if ($acao === 'editar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = trim($_POST['nome']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $tipo     = $_POST['tipo']          ?? 'cliente';

    if (empty($nome) || empty($email)) {
        $erro = 'Nome e email são obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Email inválido.';
    } else {
        $res = $db->executeQuery(
            "UPDATE utilizadores
             SET nome=:nome, email=:email, telefone=:telefone, tipo=:tipo
             WHERE id=:id",
            ['nome' => $nome, 'email' => $email,
             'telefone' => $telefone, 'tipo' => $tipo, 'id' => $id]
        );
        if ($res['status'] === 'success') {
            header('Location: ../../index.php?p=crud&secao=utilizadores&res=editado');
            exit;
        }
        $erro = 'Erro ao editar. O email pode já estar em uso.';
    }
}

ob_start();

if ($acao === 'criar' || $acao === 'editar') {
    $utilizadorEditar = null;
    if ($acao === 'editar' && $id) {
        $res              = $db->fetchQuery("SELECT * FROM utilizadores WHERE id = :id", ['id' => $id]);
        $utilizadorEditar = !empty($res['data']) ? $res['data'][0] : null;
    }
    ?>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <h4><?php echo $acao === 'criar' ? 'Novo Utilizador' : 'Editar Utilizador' ?></h4>
    <?php if ($acao === 'criar'): ?>
        <p class="text-muted">A password inicial é gerada automaticamente.</p>
    <?php endif; ?>

    <form method="POST" class="mt-3" style="max-width:500px">
        <div class="mb-3">
            <label class="form-label">Nome *</label>
            <input type="text" name="nome" class="form-control" required
                   value="<?php echo htmlspecialchars($utilizadorEditar['nome'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" required
                   value="<?php echo htmlspecialchars($utilizadorEditar['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control"
                   value="<?php echo htmlspecialchars($utilizadorEditar['telefone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="mb-4">
            <label class="form-label">Tipo *</label>
            <select name="tipo" class="form-select" required>
                <option value="cliente" <?php echo ($utilizadorEditar['tipo'] ?? 'cliente') === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                <option value="admin"   <?php echo ($utilizadorEditar['tipo'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <?php echo $acao === 'criar' ? 'Criar' : 'Guardar' ?>
            </button>
            <a href="../../index.php?p=crud&secao=utilizadores" class="btn btn-primary">Cancelar</a>
        </div>
    </form>

<?php } else {
    $res          = $db->fetchQuery("SELECT * FROM utilizadores ORDER BY tipo, nome", []);
    $utilizadores = $res['status'] === 'success' ? $res['data'] : [];
    ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Utilizadores</h4>
        <a href="../../index.php?p=crud&secao=utilizadores&acao=criar" class="btn btn-primary">+ Novo</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th><th>Nome</th><th>Email</th><th>Telefone</th><th>Tipo</th><th>Registado em</th><th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilizadores as $u): ?>
                    <tr>
                        <td><?php echo $u['id'] ?></td>
                        <td><?php echo htmlspecialchars($u['nome'],            ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?php echo htmlspecialchars($u['email'],           ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?php echo htmlspecialchars($u['telefone'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <span class="badge <?php echo $u['tipo'] === 'admin' ? 'bg-danger' : 'bg-secondary' ?>">
                                <?php echo $u['tipo'] ?>
                            </span>
                        </td>
                        <td><?php echo date('d/m/Y H:i', strtotime($u['criado_em'])) ?></td>
                        <td class="d-flex gap-1">
                            <a href="../../index.php?p=crud&secao=utilizadores&acao=editar&id=<?php echo $u['id'] ?>"
                               class="btn btn-warning btn-sm">Editar</a>
                            <?php if ($u['email'] !== $_SESSION['email']): ?>
                                <a href="../../index.php?p=crud&secao=utilizadores&acao=apagar&id=<?php echo $u['id'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Apagar utilizador e todo o histórico?')">Apagar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php } ?>