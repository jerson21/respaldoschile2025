<?php
header('Content-Type: text/html; charset=utf-8');

// Incluir el archivo de conexión utilizando la clase Conexion
require_once "bd/conexion.php";

// Obtener los parámetros POST con validación
$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
$tipo_lista = isset($_POST['tipo_lista']) ? $_POST['tipo_lista'] : '';

// Validar que los campos no estén vacíos
if (empty($fecha) || empty($tipo_lista)) {
    echo "Error: los campos fecha y tipo_lista son obligatorios";
    exit;
}

try {
    // Inicializar la conexión usando la clase Conexion
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();
    
    // Preparar la consulta con parámetros seguros
    $query = "INSERT INTO rutas(fecha, tipo) VALUES (:fecha, :tipo_lista)";
    $stmt = $conexion->prepare($query);
    
    // Vincular parámetros
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':tipo_lista', $tipo_lista, PDO::PARAM_STR);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "1"; // Éxito
    } else {
        echo "Error al insertar la ruta";
    }
} catch (PDOException $e) {
    // Manejo de errores
    echo "Falló el ingreso de ruta: " . $e->getMessage();
}
?>