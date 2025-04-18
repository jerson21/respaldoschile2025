<?php
// Include the connection class
require_once __DIR__ . '/../bd/conexion.php';

// Get PDO connection instance from the class
$pdo = Conexion::Conectar();

$id = $_POST['id'];

try {
    // Query using PDO
    $strsql = "SELECT * FROM pedidos WHERE estadopedido < 3 ORDER BY color";
    $stmt = $pdo->prepare($strsql);
    $stmt->execute();
    
    $data = array();
    $contador = "1";
    
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
        
        if($row['dpto'] != "Dpto") {
            // Empty condition in original code
        } else {
            // Empty condition in original code
        }
        
        $nestedData[] = $row["direccion"] . " " . $row['numero'] . " ";
        $nestedData[] = $row["comuna"];
        $nestedData[] = $row["telefono"];
        
        $rut_cliente = $row['rut_cliente'];
        
        // Query for client's Instagram using PDO
        $strsqls = "SELECT * FROM clientes WHERE rut = :rut_cliente";
        $stmtClient = $pdo->prepare($strsqls);
        $stmtClient->bindParam(':rut_cliente', $rut_cliente, PDO::PARAM_STR);
        $stmtClient->execute();
        
        $instagram = "";
        if ($row1 = $stmtClient->fetch(PDO::FETCH_ASSOC)) {
            $instagram = $row1['instagram'];
        }
        
        $nestedData[] = $instagram;
        $nestedData[] = $row["mododepago"];
        $nestedData[] = $row["precio"];
        $nestedData[] = "";
        $nestedData[] = "";
        
        $data[] = $nestedData;
    }
    
    $json_data = array(
        "data" => $data // total data array
    );
    
    echo json_encode($json_data);
    
} catch (PDOException $e) {
    // Handle database errors
    $error = array(
        "error" => true,
        "message" => "Database error: " . $e->getMessage()
    );
    
    echo json_encode($error);
}
?>