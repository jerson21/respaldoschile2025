<?php
require_once "bd/conexion.php"; // Se espera que este archivo cree la variable $conexion (instancia de PDO)
$objeto = new Conexion();
$conn = $objeto->Conectar();

// Obtener el id enviado por POST
$id = $_POST['id'];

// Consulta parametrizada para evitar inyección SQL
$query = "
    SELECT * FROM pedido p
    INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden 
    INNER JOIN clientes c ON p.rut_cliente = c.rut 
    LEFT JOIN pedido_etapas e ON d.id = e.idPedido 
    LEFT JOIN procesos pr ON e.idProceso = pr.idProceso 
    WHERE d.id = :id
";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

// Obtener todas las filas como un arreglo asociativo
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pedido = array();

// Recorrer los resultados y agrupar las etapas del pedido
if (count($rows) > 0) {
    foreach ($rows as $row) {
        $pedidoId = $row['id'];
        
        // Si el pedido aún no existe en el array, se crea la estructura
        if (!isset($pedido[$pedidoId])) {
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
                'etapas' => array() // Inicializamos el array de etapas
            );
        }

        // Agregar la etapa actual al array de etapas del pedido
        $pedido[$pedidoId]['etapas'][] = array(
            'idEtapa' => $row['idEtapa'],
            'idProceso' => $row['idProceso'],
            'usuario' => $row['usuario'],
            'fecha' => $row['fecha'],
            'NombreProceso' => $row['NombreProceso'],
            'obs' => $row['observacion']
        );
    }
}

// Cerrar la conexión (opcional en PDO)
$conn = null;

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($pedido);
?>
