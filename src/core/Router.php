<?php

namespace App\Core;

class Router {
    protected $routes = [];

    public function addRoute($method, $path, $handler) {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(){
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Handle query string parameters for controller and action
        $queryParams = [];
        parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ?? '', $queryParams);
        
        // Check if we have controller and action in query parameters
        if (isset($queryParams['c']) && isset($queryParams['a'])) {
            $controller = $queryParams['c'];
            $action = $queryParams['a'];
            
            // Convert to proper namespace and class name
            $controllerClass = "Aydom\\Ecomerce\\Controllers\\" . ucfirst($controller) . "Controller";
            
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass($GLOBALS['conn']);
                
                if (method_exists($controllerInstance, $action)) {
                    return $controllerInstance->$action();
                }
            }
        }
        
        // If no query parameters or invalid controller/action, continue with regular routing
        foreach($this->routes[$method] ?? [] as $route => $handler){
            if($route === $path){
                return $this->callHandler($handler);
            }
        }

        http_response_code(404);
        echo "Page not found";
    }

    public function callHandler($handler){
        if(is_callable($handler)){
            return $handler();
        }

        if (is_string($handler)){
            [$controller, $method] = explode('@', $handler);
            $controller = "App\\Controllers\\{$controller}";

            if(class_exists($controller)){
                return (new $controller)->$method();
            }
        }
        
        return null;
    }
}
?>