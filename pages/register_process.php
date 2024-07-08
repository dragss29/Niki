<?php
include __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  $passwordHash = password_hash($password, PASSWORD_BCRYPT);

  $query = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
  $query->execute([$username, $email, $passwordHash]);

  header('Location: /login');
}
?>