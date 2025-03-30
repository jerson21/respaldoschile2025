<?php // require_once "vistas/parte_superior.php"?>

<!-- INICIO del cont principal-->
<div class="container" style=" max-width: 400rem; width: 200rem; ">
    <h1>Finalizar Pedido</h1>
    

    
 <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'Libraries/phpmailer/Exception.php';
    require 'Libraries/phpmailer/PHPMailer.php';
    require 'Libraries/phpmailer/SMTP.php';


include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
$num_orden = $_GET['id'];

$consulta = "SELECT * FROM pedidos p
WHERE p.num_orden = $num_orden";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);

$conexion->exec("set names utf8");


$consulta2 = "SELECT * FROM pedidos p
WHERE p.num_orden = $num_orden";
$resultado = $conexion->prepare($consulta2);
$resultado->execute();
$data2=$resultado->fetchAll(PDO::FETCH_ASSOC);

foreach($data2 as $dat){
   // $nombre = $dat['nombre'];
  $nombre = "";
    $telefono = $dat['telefono'];
    $fecha_ingreso = $dat['fecha_ingreso'];
    $num_pedido = $dat['num_orden'];
}
?>

</div>     



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle del Pedido</title>

</head>
<body>

<style>
  body {
      font-family:Calibri;

    background-color: #f7f7f7;

  }
  .containere {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

  }
  h1 {
    color: #E50000;
  }
  p {
    margin-bottom: 10px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;

  }
  th,
  td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  th {
    background-color: #f2f2f2;
  }
  .message {
    margin-top: 20px;
    padding: 10px;
    background-color: #f2f2f2;

  }
  .product-details {
    font-size: 12px;
    color: #666;
  }
  .details-column {
    display: flex;
    flex-direction: column;
  }
  .details-column p {
    margin: 0;
  }
  .logo-container {
    text-align: center;
    margin-bottom: 20px;
  }
  .logo-img {
    max-width: 150px;
  }
</style>
</head>
<body>

  <!--  <div class="containere">
                  <div class="logo-container">
                  <img class="logo-img" src="img/logor.png" alt="Logo de la empresa">
                  </div>
                  <h1>Detalle del Pedido</h1>
                  <p>Estimado cliente,</p>


                  <p>Gracias por comprar en RespaldosChile. A continuación, le presentamos los detalles de su pedido:</p>
                   <div style="background:#e7f4ff;border:1px solid #a3c2da;border-radius:2px;font-size:13pt;line-height:190%;margin:0 0 10px;padding:10px;text-align:justify;">
                  <p style="margin: 0;"><strong>Número de Pedido:</strong> <?= $num_pedido ?></p>
                  <p style="margin: 0;"><strong>Fecha:</strong> <?= $fecha_ingreso ?></p>
                  <p style="margin: 0;"><strong>Cliente:</strong> <?= $nombre ?></p>
                  <p style="margin: 0;"><strong>Teléfono:</strong> <?= $telefono ?></p>
                </div>

                  <table>
                  <thead>
                  <tr>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Precio Unitario</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $total = 0;
                  foreach ($data as $dat) {
                  if($dat['anclaje']== "" or $dat['anclaje']== "no"){    $anclaje = "";   }
                  else{ $anclaje = "Anclaje :".$dat['anclaje'];}

                  if (strpos($dat['modelo'], "Sofa") !== false) {
                  $tamano_text = "Cuerpos";
                  $altura_base = "";
                  } else {
                  $tamano_text = "Plazas";
                  if (strpos($dat['modelo'], "Base") !== false) { $altura_base = " Largo ".$dat['alturabase']; }
                  else{
                  $altura_base = " Base: ".$dat['alturabase'];
                  }
                  

                  }




                  echo "<tr>
                  <td>
                  <span class='product-name'>".$dat['modelo']." ".$dat['plazas']." ".$tamano_text."</span><br>
                  <span class='product-details'>".ucfirst($dat['tipotela'])." ".$dat['color'].$altura_base."  ".$anclaje."</span>
                  </td>
                  <td>1</td>
                  <td>$".$dat['precio']."</td>
                  </tr>";

                  $direccion = $dat['direccion']." ".$dat['numero']." ".$dat['dpto'].", ".$dat['comuna'];
                  $total+= $dat['precio'];
                  }
                  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                  <th colspan="2">Total</th>
                  <td class="total-cell">$<?= $total ?></td>
                  </tr>
                  </tfoot>
                  </table>
                  <br>
                  <div class="details-column">
                  <p><strong>Método de Pago:</strong> Tarjeta de Crédito</p>
                  <p><strong>Dirección de despacho:</strong> <?php echo $direccion; ?></p>
                  </div>
                  <div class="message">
                  <p>Agradecemos su preferencia y estamos a su disposición para cualquier consulta o asistencia adicional. Si desea realizar consultas sobre su pedido, no dude en contactarnos mediante los siguientes canales de comunicación:</p>
                  <p>Teléfono: +56979941253</p>
                  <p>Correo Electrónico: contacto@respaldoschile.cl</p>
                  </div>
                  <?php $currentYear = date('Y'); ?>
                  <p style="text-align: center;margin-top:15px;font-size: 12px;">Respaldos Chile <?= $currentYear ?></p>
    </div>

 -->
