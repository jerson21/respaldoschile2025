<?php 	
class Conexionbd{    
    private $host   ="localhost";
    private $usuario="cre61650_respaldos21";
    private $clave  ="respaldos21/";
    private $db     ="cre61650_agenda";
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli($this->host, $this->usuario, $this->clave,$this->db) or die(mysql_error());
        $this->conexion->set_charset("utf8");
    }
}

    $conn=mysqli_connect('localhost','cre61650_respaldos21','respaldos21/','cre61650_agenda');



$BD_SERVIDOR = "localhost";
$BD_USUARIO ="cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);
$conn->set_charset("utf8");

class Conexion{
     public static function Conectar(){
         /*define('servidor','localhost');
         define('nombre_bd','cre61650_agenda');
         define('usuario','cre61650_respaldos21');
         define('password','respaldos21/'); */

         define('servidor','localhost');
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
?>