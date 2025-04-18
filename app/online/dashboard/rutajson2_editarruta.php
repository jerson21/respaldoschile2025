<?php
// Incluir la conexión con PDO
include("bd/conexion.php");
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$id = $_POST['id'];
$opcion = $_POST['opcion'];

$data = array();

// Consulta principal parametrizada
$sql = "SELECT *, pd.id as id_pedido 
        FROM pedido p 
        INNER JOIN pedido_detalle pd ON p.num_orden = pd.num_orden 
        INNER JOIN clientes c ON p.rut_cliente = c.rut 
        INNER JOIN rutas r ON pd.ruta_asignada = r.id 
        WHERE pd.ruta_asignada = :id 
        ORDER BY pd.comuna";
$stmt = $conexion->prepare($sql);
$stmt->execute([':id' => $id]);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nestedData = array();

    $nestedData[] = $row["orden_ruta"];
    $nestedData[] = $row["num_orden"];
    $nestedData[] = $row["id_pedido"];
    $rut_cliente = $row["rut_cliente"];

    // Consulta para obtener los datos del cliente (primera vez)
    $sql_e = "SELECT * FROM clientes WHERE rut = :rut";
    $stmt_e = $conexion->prepare($sql_e);
    $stmt_e->execute([':rut' => $rut_cliente]);
    $rowe = $stmt_e->fetch(PDO::FETCH_ASSOC);

    $nestedData[] = $row["rut_cliente"] . " " . (isset($rowe['nombre']) ? $rowe['nombre'] : "");
    $nestedData[] = $row["modelo"];
    $nestedData[] = $row["tamano"];

    // Dependiendo del valor de $opcion se agregan campos distintos
    if ($opcion == "editar_orden") {
        $nestedData[] = ucfirst($row["tipotela"] . " " . $row["color"] . " " . $row["alturabase"]);
        $nestedData[] = $row["direccion"] . " " . $row['numero'] . " / " . $row['dpto'] . " " . $row["comuna"];
    } else {
        $nestedData[] = $row["direccion"] . " " . $row['numero'] . " / " . $row['dpto'];
        $nestedData[] = $row["color"];
        $nestedData[] = $row["alturabase"];
    }

    $nestedData[] = $row["telefono"];

    // Consulta para obtener el instagram (segunda vez) – se puede optimizar si es el mismo dato
    $sql_s = "SELECT * FROM clientes WHERE rut = :rut";
    $stmt_s = $conexion->prepare($sql_s);
    $stmt_s->execute([':rut' => $rut_cliente]);
    // Se asume que se recupera un solo registro (si hay más, se sobreescribe la variable)
    $instagram = "";
    if ($row1 = $stmt_s->fetch(PDO::FETCH_ASSOC)) {
        $instagram = $row1['instagram'];
    }
    $nestedData[] = $instagram;

    // Campos según forma de pago
    if ($opcion == "editar_orden") {
        if ($row['formadepago'] == 'transferencia' || $row['mododepago'] == 'transferencia') {
            $nestedData[] = "T " . $row["precio"];
        }
        if ($row['formadepago'] == 'efectivo' || $row['mododepago'] == 'efectivo') {
            $nestedData[] = "E " . $row["precio"];
        }
        if ($row['formadepago'] == 'pagado' || $row['mododepago'] == 'pagado') {
            $nestedData[] = "P " . $row["precio"];
        }
        if ($row['formadepago'] == 'credito' || $row['mododepago'] == 'credito') {
            $nestedData[] = "C " . $row["precio"];
        }
        if ($row['formadepago'] == 'debito' || $row['mododepago'] == 'debito') {
            $nestedData[] = "D " . $row["precio"];
        }
    } else {
        if ($row['formadepago'] == 'transferencia') {
            $nestedData[] = "T";
        }
        if ($row['formadepago'] == 'efectivo') {
            $nestedData[] = "F";
        }
        if ($row['formadepago'] == 'pagado') {
            $nestedData[] = "P";
        }
        if ($row['formadepago'] == 'credito') {
            $nestedData[] = "C";
        }
    }

    // Procesamiento de botones y detalles extra
    $boton = '';
    $anclajeMetal = '';
    $patas = "";
    if ($row['tipo_boton'] == 'B D') {
        $boton = "Boton Diamante";
    }
    if ($row['tipo_boton'] == 'B Color') {
        $boton = "Boton de Colores";
    }
    if ($row['anclaje'] == 'patas') {
        $patas = "Patas Madera";
    }
    if ($row['anclaje'] == 'si') {
        $patas = "Madera de Anclaje";
    }
    if ($row['anclajeMetal'] == 'si') {
        $anclajeMetal = "Anclajes Metal";
    }

    if ($opcion == "editar_orden") {
        $nestedData[] = "___"; 
        $nestedData[] = $row["detalles_fabricacion"] . " " . $boton . " " . $patas . " " . $anclajeMetal;
        $nestedData[] = "";
    } else {
        $nestedData[] = "";
        $nestedData[] = $row["detalles_fabricacion"] . " " . $boton . " " . $patas . " " . $anclajeMetal;
    }

    $data[] = $nestedData;
}

$json_data = array(
    "data" => $data // total data array
);

echo json_encode($json_data);
?>
