<main class="container-fluid flex-grow-1 position-relative">

    <div class="top-right position-absolute top-0 end-0 p-3">

<?php session_start();
if(!isset($_SESSION['email'])): ?>

    <a href="?p=login" class="btn">
        Login
    </a>

    <a href="?p=registo" class="btn">
        Registo
    </a>

<?php else: ?>

    <a href="?p=historico" class="btn">
        Histórico
    </a>

    <a href="?p=logout" class="btn">
        Logout
    </a>

<?php endif; ?>

</div>

    <div class="container-centro d-flex flex-column justify-content-center align-items-center mt-5 h-100">


<?php if(!isset($_SESSION['email'])): ?>

    <h2>
        Bem-vindo
    </h2>

    <p>
        Faça login ou registe-se para realizar simulações de tradução.
    </p>

<?php else: ?>

<form
    action="processar_simulacao.php"
    method="POST"
>

    <h2>
        Nova Simulação
    </h2>

    <label>
        Idioma Origem
    </label>

    <select
        name="origem"
        required
    >

        <?php foreach($origens as $origem): ?>

            <option
                value="<?= htmlspecialchars($origem['idioma_origem']) ?>"
            >
                <?= htmlspecialchars($origem['idioma_origem']) ?>
            </option>

        <?php endforeach; ?>

    </select>

    <br><br>

    <label>
        Idioma Destino
    </label>

    <select
        name="destino"
        required
    >

        <?php foreach($destinos as $destino): ?>

            <option
                value="<?= htmlspecialchars($destino['idioma_destino']) ?>"
            >
                <?= htmlspecialchars($destino['idioma_destino']) ?>
            </option>

        <?php endforeach; ?>

    </select>

    <br><br>

    <label>
        Número de Palavras
    </label>

    <input
        type="number"
        min="1"
        name="numero_palavras"
        required
    >

    <br><br>

    <label>
        Observações
    </label>

    <textarea
        name="observacoes"
        rows="5"
    ></textarea>

    <br><br>

    <button type="submit">
        Simular
    </button>

</form>

<?php endif; ?>

</div>
