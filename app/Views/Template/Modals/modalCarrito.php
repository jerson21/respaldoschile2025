<?php 
$total = 0;
if(isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0){ 
 ?>
<ul class="header-cart-wrapitem w-full">
<?php 
	foreach ($_SESSION['arrCarrito'] as $producto) {
		
	$total += $producto['cantidad'] * $producto['precio'];
	$idProducto = openssl_encrypt($producto['idproducto'],METHODENCRIPT,KEY);	
	if($producto['cantidad'] > 0){ 
 ?>	
	<li class="header-cart-item flex-w flex-t m-b-12">
		<div class="header-cart-item-img" idpr="<?= $idProducto ?>" op="1" onclick="fntdelItem(this)">
			<img src="<?= $producto['imagen'] ?>" alt="<?= $producto['producto'] ?>">
		</div>
		
		<div class="header-cart-item-txt p-t-8" >
			<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
				<?= $producto['producto'] ?>
			</a>
			<span  class="header-cart-item-info" >
				<?= $producto['cantidad'].' x '.SMONEY.formatMoney($producto['precio']) ?>
			</span>
			<div id="producto-cantidad<?= $idProducto ?>" data-value="<?= $producto['cantidad'] ?>"> </div>

			<span class="header-cart-item-info">
				
				

				<?php if($producto['tamano'] != "undefined"){ echo $producto['tamano'];}  ?>
			</span>

			<span class="header-cart-item-info">
				<?php if($producto['tipo_tela'] != "undefined"){ echo $producto['tipo_tela'];}  ?>
				<?php if($producto['color'] != "undefined"){ echo $producto['color'];}  ?>
			</span>

		</div>
	</li>
<?php } else{
?>
			<li class="header-cart-item flex-w flex-t m-b-12">
		<div class="header-cart-item-img" idpr="<?= $idProducto ?>" op="1" onclick="fntdelItem(this)">
			<img src="<?= $producto['imagen'] ?>" alt="<?= $producto['producto'] ?>">
		</div>
		
		<div class="header-cart-item-txt p-t-8">
			<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
				<?= $producto['producto'] ?>
			</a>
			<span class="header-cart-item-info">
				<?= $producto['cantidad'].' x '.SMONEY.formatMoney($producto['precio']) ?>
			</span>

			<span class="header-cart-item-info">
				
				

				<?php if($producto['tamano'] != "undefined"){ echo $producto['tamano'];}  ?>
			</span>

			<span class="header-cart-item-info">
				<?php if($producto['tipo_tela'] != "undefined"){ echo $producto['tipo_tela'];}  ?>
				<?php if($producto['color'] != "undefined"){ echo $producto['color'];}  ?>
			</span>

		</div>
	</li>
			<script type="text/javascript">

				$(document).ready(function() {

				fntdelItem("1","<?= $idProducto ?>");

				});
</script>
		
			<?php

}
}?>
</ul>
<div class="w-full">
	<div class="header-cart-total w-full p-tb-40">
		Total: <?= SMONEY.formatMoney($total); ?>
	</div>

	<div class="header-cart-buttons flex-w w-full">
		<a href="<?= base_url() ?>/carrito" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
			Ver carrito
		</a>

		<a href="<?= base_url() ?>/carrito/procesarpago" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
			Finalizar compra
		</a>
	</div>
</div>
<?php 
}
 ?>