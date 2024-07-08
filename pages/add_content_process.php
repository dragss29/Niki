<?php
include __DIR__ . '/../includes/db.php'; // Assure-toi que le chemin est correct pour inclure db.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $video_url = $_POST['video_url'];
  $youtube_link = $_POST['youtube_link'];

  // Gérer le téléchargement de l'image
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageTmpPath = $_FILES['image']['tmp_name'];
    $imageName = basename($_FILES['image']['name']);
    $uploadDir = __DIR__ . '/../uploads/';
    $destPath = $uploadDir . $imageName;

    // Déplacer le fichier téléchargé dans le répertoire de destination
    if (move_uploaded_file($imageTmpPath, $destPath)) {
      $imageUrl = '/uploads/' . $imageName;

      try {
        // Insérer les données dans la base de données
        $stmt = $conn->prepare('INSERT INTO content (title, description, image, video_url, youtube_link) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$title, $description, $imageUrl, $video_url, $youtube_link]);

        // Rediriger vers la page du catalogue après l'ajout réussi
        header('Location: /courses');
        exit();
      } catch (PDOException $e) {
        echo 'Error inserting content: ' . $e->getMessage();
      }
    } else {
      echo 'Error uploading image.';
    }
  } else {
    echo 'No image uploaded or there was an upload error.';
  }
}
?>