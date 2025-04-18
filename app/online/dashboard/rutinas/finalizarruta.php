<?php
// Incluir el archivo de conexión
require_once '../bd/conexion.php';

// Obtener conexión PDO
$pdo = Conexion::Conectar();

// Obtener el ID desde POST
$id = $_POST['id'];

try {
    // Preparar consulta con marcador de posición para prevenir inyección SQL
    $query = "UPDATE rutas SET estado = '200' WHERE id = :id";
    
    // Preparar la sentencia
    $stmt = $pdo->prepare($query);
    
    // Vincular el parámetro
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Ejecutar la consulta
    $stmt->execute();
    
} catch (PDOException $e) {
    // Manejar el error
    die("Error: " . $e->getMessage());
}
?>