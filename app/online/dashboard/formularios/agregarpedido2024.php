<?php
header('Content-Type: text/html; charset=utf-8');

$BD_SERVIDOR = "localhost";
$BD_USUARIO = "cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");
/*
$modelo = isset($_POST['modelo']) ? ucfirst($_POST['modelo']) : "";
$plazas = isset($_POST['plazas']) ? $_POST['plazas'] : "";
$tipotela = isset($_POST['listatelas']) ? $_POST['listatelas'] : "";
$color = isset($_POST['lista2']) ? $_POST['lista2'] : "";
$alturabase = isset($_POST['alturabase']) ? $_POST['alturabase'] : "";
$detalles_fabricacion = isset($_POST['detalles_fabricacion']) ? $_POST['detalles_fabricacion'] : "";
$botones = isset($_POST['boton']) ? $_POST['boton'] : "";
$anclaje = isset($_POST['anclaje']) ? $_POST['anclaje'] : "";
*/
$infoPedidos = "";
if (isset($_POST['pedidosJson'])) {
    $pedidos = json_decode($_POST['pedidosJson'], true);

    // Ahora puedes procesar $pedidos como un array en PHP
    foreach ($pedidos as $pedido) {
        foreach ($pedido as $key => $value) {
            $infoPedidos .= "<strong>" . ucfirst($key) . ":</strong> " . $value . "<br>";
        }
        $infoPedidos .= "<br>"; // Añade un separador entre pedidos.
    }
}

$nombre = isset($_POST['name']) ? ucfirst($_POST['name']) : "";
$correo = isset($_POST['email']) ? ucfirst($_POST['email']) : "";
$rut = isset($_POST['rut']) ? $_POST['rut'] : "";
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : "";
$numero_orden = isset($_POST['num_orden']) ? $_POST['num_orden'] : "";
$despacho = isset($_POST['despacho']) ? $_POST['despacho'] : "";
$retiro_tienda = isset($_POST['retiro_tienda']) ? $_POST['retiro_tienda'] : "";
$abono = isset($_POST['abono']) ? $_POST['abono'] : "";
$detalle_entrega = isset($_POST['detalle_entrega']) ? $_POST['detalle_entrega'] : "";
$valorDespacho = isset($_POST['valorDespacho']) ? $_POST['valorDespacho'] : "";

//CONSULTAMOS SI VIENE VACIA LA DIRECCION Y LE ASIGNAMOS LOS VALORES DEL ULTIMO REGISTRO CON EL NUMERO DE ORDEN QUE RECIBIMOS.
// si viene con el click de retiro en tienda no se realiza esta consulta.
if ($_POST['street_name'] == "" and $retiro_tienda != "on") {
    $resultado = $mysqli->query("SELECT direccion,numero,dpto,region,comuna FROM pedido_detalle WHERE num_orden = '$numero_orden'");
    $fila = mysqli_fetch_array($resultado);

    $direccion = ucfirst($fila['direccion']);
    $numero =  $fila['numero']; //numero de direccion
    $dpto =  $fila['dpto']; //numero de dpto o casa
    $region =  $fila['region'];
    $comuna =  $fila['comuna'];
} else {
    $direccion = isset($_POST['street_name']) ? ucfirst($_POST['street_name']) : "";
    $numero = isset($_POST['street_number']) ? $_POST['street_number'] : "";
    $dpto = isset($_POST['dpto']) ? $_POST['dpto'] : "";
    $region = isset($_POST['regiones']) ? $_POST['regiones'] : "";
    $comuna = isset($_POST['comunas']) ? $_POST['comunas'] : "";
}

if ($retiro_tienda == "on") {
    $direccion = "Retiro en tienda";
    $detalle = isset($_POST['detalle']) ? $_POST['detalle'] : "";
    $metodo_entrega = "Retiro en tienda";
} else {
    $metodo_entrega = "Despacho";
}

$mododepago = isset($_POST['mododepago']) ? $_POST['mododepago'] : "";
$comentarios = isset($_POST['message']) ? $_POST['message'] : "";


$instagram = isset($_POST['instagram']) ? $_POST['instagram'] : "";
$vendedor = isset($_POST['vendedor']) ? $_POST['vendedor'] : "";
$precio = isset($_POST['precio']) ? $_POST['precio'] : "";

