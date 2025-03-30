<?php
headerTienda($data);

function extract_id($input) {
  // Usa una expresión regular para obtener el número antes del guion
  if (preg_match('/^\d+/', $input, $matches)) {
      return $matches[0];
  }
  return null;  // Retorna null si no se encuentra un número válido
}

$id_obt_gets = $_GET['r'] ?? $_GET['id'] ?? '';

if (!empty($id_obt_gets)) {
  $clean_id = extract_id($id_obt_gets);
  if ($clean_id !== null) {
      $id_obt_get = $clean_id;
  } else {
  }
} else {
}


?>
<!-- Carga de hojas de estilo y scripts necesarios -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Asegúrate de incluir jQuery -->
<style>

.containeras { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background: #f9f9f9;     display: none;  // Asegura que este estilo tenga prioridad
/* Inicialmente oculto */
}
.visible {
  display: block; /* Hace el contenedor visible */
}
.hidden {
display: none !important;  // Asegura que este estilo tenga prioridad

}
.section { padding: 10px 0; }
.section:not(:last-child) { border-bottom: 1px solid #ddd; }
.title { font-size: 16px; font-weight: bold; }
.info { margin: 5px 0; }
.link { color: #007BFF; text-decoration: none; }
.link:hover { text-decoration: underline; }

.info i {
margin-right: 10px; /* Espacio entre el ícono y el texto */
}

.text-primary {
color: #007bff;
}

.text-success {
color: #28a745;
}

.text-info {
color: #17a2b8;
}

.text-warninga {
color: #d39e00;
}

.text-danger {
color: #dc3545;
}

.text-secondary {
color: #6c757d;
}
.info i {
background-color: ;/* Hacer los íconos un poco más grandes para mejor visibilidad */
}

</style>

<style>
  .styled-table {
    width: 100%;
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    border: 1px solid #ddd; /* Color de los bordes */

  }

  .styled-table thead tr {
    background-color: #BD0000;
    color: #ffffff;
    text-align: left;
  }

  .styled-table th,
  .styled-table td {
    padding: 12px 15px;
    
  }

  .styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
  }

  .styled-table tbody tr:nth-of-type(even) {
    background-color: #F1F1F1;
  }

  .styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #393939;
  }

  .styled-table tbody tr.active-row {
    font-weight: bold;
    color: #009879;
  }




  .banner-content {
    background: #F5F5F5;
    padding: 20px;
    border-radius: 8px;
    margin: 0 auto;
    text-align: center;
  }

  .banner-content p {
    font-size: 18px;
    margin: 0 0 15px;
    color: #585858;
  }

  .banner-content strong {
    color: #C80202;
    /* Un color dorado para destacar la fecha */
  }

  .confirm-button {
    padding: 10px 20px;
    background-color: #C80202;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    transition: background-color 0.3s ease;
  }

  .confirm-button:hover {
    background-color: #C80202;
  }

  .table-container {
    overflow-x: auto;
    margin-top: 20px;
  }

  .info-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    /* Permite que los items se ajusten debajo uno del otro cuando no haya espacio */
    gap: 5px;
    /* Espacio entre los divs */
  }

  .client-info,
  .order-info {
    flex: 1;
    /* Esto hará que ambos divs tengan la misma anchura y ocupen el espacio disponible */
    min-width: 280px;
    /* Establece un mínimo de anchura para cuando la pantalla es muy pequeña */
    margin: 5px;
    /* Espacio alrededor de los divs para asegurar que no estén pegados */
    padding: 20px;
    background: #F6F6F6;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: relative;
  }

  @media (max-width: 768px) {
    .info-container {
      flex-direction: column;
      /* Alinea los divs en columna cuando la pantalla es menor a 768px */
    }

 


    .client-info,
    .order-info {
      width: 100%;
      /* Hace que cada div ocupe el ancho completo en pantallas pequeñas */
    }
  }

  .client-info::before,
  .order-info::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border: 1px solid #CCCCCC;
    /* Color de la línea interior */
    border-radius: 8px;
    /* Ajustado para no sobresalir del border-radius principal */
    pointer-events: none;
    /* Para que no interfiera con el contenido */
  }

  .client-info-content,
  .order-info-content {
    padding: 15px;
    /* Padding interno para el contenido */
    background: #F6F6F6;
    border-radius: 6px;
    /* Ajustado para no sobresalir del pseudo-elemento */
    position: relative;
    /* Necesario para el contenido */
  }

  .client-info p,
  .order-info p {
    display: flex;
    align-items: center;
    font-size: 16px;
    color: #333;
    margin: 10px 0;
    font-weight: 400;
  }

  .client-info p i,
  .order-info p i {
    margin-right: 10px;
    color: #007bff;
  }

  .client-info p strong,
  .order-info p strong {
    margin-right: 10px;
    /* Espacio adicional entre el nombre del campo y el resultado */
  }

  .client-info h2 {
    margin-top: 0;
    text-align: center;
    color: black;
  }

  .client-info p {
    display: flex;
    align-items: center;
    font-size: 16px;
    margin: 10px 0;
    font-weight: 400;
  }

  .client-info p i {
    margin-right: 10px;
    color: #C0280C;
    ;
  }

  .client-info p strong {
    margin-right: 10px;
    /* Espacio adicional entre el nombre del campo y el resultado */
  }

  h1 {
    color: #333;
    text-align: center;
  }

  .payment-actions {
    text-align: center;
    /* Centra los contenidos del div */
    padding-top: 20px;
  }



  .payment-table {
  width: 100%;
  border-collapse: collapse;
  margin: 0 auto 10px;
  font-size: 0.8em;
  overflow-x: auto; /* Hacer la tabla desplazable horizontalmente */
}

  .payment-table th,
  .payment-table td {
    border: 1px solid #ccc;
    padding: 5px;
    /* Reducir el padding para hacer cada celda más compacta */
    text-align: left;
    background-color: #f9f9f9;
    white-space: nowrap; /* Evitar que el texto haga salto de línea */

  }

  .payment-table th {
    background-color: #f0f0f0;
  }

  .pagar-button {
    padding: 10px 20px;
    background-color: #C80202;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    transition: background-color 0.3s ease;
    margin-top: 10px;
    /* Espacio entre la lista y el botón */
    width: 150px;
    /* Ancho del botón ajustado para que no ocupe todo el espacio */
    margin-left: auto;
    /* Junto con margin-right auto para centrar */
    margin-right: auto;
    white-space: nowrap;
    
  }



  .pagar-button:hover {
    background-color: #C80202;
  }

  .bank-selection img {
    border: solid 1px;
    border-radius: 5px;
    border-color: #dddddd;
    padding: 5px;
    width: 120px;
    /* o el tamaño que prefieras */

    height: 70px;
    /* Altura fija para todos los logos */
    object-fit: contain;
    /* Mantiene las proporciones de la imagen sin recortarla */

    margin: 5px;
    cursor: pointer;
    transition: transform 0.3s ease;
  }

  .bank-selection img:hover {
    transform: scale(1.1);
    /* Efecto de zoom al pasar el mouse */
  }

  .delivery-info {
    background: #f8f8f8;
    /* Un fondo ligeramente diferente para destacar el área */
    border: 1px solid #ccc;
    /* Un borde sutil */
    border-radius: 8px;
    padding: 20px;
    /* Espacio interno para no saturar el texto */
    margin-top: 20px;
    /* Espacio arriba para separar de los otros div */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    /* Sombra suave para dar profundidad */
    text-align: left;
    /* Alineación de texto */
  }

  .delivery-info h2 {
    color: #C80202;
    /* Un color destacado para el título, similar al del botón pagar */
  }

  .delivery-info p {
    font-size: 16px;
    /* Tamaño de fuente adecuado para la lectura */
    color: #333;
    /* Color de texto oscuro para contraste */
    line-height: 1.5;
    /* Espacio entre líneas para mejorar legibilidad */
  }

  .custom-select {
    width: 100%;
    /* Asegura que el select ocupe todo el espacio disponible */
    padding: 8px 16px;
    /* Padding para hacer el select más grande y fácil de interactuar */
    border: 1px solid #ccc;
    /* Borde sutil */
    border-radius: 5px;
    /* Bordes redondeados */
    background-color: white;
    /* Fondo blanco */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    /* Sombra suave */
    font-size: 16px;
    /* Tamaño de fuente legible */
  }

  .custom-select:focus {
    border-color: #C80202;
    /* Cambia el color del borde al enfocar */
    outline: none;
    /* Elimina el contorno por defecto */
    box-shadow: 0 0 0 2px rgba(200, 2, 2, 0.2);
    /* Sombra exterior para resaltar el foco */
  }

  .bank-selection button.banks-button {

    display: inline-block;
    background: #fff;
    /* Fondo blanco para el botón */
    border: 1px solid #ccc;
    /* Borde como los logos */
    border-radius: 5px;
    /* Bordes redondeados */
    padding: 8px 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 10px;
    font-size: 16px;
    /* Tamaño de fuente adecuado */
    width: calc(42% - 22px);
    /* Ancho completo ajustado por padding y margin */
    text-align: center;
  }

  .bank-selection button.bank-button:hover {
    background-color: #f1f1f1;
    /* Cambio de color al pasar el ratón */
  }

  .bank-list {
    z-index: 9999 !important;  /* Asegura que esté por encima de cualquier otro contenido */

    display: flex;
    flex-direction: column;
    width: 100%;
    /* Asegura que ocupe todo el espacio disponible */
    margin: 0;
    /* Elimina cualquier margen exterior */
    padding: 0;
    /* Elimina cualquier padding exterior */
    list-style: none;
    /* Elimina los estilos de lista por defecto */
    border-top: 1px solid #ccc;
    /* Añade un borde superior para definir el inicio */
  }

  .bank-list button {
    padding: 12px 20px;
    /* Aumenta el padding para mejor tocabilidad */
    text-align: left;
    /* Alinea el texto a la izquierda */
    font-size: 16px;
    /* Asegura un tamaño de fuente legible */
    color: #333;
    /* Usa un color oscuro para mejor contraste */
    background-color: #fff;
    /* Fondo blanco para cada elemento */
    border: none;
    /* Elimina bordes */
    border-bottom: 1px solid #ccc;
    /* Añade un borde entre elementos */
    width: 100%;
    /* Asegura que el botón ocupe todo el ancho disponible */
    cursor: pointer;
    /* Indica que es un elemento interactivo */
    transition: background-color 0.3s;
    /* Suaviza la transición de color al interactuar */
  }

  .bank-list button:hover {
    background-color: #e9e9e9;
    color: #333;
  }

  .bank-list button:last-child {
    border-bottom: none;
    /* Elimina el borde del último elemento */
  }

  .transaction-confirmation {
    font-size: 14px;
    color: #585858;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px 20px;
    text-align: center;
    margin-top: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .transaction-confirmation .fa-check-circle {
    color: #28a745;
    /* Verde para indicar éxito o confirmación */
    margin-right: 5px;
    font-size: 16px;
  }

  .swal2-popup {
    /* Ajusta según sea necesario para alinear mejor el contenido */
    max-width: 500px;
    /* O el ancho que prefieras */
  }

  .swal2-input {
    display: block;
    width: 80%;
    /* Ajusta el ancho del input */
    margin: 20px auto;
    /* Centra el input horizontalmente y añade espacio vertical */
    padding: 10px;
    font-size: 16px;
    /* Tamaño de fuente adecuado */
  }

  .custom-swal-popup {
    max-width: 90% !important;
    /* Ajusta el ancho máximo para pantallas pequeñas */
    /*  width: auto !important; */
    /* Ajusta el ancho automático */
  }

  .bank-details-container {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .bank-logo-container {
    margin-bottom: 20px;

  }

  .custom-swal-popup {
    max-width: 90%;
    /* Ajusta este valor según sea necesario */
  }

  .custom-confirm-button {
    background-color: #C80202 !important;
    color: #fff !important;
  }

  .custom-cancel-button {
    background-color: #ccc !important;
    colo
    
    r: #333 !important;
  }
  .payment-method-selection {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
}

.payment-method-selection button {
    margin-bottom: 10px;
}

.bank-button, .webpay-button {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%; /* Ajusta el ancho según sea necesario */
}

.bank-button {
    background-color: #4CAF50; /* Verde */
    color: white;
    font-weight: bold; /* Hacer el texto más destacado */
}

.bank-button:hover {
    background-color: #45a049;
}

.webpay-button {
    background-color: #2196F3; /* Azul */
    color: white;
}

.webpay-button:hover {
    background-color: #0b7dda;
}

.payment-info {
    font-size: 14px;
    color: #555;
    text-align: center;
    margin-bottom: 20px;
}


</style>

<br><br>

<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
// Definición de constantes para la integración con Transbank
define('TBK_API_KEY_ID', '597045358953');  
define('TBK_API_KEY_SECRET', '4db548a2-9ceb-4da1-8acb-750dce0435ec');  
define('TBK_ENDPOINT', 'https://webpay3g.transbank.cl/rswebpaytransaction/api/webpay/v1.0/transactions/');


/*
//INTEGRACION WEBPAY
define('TBK_API_KEY_ID', '597055555532');  
define('TBK_API_KEY_SECRET', '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C');  
define('TBK_ENDPOINT', 'https://webpay3gint.transbank.cl/rswebpaytransaction/api/webpay/v1.0/transactions/');
*/







// Obtención de token y acción desde el método GET/POST
$token_ws = $_POST['token_ws'] ?? null;  // Recibiendo el token desde GET
$action = $_GET['action'] ?? '';
$id = $id_obt_get ?? '';

// Inicialización de sesión para la token de formulario
if (!isset($_SESSION['form_token'])) {
  $_SESSION['form_token'] = bin2hex(random_bytes(32));
}

// Configuración de zona horaria
date_default_timezone_set('America/Santiago');

// Función que traduce el código del método de pago a texto obtenido de transbank
function traducirMetodoPago($codigo) {
  $metodosPago = [
      'VD' => 'Venta Débito',
      'VN' => 'Credito 1 Cuota',
      'VC' => 'Venta en Cuotas',
      'SI' => '3 Cuotas sin Interés',
      'S2' => '2 Cuotas sin Interés',
      'NC' => 'N Cuotas sin Interés',
      'VP' => 'Venta Prepago'
  ];

  return $metodosPago[$codigo] ?? 'Método de Pago Desconocido';
}

// Clase para la conexión a la base de datos
class Conexion2{
  public static function Conectar2(){
     
      define('servidor','localhost');
      define('nombre_bd','cre61650_agenda');
      define('usuario','cre61650_respaldos21');
      define('password','respaldos21/');     

      $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
      
      try{
         $conexion = new PDO("mysql:host=".servidor.";dbname=".nombre_bd, usuario, password, $opciones);             
         return $conexion; 
      }catch (Exception $e){
          die("El error de Conexión es :".$e->getMessage());
      }         
  }
  
}


$objeto = new Conexion2();
$pdo  = $objeto->Conectar2(); 
// Procesamiento de la acción
if ($action === 'custom_action') {

  $response = get_ws('', 'PUT', 'webpay', "/rswebpaytransaction/api/webpay/v1.0/transactions/" . $token_ws);
  // Verificar si la respuesta es correcta
  if ($response->response_code === 0) {
    
    if (isset($response->amount) && is_numeric($response->amount)) {
      $montoFormateado = number_format(floatval($response->amount), 0, ',', '.');
    } else {
      $montoFormateado = '0.00';
  }
    $metodoPago = traducirMetodoPago($response->payment_type_code);

    $transaction_date = $response->transaction_date;


// Crear un objeto DateTime a partir de la fecha en UTC
$date = new DateTime($transaction_date, new DateTimeZone('UTC'));

// Ajustar a la zona horaria local (Chile)
$date->setTimezone(new DateTimeZone('America/Santiago')); // Ajusta a tu zona horaria



    $fechaLegible = $date->format('d-m-Y H:i');
    $fecha_parabd = $date->format('Y-m-d H:i');
    //INSERTAR REGISTRO CORRECTO A BD
    
    $secret_key = '333314565';  // Asegúrate de que es la misma clave usada al crear el token

    // Obtener datos de la solicitud
    $num_orden = $id_obt_get ?? 0;  // Asegúrate de que el ID es válido
    $received_token = $_GET['token'] ?? '';
    
    // Reconstruir el token para validación
    $expected_token = hash_hmac('sha256', $num_orden, $secret_key);
    
    // Verificar el token
    if (hash_equals($expected_token, $received_token)) {
        // El token es válido, proceder con la inserción
// Primero, verifica si ya existe un registro con el mismo num_orden y fecha_mov
$checkQuery = "SELECT COUNT(*) FROM pagos WHERE num_orden = ? AND fecha_mov = ?";
$checkStmt = $pdo->prepare($checkQuery);
$checkStmt->execute([$num_orden, $fecha_parabd]);
$exists = $checkStmt->fetchColumn() > 0;
list($fecha, $hora) = explode(' ', $fechaLegible);
$iva = $montoFormateado * 0.19;
if (!$exists) {
    // Si no existe, procede con la inserción
    $sql = "INSERT INTO pagos (num_orden, metodo_pago, id_cartola, datos_adicionales, monto, usuario, fecha_mov) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $num_orden,
        $metodoPago,  // Método de pago
        $response->authorization_text, 
        json_encode($response),  // Almacenando todos los detalles como JSON
        '$'.$montoFormateado, 
        'Cliente',  // Supongamos que el usuario es 'Cliente'
        $fecha_parabd
    ]);
    echo "<script>
    Swal.fire({
        title: 'Transacción Exitosa',
        icon: 'success',
        html: `
 <div style='font-family: Arial, sans-serif; text-align: left;'>
    <div style='text-align: center;'>
        <img src='https://www.transbankdevelopers.cl/public/library/img/svg/logo_webpay.svg' style='width: 100px; margin-bottom: 20px;'>
    </div>
    <div class='comprobante'>
        <h2>COMPROBANTE DE PAGO</h2>
        <hr>
        <p><span class='title'>Nombre Comercio:</span> <span>Respaldos Chile</span></p>
        <p><span class='title'>Fecha:</span> <span>$fecha</span></p>
        <p><span class='title'>Hora:</span> <span>$hora</span></p>
        <p><span class='title'>Método de Pago:</span> <span>$metodoPago</span></p>
        <hr>
        <p><span class='title'>Monto Neto:</span> <span>$$montoFormateado</span></p>
        <p><span class='title'>IVA (19%):</span> <span>$$iva</span></p>
                <p><span class='total'>Total:</span> <span class=''>$$montoFormateado</span></p>

       
        <hr>
        <p><span class='title'>Código de Autorización:</span> <span>{$response->authorization_code}</span></p>
    </div>
</div>
        `,
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#3085d6',
        customClass: {
          popup: 'custom-swal-popup'
      }
    }).then(function() {
        fetchClientInfo({$id_obt_get});
        fetchPaymentInfo({$id_obt_get});
        fetchTotalPrice({$id_obt_get});
    });
</script>";
} else {
  echo "<script>window.location.href = 'http://' + window.location.host + window.location.pathname + '?id={$num_orden}';</script>";
    
}
      

    } else {
      echo "<script>
      Swal.fire({
          title: 'Error en la Transacción',
          text: 'Token no valido: " . htmlspecialchars($response->responseMessage) . "',
          icon: 'error'
      });
    </script>";
    }


      
  } else {
      echo "<script>
              Swal.fire({
                  title: 'Error en la Transacción',
                  text: 'Pago fallido: " . htmlspecialchars($response->responseMessage) . "',
                  icon: 'error'
              });
            </script>";
          

  }
} else {
  
 // echo "<script>Swal.fire('Error', 'Acción no definida o inválida.', 'error');</script>";
}

