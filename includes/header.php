<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Titre de Page</title>
    <!-- Inclure ici vos feuilles de style CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <?php
                    session_start(); // Démarrer la session pour vérifier l'état de connexion

                    // Vérifier si l'utilisateur est connecté
                    if (isset($_SESSION['user_id'])) {
                        // Si connecté, afficher ces liens
                        echo '<li><a href="catalogue.php">Cours</a></li>';
                        echo '<li><a href="deconnexion.php">Déconnexion</a></li>';
                    } else {
                        // Si non connecté, afficher ces liens
                        echo '<li><a href="pages/login.php">Connexion</a></li>';
                        echo '<li><a href="pages/register.php">Inscription</a></li>';
                    }
                    ?>
                </ul>
            </nav>
    </header>
    <main>
        <!-- Contenu principal commence ici -->
