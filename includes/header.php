<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mon Site</title>
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/courses">Courses</a></li>
                    <li><a href="/logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="/login">Login</a></li>
                    <li><a href="/register">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>