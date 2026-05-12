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
    $pdo->prepare("DELETE FROM vendors WHERE id = ?")->execute([$id]);
    header("Location: vendors.php?msg=deleted");
}

$vendors = $pdo->query("SELECT * FROM vendors ORDER BY created_at DESC")->fetchAll();
?>

<div class="animate-fade">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 700;">Vendor Management</h1>
            <p style="color: var(--text-muted);">Monitor and manage your platform vendors.</p>
        </div>
        <a href="add_vendor.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Vendor
        </a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
    <div class="card" style="background: rgba(239, 68, 68, 0.1); border-color: var(--danger); padding: 10px 15px; margin-bottom: 1rem; color: var(--danger); font-weight: 500;">
        <i class="fas fa-check-circle"></i> Vendor removed successfully.
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Shop Name</th>
                        <th>Vendor Name</th>
                        <th>Email & Phone</th>
                        <th>Cert. Number</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vendors as $vendor): ?>
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: var(--primary);"><?php echo $vendor['shop_name']; ?></div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);"><?php echo $vendor['address']; ?></div>
                        </td>
                        <td style="font-weight: 500;"><?php echo $vendor['name']; ?></td>
                        <td>
                            <div style="font-size: 0.85rem;"><?php echo $vendor['email']; ?></div>
                            <div style="font-size: 0.85rem; font-weight: 600;"><?php echo $vendor['phone']; ?></div>
                        </td>
                        <td><span style="font-family: monospace; background: #f1f5f9; padding: 2px 6px; border-radius: 4px;"><?php echo $vendor['certificate_number']; ?></span></td>
                        <td><span class="badge <?php echo $vendor['status'] == 'active' ? 'badge-success' : 'badge-danger'; ?>"><?php echo ucfirst($vendor['status']); ?></span></td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <a href="generate_certificate.php?id=<?php echo $vendor['id']; ?>" class="btn btn-outline btn-sm" title="View Certificate" target="_blank">
                                    <i class="fas fa-certificate"></i>
                                </a>
                                <a href="edit_vendor.php?id=<?php echo $vendor['id']; ?>" class="btn btn-outline btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="vendors.php?delete=<?php echo $vendor['id']; ?>" class="btn btn-outline btn-sm" style="color: var(--danger);" onclick="return confirm('Delete this vendor?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
