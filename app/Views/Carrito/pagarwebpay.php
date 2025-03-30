<?php
headerTienda($data);

$subtotal = 0;
$total = 0;
$costoenvio = 0;
$descuento = 0;
foreach ($_SESSION['arrCarrito'] as $producto) {
  $subtotal += $producto['precio'] * $producto['cantidad'];
}

foreach ($_SESSION['precio_envio'] as $producto) {
  $costoenvio = $producto['precio'];
}

if (!empty($_SESSION['descuento'])) {
  $descuento = $_SESSION['descuento'];

}



$tituloTerminos = !empty(getInfoPage(PTERMINOS)) ? getInfoPage(PTERMINOS)['titulo'] : "";
$infoTerminos = !empty(getInfoPage(PTERMINOS)) ? getInfoPage(PTERMINOS)['contenido'] : "";



$catFotter = getCatFooter();

/* FUNCION QUE OBTIENE DE TRANSBANK SEGUN LOS DATOS AGREGADOS EN PARAMETROS */
function get_ws($data, $method, $type, $endpoint)
{
  $curl = curl_init();

  /* AMBIENTE DE PRODUCCION */

   $TbkApiKeyId = '597045358953';
  $TbkApiKeySecret = '4db548a2-9ceb-4da1-8acb-750dce0435ec';
  $url = "https://webpay3g.transbank.cl" . $endpoint;//Live
 /*
// AMBIENTE DE INTEGRACIÓN 
  $TbkApiKeyId='597055555532';
  $TbkApiKeySecret='579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';
  $url="https://webpay3gint.transbank.cl/".$endpoint; */



  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => $method,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array(
      'Tbk-Api-Key-Id: ' . $TbkApiKeyId . '',
      'Tbk-Api-Key-Secret: ' . $TbkApiKeySecret . '',
      'Content-Type: application/json'
    ),
  )
  );

  $response = curl_exec($curl);

  curl_close($curl);
  //echo $response;
  return json_decode($response);
}



$baseurl = "https://" . $_SERVER['HTTP_HOST'] . "/carrito/metododepago";
$url = "https://webpay3g.transbank.cl/";//Live
//$url="https://webpay3gint.transbank.cl/";//Testing

/* ACTION INIT SE REFIERE A MODO PRODUCCIÓN O TRANSACCION ABIERTO */
$action = 'init';
$message = null;
$post_array = false;

switch ($action) {

  case "init":
    $message .= 'init';
    $buy_order = rand();
    $session_id = rand();
    $amount = $subtotal + $costoenvio - $descuento;
    $return_url = $baseurl . "?action=getResult";
    $type = "sandbox";
    // Se están definiendo los datos que se enviarán en la solicitud POST.
// Estos incluyen el ID de la sesión, la cantidad a pagar y la URL a la que se debe redirigir después de la transacción.
    $data = '{
                    "buy_order": "' . $buy_order . '",
                    "session_id": "' . $session_id . '",
                    "amount": ' . $amount . ',
                    "return_url": "' . $return_url . '"
                    }';
    $method = 'POST';
    $endpoint = '/rswebpaytransaction/api/webpay/v1.0/transactions';

    $response = get_ws($data, $method, $type, $endpoint);
    $message .= "<pre>";
    $message .= print_r($response, TRUE);
    $message .= "</pre>";
    $url_tbk = $response->url;
    $token = $response->token;
    $submit = 'Procesar Pago';


    break;


}

?>

<form name="brouterForm" id="brouterForm" method="POST" action="<?= $url_tbk ?>" style="display:block;">
  <input type="hidden" name="token_ws" value="<?= $token ?>" />
  <input type="submit" value="<?= (($submit) ? $submit : 'Cargando...') ?>"
    class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
    style="background-color: #6b196b;" />
</form>


<script type="text/javascript">
  formulario = document.brouterForm;
  formulario.submit();</script>