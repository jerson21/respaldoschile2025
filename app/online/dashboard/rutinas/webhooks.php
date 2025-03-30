<?php


/*
 * VERIFICACION DEL WEBHOOK
*/
//TOQUEN QUE QUERRAMOS PONER 
$token = 'resp2023';
//RETO QUE RECIBIREMOS DE FACEBOOK
$palabraReto = $_GET['hub_challenge'];
//TOQUEN DE VERIFICACION QUE RECIBIREMOS DE FACEBOOK
$tokenVerificacion = $_GET['hub_verify_token'];
//SI EL TOKEN QUE GENERAMOS ES EL MISMO QUE NOS ENVIA FACEBOOK RETORNAMOS EL RETO PARA VALIDAR QUE SOMOS NOSOTROS
if ($token === $tokenVerificacion) {
    echo $palabraReto;
    exit;
}




$mensaje = "";
$texto_recibido = "";

/*
 * RECEPCION DE MENSAJES
 */
//LEEMOS LOS DATOS ENVIADOS POR WHATSAPP



$respuesta = file_get_contents("php://input");
//CONVERTIMOS EL JSON EN ARRAY DE PHP
$respuesta = json_decode($respuesta, true);
$telefono_recibido= $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['from'];
$texto_recibido= $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
//EXTRAEMOS EL TELEFONO DEL ARRAY
$mensaje="Telefono:".$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['from']."</br>";

//EXTRAEMOS EL MENSAJE DEL ARRAY
$mensaje.="Mensaje:".$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
//GUARDAMOS EL MENSAJE Y LA RESPUESTA EN EL ARCHIVO text.txt
file_put_contents("text.txt", $mensaje);



if($texto_recibido == "Jerson"){
  $enviado = "Hola Jerson";
}
elseif($texto_recibido == "Quiero Ayuda con mi pedido"){
  $enviado = "Hola Jerson";
}
elseif($texto_recibido == "Jerson"){
  $enviado = "Hola Jerson";
}else{
  $enviado = 'Hola👋 Bienvenido a Respaldos Chile! \n Como te podemos ayudar? \n Indicanos una opcion';
  $enviado.='\n 1-Consultar por mi pedido \n 2- Realizar Pago de mi Pedido \n 3- Comprar un Producto';
  }

  if($texto_recibido == 1){
    $enviado = "Me Puedes enviar tu rut o numero de pedido:";
  }

   if($texto_recibido == 1){
    $enviado = "Claro, Indicame tu rut o numero de pedido:";
  }










        //TOKEN QUE NOS DA FACEBOOK
        $token = 'EAAqFhQwbrOwBABGbrS1cFZAuzx8UsfFxW741YUZCOwlQZCzauI8It2aAFhnWz9fMnjIoXN42HMCZCJHRInjFfJ3qLq765WTfKPSpnZCRPBibrOsOq0tL5VZCncM7amVDnnOBvHhri7yajk5j3t2I8zRKNknIUlbdeCnA59VZBuVJzbbR0rNqgOX1ZCmtiZBs1ZB9GycIcZCuzLqLrSNq3z6le38';
        //NUESTRO TELEFONO
        
        //IDENTIFICADOR DE NÚMERO DE TELÉFONO
        $telefonoID = '115436424863277';
        //URL A DONDE SE MANDARA EL MENSAJE
        $url = 'https://graph.facebook.com/v15.0/' . $telefonoID . '/messages';
        //CONFIGURACION DEL MENSAJE
        $mensaje = ''
                . '{'
                . '"messaging_product": "whatsapp", '
                . '"recipient_type": "individual",'
                . '"to": "' . $telefono_recibido . '", '
                . '"type": "text", '
                . '"text": '
                . '{'
                . '     "body":"' . $enviado . '",'
                . '     "preview_url": true, '
                . '} '
                . '}';
        //DECLARAMOS LAS CABECERAS
        $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
        //INICIAMOS EL CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
        $response = json_decode(curl_exec($curl), true);
        //OBTENEMOS EL CODIGO DE LA RESPUESTA
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //CERRAMOS EL CURL
        curl_close($curl);

        ?>
