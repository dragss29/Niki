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
  $stmt = $conn->prepare('SELECT id, title, description, image, video_url, youtube_link FROM content WHERE id = :id');
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

<link rel="stylesheet" href="../css/detail.css">

<main>
  <section class="detail-container">
    <h1><?= htmlspecialchars($content['title']) ?></h1>
    <div class="detail-content">
      <div class="detail-image">
        <img src="<?= htmlspecialchars($content['image']) ?>" alt="<?= htmlspecialchars($content['title']) ?>">
      </div>
      <div class="detail-text">
        <p><?= htmlspecialchars($content['description']) ?></p>
        <?php if ($content['youtube_link']): ?>
          <a href="<?= htmlspecialchars($content['youtube_link']) ?>" target="_blank" class="youtube-link">Regarder sur
            YouTube</a>
        <?php endif; ?>
        <div class="video-container">
          <video width="640" height="360" controls>
            <source src="<?= htmlspecialchars($content['video_url']) ?>" type="video/mp4">
            Votre navigateur ne supporte pas la balise vidéo.
          </video>
        </div>
      </div>
    </div>
  </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>