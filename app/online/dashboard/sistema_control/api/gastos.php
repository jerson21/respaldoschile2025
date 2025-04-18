<?php
// Archivo: api/gastos.php
// Proporciona la lista de gastos recientes

require_once('../config/db.php');

// Conectar a la base de datos
$db = conectarDB($config);

// Obtener gastos recientes
$gastos = obtenerGastosRecientes($db, 10);

// Enviar respuesta como JSON
header('Content-Type: application/json');
echo json_encode($gastos);