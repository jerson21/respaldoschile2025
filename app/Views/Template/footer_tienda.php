	<?php 
		$catFotter = getCatFooter();
	 ?>
	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Categorías
					</h4>
					<?php if(count($catFotter) > 0){ ?>
					<ul>
						<?php foreach ($catFotter as $cat) { ?>
						<li class="p-b-10">
							<a href="<?= base_url() ?>/tienda/categoria/<?= $cat['idcategoria'].'/'.$cat['ruta'] ?>" class="stext-107 cl7 hov-cl1 trans-04">
								<?= $cat['nombre'] ?>
							</a>
						</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</div>

				<div class="col-sm-6 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Contacto
					</h4>

					<p class="stext-107 cl7 size-201">
						<?= DIRECCION ?> <br>
						Tel: <a class="linkFooter" href="tel:<?= TELEMPRESA ?>"><?= TELEMPRESA ?></a><br>
						Email: <a class="linkFooter" href="mailto:<?= EMAIL_EMPRESA ?>"><?= EMAIL_EMPRESA ?></a>
					</p>

					<div class="p-t-27">
						<a href="<?= FACEBOOK ?>" target="_blanck" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="<?= INSTAGRAM ?>" target="_blanck"  class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>

						<a href="https://wa.me/<?= WHATSAPP ?>" target="_blanck"  class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fab fa-whatsapp"></i>
						</a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Suscríbete
					</h4>

					<form id="frmSuscripcion" name="frmSuscripcion">
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" id="nombreSuscripcion" name="nombreSuscripcion" placeholder="Nombre completo" required>
							<div class="focus-input1 trans-04"></div>
						</div>
						<br>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="email" id="emailSuscripcion" name="emailSuscripcion" placeholder="email@email.com" required >
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Suscribirme
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="p-t-40">
				<p class="stext-107 cl6 txt-center">
					
					<?= NOMBRE_EMPESA; ?> 2025 | <?= WEB_EMPRESA; ?> 
					
				</p>
			</div>
		</div>
	</footer>
	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>
	<script>
	    const base_url = "<?= base_url(); ?>";
		const smony = "<?= SMONEY; ?>";
	</script>









	
<!--===============================================================================================-->	
	<script src="<?= media() ?>/tienda/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/bootstrap/js/popper.js"></script>
	<script src="<?= media() ?>/tienda/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= media() ?>/tienda/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/slick/slick.min.js"></script>
	<script src="<?= media() ?>/tienda/js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/parallax100/parallax100.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.all.min.js"></script><!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>

	    <script type="text/javascript" src="<?= media() ?>/css/floating/floating-wpp.js"></script>
<!--===============================================================================================-->

<script type="text/javascript">
    $(function () {
        $('#myButton').floatingWhatsApp({
            phone: '56979941253',
            popupMessage: 'Hola, en que te podemos ayudar?',
            message: "",
            showPopup: true,
            showOnIE: false,
            headerTitle: 'Ejecutivo Virtual Respaldos Chile!',
            headerColor: 'rgb(9, 94, 84)',
            backgroundColor: 'Green',
            buttonImage: '<img src="<?= media() ?>/css/floating/whatsapp.svg" />'
        });
    });</script>

	<script src="<?= media();?>/js/fontawesome.js?v2"></script>
	<script src="<?= media() ?>/tienda/js/main.js?v2"></script>
	<script src="<?= media();?>/js/functions_admin.js?v2"></script>
	<script src="<?= media() ?>/js/functions_login.js?v2"></script>
	<script src="<?= media() ?>/tienda/js/functions.js?v2"></script>

	
</body>
</html>