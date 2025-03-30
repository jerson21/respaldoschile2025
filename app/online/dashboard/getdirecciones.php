<?php

include("conexion.php");

// Obtener el rut del cliente enviado por POST
$rut = $_POST['rut'];

// Consultar las direcciones del cliente en la base de datos
$query = "SELECT * FROM direccion_clientes WHERE rut_cliente = $rut";
$result = $conn->query($query);

// Crear un array para almacenar las direcciones
$direcciones = array();

if ($result->num_rows > 0) {
  // Recorrer los resultados y agregar las direcciones al array
  while ($row = $result->fetch_assoc()) {
    $direcciones[] = $row['direccion'];
  }
}

// Cerrar la conexión a la base de datos
$conn->close();

// Crear un array con los datos de las direcciones
$response = array(
  'direcciones' => $direcciones
);

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>