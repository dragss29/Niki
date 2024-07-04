<?php
// Fonction pour vérifier si un utilisateur est connecté
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Fonction pour rediriger l'utilisateur
function redirect($url) {
    header("Location: $url");
    exit();
}

// Fonction pour hashage sécurisé des mots de passe
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Fonction pour vérifier le mot de passe hashé
function verify_password($password, $hashed_password) {
    return password_verify($password, $hashed_password);
}

// Fonction pour afficher les messages d'erreur
function display_error($errors) {
    echo '<div class="error">';
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
    echo '</div>';
}
?>
