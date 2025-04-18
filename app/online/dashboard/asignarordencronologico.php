<?php
include('bd/conexion.php');

// Usamos la conexión PDO
$conn = Conexion::Conectar();

try {
    $id = $_POST['id'];
    
    // Consulta para seleccionar pedidos de la ruta
    $strsql = "SELECT * FROM pedido_detalle WHERE ruta_asignada = :id ORDER BY orden_ruta ASC";
    $stmt = $conn->prepare($strsql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Contar filas
    $total_rows = $stmt->rowCount();
    $data = array();
    $contador = 0;
    
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $idpedido = $row[0];
        $contador++;
        
        // Consulta para actualizar el orden de ruta
        $query = "UPDATE pedido_detalle SET orden_ruta = :contador WHERE id = :idpedido";
        $update_stmt = $conn->prepare($query);
        $update_stmt->bindParam(':contador', $contador, PDO::PARAM_INT);
        $update_stmt->bindParam(':idpedido', $idpedido, PDO::PARAM_INT);
        $update_stmt->execute();
        
        echo "1";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>