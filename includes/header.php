<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Niki App'; ?></title>
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <link rel="stylesheet" href="../css/output.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900 font-sans leading-normal">
<header class="bg-gray-800 text-white p-2 fixed w-full top-0 left-0 z-50 shadow-md">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <h1 class="text-center text-xl">
                <a href="/" class="hover:bg-blue-700 p-2 rounded transition duration-300">NikiApp V1.1</a>
            </h1>
            <nav class="space-x-4">
                <a href="/" class="text-white hover:bg-blue-700 p-2 rounded transition duration-300">Home</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/courses" class="text-white hover:bg-blue-700 p-2 rounded transition duration-300">Courses</a>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'superadmin'): ?>
                        <a href="/admin" class="text-white hover:bg-blue-700 p-2 rounded transition duration-300">Admin</a>
                    <?php endif; ?>
                    <a href="/logout" class="text-white hover:bg-blue-700 p-2 rounded transition duration-300">Logout</a>
                    
                <?php else: ?>
                    <a href="/login" class="text-white hover:bg-blue-700 p-2 rounded transition duration-300">Login</a>
                    <a href="/register" class="text-white hover:bg-blue-700 p-2 rounded transition duration-300">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
