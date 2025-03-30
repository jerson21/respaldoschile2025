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

 <!-- <div style="margin:0 auto; text-align:center; height: 80px; background-color: red; width:100%;  position:absolute; margin-bottom: 40px;">
	<div style=" text-align:center; ">
	<img src="<?= media() ?>/images/blackfriday.webp" alt="blackfriday" width="400" style="margin-top:-40px; text-align: center; " >	
	</div> 
	
</div>-->



	<section class="section-slide">
		<div class="wrap-slick1">
			<div class="slick1">
	

				<div class="item-slick1" style="background-image: url(<?= media() ?>/images/slide-01.webp);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
								<span class="ltext-101 cl2 respon2" >
								Bases de cama 
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
								<h2 class="ltext-102 cl2 p-t-19 p-b-43 respon1" >
							Nuevo Modelo Antideslizante
								</h2>
								
								
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
								<a href="<?= base_url()?>/tienda/categoria/3/bases-de-cama" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Comprar Ahora
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1" style="background-image: url(<?= media() ?>/images/slide-02.webp);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Sofas
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
								<h2 class="ltext-102 cl2 p-t-19 p-b-43 respon1">
									Todas Las Medidas
								</h2>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
								<a href="<?= base_url()?>/tienda/categoria/2/living-y-sofas" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Comprar Ahora
								</a>
							</div>
						</div>
					</div>
				</div>

				
		</div>
	</section>
 

<!--<div style="margin:0 auto; text-align:center;">
<script type="text/javascript">
	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
 document.write("<img src='<?= media() ?>/images/banner1.webp' width='100%'>")
}else{
  document.write("<img src='<?= media() ?>/images/banner1.webp' width='80%' >");
}
</script>
</div>
-->


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
								 	
<a href="<?= base_url() ?>/tienda/categoria/<?= $categoria['idcategoria'].'/'.$categoria['ruta'] ?>" >
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
<br>

<section class="bg0 p-t-23 p-b-140">
		<div class="container">
			<div class="p-b-10">
				<h3 class="ltext-103 cl5">
					OFERTAS IMPERDIBLES
				</h3>
			</div>



<!-- tienda/producto/118/combo-cama-completa -->
		<div style="   display: flex; overflow-x: auto;   scrollbar-width: thin;    width: 100%; ">
			<a href="<?= base_url() ?>/tienda/producto/84/respaldo-de-cama-capitone"> <picture><img  class="banner2" src="<?= media();?>/images/banner2/bannercapitone.webp"></picture> </a>
			<a href="<?= base_url() ?>/tienda/producto/78/respaldo-de-cama-madrid"><picture><img class="banner2" src="<?= media();?>/images/banner2/banner2.webp"></picture> </a>
			<a href="<?= base_url() ?>/promociones"><picture><img class="banner2" src="<?= media();?>/images/banner2/banner3.webp"></picture></a>
			<a href="<?= base_url() ?>/tienda/producto/86/velador-tiradores-negros"><picture><img class="banner2" src="<?= media();?>/images/banner2/banner4.webp"></picture></a>
     			
			
			
			
			
</div>	






			
	</div>


	<section class="bg0 p-t-23 p-b-20">
    <div class="container">
        <div class="p-b-10">
            <h3 class="ltext-103 cl5">Respaldos de Cama</h3>
        </div>
        <hr>
        <div id="splideRespaldos" class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php foreach ($data['respaldos'] as $producto): 
				
                        $rutaProducto = $producto['ruta'];
                        $portada = count($producto['images']) > 0 ? $producto['images'][0]['url_image'] : media().'/images/uploads/product.png';
                    ?>
                    <li class="splide__slide">
                        <div class="block2">
                            <div class="block2-pic hov-img0" style="border-radius: 30px;">
                                <img src="<?= $portada ?>" alt="<?= $producto['nombre'] ?>">
                                <a href="<?= base_url().'/tienda/producto/'.$producto['idproducto'].'/'.$rutaProducto; ?>" 
                                   class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                    Ver producto
                                </a>
                            </div>
							<div class="block2-txt flex-w flex-t p-t-14">
    <div class="block2-txt-child1 flex-col-l" style="text-align: center; align-items: center; justify-content: center;">
        <a href="<?= base_url().'/tienda/producto/'.$producto['idproducto'].'/'.$rutaProducto; ?>" 
           class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
            <?= $producto['nombre'] ?>
        </a>
    </div>
