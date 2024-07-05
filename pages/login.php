<?php
include '../includes/header.php';
include '../includes/db.php';
include '../includes/functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier l'existence de l'utilisateur dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && verify_password($password, $user['password'])) {
        // Authentification réussie, démarrer la session
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        redirect('index.php'); // Rediriger vers la page d'accueil après la connexion
    } else {
        $errors[] = "Identifiants invalides. Veuillez réessayer.";
    }
}
?>

<h2>Connexion</h2>
<form method="post">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Se connecter</button>
</form>

<?php
if ($errors) {
    display_error($errors);
}

include 'includes/footer.php';
?>