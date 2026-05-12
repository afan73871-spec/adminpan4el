<?php
/**
 * GramBazar InfinityFree Production Configuration
 * Hosting Volume: vol5_2
 */

// Database Configuration
define('DB_HOST', 'sql306.infinityfree.com');
define('DB_NAME', 'if0_41751867_gram_bazar'); // Replace 'gram_bazar' with your actual DB name suffix
define('DB_USER', 'if0_41751867');
define('DB_PASS', 'YOUR_INFINITYFREE_PASSWORD'); // Enter your InfinityFree account password here
define('DB_CHARSET', 'utf8mb4');

// Site Configuration
define('SITE_NAME', 'GramBazar Admin');
define('SITE_URL', 'http://i79b0hsp.infinityfree.com/');
define('CURRENCY', '₹');

// Upload Paths
define('UPLOAD_PATH_PRODUCTS', 'assets/products/');
define('UPLOAD_PATH_PROFILES', 'assets/profiles/');

// Error Reporting (Set to false in production)
define('DEBUG_MODE', false);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Start Session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