</div>

                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="bg0 p-t-23 p-b-20">
    <div class="container">
        <div class="p-b-10">
            <h3 class="ltext-103 cl5">Colchones</h3>
        </div>
        <hr>
        <div id="splideColchones" class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php foreach ($data['colchones'] as $producto): 
				
                        $rutaProducto = $producto['ruta'];
                        $portada = count($producto['images']) > 0 ? $producto['images'][0]['url_image'] : media().'/images/uploads/product.png';
                    ?>
                    <li class="splide__slide">
                        <div class="block2">
                            <div class="block2-pic hov-img0" style="border-radius: 30px;">
                                <img src="<?= $portada ?>" alt="<?= $producto['nombre'] ?>">
                                <a href="<?= base_url().'/tienda/producto/'.$producto['idproducto'].'/'.$rutaProducto; ?>" 
                                   class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                    Ver producto
                                </a>
                            </div>
							<div class="block2-txt flex-w flex-t p-t-14">
    <div class="block2-txt-child1 flex-col-l" style="text-align: center; align-items: center; justify-content: center;">
        <a href="<?= base_url().'/tienda/producto/'.$producto['idproducto'].'/'.$rutaProducto; ?>" 
           class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
            <?= $producto['nombre'] ?>
        </a>
    </div>
</div>

                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>



<section class="bg0 p-t-23 p-b-20">
    <div class="container">
        <div class="p-b-10">
            <h3 class="ltext-103 cl5">Closet y Comodas</h3>
        </div>
        <hr>
        <div id="splidecloset" class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php foreach ($data['closet'] as $producto): 
				
                        $rutaProducto = $producto['ruta'];
                        $portada = count($producto['images']) > 0 ? $producto['images'][0]['url_image'] : media().'/images/uploads/product.png';
                    ?>
                    <li class="splide__slide">
                        <div class="block2">
                            <div class="block2-pic hov-img0" style="border-radius: 30px;">
                                <img src="<?= $portada ?>" alt="<?= $producto['nombre'] ?>">
                                <a href="<?= base_url().'/tienda/producto/'.$producto['idproducto'].'/'.$rutaProducto; ?>" 
                                   class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                    Ver producto
                                </a>
                            </div>
							<div class="block2-txt flex-w flex-t p-t-14">
    <div class="block2-txt-child1 flex-col-l" style="text-align: center; align-items: center; justify-content: center;">
        <a href="<?= base_url().'/tienda/producto/'.$producto['idproducto'].'/'.$rutaProducto; ?>" 
           class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
            <?= $producto['nombre'] ?>
        </a>
    </div>
</div>

                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>





<script>
document.addEventListener('DOMContentLoaded', function () {
    new Splide('#splideRespaldos', {
        type: 'loop',
        perPage: 5,
        gap: '0.5rem',
        breakpoints: {
            1024: { perPage: 2 },
            768: { perPage: 1 },
        },
    }).mount();
});

document.addEventListener('DOMContentLoaded', function () {
    new Splide('#splideColchones', {
        type: 'loop',
        perPage: 5,
        gap: '0.5rem',
        breakpoints: {
            1024: { perPage: 2 },
            768: { perPage: 1 },
        },
    }).mount();
});

