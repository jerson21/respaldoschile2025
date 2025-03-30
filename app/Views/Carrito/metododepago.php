<?php
headerTienda($data);
$action = isset($_GET["action"]);

if ($action != "getResult") {
	unset($_SESSION['descuento']);
}

$subtotal = 0;
$total = 0;
foreach ($_SESSION['arrCarrito'] as $producto) {
	$subtotal += $producto['precio'] * $producto['cantidad'];
}

$total = $subtotal + COSTOENVIO;

$tituloTerminos = !empty(getInfoPage(PTERMINOS)) ? getInfoPage(PTERMINOS)['titulo'] : "";
$infoTerminos = !empty(getInfoPage(PTERMINOS)) ? getInfoPage(PTERMINOS)['contenido'] : "";


?>
<?php
$this->con = new Mysql();
$conexion = $this->con->getConexion(); // Obtenemos la conexión mediante un getter que debes definir en la clase Mysql

// Verifica si hay productos en el carrito en la sesión
if (!empty($_SESSION['arrCarrito'])) {
	$usuario_id = $_SESSION['userData']['idpersona']; // Asegúrate de que esta información existe en la sesión
	$productos = $_SESSION['arrCarrito'];

	try {
		// Iniciamos una transacción
		$conexion->beginTransaction();

		// Insertamos la cabecera de la compra temporal
		$sql = "INSERT INTO compras_temporales (usuario_id) VALUES (?)";
		$stmt = $conexion->prepare($sql); // Usa la variable $conexion aquí
		$stmt->execute([$usuario_id]);
		$compra_id = $conexion->lastInsertId(); // Obtiene el ID del último insert usando la conexión

		// Insertamos cada producto en la tabla de detalles
		$sql = "INSERT INTO detalles_compra_temporal (compra_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)";
		$stmt = $conexion->prepare($sql); // Preparamos el SQL usando la conexión directamente
		foreach ($productos as $producto) {
			$stmt->execute([$compra_id, $producto['idproducto'], $producto['cantidad'], $producto['precio']]);
		}

		// Si todo está bien, confirmamos la transacción
		$conexion->commit();
	} catch (Exception $e) {
		// Si algo sale mal, revertimos la transacción
		$conexion->rollBack();
		echo "Error: " . $e->getMessage();
	}
}
?>

<!-- Modal -->
<div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<?= $tituloTerminos ?>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="page-content">
					<?= $infoTerminos ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<hr>
<!-- breadcrumb -->

<?php
function renderProductos()
{
	echo '<div class="productos">';
	if (!empty($_SESSION['arrCarrito'])) {
		foreach ($_SESSION['arrCarrito'] as $producto) {
			echo '<div class="producto-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; background-color: #f9f9f9; display: flex; align-items: center;">';

			// Imagen del producto
			echo '<div class="producto-imagen" style="margin-right: 10px;">';
			echo '<img src="' . htmlspecialchars($producto['imagen']) . '" alt="' . htmlspecialchars($producto['producto']) . '" style="width: 50px; height: ; border-radius: 50%;">';
			echo '</div>';

			// Contenedor del nombre y detalles del producto
			echo '<div class="producto-info" style="flex-grow: 1;">';

			// Nombre y cantidad del producto
			echo '<div class="producto-nombre" style="font-weight: bold; font-size: 16px; margin-bottom: 5px;">' . htmlspecialchars($producto['cantidad']) . ' x ' . htmlspecialchars($producto['producto']) . '</div>';

			// Detalles del producto
			echo '<div class="producto-detalle" style="display: flex; gap: 6px; font-size: 12px;">';
			echo '<div class="producto-color" style="border-radius: 5px; background-color: #e9e9e9; padding: 2px 5px;">Color: ' . htmlspecialchars($producto['color']) . '</div>';
			echo '<div class="producto-tamano" style="border-radius: 5px; background-color: #e9e9e9; padding: 2px 5px;">Tamaño: ' . htmlspecialchars($producto['tamano']) . '</div>';
			if ($producto['altura_base'] != '') {
				echo '<div class="producto-alturabase" style="border-radius: 5px; background-color: #e9e9e9; padding: 2px 5px;">Base: ' . htmlspecialchars($producto['altura_base']) . '</div>';
			}
			echo '</div>';

			echo '</div>'; // Cierre del div producto-info
			echo '</div>'; // Cierre del div producto-item
		}
	} else {
		echo '<p style="color: #555;">No tienes productos en el carrito.</p>';
	}
	echo '</div>';
}
?>

