<?php
$url = 'https://graph.facebook.com/v15.0/115436424863277/messages';
$data = array(
    "messaging_product" => "whatsapp",
    "recipient_type" => "individual",
    "to" => "56956344617",
    "type" => "template",
    "template" => array(
        "name" => "confirmacion_de_entrega",
        "language" => array(
            "code" => "es"
        ),
        "components" => array(
            array(
                "type" => "body",
                "parameters" => array(
                    array(
                        "type" => "text",
                        "text" => $nombre
                    ),
                    array(
                        "type" => "text",
                        "text" => $productos
                    ),
                     array(
                        "type" => "text",
                        "text" => $fecha
                    ),
                      array(
                        "type" => "text",
                        "text" => $direccion
                    ),
                    array(
                        "type" => "text",
                        "text" => $total
                    )
                    
                )
            ),
        array(
        'type' => "button",
        'sub_type' => 'url',
        'index' => '0',
        'parameters' => array(
          array(
            'type' => 'text',
            'text' => "3331"
          )
        )
      ),
      array(
        'type' => 'button',
        'sub_type' => 'url',
        'index' => '1',
        'parameters' => array(
          array(
            'type' => 'text',
            'text' => "algo"
          )
        )
    )
     ) 
)

    );
$access_token = 'EAAqFhQwbrOwBAPexl6CqQZAwmgBzPabbPBZBhD5KxmkLBi1RYB0DxWFjjP8hpDYysEycMQrckeOcVxVrQ1oTFZBIoqGx1uEGcZA05VhWiiZBp3pLGF8RZCKZAaM242tiPfC8HzZCPr0e7Jimq89wD3pZAsZCK8if0ZCKvDEOGZAXy1wZBrwDOlTM08jekyZAp9iB5nSZCOtzPtFw36veaHTWZAjdyud8';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/json'
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);

echo $response;
?>




