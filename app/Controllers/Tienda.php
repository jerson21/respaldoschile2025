<?php
require_once ("Models/TCategoria.php");
require_once ("Models/TProducto.php");
require_once ("Models/TCliente.php");
require_once ("Models/LoginModel.php");

class Tienda extends Controllers
{
	use TCategoria, TProducto, TCliente;
	public $login;
	public function __construct()
	{
		parent::__construct();

		session_start();

		$this->login = new LoginModel();
	}

	public function tienda()
	{
		$data['page_tag'] = NOMBRE_EMPESA;
		$data['page_title'] = NOMBRE_EMPESA;
		$data['page_name'] = "tienda";
		//$data['productos'] = $this->getProductosT();
		$pagina = 1;
		$cantProductos = $this->cantProductos();
		$total_registro = $cantProductos['total_registro'];
		$desde = ($pagina - 1) * PROPORPAGINA;
		$total_paginas = ceil($total_registro / PROPORPAGINA);
		$data['productos'] = $this->getProductosPage($desde, PROPORPAGINA);
		$data['productos_descuentos'] = $this->getProductosPage($desde, PROPORPAGINA);
		//dep($data['productos']);exit;
		$data['pagina'] = $pagina;
		$data['total_paginas'] = $total_paginas;
		$data['categorias'] = $this->getCategorias();
		$data['slider'] = $this->getCategoriasT(CAT_SLIDER);
		$data['banner'] = $this->getCategoriasT(CAT_BANNER);
		$this->views->getView($this, "tienda", $data);
	}



