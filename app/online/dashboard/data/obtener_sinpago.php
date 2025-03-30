<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
$ruta = $_POST['ruta'];

$consulta = "SELECT p.*, c.*, d.*,
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
WHERE d.estadopedido NOT IN ('100', '404') AND d.ruta_asignada = :ruta
GROUP BY p.num_orden, d.id, p.rut_cliente
ORDER BY d.num_orden, d.id, p.rut_cliente ASC";
$resultado = $conexion->prepare($consulta);
$resultado->bindParam(':ruta', $ruta); // Asegúrate de haber definido $ruta antes de esta línea
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);



$pedidosOrganizados = [];

foreach ($data as $pedido) {
    $numOrden = $pedido['num_orden'];
    $costoDespacho = floatval($pedido['despacho']);

    // Verificar si ya existe un pedido con este número de orden en el array resultante
    if (!isset($pedidosOrganizados[$numOrden])) {
        // Si no existe, crear un nuevo elemento en el array resultante
        // Separar explícitamente los datos del pedido/cliente y los detalles del pedido
        $pedido['total_pagado'] = floatval($pedido['total_pagado']);

        $pedidosOrganizados[$numOrden] = [
            
            'pedido_cliente' => [
                // Incluir aquí todos los datos del pedido y del cliente que consideres relevantes
                'num_orden' => $pedido['num_orden'],
                'fecha_pedido' => $pedido['fecha_ingreso'],
                'rut_cliente' => $pedido['rut_cliente'],
                'direccion' => $pedido['direccion'],
                'comuna' => $pedido['comuna'],
                'numero' => $pedido['numero'],
                'nombre_cliente' => $pedido['nombre'],
                'mododepago' => $pedido['mododepago'],
                'telefono' => $pedido['telefono'],
                'despacho' => $pedido['despacho'],
                'total_precio' => $costoDespacho,
                'total_pagado' => $pedido['total_pagado'], // Asumiendo que 'nombre' es el campo del nombre del cliente
                // Añade más campos según necesites
            ],
            'detalles' => [] // Inicializar el array de detalles vacío
        ];
    }

    // Convertir el precio a un valor numérico si es necesario
    // Asegúrate de que el formato del precio en la base de datos sea consistente
    // Por ejemplo, si tienes valores como '$1,234.56', primero deberías limpiar esos valores
    $precioNumerico = floatval(str_replace(['$', ','], '', $pedido['precio']));

    // Agregar el precio del detalle actual al total del pedido
    $pedidosOrganizados[$numOrden]['pedido_cliente']['total_precio'] += $precioNumerico;

    // Agregar detalles a la subarray de detalles
    $detalle = [
        'id' => $pedido['id'],
        'modelo' => $pedido['modelo'],
        'tamano' => $pedido['tamano'],
        'alturabase' => $pedido['alturabase'],
        'estadopedido' => $pedido['estadopedido'],
        'tapicero_id' => $pedido['tapicero_id'],
        // Continuar con todos los campos específicos del detalle
        'material' => $pedido['tipotela'],
        'color' => $pedido['color'],
        'cantidad' => $pedido['cantidad'],
        'precio' => $pedido['precio'],
        'abono' => $pedido['abono'],
        'mododepago' => $pedido['mododepago'],
        'tipo_boton' => $pedido['tipo_boton'],
        'anclaje' => $pedido['anclaje'],
        'comentarios' => $pedido['comentarios'],
        'cod_ped_anterior' => $pedido['cod_ped_anterior'],
        // Agregar más campos según sea necesario
    ];

    // Añadir el detalle al pedido correspondiente
    $pedidosOrganizados[$numOrden]['detalles'][] = $detalle;
}

// Convertir a array de valores para asegurar el formato correcto para la respuesta JSON
$response = ['data' => array_values($pedidosOrganizados)];

header('Content-Type: application/json');
echo json_encode($response);
