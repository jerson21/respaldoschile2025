<?php

$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
// Configura las opciones de cURL.
curl_setopt_array($curl, [
    
    CURLOPT_URL => 'https://www.nombrerutyfirma.com/rut',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => http_build_query(['term' => '18.606.594-8']), // Asegúrate de que los datos estén codificados correctamente.
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.e30.gXEgrSSOWRwhyozo1BB0Aa7nvVjl_cbbBaPE4Hl_l8w'
    ],
]);

// Ejecuta la llamada y almacena la respuesta.
$response = curl_exec($curl);

// Verifica si hay error en cURL.
if ($response === false) {
    $error = curl_error($curl);
    echo "cURL Error: $error";
    curl_close($curl);
    return; // Termina la ejecución si hay error.
}

// Cierra la sesión cURL.
curl_close($curl);

// Continúa con el procesamiento solo si hay respuesta.
if (!empty($response)) {
   // echo "si hay datos";
    // Procesa la respuesta.
    $dom = new DOMDocument;
    libxml_use_internal_errors(true); // Evita los warnings por HTML mal formado.
    $dom->loadHTML($response);
    libxml_clear_errors(); // Limpia los errores de libxml.
    // El resto de tu código sigue aquí...
} else {
   // echo "La respuesta está vacía";
}

// Procesa la respuesta para extraer la información deseada.
$dom = new DOMDocument;
libxml_use_internal_errors(true); // Evita los warnings por HTML mal formado.
$dom->loadHTML($response);
libxml_clear_errors(); // Limpia los errores de libxml.

$xpath = new DOMXPath($dom);

// Define la ruta de los elementos que quieres extraer.
$tr_elements = $xpath->query("//table[@class='table table-hover']/tbody/tr");

$nestedData = []; // Prepara el arreglo para almacenar los datos.

foreach ($tr_elements as $tr) {
    $tds = $tr->getElementsByTagName('td');
    if ($tds->length > 0) {
        $nestedData = [
            'rut' => $tds->length > 1 ? $tds->item(1)->nodeValue : $rut,
            'nombre' => $tds->item(0)->nodeValue,
            'sexo' => $tds->length > 2 ? $tds->item(2)->nodeValue : '',
            'direccion' => $tds->length > 3 ? $tds->item(3)->nodeValue : '',
            'ciudad_comuna' => $tds->length > 4 ? $tds->item(4)->nodeValue : '',
            // Campos adicionales sin datos directos de la API:
            'telefono' => '',
            'correo' => '',
            'numero' => '',
            'dpto' => '',
            'instagram' => '',
            'region' => '', // Considerar cómo obtener este dato, si es posible desde la API o dejar vacío.
            // 'comuna' ya está incluida como 'ciudad_comuna'
        ];
        break; // Suponiendo que solo necesitas los datos del primer <tr> encontrado.
    }
}

var_dump($nestedData); // Devuelve los datos organizados.
