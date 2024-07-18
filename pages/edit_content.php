<?php
include __DIR__ . '/../includes/db.php'; // Assure-toi que le chemin est correct pour inclure db.php

// Vérifie si l'utilisateur est connecté et a le rôle 'superadmin'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'superadmin') {
    echo '<p class="text-red-500 text-center mt-4">You need to be logged in as superadmin to access this page.</p>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $title = isset($_POST['title']) ? $_POST['title'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $category = isset($_POST['category']) ? $_POST['category'] : null;
    $youtube_link = isset($_POST['youtube_link']) ? $_POST['youtube_link'] : null;

    if ($id && $title && $description && $category) {
        try {
            $imagePath = null;

            if (!empty($_FILES['image']['name'])) {
                $uploadDir = __DIR__ . '/../uploads/';
                $uploadFile = $uploadDir . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $imagePath = '/uploads/' . basename($_FILES['image']['name']);
                } else {
                    echo '<p class="text-red-500 text-center mt-4">Failed to upload image.</p>';
                    exit();
                }
            }

            $query = 'UPDATE content SET title = :title, description = :description, category = :category, youtube_link = :youtube_link';
            if ($imagePath) {
                $query .= ', image = :image';
            }
            $query .= ' WHERE id = :id';

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':youtube_link', $youtube_link);
            if ($imagePath) {
                $stmt->bindParam(':image', $imagePath);
            }
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            header('Location: /admin');
            exit();
        } catch (PDOException $e) {
            echo '<p class="text-red-500 text-center mt-4">Error updating content: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    } else {
        echo '<p class="text-red-500 text-center mt-4">Invalid input.</p>';
    }
} else {
    echo '<p class="text-red-500 text-center mt-4">Invalid request method.</p>';
}
?>
