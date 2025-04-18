<?php
// Incluimos el archivo de conexión que tiene la clase PDO
include("bd/conexion.php");

// Obtenemos la conexión usando el método estático
$conn = Conexion::Conectar();

// Recibimos los datos del formulario
$id = $_POST['agregarId'];
$ruta = $_POST['rutaId'];
$num_orden = $_POST['numero_orden'];

$contador = 0;

try {
    // Preparamos la consulta para actualizar la ruta asignada en pedido_detalle
    $query = "UPDATE pedido_detalle SET ruta_asignada = :ruta WHERE id = :id";
    $stmt = $conn->prepare($query);
    
    // Asignamos los valores a los parámetros
    $stmt->bindParam(':ruta', $ruta, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Ejecutamos la consulta
    if ($stmt->execute()) {
        $contador++;
    } else {
        echo "0";
        exit;
    }
    
    /* 
    // Código comentado actualizado a PDO
    
    // Actualizamos la ruta asignada en la tabla orden
    $query = "UPDATE orden SET ruta_asignada = :ruta WHERE num_orden = :num_orden";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':ruta', $ruta, PDO::PARAM_STR);
    $stmt->bindParam(':num_orden', $num_orden, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $contador++;
    } else {
        echo "0";
        exit;
    }
    
    // Actualizamos el estado a "3" (PREPARANDO DESPACHO) en la tabla orden
    $query = "UPDATE orden SET estado = '3' WHERE num_orden = :num_orden";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':num_orden', $num_orden, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $contador++;
    } else {
        echo "Falló el ingreso de datos: " . $stmt->errorInfo()[2];
        exit;
    }
    */
    
    // Devolvemos el contador de operaciones exitosas
    echo $contador;
    
} catch (PDOException $e) {
    // En caso de error, mostramos el mensaje
    echo "Error en la base de datos: " . $e->getMessage();
}
?>