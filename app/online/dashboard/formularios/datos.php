<?php
// Include the connection file
include_once '../bd/conexion.php';

// Create connection object using your existing Conexion class
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Check if connection was successful
if (!$conexion) {
    echo "Error: No se pudo conectar a la base de datos." . PHP_EOL;
    exit;
}

$tela = $_POST['colores'];

// Using prepared statement for security
$sql = "SELECT id, color FROM colores WHERE $tela = '1' ORDER BY color ASC";

try {
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    
    $cadena = "<label for='listatelas' class='form-label fw-bold'>Colores disponibles en ".strtoupper($tela)."</label> 
            <select class='form-select form-select-sm' id='lista2' name='lista2'>";
    
    // Fetch results using PDO
    while ($ver = $stmt->fetch(PDO::FETCH_NUM)) {
        $cadena = $cadena.'<option value="'.$ver[1].'">'.$ver[1].'</option>';
    }
    
    echo $cadena."</select>";
    
} catch(PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>