// Función para realizar la solicitud web
function get_ws($data, $method, $type, $endpoint)
		{
			$curl = curl_init();

			/* AMBIENTE DE PRODUCCION */
			$TbkApiKeyId = '597045358953';
			$TbkApiKeySecret = '4db548a2-9ceb-4da1-8acb-750dce0435ec';
			$url = "https://webpay3g.transbank.cl" . $endpoint;//Live
		
			// AMBIENTE DE INTEGRACIÓN 
			/*$TbkApiKeyId='597055555532';
					$TbkApiKeySecret='579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';
					$url="https://webpay3gint.transbank.cl/".$endpoint; */ 

			curl_setopt_array(
				$curl,
				array(
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


	
  
?>


<script>
// Esta función toma los detalles de la transacción y realiza una llamada AJAX para guardar la información de pago
function insertPaymentCard(transactionDetails) {
    // Parsear los detalles de la transacción en un formato adecuado para enviar
    var transactionData = {
        option: "insert_payment_card",  // La acción que el backend espera
        num_orden: transactionDetails.id,  // El ID de la orden obtenido desde el backend
        transactionDetails: transactionDetails  // Todos los detalles de la transacción
    };

    // Mostramos en la consola los datos que se enviarán para verificación
    console.log("Datos que se enviarán al servidor:", transactionData);

    // Creación del objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "validacion_transferencia.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Manejar la respuesta del servidor
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Respuesta del servidor:", xhr.responseText);
            Swal.fire('Completado', 'El pago ha sido registrado correctamente.', 'success');
        }
    };

    // Convertir el objeto de datos a una cadena para enviarla
    var encodedData = encodeURIComponent(JSON.stringify(transactionData));

    // Enviar la solicitud con los datos
    xhr.send("data=" + encodedData);
}


document.querySelector('header').classList.add('header-v4');

</script>



<!-- Sección del título de la página -->
<section class="bg-img1 txt-center p-lr-15 p-tb-15" style="background-image: url(<?= $banner ?>);">
  <h2>Seguimiento de Compra</h2>

</section>

<section class="banner-info" style="background-image: url('path_to_your_image.jpg');">
  <div class="banner-content">
    <p>Tu pedido será entregado el Día: <br><strong><span id="fecha_entrega"></span></strong></p>
    <button class="confirm-button" id="confirm-button" onclick="confirmReception(<?php echo $id_obt_get; ?>, obtenerClienteConfirma())">Confirmo que puedo recibir</button>
<span id="cliente-confirma" style="display:none;"><?php echo $clienteConfirma; ?></span>
<p id="cliente-ruta" style="display:none;"></p>

  </div>



  <?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.respaldoschile.cl/validacion_transferencia.php', // Ajusta esto a la URL correcta
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => [
    'num_orden' => $id_obt_get,
    'opcion' => 'informacion_cliente',
  ],
  CURLOPT_SSL_VERIFYPEER => false,
));

