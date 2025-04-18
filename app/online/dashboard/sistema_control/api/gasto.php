<?php
// Archivo: api/gasto.php
// Proporciona los detalles de un gasto específico

require_once('../config/db.php');

// Verificar que se proporcionó un ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Se requiere un ID válido']);
    exit;
}

$id_gasto = $_GET['id'];

// Conectar a la base de datos
$db = conectarDB($config);

// Obtener los detalles del gasto
$gasto = obtenerGasto($db, $id_gasto);

if (!$gasto) {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error' => 'Gasto no encontrado']);
    exit;
}

// Enviar respuesta como JSON
header('Content-Type: application/json');
echo json_encode($gasto);