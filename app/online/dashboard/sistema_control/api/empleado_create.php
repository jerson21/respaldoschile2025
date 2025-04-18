<?php
// Archivo: api/empleado.php
// Proporciona los detalles de un empleado específico

require_once('../../sistema_control/config/db.php');

// Verificar que se proporcionó un ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Se requiere un ID válido']);
    exit;
}

$id_empleado = $_GET['id'];

// Conectar a la base de datos
$db = conectarDB($config);

try {
    // Obtener los detalles del empleado
    $sql = "SELECT * FROM empleados WHERE id_empleado = :id_empleado";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
    $stmt->execute();
    $empleado = $stmt->fetch();
    
    if (!$empleado) {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Empleado no encontrado']);
        exit;
    }
    
    // Enviar respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($empleado);
    
} catch (PDOException $e) {
    error_log("Error en empleado.php: " . $e->getMessage());
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Error al cargar el empleado']);
}
?>