$response = curl_exec($curl);

// Comprobar si ocurrió un error con cURL
if (curl_errno($curl)) {
    echo 'Error de cURL: ' . curl_error($curl);
} else {
    $data = json_decode($response, true);
}

curl_close($curl);


if (isset($data['data']['cliente'])) {
  $cliente = $data['data']['cliente'];
     $id_circuitruta = $cliente['id_circuitRuta'];
     $id_circuit = $cliente['id_circuitPedido'];

    // Ahora haz la llamada a la API de Circuit
    $curl_circuit = curl_init();
    curl_setopt_array($curl_circuit, array(
      CURLOPT_URL => "https://api.getcircuit.com/public/v0.2b/plans/" . $id_circuitruta. "/stops/" .$id_circuit,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic QTluSXh4MTFRQTkxZjl3VXVmZ2o6'
      ),
      CURLOPT_SSL_VERIFYPEER => false, 
    ));
    $responseCircuit = curl_exec($curl_circuit);
    curl_close($curl_circuit);
  }


$data = json_decode($responseCircuit, true);
// Puedes modificar la lógica de la condición según los datos que estás manejando.
$hasData = empty($data['address']) && !empty($data['recipient']) && !empty($data['deliveryInfo']);

// Usa operador ternario para decidir la clase
$containerClass = $hasData ? 'containeras visible' : 'containeras hidden';



if (!empty($data['address']) && !empty($data['recipient']) && !empty($data['deliveryInfo'])) {
  $containerClass = 'containeras visible';
// Acceder a los elementos de la respuesta
$address = $data['address']['address'];
$recipientName = $data['recipient']['name'];
$photoUrl = $data['deliveryInfo']['photoUrls'][0];
$trackingLink = $data['trackingLink'];
$routeStarted = $data['route']['state']['started'];
$deliveryState = $data['deliveryInfo']['state'];
$firmante = $data['deliveryInfo']['signeeName'];
$photoUrl = $data['deliveryInfo']['photoUrls'][0] ?? 'No photo available'; // URL de la foto del producto entregado
$statusMessage = '';  // Variable para almacenar el mensaje de estado
// Suponiendo que ya tienes $responseCircuit que es la respuesta de la API convertida a un array PHP
// Extraer latitud y longitud del intento de entrega, si está disponible
$lat = isset($data['deliveryUnattempted']['attemptedLocation']['latitude']) ? floatval($data['deliveryInfo']['attemptedLocation']['latitude']) : null;
$lng = isset($data['deliveryInfo']['attemptedLocation']['longitude']) ? floatval($data['deliveryInfo']['attemptedLocation']['longitude']) : null;

// Si no hay latitud o longitud del intento de entrega, usar la dirección principal
if ($lat === null || $lng === null) {
    $lat = floatval($data['address']['latitude']);
    $lng = floatval($data['address']['longitude']);
}

$estadoDetalles = [
  'unattempted' => ['icon' => 'fa-hourglass-start', 'color' => 'text-warninga', 'text' => 'Tu pedido está en preparación y pronto será enviado'],
  'delivered_to_recipient' => ['icon' => 'fa-check-circle', 'color' => 'text-success', 'text' => 'Entregado al destinatario'],
  'delivered_to_third_party' => ['icon' => 'fa-check-circle', 'color' => 'text-success', 'text' => 'Entregado a un Tercero'],
  'delivered_to_safe_place' => ['icon' => 'fa-check-circle', 'color' => 'text-success', 'text' => 'Entregado en un lugar seguro'],
  
  'failed_other' => ['icon' => 'fa-times-circle', 'color' => 'text-danger', 'text' => 'La entrega falló'],
  'in_transit' => ['icon' => 'fa-shipping-fast', 'color' => 'text-primary', 'text' => 'El paquete está en tránsito'],
  'out_for_delivery' => ['icon' => 'fa-truck', 'color' => 'text-info', 'text' => 'El paquete está en camino para ser entregado'],
  'failed_no_access' => ['icon' => 'fa-house-damage', 'color' => 'text-danger', 'text' => 'No se pudo acceder al lugar de entrega'],
  'failed_not_home' => ['icon' => 'fa-user-slash', 'color' => 'text-danger', 'text' => 'El destinatario no estaba disponible en el momento de la entrega'],
  'failed_bad_address' => ['icon' => 'fa-map-marked-alt', 'color' => 'text-danger', 'text' => 'La dirección de entrega es incorrecta o insuficiente'],
  'returned_to_sender' => ['icon' => 'fa-undo-alt', 'color' => 'text-warning', 'text' => 'El paquete está siendo devuelto al remitente'],
  'pending_reschedule' => ['icon' => 'fa-clock', 'color' => 'text-info', 'text' => 'La entrega está pendiente de reprogramación'],
  'failed_no_parking' => ['icon' => 'fa-clock', 'color' => 'text-info', 'text' => 'El despachador no pudo encontrar estacionamiento'],

  
  'failed_cant_find_address' => ['icon' => 'fa-clock', 'color' => 'text-info', 'text' => 'El despachador no pudo encontrar la dirección de entrega'],
  
  'default' => ['icon' => 'fa-question-circle', 'color' => 'text-secondary', 'text' => 'Estado desconocido']
];

// Suponiendo que $deliveryState es tu variable de estado de entrega
$estado = $estadoDetalles[$deliveryState] ?? $estadoDetalles['default'];
?>




<?php } else {
    // No se encontró información de entrega, no mostrar secciones de información ni mapa
    //echo "<p>No hay información disponible para mostrar.</status>";
}
?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAy1me0GgrNwevFOTCa8MQo2gNNt79JizI&callback=initMap"></script>
<script>

