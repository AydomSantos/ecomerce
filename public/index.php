<?php
require __DIR__ . '/../vendor/autoload.php';

$router = new App\Core\Router();

// Rotas
$router->addRoute('GET', '/', 'HomeController@index');
$router->addRoute('GET', '/produtos', 'ProductController@list');
$router->addRoute('POST', '/carrinho/add', 'CartController@add');

$router->dispatch();