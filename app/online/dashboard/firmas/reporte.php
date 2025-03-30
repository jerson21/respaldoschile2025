<?php

/************************************************************
 * Reporte en PDF con FPDF                                   *
 *                                                           *
 * Fecha:    2021-02-09                                      *
 * Autor:  Marko Robles                                      *
 * Web:  www.codigosdeprogramacion.com                       *
 ************************************************************/
header('Content-Type: text/html; charset=UTF-8');

require "conexion.php";
require "plantilla.php";

if (!empty($_GET)) {

  $id = mysqli_escape_string($mysqli, $_GET['id']);

  $sql = "SELECT *,sum(pd.precio) as precio,sum(pd.abono)as abono from pedido p INNER JOIN pedido_detalle pd ON p.num_orden = pd.num_orden where pd.ruta_asignada = $id GROUP BY pd.num_orden ORDER BY CAST(pd.orden_ruta AS UNSIGNED) ASC";
  $resultado = $mysqli->query($sql);

  $pdf = new PDF("L", "mm", "legal");
  $pdf->AliasNbPages();
  $pdf->SetMargins(15, 15, 15);
  $pdf->AddPage();

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

  $pdf->Cell(35, 7, utf8_decode("Ubicación de Entrega"), 1, 0, "C");

  $pdf->Cell(45, 7, "Nombre Recibe", 1, 0, "C");
  $pdf->Cell(45, 7, "Firma quien recibe", 1, 0, "C");


  $pdf->Ln(7);

  $pdf->SetFont("Arial", "", 9);






  while ($fila = $resultado->fetch_assoc()) {
    $num_orden = $fila['num_orden'];
    $num_orden_escaped = $mysqli->real_escape_string($num_orden);
    $id_escaped = $mysqli->real_escape_string($id);
  
    $sql2 = "SELECT p.*, pd.*, 
    COALESCE(pg.total_pagado, 0) AS total_pagado,
    COALESCE(SUM(CAST(REPLACE(REPLACE(pd.precio, '$', ''), '.', '') AS SIGNED)), 0) AS total_precio
FROM pedido p
left JOIN pedido_detalle pd ON p.num_orden = pd.num_orden
LEFT JOIN (
    SELECT num_orden, SUM(CAST(REPLACE(REPLACE(monto, '$', ''), '.', '') AS SIGNED)) AS total_pagado
    FROM pagos
    GROUP BY num_orden
) pg ON p.num_orden = pg.num_orden
WHERE pd.estadopedido NOT IN ('100', '404') AND pd.num_orden = $num_orden_escaped AND pd.ruta_asignada = $id_escaped
GROUP BY p.num_orden, pd.id, p.rut_cliente
ORDER BY pd.num_orden, pd.id, p.rut_cliente ASC";
    $resultado2 = $mysqli->query($sql2);

    $totalPagado = 0;
    $totalPrecio = 0;
    $productos = 0;
    $despacho = 0;
    while ($fila2 = $resultado2->fetch_assoc()) {
      $orden_ruta = $fila['orden_ruta'];
      $productos += 1;
      $totalPagado = $fila2['total_pagado'];
      $totalPrecio += $fila2['total_precio']; 
      $despacho = $fila2['despacho'];
    }
   $totalPrecio = $totalPrecio + $despacho;

    $pdf->Cell(10, 11, $fila['num_orden'], 1, 0, "C");
    $pdf->Cell(22, 11, ucfirst($fila['rut_cliente']), 1, 0, "C");


    header('Content-Type: text/html; charset=UTF-8');
    $total_pago = $totalPrecio - $totalPagado;

    $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);
    $total_pago = numfmt_format_currency($fmt, $total_pago, "CLP");

    $pdf->Cell(25, 11, ucfirst($fila['mododepago']), 1, 0, "C");

    $pdf->Cell(15, 11, ucfirst("$" . $totalPrecio), 1, 0, "C");
    $pdf->Cell(15, 11, ucfirst("$" . $totalPagado), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 9);
    $pdf->Cell(17, 11,   $total_pago, 1, 0, "C");
    $pdf->Cell(15, 11, " ", 1, 0, "C");
    $pdf->Cell(20, 11, $productos, 1, 0, "C");


    $pdf->SetFont("Arial", "", 9);

    $pdf->Cell(20, 11, ' ', 1, 0, "C"); //entregados

    $pdf->Cell(35, 11, '', 1, 0, "C"); //ubicacion de entrega
    $pdf->Cell(45, 11, ' ', 1, 0, "C");
    $pdf->Cell(45, 11, ' ', 1, 0, "C");

    $pdf->Ln(11);
  }

  $pdf->Output();
}
