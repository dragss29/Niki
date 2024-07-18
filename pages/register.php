<?php
$pageTitle = 'Register';
include __DIR__ . '/../includes/header.php';
?>

<main>
    <div class="register-form-container">
        <h2>Register</h2>
        
        <?php if (isset($_GET['error']) && $_GET['error'] === 'username_exists') : ?>
            <div class="error-message">
                <p>Username already taken.</p>
            </div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] === 'password_mismatch') : ?>
            <div class="error-message">
                <p>Passwords are missmatching.</p>
            </div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] === 'missing_fields') : ?>
            <div class="error-message">
                <p>Complete all the field please.</p>
            </div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] === 'registration_failed') : ?>
            <div class="error-message">
                <p>An error occured, please try again.</p>
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'registered') : ?>
            <div class="success-message">
                <p>Registration complete ! You can now login !</p>
            </div>
        <?php endif; ?>

        <form action="/pages/register_process.php" method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-primary-text-color">Username</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-accent-color focus:border-accent-color sm:text-sm"
                >
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-primary-text-color">Email</label>
                <input 
                    type="text" 
                    name="email" 
                    id="email" 
                    required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-accent-color focus:border-accent-color sm:text-sm"
                >
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-primary-text-color">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-accent-color focus:border-accent-color sm:text-sm"
                >
            </div>
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-primary-text-color">Confirm Password</label>
                <input 
                    type="password" 
                    name="confirm_password" 
                    id="confirm_password" 
                    required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-accent-color focus:border-accent-color sm:text-sm"
                >
            </div>
            <div>
                <button 
                    type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-accent-color hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-color"
                >
                    S'inscrire
                </button>
            </div>
        </form>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').addEventListener('submit', function(event) {
        // Récupération des valeurs du formulaire
        const username = document.querySelector('#username').value;
        const email = document.querySelector('#email').value;
        const password = document.querySelector('#password').value;
        const confirmPassword = document.querySelector('#confirm_password').value;

        // Débogage : Affichage des valeurs dans la console
        console.log('Register form submitted');
        console.log('Username:', username);
        console.log('Email:', email);
        console.log('Password:', password);
        console.log('Confirm Password:', confirmPassword);

        // Affichage du message d’erreur si le formulaire est invalide
        if (!username || !password || !confirmPassword) {
            console.error('All fields are required!');
            event.preventDefault(); // Empêche l'envoi du formulaire
        } else if (password !== confirmPassword) {
            console.error('Passwords do not match!');
            event.preventDefault(); // Empêche l'envoi du formulaire
        }
    });
});
</script>

<?php
include __DIR__ . '/../includes/footer.php';
?>
