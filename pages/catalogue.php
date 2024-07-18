<?php
include __DIR__ . '/../includes/db.php'; // Assure-toi que le chemin vers db.php est correct
include __DIR__ . '/../includes/header.php';

try {
    // Requête pour récupérer les contenus avec la catégorie
    $query = $conn->query('SELECT id, title, description, image, youtube_link, category FROM content');
    $contents = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error fetching contents: ' . $e->getMessage();
}
?>

<main class="flex flex-col items-center py-8 pt-0 px-4 max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 mb-8 uppercase text-center">Courses & Videos</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full">
        <?php foreach ($contents as $content): ?>
            <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                <img src="<?= htmlspecialchars($content['image']) ?>" alt="<?= htmlspecialchars($content['title']) ?>" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-black-900"><?= htmlspecialchars($content['title']) ?></h2>
                    <p class="text-blue-500 mt-2"><?= htmlspecialchars($content['category']) ?></p>
                    <p class="text-gray-600 mt-2"><?= substr(htmlspecialchars($content['description']), 0, 100) . '...' ?></p>
                    <a href="<?= htmlspecialchars($content['youtube_link']) ?>" target="_blank" class="mt-4 inline-block bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Watch on YouTube</a>
                    <a href="/detail?id=<?= $content['id'] ?>" class="mt-2 inline-block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">View Details</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
