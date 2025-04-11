<?php
// Incluir o autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Incluir a configuração do banco de dados
require_once __DIR__ . '/../config/config.php';

// Obter o controlador e a ação da URL
$controller = $_GET['c'] ?? 'home';
$action = $_GET['a'] ?? 'index';

// Mapear controladores
$controllers = [
    'home' => 'Aydom\\Ecomerce\\Controllers\\HomeController',
    'product' => 'Aydom\\Ecomerce\\Controllers\\ProductController',
    'cart' => 'Aydom\\Ecomerce\\Controllers\\CartController',
    'admin' => 'Aydom\\Ecomerce\\Controllers\\AdminController',
    'category' => 'Aydom\\Ecomerce\\Controllers\\CategoryController',
    'user' => 'Aydom\\Ecomerce\\Controllers\\UserController'
];

// Verificar se o controlador existe
if (!isset($controllers[$controller])) {
    header("HTTP/1.0 404 Not Found");
    echo "Controlador não encontrado!";
    exit;
}

// Instanciar o controlador
$controllerClass = $controllers[$controller];
$controllerInstance = new $controllerClass($conn);

// Verificar se o método existe
if (!method_exists($controllerInstance, $action)) {
    header("HTTP/1.0 404 Not Found");
    echo "Ação não encontrada!";
    exit;
}

// Executar a ação
$controllerInstance->$action();