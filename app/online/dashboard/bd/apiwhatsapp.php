<?php
// Habilitar el acceso desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir conexión a la base de datos
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Leer los datos recibidos en formato JSON
$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData, true);

// Verificar si se envió el número de orden
if (!isset($data["num_orden"])) {
    echo json_encode(["error" => "Número de orden requerido"]);
    exit;
}

$num_orden = $data["num_orden"];

// Consulta para obtener el estado del pedido
$consulta = "SELECT p.num_orden, p.fecha_ingreso,d.tamano,d.modelo,d.tipotela,d.color, c.nombre AS cliente, d.estadopedido 
             FROM pedido p
             INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden 
             LEFT JOIN clientes c ON p.rut_cliente = c.rut
             WHERE p.num_orden = :num_orden
             LIMIT 1";

$stmt = $conexion->prepare($consulta);
$stmt->bindParam(':num_orden', $num_orden, PDO::PARAM_STR);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
$estados = [
    1  => 'PEDIDO ACEPTADO',
    2  => 'ENVIADO A FABRICACIÓN',
    3  => 'TELA CORTADA',
    4  => 'CORTE Y ARMADO DE ESQUELETO',
    5  => 'FABRICANDO',
    6  => 'TERMINADO',
    7  => 'DESPACHO INICIADO',
    8  => 'CARGADO EN CAMIÓN',
    9  => 'PRODUCTO ENTREGADO',
    10 => 'DEVUELTO POR ERROR DE FABRICACIÓN',
    11 => 'DEVUELTO POR DISCONFORMIDAD',
    12 => 'DEVUELTO POR FALLA EN CARGA',
    13 => 'DEVUELTO POR OTRO MOTIVO',
    14 => 'PRODUCTO DEVUELTO POR GARANTÍA',
    15 => 'PRODUCTO DEVUELTO CLIENTE NO CONTESTA',
    16 => 'PRODUCTO QUE NO PUDO RECIBIR',
    17 => 'CLIENTE SOLICITA FACTURA',
    18 => 'PRODUCTO ELIMINADO',
    19 => 'REAGENDAR',
    20 => 'Re-emitido'
];

// Obtenemos el id del estado de la respuesta (por ejemplo, 1, 2, etc.)
$idEstado = $resultado["estadopedido"];

// Verificamos si el id existe en el array; de lo contrario, ponemos un valor por defecto
$nombreEstado = isset($estados[$idEstado]) ? $estados[$idEstado] : 'Estado desconocido';



if ($resultado) {
    echo json_encode(["estado" => $nombreEstado, "cliente" => $resultado["cliente"], "modelo" => $resultado["modelo"], "tamano" => $resultado["tamano"], "tipotela" => $resultado["tipotela"], "color" => $resultado["color"], "fecha" => $resultado["fecha_ingreso"]]);
} else {
    echo json_encode(["error" => "Pedido no encontrado"]);
}

// Cerrar conexión
$conexion = null;
?>
