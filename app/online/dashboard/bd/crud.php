<?php
// Iniciar sesión (si aún no se ha iniciado)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Asignamos el usuario activo y actualizamos la variable de sesión
$usuario_activo = $_SESSION["s_usuario"] ?? '';
$_SESSION['nombre_user'] = $usuario_activo;

include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Recepción de datos enviados vía POST y validación de tipos
$nombre                = $_POST['nombre'] ?? '';
$telefono              = $_POST['telefono'] ?? '';
$pais                  = $_POST['pais'] ?? '';
$edad                  = ($_POST['edad'] ?? '') === '' ? 0 : (int)$_POST['edad'];
$opcion                = $_POST['opcion'] ?? '';
$estado                = ($_POST['estado'] ?? '') === '' ? 0 : (int)$_POST['estado'];
$id                    = ($_POST['id'] ?? '') === '' ? 0 : (int)$_POST['id'];
$ide                   = ($_POST['ide'] ?? '') === '' ? 0 : (int)$_POST['ide'];
$modelo                = $_POST['modelo'] ?? '';
$color                 = $_POST['color'] ?? '';
$tela                  = $_POST['tela'] ?? '';
$plazas                = ($_POST['plazas'] ?? '') === '' ? 0 : (int)$_POST['plazas'];
$alturabase            = ($_POST['alturabase'] ?? '') === '' ? 0 : (int)$_POST['alturabase'];
$tipo_boton            = $_POST['tipo_boton'] ?? '';
$anclaje               = $_POST['anclaje'] ?? '';
$rut                   = $_POST['rut'] ?? '';
$direccion             = $_POST['direccion'] ?? '';
$detalles_fabricacion  = $_POST['detalles_fabricacion'] ?? '';

$num                   = $_POST['numero'] ?? '';
$comuna                = $_POST['comuna'] ?? '';
$precio                = ($_POST['precio'] ?? '') === '' ? 0 : (int)$_POST['precio'];
$pago                  = $_POST['pago'] ?? '';
$orden                 = $_POST['orden'] ?? '';
$comentarios           = $_POST['comentarios'] ?? '';
$id_tapicero           = $_POST['id_tapicero'] ?? '';
$estadopedido          = ($_POST['estadopedido'] ?? '') === '' ? 0 : (int)$_POST['estadopedido'];
$motivo                = $_POST['motivo'] ?? '';
$abono                 = ($_POST['abono'] ?? '') === '' ? 0 : (int)$_POST['abono'];
$metodo_entrega        = $_POST['metodo_entrega'] ?? '';
$detalle_entrega       = $_POST['detalle_entrega'] ?? '';
$codigo_escaneado      = $_POST['codigo_escaneado'] ?? '';
$sector                = $_POST['sector'] ?? '';
$metraje               = ($_POST['metraje'] ?? '') === '' ? 0 : (float)$_POST['metraje'];
$cantidad              = ($_POST['cantidad'] ?? '') === '' ? 0 : (int)$_POST['cantidad'];
$material              = $_POST['material'] ?? '';

// Configuración de la zona horaria y formato de fecha (formato de 24 horas)
date_default_timezone_set('America/Santiago');
$DateAndTime = date('Y-m-d H:i:s');

