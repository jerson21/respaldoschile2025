<?php
// Incluir el archivo de conexión utilizando la clase Conexion
require_once "bd/conexion.php";

// Validar y obtener el rut del cliente enviado por POST
$rut = isset($_POST['rut']) ? $_POST['rut'] : '';

// Validar que el rut no esté vacío
if (empty($rut)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'RUT no proporcionado']);
    exit;
}

// Inicializar la conexión usando la clase Conexion
$objeto = new Conexion();
$conexion = $objeto->Conectar();

try {
    // Preparar la consulta con parámetros seguros
    $query = "SELECT * FROM direccion_clientes WHERE rut_cliente = :rut";
    $stmt = $conexion->prepare($query);
    
    // Vincular el parámetro
    $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Crear un array para almacenar las direcciones
    $direcciones = array();
    
    // Recorrer los resultados y agregar las direcciones al array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $direcciones[] = $row['direccion'];
    }
    
    // Crear un array con los datos de las direcciones
    $response = array(
        'direcciones' => $direcciones
    );
    
    // Enviar la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    
} catch (PDOException $e) {
    // En caso de error, devolver un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
?>