<?php include ("online/dashboard/bd/conexion.php");
$objeto = new Conexion();
$conn = $objeto->Conectar();
date_default_timezone_set('America/Santiago');


$opcion = filter_input(INPUT_POST, 'opcion', FILTER_SANITIZE_STRING);
$num_orden = filter_input(INPUT_POST, 'num_orden', FILTER_SANITIZE_STRING);
$criterio = isset($_POST['criterio']) ? filter_input(INPUT_POST, 'criterio', FILTER_SANITIZE_STRING) : '';
$valor = isset($_POST['valor']) ? filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_STRING) : '';
$ruta_asignada = isset($_POST['ruta_asignada']) ? filter_input(INPUT_POST, 'ruta_asignada', FILTER_SANITIZE_STRING) : '';
$rut = isset($_POST['rut']) ? filter_input(INPUT_POST, 'rut', FILTER_SANITIZE_STRING) : '';
$bank = isset($_POST['bank']) ? filter_input(INPUT_POST, 'bank', FILTER_SANITIZE_STRING) : '';
switch ($opcion) {
    case '1':
        $sql1 = "SELECT * FROM pedido_detalle pd INNER JOIN pedido p ON pd.num_orden = p.num_orden WHERE p.num_orden = '$id'";
        $query1 = $conn->query($sql1);

        if ($query1) {
            // Comprueba si hay resultados
            if ($query1->rowCount() > 0) {
                // Crear un array para almacenar los resultados
                $resultados = array();

                // Recorre los resultados y añádelos al array
                while ($row = $query1->fetch(PDO::FETCH_ASSOC)) {
                    $resultados[] = $row;
                }

                // Mostrar resultados (ejemplo simple, puedes formatear como desees)
                foreach ($resultados as $resultado) {
                    echo "Número de Orden: " . $resultado['num_orden'] . "<br>";
                    echo "Producto: " . $resultado['producto'] . "<br>";
                    echo "Cantidad: " . $resultado['cantidad'] . "<br>";
                    echo "Precio: " . $resultado['precio'] . "<br>";
                    // Añade más campos según tu estructura de base de datos
                    echo "<hr>";
                }
            } else {
                echo "No se encontraron resultados para la orden número $id.";
            }
        } else {
            echo "Error en la consulta: " . $stmt2->errorInfo()[2];
        }
        break;
    case 'informacion_cliente':
        $sql2 = "SELECT pd.id_circuit AS circuit_Pedido , r.id_circuit AS circuit_Ruta, rut, direccion, numero,dpto , comuna, telefono, nombre, mododepago, ruta_asignada, confirma, fecha,
        pd.id AS detalle_id, pd.modelo, pd.tamano, pd.tipotela, pd.color, pd.alturabase
 FROM pedido p
 INNER JOIN clientes c ON p.rut_cliente = c.rut
 INNER JOIN pedido_detalle pd ON pd.num_orden = p.num_orden
 INNER JOIN rutas r ON pd.ruta_asignada = r.id
 WHERE p.num_orden = :num_orden";

        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(':num_orden', $num_orden, PDO::PARAM_STR);

        if ($stmt2->execute()) {
            $resultados = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            if (count($resultados) > 0) {
                $cliente = [
                    'rut' => $resultados[0]['rut'],
                    'direccion' => $resultados[0]['direccion'],
                    'numero' => $resultados[0]['numero'],
                    'dpto' => $resultados[0]['dpto'],
                    'comuna' => $resultados[0]['comuna'],
                    'telefono' => $resultados[0]['telefono'],
                    'nombre' => $resultados[0]['nombre'],
                    'mododepago' => $resultados[0]['mododepago'],
                    'ruta_asignada' => $resultados[0]['ruta_asignada'],
                    'confirma' => $resultados[0]['confirma'],
                    'fecha' => $resultados[0]['fecha'],
                    'id_circuitRuta' => $resultados[0]['circuit_Ruta'],
                    'id_circuitPedido' => $resultados[0]['circuit_Pedido']
                ];

                $detalles = [];
                foreach ($resultados as $fila) {
                    $detalles[] = [
                        'id' => $fila['detalle_id'],
                        'modelo' => $fila['modelo'],
                        'tamano' => $fila['tamano'],
                        'tipotela' => $fila['tipotela'],
                        'color' => $fila['color'],
                        'alturabase' => $fila['alturabase']
                    ];
                }

                $response = [
                    'data' => [
                        'cliente' => $cliente,
                        'detalles' => $detalles
                    ],
                    'ok' => true,
                    'message' => ''
                ];
            } else {
                $response = [
                    'ok' => false,
                    'message' => "No se encontró información para la orden número $num_orden."
                ];

            }
        } else {
            $response = [
                'ok' => false,
                'message' => "Error en la consulta: " . $stmt2->errorInfo()[2]
            ];
        }
        break;

    case 'pagos':
        $consulta = "SELECT 
                        po.id AS id,
                        c.id AS id_cartola,
                        po.fecha_mov,
                        COALESCE(c.id, po.id) AS id_mostrar,
                        COALESCE(c.fecha_date) AS fecha,
                        COALESCE(c.rut, '') AS rut, 
                        COALESCE(c.nombre, '') AS nombre,
                        COALESCE(c.banco, '') AS banco,                      
                        COALESCE(c.monto, po.monto) AS monto,
                        COALESCE(c.detalle, '') AS detalle,
                        po.datos_adicionales AS ident_transbank,
                        COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(po.datos_adicionales, '$.identificacion')), ''), JSON_UNQUOTE(JSON_EXTRACT(po.datos_adicionales, '$.authorization_code'))) AS identificacion


      
                    FROM 
                        pagos po
                    LEFT JOIN 
                        cartola_bancaria c ON po.id_cartola = c.id
                    WHERE 
                        po.num_orden = :num_orden
                    ORDER BY 
                        fecha DESC";

        $stmt = $conn->prepare($consulta);
        $stmt->bindParam(':num_orden', $num_orden, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($pagos) {
                $response = [
                    'data' => $pagos,
                    'ok' => true,
                    'message' => ''
                ];
            } else {
                $response['message'] = "No se encontraron pagos para la orden número $num_orden.";
            }
        } else {
            $response['message'] = "Error en la consulta: " . $stmt->errorInfo()[2];
        }
        break;

    case 'confirmar_entrega':
        $sql = "UPDATE pedido_detalle SET confirma= 1 WHERE num_orden = :idpedido AND ruta_asignada = :ruta_asignada";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idpedido', $num_orden, PDO::PARAM_STR);
        $stmt->bindParam(':ruta_asignada', $ruta_asignada, PDO::PARAM_STR);

        $response = [];
        if ($stmt->execute()) {
            $response = [
                'ok' => true,
                'message' => 'La recepción de tu pedido ha sido confirmada.'
            ];
        } else {
            $response = [
                'ok' => false,
                'message' => 'Hubo un problema al confirmar la recepción. Intenta nuevamente.'
            ];
        }
        break;

    case 'obtener_precio_total':
        $consulta = "SELECT 
        p.despacho,  
        COALESCE(SUM(CAST(REPLACE(REPLACE(d.precio, '$', ''), '.', '') AS SIGNED)), 0) AS total_precio,
        COALESCE(pg.total_pagado, 0) AS total_pagado
      FROM 
        pedido p
      INNER JOIN 
        pedido_detalle d ON p.num_orden = d.num_orden
      LEFT JOIN (
        SELECT 
          num_orden, 
          SUM(CAST(REPLACE(REPLACE(monto, '$', ''), '.', '') AS SIGNED)) AS total_pagado
        FROM 
          pagos
        
        GROUP BY 
          num_orden
      ) pg ON p.num_orden = pg.num_orden
      WHERE 
        p.num_orden = :num_orden
      GROUP BY 
        p.num_orden, p.despacho;";

        $stmt3 = $conn->prepare($consulta);
        $stmt3->bindParam(':num_orden', $num_orden, PDO::PARAM_STR);

        if ($stmt3->execute()) {
            if ($stmt3->rowCount() > 0) {
                $result = $stmt3->fetch(PDO::FETCH_ASSOC);
                $result['total_precio'] = $result['total_precio'] + $result['despacho'];

                $response = [
                    'data' => [
                        'total_precio' => $result['total_precio'],
                        'total_pagado' => $result['total_pagado']
                    ],
                    'ok' => true,
                    'message' => ''
                ];
            } else {
                $response['message'] = "No se encontró el total para la orden número $num_orden.";
            }
        } else {
            $response['message'] = "Error en la consulta: " . $stmt3->errorInfo()[2];
        }
        break;



        case 'validacion':

            $ch = curl_init('https://m5hs7lycaonjsw7jvjljgrxneu0eyoog.lambda-url.sa-east-1.on.aws/');
            $todayDate = date('d/m/Y');
            $twoDaysBefore = date('d/m/Y', strtotime('-2 days')); // buscamos desde 2 días antes
        
            $data = array(
                'searchType' => 'dateRange',
                'startDate'   => $twoDaysBefore,
                'endDate'     => $todayDate,
                'targetRut'   => $rut
            );
        
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
            $response = curl_exec($ch);
            if ($response === false) {
                error_log('cURL error: ' . curl_error($ch));
                $response = [
                    'ok'      => false,
                    'message' => "Error al realizar la solicitud: " . curl_error($ch),
                    'error'   => curl_error($ch)
                ];
            } else {
                $responseData = json_decode($response, true);
        
                if (json_last_error() !== JSON_ERROR_NONE) {
                    error_log('Error al decodificar JSON: ' . json_last_error_msg());
                    $response = [
                        'ok'      => false,
                        'message' => "Error al decodificar JSON: " . json_last_error_msg(),
                        'error'   => json_last_error_msg()
                    ];
                } elseif (!isset($responseData['data']) || empty($responseData['data'])) {
                    $response = [
                        'ok'      => false,
                        'message' => 'Validación fallida: No se encontraron datos.',
                        'error'   => $responseData
                    ];
                } else {
        
                    $found = false;       // Indica si se encontró el RUT en la respuesta
                    $newProcessed = false; // Indica si se insertó o actualizó al menos una transferencia pendiente
                    $resultados = [];      // Acumula los datos de cada transferencia procesada
        
                    foreach ($responseData['data'] as $item) {
                        if (isset($item[2]) && $item[2] === $rut) {
                            $found = true;
                            $id_transferencia = $item[1];
                            $rut_transferencia = $item[2];
                            $nombre = $item[3];
                            $banco = $item[4];
                            $numero = $item[5];
                            $monto = $item[6];
                            $fecha = $item[0];
        
                            // Consultar si la transferencia ya existe en la BD
                            $stmt = $conn->prepare("SELECT id, orden_asoc FROM cartola_bancaria WHERE rut = ? AND id = ?");
                            $stmt->execute([$rut, $id_transferencia]);
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            $ordenAsociadaExistente = $result ? $result['orden_asoc'] : null;
                            $idExistente = $result ? $result['id'] : null;
        
                            list($dia, $mes, $año) = explode('/', $fecha);
                            $fecha_formateada = "$año-$mes-$dia"; // Formato 'YYYY-MM-DD'
        
                            if (!$idExistente) {
                                // No existe la transferencia: se inserta
                                $stmt = $conn->prepare("INSERT INTO cartola_bancaria (id, fecha, fecha_date, rut, nombre, banco, numero, monto, detalle, orden_asoc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                if ($stmt->execute([$id_transferencia, $todayDate, $fecha_formateada, $rut_transferencia, $nombre, $banco, $numero, $monto, '', $num_orden])) {
                                    insertarPagos($conn, $num_orden, $id_transferencia, $monto, $banco, $nombre);
                                    $resultados[] = [
                                        'id'         => $id_transferencia,
                                        'fecha'      => $todayDate,
                                        'fecha_date' => $fecha_formateada,
                                        'rut'        => $rut_transferencia,
                                        'nombre'     => $nombre,
                                        'banco'      => $banco,
                                        'numero'     => $numero,
                                        'monto'      => $monto,
                                        'num_orden'  => $num_orden,
                                        'funcion'    => 'insertarPagos'
                                    ];
                                    $newProcessed = true;
                                } else {
                                    error_log("Error al insertar: " . implode(", ", $stmt->errorInfo()));
                                    $resultados[] = [
                                        'error'   => $stmt->errorInfo(),
                                        'message' => "Error al insertar datos para RUT: $rut, ID: $id_transferencia"
                                    ];
                                    $newProcessed = true;
                                }
                            } else {
                                // La transferencia ya existe; si aún no tiene asociado el número de orden, se actualiza
                                if ($ordenAsociadaExistente == 0) {
                                    insertarPagos($conn, $num_orden, $id_transferencia, $monto, $banco, $nombre);
                                    $stmt = $conn->prepare("UPDATE cartola_bancaria SET orden_asoc = ? WHERE id = ? AND rut = ? AND (orden_asoc IS NULL OR orden_asoc = '0')");
                                    if ($stmt->execute([$num_orden, $id_transferencia, $rut])) {
                                        $resultados[] = [
                                            'id'         => $id_transferencia,
                                            'fecha'      => $todayDate,
                                            'fecha_date' => $fecha_formateada,
                                            'rut'        => $rut_transferencia,
                                            'nombre'     => $nombre,
                                            'banco'      => $banco,
                                            'numero'     => $numero,
                                            'monto'      => $monto,
                                            'num_orden'  => $num_orden,
                                            'funcion'    => 'updateCartolaBancaria'
                                        ];
                                        $newProcessed = true;
                                    } else {
                                        error_log("Error al actualizar: " . implode(", ", $stmt->errorInfo()));
                                        $resultados[] = [
                                            'error'   => $stmt->errorInfo(),
                                            'message' => "Error al actualizar número de orden para RUT: $rut, ID: $id_transferencia"
                                        ];
                                        $newProcessed = true;
                                    }
                                }
                                // Si ya tiene número de orden asociado, se omite (ya fue procesada previamente)
                            }
                        }
                    }
        
                    if (!$found) {
                        $response = [
                            'ok'      => false,
                            'message' => 'Validación fallida: RUT no encontrado',
                            'error'   => $responseData
                        ];
                    } elseif (!$newProcessed) {
                        // Se encontró el RUT pero todas las transferencias ya estaban asociadas
                        $response = [
                            'ok'      => false,
                            'message' => "Las transferencias encontradas para este RUT ya han sido procesadas y vinculadas a pedidos existentes.",
                            'codigo'  => 'transferencia_existente',
                            'data'    => ['id' => $id_transferencia]
                        ];
                    } else {
                        // Si se procesó solo una transferencia, se retorna ese registro;
                        // Si se procesaron varias, se agregan (por ejemplo, se suman los montos y se concatenan algunos datos)
                        if (count($resultados) == 1) {
                            $dataResponse = $resultados[0];
                        } else {
                            $totalMonto = 0;
                            $bancos = [];
                            $ruts = [];
                            foreach ($resultados as $res) {
                                $totalMonto += $res['monto'];
                                $bancos[] = $res['banco'];
                                $ruts[]   = $res['rut'];
                            }
                            $dataResponse = [
                                'id'         => $resultados[0]['id'],
                                'fecha'      => $resultados[0]['fecha'],
                                'fecha_date' => $resultados[0]['fecha_date'],
                                'rut'        => implode(', ', array_unique($ruts)),
                                'nombre'     => $resultados[0]['nombre'],
                                'banco'      => implode(', ', array_unique($bancos)),
                                'numero'     => $resultados[0]['numero'],
                                'monto'      => $totalMonto,
                                'num_orden'  => $resultados[0]['num_orden'],
                                'transferencias' => $resultados  // Opcional: detalle de cada transferencia
                            ];
                        }
        
                        $response = [
                            'ok'      => true,
                            'message' => 'Transferencias procesadas correctamente.',
                            'data'    => $dataResponse
                        ];
                    }
                }
            }
       /* 
       // Si la validación fue exitosa, enviar correo de notificación
    if (isset($response['ok']) && $response['ok'] === true) {
        // Incluimos el helper que contiene la función sendEmail
        include_once 'helpers/Helpers.php'; // Ajusta la ruta según tu estructura de proyecto
        
        // Preparamos los datos para el correo. Asegúrate de pasar al menos 'asunto', 'email' y 'emailCopia' según lo requiera la función
        $dataEmailVenta = [
            'asunto' => 'Transferencia Validada Correctamente',
            'email'  => 'jerson.cra@gmail.com',  // Cambia esto al email real del destinatario
            'emailCopia' => 'contacto@respaldoschile.cl',
            'mensaje_adicional' => 'La transferencia para el RUT ' . $rut . ' y Orden ' . $num_orden . ' ha sido validada exitosamente.'
        ];

        sendEmail($dataEmailVenta, "template_validaciontransferencia.php");
    }
        */

    curl_close($ch);
    break;

    
        default:
            echo "Opción no válida.";
            break;
        
        }        

