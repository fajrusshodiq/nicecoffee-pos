<?php
/**
 * Nice Coffee POS - Configuration File
 * Database & Application Settings
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', ''); // Default XAMPP: empty password
define('DB_NAME', 'nicecoffee_pos');
define('DB_PORT', 3306);

// Application Settings
define('APP_NAME', 'Nice Coffee POS');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/nicecoffee-pos');

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Currency
define('CURRENCY', 'Rp');
define('CURRENCY_SYMBOL', 'Rp');

// Receipt Settings
define('RECEIPT_PRINTER_WIDTH', 80); // mm
define('RECEIPT_NAME', 'Nice Coffee');
define('RECEIPT_ADDRESS', 'Jl. Contoh No. 123');
define('RECEIPT_PHONE', '+62-xxx-xxxx');
define('RECEIPT_TAX_ID', 'NPWP: xxxxx');

// Database Connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}

// Helper Functions
function getConnection() {
    global $conn;
    return $conn;
}

function formatRupiah($value) {
    return 'Rp ' . number_format($value, 0, ',', '.');
}

function getCurrentDateTime() {
    return date('Y-m-d H:i:s');
}
?>
