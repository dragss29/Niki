<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $image = $_POST['image'];
  $description = $_POST['description'];

  if (empty($title) || empty($image) || empty($description)) {
    $errors[] = "Tous les champs sont requis.";
  } else {
    // Insérer les données dans la base de données
    $stmt = $conn->prepare("INSERT INTO contents (title, image, description) VALUES (:title, :image, :description)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':description', $description);
    if ($stmt->execute()) {
      header("Location: /catalogue");
      exit();
    } else {
      $errors[] = "Erreur lors de l'ajout du contenu.";
    }
  }
}
?>

<h2>Ajouter une nouvelle vignette</h2>
<form method="post">
  <label for="title">Titre:</label>
  <input type="text" id="title" name="title" required><br><br>

  <label for="image">URL de l'image:</label>
  <input type="text" id="image" name="image" required><br><br>

  <label for="description">Description:</label>
  <textarea id="description" name="description" required></textarea><br><br>

  <button type="submit">Ajouter</button>
</form>

<?php
if ($errors) {
  foreach ($errors as $error) {
    echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
  }
}

include __DIR__ . '/../includes/footer.php';
?>