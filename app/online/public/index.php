<?php
declare(strict_types=1);
// Imports
use Dotenv\Dotenv;
use App\Core\Router;

require __DIR__ . '/../vendor/autoload.php';
// Cargar variables de entorno desde .env
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}


// Cargar configuración de rutas
$routes = require __DIR__ . '/../config/routes.php';

// Instanciar Router
$router = new Router();

// Registrar rutas
foreach ($routes as $route) {
    $router->add($route['method'], $route['path'], $route['handler']);
}

// Dispatch request
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($uri, $method);