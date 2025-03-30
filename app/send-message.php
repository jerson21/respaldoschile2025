<?php

// Asegúrate de que se esté accediendo al script mediante una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer el cuerpo de la solicitud JSON
    $data = json_decode(file_get_contents('php://input'), true);
    $message = $data['message'];

    // La URL a la que enviarás el mensaje
    $url = 'https://graph.facebook.com/v15.0/115436424863277/messages';

    // Token de acceso (asegúrate de usar uno válido)
    $accessToken = 'EAAqFhQwbrOwBOZBl8i5hNo51qGZAyRZCU4bB7EHbtXuH5hXawNkzBZBXQOp0p5gixm3ikNin4z5ihtG0vCWzS2EuQsFHhZARz9iPsOZA0bQnTyOp18qeUdyKIxJQEHox31Y3h7vDv0jZBZCDmjf50KXj7H9o53q0spvjYd43RsJg7xWfdyidplPhw9WP9uP0ZBaLEHxZCt21IuxdgghqLV';

    // Preparar el payload
   // Preparar el payload del mensaje
   $payload = [
    "messaging_product" => "whatsapp",
    "to" => "56956344617", // Reemplaza esto con el número de teléfono del destinatario
    "type" => "text",
    "text" => [
        "preview_url" => false,
        "body" => $message // El texto del mensaje que quieres enviar
    ]
];

    // Inicializar cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la solicitud
    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    // Manejar errores
    if ($err) {
        echo json_encode(['success' => false, 'error' => $err]);
    } else {
        echo $result; // O echo json_encode(['success' => true, 'result' => $result]);
    }
} else {
    // Método no permitido
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
