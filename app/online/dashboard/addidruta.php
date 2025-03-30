a<?php
include("conexion.php");
$id = $_POST['agregarId'];
$ruta = $_POST['rutaId'];
$num_orden = $_POST['numero_orden'];

$contador = 0;
// SQL para actualizar un registro 
$query = "UPDATE pedido_detalle SET ruta_asignada='{$ruta}' WHERE id=$id";
if ($conn->query($query)) {
$contador= $contador +1;
}else{
echo 0;
}
/*
$query = "UPDATE orden SET ruta_asignada='{$ruta}' WHERE num_orden=$num_orden";
if ($conn->query($query)) {
$contador= $contador +1;
}else{
echo 0;
}



$query = "UPDATE orden SET estado='3' where num_orden=$num_orden"; // SE INDICA ESTADO PREPARANDO DESPACHO
if ($conn->query($query)) {
$contador= $contador +1;
}else{
echo "Falló el ingreso de datos: (" . $conn->error . ") " . $conn->error;
}

*/

echo $contador;

?>