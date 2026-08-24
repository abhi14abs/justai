<?php
/**
 * Postryx Live Server Environment Diagnostic Tool
 * Visit: https://postryx.in/test-db.php (or https://postryx.in/public/test-db.php)
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Postryx Live Server Diagnostic Report</h2>";
echo "<hr>";

// 1. PHP Version
echo "<h3>1. PHP Runtime:</h3>";
echo "PHP Version: <strong>" . phpversion() . "</strong> ";
if (version_compare(phpversion(), '8.2.0', '>=')) {
    echo "<span style='color:green;'>✓ Compatible (8.2+)</span><br>";
} else {
    echo "<span style='color:red;'>✕ INCOMPATIBLE! Laravel 11 requires PHP 8.2+. Please upgrade in cPanel 'Select PHP Version'.</span><br>";
}

// 2. Critical Extensions
echo "<h3>2. Required PHP Extensions:</h3>";
$extensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'curl', 'xml', 'fileinfo', 'tokenizer', 'json', 'gd'];
foreach ($extensions as $ext) {
    echo $ext . ": " . (extension_loaded($ext) ? "<span style='color:green;'>✓ Loaded</span>" : "<span style='color:red;'>✕ MISSING</span>") . "<br>";
}

// 3. MySQL Database Connection Test
echo "<h3>3. MySQL Database Connection Test:</h3>";
$host = 'localhost';
$db = 'abhsin4722_postryx';
$user = 'abhsin4722_postryx';
$pass = 'Abhi123@';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "<span style='color:green;'>✓ Database connection to '$db' on '$host' SUCCESSFUL!</span><br>";
    
    // Check tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Found " . count($tables) . " tables in database: " . implode(', ', $tables) . "<br>";
} catch (PDOException $e) {
    echo "<span style='color:red;'>✕ Database connection failed: " . htmlspecialchars($e->getMessage()) . "</span><br>";
    echo "<i>Tip: In cPanel MySQL Databases, make sure user '$user' is added to database '$db' with ALL PRIVILEGES.</i><br>";
}

// 4. Folder Writable Permissions
echo "<h3>4. Directory Permissions Test:</h3>";
$dirs = [
    '../storage' => __DIR__ . '/../storage',
    '../storage/framework' => __DIR__ . '/../storage/framework',
    '../storage/framework/views' => __DIR__ . '/../storage/framework/views',
    '../storage/framework/sessions' => __DIR__ . '/../storage/framework/sessions',
    '../storage/framework/cache' => __DIR__ . '/../storage/framework/cache',
    '../storage/logs' => __DIR__ . '/../storage/logs',
    '../bootstrap/cache' => __DIR__ . '/../bootstrap/cache',
];

foreach ($dirs as $name => $path) {
    if (!file_exists($path)) {
        @mkdir($path, 0775, true);
    }
    $isWritable = is_writable($path);
    echo $name . ": " . ($isWritable ? "<span style='color:green;'>✓ Writable</span>" : "<span style='color:red;'>✕ NOT Writable (Run chmod 775)</span>") . "<br>";
}

// 5. Check .env file
echo "<h3>5. Environment (.env) File Check:</h3>";
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    echo "<span style='color:green;'>✓ .env file exists in root directory (" . filesize($envPath) . " bytes)</span><br>";
} else {
    echo "<span style='color:red;'>✕ .env file is MISSING from root directory!</span><br>";
}

// 6. Check vendor/autoload.php
echo "<h3>6. Composer Vendor Check:</h3>";
$vendorPath = __DIR__ . '/../vendor/autoload.php';
if (file_exists($vendorPath)) {
    echo "<span style='color:green;'>✓ vendor/autoload.php exists</span><br>";
} else {
    echo "<span style='color:red;'>✕ vendor/autoload.php is MISSING! You must upload the 'vendor' folder to the server.</span><br>";
}

echo "<hr><p><i>Delete this test-db.php file after testing for security.</i></p>";
