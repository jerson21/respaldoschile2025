<?php
include("conexion.php");
$id = $_POST['agregarId'];
$ruta = $_POST['rutaId'];



// SQL para actualizar un registro 
$query = "UPDATE pedidos SET mododepago='{Eliminado}' WHERE id=$id";
if ($conn->query($query)) {
echo 1;
}else{
echo 0;
}




?>