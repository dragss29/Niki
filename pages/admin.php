<?php
include __DIR__ . '/../includes/db.php'; // Assure-toi que le chemin est correct pour inclure db.php
include __DIR__ . '/../includes/header.php';

try {
    // Requête pour récupérer les contenus
    $query = $conn->query('SELECT id, title, description, image FROM content');
    $contents = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error fetching contents: ' . $e->getMessage();
}
?>

<main class="admin-container">
    <h1>Admin - Gestion des Contenus</h1>
    <button id="addContentBtn" class="button">Ajouter une Vignette</button>

    <div class="content-list">
        <?php foreach ($contents as $content): ?>
            <div class="content-item">
                <img src="<?= htmlspecialchars($content['image']) ?>" alt="<?= htmlspecialchars($content['title']) ?>">
                <div class="content-info">
                    <h2><?= htmlspecialchars($content['title']) ?></h2>
                    <p><?= htmlspecialchars($content['description']) ?></p>
                    <button
                        onclick="openEditModal(<?= $content['id'] ?>, '<?= htmlspecialchars($content['title']) ?>', '<?= htmlspecialchars($content['description']) ?>', '<?= htmlspecialchars($content['image']) ?>')">Edit</button>
                    <button onclick="openDeleteModal(<?= $content['id'] ?>)">Delete</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<!-- Modal pour l'ajout d'un contenu -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" id="addModalClose">&times;</span>
        <h2>Ajouter un Contenu</h2>
        <form id="addContentForm" method="POST" action="/add_content_process" enctype="multipart/form-data">
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>

            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit" class="button">Ajouter</button>
        </form>
    </div>
</div>

<!-- Modal pour l'édition d'un contenu -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" id="editModalClose">&times;</span>
        <h2>Éditer le Contenu</h2>
        <form id="editContentForm" method="POST" action="/edit_content" enctype="multipart/form-data">
            <input type="hidden" id="editContentId" name="id">

            <label for="editTitle">Titre</label>
            <input type="text" id="editTitle" name="title" required>

            <label for="editDescription">Description</label>
            <textarea id="editDescription" name="description" required></textarea>

            <label for="editImage">Image (laisser vide pour conserver l'image actuelle)</label>
            <input type="file" id="editImage" name="image" accept="image/*">

            <button type="submit" class="button">Enregistrer les Modifications</button>
        </form>
    </div>
</div>

<!-- Modal pour la suppression d'un contenu -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" id="deleteModalClose">&times;</span>
        <h2>Supprimer le Contenu</h2>
        <p>Êtes-vous sûr de vouloir supprimer ce contenu ?</p>
        <button id="confirmDeleteBtn" class="button">Supprimer</button>
        <button id="cancelDeleteBtn" class="button">Annuler</button>
    </div>
</div>

<script>
    // Ouvrir et fermer les modals
    const addContentBtn = document.getElementById('addContentBtn');
    const addModal = document.getElementById('addModal');
    const addModalClose = document.getElementById('addModalClose');

    const editModal = document.getElementById('editModal');
    const editModalClose = document.getElementById('editModalClose');

    const deleteModal = document.getElementById('deleteModal');
    const deleteModalClose = document.getElementById('deleteModalClose');

    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

    addContentBtn.onclick = () => addModal.style.display = 'block';
    addModalClose.onclick = () => addModal.style.display = 'none';

    function openEditModal(id, title, description, image) {
        document.getElementById('editContentId').value = id;
        document.getElementById('editTitle').value = title;
        document.getElementById('editDescription').value = description;
        document.getElementById('editImage').value = ''; // Réinitialiser le champ d'image
        editModal.style.display = 'block';
    }

    editModalClose.onclick = () => editModal.style.display = 'none';

    function openDeleteModal(id) {
        confirmDeleteBtn.onclick = () => {
            fetch('/delete_content', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // Recharger la page après suppression
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting content');
                });
        };
        deleteModal.style.display = 'block';
    }

    deleteModalClose.onclick = () => deleteModal.style.display = 'none';
    cancelDeleteBtn.onclick = () => deleteModal.style.display = 'none';

    // Fermeture des modals en cliquant en dehors de la modal
    window.onclick = (event) => {
        if (event.target == addModal) addModal.style.display = 'none';
        if (event.target == editModal) editModal.style.display = 'none';
        if (event.target == deleteModal) deleteModal.style.display = 'none';
    };
</script>

<style>
    .admin-container {
        padding: 20px;
    }

    .content-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .content-item {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        width: 200px;
        text-align: center;
    }

    .content-item img {
        max-width: 100%;
        height: auto;
    }

    .content-info {
        padding: 10px;
    }

    .button {
        padding: 10px 15px;
        margin: 5px;
        border: none;
        background-color: #007bff;
        color: white;
        cursor: pointer;
        border-radius: 5px;
    }

    .button:hover {
        background-color: #0056b3;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border-radius: 5px;
        width: 80%;
        max-width: 500px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    form label {
        margin-top: 10px;
    }

    form input,
    form textarea {
        padding: 10px;
        margin-top: 5px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }
</style>

<?php include __DIR__ . '/../includes/footer.php'; ?>