function showDeliveryPhoto(photoUrl) {
    if (photoUrl) {
        Swal.fire({
            title: 'Foto de la Entrega',
            imageUrl: photoUrl,
            imageAlt: 'Foto de la entrega',
            imageWidth: 300,
            imageHeight: 400,
            confirmButtonText: 'Cerrar',
            customClass: {
                popup: 'custom-swal-popup',
                confirmButton: 'custom-confirm-button',

            }
        });
    } else {
        Swal.fire({
            title: 'No disponible',
            text: 'No hay foto disponible para esta entrega.',
            icon: 'info',
            confirmButtonText: 'Cerrar',
            customClass: {
                popup: 'custom-swal-popup'
            }
        });
    }
}

var map;
var marker;

function initMap() {
  var initialLat = <?php echo json_encode($lat); ?>;
var initialLng = <?php echo json_encode($lng); ?>;
    var myLatLng = {lat: initialLat, lng: initialLng};

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        center: myLatLng
    });

    marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'Ubicación de la Entrega'
    });
}


function updateMap() {
    var apiUrl = 'https://api.getcircuit.com/public/v0.2b/plans/<?php echo $id_circuitruta; ?>/stops/<?php echo $id_circuit; ?>';
    fetch(apiUrl, {
        method: 'GET',
        headers: new Headers({
            'Authorization': 'Basic QTluSXh4MTFRQTkxZjl3VXVmZ2o6',
            'Content-Type': 'application/json'
        })
    })
    .then(response => response.json())
    .then(data => {
        var lat = data.deliveryInfo.attemptedLocation.latitude;
        var lng = data.deliveryInfo.attemptedLocation.longitude;
        var newLatLng = new google.maps.LatLng(lat, lng);
        marker.setPosition(newLatLng);
        map.panTo(newLatLng);
    })
    .catch(error => console.error('Error:', error));
}

// Actualizar el mapa cada 30 segundos
//setInterval(updateMap, 30000);



</script>

