<?php
// Enable error reporting to debug the 500 error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_OFF); // Prevent PHP 8.1+ from throwing 500 errors on DB connection failure

// Production Database Configuration (InfinityFree)
define('DB_HOST', 'sql211.infinityfree.com');
define('DB_USER', 'if0_41794359');
define('DB_PASS', 'ge0PmauzOh'); // ⚠️ Replace this with your vPanel password
define('DB_NAME', 'if0_41794359_admin'); // ⚠️ Replace 'admin' with whatever you named your database

// Create Database Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8");

// Session Configuration
session_start();

// Company Details
define('COMPANY_NAME', 'GramBazar');
define('COMPANY_ADDRESS', 'GramBazar Hub, India');
define('COMPANY_PHONE', '+91-XXXXXXXXXX');

// Time Zone
date_default_timezone_set('Asia/Kolkata');

// Helper Functions
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

function format_currency($amount) {
    return '₹' . number_format($amount, 2);
}

function format_date($date) {
    return date('d-m-Y h:i A', strtotime($date));
}

function generate_order_number() {
    return 'GB' . date('Ymd') . rand(1000, 9999);
}

function is_logged_in() {
    return isset($_SESSION['admin_id']);
}

function redirect($url) {
    header("Location: $url");
    exit();
}

// Check if user is logged in
if (!is_logged_in() && basename($_SERVER['PHP_SELF']) != 'login.php') {
    redirect('login.php');
}
?>