function insertarPagos($conn, $ordenAsoc, $id_transferencia, $monto, $banco, $nombre)
{


    $datos_adicionales = array('banco' => $banco, 'nombre' => $nombre);
    $datos_adicionales_json = json_encode($datos_adicionales);
    $datos_adicionales_json;
    $user = "Cliente";
    $metodo_pago = "Transferencia";

    $fechaIngreso = date("Y-m-d H:i:s"); // Fecha y hora actuales        
    $consultaInsert = "INSERT INTO pagos (num_orden,metodo_pago,id_cartola,datos_adicionales,monto, usuario, fecha_mov) VALUES (:numOrden,:metodo_pago,:idCartola,:datos_adicionales,:monto, :usuario, :fechaIngreso)";

    $stmtInsert = $conn->prepare($consultaInsert);

    // Vincular parámetros para la inserción
    $stmtInsert->bindParam(':numOrden', $ordenAsoc, PDO::PARAM_INT);
    $stmtInsert->bindParam(':metodo_pago', $metodo_pago);
    $stmtInsert->bindParam(':idCartola', $id_transferencia);
    $stmtInsert->bindParam(':datos_adicionales', $datos_adicionales_json);
    $stmtInsert->bindParam(':monto', $monto);
    $stmtInsert->bindParam(':usuario', $user);
    $stmtInsert->bindParam(':fechaIngreso', $fechaIngreso);

    // Ejecutar la consulta de inserción
    if ($stmtInsert->execute()) {
        $resultado = json_encode(["success" => true, "message" => "Inserción realizada con éxito"]);
    } else {
        $resultado = json_encode(["success" => false, "message" => "Error al insertar en pagos_orden"]);
    }
}


header('Content-Type: application/json');
echo json_encode($response);