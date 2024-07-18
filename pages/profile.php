<?php
include __DIR__ . '/../includes/db.php'; // Assure-toi que le chemin est correct pour inclure db.php
include __DIR__ . '/../includes/header.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo '<p class="text-red-500 text-center mt-4">You must be logged in to access this page.</p>';
    include __DIR__ . '/../includes/footer.php';
    exit();
}

$userId = $_SESSION['user_id'];

try {
    // Récupérer les informations de l'utilisateur depuis la base de données
    $stmt = $conn->prepare('SELECT id, username, email, subscription FROM users WHERE id = :id');
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '<p class="text-red-500 text-center mt-4">Error fetching user data: ' . htmlspecialchars($e->getMessage()) . '</p>';
}

// Gestion des modifications des informations personnelles
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = [];

    // Validation des données
    if (empty($email)) {
        $errors[] = 'Email is required.';
    }

    if (!empty($password) && strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters long.';
    }

    if (empty($errors)) {
        try {
            $conn->beginTransaction();

            // Mettre à jour les informations de l'utilisateur
            $updateQuery = 'UPDATE users SET email = :email';
            if (!empty($password)) {
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                $updateQuery .= ', password = :password';
            }
            $updateQuery .= ' WHERE id = :id';
            $stmt = $conn->prepare($updateQuery);

            $params = ['email' => $email, 'id' => $userId];
            if (!empty($password)) {
                $params['password'] = $passwordHash;
            }
            $stmt->execute($params);

            $conn->commit();
            echo '<p class="text-green-500 text-center mt-4">Profile updated successfully.</p>';
        } catch (PDOException $e) {
            $conn->rollBack();
            echo '<p class="text-red-500 text-center mt-4">Error updating profile: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    } else {
        foreach ($errors as $error) {
            echo '<p class="text-red-500 text-center mt-4">' . htmlspecialchars($error) . '</p>';
        }
    }
}
?>

<main class="flex flex-col items-center py-8 pt-0 px-4 max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Profile</h1>
    <form method="POST" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <div class="mb-4">
            <label for="username" class="block text-gray-700 mb-2">Username</label>
            <input type="text" id="username" name="username" class="w-full p-2 border border-gray-300 rounded" value="<?= htmlspecialchars($user['username']) ?>" disabled>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 mb-2">Email</label>
            <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 mb-2">New Password (Leave blank to keep current password)</label>
            <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label for="subscription" class="block text-gray-700 mb-2">Subscription</label>
            <input type="text" id="subscription" name="subscription" value="<?= htmlspecialchars($user['subscription']) ?>" class="w-full p-2 border border-gray-300 rounded" disabled>
        </div>
        <div class="flex justify-end">
            <button type="submit" name="update_profile" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600">Update Profile</button>
        </div>
    </form>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
