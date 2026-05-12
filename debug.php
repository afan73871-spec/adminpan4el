<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<html><head><style>
    body { font-family: sans-serif; padding: 40px; background: #f4f7f6; }
    .card { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .success { color: #2ecc71; font-weight: bold; }
    .error { color: #e74c3c; font-weight: bold; }
    pre { background: #eee; padding: 10px; border-radius: 5px; }
</style></head><body>
<div class='card'>
<h1>GramBazar Debug Tool</h1>";

// 1. Check Directory Structure
echo "<h3>1. Directory Check</h3>";
echo "Current directory: " . __DIR__ . "<br>";
$files = scandir(__DIR__);
echo "Files in root: " . implode(', ', $files) . "<br>";

// 2. Check Config File
echo "<h3>2. Config File Check</h3>";
if (file_exists('config.production.php')) {
    echo "<span class='success'>✅ config.production.php found!</span><br>";
    include 'config.production.php';
} elseif (file_exists('config.php')) {
    echo "<span class='success'>✅ config.php found!</span><br>";
    include 'config.php';
} else {
    echo "<span class='error'>❌ No config file found (Checked config.php and config.production.php)</span><br>";
}

// 3. Check Constants
echo "<h3>3. Constants Check</h3>";
if (defined('DB_HOST')) {
    echo "DB_HOST: " . DB_HOST . "<br>";
    echo "DB_NAME: " . DB_NAME . "<br>";
    echo "DB_USER: " . DB_USER . "<br>";
} else {
    echo "<span class='error'>❌ Database constants are not defined.</span><br>";
}

// 4. Check Database Connection
echo "<h3>4. Database Connection Check</h3>";
if (defined('DB_HOST')) {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        echo "<span class='success'>✅ Database connected successfully!</span>";
    } catch (Exception $e) {
        echo "<span class='error'>❌ Database connection failed:</span><br>";
        echo "<pre>" . $e->getMessage() . "</pre>";
        echo "<i>Note: Check if your IP is allowed and if the database name/user/password are correct in InfinityFree panel.</i>";
    }
}

echo "</div></body></html>";
?>
