<?php

include("conexion.php");

$id = $_POST['id'];
$ruta = $_POST['nuevoorden'];



// SQL para actualizar un registro 
$query = "UPDATE pedido_detalle SET orden_ruta=$ruta WHERE id=$id";
if ($conn->query($query)) {
echo 1;
}else{
echo 0;
}

?>