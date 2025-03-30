<?php
/************************************************************
* Reporte en PDF con FPDF                                   *
*                                                           *
* Fecha:    2021-02-09                                      *
* Autor:  Marko Robles                                      *
* Web:  www.codigosdeprogramacion.com                       *
************************************************************/

require "conexion.php";
require "plantilla.php";

if (!empty($_POST)) {

    $categoria = mysqli_escape_string($mysqli, $_POST['categoria']);

    $sql = "SELECT * from gan order by categoria";
    $resultado = $mysqli->query($sql);

    $pdf = new PDF("P", "mm", "A4");
    $pdf->AliasNbPages();
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    $pdf->SetFont("Arial", "B", 9);

    $pdf->Cell(10, 5, "Cod", 1, 0, "C");
    $pdf->Cell(30, 5, "Categoria", 1, 0, "C");
    $pdf->Cell(55, 5, "Modelo", 1, 0, "C");
    $pdf->Cell(40, 5, "Tamano", 1, 0, "C");
    $pdf->Cell(15, 5, "Cantidad", 1, 0, "C");
    $pdf->Cell(45, 5, "Observacion", 1, 0, "C");

     $pdf->Ln(5);

    $pdf->SetFont("Arial", "", 9);

    while ($fila = $resultado->fetch_assoc()) {
        $pdf->Cell(10, 5, $fila['cod'], 1, 0, "C");
        $pdf->Cell(30, 5, ucfirst($fila['categoria']), 1, 0, "C");
        $pdf->Cell(55, 5, $fila['modelo'], 1, 0, "C");
        $pdf->Cell(40, 5, $fila['tamano'], 1, 0, "C");
        $pdf->Cell(15, 5, ' ', 1, 0, "C");
        $pdf->Cell(45, 5, ' ', 1, 0, "C");
         $pdf->Ln(5);
    }

    $pdf->Output();
}
