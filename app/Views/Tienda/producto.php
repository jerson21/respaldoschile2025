<?php 

headerTienda($data);
$arrProducto = $data['producto'];
$arrProductos = $data['productos'];
$arrImages = $arrProducto['images'];
$arrColores = $data['color']; 
$arrcolores_prod = $data['colores_prod'];
$arrTamanos = $data['tamano']; 
$arrAlturaBase = $data['altura_base'];
$arrTipoTela = $data['tipo_tela'];
$categoriasEspeciales = [1, 2, 3, 4, 6];
$isCategoriaEspecial = in_array($arrProducto['categoriaid'], $categoriasEspeciales);



$rutacategoria = $arrProducto['categoriaid'].'/'.$arrProducto['ruta_categoria'];
$base = "https://www.respaldoschile.cl";
$urlShared = $base."/tienda/producto/".$arrProducto['idproducto']."/".$arrProducto['ruta'];
 ?>
<br><br><br>
<hr>

	<!-- breadcrumb -->
	<div class="container">
	 	<!-- <span class="stext-102" style="background:#0f0038;color:white;padding:5px;border-radius: 5px; "><i class="fa-solid fa-cart-shopping"></i> CYBERMONDAY </span> --> 
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="<?= base_url() ?>/" class="stext-109 cl8 hov-cl1 trans-04">
				Inicio
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>
			<a href="<?= base_url().'/tienda/categoria/'.$rutacategoria; ?>" class="stext-109 cl8 hov-cl1 trans-04">
				<?= $arrProducto['categoria'] ?>
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>
			<span class="stext-109 cl4">
				<?= $arrProducto['nombre'] ?>
			</span>
		</div>
	</div>





