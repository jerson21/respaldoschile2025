<?php
// Include the connection file
include_once '../bd/conexion.php';

// Create connection object using your existing Conexion class
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$id = $_POST['id'];
$opcion = $_POST['opcion'];

function formatRut($rut) {
  // Separa el número del dígito verificador
  list($numero, $dv) = explode('-', $rut);

  // Invierte el número para procesarlo de derecha a izquierda
  $numero = strrev($numero);

  // Inserta puntos cada tres dígitos
  $numeroConPuntos = implode('.', str_split($numero, 3));

  // Vuelve a invertir el número para que esté en el orden correcto
  $numeroConPuntos = strrev($numeroConPuntos);

  // Retorna el número formateado con el dígito verificador
  return $numeroConPuntos . '-' . $dv;
}

function llamarRutificador($rut){
  $rut = formatRut($rut);
  // Inicializa cURL.
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  // Configura las opciones de cURL.
  curl_setopt_array($curl, [
    CURLOPT_URL => 'https://www.nombrerutyfirma.com/rut',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => ['term' => $rut],
    CURLOPT_HTTPHEADER => [
      'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.e30.gXEgrSSOWRwhyozo1BB0Aa7nvVjl_cbbBaPE4Hl_l8w'
    ],
  ]);

  // Ejecuta la llamada y almacena la respuesta.
  $response = curl_exec($curl);

  // Cierra la sesión cURL.
  curl_close($curl);
  $externo = false;
  // Procesa la respuesta para extraer la información deseada.
  $dom = new DOMDocument;
  libxml_use_internal_errors(true); // Evita los warnings por HTML mal formado.
  $dom->loadHTML($response);
  libxml_clear_errors(); // Limpia los errores de libxml.

  $xpath = new DOMXPath($dom);

  // Define la ruta de los elementos que quieres extraer.
  $tr_elements = $xpath->query("//table[@class='table table-hover']/tbody/tr");

  $nestedData = []; // Prepara el arreglo para almacenar los datos.
  $externo = false;
  foreach ($tr_elements as $tr) {
    $tds = $tr->getElementsByTagName('td');
    $nombreCompleto = $tds->item(0)->nodeValue;  
    // Separamos el nombre completo en partes usando los espacios
    $partes = explode(' ', $nombreCompleto);

    // Reordenamos las partes del nombre
    // Asumiendo que el formato siempre es [Apellido Paterno] [Apellido Materno] [Nombres]
    // y queremos obtener [Primer Nombre] [Apellido Paterno]
    if (count($partes) >= 3) {
      $nombre = $partes[2]; // Tomamos el primer nombre
      $apellido = $partes[0]; // Tomamos el apellido paterno
      
      // Construimos el nombre reordenado
      $nombreReordenado = $nombre . " " . $apellido;
    } else {
      // Si no hay suficientes partes, simplemente usamos el nombre completo
      $nombreReordenado = $nombreCompleto;
    }

    if ($tds->length > 0) {
      $externo = true;
      $nestedData = [];
      $nestedData[] = $tds->length > 1 ? $tds->item(1)->nodeValue : ''; // RUT
      $nestedData[] =  $nombreReordenado;// Nombre
      // Agrega campos vacíos o con valores predeterminados según tu necesidad
      $nestedData[] = ''; // Teléfono
      $nestedData[] = ''; // Correo
      $nestedData[] = $tds->length > 3 ? $tds->item(3)->nodeValue : ''; // Dirección
      $nestedData[] = ''; // Número
      $nestedData[] = ''; // Dpto
      $nestedData[] = ''; // Instagram
      $nestedData[] = ''; // Región
      $nestedData[] = $tds->length > 4 ? $tds->item(4)->nodeValue : ''; // Ciudad/
      $nestedData[] = $externo;
      break; // Suponiendo que solo necesitas los datos del primer <tr> encontrado.
    }
  }

  return $nestedData; // Devuelve los datos organizados.
}

switch ($opcion) {
  case 1:
    $externo = false;
    // Usando PDO en lugar de mysqli
    $consulta = "SELECT c.*, d.*
                FROM clientes c
                INNER JOIN direccion_clientes d ON c.rut = d.rut_cliente
                WHERE c.rut = :id
                LIMIT 1";
    
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    
    $data = array();
    $nestedData = array();

    if ($stmt->rowCount() == 0) {
      $externo = true;
      // La consulta no devolvió resultados, llama a la función llamarRutificador.
      $nestedData = llamarRutificador($id);
      $json_data = array("data" => array($nestedData));
    } else {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      $nestedData[] = $row["rut"];
      $nestedData[] = $row["nombre"];
      $nestedData[] = $row["telefono"];
      $nestedData[] = $row["correo"];
      $nestedData[] = $row["direccion"];
      $nestedData[] = $row["numero"];
      $nestedData[] = $row["dpto"];
      $nestedData[] = $row["instagram"];
      $nestedData[] = $row["region"];
      $nestedData[] = $row["comuna"];
      $nestedData[] = $externo;

      $data[] = $nestedData;
    }

    $json_data = array(
      "data" => $nestedData   // total data array
    );

    echo json_encode($nestedData, JSON_UNESCAPED_UNICODE);

    break;
    
  case 2:
    // CONSULTA LOS PEDIDOS QUE ESTEN EN MENOR A 3, SIGNIFICA QUE NO ESTA ENVIADO A FABRICACION
    $consulta = "SELECT * FROM pedido p
              INNER JOIN pedido_detalle pd ON p.num_orden = pd.num_orden 
              WHERE rut_cliente = :id AND estadopedido < 3";
              
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    
    $contador = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $contador++;
      echo "<div style='margin-top:10px;'><b><img src='https://respaldoschile.cl/intranet/dashboard/img/fabricacion.png' width='25'></b> ". $contador ."- Agendado el: <b>" . $row['fecha_ingreso'] . "</b> por " . $row['vendedor'] . "<br>
<span style='color:black;'>Modelo: <b>" . $row['modelo'] . "</b> Tamaño: <b>" . $row['tamano'] . " </b>Tela: <b>" . ucfirst($row['tipotela']) . "</b> Color: <b>" .  ucfirst($row['color']) . "</b></span><br></div>";
    }
    break;
}
?>