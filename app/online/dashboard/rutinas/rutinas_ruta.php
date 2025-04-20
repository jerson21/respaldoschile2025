<?php
include "../bd/conexion.php";
$objeto1 = new Conexion();
$conexion = $objeto1->Conectar();

$opcion = $_POST['opcion'] ?? '';
error_log("==> ajax_rutas.php invocado | Opción: $opcion");

switch ($opcion) {

    case "consultar_ruta":
        $filtro = isset($_POST['rutas']) ? $_POST['rutas'] : '';
        if ($filtro == "") { $filtro = "-1"; }
        error_log("consultar_ruta | Ruta: $filtro");

        $consulta = $conexion->prepare("
            SELECT *,p.num_orden, c.nombre, pd.id as id, r.fecha as fecha_ruta,
                (SELECT GROUP_CONCAT(CONCAT(pd_sub.modelo, ' ', pd_sub.tamano, ' ', pd_sub.tipotela, ' ', pd_sub.color, ' ', pd_sub.alturabase) SEPARATOR '%0A')
                FROM pedido_detalle pd_sub
                WHERE pd_sub.num_orden = p.num_orden) AS pedido_completo,
                (SELECT SUM(precio)
                FROM pedido_detalle pd_sub
                WHERE pd_sub.num_orden = p.num_orden GROUP BY pd_sub.num_orden) AS total_pago
            FROM pedido p 
            LEFT JOIN pedido_detalle pd ON pd.num_orden = p.num_orden
            LEFT JOIN clientes c ON p.rut_cliente = c.rut   
            LEFT JOIN rutas r ON pd.ruta_asignada = r.id
            WHERE pd.ruta_asignada = :filtro
            ORDER BY pd.direccion ASC
        ");
        $consulta->bindParam(":filtro", $filtro, PDO::PARAM_INT);
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        error_log("consultar_ruta | Resultados: " . count($datos));
        echo json_encode($datos);
        unset($conexion);
        break;

    case "consultar_pedido":
        $id = $_POST['id'];
        error_log("consultar_pedido | Orden: $id");

        $consulta = $conexion->prepare("SELECT *, p.id as id FROM pedidos p 
            INNER JOIN clientes c ON p.rut_cliente = c.rut 
            INNER JOIN rutas r ON p.ruta_asignada = r.id  
            WHERE num_orden = :id ORDER BY p.direccion ASC");
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        error_log("consultar_pedido | Resultados: " . count($datos));
        echo json_encode($datos);
        unset($conexion);
        break;

    case "consultar_disponibles":
        error_log("consultar_disponibles | Consultando disponibles...");

        $consulta = $conexion->prepare("SELECT * FROM pedido p 
            INNER JOIN clientes c ON p.rut_cliente = c.rut 
            INNER JOIN pedido_detalle pd ON pd.num_orden = p.num_orden  
            WHERE pd.ruta_asignada = 0 AND pd.estadopedido IN (2,3,4,5,6,9) 
            ORDER BY pd.direccion ASC");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        error_log("consultar_disponibles | Resultados: " . count($datos));
        echo json_encode($datos);
        unset($conexion);
        break;

    case "consultar_numOrden":
        $num_orden = $_POST["orden"];
        error_log("consultar_numOrden | Orden: $num_orden");

        $consulta = $conexion->prepare("SELECT * FROM pedido p 
            INNER JOIN clientes c ON p.rut_cliente = c.rut 
            INNER JOIN pedido_detalle pd ON pd.num_orden = p.num_orden 
            WHERE p.num_orden = $num_orden ORDER BY modelo");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        error_log("consultar_numOrden | Resultados: " . count($datos));
        echo json_encode($datos);
        unset($conexion);
        break;

    case "agregar":
        $id = $_POST["id"];
        $ruta = $_POST["ruta"];
        error_log("agregar | ID: $id => Ruta: $ruta");

        $sql = "UPDATE pedido_detalle SET ruta_asignada = $ruta WHERE id = $id";
        $stmt = $conexion->prepare($sql);
        $success = $stmt->execute();
        error_log("agregar | Update: " . ($success ? "Éxito" : "Fallo"));
        $conexion = null;
        echo "Datos actualizados correctamente";
        break;

    case "eliminar":
        $id = $_POST["id"];
        error_log("eliminar | ID: $id");

        $sql = "UPDATE pedido_detalle SET ruta_asignada = 0 WHERE id = $id";
        $stmt = $conexion->prepare($sql);
        $success = $stmt->execute();
        error_log("eliminar | Update: " . ($success ? "Éxito" : "Fallo"));
        $conexion = null;
        echo "Pedido eliminado de ruta";
        break;

		case "ver_rutas":
			$pagina = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
			$porPagina = isset($_POST['porPagina']) ? (int)$_POST['porPagina'] : 25;
			$offset = ($pagina - 1) * $porPagina;
		
			error_log("ver_rutas | Página: $pagina | Registros por página: $porPagina");
		
			try {
				$consulta = $conexion->prepare("
    SELECT 
        r.id AS id_ruta,
        r.estado AS estado_ruta,
        r.fecha,
        COUNT(pd.id) AS cantidad_prod,
        GROUP_CONCAT(DISTINCT pd.comuna ORDER BY pd.comuna ASC SEPARATOR ', ') AS comuna,
		        GROUP_CONCAT(CONCAT(pd.modelo, ' - ', pd.comuna) SEPARATOR ' | ') AS resumen_pedidos

    FROM rutas r
    LEFT JOIN pedido_detalle pd ON pd.ruta_asignada = r.id
    GROUP BY r.id, r.estado, r.fecha
    ORDER BY r.fecha DESC
");

				$consulta->execute();
				$datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
		
				$cantidad = count($datos);
				error_log("ver_rutas | Resultados devueltos: $cantidad");
				echo json_encode($datos);
		
			} catch (PDOException $e) {
				error_log("ver_rutas | Error SQL: " . $e->getMessage());
				echo json_encode(["error" => "Error al consultar rutas"]);
			}
		
			unset($conexion);
			break;
		
}
?>