<?php
if($arrProducto['tipo_prod'] == "3") { ?>
<style>
.container2 {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}

.carousel img {
    width: 100%;
    height: auto;
    display: none; /* Esconde todas las imágenes inicialmente */
}

.carousel img.active {
    display: block; /* Solo muestra la imagen activa */
}

.color-button {
    padding: 10px;
    margin: 5px;
    border: none;
    cursor: pointer;
    color: white;
    background-color: #777;
}

.color-button:hover {
    background-color: #555;
}

.add-to-cart {
    padding: 10px 20px;
    background-color: green;
    color: white;
    border: none;
    cursor: pointer;
}

.add-to-cart:hover {
    background-color: darkgreen;
}


</style>
<div class="container">
    <!-- Carrusel de imágenes -->
    <div id="imageCarousel" class="carousel">
        <img src="default.jpg" alt="Color por defecto" class="active">
        <img src="red.jpg" alt="Color Rojo" style="display:none;">
        <img src="blue.jpg" alt="Color Azul" style="display:none;">
        <img src="green.jpg" alt="Color Verde" style="display:none;">
    </div>

    <!-- Detalles del producto -->
    <div class="product-details">
        <h1>Cojín Redondo Calabaza</h1>
        <p class="price">$5.900</p>
        <div class="colors">
            <button class="color-button" onclick="changeColor(0)">Gris Claro</button>
            <button class="color-button" onclick="changeColor(1)">Rosado</button>
            <button class="color-button" onclick="changeColor(2)">Blanco</button>
            <button class="color-button" onclick="changeColor(3)">Amarillo</button>
        </div>
        <button class="add-to-cart" onclick="addToCart()">Agregar al carrito de compras</button>
    </div>
</div>

<script>
function changeColor(index) {
    const images = document.querySelectorAll('#imageCarousel img');
    images.forEach(img => img.classList.remove('active'));
    images[index].classList.add('active');
    images[index].style.display = 'block';  // Asegura que la imagen esté visible
}

function addToCart() {
    console.log('Producto añadido al carrito');
    // Aquí deberías añadir la lógica para manejar el estado del carrito
}

</script>
    <?php
} else { ?>

	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-65 p-b-60">

   
	

		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

							<div class="slick3 gallery-lb">
							<?php 
								if(!empty($arrImages)){
									for ($img=0; $img < count($arrImages) ; $img++) { 
										
							 ?>
								<div class="item-slick3" data-thumb="<?= $arrImages[$img]['url_image']; ?>">
									<div class="wrap-pic-w pos-relative">
										<img src="<?= $arrImages[$img]['url_image']; ?>" alt="<?= $arrProducto['nombre']; ?>">
										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?= $arrImages[$img]['url_image']; ?>">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
							<?php 
									}
								}

								$cat = $arrProducto['categoria'];
								if($cat == "Living y Sofas" || $cat == "Respaldos de cama" || $cat == "Bases de cama" || $cat == "Banquetas" ){
							?>


							<div class="item-slick3" data-thumb="<?= media()?>/images/lino.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="<?= media()?>/images/lino.jpg" >
										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?= media()?>/images/lino.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
								<div class="item-slick3" data-thumb="<?= media()?>/images/lino2.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="<?= media()?>/images/lino2.jpg" >
										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?= media()?>/images/lino2.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
								<div class="item-slick3" data-thumb="<?= media()?>/images/felpa.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="<?= media()?>/images/felpa.jpg" >
										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?= media()?>/images/felpa.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
							<?php } ?>


							
							</div>
						</div>
					</div>
				</div>
					
				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 class="mtext-105 cl2 js-name-detail p-b-14">
							<?= $arrProducto['nombre']; ?>
						</h4>
						<span class="mtext-106 cl2">
							
							
						</span>
						<?php
							
							//SI LA CATEGORIA ES TIPO 1 NO SE DEBE MOSTRAR EL PRECIO
							if($arrProducto['categoriaid'] == 1){
								if(count($data['categorias']) > 0){
									foreach ($data['categorias'] as $categoria) {
										if($categoria['nombre'] == $arrProducto['categoria'])
										if($categoria['tipo'] == 1){
											
										}else{
											echo SMONEY.formatMoney($arrProducto['precio']);
											
										}
								

								 }
								  }
								  
							

							
						 }	?>
						 <div class="stext-102 cl3 p-t-23" ><?= $arrProducto['descripcion']; ?> 
						 </div> 

						 
						<?php if($arrProducto['tipo_prod'] == '1' && $isCategoriaEspecial){ // QUE SEA DISTINTO A CATEGORIA PROMOCIONES
						 	
						 	$precio = $arrProducto['precio'];

						 	?>
						 	<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6 font-weight-bold">
									Color:

								</div>
							
								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select id="color" name="color" class="js-select2" name="time">
										<option value="0">Elegir una opción</option>
								<?php
								if(!empty($arrcolores_prod)){
						for ($p=0; $p < count($arrcolores_prod); $p++) { 
							$ruta = $arrcolores_prod[$p]['color'];
							$id_tipotela = $arrcolores_prod[$p]['id'];
							echo "<option value='".$id_tipotela."'>".$ruta."</option>";
							 }
							  }
							  
							 ?>		
											
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>

						 	<?php
						 } 

						 ?>
						
						
						 <?php
								if(!empty($arrTamanos) ){ ?>
						<!-- Tamaño  -->						
						<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6 font-weight-bold">
									Tamaño
								</div>
							
								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select id="tamano" name="tamano" class="js-select2" name="time">
										<option value="0">Elegir una opción</option>
										<?php if($arrProducto['categoria'] == 'Veladores'){ ?>
						 		<option disabled>Alto x Ancho x Fondo</option>
						<?php } 

						 ?>

						 <?php if($arrProducto['categoria'] == 'Living y Sofas'){ ?>
						 		<option disabled>Cantidad de asientos</option>
						<?php } 

						 ?>
										
								<?php
								if(!empty($arrTamanos)){
						for ($p=0; $p < count($arrTamanos); $p++) { 
							if($arrTamanos[$p]['precio'] != "") {
								$ruta = $arrTamanos[$p]['tamano'];
							$precio = $arrTamanos[$p]['precio'];
							$descuento = $arrTamanos[$p]['descuento'];
							echo "<option data-descuento='".$descuento."' data-categoria='".$arrProducto['categoria']."' value='".$precio."'>".$ruta."</option>";
							}

							
							 }
							  }
							 ?>		
											
										</select>
										<div class="dropDownSelect2"></div>

									</div><div class="stext-107" id="medidas" name="medidas"  >
						
						</div>
								</div>
							</div>
						<?php  } ?> 

						
						<!--	<?php if(empty($arrTipoTela) && $arrProducto['categoriaid'] != "8"){ ?>
								<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6 font-weight-bold">
									Color
								</div>
							
								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select id="color" name="color" class="js-select2" name="time">
										<option value="0">Elegir una opción</option>
								<?php
								/*
								if(!empty($arrColores)){
						for ($p=0; $p < count($arrColores); $p++) { 
							$ruta = $arrColores[$p]['color'];
							echo "<option value='".$ruta."'>".$ruta."</option>";
							 }
							  }*/
							 ?>		
											
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>

						<?php } ?> -->



							<?php 
							//Categorias especiales
							


							
							if ($isCategoriaEspecial){ ?>
								<!-- Tipo de tela -->
								<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6 font-weight-bold" >
									<?php if($arrProducto['categoriaid'] == 4){ //si la categoria es respaldo de cama
											echo "Acabado";										
									 }
									 else{ echo "Tipo de Tela";  }	?>

								</div>
							
								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select id="tipo_tela" name="tipo_tela" class="js-select2" name="time">
										<option value="0">Elegir una opción</option>
								<?php
								if(!empty($arrTipoTela)){
						for ($p=0; $p < count($arrTipoTela); $p++) { 
							$ruta = $arrTipoTela[$p]['tipo_tela'];
							$id_tipotela = $arrTipoTela[$p]['id'];
							echo "<option value='".$id_tipotela."'>".$ruta."</option>";
							 }
							  }
							  
							 ?>		
											
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>

								<!-- color -->
							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6 font-weight-bold">
									Color
								</div>
							
								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select id="color" name="color" class="js-select2" name="time">
										<option value="0">Elegir una opción</option>
								<?php
								/*
								if(!empty($arrColores)){
						for ($p=0; $p < count($arrColores); $p++) { 
							$ruta = $arrColores[$p]['color'];
							echo "<option value='".$ruta."'>".$ruta."</option>";
							 }
							  }*/
							 ?>		
											
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>

							<?php }							 ?>	

							<?php if ($arrProducto['categoriaid'] == 1) : // si la categoría es respaldo de cama ?>
  <!-- Altura de base -->
  <div class="flex-w flex-r-m p-b-10">
    <div class="size-203 flex-c-m respon6 font-weight-bold">
      Altura de base
    </div>

    <div class="size-204 respon6-next">
      <div class="rs1-select2 bor8 bg0">
        <select id="altura_base" name="altura_base" class="js-select2">
          <?php if (!empty($arrAlturaBase)) : ?>
            <?php foreach ($arrAlturaBase as $item) : ?>
              <?php 
                $ruta              = $item['altura_base'];
                $precio_alturabase = $item['precio'];
                $selected          = ($ruta == '60') ? 'selected' : '';
              ?>
              <option value="<?= $precio_alturabase ?>" <?= $selected ?>><?= $ruta ?></option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
        <div class="dropDownSelect2"></div>
      </div>

      <!-- Imagen ilustrativa -->
      <img src="<?= media() ?>/tienda/images/respaanimado.gif" width="120" alt="Animación altura de base">
    </div>

    <!-- Script para mostrar información en SweetAlert -->
	<script type="text/javascript">
  function mensajeinfo() {
    Swal.fire({
      icon: 'success',
      title: 'Información Altura de base',
      html: `
        <div style="text-align: center;">
          <img 
            src="<?= media() ?>/tienda/images/respaanimado.gif" 
            width="150" 
            alt="Animación altura de base"
            style="display:block; margin:0 auto 10px;"
          >
          <p style="margin:0;">
            La altura de base es la medida desde el suelo hasta el comienzo 
            del acolchado del respaldo. Si no sabes la medida, puedes dejarlo 
            en altura estándar (60 cm).
          </p>
        </div>
      `,
      footer: 'La altura estándar de las camas es de 60cm'
    });
  }

  document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
});
</script>


    <!-- Texto explicativo -->
    <span class="stext-102 cl3">
      Para seleccionar la altura de base, debe medir desde el suelo al término del colchón.
      <span onclick="mensajeinfo();" style="cursor:pointer;">
        <b>Mas info</b>
        <i class="fa fa-question-circle" aria-hidden="true"></i>
      </span>
    </span>
  </div>
