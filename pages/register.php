<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifiez que la connexion est établie
    if ($conn) {
        // Récupérer les données du formulaire
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Préparer et exécuter la requête SQL
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            // Récupérer l'ID de l'utilisateur nouvellement créé
            $user_id = $conn->lastInsertId();

            // Définir les variables de session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;

            // Rediriger vers la page des cours
            header("Location: /courses");
            exit();
        } else {
            echo "Erreur lors de l'enregistrement de l'utilisateur";
        }
    } else {
        echo "Erreur de connexion à la base de données";
    }
}
?>
<main>
    <h1>Register</h1>
    <form method="post" action="/register">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Register</button>
    </form>
</main>

<?php
include __DIR__ . '/../includes/footer.php';
?>