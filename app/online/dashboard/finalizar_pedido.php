<?php require_once "vistas/parte_superior.php"?>


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

$consulta = "SELECT *,pv.id_categoria FROM pedido p INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden LEFT JOIN clientes c ON p.rut_cliente = c.rut LEFT JOIN productos_venta pv ON d.modelo = pv.modelo
WHERE p.num_orden = $num_orden";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);

$conexion->exec("set names utf8");


$consulta2 = "SELECT *,pv.id_categoria FROM pedido p INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden LEFT JOIN clientes c ON p.rut_cliente = c.rut LEFT JOIN productos_venta pv ON d.modelo = pv.modelo 
WHERE p.num_orden = $num_orden";
$resultado = $conexion->prepare($consulta2);
$resultado->execute();
$data2=$resultado->fetchAll(PDO::FETCH_ASSOC);

foreach($data2 as $dat){
   $nombre = $dat['nombre'];

    $telefono = $dat['telefono'];
    $fecha_ingreso = $dat['fecha_ingreso'];
    $num_pedido = $dat['num_orden'];
}
?>




<?php 
$contenidoDiv = '
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle del Pedido</title>
  <style>
    body {
      font-family: Calibri;
      background-color: #f7f7f7;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .logo-container {
      text-align: center;
      margin-bottom: 20px;
    }
    .logo-img {
      max-width: 150px;
    }
    h1 {
      color: #E50000;
    }
    p {
      margin-bottom: 10px;
    }
    .details-box {
      background: #e7f4ff;
      border: 1px solid #a3c2da;
      border-radius: 2px;
      font-size: 13pt;
      line-height: 190%;
      margin: 0 0 10px;
      padding: 10px;
      text-align: justify;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      text-align: left;
      padding: 8px;
      border-bottom: 1px solid #ddd;
    }
    tfoot td {
      text-align: right;
    }
    .payment-method {
      display: flex;
      flex-direction: column;
      margin-top: 20px;
      padding: 10px;
      background-color: #f2f2f2;
    }
    .contact-info {
      margin-top: 20px;
      padding: 10px;
      background-color: #f2f2f2;
    }
    .footer {
      text-align: center;
      margin-top: 15px;
      font-size: 12px;
    }
  </style>
