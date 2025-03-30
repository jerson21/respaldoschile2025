<?php

include("../bd/conexion.php");
$objeto = new Conexion();
$conn = $objeto->Conectar();

// Función para normalizar montos
function normalizarMonto($monto)
{
    $montoLimpio = str_replace(['$', '.'], '', $monto);
    return (float)$montoLimpio;
}

function manejarNumOrden($id, $ruta, $conn)
{
    $pedidos = [];
    $totalPrecioTodosLosPedidos = 0;
    $total_precioproductos = 0;
    $totalPagado = 0;

    $stmt = $conn->prepare("SELECT p.*, c.*, d.*, 
  COALESCE(pg.total_pagado, 0) AS total_pagado,
  COALESCE(SUM(CAST(REPLACE(REPLACE(d.precio, '$', ''), '.', '') AS SIGNED)), 0) AS total_precio
FROM pedido p
INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden
INNER JOIN clientes c ON p.rut_cliente = c.rut
LEFT JOIN (
SELECT num_orden, SUM(CAST(REPLACE(REPLACE(monto, '$', ''), '.', '') AS SIGNED)) AS total_pagado
FROM pagos
GROUP BY num_orden
) pg ON p.num_orden = pg.num_orden
WHERE d.estadopedido NOT IN ('100', '404') AND p.num_orden = ? AND d.ruta_asignada = ?
GROUP BY p.num_orden, d.id, p.rut_cliente
ORDER BY d.num_orden, d.id, p.rut_cliente ASC");
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->bindParam(2, $ruta, PDO::PARAM_INT);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
        $pedidoId = $row['num_orden'];

        if (!isset($pedidos[$pedidoId])) {
            $valorDespacho = floatval($row['despacho']);
            $totalPrecioTodosLosPedidos += $valorDespacho;
            $pedidos[$pedidoId] = [
                'num_orden' => $row['num_orden'],
                'orden_ext' => $row['orden_ext'],
                'estadopedido' => $row['estadopedido'], // Asegúrate de que este campo existe en tus resultados SQL
                'vendedor' => $row['vendedor'],
                'despacho' => $row['despacho'], // Verifica este campo, parece que faltó incluirlo en el SELECT
                'referencia' => $row['detalle_entrega'], // Verifica este campo, parece que faltó incluirlo en el SELECT
                'fecha_ingreso' => $row['fecha_ingreso'],
                'total_pagado' => $row['total_pagado'],
                'total_productos' => $row['total_precio'],
                'detalles' => $row['detalle_entrega'], // Verifica este campo, parece que faltó incluirlo en el SELECT
                'total_precio' => $row['total_precio'] + $valorDespacho,
                'mododepago' => $row['mododepago'],
                'cliente' => [
                    'rut' => $row['rut_cliente'],
                    'nombre' => $row['nombre'], // Asegúrate de que c.* incluya estos campos
                    'telefono' => $row['telefono'],
                    'direccion' => $row['direccion'],
                    'lugar_venta' => $row['instagram']
                ],
                'detalle_pedidos' => [],

            ];
        }

        // Suma el total pagado y el precio del pedido actual a los totales
        $total_precioproductos += $row['total_precio'];
        $totalPrecioTodosLosPedidos += $row['total_precio']; // Asegúrate de que esta columna exista en tu resultado SQL
        $totalPagado = $row['total_pagado'];

        $pedidos[$pedidoId]['detalle_pedidos'][] = [
            'id' => $row['id'],
            'modelo' => $row['modelo'],
            'tamano' => $row['tamano'],
            'alturabase' => $row['alturabase'],
            'estadopedido' => $row['estadopedido'],
            'tapicero_id' => $row['tapicero_id'],
            'tela' => $row['tipotela'], // Asegúrate de que d.* incluya estos campos
            'color' => $row['color'],
            'cantidad' => $row['cantidad'],
            'precio' => $row['precio'],
            'abono' => $row['abono'],
            'referencia' => $row['detalle_entrega'],
            'detalles' => $row['detalle_entrega'], // Verifica este campo, parece que faltó incluirlo en el SELECT

            'tipo_boton' => $row['tipo_boton'],
            'anclaje' => $row['anclaje'],
            'comentarios' => $row['comentarios'],
            'cod_ped_anterior' => $row['cod_ped_anterior'],
        ];
    }

    return [$pedidos, $totalPrecioTodosLosPedidos, $totalPagado, $total_precioproductos];
}

// Función para manejar el método default
function manejarDefault($id, $conn)
{
    // Aquí se manejaría el caso por defecto, similar a manejarNumOrden, pero con una consulta y lógica diferente
    // Este es solo un placeholder para demostrar dónde iría esta lógica
    return [[], 0, 0]; // Devuelve valores vacíos o predeterminados
}

// Lógica principal
if (isset($_GET['method'])) {
    if ($_GET['method'] == 'num_orden' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $ruta = $_POST['ruta'];
        [$pedidos, $totalPrecioTodosLosPedidos, $totalPagado, $total_precioproductos] = manejarNumOrden($id, $ruta, $conn);
    } else {
        // Aquí se manejarían otros métodos
        echo "La variable 'method' tiene un valor diferente de 'num_orden'.";
        exit;
    }
} else {
    // Aquí se manejaría el caso por defecto si 'method' no está definido
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        [$pedidos, $totalPrecioTodosLosPedidos, $totalPagado, $total_precioproductos] = manejarDefault($id, $conn);
    } else {
        echo "ID no proporcionado";
        exit;
    }
}

// Cerrar la conexión a la base de datos


// Enviar respuesta
enviarRespuesta($pedidos, $totalPrecioTodosLosPedidos, $totalPagado, $total_precioproductos);

function enviarRespuesta($pedidos, $totalPrecioTodosLosPedidos, $totalPagado, $total_precioproductos)
{
    $respuesta = [
        'pedidos' => $pedidos,
        'totalPrecioTodosLosPedidos' => $totalPrecioTodosLosPedidos,
        'totalPagado' => $totalPagado,
        'total_precioproductos' => $total_precioproductos,
    ];
    header('Content-Type: application/json');
    echo json_encode($respuesta);
}
