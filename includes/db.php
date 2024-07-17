<?php
$host = 'srv1014.hstgr.io';
$dbname = 'u561197304_Nikki';
$username = 'u561197304_AldoAdmin';
$password = 'i.e53ZE,';

// Définir les paramètres de la connexion PDO
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    // Création d'une instance de PDO
    $conn = new PDO($dsn, $username, $password);
    
    // Configurer PDO pour lancer des exceptions en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Vérifier la connexion
    echo "Connection successful!";
} catch (PDOException $e) {
    // Afficher les erreurs de connexion dans les logs PHP
    error_log('Connection failed: ' . $e->getMessage());
    echo 'Connection failed: ' . $e->getMessage();
}
?>
