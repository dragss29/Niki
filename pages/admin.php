<?php
include '../includes/header.php';
include '../includes/db.php';
include '../includes/functions.php';

// Vérifier si l'utilisateur est connecté et est administrateur
if (!is_logged_in()) {
    redirect('login.php');
}

// Ici vous pouvez ajouter la logique pour gérer le contenu (ajout, modification, suppression)

include '../includes/footer.php';
?>