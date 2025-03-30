<?php


$curl = curl_init();

 curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiprogram.bci.cl/sandbox/v1/api-oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            
             CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-
form-urlencoded'
            ),
            CURLOPT_POSTFIELDS => 'x-apikey => ZF6X1mAQEMLSGVAHCS7qZ1vIsfLeATU5',
            'grant_type => authorization_code',
'redirect_uri => ','client_id =>  ','code => ','scope =>  ','client_assertion_type => urn:ietf:params:oauth:client-assertion-type:jwt-bearer'));

 $response = curl_exec($curl);

      






var_dump($response);
curl_close($curl);
?>

