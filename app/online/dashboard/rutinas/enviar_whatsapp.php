<?php

error_reporting(0);

$num_orden = $_POST['num_orden'];

include "../bd/conexion.php";
$objeto1 = new Conexion();
$conexion = $objeto1->Conectar();


$consulta = $conexion->prepare("SELECT * FROM pedido_detalle p INNER JOIN rutas r on p.ruta_asignada = r.id WHERE num_orden = :num_orden order by modelo");
        $consulta->bindParam(":num_orden", $num_orden, PDO::PARAM_INT);
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $pedido = "";
         $total_pagar = 0;
          $ordenes_array = array();
        foreach($datos as $filas){

            $rut = $filas['rut_cliente'];
            $pedido.= '-'.$filas['modelo'].' '.$filas['tamano'].' '.$filas['tipotela'].' '.$filas['color'].' '.$filas['alturabase'].'\n';
            $total_pagar +=$filas['precio'];
            $ordenes_array[]=$num_orden;
            $direccion = $filas['direccion'].' '.$filas['numero'].'\nDpto/Casa : '.$filas['dpto'].'\nComuna : '.$filas['comuna'];
            $ordenes_array[$num_orden][1];
            $fecha = $filas['fecha'];

        }
        


$consulta = $conexion->prepare("SELECT * FROM clientes WHERE rut = :rut");
        $consulta->bindParam(":rut", $rut, PDO::PARAM_INT);
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        foreach($datos as $rss){
             $nombre = $rss['nombre'];
        }
//{$row['telefono']


$mensaje_whatsapp = "https://api.whatsapp.com/send/?phone=+56956344617&text=Hola {$nombre}👋!%0A%0A Le informamos que su pedido%0A{$pedido}%0A%0A Será entregado este *{$fecha_ruta}*, por RespaldosChile%0ADireccion de Entrega: {$row['direccion']} {$row['numero']} %0ADpto/Casa : {$row['dpto']} %0AComuna: {$row['comuna']} %0ATotal a pagar: $ {$total_pagar} (Si esta pagado omitir esto) %0A%0A*Por favor ingresar en el siguiente link y confirmarnos que puede recibir*👉 %0Ahttps://respaldoschile.cl/cliente_confirma_numorden.php?pedido={$numero_de_orden}%0A%0ASi no le aparece el link debe agregar este numero a sus contactos.%0A*Importante: El producto debe estar pagado para que nuestro despachador se retire del domicilio.*%0A%0A*El horario de entrega se informara mediante un sms al momento de salir a reparto.*";


$enlace = $mensaje_whatsapp;
header("Location: $enlace");
exit;
?>


/*




$resultados = $mysqli->query("SELECT * FROM pedidos WHERE num_orden = $numero_de_orden order by modelo");
$ordenes_array = array();
foreach($filas = $resultados->fetch_assoc()){
$pedido.= '-'.$filas['modelo'].' '.$filas['plazas'].' '.$filas['tipotela'].' '.$filas['color'].' '.$filas['alturabase'].'\n';
$total_pagar +=$filas['precio'];
$ordenes_array[]=$numero_de_orden;
$ordenes_array[$numero_de_orden][1];

}
$nombre = utf8_encode($fila['nombre']);

$fecha_ruta = utf8_encode($fecha_ruta);
*/
/*





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
                        'text' => "$nombre"
                    ),
                    array(
                        "type" => "text",
                        'text' => "$pedido"
                    ),
                     array(
                        "type" => "text",
                        'text' =>  "$fecha"
                    ),
                      array(
                        "type" => "text",
                        'text' => "$direccion"
                    ),
                    array(
                        "type" => "text",
                        'text' => "$$total_pagar"
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
            'text' => "$num_orden"
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
$access_token = 'EAAqFhQwbrOwBAPjNl7ib7kZA1QbaGrNfRivDYTgjdYLoN0bbEutMpeGbPZAAcygOMU6yUFTToaR6dcxa8gkw1WrXyXoP0HNr1nwld6ZAvE7JuuiQgYvtFZASC2cKGGnkyBFe4tlqWeG5pdxgAGAsYUfrKFUv55GTyKZAYsu1x1Hknyg6vlCZACa2YRkF88UKiVgvaklmV4vhiBJbIh7ewh';

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
 */

?>