$fecha_ingreso = isset($_POST['fecha_ingreso']) ? $_POST['fecha_ingreso'] : "";
$fecha_entrega = isset($_POST['fecha_entrega']) ? $_POST['fecha_entrega'] : "";
$clienteexiste = isset($_POST['clienteexisterut']) ? $_POST['clienteexisterut'] : "";

$pagado = isset($_POST['pagado']) ? $_POST['pagado'] : "";
$referencia = isset($_POST['referencia']) ? $_POST['referencia'] : "";



$descomponerdireccion = explode(",", $_POST['direccion']);

//SI EL FORMULARIO ES PARA AGREGAR PATAS
if (isset($_POST['tipo_formulario']) && $_POST['tipo_formulario'] == "patas") {

    $cantidad = $_POST['cantidad'];
    $modelo = "Patas de cama";
    $tipotela = ucfirst($_POST['modelo']);
} else {
    $cantidad = 1;
}



// Determina el número de orden para el nuevo pedido.
// Si ya existe un número de orden, lo utiliza. Si no, genera uno nuevo incrementando el último número de orden existente.
if ($numero_orden != "") {
    $nuevoregistroorden = $numero_orden;
} else {
    if ($stmt = $mysqli->prepare("SELECT MAX(num_orden) AS num_orden FROM pedido")) {
        $stmt->execute();

        // Vincular la variable al resultado de la consulta
        $stmt->bind_result($max_num_orden);

        // Obtener los resultados
        if ($stmt->fetch()) {
            $nuevoregistroorden = trim($max_num_orden) + 1;
        }

        // Cerrar el statement
        $stmt->close();
    }
}

// Consulta el nombre del color en la base de datos basándose en el ID suministrado.
// Este paso es importante para obtener detalles específicos del color que se usarán más adelante.
/*$resultado = $mysqli->query("SELECT color FROM colores WHERE id = '$color'");
$fila = mysqli_fetch_row($resultado);
*/

// FALTA FILTRAR QUE SI SE ESTA AGREGANDO UN NUEVO PEDIDO A LA ORDEN NO SE VUELVA A INGRESAR UN PEDIDO.
$estadopedidod = 0;

// Inserción de un nuevo pedido utilizando sentencias preparadas
if ($stmt = $mysqli->prepare("INSERT INTO pedido (rut_cliente, fecha_ingreso, despacho, vendedor, metodo_entrega, estado) VALUES (?, ?, ?, ?, ?, ?)")) {
    $stmt->bind_param("ssssss", $rut, $fecha_ingreso, $valorDespacho, $vendedor, $metodo_entrega, $estadopedidod);
    $stmt->execute();
    
// Asegúrate de que la cantidad de '?' coincida con el número de variables a enlazar.
if ($stmt = $mysqli->prepare("INSERT INTO pedido_detalle (num_orden, direccion, numero, dpto, region, comuna, modelo, tamano, alturabase, tipotela, color, cantidad, precio, abono, mododepago, tipo_boton, anclaje, anclajeMetal,comentarios, detalles_fabricacion, fecha_ingreso, pagado, metodo_entrega, detalle_entrega, vendedor, estadopedido) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
    
    foreach ($pedidos as $pedido) {
        // Aquí asumimos que 'cantidad', 'abono', 'comentarios', 'fecha_ingreso', 'pagado', 'mododepago', 'detalle_entrega', y 'vendedor' son iguales para todos los pedidos.
        // Ajusta la cadena de tipos y las variables según tus datos exactos.
        $stmt->bind_param('ssssssssssssidssssssssssss', 
        $nuevoregistroorden, $direccion, $numero, $dpto, $region, $comuna, $pedido['producto'], $pedido['tamano'], $pedido['alturaBase'], $pedido['material'], 
        $pedido['color'], $cantidad, $pedido['precio'], $abono, $mododepago, 
        $pedido['boton'], $pedido['anclaje'], $pedido['anclajeMetal'], $comentarios, $pedido['detallesFabricacion'], 
        $fecha_ingreso, $pagado, $metodo_entrega, $detalle_entrega, 
        $vendedor, $estadopedidod);
        if (!$stmt->execute()) {
            echo "Falló la ejecución: (" . $stmt->error . ") " . $stmt->error;
        }
        $lastid = mysqli_insert_id($mysqli);
    }
    $stmt->close();
} else {
    echo "Falló la preparación: (" . $mysqli->error . ") " . $mysqli->error;
}
}
$mensajeError = "";


// Verificar si el cliente existe en la base de datos

$clienteExiste = false;
$sql = "SELECT COUNT(*) FROM clientes WHERE rut = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s", $rut);
    $stmt->execute();
    $stmt->bind_result($count);
    if ($stmt->fetch()) {
        $clienteExiste = ($count > 0);
    }
    $stmt->close();
} else {
    $mensajeError = "Falló la preparación de la consulta de verificación del cliente: (" . $mysqli->errno . ") " . $mysqli->error;
}

