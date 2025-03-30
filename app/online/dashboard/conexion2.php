<?php
 class Conexion{
     public static function Conectar(){
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