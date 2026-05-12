<?php
if (file_exists(__DIR__ . '/config.php')) {
    require_once __DIR__ . '/config.php';
} elseif (file_exists(__DIR__ . '/config.production.php')) {
    require_once __DIR__ . '/config.production.php';
} elseif (file_exists(__DIR__ . '/../config.php')) {
    require_once __DIR__ . '/../config.php';
} else {
    require_once __DIR__ . '/../config.production.php';
}

$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (\PDOException $e) {
    if (DEBUG_MODE) {
        die("Database connection failed: " . $e->getMessage());
    } else {
        die("A database error occurred. Please try again later.");
    }
}

// Function to format currency
function formatCurrency($amount) {
    return CURRENCY . number_format($amount, 2);
}

// Function to get status badge class
function getStatusBadge($status) {
    switch ($status) {
        case 'new': return 'badge-info';
        case 'processing': return 'badge-warning';
        case 'shipped': return 'badge-primary';
        case 'delivered': return 'badge-success';
        case 'cancelled': return 'badge-danger';
        default: return 'badge-secondary';
    }
}
?>
