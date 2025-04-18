<?php
// Realizar la conexión a la base de datos
include "bd/conexion.php";
$objeto1 = new Conexion();
$conexion = $objeto1->Conectar();

// Obtener el término de búsqueda desde la solicitud
$searchTerm = isset($_GET['term']) ? $_GET['term'] : '';

// Modifica la consulta usando dos placeholders distintos
$sql = "SELECT id, codigopullman, agencodigo, IFNULL(NULLIF(comuna, ''), comunastarken) AS comuna 
        FROM agencias
        WHERE comuna LIKE :searchTerm1 OR codigopullman LIKE :searchTerm2";
        
$consulta = $conexion->prepare($sql);
$param = '%' . $searchTerm . '%';
$consulta->bindValue(':searchTerm1', $param, PDO::PARAM_STR);
$consulta->bindValue(':searchTerm2', $param, PDO::PARAM_STR);
$consulta->execute();

if ($consulta->rowCount() > 0) {
    $origenes = $consulta->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($origenes);
} else {
    echo json_encode(array());
}
?>
