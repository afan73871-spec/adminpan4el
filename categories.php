<?php
// Fail‑proof includes for db and layout
if (file_exists('includes/db_master.php')) {
    include 'includes/db_master.php';
} else {
    include 'db_master.php';
}
if (file_exists('includes/header.php')) {
    include 'includes/header.php';
} else {
    include 'header.php';
}

// ---------- Handle Form Submissions ----------
// Add new category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $icon = trim($_POST['icon'] ?? '');
    if ($name !== '') {
        $stmt = $pdo->prepare('INSERT INTO categories (name, description, icon) VALUES (?, ?, ?)');
        $stmt->execute([$name, $description, $icon]);
    }
}
// Update existing category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $icon = trim($_POST['icon'] ?? '');
    if ($id > 0 && $name !== '') {
        $stmt = $pdo->prepare('UPDATE categories SET name = ?, description = ?, icon = ? WHERE id = ?');
        $stmt->execute([$name, $description, $icon, $id]);
    }
}
// Delete category
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
    $stmt->execute([$delId]);
    // redirect to avoid resubmission
    header('Location: categories.php');
    exit();
}

// ---------- Fetch Categories for Display ----------
$categories = $pdo->query('SELECT * FROM categories ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories | GramBazar Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body{font-family:'Outfit',sans-serif;background:#f5f7fa;margin:0;padding:2rem;}
        .card{background:#fff;padding:1.5rem;margin-bottom:2rem;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,0.06);}
        h1{margin:0 0 1rem;color:#2d3748;}
        table{width:100%;border-collapse:collapse;}
        th,td{padding:.75rem;text-align:left;border-bottom:1px solid #e2e8f0;}
        th{background:#edf2f7;color:#4a5568;}
        .btn{display:inline-block;padding:.5rem 1rem;background:#6366f1;color:#fff;border:none;border-radius:6px;cursor:pointer;text-decoration:none;font-weight:600;}
        .btn:hover{background:#4f46e5;}
        .edit-form{margin-top:1rem;background:#f9fafb;padding:1rem;border-radius:8px;}
        .form-group{margin-bottom:.75rem;}
        label{display:block;margin-bottom:.25rem;font-weight:600;}
        input,textarea{width:100%;padding:.5rem;border:1px solid #cbd5e0;border-radius:4px;}
    </style>
</head>
<body>
<div class="card">
    <h1>Manage Categories</h1>
    <!-- Add New Category Form -->
    <form method="POST" class="edit-form">
        <input type="hidden" name="action" value="add">
        <div class="form-group"><label>Name</label><input type="text" name="name" required></div>
        <div class="form-group"><label>Description</label><textarea name="description"></textarea></div>
        <div class="form-group"><label>Icon (CSS class or URL)</label><input type="text" name="icon"></div>
        <button type="submit" class="btn">Add Category</button>
    </form>
</div>
<div class="card">
    <h1>Existing Categories</h1>
    <table>
        <thead>
            <tr><th>ID</th><th>Name</th><th>Description</th><th>Icon</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?=htmlspecialchars($cat['id'])?></td>
                <td><?=htmlspecialchars($cat['name'])?></td>
                <td><?=htmlspecialchars($cat['description'])?></td>
                <td><?=htmlspecialchars($cat['icon'])?></td>
                <td>
                    <a href="categories.php?edit=<?= $cat['id'] ?>" class="btn" style="background:#48bb78;">Edit</a>
                    <a href="categories.php?delete=<?= $cat['id'] ?>" class="btn" style="background:#f56565;" onclick="return confirm('Delete this category?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
// ---------- Edit Form (if editing) ----------
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
    $stmt->execute([$editId]);
    $editCat = $stmt->fetch();
    if ($editCat):
?>
<div class="card">
    <h1>Edit Category #<?=htmlspecialchars($editCat['id'])?></h1>
    <form method="POST" class="edit-form">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?=htmlspecialchars($editCat['id'])?>">
        <div class="form-group"><label>Name</label><input type="text" name="name" value="<?=htmlspecialchars($editCat['name'])?>" required></div>
        <div class="form-group"><label>Description</label><textarea name="description"><?=htmlspecialchars($editCat['description'])?></textarea></div>
        <div class="form-group"><label>Icon</label><input type="text" name="icon" value="<?=htmlspecialchars($editCat['icon'])?>"></div>
        <button type="submit" class="btn" style="background:#667eea;">Save Changes</button>
    </form>
</div>
<?php
    endif;
}
?>
<?php
if (file_exists('includes/footer.php')) {
    include 'includes/footer.php';
} else {
    include 'footer.php';
}
?>
</body>
</html>
