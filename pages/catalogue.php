<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
?>

<section id="catalogue">
    <h1>Catalogue de Contenu</h1>
    <div class="catalogue-grid">
        <?php
        // Récupérer les données depuis la base de données
        $stmt = $conn->prepare("SELECT * FROM contents");
        $stmt->execute();
        $contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Afficher les données dynamiquement
        foreach ($contents as $content) {
            echo '<div class="vignette">';
            echo '<a href="detail.php?id=' . htmlspecialchars($content['id']) . '">';
            echo '<img src="' . htmlspecialchars($content['image']) . '" alt="' . htmlspecialchars($content['title']) . '">';
            echo '<div class="vignette-title">' . htmlspecialchars($content['title']) . '</div>';
            echo '</a>';
            echo '</div>';
        }
        ?>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>