// Si el cliente no existe en la base de datos, intenta insertar un nuevo registro con sus datos.
// Si ya existe, actualiza su información con los nuevos datos proporcionados.
if (!$clienteExiste) {
    // Preparar la sentencia SQL para insertar
  $sql = "INSERT INTO clientes(rut, nombre, telefono, instagram, correo) VALUES (?, ?, ?, ?, ?)";
  if ($stmt = $mysqli->prepare($sql)) {
      // Vincular los parámetros (s para string, i para integer, d para double, b para blobs)
      $stmt->bind_param("sssss", $rut, $nombre, $telefono, $instagram, $correo);
      
      // Ejecutar la sentencia
      if (!$stmt->execute()) {    
          $mensajeError = "Falló el ingreso de CLIENTE: (" . $stmt->error . ")";
          $operacionExitosa = false;
      }      
      // Cerrar la sentencia
      $stmt->close();
  } else {
      // Manejar el error de preparación aquí
      $mensajeError = "Falló la preparación de la inserción del CLIENTE: (" . $mysqli->error . ")";
      $operacionExitosa = false;
  }
} else {
  // Actualizar la información del cliente existente
  $sql = "UPDATE clientes SET telefono = ?, nombre = ?, correo = ? WHERE rut = ?";
  if ($stmt = $mysqli->prepare($sql)) {
      // Vincular los parámetros
      $stmt->bind_param("ssss", $telefono, $nombre, $correo, $rut);
      
      // Ejecutar la sentencia
      if (!$stmt->execute()) {
          // Manejar el error aquí
          $mensajeError = "Falló la actualización de CLIENTE: (" . $stmt->error . ")";
          $operacionExitosa = false;
      }
      
      // Cerrar la sentencia
      $stmt->close();
  } else {
      // Manejar el error de preparación aquí
      $mensajeError = "Falló la preparación de la actualización del CLIENTE: (" . $mysqli->error . ")";
      $operacionExitosa = false;
  }
}

// Intenta insertar una nueva dirección para el cliente en la base de datos.
// Si la inserción falla, muestra un mensaje de error.
// Preparar la sentencia SQL con marcadores de posición (?)
$sql = "INSERT INTO direccion_clientes(rut_cliente, direccion, numero, dpto, region, comuna, referencia, estado) VALUES (?, ?, ?, ?, ?, ?, ?, '1')";

// Preparar la declaración
if ($stmt = $mysqli->prepare($sql)) {
    // Vincular parámetros y ejecutar la declaración
    $stmt->bind_param("sssssss", $rut, $direccion, $numero, $dpto, $region, $comuna, $referencia);
    
    // Ejecutar la declaración
    if ($stmt->execute()) {
        //echo "Dirección ingresada correctamente para el cliente.";
    } else {
       // echo "Falló el ingreso de dirección nueva para el cliente: (" . $stmt->errno . ") " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    //echo "Falló la preparación de la consulta: (" . $mysqli->errno . ") " . $mysqli->error;
}





// Formatea la dirección agregando el departamento o casa si está especificado PARA MOSTRARLO EN EL SWAL FIRE
if ($dpto != '') {
    $numero = $numero . ", Departamento/Casa: " . $dpto;
}





 // Número de la nueva orden

// Preparar la respuesta
$response = array(
    "success" => true,
    "message" => "Pedido ingresado con éxito",
    "vendedor" => $vendedor,
    "lastid" => $lastid,
    "nuevoregistroorden" => $nuevoregistroorden
);

// Devolver la respuesta en formato JSON
echo json_encode($response);
exit;
