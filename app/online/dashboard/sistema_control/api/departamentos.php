<?php
// Archivo: api/departamentos.php
// Proporciona la lista de departamentos

require_once('../../sistema_control/config/db.php');

// Conectar a la base de datos
$db = conectarDB($config);

try {
    // Consultar departamentos activos
    $sql = "SELECT * FROM departamentos WHERE activo = 1 ORDER BY nombre";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $departamentos = $stmt->fetchAll();
    
    // Enviar respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($departamentos);
    
} catch (PDOException $e) {
    error_log("Error en departamentos.php: " . $e->getMessage());
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Error al cargar los departamentos']);
}
?>