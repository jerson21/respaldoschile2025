<?php
// Archivo: api/gasto_create.php
// Crea un nuevo registro de gasto

require_once('../config/db.php');

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Validar datos requeridos
$campos_requeridos = ['fecha', 'descripcion', 'monto', 'id_categoria', 'id_responsable'];
foreach ($campos_requeridos as $campo) {
    if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['success' => false, 'message' => "El campo {$campo} es requerido"]);
        exit;
    }
}

// Preparar datos para inserción
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

// Registrar el gasto
$id_gasto = registrarGasto($db, $datos);

if ($id_gasto) {
    // Éxito
    echo json_encode(['success' => true, 'id_gasto' => $id_gasto]);
} else {
    // Error
    echo json_encode(['success' => false, 'message' => 'Error al registrar el gasto']);
}