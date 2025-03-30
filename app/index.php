<?php 

$actual_link = "$_SERVER[REQUEST_URI]";

if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 1800)) {
    session_unset(); 
    session_destroy(); 
}

$_SESSION['start'] = time();

require_once("Config/Config.php");
require_once("Helpers/Helpers.php");

$url = !empty($_GET['url']) ? $_GET['url'] : 'home/home';
$arrUrl = explode("/", $url);
$controller = $arrUrl[0];
$method = !empty($arrUrl[1]) && $arrUrl[1] != "" ? $arrUrl[1] : $arrUrl[0];
$params = !empty($arrUrl[2]) ? implode(',', array_slice($arrUrl, 2)) : "";

// Verificar si la página actual es 'home' y si estamos en el período de mantenimiento
$fecha_actual = strtotime(date("d-m-Y H:i:00",time())); 
$fecha_entrada = strtotime("08-07-2024 18:25:00");
if ($controller == 'home' && $method == 'home' && $fecha_actual < $fecha_entrada) {
    echo '<!DOCTYPE html>';
    echo '<html lang="es">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>Plataforma en Mantención</title>';
    echo '<style>';
    echo 'body { font-family: Arial, sans-serif; margin: 0; padding: 0; height: 100vh; display: flex; align-items: center; justify-content: center; flex-direction: column; background-color: #f4f4f4; color: #333; }';
    echo 'h1 { font-size: 2rem; margin-bottom: 20px; }';
    echo 'img { max-width: 100%; height: auto; }';
    echo '.container { text-align: center; padding: 20px; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div class="container">';
    echo '<h1>MANTENIMIENTO PLATAFORMA</h1>';
    echo '<p>Volvemos a las ' . date("H:i:00", $fecha_entrada) . '</p>';
    echo '<img src="https://www.respaldoschile.cl/mantencion.png" width="150" alt="Mantenimiento">';
    echo '</div>';
    echo '</body>';
    echo '</html>';
    exit;// Evita cargar más contenido después de esta página
}

require_once("Libraries/Core/Autoload.php");
require_once("Libraries/Core/Load.php");

?>
