<?php
// Archivo: api/productos.php
// Proporciona la lista de productos

require_once('../config/db.php');

// Conectar a la base de datos
$db = conectarDB($config);

// Obtener productos
$productos = obtenerProductos($db);

// Enviar respuesta como JSON
header('Content-Type: application/json');
echo json_encode($productos);