<?php
session_start();
include __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    error_log('Login form submitted');
    error_log("Username: $username");
    error_log("Password: $password");

    try {
        $stmt = $conn->prepare('SELECT id, username, password, role FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            error_log('Login successful');
            header('Location: /courses'); // Redirection vers /courses après une connexion réussie
            exit();
        } else {
            error_log('Error: Invalid credentials');
            header('Location: /login?error=invalid');
        }
    } catch (PDOException $e) {
        error_log("SQL Error: " . $e->getMessage());
        header('Location: /login?error=invalid');
    }
}
?>

