<?php
require_once 'config.php';

class Conexion {
    public static function Conectar() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        
        try {
            $conexion = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ]);
            return $conexion;
        } catch (PDOException $e) {
            error_log("Error de conexión: " . $e->getMessage()); // Se registra el error en logs
            die("Error de conexión a la base de datos"); // No se muestra el error detallado en producción
        }
    }
}
?>
