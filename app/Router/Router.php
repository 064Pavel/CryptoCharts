<?php

namespace App\Router;

class Router
{
    private array $routes = [];

    public function get(string $route, callable $handler)
    {
        $this->routes['GET'][$route] = $handler;
    }

    public function handle(string $url)
    {
        $method = $_SERVER['REQUEST_METHOD'];
//        dd($url);
        if (isset($this->routes[$method][$url])) {
            $handler = $this->routes[$method][$url];
            $handler();
        } else {
            header('HTTP/1.0 404 Not Found');
            echo 'Not Found';
        }
    }
}