<?php
date_default_timezone_set('America/Santiago');
include ("../intranet/dashboard/conexion.php");
$opcion = $_GET['opcion'];
$ruta = $_GET['id_ruta'];




header('Content-Type: application/json');  // Asegura que la respuesta siempre sea JSON


switch ($opcion) {
    case "enviar_ruta":



        $strsql = "SELECT pd.*,p.*,r.*,c.*,pd.id as pedido_id,c.nombre FROM pedido_detalle pd INNER JOIN pedido p ON p.num_orden = pd.num_orden INNER JOIN rutas r ON pd.ruta_asignada = r.id LEFT JOIN clientes c On p.rut_cliente = c.rut WHERE pd.ruta_asignada = $ruta GROUP BY p.num_orden";
        $rs = mysqli_query($conn, $strsql);
        $total_rows = $rs->num_rows;
        $data = array();
        $contador = "1";
        $stopDatae = array();

        while ($row = mysqli_fetch_array($rs)) {

            $fecha = $row['fecha'];
            $addressLineOne = $row['direccion'] . " " . $row['numero'] . ", " . $row['comuna'] . ", " . $row['region'];
            $rut = $row['rut_cliente'];
            $telefono = $row['telefono'];
            $nombre = $row['nombre'];
            $sellerOrderId = $row['pedido_id'];
            $num_orden = $row['num_orden'];
            $sellerName = "Vendedor";


            $strsql = "SELECT * from pedido_detalle where num_orden = $num_orden";
            $rse = mysqli_query($conn, $strsql);
            $productos = array();


            while ($row = mysqli_fetch_array($rse)) {
                $productos[] = $row['id'] . " " . $row['modelo'] . " " . $row['tamano'] . " " . $row['tipotela'] . " " . $row['color'];
            }

            $prod = json_encode($productos, JSON_UNESCAPED_UNICODE);
            //echo $prod;




            $stop = array(
                'address' => array('addressLineOne' => $addressLineOne),
                'recipient' => array('externalId' => $rut, 'phone' => $telefono, 'name' => $nombre),
                'orderInfo' => array('products' => $productos, 'sellerOrderId' => $num_orden, 'sellerName' => $sellerName)
            );

            $stopDatae[] = $stop;
        }


        //print_r($data);

        $json_data = array(
            "address" => $stopDatae   // total data array
        );

        $json = json_encode($json_data, JSON_UNESCAPED_UNICODE);

        // Establecer las cabeceras para indicar que se entregará un JSON
//header('Content-Type: application/json');

        if (empty($stopDatae)) {
            echo json_encode(['success' => false, 'message' => 'No data to send.']);
            exit;
        }





        // CREAR RUTA

        // Set the API key
        $apiKey = 'A9nIxx11QA91f9wUufgj';

        $fechaParts = explode("-", $fecha);

        $day = (int) $fechaParts[2];
        $month = (int) $fechaParts[1];
        $year = (int) $fechaParts[0];
        // Plan details
        $planData = array('title' => 'Ruta: ' . $ruta . ' Fecha ' . $fecha, 'starts' => array('day' => $day, 'month' => $month, 'year' => $year));

        // Create the plan
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.getcircuit.com/public/v0.2b/plans',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($planData),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Basic ' . base64_encode($apiKey . ':')
                ),
                CURLOPT_SSL_VERIFYPEER => false, // Indicador "insecure"
            )
        );

        $response = curl_exec($curl);

        if ($response === false) {
            echo 'Error: ' . curl_error($curl);
            exit;
        }

        $plan = json_decode($response, true);
        curl_close($curl);
        if ($response === false) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . curl_error($curl)]);
            exit;
        }
        
        $plan = json_decode($response, true);
        if (isset($plan['id'])) {
            echo json_encode(['success' => true, 'message' => 'Plan created successfully', 'planId' => $plan['id']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create plan']);
            exit;
        }

        

        // Stop details
        $stopData = $stopDatae;

        // Add stops to the plan
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.getcircuit.com/public/v0.2b/' . $plan['id'] . '/stops:import',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_VERBOSE => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($stopData),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Basic ' . base64_encode($apiKey . ':')
                ),
                CURLOPT_SSL_VERIFYPEER => false, // Indicador "insecure"
            )
        );

        $response = curl_exec($curl);

        if ($response === false) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . curl_error($curl)]);
            exit;
        }

        $stops = json_decode($response, true);
        curl_close($curl);
        if (isset($stops['success'])) {
           // echo json_encode(['success' => true, 'message' => 'Stops added successfully', 'stops' => $stops['success']]);
            // echo 'Stops added: ';
            foreach ($stops['success'] as $index => $stopId) {
                $stopDatae[$index]['stopId'] = $stopId;
                $parts = explode('/stops/', $stopId);
                if (count($parts) > 1) {
                    $stopId = $parts[1];  // Extrae solo la parte después de 'stops/'
                    $stopDatae[$index]['stopId'] = $stopId;  // Asignar el ID de parada al array original
                    // echo $stopId . ' for ' . $stopDatae[$index]['orderInfo']['sellerOrderId'] . ' Ruta ' . $ruta . '<br>';
                }

                // Escapar las variables para seguridad
                $stopID_escaped = mysqli_real_escape_string($conn, $stopId);
                $num_orden = mysqli_real_escape_string($conn, $stopDatae[$index]['orderInfo']['sellerOrderId']);
                $ruta_asignada = mysqli_real_escape_string($conn, $ruta);


                // Consulta SQL para actualizar el pedido_detalle
                $updateQuery = "UPDATE pedido_detalle SET id_circuit = '$stopID_escaped' WHERE num_orden = '$num_orden' AND ruta_asignada = '$ruta_asignada'";

                if (mysqli_query($conn, $updateQuery)) {
                   // echo json_encode(['success' => false, 'message' => 'Registro actualizado correctamente.']);

                  //  echo "Registro actualizado correctamente";
                } else {
                   // echo "Error al actualizar el registro: " . mysqli_error($conn);
                }

                // Cerrar la conexión de la base de datos si ya no es necesaria


            }

            $partsa = explode('plans/', $plan['id']);
            if (count($partsa) > 1) {
                $planID = $partsa[1];  // Extrae solo la parte después de 'stops/'

            }


            $updateQuery2 = "UPDATE rutas SET id_circuit = '$planID' WHERE id = '$ruta'";

            if (mysqli_query($conn, $updateQuery2)) {
              //  echo "Registro de ruta actualizado correctamente" . $planID;
            } else {
                // echo "Error al actualizar el registro de ruta : " . mysqli_error($conn);
            }


            mysqli_close($conn);
        }
        break;

    case "consultar_position":
        $successful = true;
        // Asegurarte de que $ruta está definida y es segura para usar en una consulta
        $ruta_escaped = mysqli_real_escape_string($conn, $ruta);

        // Preparar la consulta SQL para evitar inyecciones SQL
        $query = "SELECT id_circuit FROM rutas WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $query)) {
            // Vincular el parámetro al statement preparado
            mysqli_stmt_bind_param($stmt, "i", $ruta_escaped);

            // Ejecutar la consulta preparada
            mysqli_stmt_execute($stmt);

            // Vincular el resultado de la consulta a una variable
            mysqli_stmt_bind_result($stmt, $id_circuit);

            // Obtener el resultado
            if (mysqli_stmt_fetch($stmt)) {
                //echo "El valor de id_circuit es: $id_circuit";
                $planId = $id_circuit;
            } else {
               // echo "No se encontró un id_circuit con el id de ruta proporcionado.";
                $successful = false;
                $mensaje = "No se encontró un id_circuit con el id de ruta proporcionado";
                exit;
            }

            // Cerrar el statement
            mysqli_stmt_close($stmt);
        } else {
          //  echo "Error preparando la consulta: " . mysqli_error($conn);
        }


        //$planId = $plan['id'];
        //$planId = "YrPJ9WCtvpV5IPXoCDvN";
        $apiKey = 'A9nIxx11QA91f9wUufgj';

        /// URL para obtener los stops del plan
        $baseUrl = 'https://api.getcircuit.com/public/v0.2b/plans/' . $planId . '/stops';


        function fetchStops($url, $apiKey)
        {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Basic ' . base64_encode($apiKey . ':')
                ),
                CURLOPT_SSL_VERIFYPEER => false,
            )
            );
            $response = curl_exec($curl);
            if ($response === false) {
                echo 'Error: ' . curl_error($curl);
                
                curl_close($curl);
                exit;
            }
            curl_close($curl);
            return json_decode($response, true);
        }

        $url = $baseUrl;
        $allStops = [];

        do {
            $response = fetchStops($url, $apiKey);
            if (isset($response['stops'])) {
                foreach ($response['stops'] as $stop) {
                    $allStops[] = $stop;
                }
            }
            // Prepara la URL para la próxima página si hay un nextPageToken
            $url = isset($response['nextPageToken']) ? $baseUrl . '?pageToken=' . $response['nextPageToken'] : null;
        } while ($url !== null);

        // Ordena todas las paradas por 'Stop Position'
        usort($allStops, function ($a, $b) {
            return $a['stopPosition'] <=> $b['stopPosition'];
        });

        // Procesa las paradas ordenadas
        $paradasPorOrden = [];
        foreach ($allStops as $stop) {
            $stopId = explode('/stops/', $stop['id'])[1];
            $direccionParada = $stop['address']['addressLineOne'];
            $posicionParada = $stop['stopPosition'];

            $paradasPorOrden[$stopId] = [
                'direccionParada' => $direccionParada,
                'posicionParada' => $posicionParada
            ];
        }

        $ordenProducto = 1;  // Inicia el contador de orden de productos
        foreach ($paradasPorOrden as $stopId => $infoParada) {
            $direccionParada = $infoParada['direccionParada'];
           // echo "Procesando parada: $stopId con dirección $direccionParada<br>";

            // Consulta todos los productos que van a esta dirección
            $consultaProductos = "SELECT id FROM pedido_detalle WHERE id_circuit = '$stopId' ORDER BY id ASC";
            $resultProductos = mysqli_query($conn, $consultaProductos);

            while ($producto = mysqli_fetch_assoc($resultProductos)) {
                $productoId = $producto['id'];

                // Actualiza cada producto con su orden global
                $updateQuery = "UPDATE pedido_detalle SET orden_ruta = '$ordenProducto' WHERE id = '$productoId'";
                if (mysqli_query($conn, $updateQuery)) {
                 //   echo "Producto $productoId actualizado con orden $ordenProducto en parada $stopId<br>";
                } else {
                  //  echo "Error al actualizar el producto $productoId: " . mysqli_error($conn) . "<br>";
                  $successful = false;
                  $mensaje = "Error al actualizar el producto $productoId: " . mysqli_error($conn) . "<br>";
                }

                $ordenProducto++;  // Incrementa el orden para el próximo producto en la ruta
            }
        }





        // Cierra cURL
        curl_close($curl);
          // Si todo el proceso es exitoso
    if ($successful) {
        echo json_encode(['success' => true, 'message' => 'Proceso completado exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => $mensaje]);
    }
        break;
}