<script>
 
    function obtenerClienteConfirma() {
    const confirma = document.getElementById('cliente-confirma').textContent;
    return confirma;
}


    function confirmReception(num_orden, confirma) {
    const totalpaga = document.getElementById('totalAPagar').textContent;
    let valorapagar = totalpaga == 0 ? 0 : 1;
    let mensaje = valorapagar === 0 
        ? 'Te llegará un SMS cuando el producto salga a despacho indicando hora de entrega.' 
        : 'Recuerda pagar el producto antes de que nuestro despachador se retire del domicilio.';

    const iconUrl = '<?= media(); ?>/images/delivery.png';  // Cambia esta URL a la URL de tu imagen de icono de entrega

    Swal.fire({
        title: 'Confirmar Recepción',
        text: mensaje,
        imageUrl: iconUrl,
        imageHeight: 120,
        imageAlt: 'Icono de entrega',
        showCancelButton: true,
        confirmButtonText: 'Entendido',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false,
        customClass: {
            popup: 'custom-swal-popup',
            confirmButton: 'custom-confirm-button',
            cancelButton: 'custom-cancel-button'
        }
    }).then((result) => {
        if (result.isConfirmed) {
          const ruta_asignada = document.getElementById('cliente-ruta').textContent;

            // Aquí puedes enviar la variable al servidor
            $.ajax({
                url: 'validacion_transferencia.php',  // Asegúrate de poner la URL correcta aquí
                type: 'POST',
                data: { opcion: 'confirmar_entrega', num_orden: num_orden, confirma: confirma, ruta_asignada: ruta_asignada },  // Envía la variable adicional
                success: function(response) {
                    if (response.ok) {
                      Swal.fire({
  title: '¡Confirmado!',
  html: 'La recepción de tu pedido ha sido confirmada.<br><small>La hora de entrega será enviada por SMS al momento de salir a reparto.</small>',
  icon: 'success',
  customClass: {
    popup: 'custom-swal-popup'
  }
});
                        // Cambiar el texto del botón y deshabilitarlo
                        var botonConfirmar = document.getElementById('confirm-button');
                        botonConfirmar.textContent = 'Entrega Confirmada';
                        botonConfirmar.disabled = true;
                        botonConfirmar.classList.add('disabled-button');
                    } else {
                        Swal.fire('Error', 'Hubo un problema al confirmar la recepción. Intenta nuevamente.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error de red', 'Hubo un problema al contactar al servidor. Por favor, intenta nuevamente.', 'error');
                }
            });
        }
    });
}
    </script>
</section>
<hr>

<!-- Content page -->
<?php

?>
<div>
  <div class="container">
    <div class="info-container">
      <div class="client-info">
      <h2>Información del Cliente</h2>
                <p><i class="fas fa-id-card"></i> <strong>RUT Cliente:</strong> <span id="cliente-rut"></span></p>
                <p><i class="fas fa-map-marker-alt"></i> <strong>Dirección:</strong> <span id="cliente-direccion"></span></p>
                <p><i class="fas fa-phone-alt"></i> <strong>Teléfono:</strong> <span id="cliente-telefono"></span></p>
                <p><i class="fas fa-user"></i> <strong>Contacto:</strong> <span id="cliente-contacto"></span></p>
                <p><i class="fas fa-credit-card"></i> <strong>Modo de Pago:</strong> <span id="cliente-modo-pago"></span></p>
      </div>

      
<?php
if (isset($_GET['status'])) {
    echo '<div class="alert alert-info">' . htmlspecialchars($_GET['status']) . '</div>';
}
?>
      <script>




function fetchClientInfo(num_orden) {
    $.ajax({
        url: 'validacion_transferencia.php',  // Asegúrate de poner la URL correcta aquí
        type: 'POST',
        data: {
            opcion: 'informacion_cliente',
            num_orden: num_orden
        },
        success: function(response) {
            // Asegúrate de que el valor sea tratado como booleano
            if (response.ok === true) {
                const cliente = response.data.cliente;
                document.getElementById('cliente-rut').textContent = cliente.rut;
                document.getElementById('cliente-direccion').textContent = ucwords(
    cliente.direccion + ' ' +
    cliente.numero +
    (cliente.dpto ? ', ' + cliente.dpto : '') +
    ', ' + cliente.comuna
);                document.getElementById('cliente-telefono').textContent = ucwords(cliente.telefono);
                document.getElementById('cliente-contacto').textContent = ucwords(cliente.nombre);
                document.getElementById('cliente-modo-pago').textContent = ucwords(cliente.mododepago);
                document.getElementById('cliente-ruta').textContent = cliente.ruta_asignada; // Almacenar ruta_asignada
                if (cliente.id_circuit && cliente.id_circuit != '') {
                    fetchCircuitDetails(cliente.id_circuit);
                }
    
                var fechaString = cliente.fecha; // ejemplo: "2024-03-15"
var partesDeFecha = fechaString.split('-'); // divide la cadena en partes
// Asegúrate de restar 1 al mes porque los meses en JavaScript son de 0 a 11
var fechaObjeto = new Date(partesDeFecha[0], partesDeFecha[1] - 1, partesDeFecha[2]);
function ucwords(text) {
  return text.replace(/^(.)|\s+(.)/g, c => c.toUpperCase());
}
// Crear una instancia de Intl.DateTimeFormat para formatear la fecha
var formateador = new Intl.DateTimeFormat('es-ES', {
  weekday: 'long', // nombre del día de la semana
  year: 'numeric', // año en formato numérico
  month: 'long', // nombre del mes
  day: 'numeric' // día del mes
});

// Formatear la fecha y asignarla
document.getElementById('fecha_entrega').textContent = ucwords(formateador.format(fechaObjeto));
 // Verificar el estado de confirmación
if (cliente.confirma == 1) {
        // Cambiar el texto del botón y deshabilitarlo
        var botonConfirmar = document.getElementById('confirm-button');
        botonConfirmar.textContent = 'Entrega Confirmada';
        botonConfirmar.disabled = true;
        botonConfirmar.classList.add('disabled-button'); // Opcional: agregar clase para cambiar el estilo del botón deshabilitado
    }

                
// Rellenar la tabla de detalles del pedido
var detalles = response.data.detalles;
                var tbody = document.querySelector('.styled-table tbody');
                tbody.innerHTML = ''; // Limpiar filas existentes
                detalles.forEach(function(detalle) {
                    var row = `<tr>
                        <td>${detalle.id}</td>
                        <td>${detalle.modelo}</td>
                        <td>${detalle.tamano}</td>
                        <td>${detalle.tipotela}</td>
                        <td>${detalle.color}</td>
                        <td>${detalle.alturabase}</td>
                    </tr>`;
                    tbody.innerHTML += row; // Agregar fila a la tabla
                });
            } else {
              console.error('Error en la respuesta del servidor:', response.message);
              Swal.fire({
                    title: 'Sin ruta Asignada',
                    text: response.message,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    footer:'Por favor, contacta a tu vendedor para asignar una ruta de despacho',

                    icon: 'error',
                }).then(() => {
                    // Bloquear cualquier otra acción, redirigir o deshabilitar la página
                   // window.location.href = 'pagina_de_error.html'; // Redirigir a una página de error o de inicio
                });
            
            }
        },
        error: function() {
            alert('Error de red. Por favor, intenta nuevamente.');
        }
    });
}

function fetchPaymentInfo(num_orden) {
  return new Promise((resolve, reject) => {
    $.ajax({
        url: 'validacion_transferencia.php',
        type: 'POST',
        data: {
            opcion: 'pagos',
            criterio: 'por_n_orden',
            num_orden: num_orden
        },
        success: function(response) {
          //CAMBIAR NOMBRE COMPLETO POR NOMBRE SIMPLE
        if (response.ok) {
                const pagos = response.data;

              

                let paymentTableHtml  = '';
                pagos.forEach(pago => {
                    
          
                  let nombreFormateado = '';
                  banco = '';
        
        if (pago.nombre == '') {
      
            nombreFormateado = pago.identificacion;
            banco = 'Transbank';
            cambiarNombreColumna('Detalle');
            if(nombreFormateado == ''){
              banco = 'Efectivo/Transbank';
            }


            
        } else {
            let nombreCompleto = pago.nombre.trim(); // Asegúrate de eliminar espacios en blanco al principio y al final
            let partes = nombreCompleto.split(' ');
            banco = pago.banco;
            // Asegúrate de que hay al menos 3 partes antes de intentar acceder a partes[2]
            if (partes.length >= 3) {
                nombreFormateado = `${ucfirst(partes[0])} ${ucfirst(partes[2])}`;
            } else {
                // Si no hay suficientes partes, usa el nombre completo formateado
                nombreFormateado = ucfirst(partes[0]);
                if (partes.length > 1) {
                    nombreFormateado += ` ${ucfirst(partes[1])}`;
                }
                
            }
        }

        let nombreSimple = nombreFormateado.trim();
          
                    
          nombreSimple = nombreFormateado.trim();
                    paymentTableHtml += `
                        <tr>
                            <td>${pago.fecha_mov}</td>
                            <td>${pago.monto}</td>
                            <td>${ucfirst(nombreSimple) }</td>
                            <td>${banco}</td>
                        </tr>
                    `;
                });

                document.querySelector('.payment-table tbody').innerHTML = paymentTableHtml;

            } else {
               // alert(response.message || 'Hubo un error al procesar la información de pagos.');
            }
          },
            error: function() {
                reject('Error de red al intentar obtener información de pagos.');
            }
        });
    });
}

function cambiarNombreColumna(nuevaNombre) {
    // Obtener la tabla por su ID
    const tabla = document.getElementById('payment-table');

    // Verificar que la tabla y la fila de encabezado existan
    if (tabla && tabla.tHead && tabla.tHead.rows[0]) {
        // Obtener la fila de encabezado
        const encabezado = tabla.tHead.rows[0];

        // Verificar que la tercera columna exista
        if (encabezado.cells[2]) {
            // Cambiar el nombre de la tercera columna
            encabezado.cells[2].innerText = nuevaNombre;
        } else {
            console.error('La tercera columna no existe.');
        }
    } else {
        console.error('La tabla o la fila de encabezado no existen.');
    }
}



function ucfirst(texto) {
    return texto.charAt(0).toUpperCase() + texto.slice(1).toLowerCase();
}

function fetchTotalPrice(num_orden) {
    return new Promise((resolve, reject) => {
        $.ajax({
        url: 'validacion_transferencia.php',  // Asegúrate de poner la URL correcta aquí
        type: 'POST',
        data: {
            opcion: 'obtener_precio_total',
            num_orden: num_orden
        },
        success: function(response) {
            if (response.ok) {
                document.getElementById('precio_total').textContent = `$${response.data.total_precio}`;
                document.getElementById('total_pagado').textContent = `$${response.data.total_pagado}`;
                let totalPrecio = response.data.total_precio;
                    let totalPagado = response.data.total_pagado;
                    let totalAPagar = totalPrecio - totalPagado;
                    document.getElementById('totalAPagar').textContent = totalAPagar;
                    updatePaymentButton(totalPrecio, totalPagado);
                
                    resolve(totalAPagar);
                } else {
                    reject(response.message);
                }
            },
            error: function() {
                reject('Error de red. Por favor, intenta nuevamente.');
            }
        });
    });
}




function updatePaymentButton(total_precio, total_pagado) {
    var paymentButton = document.querySelector('.pagar-button');
    if (parseInt(total_precio) <= parseInt(total_pagado)) {      
        // Cambia el texto del botón y añade un ícono de éxito
        paymentButton.innerHTML = 'Pagado <i class="fas fa-check"></i>';
        paymentButton.style.backgroundColor = '#28a745'; // Verde Bootstrap para el éxito
        paymentButton.style.color = 'white'; // Texto blanco para mejor legibilidad
        paymentButton.disabled = true; // Opcional: desactiva el botón
    } else {
        paymentButton.innerHTML = 'Pagar';
        paymentButton.disabled = false; // Asegura que el botón esté activo si aún no se paga
    }
}




// Llama a la función con el número de orden correspondiente
fetchClientInfo(<?php echo $id_obt_get ?>);  // Reemplaza '7000' con el número de orden real
fetchPaymentInfo(<?php echo $id_obt_get ?>);
fetchTotalPrice(<?php echo $id_obt_get ?>);


</script>

      <div class="client-info">
        <div class="client-info-content">
          <h2>Información de Pago</h2>
          <p><i class="fas fa-dollar-sign"></i> <strong>Total: </strong> <span id="precio_total"></span></p>
<p><i class="fas fa-receipt"></i> <strong>Pagado: </strong> <span id="total_pagado"></span></p>

          <span id="totalAPagar" style="display:none;"></span>

          <div class="payment-actions">
          <div class="payment-actionsE" style=" overflow-x: auto; ">
          <table class="payment-table" id="payment-table">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Monto</th>
        <th>Titular</th>
        <th>Banco</th>
      </tr>
    </thead>
    <tbody>
      <!-- Filas de pagos se insertarán aquí -->
    </tbody>
  </table>
  </div>
  <button class="pagar-button" onclick="pago()">Pagar</button>
  <div class="validation-seal">
  <a href="#" class="validar-link" onclick="mostrarValidacion()">
    <img src="https://img.icons8.com/ios-filled/20/000000/security-checked.png" alt="Seguridad">
    Validación Automatizada - Más Información	
  </a>
</div>
</div>
        </div>
      </div>


    </div>
    <script>
  function mostrarValidacion() {
    Swal.fire({
      title: 'Validación de Transferencias',
      html: `
        <p>Nuestras transferencias automáticas se validan mediante un proceso riguroso y automatizado para asegurar la autenticidad y seguridad de cada transacción. Desarrollamos una función automatizada que obtiene y verifica la información de la transacción en tiempo real.</p>
        <p>Si tienes un e-commerce o un sistema similar y deseas integrar esta funcionalidad en tus sistemas, por favor contacta a <a href="mailto:contacto@respaldoschile.cl">contacto@respaldoschile.cl</a> para obtener más información.</p>
      `,
      icon: 'info',
      customClass: {
        popup: 'custom-swal-popup'
      }
    });
  }
</script>


    <style>.table-container {
  overflow-x: auto;
  position: relative;
}

.scroll-guide {
  position: sticky;
  top: 0;
  background: rgba(255, 255, 255, 0.9);
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  opacity: 0;
  transition: opacity 0.5s ease-in-out;
  white-space: nowrap;
  z-index: 10; /* Asegúrate de que el mensaje esté encima de la tabla */
  font-weight: bold;
  text-align: center;
}

.scroll-guide::after {
  content: " ➡️";
  display: inline-block;
  animation: moveIcon 1s infinite alternate;
  color: #00aaff; /* Color celeste */
}

@keyframes moveIcon {
  from {
    transform: translateX(0);
  }
  to {
    transform: translateX(10px);
  }
}
.comprobante {
    max-width: 400px;
    margin: 0 auto;
    font-family: Arial, sans-serif;
    background-color: #fff;
    padding: 10px;
}

.comprobante h2 {
    margin-bottom: 5px;
    text-align: center;
    font-size: 24px;
}

.comprobante p {
    margin: 3px 0;
    color: #555;
    word-wrap: break-word;
    display: flex;
    justify-content: space-between;
    font-size: 12px;
}

.comprobante .title {
    font-weight: bold;
    width: 160px; /* Ajusta este valor según tus necesidades */
}

.comprobante .highlight {
    color: #e91e63;
    font-weight: bold;
}

.comprobante hr {
    border: 0;
    border-top: 1px solid #ccc;
    margin: 10px 0;
}

.comprobante .total {
    font-size: 20px;
    font-weight: bold;
    text-align: center;
}

.comprobante .boleta {
  text-align: center;
    font-size: 14px;
    margin-bottom: 5px;
   
}

@media (max-width: 600px) {
    .comprobante {
        padding: 10px;
    }
}
.validar-link {
    display: flex;
    align-items: center;
    margin-top: 10px;
    font-size: 12px;
    color: #555;
    text-decoration: none;
    border: 1px solid #ccc;
    padding: 2px 5px;
    border-radius: 3px;
    background-color: #f9f9f9;
  }

  .validar-link img {
    margin-right: 5px;
  }

  .validar-link:hover {
    color: #333;
    border-color: #999;
  }


</style>
<script>document.addEventListener('scroll', function() {
  var scrollGuide = document.getElementById('scrollGuide');
  var tableContainer = document.querySelector('.table-container');
  var rect = tableContainer.getBoundingClientRect();

  if (rect.top < window.innerHeight && rect.bottom >= 0) {
    scrollGuide.style.opacity = 1;
  } else {
    scrollGuide.style.opacity = 0;
  }
});;</script>
   <div class="table-container">
   <div class="floating-container">
  <!-- Este es el div que ya tienes y que sigue en tu página -->
  <div class="scroll-guide" id="scrollGuide">    Desliza hacia el lado para ver todo el pedido   </div>
  <!-- Aquí están los botones u otros elementos que siguen -->
</div>

   <table class="styled-table">
        <thead>
          <tr>
            <th>Código</th>
            <th>Modelo</th>
            <th>Tamaño</th>
            <th>Tela</th>
            <th>Color</th>
            <th>Altura Base</th>
          </tr>
        </thead>
        <tbody>
      
        </tbody>
      </table>
    </div>
    <div  class="<?= $containerClass ?>">
    <h1>Información de la Entrega</h1>
    
    <div class="section">
        <div class="title">Detalles de la Entrega</div>
        <div class="info">Dirección: <?php echo $address; ?></div>
        <div class="info">Destinatario: <?php echo $recipientName; ?></div>
        <div class="info">Estado de la Entrega: 
          <?php 

          if ($routeStarted === true && $deliveryState === 'unattempted') {
    $estado = ['icon' => 'fa-shipping-fast', 'color' => 'text-primary', 'text' => 'En tránsito'];
}  ?>
    <i class="fas <?php echo $estado['icon']; ?> <?php echo $estado['color']; ?>"></i>
    <span class="<?php echo $estado['color']; ?>"><?php echo $estado['text']; ?></span>
    <?php 
?>
</div>

<?php if ($deliveryState === 'delivered_to_recipient' || isset($firmante) )


{ 
  
  if($deliveryState === 'delivered_to_recipient'){
    $firmante = 'Cliente';}
  if($deliveryState === 'delivered_to_safe_place'){
  }else{
  ?>
          <div class="info">Recibido por: <?php echo $firmante; ?></div> 
<?php } ?>


        <div class="info">Foto de la entrega: <a href="javascript:void(0);" onclick="showDeliveryPhoto('<?php echo $photoUrl; ?>')">Ver Foto</a></div>
        <?php }?>
    </div>

    <div class="section">
        <div class="title">Rastreo de la Ruta</div>
        <?php if($trackingLink != '') { ?>
            
          <a href="<?php echo $trackingLink; ?>" class="link" target="_blank">Seguimiento en Vivo</a>
            <?php }else{?>
              Cuando la ruta inicie, podras hacerle seguimiento a tu pedido.
<?php  }  ?>
  
    </div>

    <?php
echo '<div id="map" style="width:100%; height:400px;"></div>';

?>
</div>
    <div class="info-container"> <!-- Puedes reutilizar la clase para mantener el estilo consistente -->
      <div class="delivery-info">
        <h2>Información Importante sobre la Entrega</h2>
        <p>Por favor, asegúrese de realizar el pago completo antes de que nuestro despachador se retire del domicilio.
          Esto es crucial para completar la transacción de manera segura y eficiente.</p>
        <p>Por motivos de seguridad y logística, el producto será entregado en la entrada principal de la casa o
          conserjería. <strong>No realizamos entregas a departamentos.</strong></p>
      </div>
    </div>
    <hr>

  </div>

  <script>

  function pago() {
    const totalAPagar = document.getElementById('totalAPagar').textContent;  // Asumo que esto es el monto a pagar que ya calculaste.
    // Capitaliza el método de pago del cliente
    mododepago = document.getElementById('cliente-modo-pago').textContent;

    // Define el contenido HTML dinámico según el método de pago
    let metodoPagoCliente = mododepago.toLowerCase();
    let htmlContent;

    if (metodoPagoCliente === 'debito' || metodoPagoCliente === 'credito') {
        htmlContent = `
            <div class="payment-method-selection">
                <div style="border: 2px solid #4CAF50; border-radius: 10px; padding: 15px; margin-bottom: 10px;">
                    <button class="bank-button" onclick="pay(${totalAPagar})">Transferencia</button>
                    <p class="payment-info">Paga directamente desde tu cuenta bancaria. Podemos validar el pago automáticamente. ¡Es más rápido y seguro!</p>
                </div>
                <div style="border: 1px solid #ccc; border-radius: 10px; padding: 15px;">
                    <form id="webpayForm" action="procesar_pago_webpay.php" method="POST">
                        <input type="hidden" id="amountInput" name="amount" value="0"> <!-- El valor se establecerá dinámicamente -->
                        <input type="hidden" id="webpaynum_orden" name="webpaynum_orden" value="0"> <!-- Asegúrate de que el PHP se procese correctamente -->
                        <button type="button" class="webpay-button" onclick="payByWebpay()">Pagar con Webpay</button>
                    </form>
                    <p class="payment-info">Utiliza tu tarjeta de crédito o débito.</p>
                </div>
            </div>`;

        // Mostrar SweetAlert2 con el contenido dinámico
        Swal.fire({
            title: 'Selecciona Método de Pago',
            html: htmlContent,
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'custom-swal-popup'
            

            }
        });
    } else {
        pay();
    }
}


