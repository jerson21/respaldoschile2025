<?php

include("conexion.php");


$query = "SELECT * FROM clientes";

$result = mysqli_query($conn, $query);

// Crear el arreglo de datos para el DataTable
$data = array();
$contador = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $nestedData = array();
    $nestedData['num'] = $contador++;
    $nestedData['rut'] = $row['rut'];
    $nestedData['nombre'] = $row["nombre"];
    $nestedData['telefono'] = $row["telefono"];
    $nestedData['correo'] = $row["correo"];
        $nestedData['instagram'] = $row["instagram"];

    $nestedData[] = "";

    $data[] = $nestedData;
}

// Liberar memoria del resultado


// Cerrar la conexión
mysqli_close($conn);

// Crear el arreglo de respuesta para el DataTable
$response = array(
    "data" => $data
);

// Devolver los datos en formato JSON
echo json_encode($response);


?>