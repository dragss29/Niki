<?php
include __DIR__ . '/../includes/db.php'; // Assure-toi que le chemin vers db.php est correct
include __DIR__ . '/../includes/header.php';

try {
    // Requête pour récupérer les contenus avec la catégorie
    $query = $conn->query('SELECT id, title, description, image, youtube_link, category FROM content');
    $contents = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error fetching contents: ' . $e->getMessage();
}
?>

<main class="flex flex-col items-center py-8 pt-0 px-4 max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Admin - Content Management</h1>

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
                <div class="mb-4">
                    <label for="edit_category" class="block text-gray-700 mb-2">Category</label>
                    <select id="edit_category" name="category" class="w-full p-2 border border-gray-300 rounded">
                        <option value="Therapeutic Yoga">Therapeutic Yoga</option>
                        <option value="Lumbar Health">Lumbar Health</option>
                        <option value="Vinyasa Yoga">Vinyasa Yoga</option>
                        <option value="Mobility">Mobility</option>
                        <option value="Splits">Splits</option>
                        <option value="Handstand">Handstand</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600">Update Content</button>
                </div>
            </form>
            <button id="closeEditModalButton" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full pb-4">
        <?php if (!empty($contents)): ?>
            <?php foreach ($contents as $content): ?>
                <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden relative">
                    <!-- Buttons for Edit and Delete -->
                    <div class="absolute top-2 right-2 flex space-x-2">
                        <button class="text-blue-500 hover:text-blue-700 text-xl" title="Edit Content" onclick="openEditModal(<?= htmlspecialchars(json_encode($content)) ?>)">
                            &#9998;
                        </button>
                        <form action="/delete_content" method="POST">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($content['id']) ?>">
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xl" title="Delete Content" onclick="return confirm('Are you sure you want to delete this content? This action cannot be undone.');">
                                &times;
                            </button>
                        </form>
                    </div>
                    <img src="<?= htmlspecialchars($content['image']) ?>" alt="<?= htmlspecialchars($content['title']) ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-900 text-center"><?= htmlspecialchars($content['title']) ?></h2>
                        <p class="text-gray-600 mt-2"><?= substr(htmlspecialchars($content['description']), 0, 100) . '...' ?></p>
                        <p class="text-blue-500 mt-2"><?= htmlspecialchars($content['category']) ?></p>
                        <a href="<?= htmlspecialchars($content['youtube_link']) ?>" target="_blank" class="mt-4 inline-block bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Watch on YouTube</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500 text-center mt-4">No content available.</p>
        <?php endif; ?>
    </div>

    <button id="openModalButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 mb-6">Add Content</button>
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
                <div class="mb-4">
                    <label for="category" class="block text-gray-700 mb-2">Category</label>
                    <select id="category" name="category" class="w-full p-2 border border-gray-300 rounded">
                        <option value="Therapeutic Yoga">Therapeutic Yoga</option>
                        <option value="Lumbar Health">Lumbar Health</option>
                        <option value="Vinyasa Yoga">Vinyasa Yoga</option>
                        <option value="Mobility">Mobility</option>
                        <option value="Splits">Splits</option>
                        <option value="Handstand">Handstand</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600">Add Content</button>
                </div>
            </form>
            <button id="closeModalButton" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
    // Script to open and close modal for editing content
    function openEditModal(content) {
        document.getElementById('edit_id').value = content.id;
        document.getElementById('edit_title').value = content.title;
        document.getElementById('edit_description').value = content.description;
        document.getElementById('edit_youtube_link').value = content.youtube_link;
        document.getElementById('edit_category').value = content.category;
        document.getElementById('editContentModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editContentModal').classList.add('hidden');
    }

    document.getElementById('closeEditModalButton').addEventListener('click', function() {
        closeEditModal();
    });

    // Script to open and close modal for adding content
    function openAddModal() {
        document.getElementById('addContentModal').classList.remove('hidden');
    }

    function closeAddModal() {
        document.getElementById('addContentModal').classList.add('hidden');
    }

    document.getElementById('openModalButton').addEventListener('click', function() {
        openAddModal();
    });

    document.getElementById('closeModalButton').addEventListener('click', function() {
        closeAddModal();
    });
</script>