	public function categoria($params)
	{
		if (empty($params)) {
			header("Location:" . base_url());
		} else {

			$arrParams = explode(",", $params);
			$idcategoria = intval($arrParams[0]);
			$ruta = strClean($arrParams[1]);
			$pagina = 1;
			if (count($arrParams) > 2 and is_numeric($arrParams[2])) {
				$pagina = $arrParams[2];
			}

			$cantProductos = $this->cantProductos($idcategoria);
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina - 1) * PROCATEGORIA;
			$total_paginas = ceil($total_registro / PROCATEGORIA);
			$infoCategoria = $this->getProductosCategoriaT($idcategoria, $ruta, $desde, PROCATEGORIA);
			$categoria = strClean($params);
			$data['page_tag'] = NOMBRE_EMPESA . " - " . $infoCategoria['categoria'];
			$data['page_title'] = $infoCategoria['categoria'];
			$data['page_name'] = "categoria";
			$data['productos'] = $infoCategoria['productos'];
			$data['infoCategoria'] = $infoCategoria;
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['categorias'] = $this->getCategorias();
			$this->views->getView($this, "categoria", $data);
		}
	}



	public function producto($params)
	{
		if (empty($params)) {
			header("Location:" . base_url());
		} else {
			$arrParams = explode(",", $params);
			$idproducto = intval($arrParams[0]);
			$ruta = strClean($arrParams[1]);
			$infoProducto = $this->getProductoT($idproducto, $ruta);
			if (empty($infoProducto)) {
				header("Location:" . base_url());
			}
			$data['page_tag'] = NOMBRE_EMPESA . " - " . $infoProducto['nombre'];
			$data['page_title'] = $infoProducto['nombre'];
			$data['page_name'] = "producto";
			$data['tipo_prod'] = $infoProducto['tipo_prod'];
			$data['producto'] = $infoProducto;
			$data['productos'] = $this->getProductosRandom($infoProducto['categoriaid'], 8, "r");
			$data['color'] = $this->getColores();
			$data['colores_prod'] = $this->getColoresProducto($idproducto);
			$data['tamano'] = $this->getTamanos($idproducto);
			$data['tipo_tela'] = $this->getTelas($idproducto);
			$data['altura_base'] = $this->getAlturas($idproducto);
			$data['categorias'] = $this->getCategorias();
			$this->views->getView($this, "producto", $data);
		}
	}


	public function addCarrito()
	{
		if ($_POST) {


			//unset($_SESSION['arrCarrito']);exit;
			$arrCarrito = array();
			$cantCarrito = 0;
			$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
			$stock = $_POST['stock'];
			$cantidad = $_POST['cant'];
			$color = $_POST['color'];
			$tamano = $_POST['tamano'];
			$precio_tamano = $_POST['precio_tamano'];
			$tipo_tela = $_POST['tipo_tela'];
			$altura_base = $_POST['altura_base'];
			if ($_POST['precio_alturabase'] != 'undefined') {
				$precio_alturabase = $_POST['precio_alturabase'];
			} else {
				$precio_alturabase = 0;
			}



			$arrInfoProducto = $this->getProductoIDT($idproducto);
			if ($arrInfoProducto['tipo_prod'] == "1") {
				$precio_total = $arrInfoProducto['precio'];
			} else {
				$precio_total = $precio_tamano + $precio_alturabase;
			}

			if (is_numeric($idproducto) and is_numeric($cantidad)) {
				$arrInfoProducto = $this->getProductoIDT($idproducto);
				if (!empty($arrInfoProducto)) {
					$arrProducto = array(
						'idproducto' => $idproducto,
						'producto' => $arrInfoProducto['nombre'],
						'cantidad' => $cantidad,
						'precio' => $precio_total, //aqui hay que cambiar el precio segun tamaño
						'imagen' => $arrInfoProducto['images'][0]['url_image'],
						'color' => $color,
						'precio_alturabase' => $precio_alturabase,
						'tamano' => $tamano,
						'stock' => $arrInfoProducto['stock'],
						'tipo_tela' => $tipo_tela,
						'altura_base' => $altura_base
					);
					$cantidadr = 0;



					if (isset($_SESSION['arrCarrito']) && $arrProducto['stock'] > $cantidadr) {
						$on = true;
						$mensaje = 0;
						$arrCarrito = $_SESSION['arrCarrito'];
						$cantidads = 0;





						for ($pr = 0; $pr < count($arrCarrito); $pr++) {
							if ($arrCarrito[$pr]['idproducto'] == $idproducto && $arrCarrito[$pr]['color'] == $color && $arrCarrito[$pr]['tamano'] == $tamano && $arrCarrito[$pr]['precio_alturabase'] == $precio_alturabase) {


								// SI LA CANTIDAD AGREGADA EN EL CARRITO ES MAYOR AL STOCK EN PAGINA NO AGREGA.


								if ($arrProducto['stock'] > $arrCarrito[$pr]['cantidad']) {
									$arrCarrito[$pr]['cantidad'] += $cantidad;

									$mensaje = 2;
									$mens = 'Supera el stock0.' . $arrCarrito[$pr]['cantidad'];
								} else {

									$mensaje = 1;
									$mens = 'Supera el stock1.';
								}


								$on = false;
							}
						}
						if ($on) {
							array_push($arrCarrito, $arrProducto);
						}
						$_SESSION['arrCarrito'] = $arrCarrito;
					} else {
						array_push($arrCarrito, $arrProducto);

						$_SESSION['arrCarrito'] = $arrCarrito;
						$mensaje = 2;
						$mens = 'Supera el stock2.';
					}





					foreach ($_SESSION['arrCarrito'] as $pro) {
						$cantCarrito = $pro['cantidad'];
					}



					$htmlCarrito = "";

					if ($mensaje == 1) {
						$arrResponse = array("status" => false, "msg" => $mens);
					} else {
						$htmlCarrito = getFile('Template/Modals/modalCarrito', $_SESSION['arrCarrito']);
						$arrResponse = array(
							"status" => true,
							"msg" => '¡Se agrego al carrito!',
							"cantCarrito" => $cantCarrito,
							"color" => $color,
							"tamano" => $tamano,
							'tipo_tela' => $tipo_tela,
							'altura_base' => $altura_base,
							'precio_alturabase' => $precio_alturabase,
							"htmlCarrito" => $htmlCarrito
						);
					}
				} else {
					$arrResponse = array("status" => false, "msg" => 'Producto no existente.');
				}
			} else {
				$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delCarrito()
	{
		if ($_POST) {
			$arrCarrito = array();
			$cantCarrito = 0;
			$subtotal = 0;
			$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
			$option = $_POST['option'];
			if (is_numeric($idproducto) and ($option == 1 or $option == 2)) {
				$arrCarrito = $_SESSION['arrCarrito'];
				for ($pr = 0; $pr < count($arrCarrito); $pr++) {
					if ($arrCarrito[$pr]['idproducto'] == $idproducto) {
						unset($arrCarrito[$pr]);
					}
				}
				sort($arrCarrito);
				$_SESSION['arrCarrito'] = $arrCarrito;
				foreach ($_SESSION['arrCarrito'] as $pro) {
					$cantCarrito += $pro['cantidad'];
					$subtotal += $pro['cantidad'] * $pro['precio'];
				}
				$htmlCarrito = "";
				if ($option == 1) {
					$htmlCarrito = getFile('Template/Modals/modalCarrito', $_SESSION['arrCarrito']);
				}
				$arrResponse = array(
					"status" => true,
					"msg" => '¡Producto eliminado!',
					"cantCarrito" => $cantCarrito,
					"htmlCarrito" => $htmlCarrito,
					"subTotal" => SMONEY . formatMoney($subtotal),
					"total" => SMONEY . formatMoney($subtotal + COSTOENVIO)
				);
			} else {
				$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}


	public function updCarrito()
	{
		if ($_POST) {
			$arrCarrito = array();
			$totalProducto = 0;
			$subtotal = 0;
			$total = 0;
			$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
			$cantidad = intval($_POST['cantidad']);
			if (is_numeric($idproducto) and $cantidad > 0) {
				$arrCarrito = $_SESSION['arrCarrito'];
				for ($p = 0; $p < count($arrCarrito); $p++) {
					$arrInfoProducto = $this->getProductoIDT($idproducto);
					$stock = $arrInfoProducto['stock'];

					if ($arrCarrito[$p]['idproducto'] == $idproducto) {
						$arrCarrito[$p]['cantidad'] = $cantidad;
						$totalProducto = $arrCarrito[$p]['precio'] * $cantidad;
						break;
					}
				}
				$_SESSION['arrCarrito'] = $arrCarrito;
				foreach ($_SESSION['arrCarrito'] as $pro) {
					$subtotal += $pro['cantidad'] * $pro['precio'];
				}
				$arrResponse = array(
					"status" => true,
					"msg" => '¡Producto actualizado!',
					"totalProducto" => SMONEY . formatMoney($totalProducto),
					"subTotal" => SMONEY . formatMoney($subtotal),
					"total" => SMONEY . formatMoney($subtotal + COSTOENVIO)
				);
			} else {
				$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}


	public function registro()
	{
		//error_reporting(0);
		if ($_POST) {
			if (empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmailCliente'])) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$strApellido = ucwords(strClean($_POST['txtApellido']));
				$intTelefono = intval(strClean($_POST['txtTelefono']));
				$strEmail = strtolower(strClean($_POST['txtEmailCliente']));
				$rut = strtolower(strClean($_POST['txtRut']));
				$intTipoId = RCLIENTES;
				$request_user = "";

				$strPassword = passGenerator();
				$strPasswordEncript = hash("SHA256", $strPassword);
				$request_user = $this->insertCliente(
					$strNombre,
					$strApellido,
					$intTelefono,
					$rut,
					$strEmail,
					$strPasswordEncript,
					$intTipoId
				);
				if ($request_user > 0) {
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					$nombreUsuario = $strNombre . ' ' . $strApellido;
					$dataUsuario = array(
						'nombreUsuario' => $nombreUsuario,
						'email' => $strEmail,
						'password' => $strPassword,
						'rut' => $rut,
						'asunto' => 'Bienvenido a tu tienda en línea'
					);
					$_SESSION['idUser'] = $request_user;
					$_SESSION['login'] = true;
					$this->login->sessionLogin($request_user);
					sendEmail($dataUsuario, 'email_bienvenida');
				} else if ($request_user === 'exist') {
					$arrResponse = array('status' => false, 'msg' => '¡Atención! el rut ya existe, ingrese a su cuenta.');
				} else {
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function agregarDireccion()
	{
		if ($_POST) {

			$personaid = $_SESSION['userData']['identificacion'];


			$direccion = strClean($_POST['direccion']);
			$dirNumero = strClean($_POST['dirNumero']);
			$dirDepto = strClean($_POST['dirDepto']);
			$dirRegion = strClean($_POST['dirRegion']);
			$dirComuna = strClean($_POST['dirComuna']);
			$instrucciones = strClean($_POST['instrucciones']);

			$agregar = $this->insertDireccion($personaid, $direccion, $dirNumero, $dirDepto, $dirRegion, $dirComuna, $instrucciones);


			if ($agregar > 0) {
				$arrResponse = array('status' => true, 'msg' => "Direccion Agregada.");
			} else {
				$arrResponse = array('status' => false, 'msg' => "Direccion no agregada.");
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
	}

	public function consultarDir($rut)
	{

		$personaid = $_SESSION['userData']['identificacion'];

		$agregar = $this->getDir($personaid);


		if ($agregar > 0) {
			$arrResponse = array('status' => true, 'msg' => "Direccion Agregada.");
		} else {
			$arrResponse = array('status' => false, 'msg' => "Direccion no agregada.");
		}
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
	}


	public function cons_precioDir()
	{



		$personaidrut = $_SESSION['userData']['identificacion'];
		if ($_POST) {
			$comuna = strClean($_POST['comuna']);
			$direccion = $this->getDir($personaidrut, $comuna);

			foreach ($direccion as $direccion) {
				$comuna = $direccion['comuna'];
				$direccion = $direccion['direccion'];
			}

			$request_pedido = $this->getPrecioEnvio($comuna);

			if ($request_pedido != '') {

				$_SESSION['precio_envio'] = array('precio' => $request_pedido);
				$arrResponse = array('precio' => $request_pedido);
				//Enviar correo					
			} else {
				$arrResponse = array('precio' => "1", 'envio_loc' => "region");
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
	}

	public function consultarTotal()
	{
		$preciodescuento = 0;
		$subtotal = 0;
		$nombrecupon = "";
		$subtotal = 0;

		$coddescuento = $_POST['coddescuento'];






		$request_consultaa = $this->getPrecioDescuento($coddescuento);

		if (!empty($request_consultaa)) {

			$_SESSION['descuento'] = array('descuento' => $request_consultaa, 'nombre' => $request_consultaa);

			foreach ($_SESSION['descuento'] as $ar) {
				$preciodescuento = $ar['descuento'];
				$nombrecupon = $ar['nombre'];
			}
		} else {
			$preciodescuento = "0";
		}



		foreach ($_SESSION['precio_envio'] as $producto) {
			$costo_envio = $producto['precio'];
		}

		foreach ($_SESSION['arrCarrito'] as $pro) {
			$subtotal += $pro['cantidad'] * $pro['precio'];
		}


		$_SESSION['descuento'] = $preciodescuento;
		$subtotal = $costo_envio + $subtotal - $preciodescuento;

		$arrResponse = array("subtotales" => $subtotal, "preciodescuento" => $preciodescuento, "msg" => 'Descuento Aplicado.', "nombrecupon" => $nombrecupon);
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
		// code...
	}





	public function procesarVenta()
{
    // Verificamos que se reciba una petición POST
    if ($_POST) {

        // Si se reciben variables específicas de Transbank (pago en línea)
        if (isset($_POST['status_transbank']) && isset($_POST['payment_type_code']) && isset($_POST['buy_order']) && isset($_POST['token_ws'])) {
            $status_transbank = $_POST['status_transbank'];
            $tipodepago = $_POST['inttipopago'];
            $buy_order = $_POST['buy_order'];
            $token_ws = $_POST['token_ws'];
            $tarjeta = $_POST['card_detail'];
            $fecha_transaccion = $_POST['fecha_transaccion'];
            $authorization_code = $_POST['authorization_code'];
            // Se usa la variable $authorization_code para asignarla a $idtransaccionpaypal
            $idtransaccionpaypal = $authorization_code;
        }

        // Variable para datos de PayPal (no se utiliza en este fragmento)
        $datospaypal = NULL;
        // Obtenemos el ID del usuario de la sesión
        $personaid = $_SESSION['idUser'];
        $monto = 0; // Inicializamos el monto total

        // Obtenemos el tipo de pago como entero
        $tipopagoid = intval($_POST['inttipopago']);
        // Obtenemos la dirección seleccionada del usuario, almacenada en la sesión
        $iddireccionselect = $_SESSION['iddireccion'];
        if (empty($_POST['iddireccionselect'])) {
            header("Location:" . base_url());
        }

        // Obtenemos el RUT o identificador del cliente desde la sesión
        $personaidrut = $_SESSION['userData']['identificacion'];

        /* 
         * Obtenemos la dirección de envío:
         * - Si la dirección seleccionada es "retiro", se obtiene una dirección por defecto (ID "1").
         * - De lo contrario, se consulta la dirección del cliente usando su RUT y el ID de dirección seleccionado.
         */
        if ($iddireccionselect == "retiro") {
            $direccion = $this->getDir("1", $iddireccionselect);
        } else {
            $direccion = $this->getDir($personaidrut, $iddireccionselect);
        }

        // Construir la cadena de dirección de envío y obtener la referencia (si existe)
        foreach ($direccion as $direccion) {
            $direccionenvio = $direccion['direccion'] . ', ' . $direccion['numero'] . ', ' . $direccion['dpto'] . ', ' . $direccion['region'] . ', ' . $direccion['comuna'];
            $referencia = $direccion['referencia'] ?? "";
        }

        // Si se selecciona "retiro" (pickup en tienda), se asigna la cadena correspondiente
        if ($iddireccionselect == "retiro") {
            $direccionenvio = "Retiro en local";
            $referencia = "";
        }

        // Establecemos el estado inicial del pedido
        $status = "Pendiente"; // Se mantendrá pendiente si es transferencia o pago en efectivo
        $subtotal = 0;
        $descuento = 0;
        $costo_envio = 0;

        // Se extrae el costo de envío almacenado en la sesión
        foreach ($_SESSION['precio_envio'] as $producto) {
            $costo_envio = $producto['precio'];
        }

        // Si existe un descuento almacenado en sesión, se asigna su valor
        if (!empty($_SESSION['descuento'])) {
            $descuento = $_SESSION['descuento'];
        }

        // Calculamos el subtotal multiplicando la cantidad por el precio de cada producto en el carrito
        if (!empty($_SESSION['arrCarrito'])) {
            foreach ($_SESSION['arrCarrito'] as $pro) {
                $subtotal += $pro['cantidad'] * $pro['precio'];
            }

            // Calculamos el monto total: subtotal + costo de envío - descuento
            $monto = $subtotal + $costo_envio - $descuento;

            // Verificamos que la cantidad solicitada no supere el stock disponible
            $sobrestock = 0;
            if (!empty($_SESSION['arrCarrito'])) {
                foreach ($_SESSION['arrCarrito'] as $pro) {
                    $nom_sobrestock = "";
                    $arrInfoProducto = $this->getProductoIDT($pro['idproducto']);
                    $stock = $arrInfoProducto['stock'];
                    $nombre = $arrInfoProducto['nombre'];
                    $cantidad = $pro['cantidad'];

                    // Si la cantidad del carrito es mayor al stock, se incrementa el contador de sobrestock
                    if ($pro['cantidad'] > $stock) {
                        $sobrestock++;
                        $nom_sobrestock .= "\n\n" . $arrInfoProducto['nombre'];
                    }
                }
            }

            // Si algún producto supera el stock disponible, se devuelve un mensaje de error
            if ($sobrestock > 0) {
                $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido, uno de los productos bajo su stock disponible. Vuelva al carrito para revisar el detalle');
                // En caso de error, podría guardarse el token de la venta en la base de datos
            } else {

                /* Función para enviar una solicitud POST a una API externa */
                function sendPostRequest($url, $data)
                {
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                    $response = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    if ($response === false || $httpCode !== 200) {
                        // Registro de error
                        logMessage("Error al enviar la solicitud a $url con datos: " . print_r($data, true) . " HTTP Code: $httpCode Error: " . curl_error($ch));
                    } else {
                        // Registro de éxito
                        logMessage("Solicitud exitosa a $url con datos: " . print_r($data, true) . " Respuesta: $response");
                    }

                    curl_close($ch);
                    return $response;
                }

                /* Función para registrar mensajes en un archivo de log */
                function logMessage($message)
                {
                    $logFile = 'log.txt';
                    if ($fileHandle = fopen($logFile, 'a')) {
                        $timestamp = date('Y-m-d H:i:s');
                        $logEntry = "[$timestamp] $message\n";
                        fwrite($fileHandle, $logEntry);
                        fclose($fileHandle);
                    } else {
                        error_log("No se pudo abrir el archivo de log ($logFile) para escribir.");
                    }
                }

                // ------------------------------
                // Procesamiento para Pago por Transferencia
                // ------------------------------
                if (empty($_POST['status_transbank'])) {

                    // Se entiende que se trata de una transferencia
                    $status = "Pendiente";

                    // Se crea el pedido en la base de datos
                    $request_pedido = $this->insertPedido(
                        "null",
                        "",
                        $personaid,
                        $costo_envio,
                        $monto,
                        $descuento,
                        $tipopagoid,
                        $direccionenvio,
                        $referencia,
                        $status
                    );

                    // Se obtienen datos adicionales del cliente
                    $rut_cliente = $this->getRutCliente($personaid);
                    $direccion_cliente = $this->getDireccionCliente($request_pedido);
                    $info_cliente = $this->getClienteInfo($personaid);
                    $rut_cliente = $info_cliente['rut'];
                    $nombre_cliente = $info_cliente['nombres'];
                    $apellido_cliente = $info_cliente['apellidos'];
                    $telefono_cliente = $info_cliente['telefono'];
                    $correo_cliente = $info_cliente['email_user'];

                    // Preparar datos para enviar a la API externa (por ejemplo, para sincronización)
                    $cliente_data = array(
                        'action' => 'insertCliente',
                        'rut' => $rut_cliente,
                        'nombre' => $nombre_cliente,
                        'apellido' => $apellido_cliente,
                        'telefono' => $telefono_cliente,
                        'correo' => $correo_cliente
                    );

                    sendPostRequest('https://respaldoschile.cl/online/insert_ecommerce_pedido.php', $cliente_data);

                    // Determinar el método de entrega en base a la dirección
                    $metodo_entrega = ($direccion_cliente['direccion'] == 'Retiro en local') ? 'Retiro en tienda' : 'Despacho';

                    // Preparar datos del pedido para enviar a la API externa
                    $pedido_data = array(
                        'action' => 'insertPedido',
                        'rut_cliente' => $rut_cliente,
                        'fecha_ingreso' => date('Y-m-d H:i:s'),
                        'despacho' => $costo_envio,
                        'total_pagado' => $monto,
                        'vendedor' => 'PAGINAWEB',
                        'metodo_entrega' => $metodo_entrega,
                        'estado' => $status,
                        'orden_ext' => $request_pedido
                    );

                    sendPostRequest('https://respaldoschile.cl/online/insert_ecommerce_pedido.php', $pedido_data);

                    // Si se ha creado el pedido correctamente
                    if ($request_pedido > 0) {
                        // Insertar el detalle de cada producto en el pedido
                        foreach ($_SESSION['arrCarrito'] as $producto) {
                            $productoid = $producto['idproducto'];
                            $precio = $producto['precio'];
                            $cantidad = $producto['cantidad'];
                            $color = $producto['color'];
                            $tamano = $producto['tamano'];
                            $tipo_tela = $producto['tipo_tela'];
                            $altura_base = $producto['altura_base'];

                            $nombre_producto = $this->getNombreProducto($productoid);

                            // Inserta el detalle en la base de datos
                            $this->insertDetalle($request_pedido, $productoid, $tamano, $color, $tipo_tela, $altura_base, $precio, $cantidad);

                            // Preparar datos para enviar el detalle a la API externa
                            $detalle_data = array(
                                'action' => 'insertDetalle',
                                'pedidoid' => $request_pedido,
                                'nombre_producto' => $nombre_producto,
                                'tamano' => $tamano,
                                'color' => $color,
                                'tipo_tela' => $tipo_tela,
                                'altura_base' => $altura_base,
                                'precio' => $precio,
                                'cantidad' => $cantidad,
                                'mododepoago' => 'Transferencia',
                                'direccion' => $direccion_cliente['direccion'],
                                'numero' => $direccion_cliente['numero'],
                                'dpto' => $direccion_cliente['dpto'],
                                'metodo_entrega' => $metodo_entrega,
                                'detalle_entrega' => $direccion_cliente['referencia'],
                                'region' => $direccion_cliente['region'],
                                'comuna' => $direccion_cliente['comuna']
                            );

                            sendPostRequest('https://respaldoschile.cl/online/insert_ecommerce_pedido.php', $detalle_data);
                        }

                        // Obtener información completa del pedido para notificaciones
                        $infoOrden = $this->getPedido($request_pedido);

                        // Preparar y enviar correo de confirmación al cliente
                        $dataEmailOrden = array(
                            'asunto' => "Se ha creado la orden No." . $request_pedido,
                            'email' => $_SESSION['userData']['email_user'],
                            'emailCopia' => EMAIL_PEDIDOS,
                            'pedido' => $infoOrden
                        );
                        sendEmail($dataEmailOrden, "email_notificacion_orden");

                        // Preparar y enviar notificación interna a administración/ventas
                        $dataEmailVenta = array(
                            'asunto' => "Notificación de Nueva Venta " . $request_pedido,
                            'email' => 'jerson.sg21@gmail.com',
                            'pedido' => $infoOrden
                        );
                        sendEmail($dataEmailVenta, "template_notificacion_venta");

                        // Encriptar el ID del pedido y preparar la respuesta
                        $orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
                        $arrResponse = array(
                            "status" => true,
                            "orden" => $orden,
                            "monto_total" => $monto,
                            "transaccion" => "0",
                            "status_transbank" => "",
                            "fecha_transaccion" => date('Y-m-d H:i:s'),
                            "buy_order" => "",
                            "token_ws" => "",
                            "tarjeta" => "",
                            "tipodepago" => $tipopagoid,
                            "msg" => 'Pedido realizado'
                        );
                        // Guardar información del pedido en la sesión para la vista de confirmación
                        $_SESSION['dataorden'] = $arrResponse;
                        unset($_SESSION['precio_envio']);
                        unset($_SESSION['arrCarrito']);
                        session_regenerate_id(true);
                    }
                } else {
                    // ------------------------------
                    // Procesamiento para Pago con Webpay (Transbank)
                    // ------------------------------
                    $status = "Aprobado";
                    if ($status_transbank == "AUTHORIZED") {

                        // Crear el pedido en la base de datos con datos de Transbank
                        $request_pedido = $this->insertPedido(
                            $idtransaccionpaypal,
                            $token_ws,
                            $personaid,
                            $costo_envio,
                            $monto,
                            $descuento,
                            $tipodepago,
                            $direccionenvio,
                            $referencia,
                            $status
                        );

                        // Obtener datos del cliente
                        $rut_cliente = $this->getRutCliente($personaid);
                        $direccion_cliente = $this->getDireccionCliente($request_pedido);
                        $info_cliente = $this->getClienteInfo($personaid);
                        $rut_cliente = $info_cliente['rut'];
                        $nombre_cliente = $info_cliente['nombres'];
                        $apellido_cliente = $info_cliente['apellidos'];
                        $telefono_cliente = $info_cliente['telefono'];
                        $correo_cliente = $info_cliente['email_user'];

                        $cliente_data = array(
                            'action' => 'insertCliente',
                            'rut' => $rut_cliente,
                            'nombre' => $nombre_cliente,
                            'apellido' => $apellido_cliente,
                            'telefono' => $telefono_cliente,
                            'correo' => $correo_cliente
                        );

                        sendPostRequest('https://respaldoschile.cl/online/insert_ecommerce_pedido.php', $cliente_data);

                        $metodo_entrega = ($direccion_cliente['direccion'] == 'Retiro en local') ? 'Retiro en tienda' : 'Despacho';

                        $pedido_data = array(
                            'action' => 'insertPedido',
                            'rut_cliente' => $rut_cliente,
                            'fecha_ingreso' => date('Y-m-d H:i:s'),
                            'despacho' => $costo_envio,
                            'total_pagado' => $monto,
                            'vendedor' => 'PAGINAWEB',
                            'metodo_entrega' => $metodo_entrega,
                            'estado' => $status,
                            'orden_ext' => $request_pedido
                        );

                        sendPostRequest('https://respaldoschile.cl/online/insert_ecommerce_pedido.php', $pedido_data);

                        if ($request_pedido > 0) {
                            // Insertar el detalle de cada producto en el pedido
                            foreach ($_SESSION['arrCarrito'] as $producto) {
                                $productoid = $producto['idproducto'];
                                $precio = $producto['precio'];
                                $cantidad = $producto['cantidad'];
                                $color = $producto['color'];
                                $tamano = $producto['tamano'];
                                $tipo_tela = $producto['tipo_tela'];
                                $altura_base = $producto['altura_base'];

                                $nombre_producto = $this->getNombreProducto($productoid);

                                $this->insertDetalle($request_pedido, $productoid, $tamano, $color, $tipo_tela, $altura_base, $precio, $cantidad);

                                // Insertar detalle para cada unidad del producto
                                for ($i = 0; $i < $cantidad; $i++) {
                                    $detalle_data = array(
                                        'action' => 'insertDetalle',
                                        'pedidoid' => $request_pedido,
                                        'nombre_producto' => $nombre_producto,
                                        'tamano' => $tamano,
                                        'color' => $color,
                                        'tipo_tela' => $tipo_tela,
                                        'altura_base' => $altura_base,
                                        'precio' => $precio,
                                        'cantidad' => $cantidad,
                                        'mododepoago' => 'Transbank',
                                        'tipodepago' => $tipopagoid,
                                        'direccion' => $direccion_cliente['direccion'],
                                        'numero' => $direccion_cliente['numero'],
                                        'dpto' => $direccion_cliente['dpto'],
                                        'metodo_entrega' => $metodo_entrega,
                                        'detalle_entrega' => $direccion_cliente['referencia'],
                                        'region' => $direccion_cliente['region'],
                                        'comuna' => $direccion_cliente['comuna']
                                    );

                                    sendPostRequest('https://respaldoschile.cl/online/insert_ecommerce_pedido.php', $detalle_data);
                                }
                            }

                            // Obtener la información completa del pedido para enviar notificaciones
                            $infoOrden = $this->getPedido($request_pedido);
                            $dataEmailOrden = array(
                                'asunto' => "Se ha creado la orden No." . $request_pedido,
                                'email' => $_SESSION['userData']['email_user'],
                                'emailCopia' => EMAIL_PEDIDOS,
                                'pedido' => $infoOrden
                            );

                            sendEmail($dataEmailOrden, "email_notificacion_orden");

                            $dataEmailVenta = array(
                                'asunto' => "Notificación de Nueva Venta " . $request_pedido,
                                'email' => 'jerson.sg21@gmail.com',
                                'pedido' => $infoOrden
                            );

                            sendEmail($dataEmailVenta, "template_notificacion_venta");

                            // Ajuste de fecha: convertir fecha de transacción a zona horaria de Santiago, Chile
                            $date = new DateTime($fecha_transaccion, new DateTimeZone('UTC'));
                            $date->setTimezone(new DateTimeZone('America/Santiago'));
                            $fecha_formateada = $date->format('d-m-Y H:i:s');

                            // Encriptar el número de pedido y el buy_order para enviarlos de forma segura
                            $orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
                            $transaccion = openssl_encrypt($buy_order, METHODENCRIPT, KEY);
                            $arrResponse = array(
                                "status" => true,
                                "orden" => $orden,
                                "monto_total" => $monto,
                                "transaccion" => $transaccion,
                                "status_transbank" => $status_transbank,
                                "fecha_transaccion" => $fecha_formateada,
                                "buy_order" => $buy_order,
                                "token_ws" => $token_ws,
                                "authorization_code" => $authorization_code,
                                "tarjeta" => $tarjeta,
                                "tipodepago" => $tipodepago,
                                "msg" => 'Pedido realizado'
                            );
                            $_SESSION['dataorden'] = $arrResponse;
                            unset($_SESSION['arrCarrito']);
                            unset($_SESSION['iddireccion']);
                            session_regenerate_id(true);
                        } else {
                            $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
                        }
                    } else {
                        // Si el estado de Transbank no es "AUTHORIZED"
                        $arrResponse = array("status" => false, "msg" => 'Hubo un error en la transacción.');
                    }
                }
            }
        } else {
            $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
        }
    } else {
        $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
    }

    // Se envía la respuesta en formato JSON y se termina la ejecución
    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    die();
}


	public function pedidoconfirmado()
	{
		$this->views->getView($this, "pedidoconfirmado", $data);
	}






	public function anularventaTransbank()
	{
		function get_ws($data, $method, $type, $endpoint)
		{
			$curl = curl_init();

			/* AMBIENTE DE PRODUCCION */

			$TbkApiKeyId = '597045358953';
			$TbkApiKeySecret = '4db548a2-9ceb-4da1-8acb-750dce0435ec';
			$url = "https://webpay3g.transbank.cl" . $endpoint; //Live

			/* AMBIENTE DE INTEGRACIÓN 
																													$TbkApiKeyId='597055555532';
																													$TbkApiKeySecret='579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';
																													$url="https://webpay3gint.transbank.cl/".$endpoint;*/



			curl_setopt_array(
				$curl,
				array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => $method,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $data,
					CURLOPT_HTTPHEADER => array(
						'Tbk-Api-Key-Id: ' . $TbkApiKeyId . '',
						'Tbk-Api-Key-Secret: ' . $TbkApiKeySecret . '',
						'Content-Type: application/json'
					),
				)
			);

			$response = curl_exec($curl);

			curl_close($curl);
			//echo $response;
			return json_decode($response);
		}



		/** Token de la transacción  */
		$token = $_POST['token_ws'];
		$montotransbank = $_POST['montotransbank'];

		$request = array(
			"token" => $token
		);

		$amount = $montotransbank;
		$data = '{
	                  "amount": ' . $amount . '
	                }';
		$method = 'POST';
		$type = 'sandbox';
		$endpoint = '/rswebpaytransaction/api/webpay/v1.0/transactions/' . $token . '/refunds';

		$response = get_ws($data, $method, $type, $endpoint);


		$message = $token . $response->type;

		$arrResponse = array("status" => true, "msg" => $message);




		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}



	public function confirmarpedido()
	{
		if (empty($_SESSION['dataorden'])) {
			header("Location: " . base_url());
		} else {
			$dataorden = $_SESSION['dataorden'];
			$idpedido = openssl_decrypt($dataorden['orden'], METHODENCRIPT, KEY);
			$transaccion = openssl_decrypt($dataorden['transaccion'], METHODENCRIPT, KEY);
			$status_transbank = $dataorden['status_transbank'];
			$tarjeta = $dataorden['tarjeta'];
			$tipodepago = $dataorden['tipodepago'];
			$buy_order = $dataorden['buy_order'];
			$fecha_transaccion = $dataorden['fecha_transaccion'];
			$token_ws = $dataorden['token_ws'];
			$monto = $dataorden['monto_total'];
			$authorization_code = $dataorden['authorization_code'] ?? "";
			$detallePedido = $this->getPedido($idpedido);
			$data['orden'] = $detallePedido['orden'];
			$data['detalle'] = $detallePedido['detalle'];
			$data['page_tag'] = "Confirmar Pedido";
			$data['page_title'] = "Confirmar Pedido";
			$data['page_name'] = "confirmarpedido";
			$data['orden'] = $idpedido;
			$data['monto_total'] = $monto;
			$data['transaccion'] = $transaccion;
			$data['status_transbank'] = $status_transbank;
			$data['tarjeta'] = $tarjeta;
			$data['tipodepago'] = $tipodepago;
			$data['buy_order'] = $buy_order;
			$data['authorization_code'] = $authorization_code;
			$data['fecha_transaccion'] = $fecha_transaccion;
			$data['token_ws'] = $token_ws;

			$this->views->getView($this, "confirmarpedido", $data);
		}
		//unset($_SESSION['dataorden']);
	}

	public function page($pagina = null)
	{

		$pagina = is_numeric($pagina) ? $pagina : 1;
		$cantProductos = $this->cantProductos();
		$total_registro = $cantProductos['total_registro'];
		$desde = ($pagina - 1) * PROPORPAGINA;
		$total_paginas = ceil($total_registro / PROPORPAGINA);
		$data['productos'] = $this->getProductosPage($desde, PROPORPAGINA);
		//dep($data['productos']);exit;
		$data['page_tag'] = NOMBRE_EMPESA;
		$data['page_title'] = NOMBRE_EMPESA;
		$data['page_name'] = "tienda";
		$data['pagina'] = $pagina;
		$data['total_paginas'] = $total_paginas;
		$data['categorias'] = $this->getCategorias();
		$this->views->getView($this, "tienda", $data);
	}

	public function search()
	{
		if (empty($_REQUEST['s'])) {
			header("Location: " . base_url());
		} else {
			$busqueda = strClean($_REQUEST['s']);
		}

		$pagina = empty($_REQUEST['p']) ? 1 : intval($_REQUEST['p']);
		$cantProductos = $this->cantProdSearch($busqueda);
		$total_registro = $cantProductos['total_registro'];
		$desde = ($pagina - 1) * PROBUSCAR;
		$total_paginas = ceil($total_registro / PROBUSCAR);
		$data['productos'] = $this->getProdSearch($busqueda, $desde, PROBUSCAR);
		$data['page_tag'] = NOMBRE_EMPESA;
		$data['page_title'] = "Resultado de: " . $busqueda;
		$data['page_name'] = "tienda";
		$data['pagina'] = $pagina;
		$data['total_paginas'] = $total_paginas;
		$data['busqueda'] = $busqueda;
		$data['categorias'] = $this->getCategorias();
		$this->views->getView($this, "search", $data);
	}

	public function suscripcion()
	{
		if ($_POST) {
			$nombre = ucwords(strtolower(strClean($_POST['nombreSuscripcion'])));
			$email = strtolower(strClean($_POST['emailSuscripcion']));

			$suscripcion = $this->setSuscripcion($nombre, $email);
			if ($suscripcion > 0) {
				$arrResponse = array('status' => true, 'msg' => "Gracias por tu suscripción.");
				//Enviar correo
				$dataUsuario = array(
					'asunto' => "Nueva suscripción",
					'email' => EMAIL_SUSCRIPCION,
					'nombreSuscriptor' => $nombre,
					'emailSuscriptor' => $email
				);
				sendEmail($dataUsuario, "email_suscripcion");
			} else {
				$arrResponse = array('status' => false, 'msg' => "El email ya fue registrado.");
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function contacto()
	{
		if ($_POST) {
			//dep($_POST);
			$nombre = ucwords(strtolower(strClean($_POST['nombreContacto'])));
			$email = strtolower(strClean($_POST['emailContacto']));
			$emailCopia = "contacto@respaldoschile.cl";

			$mensaje = strClean($_POST['mensaje']);
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			$ip = $_SERVER['REMOTE_ADDR'];
			$dispositivo = "PC";

			if (preg_match("/mobile/i", $useragent)) {
				$dispositivo = "Movil";
			} else if (preg_match("/tablet/i", $useragent)) {
				$dispositivo = "Tablet";
			} else if (preg_match("/iPhone/i", $useragent)) {
				$dispositivo = "iPhone";
			} else if (preg_match("/iPad/i", $useragent)) {
				$dispositivo = "iPad";
			}

			$userContact = $this->setContacto($nombre, $email, $mensaje, $ip, $dispositivo, $useragent);
			if ($userContact > 0) {
				$dataUsuario = array(
					'asunto' => "Nuevo Usuario en contacto",
					'email' => "contacto@respaldoschile.cl",
					'nombreContacto' => $nombre,
					'emailContacto' => $email,
					'emailCopia' => $emailCopia,
					'mensaje' => $mensaje
				);
				sendEmail($dataUsuario, "email_contacto");

				$arrResponse = array('status' => true, 'msg' => "Su mensaje fue enviado correctamente. Nos pondremos en contacto con usted");
				//Enviar correo



			} else {
				$arrResponse = array('status' => false, 'msg' => "No es posible enviar el mensaje.");
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}
}
