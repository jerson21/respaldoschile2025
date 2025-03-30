<?php 
	headerTienda($data);
	$arrSlider = $data['slider'];
	$arrBanner = $data['banner'];
	$arrProductos = $data['productos'];

	$contentPage = "";
	if(!empty($data['page'])){
		$contentPage = $data['page']['contenido'];
	}

 ?>




 



<div class=""  style="margin:0 auto; background-color: ; text-align: center;">
        <div class="  flex-column justify-content-center">
         <div class="hero-img aos-init aos-animate" data-aos="zoom-out" data-aos-delay="200">
          <img src="https://www.respaldoschile.cl/assets/img/logor.png" class="img-fluid" alt="">
        </div>
        </div>
      
      </div>




<div id="landing_home1" class="autotag">

<section id="lo_tenemos_todo">
<div id="carrusel_tenemos_todo">

<div id="splide_1" class="splide splide--loop splide--ltr splide--draggable is-active" style="visibility: visible;">
<div class="splide__arrows"><button class="splide__arrow splide__arrow--prev" type="button" aria-controls="splide_1-track" aria-label="Previous slide"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40"><path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path></svg></button><button class="splide__arrow splide__arrow--next" type="button" aria-controls="splide_1-track" aria-label="Next slide"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40"><path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path></svg></button></div><div class="splide__track" id="splide_1-track">
<ul class="splide__list" id="splide_1-list" style="transform: translateX(-3990px);">


	<?php 	if(count($data['categorias']) > 0){
		foreach ($data['categorias'] as $categoria) {	
				echo '<li class="splide__slide splide__slide--clone" style="width: 190px;">';							
								 ?>

								 <div class="tenemos_todo1">
<a href="<?= base_url() ?>/tienda/categoria/<?= $categoria['idcategoria'].'/'.$categoria['ruta'] ?>" rpl_sp="carrusel-cat-ltt-_-dormitorio-_-https://simple.ripley.cl/dormitorio">
<div class="circulo">
<picture>

<source media="(min-width: 700px)" type="image/webp" srcset="https://minisitios.ripley.cl/minisitios/home/2022/evento/verano/ol/circulos-categorias/dormitorio.jpg" alt="">

<source media="(min-width: 700px)" srcset="https://minisitios.ripley.cl/minisitios/home/2022/evento/verano/ol/circulos-categorias/dormitorio.jpg">

<source type="image/webp" srcset="https://minisitios.ripley.cl/minisitios/home/2022/evento/verano/ol/circulos-categorias/dormitorio.jpg" alt="">

<img src="https://minisitios.ripley.cl/minisitios/home/2022/evento/verano/ol/circulos-categorias/dormitorio.jpg">
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







<li class="splide__slide" id="splide_1-slide19" style="width: 190px;">
<div class="tenemos_todo1">
<a href="https://simple.ripley.cl/otras-categorias" rpl_sp="carrusel-cat-ltt-_-otras-categorias-_-https://simple.ripley.cl/otras-categorias">
<div class="circulo">
<picture>

<source media="(min-width: 700px)" type="image/webp" srcset="https://minisitios.ripley.cl/minisitios/home/2022/evento/verano/ol/circulos-categorias/otras-categorias1.jpg" alt="">

<source media="(min-width: 700px)" srcset="https://minisitios.ripley.cl/minisitios/home/2022/evento/verano/ol/circulos-categorias/otras-categorias1.jpg">

<source type="image/webp" srcset="https://minisitios.ripley.cl/minisitios/home/2022/evento/verano/ol/circulos-categorias/otras-categorias1.jpg" alt="">

<img src="https://minisitios.ripley.cl/minisitios/home/2022/evento/verano/ol/circulos-categorias/otras-categorias1.jpg">
</picture>
</div>
</a>
<p>otras categorías</p>
</div>
</li>

</ul>
</div>
</div>
</div>
</section>

</div>









	<!-- Product -->
	<section class="bg0 p-t-23 p-b-140">
		<div class="container">
			<div class="p-b-10">
				<h3 class="ltext-103 cl5">
					Productos Nuevos
				</h3>
			</div>
			<hr>
			<div class="row isotope-grid">
			<?php 
				for ($p=0; $p < count($arrProductos) ; $p++) {
					$rutaProducto = $arrProductos[$p]['ruta']; 
					if(count($arrProductos[$p]['images']) > 0 ){
						$portada = $arrProductos[$p]['images'][0]['url_image'];
					}else{
						$portada = media().'/images/uploads/product.png';
					}
			 ?>
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-pic hov-img0">
							<img src="<?= $portada ?>" alt="<?= $arrProductos[$p]['nombre'] ?>">
							<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$rutaProducto; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								Ver producto
							</a>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$rutaProducto; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
									<?= $arrProductos[$p]['nombre'] ?>
								</a>
								<?php if($arrProductos[$p]['precio'] != '0') {?>
								<span class="stext-105 cl3">
									<?= SMONEY.formatMoney($arrProductos[$p]['precio']); ?>
								</span>
							<?php  } ?>
 							</div>
							<?php if($arrProductos[$p]['precio'] != '0') {?>
							<div class="block2-txt-child2 flex-r p-t-3">
								<a href="#"
								 id="<?= openssl_encrypt($arrProductos[$p]['idproducto'],METHODENCRIPT,KEY); ?>"
								 class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 js-addcart-detail
								 icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11
								 ">
									<i class="zmdi zmdi-shopping-cart"></i>
								</a>
							</div>
						<?php  } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
			<!-- Load more -->
			<div class="flex-c-m flex-w w-full p-t-45">
				<a href="<?= base_url() ?>/tienda" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
					Ver más
				</a>
			</div>
		</div>

		<div class="container text-center p-t-80">
			<hr>
			<?= $contentPage ?>
		</div>
	</section>
<?php 
	footerTienda($data);
 ?>

