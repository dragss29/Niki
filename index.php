<?php

// Démarrer une session si ce n'est pas déjà fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Définir le chemin racine
define('ROOT_PATH', __DIR__ . '/');

// Routeur simple
$request = $_SERVER['REQUEST_URI'];

// Retirer la chaîne de requête
$request = parse_url($request, PHP_URL_PATH);

// Supprimer le slash final pour uniformité
$request = rtrim($request, '/');

// Traiter les routes définies
$routes = [
    '/' => ROOT_PATH . 'pages/home.php',
    '/login' => ROOT_PATH . 'pages/login.php',
    '/register' => ROOT_PATH . 'pages/register.php',
    '/courses' => function () {
        if (isset($_SESSION['user_id'])) {
            require ROOT_PATH . 'pages/catalogue.php';
        } else {
            header("Location: /login");
            exit();
        }
    },
    '/add_content' => function () {
        if (isset($_SESSION['user_id'])) {
            require ROOT_PATH . 'pages/add_content.php';
        } else {
            header("Location: /login");
            exit();
        }
    },
    '/add_content_process' => ROOT_PATH . 'pages/add_content_process.php',
    '/logout' => function () {
        session_unset();
        session_destroy();
        header("Location: /");
        exit();
    }
];

// Fonction pour gérer les routes
function handleRoute($request, $routes)
{
    foreach ($routes as $route => $action) {
        if ($route === $request) {
            if (is_callable($action)) {
                $action();
            } else {
                require $action;
            }
            return;
        }
    }

    // Traiter les paramètres de requête pour la page de détails
    if (preg_match('/^\/detail$/', $request)) {
        $queryString = $_SERVER['QUERY_STRING'];
        parse_str($queryString, $queryParams);
        $id = isset($queryParams['id']) ? $queryParams['id'] : null;
        if ($id) {
            require ROOT_PATH . 'pages/detail.php';
        } else {
            http_response_code(400);
            echo "Paramètre 'id' manquant.";
        }
        return;
    }

    // Page 404
    http_response_code(404);
    require ROOT_PATH . 'pages/404.php';
}

// Appeler le gestionnaire de route
handleRoute($request, $routes);

?>