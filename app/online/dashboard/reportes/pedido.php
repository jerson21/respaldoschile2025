<?php
/// Powered by Evilnapsis go to http://evilnapsis.com
include "fpdf/fpdf.php";

require "conexion.php";

error_reporting(0);


    $id = $_GET['id'];
    $sql = "SELECT * FROM pedido p 
INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden
INNER JOIN clientes c ON p.rut_cliente = c.rut WHERE d.num_orden = $id";
    $resultado = $mysqli->query($sql);

    $sql3 = "SELECT * FROM pedido p 
INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden
INNER JOIN clientes c ON p.rut_cliente = c.rut where d.num_orden = $id LIMIT 1";
    $resultado2 = $mysqli->query($sql3);

    while ($fila2 = $resultado2->fetch_assoc()) {
        $rut = $fila2['rut_cliente'];
         $fecha_ingreso = $fila2['fecha_ingreso'];
        $forma_pago =  ucfirst($fila2['formadepago']);
        $vendedor =  ucfirst($fila2['vendedor']);
         }


     $sql2 = "SELECT * FROM pedido p 
INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden
INNER JOIN clientes c ON p.rut_cliente = c.rut where rut = '$rut'";
        
    $resultado_cliente = $mysqli->query($sql2);


$pdf = new FPDF($orientation='P',$unit='mm');

$pdf->AddPage();
$pdf->SetFont('Arial','B',20);  
$pdf->Image("images/logo.png", 15, 10, 15);   
$textypos = 5;
$pdf->setY(12);
$pdf->setX(0);
$pdf->Cell(0, 10, "COMPROBANTE DE ABONO", 0, 1, 'C');
$pdf->setY(12);
$pdf->setX(10);
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Empresa");
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Redeco Muebles");
$pdf->setY(40);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Av Gabriela 02861");
$pdf->setY(45);$pdf->setX(10);
$pdf->Cell(5,$textypos,"+56979941253");
$pdf->setY(50);$pdf->setX(10);
$pdf->Cell(5,$textypos,"contacto@respaldoschile.cl");

while ($fila2 = $resultado_cliente->fetch_assoc()) {
    $nombre = $fila2['nombre'];
    $telefono = $fila2['telefono'];
    $correo = $fila2['correo'];
    $rut = $fila2['rut_cliente'];
    $direccion = $fila2['direccion'] . " " . $fila2['numero'] . " " . $fila2['dpto'] . " " . $fila2['comuna'];
    if($correo == ""){
        $correo = "Sin correo";
    }
}


// Agregamos los datos del cliente
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(75);
$pdf->Cell(5,$textypos,"Cliente:");
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(75);
$pdf->Cell(5,$textypos,$nombre);
$pdf->setY(40);$pdf->setX(75);
$pdf->Cell(5,$textypos,$telefono);
$pdf->setY(45);$pdf->setX(75);
$pdf->Cell(5,$textypos,$correo);
$pdf->setY(50);$pdf->setX(75);
$pdf->Cell(5,$textypos,$direccion);


// Agregamos los datos del cliente
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(150);
$pdf->Cell(5,$textypos,"Orden ". $id);
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(150);
$pdf->Cell(5,$textypos,"Fecha: ". $fecha_ingreso);
$pdf->setY(40);$pdf->setX(150);
$pdf->Cell(5,$textypos,"Forma Pago: ". $forma_pago);
$pdf->setY(45);$pdf->setX(150);
$pdf->Cell(5,$textypos,"Vendedor: ". $vendedor);
$pdf->setY(50);$pdf->setX(150);
$pdf->Cell(5,$textypos,"");
$pdf->setY(55);$pdf->setX(150);
$pdf->Cell(5,$textypos,"");



//    $categoria = mysqli_escape_string($mysqli, $_POST['categoria']);






/// Apartir de aqui empezamos con la tabla de productos
$pdf->setY(60);$pdf->setX(135);
    $pdf->Ln();
/////////////////////////////
//// Array de Cabecera
$header = array("Cod.", "Descripcion","Cant.","Precio");
//// Arrar de Productos

  


$products = array(


    array("0010", "Producto 1",2,120,0),
    array("0024", "Producto 2",5,80,0),
    array("0001", "Producto 3",1,40,0),
    array("0001", "Producto 3",5,80,0),
    array("0001", "Producto 3",4,30,0),
    array("0001", "Producto 3",7,80,0),
);
    // Column widths
    $w = array(15, 135, 10, 25, 25);
    // Header
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C');
    $pdf->Ln();
    // Data
    $total = 0;
    $abono = 0;
$comentarios = "";
setlocale(LC_MONETARY, 'CLP');
    while ($fila = $resultado->fetch_assoc()) {
        $producto_detalle = $fila['modelo']." ".$fila['tamano']." ".$fila['tipotela']." ".$fila['color']." ".$fila['alturabase'];
       $producto_detalle = strtolower($producto_detalle);

        $pdf->Cell($w[0], 6, $fila['id'], 1, 0, "C");        
        $pdf->Cell($w[1], 6, ucwords($producto_detalle), 1, 0, "C");
        $pdf->Cell($w[2], 6, 1, 1, 0, "C");

        $pdf->Cell($w[3], 6,'$ '.number_format($fila['precio'], 0, ".", ".") , 1, 0, "C");

        $precio = intval($fila['precio']);
        $total+= $precio;





        $abono+= $fila['abono'];



        $comentarios.= $fila['detalles_fabricacion']." ";
         $pdf->Ln(6);
    }



    $por_pagar = $total - $abono;


   /* foreach($products as $row)
    {
        $pdf->Cell($w[0],6,$row[0],1);
        $pdf->Cell($w[1],6,$row[1],1);
        $pdf->Cell($w[2],6,number_format($row[2]),'1',0,'R');
        $pdf->Cell($w[3],6,"$ ".number_format($row[3],2,".",","),'1',0,'R');
        $pdf->Cell($w[4],6,"$ ".number_format($row[3]*$row[2],2,".",","),'1',0,'R');

        $pdf->Ln();
        $total+=$row[3]*$row[2];

    }*/
