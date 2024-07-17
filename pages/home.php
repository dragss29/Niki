<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="pt-0 relative w-full h-screen overflow-hidden flex flex-col items-center justify-center bg-gray-900 text-white">
    <!-- Vidéo de fond -->
    <div class="absolute inset-0 overflow-hidden">
        <video autoplay loop muted class="w-full h-full object-cover">
            <source src="/../uploads/test.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>

    <!-- Contenu principal -->
    <div class="relative z-10 p-6 text-center">
        <h1 class="text-5xl font-bold mb-4">Welcome to Our Platform</h1>
        <p class="text-xl mb-6">Discover amazing content and stay updated with the latest news!</p>
        <a href="/courses" class="inline-block bg-blue-500 text-white py-2 px-6 rounded-lg text-lg hover:bg-blue-600">Explore Courses</a>
    </div>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
