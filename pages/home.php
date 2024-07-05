<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';
?>

<section class="landing">
  <video autoplay muted loop class="video-bg">
    <source src="uploads/test.mp4" type="video/mp4">
    <!-- Incluez ici des sources supplémentaires pour la compatibilité des navigateurs -->
  </video>
  <div class="landing-content">
    <h1>Votre Titre</h1>
    <p>Texte de description ou call-to-action</p>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>