<?php
include __DIR__ . '/../includes/header.php';
?>

<main>
    <section class="form-container">
        <h1>S'inscrire</h1>
        <form action="/pages/register_process.php" method="post">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">S'inscrire</button>
            <?php if (isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
                <p class="success">Inscription réussie ! Vous pouvez vous connecter.</p>
            <?php endif; ?>
        </form>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>