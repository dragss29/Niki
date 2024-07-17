<?php
include __DIR__ . '/../includes/db.php';

// Assurer que l'utilisateur est un superadmin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'superadmin') {
    echo '<p class="text-red-500 text-center">You must be logged in as superadmin to access this page.</p>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;

    if ($id) {
        try {
            // Récupérer l'URL de l'image du contenu avant de le supprimer
            $stmt = $conn->prepare('SELECT image FROM content WHERE id = :id');
            $stmt->execute([':id' => $id]);
            $content = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($content) {
                // Supprimer le fichier image
                $imagePath = __DIR__ . '/../uploads/' . basename($content['image']);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                // Supprimer le contenu de la base de données
                $stmt = $conn->prepare('DELETE FROM content WHERE id = :id');
                $stmt->execute([':id' => $id]);

                // Rediriger vers la page admin après la suppression
                header('Location: /admin');
                exit();
            } else {
                echo '<p class="text-red-500 text-center">Content not found.</p>';
            }
        } catch (PDOException $e) {
            echo '<p class="text-red-500 text-center">Error deleting content: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    } else {
        echo '<p class="text-red-500 text-center">Invalid content ID.</p>';
    }
} else {
    echo '<p class="text-red-500 text-center">Invalid request method!</p>';
}
