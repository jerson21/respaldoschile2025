<?php
session_start();

// Carga de dependencias y configuraciones
// Activar errores en modo desarrollo
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// Claves de API de Transbank para integración (modificarlas en producción)
define('TBK_API_KEY_ID', '597045358953');  // Cambia esto por tu código de comercio en producción
define('TBK_API_KEY_SECRET', '4db548a2-9ceb-4da1-8acb-750dce0435ec');  // Cambia esto por tu clave secreta en producción */
/* define('TBK_API_KEY_ID', '597055555532');  
define('TBK_API_KEY_SECRET', '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C');  */


//597055555532
//579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C

// Formar la URL 
// Configuración de la URL de la API de Transbank
//define('TBK_ENDPOINT', 'https://webpay3gint.transbank.cl/rswebpaytransaction/api/webpay/v1.0/transactions');

// Otros parámetros de configuración de la aplicación
$num_orden = isset($_POST['webpaynum_orden']) && is_numeric($_POST['webpaynum_orden']) ? intval($_POST['webpaynum_orden']) : 0;

$secret_key = '333314565';

// Generar un token basado en el número de orden y un timestamp
$timestamp = time(); // Timestamp actual para incluir algo de entropía
$token = hash_hmac('sha256', $num_orden, $secret_key);


$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$return_url = $protocol . $_SERVER['HTTP_HOST'] . "/cliente_confirma?r=$num_orden&token=$token&action=custom_action";
 echo $return_url;
define('LOG_PATH', __DIR__ . '/logs/');


// Código para generar el token y redirigir a Transbank
$buy_order = time();
$session_id = session_id();
$amount = $_POST['amount'];


$data = [
    'buy_order' => $buy_order,
    'session_id' => $session_id,
    'amount' => $amount,
    'return_url' => $return_url 
];

$endpoint = '/rswebpaytransaction/api/webpay/v1.0/transactions';
//$url = "https://webpay3gint.transbank.cl" . $endpoint;
$url = "https://webpay3g.transbank.cl" . $endpoint;//Live
$curl = curl_init($url);

curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Tbk-Api-Key-Id: ' . TBK_API_KEY_ID,
        'Tbk-Api-Key-Secret: ' . TBK_API_KEY_SECRET
    ],
]);

$response = curl_exec($curl);
$responseData = json_decode($response, true);

if (isset($responseData['token'])) {
    $_SESSION['payment_token'] = $responseData['token'];
    header("Location: " . $responseData['url'] . "?token_ws=" . $responseData['token']);
    exit;
} else {
    echo "Error al obtener token de Transbank.";
}