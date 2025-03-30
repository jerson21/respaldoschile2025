<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$sql = "SELECT id, nombre FROM categorias";
$resultado = $conexion->query($sql);
$categorias = $resultado->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($categorias);