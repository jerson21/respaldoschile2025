<?php
namespace App\Core;

class Router
{
    protected array $routes = [];

    public function add(string $method, string $path, string $handler): void
    {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch(string $uri, string $method): void
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                $this->executeHandler($route['handler']);
                return;
            }
        }

        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        echo '404 Not Found';
    }

    protected function executeHandler(string $handler): void
    {
        [$controllerName, $method] = explode('@', $handler);
        // Definir nombre de la clase controlador completa
        $controllerClass = 'App\\Controllers\\' . $controllerName;
        // El literal '\\' en PHP se convierte en una única '\' en la cadena
        $controllerClass = 'App\\Controllers\\' . $controllerName;
        // Nota: 'App\\Controllers\\' en string literal representa App\Controllers\
        $controllerClass = 'App\\Controllers\\' . $controllerName; // <- corregido abajo
        $controllerClass = 'App\\Controllers\\' . $controllerName; // Temporal
        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller {$controllerClass} not found");
        }
        $controller = new $controllerClass();
        if (!method_exists($controller, $method)) {
            throw new \Exception("Method {$method} not found in controller {$controllerClass}");
        }
        call_user_func([$controller, $method]);
    }
}