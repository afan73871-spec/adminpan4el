<?php
/**
 * GramBazar Database Connector (root version) – error‑free
 */

// API Key (ensure defined)
if (!defined('API_KEY')) {
    define('API_KEY', 'GramBazar_Secure_Key_2024');
}

// Load configuration (try several locations)
$conf = '';
if (file_exists(__DIR__ . '/config.php')) {
    $conf = __DIR__ . '/config.php';
} elseif (file_exists(__DIR__ . '/config.production.php')) {
    $conf = __DIR__ . '/config.production.php';
} elseif (file_exists(__DIR__ . '/../config.php')) {
    $conf = __DIR__ . '/../config.php';
} elseif (file_exists(__DIR__ . '/../config.production.php')) {
    $conf = __DIR__ . '/../config.production.php';
} else {
    die('Error: Configuration file not found.');
}
require_once $conf;

// Set CORS / JSON headers (only if not already sent)
if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, X-API-KEY');
}

// PDO connection – note the correct constant name PDO::ATTR_ERRMODE
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERR_MODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        die(json_encode(['status' => 'error', 'message' => 'DB Error: ' . $e->getMessage()]));
    } else {
        die(json_encode(['status' => 'error', 'message' => 'Database connection failed.']));
    }
}

// Helper: validate API key
if (!function_exists('validateAPIKey')) {
    function validateAPIKey() {
        $headers = function_exists('apache_request_headers') ? apache_request_headers() : [];
        $key = $headers['X-API-KEY'] ?? $_GET['api_key'] ?? '';
        if ($key !== API_KEY) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Invalid API Key']);
            exit;
        }
    }
}

// Helper: send JSON response
if (!function_exists('sendResponse')) {
    function sendResponse($code, $msg, $data = null) {
        http_response_code($code);
        $resp = ['status' => ($code < 400 ? 'success' : 'error'), 'message' => $msg];
        if ($data !== null) $resp['data'] = $data;
        echo json_encode($resp);
        exit;
    }
}
?>
