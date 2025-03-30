<?php 
// Creamos un array con los parámetros a enviar en la solicitud POST
$data = array(
  'user' => 'nombre_de_usuario',
  'message' => 'mensaje'
);

// Inicializamos la sesión cURL
$ch = curl_init();

// Configuramos las opciones de la solicitud
curl_setopt($ch, CURLOPT_URL, 'https://serverhuellero.azurewebsites.net/chatHub');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
  'protocol' => 'json',
  'version' => 1,
  'type' => 1,
  'target' => 'SendMessage',
  'arguments' => array($data['user'], $data['message'])
)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Connection: Upgrade',
  'Upgrade: websocket',
  'Sec-WebSocket-Version: 13',
  'Sec-WebSocket-Key: ' . base64_encode(openssl_random_pseudo_bytes(16))
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);

// Ejecutamos la solicitud
$response = curl_exec($ch);

// Verificamos si hubo errores en la solicitud
if ($response === false) {
  echo 'Error: ' . curl_error($ch);
} else {
  echo 'Respuesta del servidor: ' . $response;
}

// Cerramos la sesión cURL
curl_close($ch);
 ?>