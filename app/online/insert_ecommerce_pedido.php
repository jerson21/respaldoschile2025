<?php
// Conexión a la base de datos del otro servidor
$servername = "localhost";
$username = "cre61650_respaldos21";
$password = "respaldos21/";
$dbname = "cre61650_agenda";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

$conn->set_charset("utf8");


// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar la acción a realizar
$action = $_POST['action'];

if ($action == 'insertCliente') {
    $rut = $_POST['rut'];
    $nombre = $_POST['nombre'] . ' ' . $_POST['apellido'];  // Concatenar nombre y apellido
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    // Verificar si el cliente ya existe
    $sql = "SELECT * FROM clientes WHERE rut = '$rut'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Insertar nuevo cliente
        $sql = "INSERT INTO clientes (rut, nombre, telefono, correo)
                VALUES ('$rut', '$nombre', '$telefono', '$correo')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Nuevo cliente creado con éxito";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

if ($action == 'insertPedido') {
    $rut_cliente = $_POST['rut_cliente'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $despacho = $_POST['despacho'];
    $total_pagado = $_POST['total_pagado'];
    $vendedor = $_POST['vendedor'];
    $metodo_entrega = $_POST['metodo_entrega'];
    $estado = $_POST['estado'];
    $orden_ext = $_POST['orden_ext'];

    // Insertar pedido
    $sql = "INSERT INTO pedido (rut_cliente, fecha_ingreso, despacho, total_pagado, vendedor, metodo_entrega, estado, orden_ext)
            VALUES ('$rut_cliente', '$fecha_ingreso', '$despacho', '$total_pagado', '$vendedor', '$metodo_entrega', '$estado', '$orden_ext')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Nuevo pedido creado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

} elseif ($action == 'insertDetalle') {
    $pedidoid = $_POST['pedidoid'];
    $nombre_producto = $_POST['nombre_producto'];
    $tamano = $_POST['tamano'];
    $color = $_POST['color'];
    $tipo_tela = $_POST['tipo_tela'];
    $altura_base = $_POST['altura_base'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $mododepoago = $_POST['mododepoago'] ?? 'Transferencia';
    $direccion = $_POST['direccion'];

    // Captura toda la información de $_POST
file_put_contents('logeeer.txt', $direccion , FILE_APPEND); 


    
    $numero = $_POST['numero'];
    $dpto = $_POST['dpto'];
    $region = $_POST['region'];
    $comuna = $_POST['comuna'];
    file_put_contents('logeeer.txt', $comuna , FILE_APPEND); 

    $detalle_entrega = $_POST['detalle_entrega'];
    $metodo_entrega = $_POST['metodo_entrega'];

      // Ajustar el tamaño si dice "1 plaza" o "2 plazas"
      if (strtolower($tamano) == "1 plaza") {
        $tamano = "1";
    } elseif (strtolower($tamano) == "2 plazas") {
        $tamano = "2";
    }

    // Obtener el num_orden usando orden_ext
    $sql = "SELECT num_orden FROM pedido WHERE orden_ext = '$pedidoid'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $num_orden = $row['num_orden'];
    } else {
        die("No se encontró un pedido con orden_ext = '$pedidoid'");
    }

    // Insertar detalle del pedido tantas veces como cantidad
    for ($i = 0; $i < $cantidad; $i++) {
        $sql = "INSERT INTO pedido_detalle (num_orden, modelo, tamano, color, mododepago, tipotela, alturabase, precio, cantidad, metodo_entrega, detalle_entrega, estadopedido, vendedor, direccion, numero, dpto, region, comuna)
                VALUES ('$num_orden', '$nombre_producto', '$tamano', '$color', '$mododepoago', '$tipo_tela', '$altura_base', '$precio', 1, '$metodo_entrega', '$detalle_entrega', 0, 'Ecommerce', '$direccion', '$numero', '$dpto', '$region', '$comuna')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Nuevo detalle de pedido creado con éxito";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Cerrar conexión
$conn->close();
?>
