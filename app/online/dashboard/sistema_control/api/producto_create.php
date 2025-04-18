<?php
// Archivo: api/producto_create.php
// Crea un nuevo producto

require_once('../config/db.php');

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Validar datos requeridos
$campos_requeridos = ['nombre', 'costo_unitario', 'precio_venta', 'stock'];
foreach ($campos_requeridos as $campo) {
    if (!isset($_POST[$campo]) || $_POST[$campo] === '') {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['success' => false, 'message' => "El campo {$campo} es requerido"]);
        exit;
    }
}

// Preparar datos para inserción
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'] ?? '';
$costo_unitario = (float)$_POST['costo_unitario'];
$precio_venta = (float)$_POST['precio_venta'];
$stock = (int)$_POST['stock'];
$id_categoria = isset($_POST['id_categoria']) ? (int)$_POST['id_categoria'] : 1; // Categoría por defecto

try {
    // Conectar a la base de datos
    $db = conectarDB($config);
    
    // Insertar el producto
    $sql = "INSERT INTO productos (nombre, descripcion, costo_unitario, precio_venta, stock, id_categoria, codigo_sku, activo)
            VALUES (:nombre, :descripcion, :costo_unitario, :precio_venta, :stock, :id_categoria, :codigo_sku, 1)";
    
    // Generar un SKU simple basado en las primeras letras del nombre y un número aleatorio
    $codigo_sku = strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $nombre), 0, 3)) . '-' . rand(1000, 9999);
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':costo_unitario', $costo_unitario);
    $stmt->bindParam(':precio_venta', $precio_venta);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':id_categoria', $id_categoria);
    $stmt->bindParam(':codigo_sku', $codigo_sku);
    $stmt->execute();
    
    $id_producto = $db->lastInsertId();
    
    // Registrar en historial de costos
    $sql_historial = "INSERT INTO historial_costos (id_producto, fecha, costo_anterior, costo_nuevo, razon_cambio)
                     VALUES (:id_producto, CURRENT_DATE, 0, :costo_nuevo, 'Creación inicial del producto')";
    
    $stmt_historial = $db->prepare($sql_historial);
    $stmt_historial->bindParam(':id_producto', $id_producto);
    $stmt_historial->bindParam(':costo_nuevo', $costo_unitario);
    $stmt_historial->execute();
    
    // Respuesta exitosa
    echo json_encode(['success' => true, 'id_producto' => $id_producto]);
    
} catch (PDOException $e) {
    error_log("Error en producto_create.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error al registrar el producto: ' . $e->getMessage()]);
}