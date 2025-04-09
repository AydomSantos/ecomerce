<?php
// Start output buffering to prevent "headers already sent" warnings
ob_start();

// Database configuration
$host = 'localhost';
$dbname = 'ecomerce_db';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Use this for debugging only, comment out in production
    // echo "Conexão Feita com Successo";
} catch(PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit;
}

// Debug function - writes to log instead of outputting directly
function debug($message) {
    $logFile = __DIR__ . '/../logs/debug.log';
    $logDir = dirname($logFile);
    
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[DEBUG] $timestamp - $message\n";
    
    if (is_array($message) || is_object($message)) {
        $logMessage = "[DEBUG] $timestamp - " . json_encode($message) . "\n";
    }
    
    file_put_contents($logFile, $logMessage, FILE_APPEND);
    
    // For development, you can also output to a debug div that won't interfere with headers
    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        echo "<pre class='debug'>" . htmlspecialchars($logMessage) . "</pre>";
    }
}

// Define DEBUG_MODE constant - set to false in production
define('DEBUG_MODE', true);
?>
