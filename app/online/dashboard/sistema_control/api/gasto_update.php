<?php
// Archivo: api/gasto_update.php
// Actualiza un registro de gasto existente

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

$id_gasto = $_GET['id'];

// Validar datos requeridos
$campos_requeridos = ['fecha', 'descripcion', 'monto', 'id_categoria', 'id_responsable'];
foreach ($campos_requeridos as $campo) {
    if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['success' => false, 'message' => "El campo {$campo} es requerido"]);
        exit;
    }
}

// Preparar datos para actualización
$datos = [
    'fecha' => $_POST['fecha'],
    'descripcion' => $_POST['descripcion'],
    'monto' => $_POST['monto'],
    'id_categoria' => $_POST['id_categoria'],
    'id_responsable' => $_POST['id_responsable'],
    'notas' => $_POST['notas'] ?? ''
];

// Conectar a la base de datos
$db = conectarDB($config);

// Actualizar el gasto
$resultado = actualizarGasto($db, $id_gasto, $datos);

if ($resultado) {
    // Éxito
    echo json_encode(['success' => true]);
} else {
    // Error
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el gasto']);
}