<?php
// Archivo: api/producto_update.php
// Actualiza un registro de producto existente

require_once('../config/db.php');

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Verificar que se proporcionó un ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['success' => false, 'message' => 'Se requiere un ID válido']);
    exit;
}

$id_producto = $_GET['id'];

// Validar datos requeridos
$campos_requeridos = ['nombre', 'costo_unitario', 'precio_venta', 'stock'];
foreach ($campos_requeridos as $campo) {
    if (!isset($_POST[$campo]) || $_POST[$campo] === '') {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['success' => false, 'message' => "El campo {$campo} es requerido"]);
        exit;
    }
}

// Verificar si se requiere razón de cambio
$costo_anterior = isset($_POST['costo_anterior']) ? (float)$_POST['costo_anterior'] : 0;
$costo_unitario = (float)$_POST['costo_unitario'];

if ($costo_anterior != $costo_unitario && (!isset($_POST['razon_cambio']) || empty($_POST['razon_cambio']))) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['success' => false, 'message' => "Debe proporcionar la razón del cambio de costo"]);
    exit;
}

// Preparar datos para actualización
$datos = [
    'nombre' => $_POST['nombre'],
    'descripcion' => $_POST['descripcion'] ?? '',
    'costo_unitario' => $costo_unitario,
    'costo_anterior' => $costo_anterior,
    'precio_venta' => (float)$_POST['precio_venta'],
    'stock' => (int)$_POST['stock'],
    'razon_cambio' => $_POST['razon_cambio'] ?? 'No especificada'
];

// Conectar a la base de datos
$db = conectarDB($config);

// Actualizar el producto
$resultado = actualizarProducto($db, $id_producto, $datos);

if ($resultado) {
    // Éxito
    echo json_encode(['success' => true]);
} else {
    // Error
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el producto']);
}