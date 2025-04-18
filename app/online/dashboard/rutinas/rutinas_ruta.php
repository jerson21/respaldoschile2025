<?php
include "../bd/conexion.php";
$objeto1 = new Conexion();
$conexion = $objeto1->Conectar();

// Obtener los datos enviados por POST
$opcion = $_POST['opcion'];

       

switch ($opcion) {
	case "consultar_ruta":
			// Conectar a la base de datos y obtener los datos de la tabla 1
		// Obtener el valor seleccionado del option select
		$filtro = isset($_POST['rutas']) ? $_POST['rutas'] : '';
		if($filtro == ""){ $filtro = "-1";}  

$consulta = $conexion->prepare("
    SELECT *,p.num_orden, c.nombre, pd.id as id, r.fecha as fecha_ruta,
        (SELECT GROUP_CONCAT(CONCAT(pd_sub.modelo, ' ', pd_sub.tamano, ' ', pd_sub.tipotela, ' ', pd_sub.color, ' ', pd_sub.alturabase) SEPARATOR '%0A')
        FROM pedido_detalle pd_sub
        WHERE pd_sub.num_orden = p.num_orden) AS pedido_completo,
        (SELECT SUM(precio)
        FROM pedido_detalle pd_sub
        WHERE pd_sub.num_orden = p.num_orden group by pd_sub.num_orden) AS total_pago
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



 



		// Devolver los resultados en formato JSON
		echo json_encode($datos);

		  // Cerrar la conexión a la base de datos
		  unset($conexion);


      break;
      case "consultar_pedido":
      $id = $_POST['id'];
      $consulta = $conexion->prepare("SELECT *, p.id as id FROM pedidos p INNER JOIN clientes c on p.rut_cliente = c.rut INNER JOIN rutas r on p.ruta_asignada = r.id  WHERE num_orden = :id ORDER BY p.direccion ASC");
		$consulta->bindParam(":id", $id, PDO::PARAM_INT);
		$consulta->execute();
		$datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

		// Devolver los resultados en formato JSON
		echo json_encode($datos);
		  // Cerrar la conexión a la base de datos
		  unset($conexion);

      break;
  case "consultar_disponibles":
  		// CONSULTAR PEDIDOS DISPONIBLES PARA ASIGNAR A RUTA QUE ESTEN EN FABRICACION O EN PROCESO

      $consulta = $conexion->prepare("SELECT * FROM  pedido p INNER JOIN clientes c on p.rut_cliente = c.rut INNER JOIN pedido_detalle pd ON pd.num_orden = p.num_orden  WHERE pd.ruta_asignada = 0 and pd.estadopedido IN (2,3,4,5,6,9) ORDER BY pd.direccion ASC");
      $consulta->execute();
      $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($datos);
	    // Cerrar la conexión a la base de datos
		unset($conexion);

      break;

   case "consultar_numOrden":
	   	$num_orden = $_POST["orden"];
	   	$consulta = $conexion->prepare("SELECT * FROM pedido p INNER JOIN clientes c on p.rut_cliente = c.rut INNER JOIN pedido_detalle pd ON pd.num_orden = p.num_orden WHERE p.num_orden = $num_orden order by modelo");
	    $consulta->execute();
	    $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
	      echo json_encode($datos);
		    // Cerrar la conexión a la base de datos
			unset($conexion);


      break;

  case "agregar":

	  $id = $_POST["id"];
	  $ruta = $_POST["ruta"];
	  $sql = "UPDATE pedido_detalle SET ruta_asignada = $ruta WHERE id = $id";
	  $stmt = $conexion->prepare($sql);
	  $stmt->execute();
	  // Cerrar la conexión a la base de datos
	  $conexion = null;

	echo "Datos actualizados correctamente";
	    break;
	  case "eliminar":
	  $id = $_POST["id"];
	   $sql = "UPDATE pedido_detalle SET ruta_asignada = 0 WHERE id = $id";
		$stmt = $conexion->prepare($sql);
	  $stmt->execute();
	// Cerrar la conexión a la base de datos
	$conexion = null;

	echo "Pedido eliminado de ruta";
	  // Cerrar la conexión a la base de datos
	  unset($conexion);

	    break;

	    case "ver_rutas":
// Parámetros de paginación (recibidos desde AJAX)
$pagina = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
$porPagina = isset($_POST['porPagina']) ? (int)$_POST['porPagina'] : 25; // Cuántos registros por página

// Validar para evitar valores negativos o cero
if ($pagina < 1) $pagina = 1;
if ($porPagina < 1) $porPagina = 25;

// Calcular el OFFSET para la consulta SQL
$offset = ($pagina - 1) * $porPagina;

	$consulta = $conexion->prepare("SELECT r.id as id_ruta ,r.estado as estado_ruta,r.*,count(pd.id) as cantidad_prod, pd.*, REPLACE(SUBSTRING_INDEX(GROUP_CONCAT(DISTINCT pd.comuna ORDER BY pd.comuna ASC SEPARATOR ','), ',', 6), ',', ', ') as comuna FROM rutas r LEFT JOIN pedido_detalle pd ON pd.ruta_asignada = r.id GROUP BY r.id ORDER BY r.fecha desc");
$consulta->execute();
$datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($datos);

  // Cerrar la conexión a la base de datos
  unset($conexion);

	    break;
 }








?>