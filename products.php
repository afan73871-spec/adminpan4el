if (file_exists('includes/db_master.php')) {
    require_once 'includes/db_master.php';
} else {
    require_once 'db_master.php';
}

// Validate API Key
validateAPIKey();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Fetch products by Category ID or all products
        if (isset($_GET['category_id'])) {
            $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.category_id = ? AND p.status = 'active'");
            $stmt->execute([$_GET['category_id']]);
        } elseif (isset($_GET['id'])) {
            $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
            $stmt->execute([$_GET['id']]);
            $data = $stmt->fetch();
            if ($data) {
                sendResponse(200, "Product details fetched", $data);
            } else {
                sendResponse(404, "Product not found");
            }
        } else {
            $stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.status = 'active' ORDER BY p.created_at DESC");
        }
        
        $data = $stmt->fetchAll();
        sendResponse(200, "Products fetched successfully", $data);
        break;

    default:
        sendResponse(405, "Method not allowed");
        break;
}
?>
