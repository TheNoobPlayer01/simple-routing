<?php

declare(strict_types=1);

namespace App;

use App\Exception\InvalidRequestMethod;
use App\Exception\InvalidRequestName;

class Router
{
    private array $routes = [];
    
    private array $suppportedHttpMethod = [
            'GET', 'POST'
        ];
    
    public function add(
        string $route,
        callable|array $method,
        string $requestMethod = 'GET'
    ): static {
        
        $requestMethod = strtoupper($requestMethod);
        
        if(in_array($requestMethod, $this->getHttpMethod(), true) !== false)
        {
            $this->routes[$requestMethod][$route] = $method;
            
            return new static();
        }
        
        throw new InvalidRequestMethod();
    }
    
    public function getHttpMethod(): array
    {
        return $this->suppportedHttpMethod;
    }
    
    public function getRoutes(): array
    {
        return $this->routes;
    }
    
    private function parseURL(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        //$uri = rtrim($uri, '/');
        $uri = filter_var($uri, FILTER_SANITIZE_URL);
        return $uri;
    }
    
    public function resolve()
    {
        $uri = $this->parseURL();
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        
        $action = $this->getRoutes()[$requestMethod];
        
        if(!in_array($uri, $action))
        {
            throw new InvalidRequestName();
        }
        
        if(is_callable($action))
        {
            return call_user_func($action);
        }
    }
}