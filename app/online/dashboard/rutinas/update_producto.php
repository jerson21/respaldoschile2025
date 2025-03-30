<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Obtener la acción y los datos del formulario
$accion = $_POST['accion'];
$id = isset($_POST['id']) ? $_POST['id'] : '';
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$color = isset($_POST['color']) ? $_POST['color'] : '';
$tela = isset($_POST['tela']) ? $_POST['tela'] : '';
$plazas = isset($_POST['plazas']) ? $_POST['plazas'] : '';
$alto = isset($_POST['alto']) ? $_POST['alto'] : '';
$ancho = isset($_POST['ancho']) ? $_POST['ancho'] : '';
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';

switch ($accion) {
    case 'agregar':
        $sql = "INSERT INTO productos_venta (categoria, modelo, color, tela, plazas, alto, ancho, descripcion) VALUES (:categoria, :nombre, :color, :tela, :plazas, :alto, :ancho, :descripcion)";
        $stmt = $conexion->prepare($sql);
        $result = $stmt->execute([
            ':categoria' => $categoria,
            ':nombre' => $nombre,
            ':color' => $color,
            ':tela' => $tela,
            ':plazas' => $plazas,
            ':alto' => $alto,
            ':ancho' => $ancho,
            ':descripcion' => $descripcion
        ]);
    
        if ($result) {
            echo "Producto agregado con éxito";
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Error al agregar producto: " . $errorInfo[2];  // errorInfo[2] contiene el mensaje de error específico del driver
        }
        break;
    
    case 'editar':
        $columna = $_POST['columna'];
        $valor = $_POST['valor'];
        $sql = "UPDATE productos_materiales SET $columna = :valor WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        if ($stmt->execute([':valor' => $valor, ':id' => $id])) {
            echo "Producto actualizado con éxito";
        } else {
            echo "Error al actualizar producto";
        }
        break;
    
    case 'eliminar':
        $sql = "DELETE FROM productos_materiales WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        if ($stmt->execute([':id' => $id])) {
            echo "Producto eliminado con éxito";
        } else {
            echo "Error al eliminar producto";
        }
        break;
}

$conexion = null;
?>