</head>
<body style="padding:7px; ">
  <div class="container" style="max-width: 600px;      margin: 0 auto;      padding: 20px;      background-color: #fff;      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <div class="logo-container">
      <img class="logo-img" src="http://www.respaldoschile.cl/intranet/dashboard/img/logor.png" alt="Logo de la empresa">
    </div>
    <h1 style="color: #E50000;">Detalle del Pedido</h1>
    <p>Estimado cliente,</p>
    <p>Gracias por comprar en RespaldosChile. A continuación, le presentamos los detalles de su pedido:</p>
    <div class="details-box" style="background: #e7f4ff;
      border: 1px solid #a3c2da;
      border-radius: 2px;
      font-size: 12pt;
      line-height: 190%;
      margin: 0 0 10px;
      padding: 10px;
      text-align: justify;">
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
$abono = 0;
$tamano_ant_text= "";
foreach ($data as $dat) {
    $anclaje = "";
    if ($dat['anclaje'] != "" && $dat['anclaje'] != "no") {
        if($dat['anclaje'] == "patas"){
            $anclaje = " Anclaje:  Patas de madera.";
        }
         if($dat['anclaje'] == "si"){
            $anclaje = " Anclaje:  Madera interior anclaje.";
        }
       
    }

    $tamano_text = "";
    $altura_base = "";
    $tipo_boton = "";
    if (strpos($dat['modelo'], "Sofa") !== false) {
        $tamano_text = "Cuerpos";
    } else {

        $tamano_text = "Plazas";
        if (strpos($dat['modelo'], "Base") !== false) {
            $altura_base = " Largo " . htmlspecialchars($dat['alturabase']);
        } else {
            $altura_base = " Base: " . htmlspecialchars($dat['alturabase']);
        }
    }


if($dat['id_categoria'] == 1 or $dat['id_categoria'] ==  2){
$tamano_text = "Plazas";

if($dat['tamano'] ==  "1 1/2" or $dat['tamano'] == "King" or $dat['tamano'] ==  "Queen" or $dat['tamano'] ==  "Super King")
{
$tamano_text = "";
$tamano_ant_text= "Tamaño: ";
}
if($dat['tamano'] ==  "1"){
$tamano_text = "Plaza";
}



}


if($dat['id_categoria'] == 3 or $dat['id_categoria'] ==  4 or $dat['id_categoria'] ==  5 or $dat['id_categoria'] == 6){
$tamano_text = "";
$tamano_ant_text= "Tamaño: ";

}
$nota = "";
if($dat['detalles_fabricacion'] != ""){
    $nota = "<b>Nota: </b>";
}

if($dat['tipo_boton'] == "B D"){
    $tipo_boton = "Boton Diamante";
}
if($dat['tipo_boton'] == "colores"){
    $tipo_boton = "Boton de colores";
}



    $contenidoDiv .= '<tr>
          <td>
            <span style="font-weight: bold;">' . htmlspecialchars($dat['modelo']) . ' ' . $tamano_ant_text . htmlspecialchars($dat['tamano']) . ' ' . $tamano_text . ' ' . $tipo_boton . '</span><br>
            <span style="font-size: 12px; color: #666; margin-bottom:0;">' . ucfirst(htmlspecialchars($dat['tipotela'])) . ' ' . htmlspecialchars($dat['color']) . $altura_base . $anclaje . '</span><br >
             <span style="font-size: 10px; padding-top:0; margin-top:0; color: #666;">'.$nota .' ' . ucfirst(htmlspecialchars($dat['detalles_fabricacion'])) . ' </span>
          </td>
          <td style="text-align:center;">' . htmlspecialchars($dat['cantidad']) . '</td>
          <td style="text-align: right;">$' . htmlspecialchars($dat['precio']) . '</td>
        </tr>';

    $direccion = htmlspecialchars($dat['direccion']) . ' ' . htmlspecialchars($dat['numero']) . ' ' . htmlspecialchars($dat['dpto']) . ', ' . htmlspecialchars($dat['comuna']);
    $total += $dat['precio'];
    $abono += $dat['abono']; 
    $envio = 5000;
}

$contenidoDiv .= '</tbody>
      <tfoot>

    

        <tr>
          <th colspan="2" style="text-align: right;      padding: 8px;     background-color:#F2F2F2;">Subtotal</th>
          <td style="text-align: right;">$' . htmlspecialchars($total) . '</td>
             
        </tr>
          <tr>
<th colspan="2" style="text-align: right;      padding: 8px;     background-color:#F2F2F2;">Envío</th>
          <td style="text-align: right;">$' . htmlspecialchars($envio) . '</td>
        </tr>
        <tr>
<th colspan="2" style="text-align: right;      padding: 8px;     background-color:#F2F2F2;">Abono</th>
          <td style="text-align: right;">$' . htmlspecialchars($abono) . '</td>
        </tr>
         <tr>
<th colspan="2" style="text-align: right;      padding: 8px;     background-color:#F2F2F2;">Por Pagar</th>
          <td style="text-align: right;">$' . htmlspecialchars($total+$envio-$abono) . '</td>
        </tr>


      </tfoot>
    </table>
    <div class="payment-method">
      <p style="width:100%;"><strong>Método de Pago:</strong> Tarjeta de Crédito</p>
      <p><strong>Dirección de despacho:</strong> ' . $direccion . '</p>
    </div>
    <div class="contact-info">
      <p>Agradecemos su preferencia y estamos a su disposición para cualquier consulta o asistencia adicional. Si desea realizar consultas sobre su pedido, no dude en contactarnos mediante los siguientes canales de comunicación:</p>
      <p>Teléfono: +56979941253</p>
      <p>Correo Electrónico: contacto@respaldoschile.cl</p>
    </div>
    <p class="footer">Respaldos Chile ' . date('Y') . '</p>
  </div>
</body>
</html>';

$mensaje = $contenidoDiv;



echo $mensaje;

$dataEmailOrden = array('asunto' => "Notificación de compra nº ".$num_pedido,
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
     $de .= "Content-type: text/html; charset=UTF-8; boundary=boundary_" . uniqid() . "\r\n";

        $de .= "From: {$empresa} <{$remitente}>\r\n";
        //$de .= "Bcc: $emailCopia\r\n";
        ob_start();

       
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
<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"?>