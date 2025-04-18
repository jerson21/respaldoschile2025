<?php

session_start();
header('Content-Type: application/json'); // Asegurar que la respuesta sea JSON

$mensaje = "";

// Verificar si la sesión expiró
if (isset($_GET['timeout'])) {
    $mensaje = "⚠️ Tu sesión ha expirado por inactividad. Por favor, inicia sesión nuevamente.";
}

// Conectar a la base de datos
require_once 'conexion.php';

try {
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();
} catch (Exception $e) {
    echo json_encode(["error" => "No se pudo conectar a la base de datos."]);
    exit();
}

// Verificar si se enviaron datos del usuario
if (empty($_POST['usuario']) || empty($_POST['password'])) {
    echo json_encode(["error" => "Usuario o contraseña no enviados."]);
    exit();
}

$usuario = trim($_POST['usuario']);
$password = trim($_POST['password']);

// Consultar usuario en la base de datos
$consulta = "SELECT * FROM usuarios WHERE usuario = :usuario";
$resultado = $conexion->prepare($consulta);
$resultado->bindParam(':usuario', $usuario, PDO::PARAM_STR);
$resultado->execute();

$data = $resultado->fetch(PDO::FETCH_ASSOC);

if ($data) {
    // Verificar la contraseña con password_verify()
    if (password_verify($password, $data['password'])) {
        session_regenerate_id(true); // Previene la fijación de sesión
        $_SESSION["s_usuario"] = $usuario;
        $_SESSION["privilegios"] = $data['privilegios'];
        $_SESSION["ultimo_acceso"] = time();
    
        echo json_encode(["status" => "success", "redirect" => "dashboard/"]);
    }
    else {
        echo json_encode(["status" => "error","error" => "Usuario o contraseña incorrectos."]);
    }
} else {
    echo json_encode(["error" => "Usuario o contraseña incorrectos."]);
}
?>
