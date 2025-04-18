<?php
// Archivo: api/historial_costos.php
// Proporciona el historial de costos de un producto

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

// Obtener el historial de costos
$historial = obtenerHistorialCostos($db, $id_producto);

// Enviar respuesta como JSON
header('Content-Type: application/json');
echo json_encode($historial);