<?php

// Start a session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Simple router
$request = $_SERVER['REQUEST_URI'];

// Remove query string
$request = parse_url($request, PHP_URL_PATH);

switch ($request) {
    case '/':
        require __DIR__ . '/pages/home.php';
        break;
    case '/login':
        require __DIR__ . '/pages/login.php';
        break;
    case '/register':
        require __DIR__ . '/pages/register.php';
        break;
    case '/courses':
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            require __DIR__ . '/pages/catalogue.php';
        } else {
            // Rediriger vers la page de login ou afficher un message d'erreur
            header("Location: /login");
            exit();
        }
        break;
    case '/logout':
        // Déconnecter l'utilisateur
        session_start();
        session_unset();
        session_destroy();
        header("Location: /");
        exit();
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/pages/404.php';
        break;
}
?>