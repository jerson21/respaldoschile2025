<?php
// Archivo: api/nomina_update.php
// Actualiza los datos de una nómina existente

require_once('../config/db.php');

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Verificar que se proporcionó un ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['success' => false, 'message' => 'Se requiere un ID válido']);
    exit;
}

$id_nomina = $_GET['id'];

// Validar datos requeridos
$campos_requeridos = ['fecha_nomina', 'sueldo_base'];
foreach ($campos_requeridos as $campo) {
    if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['success' => false, 'message' => "El campo {$campo} es requerido"]);
        exit;
    }
}

// Preparar datos para actualización
$fecha_nomina = $_POST['fecha_nomina'];
$sueldo_base = (float)$_POST['sueldo_base'];
$extras = isset($_POST['extras']) ? (float)$_POST['extras'] : 0;
$bonos = isset($_POST['bonos']) ? (float)$_POST['bonos'] : 0;
$deducciones = isset($_POST['deducciones']) ? (float)$_POST['deducciones'] : 0;
$observaciones = $_POST['observaciones'] ?? '';

// Calcular el total
$total = $sueldo_base + $extras + $bonos - $deducciones;

try {
    // Conectar a la base de datos
    $db = conectarDB($config);
    
    // Actualizar la nómina
    $sql = "UPDATE nomina SET 
            fecha_nomina = :fecha_nomina,
            sueldo_base = :sueldo_base,
            extras = :extras,
            bonos = :bonos,
            deducciones = :deducciones,
            total = :total,
            observaciones = :observaciones
            WHERE id_nomina = :id_nomina";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':fecha_nomina', $fecha_nomina);
    $stmt->bindParam(':sueldo_base', $sueldo_base);
    $stmt->bindParam(':extras', $extras);
    $stmt->bindParam(':bonos', $bonos);
    $stmt->bindParam(':deducciones', $deducciones);
    $stmt->bindParam(':total', $total);
    $stmt->bindParam(':observaciones', $observaciones);
    $stmt->bindParam(':id_nomina', $id_nomina, PDO::PARAM_INT);
    
    $resultado = $stmt->execute();
    
    if ($resultado) {
        // Éxito
        echo json_encode(['success' => true]);
    } else {
        // Error
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la nómina']);
    }
} catch (PDOException $e) {
    error_log("Error en nomina_update.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error al actualizar la nómina: ' . $e->getMessage()]);
}