<?php
 include_once 'bd/conexion.php'; 
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$monto = $_POST['monto'];
$detalle = $_POST['detalle'];
$fecha = date('Y-m-d');

$consulta = "INSERT INTO gastos (monto, detalle, fecha) VALUES('$monto', '$detalle', '$fecha') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 




echo "<script type='text/javascript'> alert('Detalle guardado');";
    echo "window.history.back(-1)";
    echo "</script>";

?>