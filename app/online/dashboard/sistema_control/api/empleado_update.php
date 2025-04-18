<?php
// Archivo: api/empleado_update.php
// Actualiza un empleado existente

require_once('../../sistema_control/config/db.php');

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

$id_empleado = $_GET['id'];

// Validar datos requeridos
$campos_requeridos = ['nombre', 'apellido', 'id_departamento', 'cargo', 'fecha_contratacion', 'sueldo_base'];
foreach ($campos_requeridos as $campo) {
    if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['success' => false, 'message' => "El campo {$campo} es requerido"]);
        exit;
    }
}

// Preparar datos para actualización
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$id_departamento = $_POST['id_departamento'];
$cargo = $_POST['cargo'];
$fecha_contratacion = $_POST['fecha_contratacion'];
$sueldo_base = floatval($_POST['sueldo_base']);
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$activo = isset($_POST['activo']) && $_POST['activo'] == '1' ? 1 : 0;

try {
    // Conectar a la base de datos
    $db = conectarDB($config);
    
    // Actualizar el empleado
    $sql = "UPDATE empleados SET 
            nombre = :nombre,
            apellido = :apellido,
            id_departamento = :id_departamento,
            cargo = :cargo,
            fecha_contratacion = :fecha_contratacion,
            sueldo_base = :sueldo_base,
            email = :email,
            telefono = :telefono,
            activo = :activo
            WHERE id_empleado = :id_empleado";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':id_departamento', $id_departamento);
    $stmt->bindParam(':cargo', $cargo);
    $stmt->bindParam(':fecha_contratacion', $fecha_contratacion);
    $stmt->bindParam(':sueldo_base', $sueldo_base);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':activo', $activo);
    $stmt->bindParam(':id_empleado', $id_empleado);
    $stmt->execute();
    
    // Respuesta exitosa
    echo json_encode(['success' => true]);
    
} catch (PDOException $e) {
    error_log("Error en empleado_update.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el empleado: ' . $e->getMessage()]);
}
?>