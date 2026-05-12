if (file_exists('includes/db_master.php')) {
    require_once 'includes/db_master.php';
} else {
    require_once 'db_master.php';
}

// Validate API Key
validateAPIKey();

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    sendResponse(405, "Method not allowed. Use POST.");
}

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['action'])) {
    sendResponse(400, "Action required (send_otp or verify_otp)");
}

switch ($input['action']) {
    case 'send_otp':
        if (!isset($input['phone'])) {
            sendResponse(400, "Phone number is required");
        }
        
        $phone = $input['phone'];
        $otp = rand(1000, 9999); // Generate 4-digit OTP
        
        // In a real scenario, you would call WhatsApp API here
        // Example: sendWhatsAppOTP($phone, $otp);
        
        // For testing, we'll just return success (In production, store OTP in DB with expiry)
        sendResponse(200, "OTP sent successfully to $phone", ["otp_debug" => $otp]);
        break;

    case 'verify_otp':
        if (!isset($input['phone']) || !isset($input['otp'])) {
            sendResponse(400, "Phone and OTP are required");
        }
        
        $phone = $input['phone'];
        $otp = $input['otp'];
        
        // Logic: If OTP is 1234 (placeholder) or you verify against DB
        if ($otp == "1234") { // Simplified for demo
            // Check if customer exists
            $stmt = $pdo->prepare("SELECT * FROM customers WHERE phone = ?");
            $stmt->execute([$phone]);
            $customer = $stmt->fetch();
            
            if (!$customer) {
                // Register new customer
                $stmt = $pdo->prepare("INSERT INTO customers (name, phone, status) VALUES (?, ?, 'active')");
                $stmt->execute(["New User", $phone]);
                $customer_id = $pdo->lastInsertId();
                $customer = ["id" => $customer_id, "name" => "New User", "phone" => $phone];
            }
            
            // Generate a simple token (In production use JWT)
            $token = bin2hex(random_bytes(16));
            
            sendResponse(200, "Login successful", [
                "user_id" => $customer['id'],
                "token" => $token,
                "user_data" => $customer
            ]);
        } else {
            sendResponse(401, "Invalid OTP code");
        }
        break;

    default:
        sendResponse(400, "Invalid action");
        break;
}
?>
