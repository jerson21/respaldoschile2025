<?php
header('Content-Type: text/html; charset=utf-8');

// Include the connection file
include_once '../bd/conexion.php';

// Create connection object using your existing Conexion class
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$infoPedidos = "";
if (isset($_POST['pedidosJson'])) {
    $pedidos = json_decode($_POST['pedidosJson'], true);

    // Procesamos el array de pedidos
    foreach ($pedidos as $pedido) {
        foreach ($pedido as $key => $value) {
            $infoPedidos .= "<strong>" . ucfirst($key) . ":</strong> " . $value . "<br>";
        }
        $infoPedidos .= "<br>"; // Añade un separador entre pedidos.
    }
}

// Recogemos todos los datos del formulario
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
if ($_POST['street_name'] == "" && $retiro_tienda != "on") {
    try {
        $consulta = "SELECT direccion, numero, dpto, region, comuna FROM pedido_detalle WHERE num_orden = :numero_orden";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':numero_orden', $numero_orden, PDO::PARAM_STR);
        $stmt->execute();
        
        if ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $direccion = ucfirst($fila['direccion']);
            $numero = $fila['numero']; //numero de direccion
            $dpto = $fila['dpto']; //numero de dpto o casa
            $region = $fila['region'];
            $comuna = $fila['comuna'];
        }
    } catch(PDOException $e) {
        // Manejo de errores
        echo "Error al consultar dirección: " . $e->getMessage();
    }
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
if ($numero_orden != "") {
    $nuevoregistroorden = $numero_orden;
} else {
    try {
        $consulta = "SELECT MAX(num_orden) AS num_orden FROM pedido";
        $stmt = $conexion->prepare($consulta);
        $stmt->execute();
        
        if ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nuevoregistroorden = trim($fila['num_orden']) + 1;
        }
    } catch(PDOException $e) {
        echo "Error al obtener número de orden: " . $e->getMessage();
    }
}

// FALTA FILTRAR QUE SI SE ESTA AGREGANDO UN NUEVO PEDIDO A LA ORDEN NO SE VUELVA A INGRESAR UN PEDIDO.
$estadopedidod = 0;

try {
    // Iniciar transacción
    $conexion->beginTransaction();
    
    // Total pagado como entero
    $total_pagado = ($abono == "" || $abono === null) ? 0 : intval($abono);
    
    // PASO 1: Insertar en la tabla principal pedido
    $consulta = "INSERT INTO pedido (rut_cliente, fecha_ingreso, despacho, total_pagado, vendedor, metodo_entrega, estado, orden_ext) 
                VALUES (:rut, :fecha_ingreso, :valor_despacho, :total_pagado, :vendedor, :metodo_entrega, :estado, :orden_ext)";
    
    $stmt = $conexion->prepare($consulta);
    
    $orden_ext = "0"; // Valor predeterminado para orden_ext
    
    $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
    $stmt->bindParam(':fecha_ingreso', $fecha_ingreso, PDO::PARAM_STR);
    $stmt->bindParam(':valor_despacho', $valorDespacho, PDO::PARAM_STR);
    $stmt->bindParam(':total_pagado', $total_pagado, PDO::PARAM_INT);
    $stmt->bindParam(':vendedor', $vendedor, PDO::PARAM_STR);
    $stmt->bindParam(':metodo_entrega', $metodo_entrega, PDO::PARAM_STR);
    $stmt->bindParam(':estado', $estadopedidod, PDO::PARAM_STR); 
    $stmt->bindParam(':orden_ext', $orden_ext, PDO::PARAM_STR);
    
    $stmt->execute();
    
    // Obtener el ID del pedido recién insertado
    $lastid = $conexion->lastInsertId();
    
    // PASO 2: Insertar detalles del pedido - usando ? en lugar de parámetros nombrados
    $consulta_detalle = "INSERT INTO pedido_detalle 
                        (num_orden, direccion, numero, dpto, region, comuna, modelo, tamano, alturabase, tipotela, 
                        color, cantidad, precio, abono, mododepago, tipo_boton, anclaje, anclajeMetal, 
                        comentarios, detalles_fabricacion, fecha_ingreso, pagado, metodo_entrega, 
                        detalle_entrega, vendedor, estadopedido, id_circuit, orden_ruta, atencion) 
                        VALUES 
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_detalle = $conexion->prepare($consulta_detalle);
    
    $id_circuit = '1'; // Valor predeterminado para id_circuit como varchar
    $orden_ruta = 0; // Valor predeterminado para orden_ruta
    $atencion = 0; // Valor predeterminado para atencion
    
    foreach ($pedidos as $pedido) {
        // Convertir abono a entero o usar 0 si está vacío
        $abono_int = ($abono == "" || $abono === null) ? 0 : intval($abono);
        
        // Preparar un array con todos los valores en el orden correcto
        $params = array(
            $nuevoregistroorden,
            $direccion,
            $numero,
            $dpto,
            $region,
            $comuna,
            $pedido['producto'],
            $pedido['tamano'],
            $pedido['alturaBase'],
            $pedido['material'],
            $pedido['color'],
            $cantidad,
            $pedido['precio'],
            $abono_int,
            $mododepago,
            $pedido['boton'],
            $pedido['anclaje'],
            $pedido['anclajeMetal'],
            $comentarios,
            $pedido['detallesFabricacion'],
            $fecha_ingreso,
            $pagado,
            $metodo_entrega,
            $detalle_entrega,
            $vendedor,
            $estadopedidod,
            $id_circuit,
            $orden_ruta,
            $atencion
        );
        
        // Ejecutar la consulta con el array de parámetros
        $stmt_detalle->execute($params);
        $lastid = $conexion->lastInsertId();
    }
    
    // Confirmar la transacción
    $conexion->commit();
    
} catch(PDOException $e) {
    // Revertir transacción en caso de error
    if ($conexion->inTransaction()) {
        $conexion->rollBack();
    }
    echo "Error en la inserción de pedido: " . $e->getMessage();
    $lastid = 0;
}

