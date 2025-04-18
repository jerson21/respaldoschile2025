<?php
// Archivo: api/presupuesto_save.php
// Guarda la configuración de presupuestos

require_once('../../sistema_control/config/db.php');

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Validar datos requeridos
if (!isset($_POST['categoria']) || !isset($_POST['monto_anual']) || !is_array($_POST['categoria']) || !is_array($_POST['monto_anual'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['success' => false, 'message' => "Datos de presupuesto inválidos"]);
    exit;
}

// Conectar a la base de datos
$db = conectarDB($config);

try {
    // Iniciar transacción
    $db->beginTransaction();
    
    $categorias = $_POST['categoria'];
    $montos = $_POST['monto_anual'];
    $descripciones = $_POST['descripcion'] ?? [];
    $ids = $_POST['id_presupuesto'] ?? [];
    
    // Iterar sobre cada presupuesto
    for ($i = 0; $i < count($categorias); $i++) {
        // Si no hay categoría o es vacía, continuar al siguiente
        if (empty($categorias[$i])) {
            continue;
        }
        
        $id = isset($ids[$i]) ? $ids[$i] : null;
        $categoria = $categorias[$i];
        $monto = floatval($montos[$i] ?? 0);
        $descripcion = $descripciones[$i] ?? '';
        
        // Si hay ID, actualizar el registro existente
        if (!empty($id)) {
            $sql = "UPDATE presupuestos SET 
                    monto_anual = :monto_anual,
                    descripcion = :descripcion
                    WHERE id_presupuesto = :id_presupuesto";
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':monto_anual', $monto);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':id_presupuesto', $id);
            $stmt->execute();
        } else {
            // Si no hay ID, insertar nuevo registro
            $sql = "INSERT INTO presupuestos (categoria, monto_anual, descripcion, fecha_inicio, fecha_fin, activo) 
                    VALUES (:categoria, :monto_anual, :descripcion, CURRENT_DATE, DATE_ADD(CURRENT_DATE, INTERVAL 1 YEAR), 1)";
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':monto_anual', $monto);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->execute();
        }
    }
    
    // Confirmar transacción
    $db->commit();
    
    // Respuesta exitosa
    echo json_encode(['success' => true]);
    
} catch (PDOException $e) {
    // Revertir transacción en caso de error
    $db->rollBack();
    
    error_log("Error en presupuesto_save.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error al guardar los presupuestos: ' . $e->getMessage()]);
}
?>