switch ($opcion) {
    case 1: // Alta
        $consulta = "INSERT INTO personas (nombre, pais, edad) VALUES(:nombre, :pais, :edad)";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $resultado->bindParam(':pais', $pais, PDO::PARAM_STR);
        $resultado->bindParam(':edad', $edad, PDO::PARAM_INT);
        $resultado->execute();

        $consulta = "SELECT id, nombre, pais, edad FROM personas ORDER BY id DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 2: // Modificación
        $consulta = "UPDATE personas SET nombre=:nombre, pais=:pais, edad=:edad WHERE id=:id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $resultado->bindParam(':pais', $pais, PDO::PARAM_STR);
        $resultado->bindParam(':edad', $edad, PDO::PARAM_INT);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();

        $consulta = "SELECT id, nombre, pais, edad FROM personas WHERE id=:id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 3: // Baja
        $consultar = "INSERT INTO eliminados (id_pedido, rut_cliente, modelo, plazas, tipotela, color, alturabase, direccion, numero, dpto, telefono, comuna, precio, motivo, fecha, usuario)
            SELECT id, rut_cliente, modelo, tamano, tipotela, color, alturabase, direccion, numero, dpto, telefono, comuna, precio, :motivo, NOW(), :usuario
            FROM pedido_detalle d
            INNER JOIN pedido p ON p.num_orden = d.num_orden 
            INNER JOIN clientes c ON p.rut_cliente = c.rut
            WHERE id = :id";
        $stmt = $conexion->prepare($consultar);
        $stmt->bindParam(':motivo', $motivo, PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $usuario_activo, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            // Actualizamos el pedido con estado 404
            $consulta = "UPDATE pedido_detalle SET estadopedido=404 WHERE id=:id";
            $resultado = $conexion->prepare($consulta);
            $resultado->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado->execute();

            $consulta = "INSERT INTO pedido_etapas (idPedido, idProceso, fecha, usuario, observacion) VALUES(:id, 18, :fecha, :usuario, :motivo)";
            $resultado = $conexion->prepare($consulta);
            $resultado->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado->bindParam(':fecha', $DateAndTime, PDO::PARAM_STR);
            $resultado->bindParam(':usuario', $usuario_activo, PDO::PARAM_STR);
            $resultado->bindParam(':motivo', $motivo, PDO::PARAM_STR);
            $resultado->execute();
            $data = "Registro eliminado correctamente";
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Error en la consulta: " . $errorInfo[1];
            $data = $errorInfo;
        }
        break;

    case 4: // Modificación de estado
        $consulta = "UPDATE pedido_detalle SET estadopedido=:estado WHERE id=:id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':estado', $estado, PDO::PARAM_INT);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();

        $consultar = "SELECT num_orden FROM pedido_detalle WHERE id=:id";
        $stmt = $conexion->prepare($consultar);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orden = !empty($data) ? $data[0]['num_orden'] : '';

        if ($estado == 1) {
            $consulta = "INSERT INTO pedido_etapas (idPedido, idProceso, fecha, usuario, observacion) VALUES(:id, :estado, :fecha, :usuario, '')";
        } else {
            $consulta = "INSERT INTO pedido_etapas (idPedido, idProceso, fecha, usuario, observacion) VALUES(:id, :estado, :fecha, :usuario, 'Zona Producción')";
        }
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->bindParam(':estado', $estado, PDO::PARAM_INT);
        $resultado->bindParam(':fecha', $DateAndTime, PDO::PARAM_STR);
        $resultado->bindParam(':usuario', $usuario_activo, PDO::PARAM_STR);
        $resultado->execute();

        $consulta = "SELECT * FROM pedido p
                    INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden 
                    LEFT JOIN clientes c ON p.rut_cliente = c.rut WHERE d.id=:id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 5: // Modificación de datos de pedido (pedido_detalle y clientes)
        $consulta = "UPDATE pedido_detalle SET modelo=:modelo, tipotela=:tela, color=:color, tamano=:plazas, alturabase=:alturabase, detalles_fabricacion=:detalles_fabricacion, anclaje=:anclaje, tipo_boton=:tipo_boton, detalle_entrega=:detalle_entrega, metodo_entrega=:metodo_entrega, direccion=:direccion, numero=:num, comuna=:comuna, precio=:precio, abono=:abono, comentarios=:comentarios WHERE id=:ide";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':modelo', $modelo, PDO::PARAM_STR);
        $resultado->bindParam(':tela', $tela, PDO::PARAM_STR);
        $resultado->bindParam(':color', $color, PDO::PARAM_STR);
        $resultado->bindParam(':plazas', $plazas, PDO::PARAM_INT);
        $resultado->bindParam(':anclaje', $anclaje, PDO::PARAM_STR);
        $resultado->bindParam(':abono', $abono, PDO::PARAM_INT);
        $resultado->bindParam(':detalle_entrega', $detalle_entrega, PDO::PARAM_STR);
        $resultado->bindParam(':metodo_entrega', $metodo_entrega, PDO::PARAM_STR);
        $resultado->bindParam(':detalles_fabricacion', $detalles_fabricacion, PDO::PARAM_STR);
        $resultado->bindParam(':tipo_boton', $tipo_boton, PDO::PARAM_STR);
        $resultado->bindParam(':alturabase', $alturabase, PDO::PARAM_INT);
        $resultado->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $resultado->bindParam(':num', $num, PDO::PARAM_STR);
        $resultado->bindParam(':comuna', $comuna, PDO::PARAM_STR);
        $resultado->bindParam(':precio', $precio, PDO::PARAM_INT);
        $resultado->bindParam(':comentarios', $comentarios, PDO::PARAM_STR);
        $resultado->bindParam(':ide', $ide, PDO::PARAM_INT);
        if ($resultado->execute()) {
            $consulta2 = "UPDATE clientes SET nombre=:nombre, telefono=:telefono WHERE rut=:rut";
            $resultado2 = $conexion->prepare($consulta2);
            $resultado2->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $resultado2->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $resultado2->bindParam(':rut', $rut, PDO::PARAM_STR);
            if ($resultado2->execute()) {
                $consulta3 = "SELECT * FROM pedido p
                            INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden 
                            INNER JOIN clientes c ON p.rut_cliente = c.rut WHERE d.id=:ide";
                $resultado3 = $conexion->prepare($consulta3);
                $resultado3->bindParam(':ide', $ide, PDO::PARAM_INT);
                $resultado3->execute();
                $data = $resultado3->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $data = "Error al actualizar los datos de clientes";
            }
        } else {
            $data = "Error al actualizar los datos de pedido_detalle";
        }
        break;

    case 6: // Modificación de datos de pedido en tabla "pedidos"
        $consulta = "UPDATE pedidos SET rut_cliente=:rut, telefono=:telefono, modelo=:modelo, tipotela=:tela, color=:color, plazas=:plazas, alturabase=:alturabase, direccion=:direccion, numero=:num, comuna=:comuna WHERE id=:id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':rut', $rut, PDO::PARAM_STR);
        $resultado->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $resultado->bindParam(':modelo', $modelo, PDO::PARAM_STR);
        $resultado->bindParam(':tela', $tela, PDO::PARAM_STR);
        $resultado->bindParam(':color', $color, PDO::PARAM_STR);
        $resultado->bindParam(':plazas', $plazas, PDO::PARAM_INT);
        $resultado->bindParam(':alturabase', $alturabase, PDO::PARAM_INT);
        $resultado->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $resultado->bindParam(':num', $num, PDO::PARAM_STR);
        $resultado->bindParam(':comuna', $comuna, PDO::PARAM_STR);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();

        $consulta = "SELECT * FROM pedido WHERE id=:id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 7: // Modificación de pago
        $consulta = "UPDATE pedido_detalle SET formadepago=:pago, pagado=1 WHERE id=:id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':pago', $pago, PDO::PARAM_STR);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();

        $consultar = "SELECT num_orden FROM pedido_detalle WHERE id=:id";
        $stmt = $conexion->prepare($consultar);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $orden = !empty($data) ? $data[0]['num_orden'] : '';

        $consultar2 = "UPDATE orden SET estado=:estado WHERE num_orden=:orden";
        $stmt2 = $conexion->prepare($consultar2);
        $stmt2->bindParam(':estado', $estado, PDO::PARAM_INT);
        $stmt2->bindParam(':orden', $orden, PDO::PARAM_STR);
        $stmt2->execute();

        $consulta = "SELECT * FROM pedido p
                    INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden 
                    INNER JOIN clientes c ON p.rut_cliente = c.rut WHERE d.id=:id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 15: // Asignar rut de tapicero a trabajo
        $consulta = "UPDATE pedido_detalle SET tapicero_id=:id_tapicero WHERE id=:id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':id_tapicero', $id_tapicero, PDO::PARAM_STR);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();

        $obs = "Asignado a " . $id_tapicero;
        $consulta = "INSERT INTO pedido_etapas (idPedido, idProceso, fecha, usuario, observacion) VALUES(:id, 2, :fecha, :usuario, :obs)";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->bindParam(':fecha', $DateAndTime, PDO::PARAM_STR);
        $resultado->bindParam(':usuario', $usuario_activo, PDO::PARAM_STR);
        $resultado->bindParam(':obs', $obs, PDO::PARAM_STR);
        $resultado->execute();
        $data = "1";
        break;

    case 16: // Asignar rut de tapicero a trabajo (variante)
        $obs = "";
        $consulta = "INSERT INTO pedido_etapas (idPedido, idProceso, fecha, usuario, observacion) VALUES(:id, :estadopedido, NOW(), :id_tapicero, :obs)";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->bindParam(':estadopedido', $estadopedido, PDO::PARAM_INT);
        $resultado->bindParam(':id_tapicero', $id_tapicero, PDO::PARAM_STR);
        $resultado->bindParam(':obs', $obs, PDO::PARAM_STR);
        $resultado->execute();

        $consulta = "UPDATE pedido_detalle SET estadopedido=:estadopedido WHERE id=:id";
        $resultado = $conexion->prepare($consulta);
        $resultado->bindParam(':estadopedido', $estadopedido, PDO::PARAM_INT);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado->execute();
        $data = "1";
        break;

    case 17: // Cortar tela con verificación en bodega
        if ($metraje == 0) {
            $data = 'Swal.fire({
                icon: "error",
                html: "NO SE PUEDE CORTAR 0"
            });';
        } else {
            $nombre_interno = $material . ' ' . $color;
            $consultaTotal = "SELECT id_prod FROM productos_bodega WHERE id_prod IN (SELECT id_producto FROM bodega) AND material = :material AND (detalle = :color OR nombre_interno = :nombre_interno)";
            $stmt = $conexion->prepare($consultaTotal);
            $stmt->bindParam(':material', $material, PDO::PARAM_STR);
            $stmt->bindParam(':color', $color, PDO::PARAM_STR);
            $stmt->bindParam(':nombre_interno', $nombre_interno, PDO::PARAM_STR);
            $stmt->execute();
            $dataProd = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($dataProd) > 0){
                $id_producto_consultado = $dataProd[0]['id_prod'];
            } else {
                $id_producto_consultado = null;
            }

            if (!$id_producto_consultado) {
                $data = 'Swal.fire({
                    icon: "error",
                    html: "Producto no encontrado en bodega."
                });';
            } else {
                $consultaTotal = "SELECT COUNT(*) AS total FROM bodega WHERE id_producto = :id_producto_consultado AND sector_id = 'k1'";
                $stmt = $conexion->prepare($consultaTotal);
                $stmt->bindParam(':id_producto_consultado', $id_producto_consultado, PDO::PARAM_STR);
                $stmt->execute();
                $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

                if ($totalRegistros == 0) {
                    $data = 'Swal.fire({
                        icon: "error",
                        html: "Tela ' . $material . ' ' . $color . ' no está en su sector.<br><div style=\'font-size:12px; margin-top:15px; background-color:#EBEBEB;padding:7px; border-radius:5px;\'>Solicite agregar metraje a sector costura.</div>"
                    });';
                } else {
                    $consulta = "UPDATE bodega SET cantidad = cantidad - :metraje WHERE id_producto = :id_producto";
                    $stmt = $conexion->prepare($consulta);
                    $stmt->bindParam(':metraje', $metraje, PDO::PARAM_STR);
                    $stmt->bindParam(':id_producto', $id_producto_consultado, PDO::PARAM_STR);
                    $stmt->execute();

                    $consulta = "INSERT INTO pedido_etapas (idPedido, idProceso, fecha, usuario, observacion) VALUES(:id, 3, NOW(), :usuario, :obs)";
                    $stmt = $conexion->prepare($consulta);
                    $obs = "";
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->bindParam(':usuario', $usuario_activo, PDO::PARAM_STR);
                    $stmt->bindParam(':obs', $obs, PDO::PARAM_STR);
                    $stmt->execute();

                    $detalle = $material . " " . $color;
                    $consulta = "INSERT INTO cortes_tela (producto_id, detalle, metraje_corte, fecha_hora, usuario_nombre) VALUES(:id, :detalle, :metraje, NOW(), :usuario)";
                    $stmt = $conexion->prepare($consulta);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->bindParam(':detalle', $detalle, PDO::PARAM_STR);
                    $stmt->bindParam(':metraje', $metraje, PDO::PARAM_STR);
                    $stmt->bindParam(':usuario', $usuario_activo, PDO::PARAM_STR);
                    $stmt->execute();

                    $data = 'Swal.fire({
                        icon: "success",
                        html: "Metraje: ' . $metraje . ' Cortado Correctamente"
                    });';
                }
            }
        }
        break;

    case 223: // Cortar tela sin actualizar bodega
        if ($metraje == 0) {
            $data = 'Swal.fire({
                icon: "error",
                html: "NO SE PUEDE CORTAR 0"
            });';
        } else {
            $consulta = "INSERT INTO pedido_etapas (idPedido, idProceso, fecha, usuario, observacion) VALUES(:id, 4, NOW(), :usuario, '')";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':usuario', $usuario_activo, PDO::PARAM_STR);
            $stmt->execute();

            $detalle = $material . " " . $color;
            $consulta = "INSERT INTO cortes_tela (producto_id, detalle, metraje_corte, fecha_hora, usuario_nombre) VALUES(:id, :detalle, :metraje, NOW(), :usuario)";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':detalle', $detalle, PDO::PARAM_STR);
            $stmt->bindParam(':metraje', $metraje, PDO::PARAM_STR);
            $stmt->bindParam(':usuario', $usuario_activo, PDO::PARAM_STR);
            $stmt->execute();

            $data = 'Swal.fire({
                icon: "success",
                html: "Metraje: ' . $metraje . ' Cortado Correctamente"
            });';
        }
        break;

    case "consultar_teladuplicada":
        // Se agregaron paréntesis para garantizar la correcta precedencia lógica
        $consultaTotal = "SELECT COUNT(*) as total FROM productos_bodega WHERE material = :material AND (detalle = :color OR nombre_interno = :color)";
        $stmt = $conexion->prepare($consultaTotal);
        $stmt->bindParam(':material', $material, PDO::PARAM_STR);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        if ($totalRegistros == 0) {
            $data = 0;
        } else {
            $consultaTelasDuplicadas = "SELECT DISTINCT material, nombre_interno FROM productos_bodega WHERE material = :material AND (detalle = :color OR nombre_interno = :color)";
            $stmt = $conexion->prepare($consultaTelasDuplicadas);
            $stmt->bindParam(':material', $material, PDO::PARAM_STR);
            $stmt->bindParam(':color', $color, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        break;

    case 26: // Seleccionar todos los pedidos para DataTables
        $start       = isset($_POST['start']) ? (int)$_POST['start'] : 0;
        $length      = isset($_POST['length']) ? (int)$_POST['length'] : 10;
        $searchValue = $_POST['search']['value'] ?? '';
        $orderColumn = isset($_POST['order'][0]['column']) ? (int)$_POST['order'][0]['column'] : 0;
        $orderDir    = $_POST['order'][0]['dir'] ?? 'asc';

        $consultaTotal = "SELECT COUNT(*) as total FROM pedido p
                    INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden";
        $stmt = $conexion->prepare($consultaTotal);
        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $porcentajeRegistros = ceil($totalRegistros * 0.1);
        $lengthInicial = min($porcentajeRegistros, $length);

        $consulta = "SELECT * FROM pedido p
                    INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden 
                    INNER JOIN clientes c ON p.rut_cliente = c.rut 
                    WHERE (d.id LIKE :search OR c.rut LIKE :search OR c.telefono LIKE :search OR c.instagram LIKE :search OR d.direccion LIKE :search OR d.comuna LIKE :search)
                    LIMIT :start, :length";
        $stmt = $conexion->prepare($consulta);
        $searchParam = "%" . $searchValue . "%";
        $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':length', $lengthInicial, PDO::PARAM_INT);
        $stmt->execute();
        $dataResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = array(
            "draw"            => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
            "recordsTotal"    => $totalRegistros,
            "recordsFiltered" => $totalRegistros,
            "data"            => $dataResult
        );
        break;

    case "escanear_bodega":
        $consultaTotal = "SELECT COUNT(*) AS total FROM bodega WHERE id_producto = :codigo_escaneado AND sector_id = :sector_id";
        $stmt = $conexion->prepare($consultaTotal);
        $stmt->bindParam(':codigo_escaneado', $codigo_escaneado, PDO::PARAM_STR);
        $stmt->bindParam(':sector_id', $sector, PDO::PARAM_STR);
        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        if ($totalRegistros == 0) {
            $consulta = "INSERT INTO bodega (id_producto, sector_id, cantidad) VALUES (:id_producto, :sector_id, :cantidad)";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_producto', $codigo_escaneado, PDO::PARAM_STR);
            $stmt->bindParam(':sector_id', $sector, PDO::PARAM_STR);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->execute();
            $data = 1;
        } else {
            $consulta = "UPDATE bodega SET cantidad = cantidad + :cantidad WHERE id_producto = :id_producto AND sector_id = :sector_id";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':sector_id', $sector, PDO::PARAM_STR);
            $stmt->bindParam(':id_producto', $codigo_escaneado, PDO::PARAM_STR);
            $stmt->execute();
            $data = 2;
        }
        break;

    case "leer_codigo":
        $consulta = "SELECT * FROM productos_bodega WHERE id_prod = :codigo_escaneado";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':codigo_escaneado', $codigo_escaneado, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;

        case "obtener_form":
            $consulta = "SELECT * FROM productos_venta WHERE id_categoria = 1 ORDER BY id DESC";
            $stmt = $conexion->prepare($consulta);
            $stmt->execute();
            $data_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
            usort($data_db, function ($a, $b) {
                return $a['id'] - $b['id'];
            });
            $data = array();
            $tipo_producto_actual = '';
            foreach ($data_db as $row) {
                $tipo_producto = $row['tipo_producto'];
                $modelo = $row['modelo'];
                if ($tipo_producto != $tipo_producto_actual) {
                    if ($tipo_producto_actual != '') {
                        $data[] = '</optgroup>';
                    }
                    $data[] = "<optgroup label='$tipo_producto'>";
                    $tipo_producto_actual = $tipo_producto;
                }
                $data[] = "<option value='$modelo'>$modelo</option>";
            }
            $data[] = '</optgroup>';
            $data = json_encode($data);
            break;
    
        case "ultima_orden":
            $consulta = "SELECT * FROM pedido ORDER BY num_orden DESC LIMIT 1";
            $stmt = $conexion->prepare($consulta);
            $stmt->execute();
            $data_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                foreach ($data_db as $row) {
                    $data["orden"] = $row["num_orden"];
                    $data["fecha"] = $row["fecha_ingreso"];
                    $data["cliente"] = $row["rut_cliente"];
                }
            } else {
                $data = "No se encontraron comprobantes.";
            }
            break;
    
        case "buscar_pedidos":
            $consulta = "SELECT * FROM pedido p
                        INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden 
                        LEFT JOIN clientes c ON p.rut_cliente = c.rut WHERE rut_cliente = :rut";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;
    }
    
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    $conexion = null;
    ?>