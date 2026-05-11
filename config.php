<?php
/**
 * GramBazar Admin Panel Configuration
 */

// Database Configuration
define('DB_HOST', 'db.fr-pari1.bengt.wasmernet.com');
define('DB_NAME', 'gram_bazar');
define('DB_USER', '8b65cfa670e08000921b8045e3f2');
define('DB_PASS', '069f8b65-cfa6-7206-8000-a49dae817a9a');
define('DB_CHARSET', 'utf8mb4');

// Site Configuration
define('SITE_NAME', 'GramBazar Admin');
define('SITE_URL', 'https://grambazaradmin.wasmer.app/'); // Update this to your actual URL
define('CURRENCY', '₹');

// Upload Paths
define('UPLOAD_PATH_PRODUCTS', 'assets/products/');
define('UPLOAD_PATH_PROFILES', 'assets/profiles/');

// Error Reporting (Set to false in production)
define('DEBUG_MODE', true);

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
