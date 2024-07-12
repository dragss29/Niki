<?php
include __DIR__ . '/../includes/db.php'; // Assurez-vous que le chemin est correct

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  $id = $data['id'];

  try {
    $stmt = $conn->prepare('DELETE FROM content WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $response['success'] = true;
  } catch (PDOException $e) {
    $response['error'] = 'Error deleting content: ' . $e->getMessage();
  }
}

echo json_encode($response);
?>