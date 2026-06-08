<main class="container py-5">
<?php if (isset($_GET['res'])): ?>
    <div>
        <?php
        switch ($_GET['res']) {
            case 'error':
                echo "<p class='error'>Ocorreu um erro ao efetuar o registo.</p>";
                break;
        }
        ?>
    </div>
<?php endif; ?>
<form action="pages/doRegister.php" method="POST" class="mx-auto" style="max-width:400px">

    <h2 class="mb-4">Registo</h2>

    <input
        type="text"
        name="nome"
        placeholder="Nome"
        class="form-control mb-3"
    >

    <input
        type="email"
        name="email"
        placeholder="Email"
        class="form-control mb-3"
    >

    <input
        type="password"
        name="password"
        placeholder="Password"
        class="form-control mb-3"
    >

    <button
        type="submit"
        class="btn btn-primary w-100"
    >
        Registar
    </button>

</form>