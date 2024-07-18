<?php
include __DIR__ . '/../includes/db.php';

// Assurer que l'utilisateur est un superadmin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'superadmin') {
    echo '<p class="text-red-500 text-center">You must be logged in as superadmin to access this page.</p>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $youtube_link = trim($_POST['youtube_link']);

    // Vérifier et valider le fichier image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $imagePath = __DIR__ . '/../uploads/' . $imageName;

        // Déplacer le fichier image vers le répertoire 'uploads'
        if (move_uploaded_file($imageTmpName, $imagePath)) {
            $imageURL = '/uploads/' . $imageName;
        } else {
            echo '<p class="text-red-500 text-center">Failed to upload image.</p>';
            exit();
        }
    } else {
        echo '<p class="text-red-500 text-center">Image file is required!</p>';
        exit();
    }

    // Valider les données restantes
    if (empty($title) || empty($description) || empty($category)) {
        echo '<p class="text-red-500 text-center">Title, description, and category are required!</p>';
        exit();
    }

    try {
        // Préparer la requête d'insertion
        $stmt = $conn->prepare('INSERT INTO content (title, description, category, image, youtube_link) VALUES (:title, :description, :category, :image, :youtube_link)');
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':category' => $category,
            ':image' => $imageURL,
            ':youtube_link' => $youtube_link,
        ]);

        // Rediriger vers la page admin après l'ajout
        header('Location: /admin');
        exit();
    } catch (PDOException $e) {
        echo '<p class="text-red-500 text-center">Error adding content: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
} else {
    echo '<p class="text-red-500 text-center">Invalid request method!</p>';
}
?>
