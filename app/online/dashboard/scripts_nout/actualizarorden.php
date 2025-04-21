<?php
// Incluir el archivo de conexión utilizando la clase Conexion
require_once "bd/conexion.php";

// Obtener los parámetros POST con validación
$id = isset($_POST['id']) ? $_POST['id'] : 0;
$ruta = isset($_POST['nuevoorden']) ? $_POST['nuevoorden'] : 0;

// Validar que los valores son numéricos para prevenir inyección SQL
if (!is_numeric($id) || !is_numeric($ruta)) {
    echo 0;
    exit;
}

try {
    // Inicializar la conexión usando la clase Conexion
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();
    
    // Preparar la consulta con parámetros seguros
    $query = "UPDATE pedido_detalle SET orden_ruta = :ruta WHERE id = :id";
    $stmt = $conexion->prepare($query);
    
    // Vincular parámetros
    $stmt->bindParam(':ruta', $ruta, PDO::PARAM_INT);
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
    // error_log("Error en la actualización de orden_ruta: " . $e->getMessage());
}
?>