<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Site</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    ?>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <?php
                session_start(); // Démarrer la session pour vérifier l'état de connexion
                
                // Vérifier si l'utilisateur est connecté
                if (isset($_SESSION['user_id'])) {
                    // Si connecté, afficher ces liens
                    echo '<li><a href="/catalogue">Course</a></li>';
                    echo '<li><a href="/logout">Logout</a></li>';
                } else {
                    // Si non connecté, afficher ces liens
                    echo '<li><a href="/login">Login</a></li>';
                    echo '<li><a href="/register">Register</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>