<?php endif; ?>

<?php if ($isCategoriaEspecial) : ?>
  <span class="stext-102 cl3">Los colores los puedes ver en las imágenes.</span>
<?php endif; ?>


							<div style="display : flex; flex-direction : row; font-size:20px; color:black;" > <!-- inicio div  -->
						
						
							<div >
						<input id="precio_alturabase" name="precio_alturabase"   value="">
						
						</div>
						</div><!-- fin div  -->

						
							
							
							<div class="mtext-105" style="display : flex; flex-direction : row;  color:black; " > 
						
						<div style="margin-right:5px;">
						Precio:   
						</div>
						
							<div  id="precioportamano" name="precioportamano">
						<?php if($arrProducto['tipo_prod'] == '1'){
						 	
							 echo  SMONEY . number_format($arrProducto['precio'], 0, '', '.');
							} 

						 ?>
						
						</div>




						</div>



					<div id="descuento_activo" class="notblock">
	<span class="stext-102">Antes:</span> <span class="mtext-101" style="text-decoration: line-through;" id="precioportamano_descuento" name="precioportamano_descuento"> </span>
</div>
<!--AQUI INCLUIR PRECIOCYBER 
 <span class="stext-102" style="background:#0f0038;color:white;padding:5px;border-radius: 5px; font-size: 12px;"><i class="fa-solid fa-cart-shopping"></i> </span>	-->				



						<br><br><span class="stext-102" style="background:red;color:white;padding:2px;border-radius: 5px; padding-left: 5px;padding-right: 5px; display: none;"> TextoOferta</span><br>
