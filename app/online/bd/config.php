<?php
//$dotenv = parse_ini_file(__DIR__ . '/../.env'); // ruta según tu estructura


//Datos de conexión a Base de Datos
// Usar DB_HOST de .env si existe, sino fallback a 'db' para Docker
define('DB_HOST', !empty($dotenv['DB_HOST']) ? $dotenv['DB_HOST'] : 'db');
define('DB_NAME', 'cre61650_agenda');
define('DB_USER', 'cre61650_respaldos21');
define('DB_PASS', 'respaldos21/');
?>
