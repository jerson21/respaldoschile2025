<?php
/**
 * Definición de rutas de la aplicación
 * Cada ruta es un array con clave:
 * - method: GET|POST|...
 * - path: URI
 * - handler: Controller@method
 */
return [
    [
        'method' => 'GET',
        'path' => '/',
        'handler' => 'HomeController@index',
    ],
    // Ruta del dashboard de pedidos
    [
        'method' => 'GET',
        'path' => '/pedidos',
        'handler' => 'PedidosController@index',
    ],
    // Otras rutas se agregarán aquí
];