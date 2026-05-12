<?php
require_once '../../db_connect.php';
validateAPIKey();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendResponse(405, "Method not allowed");
}

$delivery_boy_id = $_GET['delivery_boy_id'] ?? null;

if (!$delivery_boy_id) {
    sendResponse(400, "Delivery Boy ID is required");
}

try {
    // Get orders assigned to this delivery boy that are delivered or cancelled
    $stmt = $pdo->prepare("
        SELECT o.*, 
               c.name as customer_name, c.phone as customer_phone, c.address as customer_address,
               v.name as vendor_name, v.shop_name as vendor_shop_name, v.address as vendor_address, v.phone as vendor_phone
        FROM orders o
        LEFT JOIN customers c ON o.customer_id = c.id
        LEFT JOIN vendors v ON o.vendor_id = v.id
        WHERE o.delivery_boy_id = ? AND o.status IN ('delivered', 'cancelled')
        ORDER BY o.order_date DESC
    ");
    $stmt->execute([$delivery_boy_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch order items for each order
    foreach ($orders as &$order) {
        $stmt_items = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt_items->execute([$order['id']]);
        $order['items'] = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
    }

    sendResponse(200, "Order history fetched successfully", $orders);
} catch (PDOException $e) {
    sendResponse(500, "Database error: " . $e->getMessage());
}
?>
