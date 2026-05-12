<?php
if (file_exists('includes/db.php')) {
    include 'includes/db.php';
} else {
    include 'db.php';
}

if (file_exists('includes/header.php')) {
    include 'includes/header.php';
} else {
    include 'header.php';
}

// Handle Deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Update related orders to null instead of deleting orders
    $pdo->prepare("UPDATE orders SET delivery_boy_id = NULL WHERE delivery_boy_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM delivery_boys WHERE id = ?")->execute([$id]);
    header("Location: delivery_boys.php?msg=deleted");
}

$boys = $pdo->query("SELECT * FROM delivery_boys ORDER BY created_at DESC")->fetchAll();
?>

<div class="animate-fade">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 700;">Delivery Boys</h1>
            <p style="color: var(--text-muted);">Manage your delivery fleet and generate ID cards.</p>
        </div>
        <a href="add_delivery_boy.php" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Add Delivery Boy
        </a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
    <div class="card" style="background: rgba(239, 68, 68, 0.1); border-color: var(--danger); padding: 10px 15px; margin-bottom: 1rem; color: var(--danger); font-weight: 500;">
        <i class="fas fa-check-circle"></i> Delivery boy removed successfully.
    </div>
    <?php endif; ?>

    <div class="grid-2" style="grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));">
        <?php foreach ($boys as $boy): ?>
        <div class="card" style="position: relative;">
            <div style="display: flex; gap: 20px;">
                <img src="<?php echo $boy['profile_pic'] ? $boy['profile_pic'] : 'https://ui-avatars.com/api/?name='.urlencode($boy['name']).'&background=6366f1&color=fff'; ?>" alt="" style="width: 80px; height: 80px; border-radius: 15px; object-fit: cover;">
                <div style="flex: 1;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 4px;"><?php echo $boy['name']; ?></h3>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 10px;">ID: <?php echo $boy['id_card_number']; ?></p>
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <span style="font-size: 0.85rem;"><i class="fas fa-phone" style="width: 20px; color: var(--primary);"></i> <?php echo $boy['phone']; ?></span>
                        <span style="font-size: 0.85rem;"><i class="fas fa-envelope" style="width: 20px; color: var(--primary);"></i> <?php echo $boy['email']; ?></span>
                    </div>
                </div>
            </div>
            
            <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border);">
            
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span class="badge <?php echo $boy['status'] == 'active' ? 'badge-success' : 'badge-danger'; ?>"><?php echo ucfirst($boy['status']); ?></span>
                <div style="display: flex; gap: 8px;">
                    <a href="generate_id_card.php?id=<?php echo $boy['id']; ?>" class="btn btn-outline btn-sm" title="Generate ID Card" target="_blank">
                        <i class="fas fa-id-card"></i> ID Card
                    </a>
                    <a href="edit_delivery_boy.php?id=<?php echo $boy['id']; ?>" class="btn btn-outline btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="delivery_boys.php?delete=<?php echo $boy['id']; ?>" class="btn btn-outline btn-sm" style="color: var(--danger);" onclick="return confirm('Delete this delivery boy?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
