<?php
include __DIR__ . '/../includes/db.php'; // Assure-toi que le chemin est correct pour inclure db.php
include __DIR__ . '/../includes/header.php';

// Vérifie si l'utilisateur est connecté et a le rôle 'superadmin'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'superadmin') {
    echo '<p class="text-red-500 text-center mt-4">You need to be logged in as superadmin to access this page.</p>';
    include __DIR__ . '/../includes/footer.php';
    exit();
}

try {
    // Récupérer les contenus depuis la base de données
    $query = $conn->query('SELECT id, title, description, image, youtube_link FROM content');
    $contents = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '<p class="text-red-500 text-center mt-4">Error fetching contents: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>

<main class="py-10 px-4 max-w-6xl mx-auto bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-center">Admin - Content Management</h1>
    <button id="openModalButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600">Add Content</button>

    <!-- Modal Add Content -->
    <div id="addContentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <h2 class="text-2xl font-bold mb-4">Add New Content</h2>
            <form id="addContentForm" action="/add_content" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 mb-2">Title</label>
                    <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" class="w-full p-2 border border-gray-300 rounded" rows="4" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="youtube_link" class="block text-gray-700 mb-2">YouTube Link</label>
                    <input type="url" id="youtube_link" name="youtube_link" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 mb-2">Image File</label>
                    <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded" accept="image/*" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600">Add Content</button>
                </div>
            </form>
            <button id="closeModalButton" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>
    </div>

    <!-- Modal Edit Content -->
    <div id="editContentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <h2 class="text-2xl font-bold mb-4">Edit Content</h2>
            <form id="editContentForm" action="/edit_content" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit_id" name="id">
                <div class="mb-4">
                    <label for="edit_title" class="block text-gray-700 mb-2">Title</label>
                    <input type="text" id="edit_title" name="title" class="w-full p-2 border border-gray-300 rounded" required>
                </div>
                <div class="mb-4">
                    <label for="edit_description" class="block text-gray-700 mb-2">Description</label>
                    <textarea id="edit_description" name="description" class="w-full p-2 border border-gray-300 rounded" rows="4" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="edit_youtube_link" class="block text-gray-700 mb-2">YouTube Link</label>
                    <input type="url" id="edit_youtube_link" name="youtube_link" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label for="edit_image" class="block text-gray-700 mb-2">Image File (Leave blank to keep the current image)</label>
                    <input type="file" id="edit_image" name="image" class="w-full p-2 border border-gray-300 rounded" accept="image/*">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600">Update Content</button>
                </div>
            </form>
            <button id="closeEditModalButton" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php if (!empty($contents)): ?>
            <?php foreach ($contents as $content): ?>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col items-center relative">
                    <form action="/delete_content" method="POST" class="absolute top-2 right-2">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($content['id']) ?>">
                        <button type="submit" class="text-red-500 hover:text-red-700 text-xl" title="Delete Content" onclick="return confirm('Are you sure you want to delete this content? This action cannot be undone.');">
                            &times;
                        </button>
                    </form>
                    <button class="text-blue-500 hover:text-blue-700 text-xl absolute top-2 left-2" title="Edit Content" onclick="openEditModal(<?= htmlspecialchars(json_encode($content)) ?>)">
                        &#9998;
                    </button>
                    <img src="<?= htmlspecialchars($content['image']) ?>" alt="<?= htmlspecialchars($content['title']) ?>" class="w-full h-32 object-cover mb-4 rounded">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($content['title']) ?></h2>
                        <p class="text-gray-600 mb-4"><?= htmlspecialchars($content['description']) ?></p>
                        <a href="<?= htmlspecialchars($content['youtube_link']) ?>" target="_blank" class="text-blue-500 hover:underline mb-2 block">YouTube Link</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500 text-center mt-4">No content available.</p>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
document.getElementById('openModalButton').addEventListener('click', function() {
    document.getElementById('addContentModal').classList.remove('hidden');
});

document.getElementById('closeModalButton').addEventListener('click', function() {
    document.getElementById('addContentModal').classList.add('hidden');
});

document.getElementById('closeEditModalButton').addEventListener('click', function() {
    document.getElementById('editContentModal').classList.add('hidden');
});

function openEditModal(content) {
    document.getElementById('edit_id').value = content.id;
    document.getElementById('edit_title').value = content.title;
    document.getElementById('edit_description').value = content.description;
    document.getElementById('edit_youtube_link').value = content.youtube_link;
    document.getElementById('edit_image').value = ''; // Pour ne pas conserver le fichier précédent
    document.getElementById('editContentModal').classList.remove('hidden');
}
</script>
