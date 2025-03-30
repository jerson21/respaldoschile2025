<?php

include("conexion.php");

// Obtener el rut del cliente enviado por POST
$id = $_POST['id'];
$totalPrecioTodosLosPedidos = 0;
$totalPagado = 0;

// Verificar si la variable "method" existe en la URL
if (isset($_GET['method'])) {
  // Verificar si el valor de "method" es "num_orden"
  if ($_GET['method'] == 'num_orden') {
      // Aquí puedes agregar lo que necesites hacer si "method" es "num_orden"
   
// Consultar las direcciones del cliente en la base de datos
$query = "
SELECT *,d.id AS idpedido, d.numero AS numero, p.num_orden AS num_orden, c.nombre AS nombre FROM pedido p
INNER JOIN pedido_detalle d on p.num_orden = d.num_orden 
LEFT JOIN clientes c on p.rut_cliente = c.rut 
LEFT JOIN pedido_etapas e ON d.id = e.idPedido 
LEFT JOIN procesos pr ON e.idProceso = pr.idProceso
LEFT JOIN cartola_bancaria cb ON cb.orden_asoc = p.num_orden
LEFT JOIN pagos pg ON pg.num_orden = p.num_orden  WHERE p.num_orden = $id GROUP BY d.id";
$result = $conn->query($query);

// Crear un array para almacenar las direcciones
$direcciones = array();

$pedido = array();
$totalPrecioTodosLosPedidos  =  0;
$totalPagado = 0;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $pedidoId = $row['idpedido'];

    // Verificar si el pedido ya existe en el array de pedidos
    if (!isset($pedido[$pedidoId])) {
      // Crear un nuevo array para almacenar los detalles del pedido
       
      $pedido[$pedidoId] = array(
        'ide' => $row['idpedido'],
        'ide_webs' => $row['orden_ext'],
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
        'estado_orden' => $row['estado'],
         'costo_envio' => $row['despacho'],
          'total_pagado' => $row['monto'],
        'estadopedido' => $row['estadopedido'],
        'fecha_ingreso' => $row['fecha_ingreso'],
        'vendedor' => $row['vendedor'],
        'comentarios' => $row['comentarios'],
        'etapas' => array(),
         // Array vacío para almacenar los detalles del pedido
      );
      $totalPrecioTodosLosPedidos += $row['precio'];
      $montoSinSimbolo = str_replace('$', '', $row['monto']);
      // Ahora eliminar los puntos para remover el separador de miles
      $montoSinPuntos = str_replace('.', '', $montoSinSimbolo);
      // Convertir el resultado a un número
      $montoNumerico = (float)$montoSinPuntos;
      
      // Ahora puedes sumarlo a $totalPagado
      $totalPagado += $montoNumerico;
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
      // Ejemplo de espacio para agregar algo:
      // Tu código a agregar podría ir aquí
  } else {
      // Si "method" tiene un valor diferente, puedes manejarlo aquí
      echo "La variable 'method' tiene un valor diferente de 'num_orden'.";
  }
} else {
  


// Consultar las direcciones del cliente en la base de datos
$query = "
SELECT *, d.id AS id FROM pedido p
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
        'ide_webs' => $row['orden_ext'],
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
        'estado_orden' => $row['estado'],
        'precio' => $row['precio'],
        'abono' => $row['abono'],
         'costo_envio' => $row['despacho'],
          'total_pagado' => $row['total_pagado'],
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

}








// Agregar el total de precios a la respuesta
$respuesta = [
  'pedidos' => $pedido,
  'totalPrecioTodosLosPedidos' => $totalPrecioTodosLosPedidos,
  'total_pagado' =>  $totalPagado
];

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($respuesta);


?>