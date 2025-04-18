<?php
// Incluir el archivo de conexión utilizando la clase Conexion
require_once "bd/conexion.php";

// Obtener los parámetros POST con validación
$id = isset($_POST['agregarId']) ? $_POST['agregarId'] : 0;
$ruta = isset($_POST['rutaId']) ? $_POST['rutaId'] : 0;

// Validar que los valores son numéricos para prevenir inyección SQL
if (!is_numeric($id) || !is_numeric($ruta)) {
    echo 0;
    exit;
}

// Inicializar la conexión usando la clase Conexion
$objeto = new Conexion();
$conexion = $objeto->Conectar();

try {
    // Preparar la consulta con parámetros seguros
    $query = "UPDATE pedidos SET ruta_asignada = :ruta, orden_ruta = :orden WHERE id = :id";
    $stmt = $conexion->prepare($query);
    
    // Vincular parámetros
    $stmt->bindParam(':ruta', $ruta, PDO::PARAM_INT);
    $orden = 0; // Orden por defecto
    $stmt->bindParam(':orden', $orden, PDO::PARAM_INT);
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