<?php




?>









<div class="container">
	<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
		<a href="<?= base_url() ?>" class="stext-109 cl8 hov-cl1 trans-04">
			Inicio
			<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
		</a>
		<a href="<?= base_url() ?>/carrito/procesarpago" class="stext-109 cl8 hov-cl1 trans-04">
			Metodo de envio
			<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
		</a>
		<span class="stext-109 cl4">
			<?= $data['page_title'] ?>
		</span>
	</div>
</div>
<br>
<div class="container">

	<?php $this->con = new Mysql();






	if (!empty($_SESSION['iddireccion'])) {
		echo '<input type="hidden" id="iddireccionselect" name="iddireccionselect" value="' . $_SESSION['iddireccion'] . '">';
	} else {

	}



	if ($_SESSION['iddireccion'] == 1) {

		echo '<input type="hidden" id="direvalue" name="direvalue" value="Retiro en fabrica">
										<input type="hidden" id="direnumero" name="direnumero" value=" ">
										<input type="hidden" id="diredpto" name="diredpto" value=" ">
										<input type="hidden" id="direregion" name="direregion" value=" "> 
										<input type="hidden" id="direcomuna" name="direcomuna" value=" ">
										<input type="hidden" id="direreferencia" name="direreferencia" value=" ">';
		echo '<input type="hidden" id="iddireccionselect" name="iddireccionselect" value="' . $_SESSION['iddireccion'] . '">';
		$datodedireccion = $_SESSION['iddireccion'];
		//$_SESSION['iddireccion'] = 1;
	}




	$request = array();
	$suma = 0;
	$tienedireccion = false;
	$rut_cliente = $_SESSION['userData']['identificacion'];
	$iddedireccion = $_SESSION['iddireccion'];
	$sql = "SELECT * FROM direccion_cliente where rut_cliente = '$rut_cliente' and id = 'iddedireccion'";
	$requestPedido = $this->con->select($sql);

	if ($requestPedido > 0) {
		$sql_detalle = "SELECT * FROM direccion_cliente where rut_cliente = '$rut_cliente'";
		$requestProductos = $this->con->select_all($sql_detalle);
		$request = array(
			'direccion' => $requestProductos,
			'numero' => $requestProductos
		);

		if (!empty($_SESSION['iddireccion']) == "1") {

			echo '<input type="hidden" id="direvalue" name="direvalue" value="Retiro en fabrica">
										<input type="hidden" id="direnumero" name="direnumero" value=" ">
										<input type="hidden" id="diredpto" name="diredpto" value=" ">
										<input type="hidden" id="direregion" name="direregion" value=" "> 
										<input type="hidden" id="direcomuna" name="direcomuna" value=" ">
										<input type="hidden" id="direreferencia" name="direreferencia" value=" ">';

		}


		if ($_SESSION['iddireccion'] == 1) {

			echo '<input type="hidden" id="direvalue" name="direvalue" value="Retiro en fabrica">
										<input type="hidden" id="direnumero" name="direnumero" value=" ">
										<input type="hidden" id="diredpto" name="diredpto" value=" ">
										<input type="hidden" id="direregion" name="direregion" value=" "> 
										<input type="hidden" id="direcomuna" name="direcomuna" value=" ">
										<input type="hidden" id="direreferencia" name="direreferencia" value=" ">';
			echo '<input type="hidden" id="iddireccionselect" name="iddireccionselect" value="' . $_SESSION['iddireccion'] . '">';
			$datodedireccion = $_SESSION['iddireccion'];
		} else {



			if (!empty($_SESSION['precio_envio']['precio']['iddireccion'])) {
				echo '<input type="hidden" id="iddireccionselect" name="iddireccionselect" value="' . $_SESSION['precio_envio']['precio']['iddireccion'] . '">';
				$datodedireccion = $_POST['iddireccionselect'];
				$_SESSION['iddireccion'] = $datodedireccion;
			} else {
				echo '<input type="hidden" id="iddireccionselect" name="iddireccionselect" value="' . $_SESSION['iddireccion'] . '">';
			}




			foreach ($requestProductos as $form) { ?>





				<?php
				$detalle_dir = $form['direccion'] . " " . $form['numero'] . ", " . $form['dpto'] . ", " . $form['region'] . ", " . $form['comuna'];


				echo '<input type="hidden" id="direvalue" name="direvalue" value="' . $form["direccion"] . '">
										<input type="hidden" id="direnumero" name="direnumero" value="' . $form["numero"] . '">
										<input type="hidden" id="diredpto" name="diredpto" value="' . $form["dpto"] . '">
										<input type="hidden" id="direregion" name="direregion" value="' . $form["region"] . '"> 
										<input type="hidden" id="direcomuna" name="direcomuna" value="' . $form["comuna"] . '">
										<input type="hidden" id="direreferencia" name="direreferencia" value="' . $form["referencia"] . '">';




				?>


				<?php

			}
		}

	} ?>


	<div class="row stext-102">
		<div class="col-sm-10 col-lg-7 col-xl-7 m-lr-auto m-b-50">
			<div class="bor10 p-lr-40 p-t-20 p-b-10"
				style=" border-radius:5px;margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
				<div id="divMetodoPago">

					<div id="optMetodoPago">
						<h4 class=" cl2 p-b-10" style="font-weight: bold;">
							<i class="fa fa-credit-card" aria-hidden="true"></i> Medio de Pago
						</h4>
						Recuerda tener tu tarjeta a mano
						<div class="divmetodpago">
							<div>
								<label for="paypal">
									<input type="radio" id="webpay" class="methodpago" name="payment-method"
										value="Paypal">
									<img src="<?= media() ?>/images/webpay.png" alt="Icono de webpay"
										class="ml-space-sm">
								</label>
							</div>
							<div>
								<label for="contraentrega">
									<input type="radio" id="contraentrega" class="methodpago" name="payment-method"
										value="CT">
									<span>Transferencia Bancaria</span>
								</label>
							</div>



						</div>



					</div>







				</div>

			</div>
			<div class="bor10 p-lr-40 p-t-20 p-b-15"
				style="margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">

				<h4 class=" cl2 p-b-10" style="font-weight: bold;">
					<i class="fa fa-truck"></i> Entrega
				</h4>
				<?php //renderEntrega(); 
				$this->con = new Mysql();
				$rut_cliente = $_SESSION['userData']['identificacion'];
				$id_direccion = $_SESSION['iddireccion'];
				$sql = "SELECT * FROM direccion_cliente WHERE rut_cliente = '$rut_cliente' and id = '$id_direccion'";
				$request = $this->con->select_all($sql);
				if (!empty($request)) {
					foreach ($request as $direccion) {
						$detalle = $direccion['direccion'] . " " . $direccion['numero'] . ", " . $direccion['dpto'] . ", " . $direccion['region'] . ", " . $direccion['comuna'];
						echo ucfirst($detalle);
					}
				} elseif ($_SESSION['iddireccion'] == "retiro") {
					echo "Retiro en Av uno 10185, La Florida, Santiago.";

				} else {
					echo '<p>No tienes direcciones guardadas. <a href="#">Agregar dirección</a></p>';
				}
				?>

			</div>
			<div class="bor10 p-lr-40 p-t-20 p-b-5"
				style="margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">

				<h4 class=" cl2 p-b-10" style="font-weight: bold;">
					<i class="fa fa-tags"></i> Codigo descuento
				</h4>

				<table style="text-align:center; ">
					<th></th>
					<th><input type="text" id="cod_descuento" name="cod_descuento" placeholder="Cupón de descuento"
							class="form-control" style="width:90%;">
					</th>
					<th style="padding: 2px;"></th>
					<th>

						<input type="button"
							class="flex-c-m stext-101 cl0 size-125 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
							name="aplicar" id="aplicar" onclick="aplicarDescuento();" value="Aplicar">

					</th>


				</table>


				<div id="cupon" class="notblock" style="display: flex;border: 1px solid #d9d9d9;border-radius: 4px;background: #fff;justify-content: center;align-items: center;width: 60%;height: -webkit-fit-content;
				height: -moz-fit-content;height: fit-content; font-size: 12px;">
					<div
						style="z-index: 1;display: flex;justify-content: space-between;align-items: center;width: 100%;">
						<div
							style='font-family: "Barlow","Roboto","Helvetica Neue",sans-serif;color: #464646;   display: flex;'>
							<img style="margin-right: 6px;" alt="Check"
								src="https://checkout-corp.ripley.cl/static/media/check.4babb080.svg" width="20"
								height="20">
							<div>
								<div><input type="text" name="nombrecupon" id="nombrecupon" value="DESPACHOGRATIS"
										style="color: #008330;font-weight: 600;"></div>
								<div class="CouponTag_coupon_tag__coupon_description__1Xdyp">
									<div></div>
									<div>Cupón aplicado correctamente</div>
								</div>
							</div>
						</div>
					</div>
				</div>



				<br>







			</div>

			<div class="bor10 p-lr-40 p-t-30 p-b-30"
				style="margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">


				<i class="fa fa-question-circle" aria-hidden="true"></i><span class="stext-102"> ¿Necesitas ayuda para
					realizar la
					compra?</span><br>
				<span class="mtext-105 pointer"
					onclick="window.open('https://api.whatsapp.com/send/?phone=+56979941253&text=Hola! necesito ayuda')"
					; target="_blank"><i class="fa fa-whatsapp fa-6" aria-hidden="true"></i> Haz click aqui</span>

				<br>Estaremos disponibles para ayudarte.




			</div>










		</div>


		<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
			<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-20 m-r-40 m-lr-0-xl p-lr-15-sm">


				<div id="optProductos">
					<h4 class="cl2 p-b-10" style="font-weight: bold;">
						<i class="fa fa-shopping-bag" aria-hidden="true"></i> Mis Productos
					</h4>


					<?php renderProductos(); ?>






				</div>
				<hr>


				<div class="flex-w flex-t bor12 p-b-13">
					<div class="size-208">
						<span class="stext-110 cl2">
							Subtotal:
						</span>
					</div>

					<div class="size-208">
						<span id="subTotalCompra" class="mtext-110 cl2">

							<table>
								<th>$</th>
								<th>
									<?= $subtotal ?>
								</th>
							</table>
						</span>
					</div>

					<div class="size-208">
						<span class="stext-110 cl2">
							Envío:
						</span>
					</div>

					<?php $region = $_SESSION['precio_envio']['precio']['envio_loc'] ?? '0'; ?>


					<div class="size-208">
						<span class="mtext-110 cl2">
							<table>
								<th></th>
								<th>
									<?php foreach ($_SESSION['precio_envio'] as $producto) {
										$costoenvio = $producto['precio'];
									} ?>

									<?php

									if ($region != 'region') {
										echo '$' . $costoenvio;
									} else {
										echo 'Por Pagar';
									}
									?>
								</th>
							</table>



						</span>
					</div>



					<div class="size-208">
						<span class="stext-110 cl2">
							Descuento:
						</span>
					</div>

					<div class="size-209">
						<span class="mtext-110 cl2" style="font-family:'Roboto';">
							<table>
								<th>$</th>
								<th>

									<div id="descuento">
										<?php
										if (!empty($_SESSION['descuento'])) {
											echo $_SESSION['descuento'];
										} ?>
									</div>
								</th>
							</table>



						</span>
					</div>
				</div>
				<div class="flex-w flex-t p-t-27 p-b-33">
					<div class="size-208">
						<span class="mtext-101 cl2">
							Total:
						</span>
					</div>

					<div class="size-209">

						<span class="mtext-110 cl2">
							<table>
								<th>$</th>
								<th>
									<span id="totaal" data-value="<?php echo $subtotal + $costoenvio ?>">
										<?php echo $subtotal + $costoenvio;

										if (!isset($costoenvio)) {
											echo "<script>window.location = '" . base_url() . "/carrito/procesarpago';</script>";
										}
										?>

					</div>

					</th>
					<?php ?>
					</table>
					</span>



				</div>
				<div id="metodosdepagoenlinea" name="metodosdepagoenlinea" style="margin:0 auto;">
					<div id="divtipopago" class="notblock">
						<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
							<select id="listtipopago" class="js-select2" name="listtipopago">
								<?php
								if (count($data['tiposPago']) > 0) {
									foreach ($data['tiposPago'] as $tipopago) {
										if ($tipopago['idtipopago'] != 1) {
											?>
											<option value="<?= $tipopago['idtipopago'] ?>">
												<?= $tipopago['tipopago'] ?>
											</option>
											<?php
										}
									}
								} ?>
							</select>
							<div class="dropDownSelect2"></div>
						</div>

						<button type="submit" id="btnComprar" name="btnComprar"
							class="flex-c-m stext-101 cl0 size-116 bg1 bor14 hov-btn3 p-lr-15 trans-04 pointer">Pagar</button>


					</div>

					<?php

					$catFotter = getCatFooter();



					function get_ws($data, $method, $type, $endpoint)
					{
						$curl = curl_init();

						/* AMBIENTE DE PRODUCCION */
									   $TbkApiKeyId = '597045358953';
									   $TbkApiKeySecret = '4db548a2-9ceb-4da1-8acb-750dce0435ec';
									   $url = "https://webpay3g.transbank.cl" . $endpoint;//Live

						/* AMBIENTE DE INTEGRACIÓN 
						$TbkApiKeyId = '597055555532';
						$TbkApiKeySecret = '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';
						$url = "https://webpay3gint.transbank.cl/" . $endpoint;
*/
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


					$baseurl = "https://" . $_SERVER['HTTP_HOST'] . "/carrito/metododepago";
					$url = "https://webpay3g.transbank.cl/";//Live
					//$url = "https://webpay3gint.transbank.cl/";//Testing
					
					$action = isset($_GET["action"]);
					$message = null;
					$post_array = false;

					switch ($action) {



						case "getResult": // OBTENER EL RESULTADO DE LA TRANSACCIÓN
					
							$message .= "<pre>" . print_r($_POST, TRUE) . "</pre>";

							$submit = 'Continuar!';
							if (!isset($_POST["token_ws"])) {
								echo "<script type='text/javascript'> Swal.fire(  'Transacción anulada',  'Error 021Null',  'error');</script>";
								break;
							}


							/** Token de la transacción */
							$token = filter_input(INPUT_POST, 'token_ws');

							$request = array(
								"token" => filter_input(INPUT_POST, 'token_ws')
							);

							$data = '';
							$method = 'PUT';
							$type = 'sandbox';
							$endpoint = '/rswebpaytransaction/api/webpay/v1.0/transactions/' . $token;

							$response = get_ws($data, $method, $type, $endpoint);

							$message .= "<pre>";
							$message .= print_r($response, TRUE);

							$message .= "</pre>";

							$url_tbk = $baseurl . "?action=getStatus";
							$submit = 'Ver Status!';

							$token_ws = $_POST["token_ws"];


							$montotransbank = $response->amount;
							$status_transbank = $response->status;
							$fecha_transaccion = $response->transaction_date;
							$buy_order = $response->buy_order;
							$payment_type_code = $response->payment_type_code;
							$responde_code = $response->responde_code;
							if ($payment_type_code == 'VD') {
								$payment_type_code = "Débito";
							} elseif ($payment_type_code == 'VD') {
								$payment_type_code = "Débito";
							} elseif ($payment_type_code == 'VP') {
								$payment_type_code = "Prepago";
							} elseif ($payment_type_code == 'VN') {
								$payment_type_code = "Credito Sin Cuotas";
							} elseif ($payment_type_code == 'VC') {
								$payment_type_code = "Credito En Cuotas";
							}

							$authorization_code = $response->authorization_code;
							$card_detail = $response->card_detail->card_number;








							?>



							<script type="text/javascript">





								/**
								 * Agrega una venta al sistema.
								 *
								 * @param float $montotransbank El monto de la transacción en Transbank.
								 * @param string $statustransbank El estado de la transacción en Transbank.
								 * @param string $card_detail Los detalles de la tarjeta utilizada en la transacción.
								 * @param string $payment_type_code El código del tipo de pago utilizado.
								 * @param string $buy_order El número de orden de compra.
								 * @param string $fecha_transaccion La fecha de la transacción.
								 * @param string $token_ws El token de la transacción en Webpay.
								 * @param string $authorization_code El código de autorización de la transacción.
								 * @return void
								 */

								function agregarVenta(montotransbank, statustransbank, card_detail, payment_type_code, buy_order, fecha_transaccion, token_ws, authorization_code) {


									base_url = "<?= base_url(); ?>";


									//let dir = document.querySelector("#direvalue").value;
									//let numero = document.querySelector("#direnumero").value;
									// let dpto = document.querySelector("#diredpto").value;
									//let region = document.querySelector("#direregion").value;
									// let comuna = document.querySelector("#direcomuna").value;	    
									// let referencia = document.querySelector("#direreferencia").value;
									let iddireccionselect = document.querySelector("#iddireccionselect").value;
									var inttipopago = payment_type_code;


									if (iddireccionselect === undefined) { swal("", "Complete datos de envío", "error"); return; }
									else {
										divLoading.style.display = "flex";
										let request = (window.XMLHttpRequest) ?
											new XMLHttpRequest() :
											new ActiveXObject('Microsoft.XMLHTTP');
										let ajaxUrl = base_url + '/Tienda/procesarVenta';
										let formData = new FormData(); // Crear instancia de FormData
										console.log("iddireccion" + iddireccionselect)
										formData.append('iddireccionselect', iddireccionselect);
										formData.append('token_ws', token_ws);
										formData.append('inttipopago', inttipopago);
										formData.append('montotransbank', montotransbank);
										formData.append('status_transbank', statustransbank);
										formData.append('buy_order', buy_order);
										formData.append('card_detail', card_detail);
										formData.append('payment_type_code', inttipopago);
										formData.append('fecha_transaccion', fecha_transaccion);
										formData.append('authorization_code', authorization_code);
										request.open("POST", ajaxUrl, true);
										request.send(formData);
										request.onreadystatechange = function () {
											if (request.readyState != 4) return;
											if (request.status == 200) {
												let objData = JSON.parse(request.responseText);
												if (objData.status) { // SI EXISTE OBJDATA STATUS
													window.location = base_url + "/tienda/confirmarpedido/";
												}
												else {


													if (objData.msg === "No es posible procesar el pedido, uno de los productos bajo su stock disponible. Vuelva al carrito para revisar el detalle") {


														let request = (window.XMLHttpRequest) ?
															new XMLHttpRequest() :
															new ActiveXObject('Microsoft.XMLHTTP');
														let ajaxUrl = base_url + '/Tienda/anularventaTransbank';
														let formData = new FormData();

														formData.append('token_ws', token_ws);
														formData.append('montotransbank', montotransbank);
														request.open("POST", ajaxUrl, true);
														request.send(formData);
														request.onreadystatechange = function () {
															if (request.readyState != 4) return;
															if (request.status == 200) {
																let objData = JSON.parse(request.responseText);
																if (objData.status) { // SI EXISTE OBJDATA STATUS
																	Swal.fire({
																		title: 'Hubo un error en la transacción',
																		text: "No es posible procesar el pedido, uno de los productos bajo su stock disponible! ",
																		icon: 'warning',
																		showCancelButton: true,
																		confirmButtonColor: '#3085d6',
																		cancelButtonColor: '#d33',
																		confirmButtonText: 'Volver al carrito'
																	}).then((result) => {
																		if (result.isConfirmed) {
																			window.location = base_url + "/carrito/procesarpago";
																		}
																	});

																}







															}
														}


													}
													else { Swal.fire("", objData.msg, "error"); }

												}
											}//FIN REQUEST STATUS 200 (OK)

											divLoading.style.display = "none";
											return false;
										}// FIN ONREADYSTATECHANGE


									}
								} // FIN FUNCION AGREGAR VENTA.



								token_ws = "<?php echo $token_ws; ?>";
								buy_order = "<?php echo $buy_order; ?>";
								fecha_transaccion = "<?php echo $fecha_transaccion; ?>";
								payment_type_code = "<?php echo $payment_type_code; ?>";
								card_detail = "<?php echo $card_detail; ?>";
								montotransbank = "<?php echo $montotransbank; ?>";
								statustransbank = "<?php echo $status_transbank; ?>";
								authorization_code = "<?php echo $authorization_code; ?>";





								agregarVenta(montotransbank, statustransbank, card_detail, payment_type_code, buy_order, fecha_transaccion, token_ws, authorization_code);


							</script>

							<?php
							break;





					}
					?>
					<div id="divCondiciones" style="margin-bottom:10px; margin-top:15px;">
						<input type="checkbox" id="condiciones" name="condiciones" onclick="validar()">
						<label for="condiciones"> Aceptar </label>
						<a href="#" data-toggle="modal" data-target="#modalTerminos"> Términos y Condiciones </a>
					</div>
					<div id="divpaypal" class="notblock">

						<br>
						<div>

							<p><i class="fa fa-lock"></i> Para completar la transacción, serás redirigido a los
								servidores seguros de Transbank.</p>
						</div>

						<div class="container">
							<div class="vertical-center">
								<div class="lds-hourglass"></div>



								<?php $baseenvio = "https://" . $_SERVER['HTTP_HOST'] . "/carrito/pagarwebpay";


								if (isset($_POST["TBK_TOKEN"])) {
									echo "Transaccion anulada";
								}
								?>
								<form name="brouterForm" id="brouterForm" method="POST" action="<?= $baseenvio ?>"
									style="display:block;">
									<input type="hidden" name="">
									<input type="submit" value="Procesar pago"
										class="flex-c-m stext-101 cl0 size-116 bg1 bor14 hov-btn3 p-lr-15 trans-04 pointer"
										style="background-color:;" />
								</form>



								<script type="text/javascript">
									document.addEventListener("DOMContentLoaded", function () {
										document.getElementById("brouterForm").addEventListener('submit', validarFormulario);
									});




									function validarFormulario(evento) {
										evento.preventDefault();

										if (validar() == true) {
											this.submit();
										}
										else {
											swal.fire("", "Debe aceptar terminos y condiciones", "success");
										}

									}


									function validar() {
										var checkBox = document.getElementById("condiciones");

										if (checkBox.checked == true) {
											return true;
										} else {

											swal.fire("", "Debe aceptar terminos y condiciones", "success");
											return false;
										}


									}







								</script>





							</div>
						</div>
					</div>


				</div>
			</div>

			<hr>


			<?php
			if (isset($_SESSION['login'])) {
				?>



			<?php } ?>
		</div>


	</div>
</div>
</div>

<?php
//echo $message;
footerTienda($data);

?>