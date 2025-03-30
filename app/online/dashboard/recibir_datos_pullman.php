<?php
include "bd/conexion.php";
$objeto1 = new Conexion();
$conexion = $objeto1->Conectar();
  $destino = $_POST["destino"];
// Consulta para obtener los datos de la base de datos
$sql = "SELECT * FROM agencias WHERE id = $destino";
$resultado = $conexion->query($sql);

if ($resultado) {
    // Verifica que la consulta fue exitosa

    // Obtén la fila asociada al resultado
    $row = $resultado->fetch(PDO::FETCH_ASSOC);

    // Comprueba si la fila tiene datos
    if ($row) {
        // Accede a la columna específica que deseas imprimir
        $AGENCODIGO = $row['AGENCODIGO'];
         $comuna_pullmancargo = $row['codigopullman'];
          $CIUDCODIGO = $row['CIUDCODIGO'];
             $TIPO_ENTREGA = $row['TIPO_ENTREGA'];

            
        
        // Imprime la comuna
        
    } else {
        echo "No se encontraron datos para el ID proporcionado.";
    }
} else {
    echo "Error en la consulta: " . $conexion->errorInfo()[2];
}

// Recuerda cerrar la conexión después de usarla
$conexion = null;


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si se ha enviado un formulario
   $selected = $_POST["selected"];
    $origen = "1310100101&SANTIAGO";
    
    $pago = "PED";
    $alto = $_POST["alto"];
    $ancho = $_POST["ancho"];
    $largo = $_POST["largo"];
    $lugar = $_POST["lugar"];
    $peso = $_POST["peso"];
    $telefono = $_POST["telefono"];
    // Agregar otros campos aquí

    // Crear datos para la solicitud cURL a pullmango.cl
    $data_pullmango = array(
        "selected" => $selected,
        "origen" => $origen,
        "destino" => $comuna_pullmancargo,
        "pago" => $pago,
        "alto" => $alto,
        "ancho" => $ancho,
        "largo" => $largo,
        "lugar" => $lugar,
        "peso" => $peso,
        "telefono" => $telefono
    );

    $data_string_pullmango = json_encode($data_pullmango);

    // Realizar la solicitud cURL a pullmango.cl
    $curl_pullmango = curl_init();
    curl_setopt_array($curl_pullmango, array(
        CURLOPT_URL => 'https://www.pullmango.cl/api/cotizar',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data_string_pullmango,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));
    $response_pullmango = curl_exec($curl_pullmango);
    curl_close($curl_pullmango);

    if($TIPO_ENTREGA == "-"){
        $tiene_domicilio = "DOMICILIO";
    }else{
         $tiene_domicilio = "AGENCIA";
    }

    // Datos para Starken
$data_starken = array(
    "entrega" => "DOMICILIO",
    "tipoServicio" => "NORMAL",
    "codigoAgenciaDestino" => $AGENCODIGO,
    "codigoAgenciaOrigen" => 1197,
    "rutCliente" => "",
    "codigoTipoPago" => 1,
    "codigoCiudadOrigen" => 1,
    "codigoCiudadDestino" => $CIUDCODIGO,
    "rutDestinatario" => "",
    "encargos" => [
        ["tipoEncargo" => "29", "alto" => $alto, "ancho" => $ancho, "largo" => $largo, "kilos" => $peso]
    ]
);

// Convertir a formato JSON
$data_string_starken = json_encode($data_starken);

// Iniciar cURL para Starken
$curl_starken = curl_init();

// Configuración para Starken
curl_setopt_array($curl_starken, array(
    CURLOPT_URL => 'https://apiprod.starkenpro.cl/quote/caja-tarifa/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $data_string_starken,
    CURLOPT_HTTPHEADER => array(
        'api-key: def67c5e3ad0527b7a876fb3231d009b',
        'Content-Type: application/json',
        'Authorization: Bearer 25ed8eca-3fb3-4fd6-8a14-9b149ab56689'
    ),
));

    // Ejecutar la consulta cURL para Starken
$response_starken = curl_exec($curl_starken);

// Cerrar la conexión cURL para Starken
curl_close($curl_starken);

    // Transformar las respuestas en un array asociativo
    $responseArray_pullmango = json_decode($response_pullmango, true);
    $responseArray_hereapi = json_decode($response_starken, true);

    // Combinar ambas respuestas en un solo array
    $combinedResponse = array(
        'pullmango' => $responseArray_pullmango,
        'hereapi' => $responseArray_hereapi
    );

    // Enviar la respuesta combinada como JSON
    header('Content-Type: application/json');
    echo json_encode($combinedResponse);
}
?>