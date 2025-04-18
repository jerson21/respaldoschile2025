<?php
// Archivo: api/comparativa_presupuesto.php
// Proporciona datos de comparativa entre presupuesto y gastos

require_once('../config/db.php');

// Conectar a la base de datos
$db = conectarDB($config);

// Obtener comparativa presupuesto vs gastos
$comparativa = obtenerComparativaPresupuesto($db);

// Enviar respuesta como JSON
header('Content-Type: application/json');
echo json_encode($comparativa);