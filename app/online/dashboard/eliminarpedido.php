<?php
// Incluir el archivo de conexión utilizando la clase Conexion
require_once "bd/conexion.php";

// Obtener los parámetros POST con validación
$id = isset($_POST['agregarId']) ? $_POST['agregarId'] : 0;

// Validar que el ID es numérico para prevenir inyección SQL
if (!is_numeric($id)) {
    echo 0;
    exit;
}

// Inicializar la conexión usando la clase Conexion
$objeto = new Conexion();
$conexion = $objeto->Conectar();

try {
    // Preparar la consulta con parámetros seguros
    $query = "UPDATE pedidos SET mododepago = :mododepago WHERE id = :id";
    $stmt = $conexion->prepare($query);
    
    // Establecer el nuevo valor para mododepago
    $mododepago = 'Eliminado';
    
    // Vincular parámetros
    $stmt->bindParam(':mododepago', $mododepago, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo 1; // Éxito
    } else {
        echo 0; // Error
    }
} catch (PDOException $e) {
    // Manejo de errores
    echo 0;
    // Opcionalmente, registrar el error en un archivo de log
    // error_log("Error en la actualización: " . $e->getMessage());
}
?>