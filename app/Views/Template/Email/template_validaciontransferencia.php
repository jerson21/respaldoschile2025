<?php 
$orden   = $data['pedido']['orden'];
$detalle = $data['pedido']['detalle'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Notificación de Pago Validado</title>
	<style type="text/css">
		p {
			font-family: arial;
			letter-spacing: 1px;
			color: #7f7f7f;
			font-size: 12px;
		}
		hr {
			border:0; 
			border-top: 1px solid #CCC;
		}
		h4 {
			font-family: arial;
			margin: 0;
		}
		table {
			width: 100%;
			max-width: 600px;
			margin: 10px auto;
			border: 1px solid #CCC;
			border-spacing: 0;
		}
		table tr td,
		table tr th {
			padding: 5px 10px;
			font-family: arial;
			font-size: 12px;
		}
		#detalleOrden tr td {
			border: 1px solid #CCC;
		}
		.table-active {
			background-color: #CCC;
		}
		.text-center {
			text-align: center;
		}
		.text-right {
			text-align: right;
		}
		@media screen and (max-width: 470px) {
			.logo {
				width: 90px;
			}
			p,
			table tr td,
			table tr th {
				font-size: 9px;
			}
		}
	</style>
</head>
<body>
	<div>
		<br>
		<!-- Encabezado / Logo -->
		<table style="border:none;">
			<tr>
				<td class="text-center">
					<img class="logo" src="https://tienda2.respaldoschile.cl/Assets/tienda/images/logo2.png" width="30%" alt="Logo" />
					<p style="margin: 0; text-align: center; background-color: #ffffff; color: #263238; font-family: 'Speedee', Arial; font-size: 36px; font-weight: bold;">
						¡Transferencia Validada, <?php echo $_SESSION['userData']['nombres']; ?>!
					</p>
				</td>
			</tr>
		</table>

		<!-- Mensaje principal -->
		<p class="text-center" style="color: black; text-align:center;">
			Hemos verificado correctamente tu pago. Tu pedido ha sido confirmado y comenzaremos con el proceso de despacho lo antes posible.
		</p>

		<!-- Datos de la orden -->
		<p class="text-center">
			Pedido Número: <strong>000<?php echo $orden['idpedido']; ?></strong><br>
			Fecha de validación: <?php echo $orden['fecha']; ?><br>
			Método de Pago: Transferencia
		</p>
		<p class="text-center">
			<img class="logo" src="https://tienda2.respaldoschile.cl/Assets/images/comprobado.png" width="5%" alt="Logo" />
		</p>

		<!-- Datos del cliente -->
		<table style="border:none;">
			<tr>
				<td width="140">Nombre:</td>
				<td><?php echo $_SESSION['userData']['nombres'].' '.$_SESSION['userData']['apellidos']; ?></td>
			</tr>
			<tr>
				<td>Teléfono:</td>
				<td><?php echo $_SESSION['userData']['telefono']; ?></td>
			</tr>
			<tr>
				<td>Dirección de envío:</td>
				<td><?php echo ucfirst($orden['direccion_envio']); ?></td>
			</tr>
		</table>

		<!-- Detalle del pedido -->
		<br>
		<h4 class="text-center">Detalle del pedido</h4>
		<table>
			<tbody>
			<?php 
			if(count($detalle) > 0){
				$subtotal = 0;
				foreach ($detalle as $producto) {
					$tamano      = $producto['tamano'];
					$color       = $producto['color'];
					$tipo_tela   = $producto['tipo_tela'];
					$altura_base = $producto['altura_base'];
					$precio      = $producto['precio'];
					$importe     = $producto['precio'] * $producto['cantidad'];
					$subtotal   += $importe;
			?>
				<tr>
					<td>
						<?php echo $producto['cantidad'].' x '.$producto['producto'].' '.$tamano.' '.
							($tipo_tela   != 'undefined' ? $tipo_tela   : '').' '.
							($color       != 'undefined' ? $color       : '').' '.
							($altura_base != 'undefined' ? $altura_base : ''); ?>
					</td>
					<td><?php echo SMONEY.number_format($precio); ?></td>
				</tr>
				<hr>
			<?php 
				}
			} 
			?>
			</tbody>
			<tfoot>
				<?php 
					// Se asume que $orden['costo_envio'] y $orden['monto'] existen
					// y SMONEY es un helper para mostrar el símbolo de la moneda
				?>
				<tr>
					<th class="text-right">Subtotal:</th>
					<td class="text-right"><?php echo SMONEY.number_format($subtotal); ?></td>
				</tr>
				<tr>
					<th class="text-right">Envío:</th>
					<td class="text-right"><?php echo SMONEY.number_format($orden['costo_envio']); ?></td>
				</tr>
				<tr>
					<th class="text-right">Total:</th>
					<td class="text-right"><?php echo SMONEY.number_format($orden['monto']); ?></td>
				</tr>
			</tfoot>
		</table>

		<div class="text-center">
			<br>
			<p>Nos pondremos en contacto muy pronto para coordinar la entrega. Si la validación se realizó un día viernes, fin de semana o feriado, el tiempo de despacho comenzará a contar desde el siguiente día hábil.</p>
			<p>Puedes consultar el estado de tu pedido en tu cuenta o enviarnos un WhatsApp al <?php echo TELEMPRESA; ?> si necesitas asistencia.</p>
			<h4>¡Gracias por tu compra!</h4>
			<br>
			<h4>Respaldos Chile - Redeco Muebles</h4>
		</div>
	</div>									
</body>
</html>
