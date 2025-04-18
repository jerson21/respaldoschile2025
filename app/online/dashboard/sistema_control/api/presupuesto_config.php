<?php
// Archivo: api/presupuesto_config.php
// Proporciona la configuración actual de presupuestos

require_once('../../sistema_control/config/db.php');

// Conectar a la base de datos
$db = conectarDB($config);

try {
    // Obtener todos los presupuestos activos
    $sql = "SELECT id_presupuesto, categoria, monto_anual, descripcion 
            FROM presupuestos 
            WHERE activo = 1
            ORDER BY categoria";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $presupuestos = $stmt->fetchAll();
    
    // Si no hay presupuestos, agregar categorías predefinidas
    if (count($presupuestos) == 0) {
        $categorias_predefinidas = [
            'Salarios',
            'Marketing',
            'Operaciones',
            'Tecnología',
            'Capacitación',
            'Infraestructura',
            'Imprevistos'
        ];
        
        $presupuestos = [];
        foreach ($categorias_predefinidas as $categoria) {
            $presupuestos[] = [
                'id_presupuesto' => null,
                'categoria' => $categoria,
                'monto_anual' => 0,
                'descripcion' => ''
            ];
        }
    }
    
    // Enviar respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($presupuestos);
    
} catch (PDOException $e) {
    error_log("Error en presupuesto_config.php: " . $e->getMessage());
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Error al cargar los datos de presupuesto']);
}
?>