<?php
// Archivo: api/estadisticas.php
// Proporciona datos estadísticos para el dashboard

require_once('../config/db.php');

// Conectar a la base de datos
$db = conectarDB($config);

// Obtener datos de gastos totales
$sql_gastos = "SELECT 
                SUM(monto) as total_actual,
                (SELECT SUM(monto) FROM gastos 
                 WHERE YEAR(fecha) = YEAR(CURRENT_DATE) 
                 AND MONTH(fecha) = MONTH(CURRENT_DATE) - 1) as total_anterior
              FROM gastos 
              WHERE YEAR(fecha) = YEAR(CURRENT_DATE) 
              AND MONTH(fecha) = MONTH(CURRENT_DATE)";

$stmt = $db->prepare($sql_gastos);
$stmt->execute();
$gastos = $stmt->fetch();

// Calcular variación de gastos
$gastos_totales = $gastos['total_actual'] ?? 0;
$gastos_anterior = $gastos['total_anterior'] ?? 0;
$var_gastos = $gastos_anterior > 0 ? 
    round(($gastos_totales - $gastos_anterior) / $gastos_anterior * 100, 1) : 0;

// Obtener datos de margen promedio
$sql_margen = "SELECT 
                AVG(ROUND(((precio_venta - costo_unitario) / precio_venta * 100), 1)) as margen_actual,
                (SELECT AVG(ROUND(((precio_venta - costo_unitario) / precio_venta * 100), 1)) 
                 FROM productos as p
                 JOIN historial_costos as h ON p.id_producto = h.id_producto
                 WHERE MONTH(h.fecha) = MONTH(CURRENT_DATE) - 1
                 AND YEAR(h.fecha) = YEAR(CURRENT_DATE)) as margen_anterior
              FROM productos";

$stmt = $db->prepare($sql_margen);
$stmt->execute();
$margenes = $stmt->fetch();

// Calcular variación de margen
$margen_promedio = round($margenes['margen_actual'] ?? 0, 1);
$margen_anterior = $margenes['margen_anterior'] ?? 0;
$var_margen = $margen_anterior > 0 ? 
    round(($margen_promedio - $margen_anterior) / $margen_anterior * 100, 1) : 0;

// Obtener datos de sueldos
$mes_actual = date('m');
$anio_actual = date('Y');
$mes_anterior = $mes_actual > 1 ? $mes_actual - 1 : 12;
$anio_anterior = $mes_actual > 1 ? $anio_actual : $anio_actual - 1;

$sql_sueldos = "SELECT 
                 SUM(total) as total_actual,
                 (SELECT SUM(total) FROM nomina 
                  WHERE MONTH(fecha_nomina) = :mes_anterior
                  AND YEAR(fecha_nomina) = :anio_anterior) as total_anterior
               FROM nomina 
               WHERE MONTH(fecha_nomina) = :mes_actual
               AND YEAR(fecha_nomina) = :anio_actual";

$stmt = $db->prepare($sql_sueldos);
$stmt->bindParam(':mes_actual', $mes_actual);
$stmt->bindParam(':anio_actual', $anio_actual);
$stmt->bindParam(':mes_anterior', $mes_anterior);
$stmt->bindParam(':anio_anterior', $anio_anterior);
$stmt->execute();
$sueldos = $stmt->fetch();

// Calcular variación de sueldos
$sueldos_totales = $sueldos['total_actual'] ?? 0;
$sueldos_anterior = $sueldos['total_anterior'] ?? 0;
$var_sueldos = $sueldos_anterior > 0 ? 
    round(($sueldos_totales - $sueldos_anterior) / $sueldos_anterior * 100, 1) : 0;

// Obtener distribución de gastos
$distribucion_gastos = obtenerDistribucionGastos($db);

// Obtener evolución de costos
$evolucion_costos = obtenerEvolucionCostos($db);

// Preparar la respuesta
$respuesta = [
    'gastos_totales' => $gastos_totales,
    'var_gastos' => $var_gastos,
    'margen_promedio' => $margen_promedio,
    'var_margen' => $var_margen,
    'sueldos_totales' => $sueldos_totales,
    'var_sueldos' => $var_sueldos,
    'distribucion_gastos' => $distribucion_gastos,
    'evolucion_costos' => $evolucion_costos
];

// Enviar respuesta como JSON
header('Content-Type: application/json');
echo json_encode($respuesta);