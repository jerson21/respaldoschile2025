<?php
headerTienda($data);
$arrProductos = $data['productos'];

?>
<hr>
<!-- Product -->
<div class="bg0 m-t-23 p-b-140">
	<div class="container">
		<span class="stext-102" style="background:black;color:white;padding:5px;border-radius: 5px; "><i class="fa-solid fa-cart-shopping"></i> Descuentos2025</span>
		<div class="flex-w flex-sb-m p-b-52">

			<div class="flex-w flex-l-m filter-tope-group m-tb-10">
				<h3><?= $data['page_title']; ?></h3>
			</div>

			<div class="flex-w flex-c-m m-tb-10">
				<div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
					&nbsp;&nbsp;
					<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
					<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
					Categoría &nbsp;
				</div>
			</div>
			<!-- Filter -->
			<div class="dis-none panel-filter w-full p-t-10">
				<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
					<div class="filter-col4 p-b-27">
						<div class="mtext-102 cl2 p-b-15">
							Categorías
						</div>

						<div class="flex-w p-t-4 m-r--5">
							<?php
							if (count($data['categorias']) > 0) {
								foreach ($data['categorias'] as $categoria) {
							?>
									<a href="<?= base_url() ?>/tienda/categoria/<?= $categoria['idcategoria'] . '/' . $categoria['ruta'] ?>" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
										<?= $categoria['nombre'] ?> <span> &nbsp;(<?= $categoria['cantidad'] ?>)</span>
									</a>
							<?php
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="text-center"><span class="stext-107" style="background:black;color:white;padding:2px;border-radius: 5px; ">&#8226; Para elegir tamaños y colores ingresa al producto &#8226;</span></div>


		<div id="landing_home1" class="autotag">

			<section id="lo_tenemos_todo">
				<div id="carrusel_tenemos_todo">

					<div id="splide_1" class="splide splide--loop splide--ltr splide--draggable is-active" style="visibility: visible;">
						<div class="splide__arrows"><button class="splide__arrow splide__arrow--prev" type="button" aria-controls="splide_1-track" aria-label="Previous slide"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">
									<path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path>
								</svg></button><button class="splide__arrow splide__arrow--next" type="button" aria-controls="splide_1-track" aria-label="Next slide"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">
									<path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path>
								</svg></button></div>
						<div class="splide__track" id="splide_1-track">
							<ul class="splide__list" id="splide_1-list" style="transform: translateX(-3990px);">


								<?php if (count($data['categorias']) > 0) {
									foreach ($data['categorias'] as $categoria) {
										echo '<li class="splide__slide splide__slide--clone" style="width: 190px;">';
								?>

										<div class="tenemos_todo1">

											<a href="<?= base_url() ?>/tienda/categoria/<?= $categoria['idcategoria'] . '/' . $categoria['ruta'] ?>" rpl_sp="carrusel-cat-ltt-_-dormitorio-_-https://simple.ripley.cl/dormitorio">
												<div class="circulo">
													<picture>

														<source media="(min-width: 700px)" type="image/webp" srcset="<?= $categoria['portada'] ?>" alt="">

														<source media="(min-width: 700px)" srcset="<?= $categoria['portada'] ?>">

														<source type="image/webp" srcset="<?= $categoria['portada'] ?>" alt="">

														<img src="<?= $categoria['portada'] ?>">
													</picture>
												</div>
											</a>
											<p><?= $categoria['nombre'] ?></p>
										</div>
										</li>
								<?php
									}
								}
								?>









							</ul>
						</div>
					</div>
				</div>
			</section>

		</div>

		<div class="row isotope-grid">

			<?php
			if (count($arrProductos) > 0) {
				for ($p = 0; $p < count($arrProductos); $p++) {
					$ruta = $arrProductos[$p]['ruta'];
					if (count($arrProductos[$p]['images']) > 0) {
						$portada = $arrProductos[$p]['images'][0]['url_image'];
					} else {
						$portada = media() . '/images/uploads/product.png';
					}
			?>

					<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0" style="border-radius: 30px; z-index: 0;">
								<?php //if($arrProductos[$p]['tipo_prod'] == "1"){

								$descuento = "";
								$multiplic = "";
								$existedescuento = false;

								if (count($arrProductos[$p]['descuento']) > 0) {
									$descuento = $arrProductos[$p]['descuento'][0]['descuento'] . " " . $arrProductos[$p]['descuento'][0]['precio'];
									$precio = $arrProductos[$p]['descuento'][0]['precio'];

									if ($precio > 0) {
										$multiplic = 100 * intval($arrProductos[$p]['descuento'][0]['descuento']);
										$descuento = round($multiplic / $arrProductos[$p]['descuento'][0]['precio']);
										$existedescuento = true;
									}
								}





								?>
								<?php
								if ($descuento > 0) { ?>
									<span class="oferta">
										<?php echo  "-" . $descuento . "%"; //} 
										?>




									</span> <?php } ?>

								<img src="<?= $portada ?>" alt="<?= $arrProductos[$p]['nombre'] ?>">

								<a href="<?= base_url() . '/tienda/producto/' . $arrProductos[$p]['idproducto'] . '/' . $ruta; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">

									Ver producto
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="<?= base_url() . '/tienda/producto/' . $arrProductos[$p]['idproducto'] . '/' . $ruta; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										<?= $arrProductos[$p]['nombre'] ?>
									</a>
									<span class="stext-105 cl3">
										<?php if ($arrProductos[$p]['precio'] != '0') { ?>
											<?= SMONEY . formatMoney($arrProductos[$p]['precio']); ?>
										<?php  } ?>
									</span>
								</div>
								<?php if ($arrProductos[$p]['precio'] != '0') { ?>
									<!--<div class="block2-txt-child2 flex-r p-t-3">

							 	<a href="#"
								 id="<?= openssl_encrypt($arrProductos[$p]['idproducto'], METHODENCRIPT, KEY); ?>"
								 class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 js-addcart-detail
								 icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11
								 ">
									<i class="zmdi zmdi-shopping-cart"></i>
								</a>
							</div> -->
								<?php  } ?>
							</div>
						</div>
						<?php if ($arrProductos[$p]['categoria'] != 'Colchones') { ?>

							<span class="stext-107" style="background:#C6C6C6;color:white;padding:2px;border-radius: 5px; padding-left: 5px;padding-right: 5px;"> +Colores disponibles</span>
						<?php  } ?>


					</div>
				<?php }
			} else {
				?>
				<p>No hay productos para mostrar <a href="<?= base_url() ?>/tienda"> Ver productos</a></p>
			<?php } ?>

		</div>

		<!-- Load more -->
		<?php
		if (count($data['productos']) > 0) {
			$prevPagina = $data['pagina'] - 1;
			$nextPagina = $data['pagina'] + 1;
		?>
			<div class="flex-c-m flex-w w-full p-t-45">
				<?php if ($data['pagina'] > 1) { ?>
					<a href="<?= base_url() ?>/tienda/page/<?= $prevPagina ?>" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04"> <i class="fas fa-chevron-left"></i> &nbsp; Anterior </a>&nbsp;&nbsp;
				<?php } ?>
				<?php if ($data['pagina'] != $data['total_paginas']) { ?>
					<a href="<?= base_url() ?>/tienda/page/<?= $nextPagina ?>" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04"> Siguiente &nbsp; <i class="fas fa-chevron-right"></i> </a>
				<?php } ?>
			</div>
		<?php
		}
		?>
	</div>
</div>
<link rel="stylesheet" href="<?= media() ?>/js/ripjs/splide.min.css">
<script src="<?= media() ?>/js/ripjs/splide.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= media() ?>/js/ripjs/cat-circulos-zona4.css">
<script src="<?= media() ?>/js/ripjs/index4.js"></script> <!-- js para carrousel circulos -->
<?php
footerTienda($data);
?>