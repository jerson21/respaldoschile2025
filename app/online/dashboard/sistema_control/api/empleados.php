<?php
// Archivo: api/empleados.php
// Proporciona la lista de empleados para selects y formularios

require_once('../config/db.php');

// Conectar a la base de datos
$db = conectarDB($config);

try {
    // Obtener empleados activos
    $sql = "SELECT id_empleado, CONCAT(nombre, ' ', apellido) as nombre_completo 
            FROM empleados 
            WHERE activo = 1 
            ORDER BY nombre, apellido";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $empleados = $stmt->fetchAll();
    
    // Enviar respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($empleados);
    
} catch (PDOException $e) {
    error_log("Error en obtenerEmpleados: " . $e->getMessage());
    return [];
}
?>