// Función para capitalizar palabras
  function ucwords(str) {
  return str.replace(/\b\w/g, function(l) { return l.toUpperCase(); });
  }


  function pay() {
      const orderId = <?php echo $id_obt_get; ?>;  // Asegúrate de que el PHP se procese correctamente.
      
      // Obtener primero el monto total a pagar
      fetchTotalPrice(orderId).then(totalAPagar => {
          Swal.fire({
              title: 'Selecciona tu Banco',
              html: `
                  <div class="bank-selection">
                      <img src="<?= media(); ?>/images/banc/2024212162213BancoEstado_General_MDP_022024.png" onclick="selectBank('BancoEstado')" alt="Banco Estado">
                      <img src="<?= media(); ?>/images/banc/2022102513251120211021151441BancoDeChile.png" onclick="selectBank('BancoDeChile')" alt="Banco de Chile">
                      <img src="<?= media(); ?>/images/banc/20211021152820santander.png" onclick="selectBank('BancoSantander')" alt="Santander">
                      <img src="<?= media(); ?>/images/banc/202421216201520230413123142MedioPagoBCI.png" onclick="selectBank('BCI')" alt="BCI">
                      <img src="<?= media(); ?>/images/banc/2024228162310MACH_MDP_022024.png" onclick="selectBank('Mach')" alt="MACH">
                      <img src="<?= media(); ?>/images/banc/202351818232020211021152053Itau.png" onclick="selectBank('BancoItau')" alt="Itaú">
                      <img src="<?= media(); ?>/images/banc/202415224744BancoFalabella.png" onclick="selectBank('BancoFalabella')" alt="Banco Falabella">
                      <img src="<?= media(); ?>/images/banc/bice.png" onclick="selectBank('BancoBice')" alt="Banco Bice">
                      <img src="<?= media(); ?>/images/banc/Logo_Ripley_banco_2.png" onclick="selectBank('BancoRipley')" alt="Banco Ripley">
                      <button class="banks-button" onclick="showOtherBanks()"><i class="fas fa-building"></i> Otros Bancos</button>
                      <p class="transaction-confirmation">
                          <i class="fas fa-check-circle"></i> Confirmaremos la recepción de su transferencia en nuestra cuenta de forma inmediata.
                        
                      </p>
                      <br><strong>Total a Pagar: $${totalAPagar}</strong>
                  </div>`,
              showCancelButton: true,
              showConfirmButton: false,
              allowOutsideClick: false,
              cancelButtonText: 'Cancelar',
              customClass: {
                  popup: 'custom-swal-popup'
              }
          });
      }).catch(error => {
          console.error('Error al obtener el total a pagar:', error);
          alert('Error al obtener los datos de pago: ' + error);
      });
  }
    
  function showOtherBanks() {
      Swal.fire({
        title: 'Otros Bancos',
        html: `
        <div class="bank-list">
    <button onclick="selectBank('BancoConsorcio')">Banco Consorcio →</button>
    <button onclick="selectBank('BancoInternacional')">Banco Internacional →</button>
    <button onclick="selectBank('BancoItau')">Banco Itaú →</button>
    <button onclick="selectBank('BancoSecurity')">Banco Security →</button>
    <button onclick="selectBank('BancodeChileEdwardsCiti')">Banco de Chile | Edwards | Citi →</button>
    <button onclick="selectBank('CajalosAndes')">Caja los Andes →</button>
    <button onclick="selectBank('Coopeuch')">Coopeuch →</button>
    <button onclick="selectBank('Corpbanca')">Corpbanca →</button>
    <button onclick="selectBank('HSBC')">HSBC →</button>
    <button onclick="selectBank('MercadoPago')">Mercado Pago →</button>
    <button onclick="selectBank('Otrobanco')">Otro banco →</button>
    <button onclick="selectBank('PrepagoLosHeroes')">Prepago Los Heroes →</button>
    <button onclick="selectBank('Scotiabank')">Scotiabank →</button>
    <button onclick="selectBank('Tenpo')">Tenpo →</button>
</div>`,
        preConfirm: () => {
          const selectedBank = document.getElementById('bank-select').value;
          if (!selectedBank) {
            Swal.showValidationMessage("Por favor selecciona un banco"); // Muestra un mensaje si no selecciona banco
            return false;
          }
          return selectedBank;
        },
        confirmButtonText: 'Continuar',
        showCancelButton: true,
        cancelButtonText: 'Volver',
        cancelButtonColor: '#565656',
        customClass: {
          popup: 'custom-swal-popup',
          confirmButtonText: 'custom-confirm-button'
        },
        reverseButtons: true,
      }).then((result) => {
        if (result.isConfirmed && result.value) {
        

          selectBank(result.value);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          pay(); // Volver a la selección inicial de bancos
        }
      });
    }

  function selectBank(bank) {
      const bankLogoUrl = getBankLogoUrl(bank);
      Swal.fire({
        title: 'Confirmación del Banco',
        html: `
            <img src="${bankLogoUrl}" alt="${bank}" style="width: 100px; height: auto; margin-bottom: 20px;">
            <p>Por favor, ingresa tu RUT para continuar.</p>
            <input type="text" id="rut-input" class="swal2-input" placeholder="Ingresa tu RUT">
            <div id="rut-validation-message" style="color: red; font-size:12px;"></div>
            
        `,
        preConfirm: () => {
          const rut = document.getElementById('rut-input').value;
          if (!validateRUT(rut)) {
            Swal.showValidationMessage("Por favor, ingresa un RUT válido");
            return false;
          }
          return { bank: bank, rut: rut };
        },
        confirmButtonText: 'Continuar',
        showCancelButton: true,
        cancelButtonText: 'Cambiar de banco',
        allowOutsideClick : false,
        customClass: {
          popup: 'custom-swal-popup',
          confirmButton: 'custom-confirm-button'

        },
        didOpen: () => {
          const rutInput = document.getElementById('rut-input');
          rutInput.addEventListener('input', function () {
            this.value = formatRUT(this.value);
          });
          rutInput.addEventListener('blur', function () {
            const isValid = validateRUT(this.value);
            const messageElement = document.getElementById('rut-validation-message');
            messageElement.textContent = isValid ? '' : 'RUT inválido';
          });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          showBankDetails(result.value.bank, result.value.rut);
        } else {
          pay();
        }
      });
    }

  function formatRUT(rut) {
      const cleaned = rut.replace(/[^0-9kK]+/g, ''); // Elimina cualquier carácter que no sea dígito o 'k' o 'K'.
      if (cleaned.length <= 1) return cleaned;

      let body = cleaned.slice(0, -1);
      let dv = cleaned.substr(-1).toUpperCase();

      const formatted = body.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

      return `${formatted}-${dv}`;
    }

  function validateRUT(rut) {
      if (!/^\d{1,3}\.?\d{3}\.?\d{3}-[\dkK]$/.test(rut)) return false;
      let [body, dv] = rut.split('-');
      body = body.replace(/\./g, '');

      let sum = 0;
      let multiplier = 2;
      for (let i = body.length - 1; i >= 0; i--) {
        sum = sum + multiplier * body.charAt(i);
        multiplier = (multiplier == 7) ? 2 : multiplier + 1;
      }
      let calculatedDV = 11 - (sum % 11);
      if (calculatedDV === 11) calculatedDV = '0';
      if (calculatedDV === 10) calculatedDV = 'K';
      return dv.toUpperCase() === calculatedDV.toString().toUpperCase();
    }


  function showBankDetails(bank, rut) {
      const details = {
        accountNumber: '46328157',  // Número de cuenta fijo
        accountHolder: 'Respaldos Chile Spa',  // Titular de la cuenta fijo
        rut: '77186031-1',
        banco: 'Bci',
        tipo: 'Corriente',
        email: 'respaldos.transferencias@gmail.com'  // Email de contacto fijo
      };
      const bankLogoUrl = getBankLogoUrl('BCI'); // Obtener la URL del logo del banco
      let total_porpagar = document.getElementById('totalAPagar').textContent;
      Swal.fire({
        title: 'Transfiere tu pago',
        html: `<strong style="font-size:12px;">Copia los datos de nuestra cuenta de destino, abre la aplicación de tu banco y realiza la transferencia.</strong><div><img src="${bankLogoUrl}" alt="${bank}" style="width: 100px; height: auto; "><div  style="margin-bottom: 15px;">Monto: <strong id="montoapagar">$${total_porpagar}</strong></div></div>
          <div><strong>Banco:</strong> ${details.banco}</div>
            <div><strong>Nombre:</strong> ${details.accountHolder}</div>
            <div><strong>Rut:</strong> ${details.rut}</div>            
            <div><strong>Numero de cuenta:</strong> ${details.accountNumber}</div>  
            <div><strong>Tipo de cuenta:</strong> ${details.tipo}</div>        
            <div><strong>Email:</strong> ${details.email}</div>
            </div>`,
        showCancelButton: true,
        confirmButtonText: 'Ya Transferí',
        cancelButtonText: 'Cambiaré de banco',
        confirmButtonColor: '#68C802',
        allowOutsideClick : false,
        footer: `<button id="copy-button" onclick="copyBankDetails('${details.accountHolder}','${details.rut}', '${details.accountNumber}', '${details.tipo}', '${details.banco}', '${details.email}')">Copiar Datos</button>`,
        customClass: {
          popup: 'custom-swal-popup'        
        }
      }).then((result) => {
        if (result.isConfirmed) {
          confirmTransfer(bank, rut);  // Envía el banco elegido y rut para validación
        } else {
          pay();  // Vuelve a la selección de banco si decide cambiar
        }
      });
    }

  function copyBankDetails(accountHolder,rut, accountNumber, tipo, bank, email) {
      const textToCopy = `Nombre: ${accountHolder}, Rut: ${rut}, N° de cuenta: ${accountNumber}, Tipo de cuenta: ${tipo}, Banco: ${bank}, Email: ${email}`;
      navigator.clipboard.writeText(textToCopy).then(() => {
        Swal.update({
          title: 'Datos copiados',
          html: '<p>Los datos de la cuenta han sido copiados al portapapeles.</p>',
          showConfirmButton: false
          
        });

        // Asume que esta función calcula el monto a pagar

        // Restaurar el contenido original después de 2 segundos
        setTimeout(() => {
          showBankDetails(bank, rut);
        }, 1500);
      }).catch(err => {
        Swal.fire('Error', 'No se pudo copiar los datos.', 'error');
      });
    }


  function cleanCurrency(currencyValue) {
    if (!currencyValue) return 0;
    const cleaned = currencyValue.replace(/\$/g, '').replace(/\./g, '').replace(/,/g, '');
    return parseFloat(cleaned) || 0;
}

