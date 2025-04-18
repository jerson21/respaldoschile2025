<?php
// Archivo: api/empleados_lista.php
// Proporciona la lista completa de empleados activos

require_once('../../sistema_control/config/db.php');

// Conectar a la base de datos
$db = conectarDB($config);

try {
    // Consultar empleados con nombre de departamento (solo activos)
    $sql = "SELECT e.*, d.nombre as departamento 
            FROM empleados e
            LEFT JOIN departamentos d ON e.id_departamento = d.id_departamento
            WHERE e.activo = 1
            ORDER BY e.nombre, e.apellido";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $empleados = $stmt->fetchAll();
    
    // Enviar respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($empleados);
    
} catch (PDOException $e) {
    error_log("Error en empleados_lista.php: " . $e->getMessage());
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Error al cargar los empleados']);
}
?>