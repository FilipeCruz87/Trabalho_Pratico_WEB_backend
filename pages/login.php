<?php require_once __DIR__ . '/../db/Database.php';?>

<main class="container py-5">
<?php if (isset($_GET['res'])): ?>
    <div>
        <?php
        switch ($_GET['res']) {
            case 'ok':
                echo "<p class='alert alert-success'>Registo efetuado com sucesso.</p>";
                break;
            case 'error':
                echo "<p class='alert alert-error'>Ocorreu um erro ao efetuar o login.</p>";
                break;
        }
        ?>
    </div>
<?php endif; ?>
<form action="pages/doLogin.php" method="POST" class="mx-auto" style="max-width:400px">

    <h2 class="mb-4">Login</h2>

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
        Entrar
    </button>

</form>