let attemptCount = 0;

  function confirmTransfer(bank, rut) {
  Swal.fire({
    title: 'Validando transferencia...',
    html: `
        <div id="swal-content">Por favor espera mientras validamos la transferencia.</div>
        <div style="margin-top: 20px;">
            <div id="progress-bar" style="width: 100%; background: #eee; border-radius: 5px; overflow: hidden;">
                <div id="progress" style="width: 0%; height: 10px; background: #28a745; transition: width 0.1s;"></div>
            </div>
        </div>
    `,
    allowOutsideClick: false,
    customClass: {
      popup: 'custom-swal-popup'
    },
    didOpen: () => {
      Swal.showLoading();
      const progressBar = document.getElementById('progress');
      let progress = 0;
      const interval = setInterval(() => {
        progress += 2;
        if (progress <= 100) {
          progressBar.style.width = progress + '%';
        }
      }, 450);

      // Actualizar mensajes de estado cada cierto tiempo
      setTimeout(() => updateSwalMessage('Estamos procesando tu solicitud...'), 5000);
      setTimeout(() => updateSwalMessage('Casi listo, estamos finalizando la validación...'), 11000);
      setTimeout(() => updateSwalMessage('Gracias por comprar en RespaldosChile...'), 15000);

      $.ajax({
        url: 'validacion_transferencia.php',
        type: 'POST',
        data: { bank, rut, opcion: 'validacion', num_orden: <?php echo $id_obt_get; ?>},
        success: function (response) {
            clearInterval(interval);  // Detener la barra de progreso
            if (response.ok) {
               // Actualizar datatable de pagos
            fetchTotalPrice(response.data.num_orden)
                .then(() => {
                    const totalPagado = cleanCurrency(document.getElementById('total_pagado').textContent);
                    const totalPrecio = cleanCurrency(document.getElementById('precio_total').textContent);
                    console.log('Total pagado:', totalPagado, 'Total precio:', totalPrecio);
                    updatePaymentButton(totalPrecio, totalPagado);  // Actualizar el botón de pago
                })
                .catch(error => console.error('Error updating payment info and prices:', error));
                fetchPaymentInfo(response.data.num_orden);
              const montoRecienteStr = response.data.monto;
    let totalPagadoStr = document.getElementById('total_pagado').textContent;
    let totalAPagarStr = document.getElementById('totalAPagar').textContent;

    let montoReciente = cleanCurrency(montoRecienteStr);
    let totalPagado = cleanCurrency(totalPagadoStr);
    let totalAPagar = cleanCurrency(totalAPagarStr);
                totalPagado += montoReciente;

              
                if (totalPagado >= totalAPagar) {
                  Swal.fire({
    title: '¡Todo listo!',
    html: `
        <div style="font-size: 16px;">¡Los pagos han sido completados con éxito!</div>
        <div style="margin-top: 20px; font-size: 16px; background: #f8f9fa; border-left: 5px solid #28a745; padding: 10px;">
            <strong>Detalles de la Transferencia:</strong>
            <ul style="list-style-type: none; padding-left: 0;">
                <li><strong>Banco:</strong> ${response.data.banco}</li>
                <li><strong>Monto:</strong> ${response.data.monto}</li>
                <li><strong>Rut:</strong> ${response.data.rut}</li>
            </ul>
        </div>
    `,
    icon: 'success',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Aceptar',
    customClass: {
      popup: 'custom-swal-popup',
        confirmButton: 'custom-confirm-button'
    }
});
} else {
   // Actualizar datatable de pagos
fetchPaymentInfo(response.data.num_orden);
    let textoAdicional = response.ok ? "Tu transferencia ha sido registrada, pero no cubre el total requerido." : "Por favor, revisa los detalles de la transferencia enviada.";
    Swal.fire({
    title: '¡Casi listo!',
    html: `
        <p style="font-size: 16px;">${textoAdicional}</p>
        <p style="font-size: 16px; margin-top: 10px;">Por favor, completa el pago restante para finalizar completamente tu transacción.</p>
        <div style="margin-top: 20px; font-size: 16px; background: #f8f9fa; border-left: 5px solid #ffc107; padding: 10px;">
            <strong>Detalles de la Transferencia:</strong>
            <ul style="list-style-type: none; padding-left: 0;">
                <li><strong>Banco:</strong> ${response.data.banco}</li>
                <li><strong>Monto:</strong> ${response.data.monto}</li>
                <li><strong>Rut:</strong> ${response.data.rut}</li>
            </ul>
        </div>
    `,
    icon: 'warning',
    confirmButtonText: 'Continuar',
  
    customClass: {
      popup: 'custom-swal-popup',
        confirmButton: 'custom-confirm-button',

    },
    }).then((result) => {
        if (result.isConfirmed) {
            pay(); // Reabre la ventana de selección de banco para nuevo pago
        }
    });
}

              
            } else {
              if (response.message === "Validación fallida: No se encontraron datos.") {
                if (attemptCount < 1) {
                    Swal.fire({
                        title: 'No se encontraron datos',
                        html: `El RUT ingresado es <strong>${rut}</strong>. Asegúrate de haber realizado la transferencia correctamente.<br><span style='font-size: 12px;  margin-top: 10px;'>Este mensaje puede aparecer si estamos experimentando demoras temporales en recibir la confirmación del banco o si aún no se ha completado la transferencia.</span>`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Reintentar',
                        cancelButtonText: 'Cancelar',
                        customClass: {
                          popup: 'custom-swal-popup',
                            confirmButton: 'custom-confirm-button',
                            cancelButton: 'custom-cancel-button'
                        }
                    }).then((retryResult) => {
                        if (retryResult.isConfirmed) {
                            attemptCount++; // Incrementar el contador de intentos
                            confirmTransfer(bank, rut); // Reintentar la validación
                        } else {
                          pay();
                        }
                    });
                } else {
                    showContactSupportMessage();
                }
            } else {
                Swal.fire('Error', response.message, 'error');
            }
              
            }
        },
        error: function () {
            clearInterval(interval);
            Swal.fire('Error de red', 'Hubo un problema al contactar al servidor. Por favor, intenta nuevamente.', 'error');
        }
      });
    }
  });
}

  function showContactSupportMessage() {
      Swal.fire({
          title: 'Limite de Intentos',
          html: `Si el problema persiste, por favor contacta a tu ejecutivo de ventas para asistencia técnica. Esto puede deberse a un problema intermitente en nuestros servidores o a una interrupción de la red. <br><br> Teléfono: <strong>+56979941253</strong>`,
          icon: 'info',
          confirmButtonText: 'Entendido',
          customClass: {
            popup: 'custom-swal-popup',
              confirmButton: 'custom-confirm-button'
          }
      });
  }

