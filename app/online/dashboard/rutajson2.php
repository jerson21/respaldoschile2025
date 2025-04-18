<?php
// Incluir el archivo de conexión utilizando la clase Conexion
require_once "bd/conexion.php";

// Obtener el ID de la ruta con validación
$id = isset($_POST['id']) ? $_POST['id'] : 0;

// Validar que el ID sea numérico
if (!is_numeric($id)) {
    echo json_encode(array("error" => "ID inválido"));
    exit;
}

try {
    // Inicializar la conexión usando la clase Conexion
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();
    
    // Consulta para obtener los pedidos de la ruta
    $query = "SELECT * FROM pedidos WHERE ruta_asignada = :id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $data = array();
    
    // Recorrer los resultados
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nestedData = array();
        
        $nestedData[] = $row["orden_ruta"];
        $nestedData[] = $row["num_orden"];
        $nestedData[] = $row["id"];
        $nestedData[] = $row["rut_cliente"];
        $nestedData[] = $row["modelo"];
        $nestedData[] = $row["plazas"];
        $nestedData[] = $row["tipotela"];
        $nestedData[] = $row["color"];
        $nestedData[] = $row["alturabase"];
        
        // Formatear la dirección
        $direccion = $row["direccion"] . " " . $row['numero'];
        if ($row['dpto'] != "Dpto") {
            $direccion .= " " . $row['dpto'];
        }
        $nestedData[] = $direccion;
        
        $nestedData[] = $row["comuna"];
        $nestedData[] = $row["telefono"];
        
        // Obtener el Instagram del cliente
        $rut_cliente = $row['rut_cliente'];
        $instagram = "";
        
        $query_cliente = "SELECT instagram FROM clientes WHERE rut = :rut";
        $stmt_cliente = $conexion->prepare($query_cliente);
        $stmt_cliente->bindParam(':rut', $rut_cliente, PDO::PARAM_STR);
        $stmt_cliente->execute();
        
        $cliente_data = $stmt_cliente->fetch(PDO::FETCH_ASSOC);
        if ($cliente_data) {
            $instagram = $cliente_data['instagram'];
        }
        
        $nestedData[] = $instagram;
        $nestedData[] = $row["mododepago"];
        $nestedData[] = $row["precio"];
        $nestedData[] = $row["comentarios"];
        $nestedData[] = "";
        
        $data[] = $nestedData;
    }
    
    // Preparar la respuesta en formato JSON para DataTables
    $json_data = array(
        "data" => $data
    );
    
    // Devolver los resultados como JSON
    echo json_encode($json_data);
    
} catch (PDOException $e) {
    // En caso de error, devolver un mensaje de error en formato JSON
    echo json_encode(array("error" => "Error en la consulta: " . $e->getMessage()));
}
?>