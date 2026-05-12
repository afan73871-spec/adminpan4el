<?php
// API Security Key
define('API_KEY', 'GramBazar_Secure_Key_2024');

// Include root config for DB credentials
if (file_exists(__DIR__ . '/config.php')) {
    require_once __DIR__ . '/config.php';
} elseif (file_exists(__DIR__ . '/config.production.php')) {
    require_once __DIR__ . '/config.production.php';
} elseif (file_exists(__DIR__ . '/../config.php')) {
    require_once __DIR__ . '/../config.php';
} else {
    require_once __DIR__ . '/../config.production.php';
}

// Set headers for JSON response
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, X-API-KEY");

// Function to validate API Key
function validateAPIKey() {
    $headers = apache_request_headers();
    $provided_key = $headers['X-API-KEY'] ?? $_GET['api_key'] ?? '';
    
    if ($provided_key !== API_KEY) {
        http_response_code(401);
        echo json_encode([
            "status" => "error",
            "message" => "Unauthorized access. Invalid API Key."
        ]);
        exit();
    }
}

// Database connection using PDO
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERR_MODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $e->getMessage()
    ]);
    exit();
}

// Utility function to send response
function sendResponse($status_code, $message, $data = null) {
    http_response_code($status_code);
    $response = [
        "status" => $status_code == 200 || $status_code == 201 ? "success" : "error",
        "message" => $message
    ];
    if ($data !== null) {
        $response["data"] = $data;
    }
    echo json_encode($response);
    exit();
}
?>
