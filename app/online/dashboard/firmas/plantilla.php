<?php
/************************************************************
* Plantilla para encabezado y pie de página                 *
*                                                           *
* Fecha:    2021-02-09                                      *
* Autor:  Marko Robles                                      *
* Web:  www.codigosdeprogramacion.com                       *
************************************************************/

require 'fpdf/fpdf.php';
header('Content-Type: text/html; charset=UTF-8');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $ruta = $_GET['id'];
        // Logo
        $this->Image("images/logo.png", 10, 5, 13);
        // Arial bold 15
        $this->SetFont("Arial", "B", 12);
        // Título
        $this->Cell(25);
        $this->Cell(250, 5, utf8_decode("Control de Entregas Ruta ".$ruta), 0, 0, "C");

//Fecha
        $this->SetFont("Arial", "", 10);
        $this->Cell(25, 5, "Fecha: ". date("d/m/Y"), 0, 1, "C");
        $this->Ln(3);
        $this->SetFont("Arial", "B", 12);
      
        
        // Salto de línea
        
 $this->SetAutoPageBreak(true, 10);
    }

    // Pie de página
    function Footer()
    {

    }
}
