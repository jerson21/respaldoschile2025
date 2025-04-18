<?php
// Archivo: api/nomina.php
// Proporciona los datos de nómina para un mes específico

require_once('../../sistema_control/config/db.php');

// Obtener el mes solicitado (por defecto, el mes actual)
$mes = isset($_GET['mes']) ? (int)$_GET['mes'] : date('m');
$anio = isset($_GET['anio']) ? (int)$_GET['anio'] : date('Y');

// Conectar a la base de datos
$db = conectarDB($config);

try {
    // Obtener los empleados con sus datos de nómina (solo empleados activos)
    $sql_empleados = "SELECT n.id_nomina, CONCAT(e.nombre, ' ', e.apellido) as empleado, 
                      d.nombre as departamento, e.cargo, n.sueldo_base, n.extras, n.total,
                      e.id_empleado
                      FROM nomina n
                      JOIN empleados e ON n.id_empleado = e.id_empleado
                      JOIN departamentos d ON e.id_departamento = d.id_departamento
                      WHERE MONTH(n.fecha_nomina) = :mes AND YEAR(n.fecha_nomina) = :anio
                      AND e.activo = 1
                      ORDER BY n.total DESC";
                
    $stmt_empleados = $db->prepare($sql_empleados);
    $stmt_empleados->bindParam(':mes', $mes, PDO::PARAM_INT);
    $stmt_empleados->bindParam(':anio', $anio, PDO::PARAM_INT);
    $stmt_empleados->execute();
    $empleados = $stmt_empleados->fetchAll();
    
    // Obtener el resumen de nómina - Especificamos que sueldo_base viene de la tabla nomina
    $sql_resumen = "SELECT SUM(n.sueldo_base) as total_base, 
                     SUM(n.extras) as total_extras,
                     SUM(n.bonos) as total_bonos,
                     SUM(n.deducciones) as total_deducciones,
                     SUM(n.total) as total_nomina
                     FROM nomina n
                     JOIN empleados e ON n.id_empleado = e.id_empleado
                     WHERE MONTH(n.fecha_nomina) = :mes AND YEAR(n.fecha_nomina) = :anio
                     AND e.activo = 1";
                
    $stmt_resumen = $db->prepare($sql_resumen);
    $stmt_resumen->bindParam(':mes', $mes, PDO::PARAM_INT);
    $stmt_resumen->bindParam(':anio', $anio, PDO::PARAM_INT);
    $stmt_resumen->execute();
    $resumen = $stmt_resumen->fetch();
    
    // Obtener datos por departamento para el gráfico
    $sql_departamentos = "SELECT d.nombre as departamento, SUM(n.total) as total
                          FROM nomina n
                          JOIN empleados e ON n.id_empleado = e.id_empleado
                          JOIN departamentos d ON e.id_departamento = d.id_departamento
                          WHERE MONTH(n.fecha_nomina) = :mes AND YEAR(n.fecha_nomina) = :anio
                          AND e.activo = 1
                          GROUP BY d.id_departamento
                          ORDER BY total DESC";
                
    $stmt_departamentos = $db->prepare($sql_departamentos);
    $stmt_departamentos->bindParam(':mes', $mes, PDO::PARAM_INT);
    $stmt_departamentos->bindParam(':anio', $anio, PDO::PARAM_INT);
    $stmt_departamentos->execute();
    $departamentos = $stmt_departamentos->fetchAll();
    
    // Inicializar valores por defecto si no hay resultados
    if (!$resumen) {
        $resumen = [
            'total_base' => 0,
            'total_extras' => 0,
            'total_bonos' => 0,
            'total_deducciones' => 0,
            'total_nomina' => 0
        ];
    }
    
    if (empty($departamentos)) {
        $departamentos = [];
    }
    
    // Preparar la respuesta
    $respuesta = [
        'empleados' => $empleados,
        'resumen' => $resumen,
        'departamentos' => $departamentos
    ];
    
    // Enviar respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($respuesta);
    
} catch (PDOException $e) {
    error_log("Error en nomina.php: " . $e->getMessage());
    
    // Evitar enviar encabezados si ya se enviaron
    if (!headers_sent()) {
        header('HTTP/1.1 500 Internal Server Error');
    }
    
    echo json_encode(['error' => 'Error al cargar los datos de nómina: ' . $e->getMessage()]);
}