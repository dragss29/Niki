<?php
include __DIR__ . '/../includes/db.php'; // Assure-toi que le chemin est correct pour inclure db.php
include __DIR__ . '/../includes/header.php';

try {
    // Requête pour récupérer les contenus
    $query = $conn->query('SELECT id, title, description, image, video_url, youtube_link FROM content');
    $contents = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error fetching contents: ' . $e->getMessage();
}
?>

<link rel="stylesheet" href="../css/catalogue.css">

<main class="catalogue-container">
    <h1>Catalogue</h1>
    <div class="catalogue-content">
        <?php foreach ($contents as $content): ?>
            <div class="catalogue-item">
                <img src="<?= htmlspecialchars($content['image']) ?>" alt="<?= htmlspecialchars($content['title']) ?>">
                <div class="catalogue-item-info">
                    <h2><?= htmlspecialchars($content['title']) ?></h2>
                    <p><?= htmlspecialchars($content['description']) ?></p>
                    <a href="/detail?id=<?= $content['id'] ?>" class="button">Voir Détail</a>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- Vignette pour ajouter un nouveau contenu -->
        <div class="catalogue-item add-item">
            <button class="add-button" onclick="openModal()">+</button>
        </div>
    </div>
</main>

<!-- Modal pour ajouter un nouveau contenu -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeModal()">&times;</span>
        <h2>Ajouter un nouveau contenu</h2>
        <form action="/add_content_process" method="POST" enctype="multipart/form-data">
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>

            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <label for="video_url">Lien Vidéo</label>
            <input type="text" id="video_url" name="video_url" required>

            <label for="youtube_link">Lien YouTube</label>
            <input type="text" id="youtube_link" name="youtube_link" required>

            <button type="submit">Ajouter</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('addModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('addModal').style.display = 'none';
    }
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>