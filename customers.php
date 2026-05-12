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

$customers = $pdo->query("SELECT c.*, (SELECT COUNT(*) FROM orders WHERE customer_id = c.id) as total_orders FROM customers c ORDER BY c.created_at DESC")->fetchAll();
?>

<div class="animate-fade">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 700;">Customer Directory</h1>
            <p style="color: var(--text-muted);">View and manage your registered customer base.</p>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Contact info</th>
                        <th>Address</th>
                        <th>Total Orders</th>
                        <th>Joined Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($customer['name']); ?>&background=random" alt="" style="width: 40px; height: 40px; border-radius: 50%;">
                                <div style="font-weight: 600;"><?php echo $customer['name']; ?></div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 0.85rem;"><?php echo $customer['email']; ?></div>
                            <div style="font-size: 0.85rem; font-weight: 600;"><?php echo $customer['phone']; ?></div>
                        </td>
                        <td style="font-size: 0.85rem; max-width: 200px;"><?php echo $customer['address']; ?></td>
                        <td style="text-align: center;"><span class="badge badge-info"><?php echo $customer['total_orders']; ?></span></td>
                        <td><?php echo date('M d, Y', strtotime($customer['created_at'])); ?></td>
                        <td><span class="badge <?php echo $customer['status'] == 'active' ? 'badge-success' : 'badge-danger'; ?>"><?php echo ucfirst($customer['status']); ?></span></td>
                        <td>
                            <a href="view_customer.php?id=<?php echo $customer['id']; ?>" class="btn btn-outline btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
