<?php
session_start();
?>
<main class="container flex-grow-1 position-relative py-5">

    <div class="position-absolute top-0 end-0 p-3">

        

        <?php if(!isset($_SESSION['email'])): ?>

            <a href="?p=login" class="btn btn-primary me-2">
                Login
            </a>

            <a href="?p=register" class="btn btn-primary">
                Registo
            </a>

        <?php else: ?>

            <a href="?p=historico" class="btn btn-primary me-2">
                Histórico
            </a>

            <a href="?p=logout" class="btn btn-danger">
                Logout
            </a>

        <?php endif; ?>

    </div>

    <div class="row justify-content-center align-items-center h-100">

        <div class="col-md-8 col-lg-6">

            <?php if(!isset($_SESSION['email'])): ?>

                <div >
                    <div >

                        <h2 class="mb-3">
                            Bem-vindo
                        </h2>

                        <p class="mb-4">
                            Faça login ou registe-se para realizar simulações de tradução.
                        </p>

                    </div>
                </div>

            <?php else: ?>

                <div >
                    <div >

                        <h2 class="text-center mb-4">
                            Nova Simulação
                        </h2>

                        <form action="processar_simulacao.php" method="POST">

                            <div class="mb-3">
                                <label class="form-label">
                                    Idioma Origem
                                </label>

                                <select
                                    name="origem"
                                    class="form-select"
                                    required
                                >
                                    <?php foreach($origens as $origem): ?>
                                        <option value="<?= htmlspecialchars($origem['idioma_origem']) ?>">
                                            <?= htmlspecialchars($origem['idioma_origem']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Idioma Destino
                                </label>

                                <select
                                    name="destino"
                                    class="form-select"
                                    required
                                >
                                    <!-- <?php foreach($destinos as $destino): ?>
                                        <option value="<?= htmlspecialchars($destino['idioma_destino']) ?>">
                                            <?= htmlspecialchars($destino['idioma_destino']) ?>
                                        </option>
                                    <?php endforeach; ?> -->
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