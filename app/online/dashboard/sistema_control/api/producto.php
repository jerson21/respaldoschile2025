<?php
// Archivo: api/producto.php
// Proporciona los detalles de un producto específico

require_once('../config/db.php');

// Verificar que se proporcionó un ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Se requiere un ID válido']);
    exit;
}

$id_producto = $_GET['id'];

// Conectar a la base de datos
$db = conectarDB($config);

// Obtener los detalles del producto
$producto = obtenerProducto($db, $id_producto);

if (!$producto) {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error' => 'Producto no encontrado']);
    exit;
}

// Enviar respuesta como JSON
header('Content-Type: application/json');
echo json_encode($producto);