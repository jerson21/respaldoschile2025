<?php
session_start();
if (isset($_SESSION["s_usuario"])) {
    unset($_SESSION["s_usuario"]);
    session_destroy();
}

// Redirigir correctamente a la página principal del sistema
header("Location: ../");
exit();
?>