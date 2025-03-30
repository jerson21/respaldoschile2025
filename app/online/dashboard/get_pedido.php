<?php

include("conexion.php");

// Obtener el rut del cliente enviado por POST
$id = $_POST['id'];

// Consultar las direcciones del cliente en la base de datos
$query = "
SELECT * FROM pedido p
INNER JOIN pedido_detalle d on p.num_orden = d.num_orden 
INNER JOIN clientes c on p.rut_cliente = c.rut 
LEFT JOIN pedido_etapas e ON d.id = e.idPedido 
LEFT JOIN procesos pr ON e.idProceso = pr.idProceso WHERE d.id = $id";
$result = $conn->query($query);

// Crear un array para almacenar las direcciones
$direcciones = array();

$pedido = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $pedidoId = $row['id'];

    // Verificar si el pedido ya existe en el array de pedidos
    if (!isset($pedido[$pedidoId])) {
      // Crear un nuevo array para almacenar los detalles del pedido
      $pedido[$pedidoId] = array(
        'ide' => $row['id'],
        'orden_ext' => $row['orden_ext'],
        'rut' => $row['rut_cliente'],
        'nombre' => $row['nombre'],
        'modelo' => $row['modelo'],
        'plazas' => $row['tamano'],
        'altura' => $row['alturabase'],
        'anclaje' => $row['anclaje'],
        'tipo_boton' => $row['tipo_boton'],
        'detalles_fabricacion' => $row['detalles_fabricacion'],
        'num_orden' => $row['num_orden'],
        'tela' => $row['tipotela'],
        'metodo_entrega' => $row['metodo_entrega'],
        'detalle_entrega' => $row['detalle_entrega'],
        'color' => $row['color'],
        'direccion' => $row['direccion'],
        'numero' => $row['numero'],
        'dpto' => $row['dpto'],
        'comuna' => $row['comuna'],
        'telefono' => $row['telefono'],
        'precio' => $row['precio'],
        'abono' => $row['abono'],
        'estadopedido' => $row['estadopedido'],
        'fecha_ingreso' => $row['fecha_ingreso'],
        'vendedor' => $row['vendedor'],
        'comentarios' => $row['comentarios'],
        'etapas' => array()  // Array vacío para almacenar los detalles del pedido
      );
    }

    // Agregar el detalle actual al array de detalles del pedido
    $pedido[$pedidoId]['etapas'][] = array(
      'idEtapa' => $row['idEtapa'],
      'idProceso' => $row['idProceso'],
      'usuario' => $row['usuario'],
      'fecha' => $row['fecha'],
      'NombreProceso' => $row['NombreProceso'],
      'obs' => $row['observacion'],
      // Agregar más campos del detalle según tu estructura de datos
    );

  }

}

// Cerrar la conexión a la base de datos
$conn->close();

// Crear un array con los datos de las direcciones



// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($pedido);
?>