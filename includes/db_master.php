<?php
/**
 * GramBazar Master Database Connector
 * This file is error-free and handles both root and include locations.
 */

// API Security Key
if (!defined('API_KEY')) {
    define('API_KEY', 'GramBazar_Secure_Key_2024');
}

// 1. Find and Load Config
$configPath = "";
if (file_exists(__DIR__ . '/config.php')) { $configPath = __DIR__ . '/config.php'; }
elseif (file_exists(__DIR__ . '/config.production.php')) { $configPath = __DIR__ . '/config.production.php'; }
elseif (file_exists(__DIR__ . '/../config.php')) { $configPath = __DIR__ . '/../config.php'; }
elseif (file_exists(__DIR__ . '/../config.production.php')) { $configPath = __DIR__ . '/../config.production.php'; }

if ($configPath) {
    require_once $configPath;
} else {
    die("Error: Configuration file (config.php) not found.");
}

// 2. Set API Headers
if (!headers_sent()) {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, X-API-KEY");
}

// 3. Database Connection
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
        die(json_encode(["status" => "error", "message" => "DB Error: " . $e->getMessage()]));
    } else {
        die(json_encode(["status" => "error", "message" => "Connection failed."]));
    }
}

// 4. Utility Functions
if (!function_exists('validateAPIKey')) {
    function validateAPIKey() {
        $headers = function_exists('apache_request_headers') ? apache_request_headers() : [];
        $provided_key = $headers['X-API-KEY'] ?? $_GET['api_key'] ?? '';
        if ($provided_key !== API_KEY) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Invalid API Key"]);
            exit();
        }
    }
}

if (!function_exists('sendResponse')) {
    function sendResponse($status_code, $message, $data = null) {
        http_response_code($status_code);
        $response = ["status" => ($status_code < 400 ? "success" : "error"), "message" => $message];
        if ($data !== null) $response["data"] = $data;
        echo json_encode($response);
        exit();
    }
}
?>
