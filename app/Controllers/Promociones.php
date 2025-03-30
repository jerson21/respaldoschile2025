<?php 
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");
	require_once("Models/TCliente.php");
	require_once("Models/LoginModel.php");

	class Promociones extends Controllers{
		use TCategoria, TProducto, TCliente;
		public $login;
		public function __construct()
		{
			parent::__construct();

			session_start();
			$this->login = new LoginModel();
		}

		public function promociones()
		{
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "promociones";
			//$data['productos'] = $this->getProductosT();
			$pagina = 1;
			$cantProductos = $this->cantProductosStock();
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * 12;
			$total_paginas = ceil($total_registro / 12);
			$data['productos'] = $this->getProductosStock($desde,12);
			//dep($data['productos']);exit;
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['categorias'] = $this->getCategorias();
			$data['slider'] = $this->getCategoriasT(CAT_SLIDER);
			$data['banner'] = $this->getCategoriasT(CAT_BANNER);
			$this->views->getView($this,"promociones",$data);
			
		}

		

		public function categoria($params){
			if(empty($params)){
				header("Location:".base_url());
			}else{

				$arrParams = explode(",",$params);
				$idcategoria = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
				$pagina = 1;
				if(count($arrParams) > 2 AND is_numeric($arrParams[2])){
					$pagina = $arrParams[2];
				}

				$cantProductos = $this->cantProductos($idcategoria);
				$total_registro = $cantProductos['total_registro'];
				$desde = ($pagina-1) * PROCATEGORIA;
				$total_paginas = ceil($total_registro / PROCATEGORIA);
				$infoCategoria = $this->getProductosCategoriaT($idcategoria,$ruta,$desde,PROCATEGORIA);
				$categoria = strClean($params);
				$data['page_tag'] = NOMBRE_EMPESA." - ".$infoCategoria['categoria'];
				$data['page_title'] = $infoCategoria['categoria'];
				$data['page_name'] = "categoria";
				$data['productos'] = $infoCategoria['productos'];
				$data['infoCategoria'] = $infoCategoria;
				$data['pagina'] = $pagina;
				$data['total_paginas'] = $total_paginas;
				$data['categorias'] = $this->getCategorias();
				$this->views->getView($this,"categoria",$data);
			}
		}



		public function producto($params){
			if(empty($params)){
				header("Location:".base_url());
			}else{
				$arrParams = explode(",",$params);
				$idproducto = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
				$infoProducto = $this->getProductoT($idproducto,$ruta);
				if(empty($infoProducto)){
					header("Location:".base_url());
				}
				$data['page_tag'] = NOMBRE_EMPESA." - ".$infoProducto['nombre'];
				$data['page_title'] = $infoProducto['nombre'];
				$data['page_name'] = "producto";
				$data['tipo_prod'] = $infoProducto['tipo_prod'];
				$data['producto'] = $infoProducto;
				$data['productos'] = $this->getProductosRandom($infoProducto['categoriaid'],8,"r");
				$data['color'] = $this->getColores();
				$data['colores_prod'] = $this->getColoresProducto($idproducto);
				$data['tamano'] = $this->getTamanos($idproducto);
				$data['tipo_tela'] = $this->getTelas($idproducto);
				$data['altura_base'] = $this->getAlturas($idproducto);
				$data['categorias'] = $this->getCategorias();
				$this->views->getView($this,"producto",$data);
			}
		}
		

		public function addCarrito(){
			if($_POST){
				//unset($_SESSION['arrCarrito']);exit;
				$arrCarrito = array();
				$cantCarrito = 0;
				$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
				$cantidad = $_POST['cant'];
				$color = $_POST['color'];
				$tamano = $_POST['tamano'];
				$precio_tamano = $_POST['precio_tamano'];				
				$tipo_tela = $_POST['tipo_tela'];
				$altura_base = $_POST['altura_base'];
				if($_POST['precio_alturabase'] != 'undefined'){$precio_alturabase = $_POST['precio_alturabase']; }else{ $precio_alturabase =0; }
				
				$arrInfoProducto = $this->getProductoIDT($idproducto);
				if($arrInfoProducto['tipo_prod'] == "1"){
					$precio_total =  $arrInfoProducto['precio'];
				}else{
					$precio_total = $precio_tamano+$precio_alturabase;
				}

				if(is_numeric($idproducto) and is_numeric($cantidad)){
					$arrInfoProducto = $this->getProductoIDT($idproducto);
					if(!empty($arrInfoProducto)){
						$arrProducto = array('idproducto' => $idproducto,
											'producto' => $arrInfoProducto['nombre'],
											'cantidad' => $cantidad,
											'precio' => $precio_total, //aqui hay que cambiar el precio segun tamaño
											'imagen' => $arrInfoProducto['images'][0]['url_image'],
											'color' => $color,
											'precio_alturabase' => $precio_alturabase,
											'tamano' => $tamano,
											'tipo_tela' => $tipo_tela,
											'altura_base' => $altura_base
										);
						if(isset($_SESSION['arrCarrito'])){
							$on = true;
							$arrCarrito = $_SESSION['arrCarrito'];
							for ($pr=0; $pr < count($arrCarrito); $pr++) {
								if($arrCarrito[$pr]['idproducto'] == $idproducto && $arrCarrito[$pr]['color'] == $color && $arrCarrito[$pr]['tamano'] == $tamano && $arrCarrito[$pr]['precio_alturabase'] == $precio_alturabase){
									$arrCarrito[$pr]['cantidad'] += $cantidad;
									$on = false;
								}
							}
							if($on){
								array_push($arrCarrito,$arrProducto);
							}
							$_SESSION['arrCarrito'] = $arrCarrito;
						}else{
							array_push($arrCarrito, $arrProducto);
							$_SESSION['arrCarrito'] = $arrCarrito;
						}

						foreach ($_SESSION['arrCarrito'] as $pro) {
							$cantCarrito += $pro['cantidad'];
						}
						$htmlCarrito ="";
						$htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
						$arrResponse = array("status" => true, 
											"msg" => '¡Se agrego al carrito!',
											"cantCarrito" => $cantCarrito,
											"color" => $color,
											"tamano" => $tamano,
											'tipo_tela' => $tipo_tela,
											'altura_base' => $altura_base,
											'precio_alturabase' => $precio_alturabase,
											"htmlCarrito" => $htmlCarrito
										);

					}else{
						$arrResponse = array("status" => false, "msg" => 'Producto no existente.');
					}
				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delCarrito(){
			if($_POST){
				$arrCarrito = array();
				$cantCarrito = 0;
				$subtotal = 0;
				$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
				$option = $_POST['option'];
				if(is_numeric($idproducto) and ($option == 1 or $option == 2)){
					$arrCarrito = $_SESSION['arrCarrito'];
					for ($pr=0; $pr < count($arrCarrito); $pr++) {
						if($arrCarrito[$pr]['idproducto'] == $idproducto){
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
					if($option == 1){
						$htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
					}
					$arrResponse = array("status" => true, 
											"msg" => '¡Producto eliminado!',
											"cantCarrito" => $cantCarrito,
											"htmlCarrito" => $htmlCarrito,
											"subTotal" => SMONEY.formatMoney($subtotal),
											"total" => SMONEY.formatMoney($subtotal + COSTOENVIO)
										);
				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function updCarrito(){
			if($_POST){
				$arrCarrito = array();
				$totalProducto = 0;
				$subtotal = 0;
				$total = 0;
				$idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
				$cantidad = intval($_POST['cantidad']);
				if(is_numeric($idproducto) and $cantidad > 0){
					$arrCarrito = $_SESSION['arrCarrito'];
					for ($p=0; $p < count($arrCarrito); $p++) { 
						if($arrCarrito[$p]['idproducto'] == $idproducto){
							$arrCarrito[$p]['cantidad'] = $cantidad;
							$totalProducto = $arrCarrito[$p]['precio'] * $cantidad;
							break;
						}
					}
					$_SESSION['arrCarrito'] = $arrCarrito;
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$subtotal += $pro['cantidad'] * $pro['precio']; 
					}
					$arrResponse = array("status" => true, 
										"msg" => '¡Producto actualizado!',
										"totalProducto" => SMONEY.formatMoney($totalProducto),
										"subTotal" => SMONEY.formatMoney($subtotal),
										"total" => SMONEY.formatMoney($subtotal + COSTOENVIO)
									);

				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function registro(){
			error_reporting(0);
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmailCliente']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmailCliente']));
					$rut = strtolower(strClean($_POST['txtRut']));
					$intTipoId = RCLIENTES; 
					$request_user = "";
					
					$strPassword =  passGenerator();
					$strPasswordEncript = hash("SHA256",$strPassword);
					$request_user = $this->insertCliente($strNombre, 
														$strApellido, 
														$intTelefono, 
														$rut,
														$strEmail,														
														$strPasswordEncript,
														$intTipoId );
					if($request_user > 0 )
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						$nombreUsuario = $strNombre.' '.$strApellido;
						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'password' => $strPassword,
											 'rut' => $rut,
											 'asunto' => 'Bienvenido a tu tienda en línea');
						$_SESSION['idUser'] = $request_user;
						$_SESSION['login'] = true;
						$this->login->sessionLogin($request_user);
						sendEmail($dataUsuario,'email_bienvenida');

					}else if($request_user == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el rut ya existe, ingrese a su cuenta.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

public function agregarDireccion(){
	if($_POST){
				
				$personaid = $_SESSION['userData']['identificacion'];				
				
							
				$direccion = strClean($_POST['direccion']);
				$dirNumero = strClean($_POST['dirNumero']);
				$dirDepto = strClean($_POST['dirDepto']);
				$dirRegion = strClean($_POST['dirRegion']);
				$dirComuna = strClean($_POST['dirComuna']);
				$instrucciones = strClean($_POST['instrucciones']);

				$agregar = $this->insertDireccion($personaid,$direccion,$dirNumero,$dirDepto,$dirRegion,$dirComuna,$instrucciones);


				if($agregar > 0){
				$arrResponse = array('status' => true, 'msg' => "Direccion Agregada.");
					
				}else{
					$arrResponse = array('status' => false, 'msg' => "Direccion no agregada.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);


				 }


	 }

	 public function consultarDir($rut){
			
				$personaid = $_SESSION['userData']['identificacion'];	

				$agregar = $this->getDir($personaid);


				if($agregar > 0){
				$arrResponse = array('status' => true, 'msg' => "Direccion Agregada.");
					
				}else{
					$arrResponse = array('status' => false, 'msg' => "Direccion no agregada.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);


				 }

				 
				 public function cons_precioDir(){


				 	
				 	$personaidrut = $_SESSION['userData']['identificacion'];
				 	if($_POST){
				 		$comuna = strClean($_POST['comuna']);
				 		$direccion = $this->getDir($personaidrut,$comuna);
					
				foreach($direccion as $direccion){ 
				$comuna = $direccion['comuna'];
				
				 }

				 		$request_pedido = $this->getPrecioEnvio($comuna);
						
				if($request_pedido != ''){
					
					$_SESSION['precio_envio'] = array('precio' => $request_pedido);
					$arrResponse = array('precio' => $request_pedido);
					//Enviar correo					
				}else{
					$arrResponse = array('precio' => "1");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}

				 	}

				  public function consultarTotal()
				 {
				 	$preciodescuento = 0;
				 	$subtotal=0;
				 	$nombrecupon="";
				 	$subtotal=0;

				 	$coddescuento = $_POST['coddescuento'];
					
					
					
					
					

					$request_consultaa = $this->getPrecioDescuento($coddescuento);
						
					if(!empty($request_consultaa)){
						
						$_SESSION['descuento'] = array('descuento' => $request_consultaa,'nombre' => $request_consultaa);

						foreach($_SESSION['descuento'] as $ar){
						$preciodescuento = $ar['descuento'];
						$nombrecupon = $ar['nombre'];
						
						}
					
						

						
						
						
						
						

										
					}else{
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

					$arrResponse = array("subtotales" => $subtotal,"preciodescuento" => $preciodescuento, "msg" => 'Descuento Aplicado.', "nombrecupon" => $nombrecupon);
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
					die();
				 	// code...
				 }


		       

			 
		public function procesarVenta(){
			if($_POST){
				$idtransaccionpaypal = NULL;
				$datospaypal = NULL;
				$personaid = $_SESSION['idUser'];
				$monto = 0;
				$status_transbank = $_POST['status_transbank'];
				//$retiroenlatienda = $_POST['direccion'];
				$tarjeta =$_POST['card_detail'];
				$tipodepago = $_POST['payment_type_code'];
				$buy_order = $_POST['buy_order'];
				$token_ws = $_POST['token_ws'];
				$fecha_transaccion = $_POST['fecha_transaccion'];
				$tipopagoid = intval($_POST['inttipopago']);
				$iddireccionselect = $_POST['iddireccionselect'];
				
				// $direccionenvio = strClean($_POST['direccion']).' '.strClean($_POST['numero']).', '.strClean($_POST['region']).', '.strClean($_POST['comuna']).', '.strClean($_POST['dpto']);
				
				$personaidrut = $_SESSION['userData']['identificacion'];

				 if($iddireccionselect == "1"){
				 	$direccion = $this->getDir("1",$iddireccionselect);
				 }
				 else{
				 	$direccion = $this->getDir($personaidrut,$iddireccionselect);
				 }

				
					
				foreach($direccion as $direccion){ 
				$direccionenvio = $direccion['direccion'].', '.$direccion['numero'].', '.$direccion['dpto'].', '.$direccion['region'].', '.$direccion['comuna'];
				$referencia = $direccion['referencia'];
				 }


				 if($iddireccionselect == "1"){
				 	$direccionenvio = "Retiro en local";
				 }



				
				$status = "Pendiente";
				$subtotal = 0;
				$descuento = 0;
				$costo_envio = 0;
				foreach ($_SESSION['precio_envio'] as $producto) {
											$costo_envio = $producto['precio'];
										} 

				if(!empty($_SESSION['descuento'])){						
				$descuento = $_SESSION['descuento'];
										}
				

				if(!empty($_SESSION['arrCarrito'])){
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$subtotal += $pro['cantidad'] * $pro['precio']; 
					}
					$monto = $subtotal + $costo_envio-$descuento;
					//Pago contra entrega
					if(empty($_POST['status_transbank'])){
						//Crear pedido
						$request_pedido = $this->insertPedido($idtransaccionpaypal, 
															$datospaypal, 
															$personaid,
															$costo_envio,
															$monto,
															$descuento, 
															$tipopagoid,
															$direccionenvio,
															$referencia, 
															$status);
						if($request_pedido > 0 ){
							//Insertamos detalle
							foreach ($_SESSION['arrCarrito'] as $producto) {
								$productoid = $producto['idproducto'];
								$precio = $producto['precio'];
								$cantidad = $producto['cantidad'];
								$color = $producto['color'];
								$tamano = $producto['tamano'];
								$tipo_tela = $producto['tipo_tela'];
								$altura_base = $producto['altura_base'];
								$this->insertDetalle($request_pedido,$productoid,$tamano,$color,$tipo_tela,$altura_base,$precio,$cantidad);
							}

							$infoOrden = $this->getPedido($request_pedido);
							$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
													'email' => $_SESSION['userData']['email_user'], 
													'emailCopia' => EMAIL_PEDIDOS,
													'pedido' => $infoOrden );
							sendEmail($dataEmailOrden,"email_notificacion_orden");

							$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
							$transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);
							$arrResponse = array("status" => true, 
											"orden" => $orden, 
											"monto_total" =>$monto,
											"transaccion" =>$transaccion,
											"status_transbank" =>$status_transbank,
											"fecha_transaccion" =>$fecha_transaccion,
											"buy_order" =>$buy_order,
											"token_ws" =>$token_ws,
											"tarjeta" =>$tarjeta,
											"tipodepago" =>$tipodepago,
											"msg" => 'Pedido realizado'
										);
							$_SESSION['dataorden'] = $arrResponse;
							unset($_SESSION['precio_envio']);
							unset($_SESSION['arrCarrito']);
							session_regenerate_id(true);
						}
					}else{ 
					//Pago con web
						
						$status = "Aprobado";
						if($status_transbank == "AUTHORIZED"){
							
							
								
								//if($monto == $totalPaypal){  //CONSULTAR SI EL MONTO PAGADO A TRANSBANK ES EL MISMO DE LA PAGINA.
									//$status = "Completo";
								//}
								//Crear pedido
									$request_pedido = $this->insertPedido($idtransaccionpaypal, 
															$buy_order, 
															$personaid,
															$costo_envio,
															$monto,
															$descuento, 
															"1",
															$direccionenvio,
															$referencia, 
															$status);
										if($request_pedido > 0 ){
											//Insertamos detalle
											foreach ($_SESSION['arrCarrito'] as $producto) {
												$productoid = $producto['idproducto'];
												$precio = $producto['precio'];
												$cantidad = $producto['cantidad'];
												$color = $producto['color'];
												$tamano = $producto['tamano'];
												$tipo_tela = $producto['tipo_tela'];
												$altura_base = $producto['altura_base'];
												$this->insertDetalle($request_pedido,$productoid,$tamano,$color,$tipo_tela,$altura_base,$precio,$cantidad);
											}
									$infoOrden = $this->getPedido($request_pedido);
									$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
													'email' => $_SESSION['userData']['email_user'], 
													'emailCopia' => EMAIL_PEDIDOS,
													'pedido' => $infoOrden );

									sendEmail($dataEmailOrden,"email_notificacion_orden"); //buscar plantilla de envio de correo y asignar datos de transbank

									$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
									$transaccion = openssl_encrypt($buy_order, METHODENCRIPT, KEY);
									$arrResponse = array("status" => true, 
											"orden" => $orden, 
											"monto_total" =>$monto,
											"transaccion" =>$transaccion,
											"status_transbank" =>$status_transbank,
											"fecha_transaccion" =>$fecha_transaccion,
											"buy_order" =>$buy_order,
											"token_ws" =>$token_ws,
											"tarjeta" =>$tarjeta,
											"tipodepago" =>$tipodepago,
											"msg" => 'Pedido realizado'
										);
									$_SESSION['dataorden'] = $arrResponse;
									unset($_SESSION['arrCarrito']);
									unset($_SESSION['iddireccion']);
									session_regenerate_id(true);
								}else{
									$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
								}
							
						}


						else{
							$arrResponse = array("status" => false, "msg" => 'Hubo un error en la transacción.');
						}
					}//FIN DE PAGO CON WEBPAY
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
				}
			}else{
				$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function pedidoconfirmado(){
			$this->views->getView($this,"pedidoconfirmado",$data);
			 }

		public function confirmarpedido(){
			if(empty($_SESSION['dataorden'])){
				header("Location: ".base_url());
			}else{
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
				$data['fecha_transaccion'] = $fecha_transaccion;
				$data['token_ws'] = $token_ws;

				$this->views->getView($this,"confirmarpedido",$data);
			}
			unset($_SESSION['dataorden']);
		}

		public function page($pagina = null){

			$pagina = is_numeric($pagina) ? $pagina : 1;
			$cantProductos = $this->cantProductosStock();
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * 12;
			$total_paginas = ceil($total_registro / 12);
			$data['productos'] = $this->getProductosStock($desde,12);
			//dep($data['productos']);exit;
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "tienda";
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['categorias'] = $this->getCategorias();
			$this->views->getView($this,"promociones",$data);
		}

		public function search(){
			if(empty($_REQUEST['s'])){
				header("Location: ".base_url());
			}else{
				$busqueda = strClean($_REQUEST['s']);
			}

			$pagina = empty($_REQUEST['p']) ? 1 : intval($_REQUEST['p']);
			$cantProductos = $this->cantProdSearch($busqueda);
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * PROBUSCAR;
			$total_paginas = ceil($total_registro / PROBUSCAR);
			$data['productos'] = $this->getProdSearch($busqueda,$desde,PROBUSCAR);
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = "Resultado de: ".$busqueda;
			$data['page_name'] = "tienda";
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['busqueda'] = $busqueda;
			$data['categorias'] = $this->getCategorias();
			$this->views->getView($this,"search",$data);

		}

		public function suscripcion(){
			if($_POST){
				$nombre = ucwords(strtolower(strClean($_POST['nombreSuscripcion'])));
				$email  = strtolower(strClean($_POST['emailSuscripcion']));

				$suscripcion = $this->setSuscripcion($nombre,$email);
				if($suscripcion > 0){
					$arrResponse = array('status' => true, 'msg' => "Gracias por tu suscripción.");
					//Enviar correo
					$dataUsuario = array('asunto' => "Nueva suscripción",
										'email' => EMAIL_SUSCRIPCION,
										'nombreSuscriptor' => $nombre,
										'emailSuscriptor' => $email );
					sendEmail($dataUsuario,"email_suscripcion");
				}else{
					$arrResponse = array('status' => false, 'msg' => "El email ya fue registrado.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}

		public function contacto(){
			if($_POST){
				//dep($_POST);
				$nombre = ucwords(strtolower(strClean($_POST['nombreContacto'])));
				$email  = strtolower(strClean($_POST['emailContacto']));
				$emailCopia  = "contacto@respaldoschile.cl";

				$mensaje  = strClean($_POST['mensaje']);
				$useragent = $_SERVER['HTTP_USER_AGENT'];
				$ip        = $_SERVER['REMOTE_ADDR'];
				$dispositivo= "PC";

				if(preg_match("/mobile/i",$useragent)){
					$dispositivo = "Movil";
				}else if(preg_match("/tablet/i",$useragent)){
					$dispositivo = "Tablet";
				}else if(preg_match("/iPhone/i",$useragent)){
					$dispositivo = "iPhone";
				}else if(preg_match("/iPad/i",$useragent)){
					$dispositivo = "iPad";
				}

				$userContact = $this->setContacto($nombre,$email,$mensaje,$ip,$dispositivo,$useragent);
				if($userContact > 0){
					$dataUsuario = array('asunto' => "Nuevo Usuario en contacto",
										'email' => "contacto@respaldoschile.cl",
										'nombreContacto' => $nombre,
										'emailContacto' => $email,
										'emailCopia' => $emailCopia,
										'mensaje' => $mensaje );
					sendEmail($dataUsuario,"email_contacto");

					$arrResponse = array('status' => true, 'msg' => "Su mensaje fue enviado correctamente. Nos pondremos en contacto con usted");
					//Enviar correo
					


				}else{
					$arrResponse = array('status' => false, 'msg' => "No es posible enviar el mensaje.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}

	}

 ?>
