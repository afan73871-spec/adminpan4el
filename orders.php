<?php
include 'includes/db.php';
include 'includes/header.php';

$status_filter = $_GET['status'] ?? 'all';

$query = "SELECT o.*, c.name as customer_name, v.shop_name as vendor_name, d.name as delivery_boy_name 
          FROM orders o 
          LEFT JOIN customers c ON o.customer_id = c.id 
          LEFT JOIN vendors v ON o.vendor_id = v.id
          LEFT JOIN delivery_boys d ON o.delivery_boy_id = d.id";

if ($status_filter != 'all') {
    $query .= " WHERE o.status = :status";
}
$query .= " ORDER BY o.order_date DESC";

$stmt = $pdo->prepare($query);
if ($status_filter != 'all') {
    $stmt->execute(['status' => $status_filter]);
} else {
    $stmt->execute();
}
$orders = $stmt->fetchAll();
?>

<div class="animate-fade">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 700;">Order Management</h1>
            <p style="color: var(--text-muted);">Manage and track all customer orders from here.</p>
        </div>
        <div class="btn-group">
            <button class="btn btn-outline"><i class="fas fa-download"></i> Export</button>
        </div>
    </div>

    <!-- Status Tabs -->
    <div style="display: flex; gap: 10px; margin-bottom: 2rem; overflow-x: auto; padding-bottom: 5px;">
        <a href="orders.php?status=all" class="btn <?php echo $status_filter == 'all' ? 'btn-primary' : 'btn-outline'; ?>">All Orders</a>
        <a href="orders.php?status=new" class="btn <?php echo $status_filter == 'new' ? 'btn-primary' : 'btn-outline'; ?>">New</a>
        <a href="orders.php?status=processing" class="btn <?php echo $status_filter == 'processing' ? 'btn-primary' : 'btn-outline'; ?>">Processing</a>
        <a href="orders.php?status=shipped" class="btn <?php echo $status_filter == 'shipped' ? 'btn-primary' : 'btn-outline'; ?>">Shipped</a>
        <a href="orders.php?status=delivered" class="btn <?php echo $status_filter == 'delivered' ? 'btn-primary' : 'btn-outline'; ?>">Delivered</a>
        <a href="orders.php?status=cancelled" class="btn <?php echo $status_filter == 'cancelled' ? 'btn-primary' : 'btn-outline'; ?>">Cancelled</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Vendor</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Delivery Boy</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                            <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                            No orders found in this category.
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td style="font-weight: 600;">#<?php echo $order['order_number']; ?></td>
                        <td><?php echo $order['customer_name'] ?? 'Guest'; ?></td>
                        <td><?php echo $order['vendor_name'] ?? '<span style="color:var(--text-muted)">N/A</span>'; ?></td>
                        <td style="font-weight: 600;"><?php echo formatCurrency($order['total_amount']); ?></td>
                        <td><span class="badge <?php echo getStatusBadge($order['status']); ?>"><?php echo ucfirst($order['status']); ?></span></td>
                        <td><?php echo $order['delivery_boy_name'] ?? '<span style="color:var(--text-muted)">Unassigned</span>'; ?></td>
                        <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-outline btn-sm" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button onclick="updateStatus(<?php echo $order['id']; ?>, '<?php echo $order['status']; ?>')" class="btn btn-outline btn-sm" title="Update Status">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Simple Modal for Status Update (Optional implementation) -->
<script>
function updateStatus(id, currentStatus) {
    const newStatus = prompt("Enter new status (new, processing, shipped, delivered, cancelled):", currentStatus);
    if (newStatus && newStatus !== currentStatus) {
        window.location.href = `update_order_status.php?id=${id}&status=${newStatus}`;
    }
}
</script>

<?php include 'includes/footer.php'; ?>
