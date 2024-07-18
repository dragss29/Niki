<?php
session_start();
include __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    error_log('Register form submitted');
    error_log("Username: $username");
    error_log("Email: $email");
    error_log("Password: $password");
    error_log("Confirm Password: $confirmPassword");

    if (empty($username) || empty($password) || empty($confirmPassword)) {
        error_log('Error: Missing fields');
        header('Location: /register?error=missing_fields');
        exit;
    }

    if ($password !== $confirmPassword) {
        error_log('Error: Passwords do not match');
        header('Location: /register?error=password_mismatch');
        exit;
    }

    try {
        $stmt = $conn->prepare('SELECT id FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            error_log('Error: Username already exists');
            header('Location: /register?error=username_exists');
            exit;
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare('INSERT INTO users (username, password, email) VALUES (:username, :password, :email)');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Connecter l'utilisateur après l'inscription
            $_SESSION['user_id'] = $conn->lastInsertId();
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = 0;  // Par défaut, l'utilisateur n'est pas admin

            error_log('Registration successful');
            header('Location: /courses');  // Redirection vers /courses après une inscription réussie
            exit();
        } else {
            error_log('Error: Registration failed');
            header('Location: /register?error=registration_failed');
        }
    } catch (PDOException $e) {
        error_log("SQL Error: " . $e->getMessage());
        header('Location: /register?error=registration_failed');
    }
}
?>
