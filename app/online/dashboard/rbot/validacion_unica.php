<?php
$log = "log.txt";
date_default_timezone_set('America/Santiago');

$startTime = microtime(true);
file_put_contents($log, "Ejecutado el " . date("Y-m-d H:i:s") . "\n", FILE_APPEND);

$url = 'https://z21jpv2xb0.execute-api.sa-east-1.amazonaws.com/default/nuevafuncionbanc';

// Fechas para la solicitud (fecha de hoy)
$startDate = date('d/m/Y');
$endDate = date('d/m/Y');

echo "Consultando datos desde $startDate hasta $endDate\n";

// Datos para la solicitud
$data = array(
    'clave' => 'valor', // Aquí puedes añadir más datos según sea necesario
    'searchType' => 'dateRange',
    'startDate' => $startDate,
    'endDate' => $endDate
);

// Inicia cURL
$ch = curl_init($url);

// Configura la solicitud POST
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Desactivar la verificación de SSL (si es necesario)
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Ejecuta la solicitud y captura la respuesta
$response = curl_exec($ch);
if ($response === false) {
    error_log('cURL error: ' . curl_error($ch));
    echo "Error al realizar la solicitud: " . curl_error($ch) . "\n";
} else {
    echo "Respuesta recibida: " . $response . "\n";
}

// Cierra el recurso cURL
curl_close($ch);

// Procesa la respuesta
if ($response) {
    $responseData = json_decode($response, true);
    if (!isset($responseData['data']) || empty($responseData['data'])) {
        error_log('Datos no encontrados en la respuesta');
        echo "Datos no encontrados en la respuesta\n";
    } else {
        echo "Datos decodificados: \n";
        foreach ($responseData['data'] as $dataItem) {
            echo print_r($dataItem, true) . "\n";
        }
    }
} else {
    echo "Error al realizar la solicitud\n";
}

// Al final del script, calcula la duración y guarda en el log
$endTime = microtime(true);
$executionTime = $endTime - $startTime; // Duración en segundos

// Ahora también guardamos la duración de la ejecución en el log
file_put_contents($log, "Ejecutado el " . date("Y-m-d H:i:s") . " - Duración: " . $executionTime . " segundos\n", FILE_APPEND);
?>
