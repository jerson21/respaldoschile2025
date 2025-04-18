<?php
class Conexion {
    public static function Conectar() {
        $dotenv_path = __DIR__ . '/../../../.env';
        if (!file_exists($dotenv_path)) {
            die("Error: El archivo .env es obligatorio y no se encontró.");
        }
        
        $dotenv = parse_ini_file($dotenv_path);
        
        // Verificamos que se encuentren todas las variables necesarias en el .env
        if (!isset($dotenv['DB_HOST'], $dotenv['DB_NAME'], $dotenv['DB_USER'], $dotenv['DB_PASS'])) {
            die("Error: Faltan algunas variables de configuración en el archivo .env.");
        }
        
        // Definimos las constantes usando los valores del .env
        define('SERVIDOR', $dotenv['DB_HOST']);
        define('NOMBRE_BD', $dotenv['DB_NAME']);
        define('USUARIO', $dotenv['DB_USER']);
        define('PASSWORD', $dotenv['DB_PASS']);

         $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
         
         try {
            $dsn = "mysql:host=" . SERVIDOR . ";dbname=" . NOMBRE_BD . ";charset=utf8";
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $conexion = new PDO($dsn, USUARIO, PASSWORD, $opciones);
            return $conexion;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
     
 }

class ConEcom {
    public static function Conectar2() {
        define('servidor_ecom', 'localhost');  // Cambiado el nombre de las constantes
        define('nombre_bd_ecom', 'cre61650_db_tiendadb');
        define('usuario_ecom', 'cre61650_respaldos21');
        define('password_ecom', 'respaldos21/');

        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        
        try {
            $conexion = new PDO("mysql:host=".servidor_ecom.";dbname=".nombre_bd_ecom, usuario_ecom, password_ecom, $opciones);
            return $conexion; 
        } catch (Exception $e) {
            die("El error de Conexión es: " . $e->getMessage());
        }
    }
}
?>