<?php

require_once __DIR__ . '/../db/Database.php';
$db = new Database();

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php?p=login');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: ../index.php?p=simulacoes');
    exit;
}

$simulacaoId = (int)$_GET['id'];

$sql = "SELECT s.*, u.nome, u.email 
        FROM simulacoes s 
        JOIN utilizadores u ON s.utilizador_id = u.id 
        WHERE s.id = :id";

$result = $db->fetchQuery($sql, ['id' => $simulacaoId]);

if ($result['status'] !== 'success' || empty($result['data'])) {
    header('Location: ../index.php?p=simulacoes');
    exit;
}

$simulacao = $result['data'][0];
?>

<?php if (isset($_GET['res'])): ?>
    <div>
        <?php
        switch ($_GET['res']) {
            case 'erro_email':
                echo "<p class='alert alert-error'>Erro no envio da simulação.</p>";
                break;
        }
        ?>
    </div>
<?php endif; ?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <h2 class="text-center mb-4">Resultado da Simulação</h2>

            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th>Idioma Origem</th>
                            <td><?php echo htmlspecialchars($simulacao['idioma_origem'], ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th>Idioma Destino</th>
                            <td><?php echo htmlspecialchars($simulacao['idioma_destino'], ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th>Número de Palavras</th>
                            <td><?php echo $simulacao['numero_palavras'] ?></td>
                        </tr>
                        <tr>
                            <th>Preço Total</th>
                            <td><?php echo number_format($simulacao['preco_total'], 2, ',', '.') ?> €</td>
                        </tr>
                        <?php if (!empty($simulacao['observacoes'])): ?>
                        <tr>
                            <th>Observações</th>
                            <td><?php echo htmlspecialchars($simulacao['observacoes'], ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <div class="d-grid gap-3">

                <form action="pages/doEnviarSimulacao.php" method="POST">
                    <input type="hidden" name="simulacao_id" value="<?php echo $simulacaoId ?>">
                    <button type="submit" class="btn btn-primary w-100">
                        Enviar simulação
                    </button>
                </form>

                <a href="../index.php?p=simulacoes" type="submit" class="btn btn-primary w-100">
                    Nova simulação
                </a>
            </div>
        </div>
    </div>
</main>