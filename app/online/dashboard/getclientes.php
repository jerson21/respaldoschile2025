<?php
// Incluir el archivo de conexión utilizando la clase Conexion
require_once "bd/conexion.php";

// Inicializar la conexión usando la clase Conexion
$objeto = new Conexion();
$conexion = $objeto->Conectar();

try {
    // Consulta para obtener todos los clientes
    $query = "SELECT * FROM clientes";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    
    // Crear el arreglo de datos para el DataTable
    $data = array();
    $contador = 1;
    
    // Recorrer los resultados usando PDO
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nestedData = array();
        $nestedData['num'] = $contador++;
        $nestedData['rut'] = $row['rut'];
        $nestedData['nombre'] = $row["nombre"];
        $nestedData['telefono'] = $row["telefono"];
        $nestedData['correo'] = $row["correo"];
        $nestedData['instagram'] = $row["instagram"];
        
        $nestedData[] = "";
        
        $data[] = $nestedData;
    }
    
    // Crear el arreglo de respuesta para el DataTable
    $response = array(
        "data" => $data
    );
    
    // Devolver los datos en formato JSON
    echo json_encode($response);
    
} catch (PDOException $e) {
    // En caso de error, devolver un mensaje de error en formato JSON
    $errorResponse = array(
        "error" => "Error en la consulta: " . $e->getMessage()
    );
    
    // Establecer el código de respuesta HTTP
    http_response_code(500);
    
    // Devolver el error en formato JSON
    echo json_encode($errorResponse);
}
?>