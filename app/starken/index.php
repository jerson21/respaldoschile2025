<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body >
    <div style="background:#E7E7E7;max-width: 500px;">
<?php


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://gateway.starken.cl/externo/integracion/tracking/orden-flete/of/979967790',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'api-key: def67c5e3ad0527b7a876fb3231d009b',
    'Authorization: Bearer 25ed8eca-3fb3-4fd6-8a14-9b149ab56689'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "Consulta de seguimiento: <br><pre>";
echo $response;
echo "</pre>";


//REGIONES 


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiprod.starkenpro.cl/agency/region',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS =>'{"entrega":"AGENCIA","tipoServicio":"NORMAL","codigoAgenciaDestino":1763,"codigoAgenciaOrigen":281,"rutCliente":"","codigoTipoPago":1,"codigoCiudadOrigen":1,"codigoCiudadDestino":1,"rutDestinatario":"","encargos":[{"tipoEncargo":"29","alto":"120","ancho":"15","largo":"200","kilos":"13"}]}',
  CURLOPT_HTTPHEADER => array(
    'api-key: def67c5e3ad0527b7a876fb3231d009b',
    'Content-Type: application/json',
    'Authorization: Bearer 25ed8eca-3fb3-4fd6-8a14-9b149ab56689'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo " Consulta de regiones: <br><pre>";
print_r($response);
echo " </pre>";













// COTIZACIÓN

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiprod.starkenpro.cl/quote/caja-tarifa/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"entrega":"AGENCIA","tipoServicio":"NORMAL","codigoAgenciaDestino":1763,"codigoAgenciaOrigen":281,"rutCliente":"","codigoTipoPago":1,"codigoCiudadOrigen":1,"codigoCiudadDestino":1,"rutDestinatario":"","encargos":[{"tipoEncargo":"29","alto":"120","ancho":"15","largo":"150","kilos":"13"}]}',
  CURLOPT_HTTPHEADER => array(
    'api-key: def67c5e3ad0527b7a876fb3231d009b',
    'encargos: [{"tipoEncargo":"29","alto":"120","ancho":"15","largo":"150","kilos":"13"}]',
    'Content-Type: application/json',
    'Authorization: Bearer 25ed8eca-3fb3-4fd6-8a14-9b149ab56689'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "Consulta de cotización: <br> <pre>";
print_r($response);
echo " </pre>";




// CONSULTA TIPO DE ENTREGA

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiprod.starkenpro.cl/emision/tipo-entrega',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'api-key: def67c5e3ad0527b7a876fb3231d009b',
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MzkxMzU1LCJuYW1lIjoicmVzcGFsZG9zIGNoaWxlIHNwYSIsInJ1biI6Ijc3MTg2MDMxMSIsIm1hc3Rlcl9pZCI6bnVsbCwiYXBwbGljYXRpb24iOnsiaWQiOjIsIm5hbWUiOiJTdGFya2VuIFBybyIsImNvZGUiOiJQUk8ifSwicm9sZSI6eyJpZCI6MSwiY29kZSI6IlVTRVIiLCJuYW1lIjoiVVNVQVJJTyJ9LCJpYXQiOjE2ODEyMTk0MDEsImV4cCI6MTY4MTIzMDIwMX0.xHAL21ELK7O7hOQ7JNWwvvnq8auJVRi-p1IWhmUEdII'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "Consulta de tipo de entrega: <br> <pre>";
print_r($response);
echo " </pre>";




$curl = curl_init();
$calle = 'callenueva3706';
$ciudad = 'santiago';
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://geocode.search.hereapi.com/v1/geocode?maxresults=4&apiKey=97eELw7yGj5u1ZbVF3Xqw0INRBVVEVZqO_8x3dFSipY&qq=country=Chile;city='.$ciudad.';street='.$calle.'&api-key=97eELw7yGj5u1ZbVF3Xqw0INRBVVEVZqO_8x3dFSipY',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS => array('entrega' => 'Agencia','tipoServicio' => 'NORMAL','codigoAgenciaDestino' => '1763','codigoAgenciaOrigen' => '281','rutCliente' => '','codigoTipoPago' => '1','codigoCiudadOrigen' => '1','codigoCiudadDestino' => '1','rutDestinatario' => ''),
  CURLOPT_HTTPHEADER => array(
    'api-key: def67c5e3ad0527b7a876fb3231d009b'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "Consulta de tipo de entrega: <br> <pre>";
print_r($response);
echo " </pre>";

?>

</div>
</body>
</html>