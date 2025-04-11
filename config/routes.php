<?php
// Define routes for the application
$routes = [
    'home' => [
        'controller' => 'HomeController',
        'actions' => ['index', 'about', 'contact']
    ],
    'product' => [
        'controller' => 'ProductController',
        'actions' => ['list', 'detail', 'create', 'edit', 'delete']
    ],
    'category' => [
        'controller' => 'CategoryController',
        'actions' => ['list', 'create', 'edit', 'delete']
    ],
    'cart' => [
        'controller' => 'CartController',
        'actions' => ['view', 'add', 'remove', 'update', 'checkout']
    ],
    'user' => [
        'controller' => 'UserController',
        'actions' => ['login', 'logout', 'register', 'profile']
    ],
    'admin' => [
        'controller' => 'AdminController',
        'actions' => ['dashboard', 'login', 'logout', 'tasks']
    ]
];

// Default route if none specified
$defaultController = 'home';
$defaultAction = 'index';

// Function to check if a route is valid
function isValidRoute($controller, $action) {
    global $routes;
    
    if (!isset($routes[$controller])) {
        return false;
    }
    
    if (!in_array($action, $routes[$controller]['actions'])) {
        return false;
    }
    
    return true;
}

// Function to get the controller class name
function getControllerClass($controller) {
    global $routes;
    
    if (isset($routes[$controller])) {
        return 'Aydom\\Ecomerce\\Controllers\\' . $routes[$controller]['controller'];
    }
    
    return null;
}