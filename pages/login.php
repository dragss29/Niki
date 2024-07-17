<?php
$pageTitle = 'Login';
include __DIR__ . '/../includes/header.php';
?>

<main>
    <div class="login-form-container">
        <h2>Connexion</h2>
        
        <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid') : ?>
            <div class="error-message">
                <p>Identifiant ou mot de passe incorrect.</p>
            </div>
        <?php endif; ?>

        <form action="/pages/login_process.php" method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-primary-text-color">Nom d'utilisateur</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-accent-color focus:border-accent-color sm:text-sm"
                >
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-primary-text-color">Mot de passe</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-accent-color focus:border-accent-color sm:text-sm"
                >
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-accent-color text-white rounded-md">Se connecter</button>
        </form>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').addEventListener('submit', function(event) {
        // Récupération des valeurs du formulaire
        const username = document.querySelector('#username').value;
        const password = document.querySelector('#password').value;

        // Débogage : Affichage des valeurs dans la console
        console.log('Login form submitted');
        console.log('Username:', username);
        console.log('Password:', password);

        // Affichage du message d’erreur si le formulaire est invalide
        if (!username || !password) {
            console.error('All fields are required!');
            event.preventDefault(); // Empêche l'envoi du formulaire
        }
    });
});
</script>

<?php
include __DIR__ . '/../includes/footer.php';
?>
