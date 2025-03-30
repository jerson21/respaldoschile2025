<?php

// Realizar la conexión a la base de datos (asegúrate de tener tu clase de conexión configurada)
include "bd/conexion.php";
$objeto1 = new Conexion();
$conexion = $objeto1->Conectar();

// Obtener el término de búsqueda desde la solicitud
$searchTerm = isset($_GET['term']) ? $_GET['term'] : '';

// Consulta para obtener los datos de la base de datos
$sql = "SELECT id, codigopullman, agencodigo, IFNULL(NULLIF(comuna, ''), comunastarken) AS comuna 
        FROM agencias
        WHERE comuna LIKE :searchTerm OR codigopullman LIKE :searchTerm";
        
$consulta = $conexion->prepare($sql);
$consulta->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
$consulta->execute();

// Verificar si hay resultados
if ($consulta->rowCount() > 0) {
    $origenes = $consulta->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($origenes);
} else {
    echo json_encode(array()); // Devolver un array vacío si no hay resultados
}

?>