<div style="display : flex; flex-direction : row; font-size:15px; color:black; border:solid; border-width: 1px; border-color:#D8D8D8; padding: 6px; border-radius:3px;" >
	<div class="stext-102  cl3">
	<div class="stext-102  cl3"><img src="<?= media() ?>\tienda\images\icons/disponible.png" width="30">Disponible despacho </div> </div><br>
	<div class="stext-102  cl3" style="margin-left: 7px;">
	<div class="stext-102  cl3"><img src="<?= media() ?>\tienda\images\icons/disponible.png" width="30">Retiro programado en tienda</div> </div>

</div>
	<!-- <span class="stext-102 cl3">Las entregas se programan luego de la compra. </span>	-->					
							
							<br>
							<i class="fa fa-question-circle" style="color:#cc0000;" aria-hidden="true"></i><span class="stext-102" style="color:#cc0000;"> ¿Necesitas ayuda con este producto?
							 <?php if($arrProducto['categoria'] == 'Living y Sofas'){ ?>
						 		<br>Podemos hacerlo a tu medida.
						<?php } 

						 ?>
						 </span><br>
							<span class="mtext-105 pointer" style="color:#cc0000;" onclick="window.open('https://api.whatsapp.com/send/?phone=+56979941253&text=Hola! necesito ayuda para comprar este producto%0A <?= $arrProducto['nombre'].' '.$urlShared ?>')" target="_blank"><i class="fa fa-whatsapp fa-6" aria-hidden="true"></i> Haz click aqui</span>
							<!--<div class="flex-c-m cl0 size-40 bg3 bor1  p-lr-10" style="width:40%; float:left; margin:1px;">Se programará lae</div> -->
						<!--<div class="flex-c-m cl0 size-40  bor1  p-lr-10" style="width:40%; background-color:#63C602;">Disponible	</div>-->
						<div class="p-t-33">
						<span class="stext-102">Stock: <?= $arrProducto['stock'] ?></span> 
							<div class="flex-w flex-r-m p-b-10">
								
							<input id="id_prod" name="id_prod" type="hidden" value="<?= $arrProducto['idproducto'] ?>">

							<input id="stock" type="hidden" name="stock"  value="<?= $arrProducto['stock'] ?>">
								<div class="size-204 flex-w flex-m respon6-next">
									
									<div class="wrap-num-product flex-w m-r-20 m-tb-10">
										
										<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
											
										</div>
										
										



										<input type="number" id="cant-product"  class="mtext-104 cl3 txt-center num-product"   name="num-product" value="1" min="1" max="<?= $arrProducto['stock'] ?>">




  


										<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
										
									</div>
									
							  
									<button id="<?= openssl_encrypt($arrProducto['idproducto'],METHODENCRIPT,KEY); ?>" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
										Agregar al carrito
									</button>
								</div>
							</div>	
						</div>
						<!--  -->
						<div class="flex-w flex-m p-l-100 p-t-40 respon7">
							<div class="flex-m bor9 p-r-10 m-r-11">
								Compartir en:
							</div>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook"
								onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= $urlShared; ?> &t=<?= $arrProducto['nombre'] ?>','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"
								>
								<i class="fa fa-facebook"></i>
							</a>

							<a href="https://twitter.com/intent/tweet?text=<?= $arrProducto['nombre'] ?>&url=<?= $urlShared; ?>&hashtags=<?= SHAREDHASH; ?>" target="_blank" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
								<i class="fa fa-twitter"></i>
							</a>

							<a href="#" onclick="window.open('https://api.whatsapp.com/send?text=<?= $arrProducto['nombre'].' '.$urlShared ?>')" target="_blank" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="WhatsApp">

								<i class="fab fa-whatsapp" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
			<h3>Productos Relacionados</h3>
		</div>
	</section>

	<?php } ?>

	<!-- Related Products -->
	<section class="sec-relate-product bg0 p-t-45 p-b-105">
		<div class="container">
			<!-- Slide2 -->
			<div class="wrap-slick2">
				<div class="slick2" >

				<?php 
					if(!empty($arrProductos)){
						for ($p=0; $p < count($arrProductos); $p++) { 
							$ruta = $arrProductos[$p]['ruta'];
							if(count($arrProductos[$p]['images']) > 0 ){
								$portada = $arrProductos[$p]['images'][0]['url_image'];
							}else{
								$portada = media().'/images/uploads/product.png';
							}
				 ?>
					<div class="item-slick2 p-l-1 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						<div class="block2" >
							<div class="block2-pic hov-img0" onclick="location.href='<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$ruta; ?>'">
								<img src="<?= $portada ?>" alt="<?= $arrProductos[$p]['nombre'] ?>">

								<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$ruta; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
									Ver producto
								</a>
							</div>

						<!--	<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="<?= base_url().'/tienda/producto/'.$arrProductos[$p]['idproducto'].'/'.$ruta; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										<?= $arrProductos[$p]['nombre'] ?>
									</a>
									<span class="stext-105 cl3">
										<?= SMONEY.formatMoney($arrProductos[$p]['precio']); ?>
									</span>
								</div>
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
							</div> -->
						</div>
					</div>
				<?php 
						}
					}	
				 ?>

				</div>
			</div>
		</div>
	</section>
<?php 
	footerTienda($data);
?>
