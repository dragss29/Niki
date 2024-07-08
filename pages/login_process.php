<?php
include __DIR__ . '/../includes/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  $query = $conn->prepare('SELECT id, username, password FROM users WHERE username = ?');
  $query->execute([$username]);
  $user = $query->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header('Location: /');
  } else {
    echo 'Nom d\'utilisateur ou mot de passe incorrect';
  }
}
?>