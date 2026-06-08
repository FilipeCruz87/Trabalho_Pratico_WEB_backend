<?php session_start();
require_once __DIR__ . '/../db/Database.php';
$db = new Database();

$idiomas_origem = [];
$idiomas_destino = [];

if (isset($_SESSION['email'])) {
    $res_origem = $db->fetchQuery(
        "SELECT DISTINCT idioma_origem FROM precos ORDER BY idioma_origem",
        []
    );
    if ($res_origem['status'] === 'success') {
        $idiomas_origem = $res_origem['data'];
    }

    $res_destino = $db->fetchQuery(
        "SELECT DISTINCT idioma_destino FROM precos ORDER BY idioma_destino",
        []
    );
    if ($res_destino['status'] === 'success') {
        $idiomas_destino = $res_destino['data'];
    }
}

if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'admin') {
    header('Location: ../index.php?p=admin');
    exit;
}
?>
<main class="container flex-grow-1 position-relative py-5">

    <div class="position-absolute top-0 end-0 pt-3">

        

        <?php if(!isset($_SESSION['email'])): ?>

            <a href="?p=login" class="btn btn-primary me-2">
                Login
            </a>

            <a href="?p=register" class="btn btn-primary">
                Registo
            </a>

        <?php else: ?>
            
            <?php if(isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'admin'): ?>
                <a href="?p=admin" class="btn btn-primary me-2">
                Controlos
            </a>
                <?php endif; ?>

            <a href="?p=historico" class="btn btn-primary me-2">
                Histórico
            </a>

            <a href="?p=logout" class="btn btn-primary">
                Logout
            </a>

        <?php endif; ?>

    </div>

    <div class="row justify-content-center align-items-center h-100">

        <div class="col-md-8 col-lg-6">
            <br>

            <?php if(!isset($_SESSION['email'])): ?>

                <div >
                    <div >

                        <h2 class="mb-3">
                            Bem-vindo
                        </h2>

                        <p class="mb-4">
                            Faz login para fazer simulações de orçamentos de tradução. 
                        </p>

                    </div>
                </div>

            <?php else: ?>

                <div >
                    <div >

                        <h2 class="text-center mb-4">
                            Nova Simulação
                        </h2>

                        <h3 class="text-center mb-4">Bem vindo, <?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8')?></h3>

                        <form action="/pages/doSimulacao.php" method="POST">

                            <div class="mb-3">
                                <label class="form-label">
                                    Idioma Origem
                                </label>

                                <select name="origem" class="form-select" required>
    <option value="">-- Seleciona --</option>
    <?php foreach ($idiomas_origem as $idioma): ?>
        <option value="<?php echo htmlspecialchars($idioma['idioma_origem'], ENT_QUOTES, 'UTF-8') ?>">
            <?php echo htmlspecialchars($idioma['idioma_origem'], ENT_QUOTES, 'UTF-8') ?>
        </option>
    <?php endforeach; ?>
</select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Idioma Destino
                                </label>

                                <select name="destino" class="form-select" required>
    <option value="">-- Seleciona --</option>
    <?php foreach ($idiomas_destino as $idioma): ?>
        <option value="<?php echo htmlspecialchars($idioma['idioma_destino'], ENT_QUOTES, 'UTF-8') ?>">
            <?php echo htmlspecialchars($idioma['idioma_destino'], ENT_QUOTES, 'UTF-8') ?>
        </option>
    <?php endforeach; ?>
</select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Número de Palavras
                                </label>

                                <input
                                    type="number"
                                    min="1"
                                    name="numero_palavras"
                                    class="form-control"
                                    required
                                >
                            </div>

                            <div class="mb-4">
                                <label class="form-label">
                                    Observações
                                </label>

                                <textarea
                                    name="observacoes"
                                    rows="5"
                                    class="form-control"
                                ></textarea>
                            </div>

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >
                                Simular
                            </button>

                        </form>

                    </div>
                </div>

            <?php endif; ?>

        </div>

    </div>

</main>