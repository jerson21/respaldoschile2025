<?php
require_once 'conexion.php'; // Asegúrate de que este archivo existe y es accesible

$conexion = (new Conexion())->Conectar();

// Seleccionar todas las contraseñas antiguas
$query = "SELECT id, usuario, password FROM usuarios";
$result = $conexion->query($query);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $old_password = $row['password'];

    // Generar el nuevo hash
    $new_hashed_password = password_hash($old_password, PASSWORD_DEFAULT);

    // Actualizar la contraseña en la BD
    $update_query = "UPDATE usuarios SET password = :new_password WHERE id = :id";
    $stmt = $conexion->prepare($update_query);
    $stmt->bindParam(':new_password', $new_hashed_password);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo "Usuario: " . $row['usuario'] . " - Contraseña actualizada correctamente.<br>";
}
?>