/////////////////////////////









//// Apartir de aqui esta la tabla con los subtotales y totales
$yposdinamic = 70 + (count($products)*8);


//// Apartir de aqui esta la tabla con los subtotales y totales
$sql = "SELECT * from pedido_detalle where num_orden = $id";
    $resultado = $mysqli->query($sql);
$pdf->setY($yposdinamic+7);
$pdf->setX(10);



$incremento = 0; // Variable para incrementar la posición vertical en cada iteración

while ($fila = $resultado->fetch_assoc()) {

    if($fila['detalles_fabricacion'] != ""){
    $pdf->SetFont('Arial', 'B', 10); // Establecer fuente en negrita
    $pdf->Cell(5, $textypos, $fila['id']."-", 0, 0, 'B');
    $pdf->SetFont('Arial', '', 10); // Restaurar fuente normal
    $pdf->Cell(5, $textypos, "       " . ucfirst($fila['detalles_fabricacion']));
    $pdf->setY($yposdinamic + 12 + $incremento);
    $pdf->setX(10);
    $incremento += 5;
    }
}
 
$pdf->setY($yposdinamic);
$pdf->setX(10);
$pdf->SetFont('Arial', 'B', 10); 
$pdf->Cell(5,$textypos,"OBSERVACIONES");
$pdf->SetFont('Arial', 'B', 10);   







$header = array("", "");

$data2 = array(

   array("Subtotal", $total),
    array("Abono", $abono),
    array("Por Pagar",$por_pagar),
     
   
);

// Column widths
$w2 = array(40, 40);
// Header

// Data
$ypos = 160; // Posición inicial de las celdas de subtotales y totales
$xpos = 115; // Posición horizontal para las celdas de subtotales y totales
$pdf->setY($ypos);
$pdf->setX($xpos);

foreach ($data2 as $row) {
    $pdf->setX($xpos); // Establecer la posición horizontal de las celdas de subtotales y totales
    $pdf->Cell($w2[0], 6, $row[0], 1, 0, 'R'); // Alineación a la derecha
    $pdf->Cell($w2[1], 6, "$ " . number_format($row[1], 0, ".", "."), 1, 0, 'R'); // Alineación a la derecha
    $pdf->Ln();
    $ypos += 6; // Aumentar la posición vertical para la siguiente iteración
}

/////////////////////////////

$yposdinamic += (count($data2) * 25);
$pdf->SetFont('Arial', 'B', 10);

$pdf->setY($yposdinamic);
$pdf->setX(10);
$pdf->Cell(0, $textypos, "TERMINOS Y CONDICIONES"); // Use 0 for width to make the cell extend to the right margin
$pdf->SetFont('Arial', '', 9);

$pdf->Ln(10); // Move down 10 units

$text1 = iconv('UTF-8', 'ISO-8859-1', 'Plazo de entrega de 3 a 15 días hábiles.');
$text2 = iconv('UTF-8', 'ISO-8859-1', 'Una vez fabricado, no se pueden realizar cambios de color ni tela.');
$text3 = iconv('UTF-8', 'ISO-8859-1', 'Para conocer el estado de su pedido, puede comunicarse con nuestro equipo a través de WhatsApp al +56979941253, indicando el código de pedido: ' . $id);
$text4 = iconv('UTF-8', 'ISO-8859-1', 'Nuestros despachadores no están autorizados para ingresar a domicilios ni subir a departamentos. Se realizará la entrega en el acceso principal del edificio o domicilio.');
$pdf->setX(10);
$pdf->MultiCell(0, $textypos, $text1);



$pdf->setX(10);
$pdf->MultiCell(0, $textypos, $text2);



$pdf->setX(10);
$pdf->MultiCell(0, $textypos, $text3);

$pdf->setX(10);
$pdf->MultiCell(0, $textypos, $text4);







$apiUrl = 'https://chart.googleapis.com/chart';
$text = 'https://www.respaldoschile.cl/seguimientocompra.php?rut='. $rut;
$size = 130;

$url = $apiUrl . '?cht=qr&chs=' . $size . 'x' . $size . '&chl=' . urlencode($text);

$imageData = file_get_contents($url);

// Guardar la imagen en un archivo local (opcional)
$qrCodeImagePath = 'qr_code.png';
file_put_contents($qrCodeImagePath, $imageData);

// Agregar la imagen del código QR al PDF
$pdf->Image($qrCodeImagePath, $x, $y, $width, $height);

$text1 = iconv('UTF-8', 'ISO-8859-1', 'Escanea para ver el estado de tu pedido.');
$pdf->setX(5);

$pdf->MultiCell(0, $textypos, $text1);


$pdf->Line(110, 260, 210-20, 260); // 20mm from each edge




$pdf->output();