// Función para actualizar el mensaje de SweetAlert2
function updateSwalMessage(message) {
  const swalContent = document.getElementById('swal-content');
  if (swalContent) {
    swalContent.innerHTML = message;
  }
}



// Función para enviar el formulario de Webpay
function payByWebpay() {
    const totalAPagar = document.getElementById('totalAPagar').textContent;
    document.getElementById('webpaynum_orden').value = <?php echo $id; ?>;
// Establece el monto a pagar
    document.getElementById('amountInput').value = totalAPagar; // Establece el monto a pagar
    document.getElementById('webpayForm').submit(); // Envía el formulario
}



// Función para obtener la URL del logo del banco
function getBankLogoUrl(bank) {
      switch (bank) {
        case 'BancoEstado':
          return '<?= media() ?>/images/banc/2024212162213BancoEstado_General_MDP_022024.png';
        case 'BancoDeChile':
          return '<?= media() ?>/images/banc/2022102513251120211021151441BancoDeChile.png';
        case 'BancoSantander':
          return '<?= media() ?>/images/banc/20211021152820santander.png';
        case 'BCI':
          return '<?= media() ?>/images/banc/202421216201520230413123142MedioPagoBCI.png';
        case 'BancoItau':
          return '<?= media() ?>/images/banc/202351818232020211021152053Itau.png'; // Ruta de ejemplo, debes verificarla
        case 'BancoFalabella':
          return '<?= media() ?>/images/banc/202415224744BancoFalabella.png'; // Ruta de ejemplo, debes verificarla
        case 'BancoSecurity':
          return '<?= media() ?>/images/banc/Logo_empresa_banco_security.png'; // Ruta de ejemplo, debes verificarla
        case 'Scotiabank':
          return '<?= media() ?>/images/banc/2023779531820223910154scotiabank_logo_Mesa de trabajo 1.png'; // Ruta de ejemplo, debes verificarla
        case 'Corpbanca':
          return '<?= media() ?>/images/banc/Logo_CorpBanca.png'; // Ruta de ejemplo, debes verificarla
        case 'BancoBice':
          return '<?= media() ?>/images/banc/bice.png'; // Ruta de ejemplo, debes verificarla
        case 'BancoConsorcio':
          return '<?= media() ?>/images/banc/consorcio.jpeg'; // Ruta de ejemplo, debes verificarla
        case 'BancoInternacional':
          return '<?= media() ?>/images/banc/Banco_Internacional_2015.webp'; // Ruta de ejemplo, debes verificarla
        case 'BancoRipley':
          return '<?= media() ?>/images/banc/Logo_Ripley_banco_2.png'; // Ruta de ejemplo, debes verificarla
        case 'HSBC':
          return '<?= media() ?>/images/banc/HSBC-logo.svg'; // Ruta de ejemplo, debes verificarla
        case 'Coopeuch':
          return '<?= media() ?>/images/banc/logo.png'; // Ruta de ejemplo, debes verificarla
        case 'PrepagoLosHeroes':
          return '<?= media() ?>/images/banc/Logo-Los-Heroes-Prepago-3.png'; // Ruta de ejemplo, debes verificarla
        case 'Tenpo':
          return '<?= media() ?>/images/banc/Logo-Tenpo-4.png'; // Ruta de ejemplo, debes verificarla
        case 'CajalosAndes':
          return '<? media() ?>/images/banc/Logotipo_Caja_Los_Andes.png'; 
        case 'Mach':
          return '<?= media() ?>/images/banc/mach-sf.svg'; // Ruta de ejemplo, debes verificarla
        case 'MercadoPago':
          return '<?= media() ?>/images/banc/mercadopago.svg'; // Ruta de ejemplo, debes verificarla
        case 'Otro banco':
          return '<?= media() ?>/images/banc/otrobanco.png'; // Ruta de ejemplo, debes verificarla
        default:
          return '<?= media() ?>/images/banc/default.png'; // Un logo por defecto en caso de que no haya uno específico
      }
    }

    const bankUrls = {
      "BancoSantander": "https://www.santander.cl/",
      "BancodeChile | Edwards | Citi": "https://login.bancochile.cl/bancochile-web/persona/login/index.html#/login",
      "BCI": "https://www.bci.cl/personas",
      "BancoEstado": "https://www.bancoestado.cl/imagenes/comun2008/nuevo_paglg_pers2.html",
      "BancoItau": "https://banco.itau.cl/wps/portal/olb/web/login/!ut/p/b1/04_SjzQxMzY3NTExMteP0I_KSyzLTE8syczPS8wB8aPM4k3dQ40tPQ2BCoxMLQ0cvY0MvZx8fIwDfc2ACiKBCgxwAEcDQvrD9aPwKnE0gSrAY4WfR35uqn5uVI6lp66jIgBeuFZr/dl4/d5/L2dBISEvZ0FBIS9nQSEh/",
      "BancoFalabella": "https://www.bancofalabella.cl/BancoFalabellaChile/index.html",
      "BancoSecurity": "https://www.bancosecurity.cl/widgets/wPersonasLogin/index.asp",
      "Scotiabank": "https://www.scotiabank.cl/login/personas/?nocache=true&_ga=2.149632118.197575516.1504294443-831341108.1504294443",
      "Corpbanca": "https://www.corpbanca.cl/Ibank/Login.aspx?Persona",
      "BancoBICE": "http://www.bice.cl/personas",
      "BancoConsorcio": "https://www.bancoconsorcio.cl/WEB_BANCO_TRX/login.aspx",
      "BancoInternacional": "https://www.bancointernacional.cl/index.aspx",
      "BancoRipley": "https://miportal.bancoripley.cl/home/login.handler",
      "HSBC": "http://www.hsbc.cl/",
      "Coopeuch": "https://www.coopeuch.cl/tef/#/",
      "Prepago Los Heroes": "https://sitioprivado.prepagolosheroes.cl/login",
      "Tenpo": "https://www.tenpo.cl/",
      "CajalosAndes": "https://www.cajalosandes.cl/home_personas",
      "MercadoPago": "https://www.mercadopago.cl/link-de-pago-plugins-y-plataformas-checkout?matt_tool=70038000&matt_word=MLC_Institucionales_B&gclid=CjwKCAiA68ebBhB-EiwALVC-No2c5ZBw2F0Db1SUxxSgApcfPD8-XdhYp6kynLeMA_6X7VsFqklnRRoC_RAQAvD_BwE",
      "Otro banco": "N/A"  // Supongo que es un placeholder y deberías manejarlo en el código.
    };


  </script>

</div>
</div>
<?php


footerTienda($data);
?>