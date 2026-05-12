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

// Fetch Statistics
// Today's Sales
$today_sales_query = $pdo->query("SELECT SUM(total_amount) as total FROM orders WHERE DATE(order_date) = CURDATE() AND status != 'cancelled'");
$today_sales = $today_sales_query->fetch()['total'] ?? 0;

// Weekly Sales
$weekly_sales_query = $pdo->query("SELECT SUM(total_amount) as total FROM orders WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND status != 'cancelled'");
$weekly_sales = $weekly_sales_query->fetch()['total'] ?? 0;

// Monthly Sales
$monthly_sales_query = $pdo->query("SELECT SUM(total_amount) as total FROM orders WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND status != 'cancelled'");
$monthly_sales = $monthly_sales_query->fetch()['total'] ?? 0;

// Order Counts by Status
$new_orders_count = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'new'")->fetchColumn();
$delivered_orders_count = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'delivered'")->fetchColumn();

// Recent Orders
$recent_orders = $pdo->query("SELECT o.*, c.name as customer_name FROM orders o LEFT JOIN customers c ON o.customer_id = c.id ORDER BY o.order_date DESC LIMIT 5")->fetchAll();

// Data for Chart (Last 7 days)
$chart_data = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $day_name = date('D', strtotime($date));
    $stmt = $pdo->prepare("SELECT SUM(total_amount) as total FROM orders WHERE DATE(order_date) = ? AND status != 'cancelled'");
    $stmt->execute([$date]);
    $total = $stmt->fetch()['total'] ?? 0;
    $chart_data['labels'][] = $day_name;
    $chart_data['values'][] = (float)$total;
}
?>

<div class="animate-fade">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.75rem; font-weight: 700;">Dashboard Overview</h1>
        <p style="color: var(--text-muted);">Welcome back, here's what's happening with your store today.</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="card stat-card">
            <div class="stat-info">
                <h3>Today's Sale</h3>
                <p><?php echo formatCurrency($today_sales); ?></p>
            </div>
            <div class="stat-icon success">
                <i class="fas fa-calendar-day"></i>
            </div>
        </div>
        <div class="card stat-card">
            <div class="stat-info">
                <h3>Weekly Sale</h3>
                <p><?php echo formatCurrency($weekly_sales); ?></p>
            </div>
            <div class="stat-icon info">
                <i class="fas fa-calendar-week"></i>
            </div>
        </div>
        <div class="card stat-card">
            <div class="stat-info">
                <h3>Monthly Sale</h3>
                <p><?php echo formatCurrency($monthly_sales); ?></p>
            </div>
            <div class="stat-icon primary">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
        <div class="card stat-card">
            <div class="stat-info">
                <h3>New Orders</h3>
                <p><?php echo $new_orders_count; ?></p>
            </div>
            <div class="stat-icon warning">
                <i class="fas fa-shopping-basket"></i>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <!-- Sales Chart -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.1rem; font-weight: 600;">Sales Analytics (Last 7 Days)</h3>
                <select class="form-control" style="width: auto; padding: 5px 10px; font-size: 0.8rem;">
                    <option>Weekly</option>
                    <option>Monthly</option>
                </select>
            </div>
            <canvas id="salesChart" height="250"></canvas>
        </div>

        <!-- Order Status Summary -->
        <div class="card">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1.5rem;">Orders by Status</h3>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <?php
                $statuses = ['new', 'processing', 'shipped', 'delivered', 'cancelled'];
                foreach ($statuses as $status) {
                    $count = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = '$status'")->fetchColumn();
                    $total = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
                    $percentage = ($total > 0) ? ($count / $total) * 100 : 0;
                    $badge_class = getStatusBadge($status);
                ?>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 0.85rem;">
                        <span style="text-transform: capitalize; font-weight: 500;"><?php echo $status; ?></span>
                        <span style="color: var(--text-muted);"><?php echo $count; ?></span>
                    </div>
                    <div style="height: 8px; background: var(--bg-body); border-radius: 4px; overflow: hidden;">
                        <div style="width: <?php echo $percentage; ?>%; height: 100%; background: var(--primary); border-radius: 4px;"></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 600;">Recent Orders</h3>
            <a href="orders.php" class="btn btn-outline btn-sm">View All Orders</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_orders as $order): ?>
                    <tr>
                        <td style="font-weight: 600;">#<?php echo $order['order_number']; ?></td>
                        <td><?php echo $order['customer_name'] ?? 'Guest'; ?></td>
                        <td><?php echo formatCurrency($order['total_amount']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                        <td><span class="badge <?php echo getStatusBadge($order['status']); ?>"><?php echo ucfirst($order['status']); ?></span></td>
                        <td>
                            <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-outline btn-sm">
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

<script>
    // Initialize Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($chart_data['labels']); ?>,
            datasets: [{
                label: 'Sales (₹)',
                data: <?php echo json_encode($chart_data['values']); ?>,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { family: 'Outfit' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Outfit' } }
                }
            }
        }
    });
</script>

<?php 
if (file_exists('includes/footer.php')) {
    include 'includes/footer.php';
} else {
    include 'footer.php';
}
?>
