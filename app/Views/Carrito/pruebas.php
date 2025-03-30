<?php
  /* FUNCION QUE OBTIENE DE TRANSBANK SEGUN LOS DATOS AGREGADOS EN PARAMETROS */
                                                function get_ws($data,$method,$type,$endpoint){
                                                $curl = curl_init();
                                               
                                                    /* AMBIENTE DE PRODUCCION */

                                                    $TbkApiKeyId='597045358953';
                                                    $TbkApiKeySecret='4db548a2-9ceb-4da1-8acb-750dce0435ec';
                                                     $url="https://webpay3g.transbank.cl".$endpoint;//Live
                                                     /* AMBIENTE DE INTEGRACIÓN 
                                                     $TbkApiKeyId='597055555532';
                                                     $TbkApiKeySecret='579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';
                                                         $url="https://webpay3gint.transbank.cl/".$endpoint;*/

                                                    
                                                
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
                                                    'Tbk-Api-Key-Id: '.$TbkApiKeyId.'',
                                                    'Tbk-Api-Key-Secret: '.$TbkApiKeySecret.'',
                                                    'Content-Type: application/json'
                                                  ),
                                                ));
                                                
                                                $response = curl_exec($curl);
                                                
                                                curl_close($curl);
                                                //echo $response;
                                                return json_decode($response);
                                            }



$baseurl = "https://" . $_SERVER['HTTP_HOST'] . "/tienda2/carrito/metododepago";
$url="https://webpay3g.transbank.cl/";//Live
//$url="https://webpay3gint.transbank.cl/";//Testing

/* ACTION INIT SE REFIERE A MODO PRODUCCION O TRANSACCION ABIERTO */
$action = 'getResult';
$message=null;
$post_array = false;

switch ($action) {

case "getResult":
        
        if (!isset($_GET["token_ws"]))
            break;

        /** Token de la transacción */
        $token = filter_input(INPUT_GET, 'token_ws');
        
        $request = array(
            "token" => filter_input(INPUT_GET, 'token_ws')
        );
        
        $data='';
		$method='GET';
		$type='sandbox';
		$endpoint='/rswebpaytransaction/api/webpay/v1.0/transactions/'.$token;
		
        $response = get_ws($data,$method,$type,$endpoint);
       
        $message.= "<pre>";
       echo   $message.= print_r($response,TRUE);
        $message.= "</pre>";
        
        $url_tbk = $baseurl."?action=refund";
        $submit='Refund!';
        break;

	 }
?>