<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mon Site</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-8iOqOztZlkeU6TQXQEC9NOj5w4IksFf+DA+5r+6hH47J0nGcPtwH9ay6HzPVDc5a" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <?php
    $page = basename($_SERVER['SCRIPT_FILENAME'], '.php');
    if (file_exists(__DIR__ . "/../css/{$page}.css")): ?>
        <link rel="stylesheet" href="../css/<?= $page ?>.css">
    <?php endif; ?>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/courses">Catalogue</a></li>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="/login">Login</a></li>
                    <li><a href="/register">Register</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['is_admin'])): ?>
                    <li><a href="/admin">Admin</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/logout">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>



    </header>