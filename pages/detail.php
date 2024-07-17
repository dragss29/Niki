<?php
include __DIR__ . '/../includes/db.php'; // Assure-toi que le chemin est correct pour inclure db.php
include __DIR__ . '/../includes/header.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo 'ID manquant';
    exit();
}

$id = intval($_GET['id']);

try {
    $stmt = $conn->prepare('SELECT id, title, description, image, youtube_link FROM content WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $content = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$content) {
        http_response_code(404);
        echo 'Contenu non trouvé';
        exit();
    }
} catch (PDOException $e) {
    echo 'Erreur de requête : ' . $e->getMessage();
}
?>

<main class="min-h-screen bg-gray-100 py-12">
    <section class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-gray-900 mb-8"><?= htmlspecialchars($content['title']) ?></h1>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:flex-shrink-0">
                    <img class="h-48 w-full object-cover md:w-48" src="<?= htmlspecialchars($content['image']) ?>" alt="<?= htmlspecialchars($content['title']) ?>">
                </div>
                <div class="p-8">
                    <p class="mt-2 text-gray-600"><?= htmlspecialchars($content['description']) ?></p>
                    <?php if ($content['youtube_link']): ?>
                        <a href="<?= htmlspecialchars($content['youtube_link']) ?>" target="_blank" class="block mt-4 text-blue-500 hover:underline">Regarder sur YouTube</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
