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
    header('Location: categories.php');
    exit();
}

// ---------- Fetch Categories ----------
$categories = $pdo->query('SELECT * FROM categories ORDER BY created_at DESC')->fetchAll();
?>

<style>
    :root {
        --glass: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.3);
    }

    .glass-card {
        background: var(--glass);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }

    .premium-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .premium-table th {
        padding: 1rem;
        color: #64748b;
        font-weight: 600;
        text-align: left;
    }

    .premium-table tr {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        transition: transform 0.2s;
    }

    .premium-table tr:hover {
        transform: scale(1.01);
    }

    .premium-table td {
        padding: 1.25rem 1rem;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
    }

    .premium-table td:first-child { border-left: 1px solid #f1f5f9; border-radius: 12px 0 0 12px; }
    .premium-table td:last-child { border-right: 1px solid #f1f5f9; border-radius: 0 12px 12px 0; }

    .btn-action {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 5px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-edit { background: #e0e7ff; color: #4f46e5; }
    .btn-delete { background: #fee2e2; color: #ef4444; }

    .btn-action:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }

    .badge-icon {
        width: 40px;
        height: 40px;
        background: #f1f5f9;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
</style>

<div class="animate-fade">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 700;">Categories</h1>
            <p style="color: #64748b;">Manage product categories and icons.</p>
        </div>
        <button onclick="document.getElementById('addModal').style.display='block'" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Category
        </button>
    </div>

    <!-- Edit Form (if editing) -->
    <?php if (isset($_GET['edit'])): 
        $editStmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
        $editStmt->execute([$_GET['edit']]);
        $editCat = $editStmt->fetch();
        if ($editCat):
    ?>
    <div class="glass-card">
        <h2 style="margin-bottom: 1.5rem;">Edit Category: <?php echo $editCat['name']; ?></h2>
        <form method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?php echo $editCat['id']; ?>">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; align-items: end;">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $editCat['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Icon Class (e.g. fas fa-laptop)</label>
                    <input type="text" name="icon" class="form-control" value="<?php echo $editCat['icon']; ?>">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" class="form-control" value="<?php echo $editCat['description']; ?>">
                </div>
            </div>
            <div style="margin-top: 1.5rem; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update Category</button>
                <a href="categories.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
    <?php endif; endif; ?>

    <!-- Categories Table -->
    <div class="glass-card">
        <table class="premium-table">
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td>
                        <div class="badge-icon">
                            <i class="<?php echo $cat['icon'] ?: 'fas fa-tag'; ?>"></i>
                        </div>
                    </td>
                    <td><strong><?php echo $cat['name']; ?></strong></td>
                    <td><?php echo $cat['description'] ?: '<span style="color:#94a3b8">No description</span>'; ?></td>
                    <td><span class="badge badge-success"><?php echo ucfirst($cat['status']); ?></span></td>
                    <td>
                        <a href="categories.php?edit=<?php echo $cat['id']; ?>" class="btn-action btn-edit" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="categories.php?delete=<?php echo $cat['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Delete this category?')" title="Delete">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Simple Add Modal Placeholder -->
<div id="addModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; width:500px; margin:100px auto; padding:2rem; border-radius:20px;">
        <h2 style="margin-bottom: 1.5rem;">Add New Category</h2>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Icon (FontAwesome Class)</label>
                <input type="text" name="icon" class="form-control" placeholder="fas fa-shopping-basket">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div style="margin-top: 2rem; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="document.getElementById('addModal').style.display='none'" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Category</button>
            </div>
        </form>
    </div>
</div>

<?php 
if (file_exists('includes/footer.php')) {
    include 'includes/footer.php';
} else {
    include 'footer.php';
}
?>
