<?php
/************************************************************
 * Reporte en PDF con FPDF                                   *
 * Versión actualizada usando PDO con correcciones           *
 ************************************************************/
header('Content-Type: text/html; charset=UTF-8');

// Incluir archivos necesarios
require_once "../bd/conexion.php";
require_once "plantilla.php";

// Obtener conexión PDO
$pdo = Conexion::Conectar();

if (!empty($_GET)) {
    // Obtener y sanitizar el ID
    $id = $_GET['id'];

    try {
        // Consulta principal con prepared statement
        $sql = "SELECT *, SUM(pd.precio) as precio, SUM(pd.abono) as abono 
                FROM pedido p 
                INNER JOIN pedido_detalle pd ON p.num_orden = pd.num_orden 
                WHERE pd.ruta_asignada = :id 
                GROUP BY pd.num_orden 
                ORDER BY CAST(pd.orden_ruta AS UNSIGNED) ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Crear PDF
        $pdf = new PDF("L", "mm", "legal");
        $pdf->AliasNbPages();
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        
        // Configurar encabezados
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Cell(10, 7, "Orden", 1, 0, "C");
        $pdf->Cell(22, 7, "Rut", 1, 0, "C");
        $pdf->Cell(25, 7, "Forma Pago", 1, 0, "C");
        $pdf->Cell(15, 7, "Total", 1, 0, "C");
        $pdf->Cell(15, 7, "Abono", 1, 0, "C");
        $pdf->Cell(17, 7, "Por Pagar", 1, 0, "C");
        $pdf->Cell(15, 7, "Mod", 1, 0, "C");
        $pdf->Cell(20, 7, "Productos", 1, 0, "C");
        $pdf->Cell(20, 7, "Entregados", 1, 0, "C");
        
        // Reemplazar utf8_decode() que está obsoleto
        $ubicacion = mb_convert_encoding("Ubicación de Entrega", 'ISO-8859-1', 'UTF-8');
        $pdf->Cell(35, 7, $ubicacion, 1, 0, "C");
        
        $pdf->Cell(45, 7, "Nombre Recibe", 1, 0, "C");
        $pdf->Cell(45, 7, "Firma quien recibe", 1, 0, "C");
        $pdf->Ln(7);
        
        $pdf->SetFont("Arial", "", 9);
        
        // Procesar cada fila del resultado
        while ($fila = $stmt->fetch()) {
            $num_orden = $fila['num_orden'];
            
            // Consulta secundaria con prepared statement
            $sql2 = "SELECT p.*, pd.*, 
                    COALESCE(pg.total_pagado, 0) AS total_pagado,
                    COALESCE(SUM(CAST(REPLACE(REPLACE(pd.precio, '$', ''), '.', '') AS SIGNED)), 0) AS total_precio
                FROM pedido p
                LEFT JOIN pedido_detalle pd ON p.num_orden = pd.num_orden
                LEFT JOIN (
                    SELECT num_orden, SUM(CAST(REPLACE(REPLACE(monto, '$', ''), '.', '') AS SIGNED)) AS total_pagado
                    FROM pagos
                    GROUP BY num_orden
                ) pg ON p.num_orden = pg.num_orden
                WHERE pd.estadopedido NOT IN ('100', '404') AND pd.num_orden = :num_orden AND pd.ruta_asignada = :id
                GROUP BY p.num_orden, pd.id, p.rut_cliente
                ORDER BY pd.num_orden, pd.id, p.rut_cliente ASC";
            
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->bindParam(':num_orden', $num_orden, PDO::PARAM_STR);
            $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt2->execute();
            
            $totalPagado = 0;
            $totalPrecio = 0;
            $productos = 0;
            $despacho = 0;
            
            while ($fila2 = $stmt2->fetch()) {
                $orden_ruta = $fila['orden_ruta'];
                $productos += 1;
                $totalPagado = $fila2['total_pagado'];
                $totalPrecio += $fila2['total_precio']; 
                $despacho = $fila2['despacho'];
            }
            
            $totalPrecio = $totalPrecio + $despacho;
            
            // Imprimir fila en PDF
            $pdf->Cell(10, 11, $fila['num_orden'], 1, 0, "C");
            $pdf->Cell(22, 11, ucfirst($fila['rut_cliente']), 1, 0, "C");
            
            // Calcular total a pagar
            $total_pago = $totalPrecio - $totalPagado;
            
            // Reemplazar numfmt_create que requiere la extensión intl
            // con una función de formato manual
            $total_pago_formateado = number_format($total_pago, 0, ',', '.'); 
            $total_pago_formateado = '$' . $total_pago_formateado;
            
            $pdf->Cell(25, 11, ucfirst($fila['mododepago']), 1, 0, "C");
            $pdf->Cell(15, 11, ucfirst("$" . number_format($totalPrecio, 0, ',', '.')), 1, 0, "C");
            $pdf->Cell(15, 11, ucfirst("$" . number_format($totalPagado, 0, ',', '.')), 1, 0, "C");
            
            $pdf->SetFont("Arial", "B", 9);
            $pdf->Cell(17, 11, $total_pago_formateado, 1, 0, "C");
            $pdf->Cell(15, 11, " ", 1, 0, "C");
            $pdf->Cell(20, 11, $productos, 1, 0, "C");
            
            $pdf->SetFont("Arial", "", 9);
            $pdf->Cell(20, 11, ' ', 1, 0, "C"); // entregados
            $pdf->Cell(35, 11, '', 1, 0, "C");  // ubicacion de entrega
            $pdf->Cell(45, 11, ' ', 1, 0, "C"); // nombre recibe
            $pdf->Cell(45, 11, ' ', 1, 0, "C"); // firma
            
            $pdf->Ln(11);
        }
        
        // Generar salida del PDF
        $pdf->Output();
        
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error en la base de datos: " . $e->getMessage();
    }
}
?>