<br>


<?php 

$contenidoDiv = '<div class="containere">
                  <div class="logo-container">
                  <img class="logo-img" src="img/logor.png" alt="Logo de la empresa">
                  </div>
                  <h1>Detalle del Pedido</h1>
                  <p>Estimado cliente,</p>


                  <p>Gracias por comprar en RespaldosChile. A continuación, le presentamos los detalles de su pedido:</p>
                   <div style="background:#e7f4ff;border:1px solid #a3c2da;border-radius:2px;font-size:13pt;line-height:190%;margin:0 0 10px;padding:10px;text-align:justify;">
                  <p style="margin: 0;"><strong>Número de Pedido:</strong> ' . htmlspecialchars($num_pedido) . '</p>
                  <p style="margin: 0;"><strong>Fecha:</strong> ' . htmlspecialchars($fecha_ingreso) . '</p>
                  <p style="margin: 0;"><strong>Cliente:</strong> ' . htmlspecialchars($nombre) . '</p>
                  <p style="margin: 0;"><strong>Teléfono:</strong> ' . htmlspecialchars($telefono) . '</p>
                </div>

                  <table>
                  <thead>
                  <tr>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Precio Unitario</th>
                  </tr>
                  </thead>
                  <tbody>';
$total = 0;
foreach ($data as $dat) {
    if ($dat['anclaje'] == "" or $dat['anclaje'] == "no") {
        $anclaje = "";
    } else {
        $anclaje = "Anclaje :" . htmlspecialchars($dat['anclaje']);
    }

    if (strpos($dat['modelo'], "Sofa") !== false) {
        $tamano_text = "Cuerpos";
        $altura_base = "";
    } else {
        $tamano_text = "Plazas";
        if (strpos($dat['modelo'], "Base") !== false) {
            $altura_base = " Largo " . htmlspecialchars($dat['alturabase']);
        } else {
            $altura_base = " Base: " . htmlspecialchars($dat['alturabase']);
        }
    }

    $contenidoDiv .= '<tr>
                  <td>
                  <span class="product-name">' . htmlspecialchars($dat['modelo']) . ' ' . htmlspecialchars($dat['plazas']) . ' ' . $tamano_text . '</span><br>
                  <span class="product-details">' . ucfirst(htmlspecialchars($dat['tipotela'])) . ' ' . htmlspecialchars($dat['color']) . $altura_base . '  ' . $anclaje . '</span>
                  </td>
                  <td>1</td>
                  <td>$' . htmlspecialchars($dat['precio']) . '</td>
                  </tr>';

    $direccion = htmlspecialchars($dat['direccion']) . ' ' . htmlspecialchars($dat['numero']) . ' ' . htmlspecialchars($dat['dpto']) . ', ' . htmlspecialchars($dat['comuna']);
    $total += $dat['precio'];
}

