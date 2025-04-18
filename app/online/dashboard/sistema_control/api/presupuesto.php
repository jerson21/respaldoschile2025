<?php
// Archivo: api/presupuesto.php
// Proporciona los datos de presupuesto

require_once('../config/db.php');

// Obtener el período solicitado
$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : 'anual';

// Conectar a la base de datos
$db = conectarDB($config);

try {
    // Obtener el resumen de presupuesto
    $sql_resumen = "SELECT SUM(monto_anual) as total,
                    (SELECT SUM(monto) FROM gastos WHERE YEAR(fecha) = YEAR(CURRENT_DATE)) as ejecutado
                    FROM presupuestos 
                    WHERE activo = 1";
    
    $stmt_resumen = $db->prepare($sql_resumen);
    $stmt_resumen->execute();
    $resumen = $stmt_resumen->fetch();
    
    // Obtener detalle de presupuesto por categoría
    $sql_detalle = "SELECT 
                    p.categoria,
                    p.monto_anual as presupuesto,
                    IFNULL((SELECT SUM(g.monto) FROM gastos g 
                           JOIN categorias_gastos cg ON g.id_categoria = cg.id_categoria
                           WHERE cg.nombre = p.categoria
                           AND YEAR(g.fecha) = YEAR(CURRENT_DATE)), 0) as gastado,
                    IFNULL((SELECT AVG(e.variacion_porcentual) FROM ejecucion_presupuesto e
                           WHERE e.id_presupuesto = p.id_presupuesto
                           AND e.anio = YEAR(CURRENT_DATE)
                           AND e.mes BETWEEN MONTH(CURRENT_DATE) - 3 AND MONTH(CURRENT_DATE)), 0) as tendencia
                    FROM presupuestos p
                    WHERE p.activo = 1
                    ORDER BY p.monto_anual DESC";
    
    $stmt_detalle = $db->prepare($sql_detalle);
    $stmt_detalle->execute();
    $detalle_base = $stmt_detalle->fetchAll();
    
    // Procesar el detalle para agregar campos calculados
    $detalle = [];
    foreach ($detalle_base as $item) {
        $porcentaje = $item['presupuesto'] > 0 ? ($item['gastado'] / $item['presupuesto'] * 100) : 0;
        $proyeccion = $item['presupuesto'] * (1 + ($item['tendencia'] / 100));
        
        // Determinar el estado
        $estado = 'Dentro del presupuesto';
        if ($porcentaje > 90) {
            $estado = 'En riesgo';
        } elseif ($porcentaje < 30 && date('m') > 6) {
            $estado = 'Subutilizado';
        }
        
        $detalle[] = [
            'categoria' => $item['categoria'],
            'presupuesto' => $item['presupuesto'],
            'gastado' => $item['gastado'],
            'tendencia' => $item['tendencia'],
            'proyeccion' => $proyeccion,
            'estado' => $estado
        ];
    }
    
    // Obtener datos de ejecución por área para el gráfico
    $sql_areas = "SELECT 
                 p.categoria,
                 p.monto_anual as presupuesto,
                 IFNULL((SELECT SUM(g.monto) FROM gastos g 
                        JOIN categorias_gastos cg ON g.id_categoria = cg.id_categoria
                        WHERE cg.nombre = p.categoria
                        AND YEAR(g.fecha) = YEAR(CURRENT_DATE)), 0) as ejecutado
                 FROM presupuestos p
                 WHERE p.activo = 1
                 ORDER BY p.monto_anual DESC";
    
    $stmt_areas = $db->prepare($sql_areas);
    $stmt_areas->execute();
    $areas = $stmt_areas->fetchAll();
    
    // Preparar la respuesta
    $respuesta = [
        'resumen' => $resumen,
        'detalle' => $detalle,
        'areas' => $areas
    ];
    
    // Enviar respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($respuesta);
    
} catch (PDOException $e) {
    error_log("Error en presupuesto.php: " . $e->getMessage());
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Error al cargar los datos de presupuesto']);
}