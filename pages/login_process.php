<?php
session_start();
include __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  try {
    $stmt = $conn->prepare('SELECT id, username, password, is_admin FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['is_admin'] = $user['is_admin'];
      header('Location: /');
      exit();
    } else {
      echo 'Invalid credentials';
    }
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}
?>