$contenidoDiv .= '</tbody>
                  <tfoot>
                  <tr>
                  <th colspan="2">Total</th>
                  <td class="total-cell">$' . htmlspecialchars($total) . '</td>
                  </tr>
                  </tfoot>
                  </table>
                  <br>
                  <div class="details-column">
                  <p><strong>Método de Pago:</strong> Tarjeta de Crédito</p>
                  <p><strong>Dirección de despacho:</strong> ' . $direccion . '</p>
                  </div>
                  <div class="message">
                  <p>Agradecemos su preferencia y estamos a su disposición para cualquier consulta o asistencia adicional. Si desea realizar consultas sobre su pedido, no dude en contactarnos mediante los siguientes canales de comunicación:</p>
                  <p>Teléfono: +56979941253</p>
                  <p>Correo Electrónico: contacto@respaldoschile.cl</p>
                  </div>
                  <?php $currentYear = date("Y"); ?>
                  <p style="text-align: center;margin-top:15px;font-size: 12px;">Respaldos Chile ' . $currentYear . '</p>
    </div>';

$mensaje = $contenidoDiv;

echo $mensaje;

$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$num_pedido,
                          'email' => "jerson.sg21@gmail.com", 
                          'emailCopia' => "contacto@respaldoschile.cl",
                          'pedido' => $num_pedido );

              sendEmail($dataEmailOrden,$mensaje);


// Envío de correos
function sendEmail($data, $mensaje)
{


    $ENVIRONMENT = 1;
    if ($ENVIRONMENT == 1) {
        $asunto = $data['asunto'];
        $emailDestino = $data['email'];
        $empresa = "Respaldos Chile";
        $remitente = "noreply@respaldoschile.cl";
        $emailCopia = "contacto@respaldoschile.cl";
        // ENVIO DE CORREO
        $de = "MIME-Version: 1.0\r\n";
        $de .= "Content-type: text/html; charset=UTF-8\r\n";
        $de .= "From: {$empresa} <{$remitente}>\r\n";
        $de .= "Bcc: $emailCopia\r\n";
        ob_start();

        ini_set("SMTP", "localhost");
ini_set("smtp_port", "25");
        $send = mail($emailDestino, $asunto, $mensaje, $de);
        return $send;
    } else {
        // Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        ob_start();
        require_once("Views/Template/Email/" . $template . ".php");
        $mensaje = ob_get_clean();

        try {
            // Configuración del servidor SMTP
            $mail->SMTPDebug = 1;                      // Habilitar la salida detallada de depuración
            $mail->isSMTP();                                            // Enviar utilizando SMTP
            $mail->Host       = 'mail.respaldoschile.cl';                     // Configurar el servidor SMTP
            $mail->SMTPAuth   = true;                                   // Habilitar la autenticación SMTP
            $mail->Username   = 'contacto@respaldoschile.cl';          // Nombre de usuario SMTP
            $mail->Password   = 'jerson21J';                               // Contraseña SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Habilitar el cifrado TLS implícito
            $mail->Port       = 465;                                    // Puerto TCP para conectar; usa 587 si has configurado `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Destinatarios
            $mail->setFrom('contacto@respaldoschile.cl', 'Servidor Local');
            $mail->addAddress($data['email']);     // Agregar un destinatario
            if (!empty($data['emailCopia'])) {
                $mail->addBCC($data['emailCopia']);
            }
            $mail->CharSet = 'UTF-8';
            // Contenido
            $mail->isHTML(true);                                  // Establecer el formato de correo electrónico en HTML
            $mail->Subject = $data['asunto'];
            $mail->Body    = $mensaje;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
        

        
    


              ?>




</body>
</html>
<?php require_once "vistas/parte_inferior.php"?>