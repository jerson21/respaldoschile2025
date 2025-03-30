<?php 

$orden = $data['pedido']['orden'];
$detalle = $data['pedido']['detalle'];
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Orden</title>
	<style type="text/css">
		p{
			font-family: arial;letter-spacing: 1px;color: #7f7f7f;font-size: 12px;
		}
		hr{border:0; border-top: 1px solid #CCC;}
		h4{font-family: arial; margin: 0;}
		table{width: 100%; max-width: 600px; margin: 10px auto; border: 1px solid #CCC; border-spacing: 0;}
		table tr td, table tr th{padding: 5px 10px;font-family: arial; font-size: 12px;}
		#detalleOrden tr td{border: 1px solid #CCC;}
		.table-active{background-color: #CCC;}
		.text-center{text-align: center;}
		.text-right{text-align: right;}

		@media screen and (max-width: 470px) {
			.logo{width: 90px;}
			p, table tr td, table tr th{font-size: 9px;}
		}

		
	</style>
</head>
<body style="">





	<div style="">
		<br>
		<table style="border:none;">
			<td class="text-center" >   
					<img class="logo" src="https://tienda2.respaldoschile.cl/Assets/tienda/images/logo2.png" width="30%" alt="Logo">
					<p style=" margin: 0; text-align: center;  background-color: #ffffff; color: #263238;   font-family: 'Speedee',Arial; font-size: 36px; font-weight: bold;">Gracias, <?= $_SESSION['userData']['nombres']?>!<br>Tu pedido fue confirmado</p>
					<p>
							

				</td>

				</table>
				<?php
// Definimos los métodos de pago que se reciben de Transbank
$mapeoPagos = array(
    "Débito",
    "Prepago",
    "Crédito Sin Cuotas",
    "Crédito En Cuotas"
);
?>



		<p class="text-center"> <td></td>
							Pedido Numero: <strong>000<?= $orden['idpedido'] ?></strong><br>
                            Fecha: <?= $orden['fecha'] ?><br>
				
							
                            <?php 
							
							if (in_array($orden['tipopagoid'], $mapeoPagos)) {
								?>
									
							
						
                            Método Pago: <?= $orden['tipopagoid'] ?> <br>
                            Transacción: <?= $orden['idtransaccionpaypal'] ?>
                        <?php }else{ ?>
                        	Método Pago: Por Pagar <br>
							Tipo Pago: <?= $orden['tipopago'] ?>
                        <?php } ?>

						<td></td><td></td></p>
						<p class="text-center" style="color: black; text-align:center;"> <td></td>
 <?php 
if (in_array( $orden['tipopagoid'],  $mapeoPagos)) {
	?>
                           
                        <?php }else{ ?>
                        								A continuación encontrarás los datos para que realices la transferencia antes de 48 horas, después de ese periodo se anulara el pedido.<br>


<br>
<div class="text-center" style="font-size:18px; background-color: #FAFAFA;">
<b>Respaldos Chile SPA<br>
Banco de Crédito e inversiones(BCI)<br>
Tipo de cuenta: Cuenta Corriente<br>
Cuenta: 46328157<br>
RUT: 77.186.031-1<br>
Mensaje : Pedido <?= $orden['idpedido'] ?><br>
Correo: contacto@respaldoschile.cl<br>
Monto: <?= SMONEY.number_format($orden['monto']); ?>
</div><br>
 <b><br><br>
En el caso que la transacción se realice un día viernes, fin de semana o feriado el tiempo de despacho contara desde el dia habil siguiente. <br>
	Para asistencia sobre el pago o dudas del producto, por favor contáctenos por whatsapp al  <?= TELEMPRESA ?> o al mail <?= EMAIL_EMPRESA ?>, en horario de atención de tienda (lunes a viernes de 09:00 a 18:00 hrs.).<br>
                        <?php } ?>




						<td></td><td></td></p>

<p class="text-center"> 

						<img class="logo" src="https://tienda2.respaldoschile.cl/Assets/images/comprobado.png" width="5%" alt="Logo"></p>

		<br>
		
		<br>
		
		<table style="border:none;">
			
			<tr >
				
				
						
			</tr>
		</table>
		<table>
			<tr>
		    	<td width="140">Nombre:</td>
		    	<td><?= $_SESSION['userData']['nombres'].' '.$_SESSION['userData']['apellidos'] ?></td>
		    </tr>
		    <tr>
		    	<td>Teléfono</td>
		    	<td><?= $_SESSION['userData']['telefono'] ?></td>
		    </tr>
		    <tr>
		    	<td>Dirección de envío:</td>
		    	<td><?= ucfirst($orden['direccion_envio']) ?></td>

		    </tr>

		</table>
		<table >
		  <thead >
		

		  	<td><h1>Detalle del pedido</h1></td>
		   
		  </thead>
		  <tbody>
		    
		    	  	<?php 
		  		if(count($detalle) > 0){
		  			$subtotal = 0;
		  			foreach ($detalle as $producto) {
						$tamano =$producto['tamano'];
						$color =$producto['color'];
						$tipo_tela =$producto['tipo_tela'];
						$altura_base =$producto['altura_base'];
		  				$precio = $producto['precio'];
		  				$importe = $producto['precio'] * $producto['cantidad'];
		  				$subtotal += $importe;
		  	 ?>
		  	 <tr>
		      <td><?= $producto['cantidad'] ?> x <?= $producto['producto'] ?> <?= $tamano ?> <?php if($tipo_tela != "undefined"){ echo $tipo_tela;} ?> <?php if($color != "undefined"){ echo $color;} ?> <?php if($altura_base != "undefined"){ echo $altura_base;} ?>   </td>
		      <td> <?= SMONEY.number_format($precio) ?></td>
		      
		    </tr>
		    <hr>
		    <?php }
				} ?>


		    
		  </tbody>
		  <tfoot>
		  		<tr>
		  			<th colspan="3" class="text-right">Subtotal:</th>
		  			<td class="text-right"><?= SMONEY.number_format($subtotal); ?></td>
		  		</tr>
		  		<tr>
		  			<th colspan="3" class="text-right">Envío:</th>
		  			<td class="text-right"><?= SMONEY.number_format($orden['costo_envio']); ?></td>
		  		</tr>
		  		<tr>
		  			<th colspan="3" class="text-right">Total:</th>
		  			<td class="text-right"><?= SMONEY.number_format($orden['monto']); ?></td>
		  		</tr>
		  </tfoot>
		</table>
		<div class="text-center">

			 <p>Muy pronto estaremos en contacto para coordinar la entrega.</p>
  <p>Puedes ver el estado de tu pedido en la sección pedidos de tu usuario.</p>
			<h4>¡Gracias por tu compra!</h4>		

			<br>
			<h4>Respaldos Chile - Redeco Muebles</h4>		
		</div>
	</div>									
</body>
</html>
