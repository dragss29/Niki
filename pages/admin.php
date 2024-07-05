<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/functions.php';

// Vérifier si l'utilisateur est connecté et est administrateur
if (!is_logged_in()) {
    redirect('/login');
}

// Ici vous pouvez ajouter la logique pour gérer le contenu (ajout, modification, suppression)

include __DIR__ . '/../includes/footer.php';
?>