document.addEventListener('DOMContentLoaded', function () {
    new Splide('#splidecloset', {
        type: 'loop',
        perPage: 5,
        gap: '0.5rem',
        breakpoints: {
            1024: { perPage: 2 },
            768: { perPage: 1 },
        },
    }).mount();
});
</script>

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
			$descuento = "";
				for ($p=0; $p < count($arrProductos) ; $p++) {
					 if($categoria = $arrProductos[$p]['categoriaid'] == "8" and $arrProductos[$p]['precio_normal'] > 1){
					$precio_antes = $arrProductos[$p]['precio_normal']; 
					$precio_actual = $arrProductos[$p]['precio'];
					 $descuento = $precio_antes - $precio_actual;
					
					$categoria = $arrProductos[$p]['categoriaid'];
					
					$descuento_actual = 100 * $descuento;
					$descuento_actual = $descuento_actual / $precio_antes;
					 }

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


						<div class="block2-pic hov-img0" style="border-radius: 30px; z-index: 0;">
				<?php if($categoria == 8 && $descuento > 0){ ?> <span  class="oferta">- <?=  round($descuento_actual);   ?>%</span> <?php } ?>



							<?php //if($arrProductos[$p]['tipo_prod'] == "1"){
						 	
						  $descuento = "";
						    $multiplic = "";
						    $existedescuento = false;
						    
						    if(count($arrProductos[$p]['descuento']) > 0 ) {
						        $descuento = $arrProductos[$p]['descuento'][0]['descuento']." ".$arrProductos[$p]['descuento'][0]['precio'];
						        $precio = $arrProductos[$p]['descuento'][0]['precio'];
						        
						        if($precio > 0) {
						            $multiplic = 100 * intval($arrProductos[$p]['descuento'][0]['descuento']);
						            $descuento = round($multiplic / $arrProductos[$p]['descuento'][0]['precio']);
						            $existedescuento = true;
						        }
						    }
											
					 
					  
						 

						 ?>
						 <?php 
								if($descuento > 0){ ?>
							<span  class="oferta"> 
							<?php 	echo  "-".$descuento."%";//} ?>
								
							
							

						</span> <?php } ?>
							<img src="<?= $portada ?>" alt="<?= $arrProductos[$p]['nombre'] ?>">
							
							<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$rutaProducto; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								Ver producto
							</a>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a  href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$rutaProducto; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
									<?= $arrProductos[$p]['categoria'] ?>
								</a>
								<span class="stext-105 cl3">
									<?= $arrProductos[$p]['nombre'] ?>
								</span>
								<?php if($arrProductos[$p]['precio'] != '0') {?>
								<span class="stext-105 cl3">
									<?php  SMONEY.formatMoney($arrProductos[$p]['precio']); ?>
								</span>
							<?php  } ?>
 							</div>
						<!--	<?php if($arrProductos[$p]['precio'] != '0') {?>
							<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#"
									 id="<?= openssl_encrypt($arrProductos[$p]['idproducto'],METHODENCRIPT,KEY); ?>"
									 pr="1"
									 class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 js-addcart-detail
									 icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11
									 ">
										<i class="zmdi zmdi-shopping-cart"></i>
									</a>
								</div>
						<?php  } ?> -->
						</div>



						
<?php  if($arrProductos[$p]['categoria'] != 'Colchones'){?>

					<span class="stext-107" style="background:#C6C6C6;color:white;padding:2px;border-radius: 5px; padding-left: 5px;padding-right: 5px;"> +Colores disponibles</span>
					<?php  } ?>

						
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
<div class="container text-center p-t-80"  style="margin:0 auto; background-color: ; text-align: center;">
        <div class="  flex-column justify-content-center">
         <div class="hero-img aos-init aos-animate" data-aos="zoom-out" data-aos-delay="200">
          <img src="https://www.respaldoschile.cl/assets/img/logor.png" width="150px" class="img-fluid" alt="">
          <img src="<?= base_url() ?>/Assets/images/logo2.png" width="150px" class="img-fluid" alt="">
        </div>
        </div>
 <div class="  flex-column justify-content-center">
         <div class="hero-img aos-init aos-animate" data-aos="zoom-out" data-aos-delay="200">
          <img src="https://www.respaldoschile.cl/assets/images/logorespaldoschile.png" width="140px" class="img-fluid" alt="">
          <img src="<?= base_url() ?>/Assets/images/logorespaldoschile.png" width="140px" class="img-fluid" alt="">
        </div>
        </div>

      </div>

  


		<div class="container text-center p-t-80">
			<hr>
			<?= $contentPage ?>
		</div>
	</section>
	<link rel="stylesheet" href="<?= media() ?>/js/ripjs/splide.min.css">
<script src="<?= media() ?>/js/ripjs/splide.min.js?"></script>
<link rel="stylesheet" type="text/css" href="<?= media() ?>/js/ripjs/cat-circulos-zona4.css">
<script src="<?= media() ?>/js/ripjs/index4.js"></script> <!-- js para carrousel circulos -->

<?php 
	footerTienda($data);
 ?>