$mensajeError = "";

// Verificar si el cliente existe en la base de datos
$clienteExiste = false;
try {
    $consulta = "SELECT COUNT(*) FROM clientes WHERE rut = :rut";
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
    $stmt->execute();
    
    $count = $stmt->fetchColumn();
    $clienteExiste = ($count > 0);
    
} catch(PDOException $e) {
    $mensajeError = "Error al verificar cliente: " . $e->getMessage();
}

// Si el cliente no existe, lo insertamos. Si existe, actualizamos sus datos.
try {
    if (!$clienteExiste) {
        // Insertar nuevo cliente
        $consulta = "INSERT INTO clientes(rut, nombre, telefono, instagram, correo) 
                   VALUES (:rut, :nombre, :telefono, :instagram, :correo)";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':instagram', $instagram, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
    } else {
        // Actualizar cliente existente
        $consulta = "UPDATE clientes SET telefono = :telefono, nombre = :nombre, correo = :correo 
                   WHERE rut = :rut";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
        $stmt->execute();
    }
} catch(PDOException $e) {
    $mensajeError = "Error en operación de cliente: " . $e->getMessage();
}

// Insertar dirección del cliente
try {
    $consulta = "INSERT INTO direccion_clientes(rut_cliente, direccion, numero, dpto, region, comuna, referencia, estado) 
               VALUES (:rut, :direccion, :numero, :dpto, :region, :comuna, :referencia, '1')";
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
    $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
    $stmt->bindParam(':numero', $numero, PDO::PARAM_STR);
    $stmt->bindParam(':dpto', $dpto, PDO::PARAM_STR);
    $stmt->bindParam(':region', $region, PDO::PARAM_STR);
    $stmt->bindParam(':comuna', $comuna, PDO::PARAM_STR);
    $stmt->bindParam(':referencia', $referencia, PDO::PARAM_STR);
    $stmt->execute();
} catch(PDOException $e) {
    // Solo registrar el error, no interrumpir el proceso
    $mensajeError .= " Error al insertar dirección: " . $e->getMessage();
}

// Formatea la dirección para mostrarla en el SweetAlert
if ($dpto != '') {
    $numero = $numero . ", Departamento/Casa: " . $dpto;
}

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
?>