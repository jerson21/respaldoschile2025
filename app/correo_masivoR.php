<?php
 use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
require 'Libraries/phpmailer/Exception.php';
    require 'Libraries/phpmailer/PHPMailer.php';
    require 'Libraries/phpmailer/SMTP.php';

   


// Crear una nueva instancia de PHPMailer
$mail = new PHPMailer(true);

// Configurar las credenciales de Google SMTP
  $mail->SMTPDebug = 1;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'contacto@respaldoschile.cl';          //SMTP username
                $mail->Password   = 'jhmifzugyhlyredw';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;     
                $mail->From = 'noreply@respaldoschile.cl';
                $mail->FromName = "Ventas";
                   $mail->isHTML(true); 
             $mail->CharSet = 'UTF-8';


// Configurar el remitente
$mail->setFrom('noreply@respaldoschile.cl', 'RespaldosChile');


// Configurar el asunto y el contenido del correo electrónico
$body = file_get_contents('correo/correo.html');

$mail->Subject = 'Nuevos productos en muebles y respaldos de cama🏠💫';


$mail->Body = $body;
$mail->AltBody = 'Descubre nuestros nuevos productos de muebles y respaldos';


         


// Iterar a través del array de destinatarios
$destinatarios = array('jerson.sg21@gmail.com');
foreach ($destinatarios as $destinatario) {
    // Agregar destinatario al correo electrónico
    $mail->addAddress($destinatario);
    
    // Enviar el correo electrónico
    if ($mail->send()) {
        echo 'El correo electrónico se envió correctamente a ' . $destinatario . '<br>';
    } else {
        echo 'Hubo un error al enviar el correo electrónico a ' . $destinatario . ': ' . $mail->ErrorInfo . '<br>';
    }
    
    // Limpiar el destinatario del correo electrónico
    $mail->ClearAddresses();

     // Borra las direcciones de correo electrónico
    $mail->ClearAllRecipients();
}

?>