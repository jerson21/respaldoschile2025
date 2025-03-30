<?php
headerTienda($data);

$subtotal = 0;
$total = 0;
foreach ($_SESSION['arrCarrito'] as $producto) {
	$subtotal += $producto['precio'] * $producto['cantidad'];
}


unset($_SESSION['precio_envio']);
unset($_SESSION['iddireccion']);
$total = $subtotal + COSTOENVIO;

$tituloTerminos = !empty(getInfoPage(PTERMINOS)) ? getInfoPage(PTERMINOS)['titulo'] : "";
$infoTerminos = !empty(getInfoPage(PTERMINOS)) ? getInfoPage(PTERMINOS)['contenido'] : "";

?>




<!-- Modal -->
<div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?= $tituloTerminos ?></h5>
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
<div class="container">
	<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
		<a href="<?= base_url() ?>" class="stext-109 cl8 hov-cl1 trans-04">
			Inicio
			<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
		</a>
		<span class="stext-109 cl4">
			<?= $data['page_title'] ?>
		</span>
	</div>
</div>
<br>
<div class="container">
	<style>
		.boxis {
			font-weight: bold;
			cursor: pointer;
			border: solid;
			border-width: 1px;
			border-radius: 5px;
			padding: 5px;
		}

		.boxis:hover {
			background-color: #DF0101 !important;
			color: white;

		}

		.actiontr {
			background-color: #DF0101 !important;
			color: white;
		}
	</style>
	<div class="row">
		<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">


			<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-l-25 m-r--38 m-lr-0-xl ">

				<div>

					<?php
					if (isset($_SESSION['login'])) {
						$inputs = "";
						?>
						<!-- DIV SELECCION DE METODO DE ENTREGA -->
						<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-l-25 m-r--38 m-lr-0-xl" style="margin:auto; ">

							<div style="display : flex; flex-direction : row; font-size:17px; color:black;   align-items: center;
  justify-content: center; text-align: center; ">

								<div id="retiroentienda" class="stext-204 cl3 boxis" onclick="abrir('retiro');"
									style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
									<div class="boxis">


										<i class="fa-solid fa-location-dot"></i> Retiro en Tienda

									</div>
								</div>




								<div id="despachoadomicilio" class="stext-204 cl3 boxis" onclick="abrir('despacho');"
									style=" margin-left: 10px;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
									<div class=" boxis">


										<i class="fa-solid fa-truck"></i> Despacho a domicilio

									</div>
								</div>

							</div>

						</div><br>
						<div id="retiroenlocal" class="stext-102 cl3 notblock">

							<i class="fa-solid fa-location-dot"></i> Retiro en: Av Uno 10185, La Florida, Santiago.
						</div>
						<br>
						<div id="direccion" style="background-color:white">
							<?php $this->con = new Mysql();
							$request = array();
							$suma = 0;
							$tienedireccion = false;
							$rut_cliente = $_SESSION['userData']['identificacion'];
							$sql = "SELECT * FROM direccion_cliente where rut_cliente = '$rut_cliente'";
							$requestPedido = $this->con->select($sql);
							if ($requestPedido > 0) {
								$sql_detalle = "SELECT * FROM direccion_cliente where rut_cliente = '$rut_cliente'";
								$requestProductos = $this->con->select_all($sql_detalle);
								$request = array(
									'direccion' => $requestProductos,
									'numero' => $requestProductos
								);
								foreach ($requestProductos as $form) { ?>
									<br>
									<div id="direccion2" style="background-color:#E0F8E6; padding: 15px; border-radius: 5px;">
										<span class="stext-102 cl3" style="font-weight:bold;">Direccion:</span><br>

										<span class="stext-102 cl3">
											<i class="fa-solid fa-location-dot"></i>
											<?php
											$detalle_dir = $form['direccion'] . " " . $form['numero'] . ", " . $form['dpto'] . ", " . $form['region'] . ", " . $form['comuna'];
											echo ucwords($detalle_dir);
											echo "<br>";
											echo '<span style="font-weight: bold;">Referencia:</span><br>';
											echo $form['referencia'];


											echo $inputs = '
									<input type="hidden" id="direid" name="direid" value="' . $form["id"] . '">
    <input type="hidden" id="direvalue" name="direvalue" value="' . $form["direccion"] . '">
    <input type="hidden" id="direnumero" name="direnumero" value="' . $form["numero"] . '">
    <input type="hidden" id="diredpto" name="diredpto" value="' . $form["dpto"] . '">
    <input type="hidden" id="direregion" name="direregion" value="' . $form["region"] . '"> 
    <input type="hidden" id="direcomuna" name="direcomuna" value="' . $form["comuna"] . '">
    <input type="hidden" id="direreferencia" name="direreferencia" value="' . $form["referencia"] . '">
    <span style="float:right;">
        <label>
            <input type="checkbox" class="direccion-checkbox" id="iddireccion' . $form["id"] . '" onClick="cambiarprecio(this)" name="iddireccion" value="' . $form["id"] . '" data-precio="">Seleccionar
        </label>
    </span>
    <br> <br>';


											?>

									</div>
									</span>




									</script>
									<?php

								}
							} ?>
						</div>
						<br>
						<div id="direccion">
							<input class="flex-c-m stext-101 cl0 size-116 bg1 bor14 hov-btn3 p-lr-15 trans-04 pointer"
								onclick="agregarunadireccion();" type="button" value="Agregar Direccion">
						</div>
						<script type="text/javascript">
							function agregarunadireccion() {
								document.querySelector("#direccion_nueva").classList.remove("notblock");
								document.querySelector("#direccion").classList.add("notblock");
							}
						</script>



						<input type="hidden" id="retiroenlatienda" name="retiroenlatienda" value="0">

						<br>
						<div id="direccion_nueva" name="direccion_nueva " class="notblock">
							<form id="formDireccion">
								<div>

									<label for="tipopago">Dirección de envío</label>
									<div class="bor8 bg0 m-b-12">



										<input id="txtDireccion" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
											name="txtDireccion" placeholder="Calle" /required>
									</div>
									<div class="bor8 bg0 m-b-10">
										<input id="txtDirNumero" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
											name="txtDirNumero" placeholder="Numero" /required>
									</div>
									<div class="bor8 bg0 m-b-22">
										<input id="txtDirDpto" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
											name="txtDirDpto" placeholder="Dpto/Casa/oficina">
									</div>
									<div class=" bg0 m-b-22">
										<select class=" cl8 plh3 size-111 " style="display: block;
  font-size: 16px;
  font-family: 'Verdana', sans-serif;
  font-weight: 400;
  color: #444;
  line-height: 1.3;
  padding: .4em 1.4em .3em .8em;
 
  max-width: 100%; 
  box-sizing: border-box;
 
  border: 1px solid #aaa;
  box-shadow: 0 1px 0 1px rgba(0,0,0,.03);
  border-radius: .3em;
  -moz-appearance: none;
  -webkit-appearance: none;
  appearance: none;
  background-color: #fff;" id="regiones" name="regiones" required="required"></select>
									</div>
									<div class=" bg0 m-b-22">
										<select class="cl8 plh3 size-111" style="display: block;
  font-size: 16px;
  font-family: 'Verdana', sans-serif;
  font-weight: 400;
  color: #444;
  line-height: 1.3;
  padding: .4em 1.4em .3em .8em;
 
  max-width: 100%; 
  box-sizing: border-box;
 
  border: 1px solid #aaa;
  box-shadow: 0 1px 0 1px rgba(0,0,0,.03);
  border-radius: .3em;
  -moz-appearance: none;
  -webkit-appearance: none;
  appearance: none;
  background-color: #fff;" id="comunas" name="comunas" required="required"></select>
									</div>

									<div class="bor8 bg0 m-b-12">



										<textarea name="instrucciones" id="instrucciones"
											class="stext-111 cl8 plh3 size-111 p-lr-15"
											placeholder="Instrucciones de entrega"></textarea>
									</div>

									<div class="bor8 bg0 m-b-22">
										<input id="txtNombredir" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
											name="txtNombredir" placeholder="Nombre direccion / Ej: Mi Casa">
									</div>



									<button type="submit" class="btn btn-primary">Ingresar direccion</button>
								</div>
							</form>

						</div>


						<?php

						if ($tienedireccion == false) {
							?>

							<div id="direccion" name="direccion" class="notblock">
								<form id="formDireccion">
									<div>

										<label for="tipopago">Dirección de envío</label>
										<div class="bor8 bg0 m-b-12">



											<input id="txtDireccion" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
												name="txtDireccion" placeholder="Calle" /required>
										</div>
										<div class="bor8 bg0 m-b-10">
											<input id="txtDirNumero" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
												name="txtDirNumero" placeholder="Numero" /required>
										</div>
										<div class="bor8 bg0 m-b-22">
											<input id="txtDirDpto" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
												name="txtDirDpto" placeholder="Dpto/Casa/oficina">
										</div>
										<div class=" bg0 m-b-22">
											<select class=" cl8 plh3 size-111 " style="display: block;
  font-size: 16px;
  font-family: 'Verdana', sans-serif;
  font-weight: 400;
  color: #444;
  line-height: 1.3;
  padding: .4em 1.4em .3em .8em;
 
  max-width: 100%; 
  box-sizing: border-box;
 
  border: 1px solid #aaa;
  box-shadow: 0 1px 0 1px rgba(0,0,0,.03);
  border-radius: .3em;
  -moz-appearance: none;
  -webkit-appearance: none;
  appearance: none;
  background-color: #fff;" id="regiones" name="regiones" required="required"></select>
										</div>
										<div class=" bg0 m-b-22">
											<select class="cl8 plh3 size-111" style="display: block;
  font-size: 16px;
  font-family: 'Verdana', sans-serif;
  font-weight: 400;
  color: #444;
  line-height: 1.3;
  padding: .4em 1.4em .3em .8em;
 
  max-width: 100%; 
  box-sizing: border-box;
 
  border: 1px solid #aaa;
  box-shadow: 0 1px 0 1px rgba(0,0,0,.03);
  border-radius: .3em;
  -moz-appearance: none;
  -webkit-appearance: none;
  appearance: none;
  background-color: #fff;" id="comunas" name="comunas" required="required"></select>
										</div>

										<div class="bor8 bg0 m-b-12">



											<textarea name="instrucciones" id="instrucciones"
												class="stext-111 cl8 plh3 size-111 p-lr-15"
												placeholder="Instrucciones de entrega"></textarea>
										</div>

										<div class="bor8 bg0 m-b-22">
											<input id="txtNombredir" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
												name="txtNombredir" placeholder="Nombre direccion / Ej: Mi Casa">
										</div>



										<button type="submit" class="btn btn-primary">Ingresar direccion</button>
									</div>
								</form>

							</div>
							<?php
						}
					} else { ?>

						<ul class="nav nav-tabs" id="myTab" role="tablist">

							<li class="nav-item">
								<a class="nav-link active" id="profile-tab" data-toggle="tab" href="#registro" role="tab"
									aria-controls="profile" aria-selected="true">Ingreso invitado </a>
							</li>
							<li class="nav-item">
								<a class="nav-link " id="home-tab" data-toggle="tab" href="#login" role="tab"
									aria-controls="home" aria-selected="false">Iniciar Sesión</a>
							</li>
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade " id="login" role="tabpanel" aria-labelledby="home-tab">
								<br>
								<form id="formLogin">
									<div class="form-group">
										<label for="txtEmail">Usuario</label>
										<input type="email" class="form-control" id="txtEmail" name="txtEmail">
									</div>
									<div class="form-group">
										<label for="txtPassword">Contraseña</label>
										<input type="password" class="form-control" id="txtPassword" name="txtPassword">
									</div>
									<button type="submit" class="btn btn-primary">Iniciar sesión</button>
								</form>

							</div>
							<div class="tab-pane fade show active" id="registro" role="tabpanel"
								aria-labelledby="profile-tab">

								<span class="stext-102 cl2 p-b-30">Solicitamos únicamente la información esencial para la
									finalización de la compra.</span><br><br>
								<form id="formRegister">
									<div class="row">
										<div class="col col-md-6 form-group">
											<label for="txtNombre">Nombre</label>
											<input type="text" class="form-control valid validText" id="txtNombre"
												name="txtNombre" placeholder="" required="">
										</div>
										<div class="col col-md-6 form-group">
											<label for="txtApellido">Apellido</label>
											<input type="text" class="form-control valid validText" id="txtApellido"
												name="txtApellido" placeholder="" required="">
										</div>
									</div>
									<div class="row">
										<div class="col col-md-6 form-group">
											<label for="txtTelefono">Teléfono</label>
											<input type="tel" size="9" class="form-control valid validNumber"
												id="txtTelefono" name="txtTelefono" placeholder="Ingresa tu Telefono"
												required="" onkeypress="return controlTag(event);">
										</div>
										<div class="col col-md-6 form-group">
											<label for="txtEmailCliente">Email</label>
											<input type="email" class="form-control valid validEmail" id="txtEmailCliente"
												name="txtEmailCliente" placeholder="Ingresa un email válido">
										</div>
									</div>
									<div class="row">
										<div class="col col-md-6 form-group">
											<label for="txtRut">Rut</label>
											<input type="text" class="form-control" id="txtRut" name="txtRut"
												placeholder="Ingresa tu RUT" oninput="checkRute(this)">
										</div>
										<script type="text/javascript">
											function checkRute(rut) {
												// Despejar Puntos
												var valor = rut.value.replace('.', '');
												// Despejar Guión
												valor = valor.replace('-', '');

												// Aislar Cuerpo y Dígito Verificador
												cuerpo = valor.slice(0, -1);
												dv = valor.slice(-1).toUpperCase();

												// Formatear RUN
												rut.value = cuerpo + '-' + dv

												// Si no cumple con el mínimo ej. (n.nnn.nnn)
												if (cuerpo.length < 7) {
													return false;
												}

												// Calcular Dígito Verificador
												suma = 0;
												multiplo = 2;

												// Para cada dígito del Cuerpo
												for (i = 1; i <= cuerpo.length; i++) {

													// Obtener su Producto con el Múltiplo Correspondiente
													index = multiplo * valor.charAt(cuerpo.length - i);

													// Sumar al Contador General
													suma = suma + index;

													// Consolidar Múltiplo dentro del rango [2,7]
													if (multiplo < 7) {
														multiplo = multiplo + 1;
													} else {
														multiplo = 2;
													}

												}

												// Calcular Dígito Verificador en base al Módulo 11
												dvEsperado = 11 - (suma % 11);

												// Casos Especiales (0 y K)
												dv = (dv == 'K') ? 10 : dv;
												dv = (dv == 0) ? 11 : dv;

												// Validar que el Cuerpo coincide con su Dígito Verificador
												if (dvEsperado != dv) {
													return false;
												}

												// Si todo sale bien, eliminar errores (decretar que es válido)

											}
										</script>

									</div>
									<button type="submit" class="btn btn-primary">Ingresar</button>
								</form>
							</div>
						</div>

					<?php } ?>
				</div>
			</div>
		</div>

		<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
			<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
				<h4 class="mtext-109 cl2 p-b-30">
					Resumen
				</h4>

				<div class="flex-w flex-t bor12 p-b-13">
					<div class="size-208">
						<span class="stext-110 cl2">
							Subtotal:
						</span>
					</div>

					<div class="size-209">
						<span id="subTotalCompra" class="mtext-110 cl2">

							<table>
								<th>$</th>
								<th>
									<?= number_format($subtotal) ?>
								</th>
							</table>
						</span>
					</div>

					<div class="size-208">
						<span class="stext-110 cl2">
							Envío:
						</span>
					</div>

					<div class="size-209">
						<span class="mtext-110 cl2">
							<table>
								<th>$</th>
								<th>
									<span id="costoenvio" name="costoenvio">
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

					<div class="size-209 p-t-1">

						<span id="totalCompra" class="mtext-110 cl2">
							<table>
								<th>$</th>
								<th>
									<input type="text" id="totalcompra" name="totalcompra" value="<?= $subtotal ?>">

								</th>

							</table>
						</span>
					</div>
				</div>
				<div id="mensj"></div>
				<hr>
				<?php
				if (isset($_SESSION['login'])) {
					?>


					<div id="divMetodoPago">

						<div id="optMetodoPago">

							<br>
							<form id="formulariodireccion" method="post" action="<?= base_url(); ?>/carrito/metododepago">

								<input type="hidden" id="iddireccionselect" name="iddireccionselect" value="">
								<input type="hidden" id="datos" name="datos" value='<?php echo $inputs; ?>'>
								<input type="hidden" name="retiro" id="retiro" value="">

								<?php
								$carro = $_SESSION['arrCarrito'];
								$suma = 0;
								foreach ($carro as $pre) {
									$idprod = $pre['idproducto'];
									$sql = "SELECT * FROM producto where idproducto = $idprod";
									$requestPedido = $this->con->select_all($sql);

									foreach ($requestPedido as $form) {



										$stock = $form['stock'];
										$cantidad_carro = $pre['cantidad'];


										if ($cantidad_carro <= $stock) {
										} else {

											$suma = $suma + 1;
											$idProducto = openssl_encrypt($idprod, METHODENCRIPT, KEY);
											?>
											<i class="fa fa-exclamation-circle " style="color:red;"></i>Ups!<br>
											Quedan <?php echo $form['stock']; ?> unidades de <?php echo $form['nombre']; ?>
											<div id="boton_delete" class="header-cart-item-img" idpr="<?= $idProducto ?>" op="1"
												onclick="fntdelItem(this)"> </div>

											<?php

											?></br></br>
											<button class="flex-c-m stext-101 cl0 size-116 bg1 bor14 hov-btn3 p-lr-15 trans-04 pointer"
												onClick="history.go(0);">Actualizar Carrito</button>
											<?php


											// Consulta si el stock de producto es mayor a 0 
											if (is_numeric($idprod) and $stock > 0) {
												$arrCarrito = $_SESSION['arrCarrito'];
												for ($p = 0; $p < count($arrCarrito); $p++) {



													if ($arrCarrito[$p]['idproducto'] == $idprod) {
														$arrCarrito[$p]['cantidad'] = $stock;
														$totalProducto = $arrCarrito[$p]['precio'] * $stock;
														break;
													}
												}
												// SI SE CUMPLE LA PRIMERA CONDICION MULTIPLICA LA CANTIDAD POR PRECIO Y ASIGNA SUBTOTAL.
												$_SESSION['arrCarrito'] = $arrCarrito;
												foreach ($_SESSION['arrCarrito'] as $pro) {
													$subtotal += $pro['cantidad'] * $pro['precio'];
												}
											}


											if (is_numeric($idprod) and $stock == 0) {
												$arrCarrito = $_SESSION['arrCarrito'];
												for ($p = 0; $p < count($arrCarrito); $p++) {



													if ($arrCarrito[$p]['idproducto'] == $idprod) {
														$arrCarrito[$p]['cantidad'] = 0;
														$totalProducto = $arrCarrito[$p]['precio'] * 0;
														break;
													}
												}
												$_SESSION['arrCarrito'] = $arrCarrito;
												foreach ($_SESSION['arrCarrito'] as $pro) {
													$subtotal += $pro['cantidad'] * $pro['precio'];
												}
											}
										}
										if ($stock == 0) {
											$idProducto = openssl_encrypt($idprod, METHODENCRIPT, KEY);

											?>

											<script type="text/javascript">
												base_url = "<?= base_url(); ?>";

												deletItem("1", "<?= $idProducto ?>");

												function deletItem(options, idprr) {
													//Option 1 = Modal
													//Option 2 = Vista Carrito
													let option = options;
													let idpr = idprr;
													if (option == 1 || option == 2) {

														let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
														let ajaxUrl = base_url + '/Tienda/delCarrito';
														let formData = new FormData();
														formData.append('id', idpr);
														formData.append('option', option);
														request.open("POST", ajaxUrl, true);
														request.send(formData);
														request.onreadystatechange = function () {
															if (request.readyState != 4) return;
															if (request.status == 200) {
																let objData = JSON.parse(request.responseText);
																if (objData.status) {
																	if (option == 1) {
																		document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
																		const cants = document.querySelectorAll(".cantCarrito");
																		cants.forEach(element => {
																			element.setAttribute("data-notify", objData.cantCarrito)
																		});
																	} else {
																		element.parentNode.parentNode.remove();
																		document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
																		document.querySelector("#totalCompra").innerHTML = objData.total;

																		if (document.querySelectorAll("#tblCarrito tr").length == 1) {
																			window.location.href = base_url;
																		}
																	}
																} else {
																	swal("", objData.msg, "error");
																}
															}
															return false;
														}

													}
												}
											</script>
											<?php

										}
									}
								}




								if ($suma < 1) {

									?>

									<button type="submit" id="continuarmetododepago1"
										class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Continuar</button>
									<?php
								}


								?>


							</form>
						</div>


					</div>

				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php
footerTienda($data);
?>



<script type="text/javascript">
	var RegionesYcomunas = {

		"regiones": [{
			"NombreRegion": "Arica y Parinacota",
			"comunas": ["Arica", "Camarones", "Putre", "General Lagos"]
		},
		{
			"NombreRegion": "Tarapacá",
			"comunas": ["Iquique", "Alto Hospicio", "Pozo Almonte", "Camiña", "Colchane", "Huara", "Pica"]
		},
		{
			"NombreRegion": "Antofagasta",
			"comunas": ["Antofagasta", "Mejillones", "Sierra Gorda", "Taltal", "Calama", "Ollagüe", "San Pedro de Atacama", "Tocopilla", "María Elena"]
		},
		{
			"NombreRegion": "Atacama",
			"comunas": ["Copiapó", "Caldera", "Tierra Amarilla", "Chañaral", "Diego de Almagro", "Vallenar", "Alto del Carmen", "Freirina", "Huasco"]
		},
		{
			"NombreRegion": "Coquimbo",
			"comunas": ["La Serena", "Coquimbo", "Andacollo", "La Higuera", "Paiguano", "Vicuña", "Illapel", "Canela", "Los Vilos", "Salamanca", "Ovalle", "Combarbalá", "Monte Patria", "Punitaqui", "Río Hurtado"]
		},
		{
			"NombreRegion": "Valparaíso",
			"comunas": ["Valparaíso", "Casablanca", "Concón", "Juan Fernández", "Puchuncaví", "Quintero", "Viña del Mar", "Isla de Pascua", "Los Andes", "Calle Larga", "Rinconada", "San Esteban", "La Ligua", "Cabildo", "Papudo", "Petorca", "Zapallar", "Quillota", "Calera", "Hijuelas", "La Cruz", "Nogales", "San Antonio", "Algarrobo", "Cartagena", "El Quisco", "El Tabo", "Santo Domingo", "San Felipe", "Catemu", "Llaillay", "Panquehue", "Putaendo", "Santa María", "Quilpué", "Limache", "Olmué", "Villa Alemana"]
		},
		{
			"NombreRegion": "Región del Libertador Gral. Bernardo O’Higgins",
			"comunas": ["Rancagua", "Codegua", "Coinco", "Coltauco", "Doñihue", "Graneros", "Las Cabras", "Machalí", "Malloa", "Mostazal", "Olivar", "Peumo", "Pichidegua", "Quinta de Tilcoco", "Rengo", "Requínoa", "San Vicente", "Pichilemu", "La Estrella", "Litueche", "Marchihue", "Navidad", "Paredones", "San Fernando", "Chépica", "Chimbarongo", "Lolol", "Nancagua", "Palmilla", "Peralillo", "Placilla", "Pumanque", "Santa Cruz"]
		},
		{
			"NombreRegion": "Región del Maule",
			"comunas": ["Talca", "ConsVtución", "Curepto", "Empedrado", "Maule", "Pelarco", "Pencahue", "Río Claro", "San Clemente", "San Rafael", "Cauquenes", "Chanco", "Pelluhue", "Curicó", "Hualañé", "Licantén", "Molina", "Rauco", "Romeral", "Sagrada Familia", "Teno", "Vichuquén", "Linares", "Colbún", "Longaví", "Parral", "ReVro", "San Javier", "Villa Alegre", "Yerbas Buenas"]
		},
		{
			"NombreRegion": "Región del Biobío",
			"comunas": ["Concepción", "Coronel", "Chiguayante", "Florida", "Hualqui", "Lota", "Penco", "San Pedro de la Paz", "Santa Juana", "Talcahuano", "Tomé", "Hualpén", "Lebu", "Arauco", "Cañete", "Contulmo", "Curanilahue", "Los Álamos", "Tirúa", "Los Ángeles", "Antuco", "Cabrero", "Laja", "Mulchén", "Nacimiento", "Negrete", "Quilaco", "Quilleco", "San Rosendo", "Santa Bárbara", "Tucapel", "Yumbel", "Alto Biobío", "Chillán", "Bulnes", "Cobquecura", "Coelemu", "Coihueco", "Chillán Viejo", "El Carmen", "Ninhue", "Ñiquén", "Pemuco", "Pinto", "Portezuelo", "Quillón", "Quirihue", "Ránquil", "San Carlos", "San Fabián", "San Ignacio", "San Nicolás", "Treguaco", "Yungay"]
		},
		{
			"NombreRegion": "Región de la Araucanía",
			"comunas": ["Temuco", "Carahue", "Cunco", "Curarrehue", "Freire", "Galvarino", "Gorbea", "Lautaro", "Loncoche", "Melipeuco", "Nueva Imperial", "Padre las Casas", "Perquenco", "Pitrufquén", "Pucón", "Saavedra", "Teodoro Schmidt", "Toltén", "Vilcún", "Villarrica", "Cholchol", "Angol", "Collipulli", "Curacautín", "Ercilla", "Lonquimay", "Los Sauces", "Lumaco", "Purén", "Renaico", "Traiguén", "Victoria",]
		},
		{
			"NombreRegion": "Región de Los Ríos",
			"comunas": ["Valdivia", "Corral", "Lanco", "Los Lagos", "Máfil", "Mariquina", "Paillaco", "Panguipulli", "La Unión", "Futrono", "Lago Ranco", "Río Bueno"]
		},
		{
			"NombreRegion": "Región de Los Lagos",
			"comunas": ["Puerto Montt", "Calbuco", "Cochamó", "Fresia", "FruVllar", "Los Muermos", "Llanquihue", "Maullín", "Puerto Varas", "Castro", "Ancud", "Chonchi", "Curaco de Vélez", "Dalcahue", "Puqueldón", "Queilén", "Quellón", "Quemchi", "Quinchao", "Osorno", "Puerto Octay", "Purranque", "Puyehue", "Río Negro", "San Juan de la Costa", "San Pablo", "Chaitén", "Futaleufú", "Hualaihué", "Palena"]
		},
		{
			"NombreRegion": "Región Aisén del Gral. Carlos Ibáñez del Campo",
			"comunas": ["Coihaique", "Lago Verde", "Aisén", "Cisnes", "Guaitecas", "Cochrane", "O’Higgins", "Tortel", "Chile Chico", "Río Ibáñez"]
		},
		{
			"NombreRegion": "Región de Magallanes y de la Antárica Chilena",
			"comunas": ["Punta Arenas", "Laguna Blanca", "Río Verde", "San Gregorio", "Cabo de Hornos (Ex Navarino)", "AntárVca", "Porvenir", "Primavera", "Timaukel", "Natales", "Torres del Paine"]
		},
		{
			"NombreRegion": "Región Metropolitana de Santiago",
			"comunas": ["Cerrillos", "Cerro Navia", "Conchalí", "El Bosque", "Estación Central", "Huechuraba", "Independencia", "La Cisterna", "La Florida", "La Granja", "La Pintana", "La Reina", "Las Condes", "Lo Barnechea", "Lo Espejo", "Lo Prado", "Macul", "Maipú", "Ñuñoa", "Pedro Aguirre Cerda", "Peñalolén", "Providencia", "Pudahuel", "Puente Alto", "Quilicura", "Quinta Normal", "Recoleta", "Renca", "San Joaquín", "San Miguel", "San Ramón", "Santiago", "Vitacura", "Pirque", "San José de Maipo", "Colina", "Lampa", "TilTil", "San Bernardo", "Buin", "Calera de Tango", "Paine", "Melipilla", "Alhué", "Curacaví", "María Pinto", "San Pedro", "Talagante", "El Monte", "Isla de Maipo", "Padre Hurtado", "Peñaflor"]
		}
		]
	}


	jQuery(document).ready(function () {


		var iRegion = 0;
		var htmlRegion = '<option selected disabled value="">Seleccione región</option>';
		var htmlComunas = '<option selected disabled value="">Seleccione comuna</option>';

		jQuery.each(RegionesYcomunas.regiones, function () {
			htmlRegion = htmlRegion + '<option value="' + RegionesYcomunas.regiones[iRegion].NombreRegion + '">' + RegionesYcomunas.regiones[iRegion].NombreRegion + '</option>';
			iRegion++;
		});

		jQuery('#regiones').html(htmlRegion);
		jQuery('#comunas').html(htmlComunas);

		jQuery('#regiones').change(function () {
			var iRegiones = 0;
			var valorRegion = jQuery(this).val();
			var htmlComuna = '<option selected disabled value="">Seleccione comuna</option>';
			jQuery.each(RegionesYcomunas.regiones, function () {
				if (RegionesYcomunas.regiones[iRegiones].NombreRegion == valorRegion) {
					var iComunas = 0;
					jQuery.each(RegionesYcomunas.regiones[iRegiones].comunas, function () {

						htmlComuna = htmlComuna + '<option value="' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '">' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '</option>';
						iComunas++;
					});
				}
				iRegiones++;
			});
			jQuery('#comunas').html(htmlComuna);
		});
		jQuery('#comunas').change(function () {
			if (jQuery(this).val() == 'sin-region') {
				alert('selecciones Región');
			} else if (jQuery(this).val() == 'sin-comuna') {
				alert('selecciones Comuna');
			}
		});
		jQuery('#regiones').change(function () {
			if (jQuery(this).val() == 'sin-region') {
				alert('selecciones Región');
			}
		});

	});
</script>