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
            return $handler;
        }

        if (is_string($handler)){
            [$controller, $method] = explode('@', $handler);
            $controller = "App\\Controllers\\{$controller}";

            if(class_exists($controller)){
                return (new $controller)->$method();
                }
            }
        }
    }
?>