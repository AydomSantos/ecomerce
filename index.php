<?php
// Start session
session_start();

// Include necessary files
require_once 'src/config/config.php';
require_once 'src/config/database.php'; 

// Autoload classes
spl_autoload_register(function ($class) {
    $class = str_replace('Aydom\\Ecomerce\\', '', $class);
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/src/' . $class . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// Get controller and action from URL
$controller = $_GET['c'] ?? 'admin';
$action = $_GET['a'] ?? 'dashboard';

$controllerClass = "Aydom\\Ecomerce\\Controllers\\" . ucfirst($controller) . "Controller";

if (class_exists($controllerClass)) {
    $controllerInstance = new $controllerClass($conn);
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        // Improved error handling
        echo "Action '$action' not found in controller '$controllerClass'.";
    }
} else {
    // Improved error handling
    echo "Controller '$controllerClass' not found.";
}