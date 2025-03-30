<?php


error_reporting(0);



require_once 'Classes/PHPExcel.php';



$archivo = "libro1.xls";
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();
$rut = $_GET['id'];
$monto = "300";



for ($row = 10; $row <= $highestRow; $row++){ 
    $rute = $sheet->getCell("B".$row)->getValue();
    $rute = limpiar($rute);

    $monto_pagado = $sheet->getCell("F".$row)->getValue();
    $monto_pagado = limpiar($monto_pagado);
    //&& $monto == $monto_pagado


$rut = limpiar($rut);

        if(preg_match("/{$rut}/i", $rute)){
            $fecha = $sheet->getCell("A".$row)->getValue();
            $id_transferencia = $sheet->getCell("B".$row)->getValue();
            $nombre = $sheet->getCell("H".$row)->getValue();
            $monto = $sheet->getCell("F".$row)->getValue();
            $banco = $sheet->getCell("D".$row)->getValue();

            $data['rut'] = $rut;
            $data['fecha'] =    $fecha;
             $data['id_transferencia'] =    $id_transferencia;
            $data['nombre'] =   $nombre;
            $data['monto'] =   $monto;
            $data['banco'] =  $banco;
            

        }
         $sheet->getCell("A".$row)->getValue()." – ";
         $sheet->getCell("B".$row)->getValue()." – ";
         $sheet->getCell("C".$row)->getValue()." – ";
          $sheet->getCell("D".$row)->getValue()." – ";
          $sheet->getCell("E".$row)->getValue();
           $sheet->getCell("F".$row)->getValue();
           $sheet->getCell("G".$row)->getValue();
           $sheet->getCell("H".$row)->getValue();

        
}



function limpiar($s)
{
$s = str_replace('á', 'a', $s);
$s = str_replace('Á', 'A', $s);
$s = str_replace('é', 'e', $s);
$s = str_replace('É', 'E', $s);
$s = str_replace('í', 'i', $s);
$s = str_replace('Í', 'I', $s);
$s = str_replace('ó', 'o', $s);
$s = str_replace('Ó', 'O', $s);
$s = str_replace('Ú', 'U', $s);
$s= str_replace('.', '', $s);
$s= str_replace('-', '', $s);
return $s;
}

if($data == null){
   $data['nombre'] = "NO EXISTEN PAGOS";  


}

echo json_encode($data,JSON_UNESCAPED_UNICODE);


?>
