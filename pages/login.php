<?php
$pageTitle = 'Login';
include __DIR__ . '/../includes/header.php';
?>

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Connexion</h2>
        <form action="/pages/login_process.php" method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">Se souvenir de moi</label>
                </div>
                <div class="text-sm">
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Mot de passe oublié?</a>
                </div>
            </div>
            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Se connecter</button>
            </div>
        </form>
    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
