<?php
class Conexion {
    public static function Conectar() {
        // Intentar cargar variables de entorno si existe el archivo .env
        $dotenv_path = __DIR__ . '/../../../.env';
        if (file_exists($dotenv_path)) {
            $dotenv = parse_ini_file($dotenv_path);
            define('servidor', $dotenv['DB_HOST'] ?? 'db'); // Usa el valor de DB_HOST si existe, o 'db' por defecto
        } else {
            // Configuración por defecto si no hay .env
            define('servidor', 'db'); // 'db' es el nombre del servicio en Docker
        }
         define('nombre_bd','cre61650_agenda');
         define('usuario','cre61650_respaldos21');
         define('password','respaldos21/');   


         $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
         
         try{
            $conexion = new PDO("mysql:host=".servidor.";dbname=".nombre_bd, usuario, password, $opciones);             
            return $conexion; 
         }catch (Exception $e){
             die("El error de Conexión es :".$e->getMessage());
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