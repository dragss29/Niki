<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Niki App'; ?></title>
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <link rel="stylesheet" href="../css/output.css" type="text/css">
    </head>
<body class="bg-gray-100 text-gray-900 font-sans leading-normal">
<header class="bg-gray-800 text-white p-4 fixed w-full top-0 left-0 z-50 shadow-md">
    <h1 class="text-center text-xl">Mon Site</h1>
    <nav class="flex justify-around py-4">
        <a href="/" class="text-white hover:bg-blue-700 p-2 rounded transition duration-300">Home</a>
        <a href="/login" class="text-white hover:bg-blue-700 p-2 rounded transition duration-300">Login</a>
        <a href="/register" class="text-white hover:bg-blue-700 p-2 rounded transition duration-300">Register</a>
    </nav>
</header>
<main class="pt-16 max-w-6xl mx-auto">
