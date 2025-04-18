<?php
// Archivo: api/categorias.php
// Proporciona la lista de categorías de gastos

require_once('../config/db.php');

// Conectar a la base de datos
$db = conectarDB($config);

// Obtener categorías
$categorias = obtenerCategoriasGastos($db);

// Enviar respuesta como JSON
header('Content-Type: application/json');
echo json_encode($categorias);