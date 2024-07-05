<?php
include '../includes/header.php';
include '../includes/db.php';
include '../includes/functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe déjà
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        $errors[] = "Ce nom d'utilisateur est déjà pris.";
    } else {
        // Insérer l'utilisateur dans la base de données
        $hashed_password = hash_password($password);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashed_password]);

        // Rediriger vers la page de connexion après l'inscription
        redirect('login.php');
    }
}
?>

<h2>Inscription</h2>
<form method="post">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">S'inscrire</button>
</form>

<?php
if ($errors) {
    display_error($errors);
}

include '../includes/footer.php';
?>