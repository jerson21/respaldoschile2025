<?php
// Incluir el archivo de conexión
require_once '../bd/conexion.php';

// Obtener conexión PDO
$pdo = Conexion::Conectar();

// Obtener el ID desde POST
$id = $_POST['id'];

try {
    // Preparar consulta con marcador de posición para prevenir inyección SQL
    $query = "UPDATE rutas SET estado = '1' WHERE id = :id";
    
    // Preparar la sentencia
    $stmt = $pdo->prepare($query);
    
    // Vincular el parámetro
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Verificar si se actualizó alguna fila
    if ($stmt->rowCount() > 0) {
        echo "Estado de ruta actualizado correctamente";
    } else {
        echo "No se encontró la ruta con ID: " . $id;
    }
    
} catch (PDOException $e) {
    // Manejar el error
    echo "Error: " . $e->getMessage();
}
?>