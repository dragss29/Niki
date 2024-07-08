<?php
include __DIR__ . '/../includes/header.php';
?>

<main>
    <section class="form-container">
        <h1>Se Connecter</h1>
        <form action="/pages/login_process.php" method="post">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Se Connecter</button>
            <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
                <p class="error">Nom d'utilisateur ou mot de passe incorrect</p>
            <?php elseif (isset($_GET['error']) && $_GET['error'] == 'empty'): ?>
                <p class="error">Veuillez remplir tous les champs</p>
            <?php endif; ?>
        </form>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>