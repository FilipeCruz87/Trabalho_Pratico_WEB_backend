<?php

require_once __DIR__ . '/../db/Database.php';
$db = new Database();

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php?p=login');
    exit;
}

$erro    = '';
$sucesso = '';

$res  = $db->fetchQuery("SELECT * FROM utilizadores WHERE email = :email", ['email' => $_SESSION['email']]);
$user = !empty($res['data']) ? $res['data'][0] : null;

if (!$user) {
    header('Location: ../index.php?p=login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = trim($_POST['nome']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $passwordAtual = $_POST['password_atual']       ?? '';
    $passwordNova  = $_POST['password_nova']         ?? '';
    $passwordConf  = $_POST['password_confirmacao']  ?? '';

    if (empty($nome) || empty($email)) {
        $erro = 'Nome e email são obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Email inválido.';
    } elseif (!empty($passwordNova) && strlen($passwordNova) < 8) {
        $erro = 'A nova password deve ter pelo menos 8 caracteres.';
    } elseif (!empty($passwordNova) && $passwordNova !== $passwordConf) {
        $erro = 'A nova password e a confirmação não coincidem.';
    } elseif (!empty($passwordNova) && !password_verify($passwordAtual, $user['password'])) {
        $erro = 'A password atual está incorreta.';
    } else {
        if (!empty($passwordNova)) {
            $hash = password_hash($passwordNova, PASSWORD_DEFAULT);
            $res  = $db->executeQuery(
                "UPDATE utilizadores SET nome=:nome, email=:email, telefone=:telefone, password=:password WHERE id=:id",
                ['nome' => $nome, 'email' => $email, 'telefone' => $telefone, 'password' => $hash, 'id' => $user['id']]
            );
        } else {
            $res = $db->executeQuery(
                "UPDATE utilizadores SET nome=:nome, email=:email, telefone=:telefone WHERE id=:id",
                ['nome' => $nome, 'email' => $email, 'telefone' => $telefone, 'id' => $user['id']]
            );
        }

        if ($res['status'] === 'success') {
            $_SESSION['email'] = $email;
            $_SESSION['nome']  = $nome;
            $sucesso = 'Dados atualizados com sucesso.';
            $res  = $db->fetchQuery("SELECT * FROM utilizadores WHERE id = :id", ['id' => $user['id']]);
            $user = $res['data'][0];
        } else {
            $erro = 'Erro ao atualizar. O email pode já estar em uso.';
        }
    }
}
?>

<main class="container py-5">

    <div class="position-absolute top-0 end-0 pt-3">
        <?php if(isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'admin'): ?>
            <a href="?p=admin" class="btn btn-primary me-2">Controlos</a>
        <?php endif; ?>
        <a href="?p=perfil" class="btn btn-primary me-2">O meu perfil</a>
        <a href="?p=historico" class="btn btn-primary me-2">Histórico</a>
        <a href="?p=logout" class="btn btn-primary">Logout</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">

            <h2 class="text-center mb-4">O meu perfil</h2>

            <?php if (!empty($erro)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            <?php if (!empty($sucesso)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>

            <form method="POST">

                <h5 class="mb-3">Dados pessoais</h5>

                <div class="mb-3">
                    <label class="form-label">Nome *</label>
                    <input type="text" name="nome" class="form-control" required
                           value="<?php echo htmlspecialchars($user['nome'], ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" required
                           value="<?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="mb-4">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="telefone" class="form-control"
                           value="<?php echo htmlspecialchars($user['telefone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <hr>

                <h5 class="mb-3">Alterar password <span class="text-muted fs-6">(opcional)</span></h5>

                <div class="mb-3">
                    <label class="form-label">Password atual</label>
                    <input type="password" name="password_atual" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nova password</label>
                    <input type="password" name="password_nova" class="form-control">
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirmar nova password</label>
                    <input type="password" name="password_confirmacao" class="form-control">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Guardar alterações</button>
                    <a href="?p=simulacoes" class="btn btn-primary w-100">Cancelar</a>
                </div>

            </form>

        </div>
    </div>

</main>