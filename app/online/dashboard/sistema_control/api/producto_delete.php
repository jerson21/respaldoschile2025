<?php
// Archivo: api/producto_delete.php
// Elimina (desactiva) un producto

require_once('../../sistema_control/config/db.php');

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

try {
    // Conectar a la base de datos
    $db = conectarDB($config);
    
    // En lugar de eliminar físicamente, marcamos como inactivo
    $sql = "UPDATE productos SET activo = 0 WHERE id_producto = :id_producto";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_producto', $id_producto);
    $resultado = $stmt->execute();
    
    if ($resultado) {
        // Respuesta exitosa
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el producto']);
    }
    
} catch (PDOException $e) {
    error_log("Error en producto_delete.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto: ' . $e->getMessage()]);
}
?>