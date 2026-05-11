<?php
include 'includes/db.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    
    $allowed_statuses = ['new', 'processing', 'shipped', 'delivered', 'cancelled'];
    
    if (in_array($status, $allowed_statuses)) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        header("Location: orders.php?msg=updated");
    } else {
        header("Location: orders.php?error=invalid_status");
    }
} else {
    header("Location: orders.php");
}
?>
