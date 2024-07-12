<?php
include __DIR__ . '/../includes/db.php'; // Assurez-vous que le chemin est correct

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $image = $_POST['image'];
  $video_url = $_POST['video_url'];
  $youtube_link = $_POST['youtube_link'];

  try {
    $stmt = $conn->prepare('UPDATE content SET title = :title, description = :description, image = :image, video_url = :video_url, youtube_link = :youtube_link WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':video_url', $video_url);
    $stmt->bindParam(':youtube_link', $youtube_link);
    $stmt->execute();

    $response['success'] = true;
  } catch (PDOException $e) {
    $response['error'] = 'Error updating content: ' . $e->getMessage();
  }
}

echo json_encode($response);
?>