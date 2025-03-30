<?php 
headerTienda($data);
 ?>


<?php
$date = new DateTime();
// $date->format('Y-m-d H:i:s');
?>
<div class="text-center" style="background-color:white; padding: 20px; border-radius: 5px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
<div style="background-color: #BC0202; padding: 20px; border-radius: 5px; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 30px;">
<img src="<?= media(); ?>/images/logoblanco.png" alt="Logo" style="width: 200px;">       
<h1 class="display-4" style="color: white;">¡Gracias por tu compra!</h1>
        <p class="lead" style="color: white;">Tu pedido fue procesado con éxito.</p>
        <p style="color: white;">No. Orden: <strong> <?= $data['orden']; ?> </strong></p>
    </div>

        <!-- Timeline Start -->
        <div style="max-width: 960px; margin: auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; position: relative;">
        <div style="position: absolute; width: 100%; height: 2px; background-color: #ccc; top: 20px;"></div> <!-- Timeline grey bar -->
        <div style="position: absolute; width: 25%; height: 2px; background-color: green; top: 20px;"></div> <!-- Timeline green bar -->
        <div style="flex-grow: 1; text-align: center; position: relative;">
            <div style="width: 30px; height: 30px; border-radius: 50%; background-color: green; color: white; display: flex; justify-content: center; align-items: center; position: absolute; top: -15px; left: 50%; transform: translateX(-50%); z-index: 2;">
                <i class="fas fa-check"></i>
            </div>
            <p style="position: absolute; top: 35px; width: 100%; font-size: 12px;">Orden Creada</p>
        </div>
        <div style="flex-grow: 1; text-align: center; position: relative;">
            <div style="width: 30px; height: 30px; border-radius: 50%; background-color: #ccc; color: white; display: flex; justify-content: center; align-items: center; position: absolute; top: -15px; left: 50%; transform: translateX(-50%); z-index: 2;">
                <i class="fas fa-sync-alt"></i>
            </div>
            <p style="position: absolute; top: 35px; width: 100%; font-size: 12px;">Pedido en Preparación</p>
        </div>
        <div style="flex-grow: 1; text-align: center; position: relative;">
            <div style="width: 30px; height: 30px; border-radius: 50%; background-color: #ccc; color: white; display: flex; justify-content: center; align-items: center; position: absolute; top: -15px; left: 50%; transform: translateX(-50%); z-index: 2;">
                <i class="fas fa-truck"></i>
            </div>
            <p style="position: absolute; top: 35px; width: 100%; font-size: 12px;">Pedido en Despacho</p>
        </div>
        <div style="flex-grow: 1; text-align: center; position: relative;">
            <div style="width: 30px; height: 30px; border-radius: 50%; background-color: #ccc; color: white; display: flex; justify-content: center; align-items: center; position: absolute; top: -15px; left: 50%; transform: translateX(-50%); z-index: 2;">
                <i class="fas fa-home"></i>
            </div>
            <p style="position: absolute; top: 35px; width: 100%; font-size: 12px;">Pedido Entregado</p>
        </div>
    </div>
</div> <!-- Timeline FIN -->

<br><br>

<div>
<div style="display: flex; flex-wrap: wrap; max-width: 960px; margin: auto; margin-top:15px; padding: 20px; background-color: #f9f9f9; border-radius: 5px; border: 1px solid #ccc; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
<div style="flex: 1;  margin-right: 20px; border-radius: 5px; background-color: #FFFFFF;  align-items: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);" >
        <h3>Datos de Pago</h3>
        <?php if(!empty($data['status_transbank'])): ?>
            <p>Tarjeta : <strong> ************<?= $data['tarjeta']; ?> </strong></p>
            <p>Tipo de pago: <strong> <?= $data['tipodepago']; ?> </strong></p>
            <p>Fecha de Transacción: <strong> <?= $data['fecha_transaccion']; ?> </strong></p>
            <p>Codigo de Autorización: <strong> <?= $data['authorization_code']; ?> </strong></p>
        <?php else: ?>
          <div id="depositobancario" style="background-color: #f9f9f9; padding: 20px; margin-top: 20px; border-radius: 5px; border: 1px solid #ccc; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <p>Por favor, realiza la transferencia antes de 48 horas. Después de este periodo, el pedido será anulado.</p>
    <br>
    <strong>
        <p>Respaldos Chile SPA</p>
        <p>Banco de Crédito e Inversiones (BCI)</p>
        <p>Tipo de cuenta: Cuenta Corriente</p>
        <p>Cuenta: 46328157</p>
        <p>RUT: 77.186.031-1</p>
        <p>Mensaje: Pedido 000<?= $data['orden']; ?></p>
        <p>Correo: contacto@respaldoschile.cl</p>
        <p>Monto: $<?= number_format($data['monto_total'], 0, ',', '.'); ?></p>
    </strong>
</div>
        <?php endif; ?>

        <div id="transferencias" style="background-color: #f9f9f9;font-size:12px; padding: 5px; margin:5px; margin-top: 20px;margin-bottom:15px; border-radius: 5px; border: 1px solid #ccc; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <i class="fas fa-info-circle" style="color: #007BFF;"></i> Plazo de entrega: 3 a 7 días hábiles
        </div>
    </div>
    
    <div style="flex: 1;" style="margin-top:15px;">
        <h3>Productos</h3>
        <?php foreach ($data['detalle'] as $producto): ?>
        <div class="producto-item" style="margin-bottom: 10px;margin-top:20px; border: 1px solid #ddd; padding: 15px; border-radius: 5px; background-color: #FFFFFF; display: flex; align-items: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <div class="producto-imagen" style="flex-shrink: 0; margin-right: 15px;">
        <img src="<?= media() . '/images/uploads/' . htmlspecialchars($producto['img']) ?>" alt="<?= htmlspecialchars($producto['producto']) ?>" style=" height: 50px; border-radius: 50%;">
    </div> <!-- Contenedor del nombre y detalles del producto -->
            <div class="producto-info" style="flex-grow: 1;">
                <!-- Nombre y cantidad del producto -->
                <div class="producto-nombre" style="font-weight: bold; text-align:left; font-size: 15px; margin-bottom: 5px;">
                    <?= htmlspecialchars($producto['cantidad']) ?> x <?= htmlspecialchars($producto['producto']) ?>
                </div>
                
                <!-- Detalles del producto -->
                <div class="producto-detalle" style="display: flex; gap: 5px; font-size: 11px;">
                    <div class="producto-color" style="border-radius: 5px; background-color: #e9e9e9; padding: 2px 5px;">
                    Color: <?= htmlspecialchars(ucwords(strtolower($producto['color']))) ?>
                    </div>
                    <div class="producto-tamano" style="border-radius: 5px; background-color: #e9e9e9; padding: 2px 5px;">
                        Tamaño: <?= htmlspecialchars($producto['tamano']) ?>
                    </div>
                    <?php if ($producto['altura_base'] != ''): ?>
                        <div class="producto-alturabase" style="border-radius: 5px; background-color: #e9e9e9; padding: 2px 5px;">
                            Base: <?= htmlspecialchars($producto['altura_base']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>


</div>

        <?php if(!empty($data['transaccion'])): ?>
            <p>Transacción: <strong> <?= $data['transaccion']; ?> </strong></p>
        <?php endif; ?>
        <hr class="my-4">
      
        <p>Muy pronto estaremos en contacto para coordinar la entrega.</p>
        <p>Puedes ver el estado de tu pedido en la sección pedidos de tu usuario.</p><br>
        <a class="btn btn-lg" href="<?= base_url()."/tienda"; ?>" role="button" style="background-color: #BC0202; color:white;">Continuar</a>
          </div>
</div>
<div style=" margin-top:15px; height: 3px; width: 100%; background: linear-gradient(271.95deg, #d60303 9.78%, #333 33.12%, #ff0202 58.36%, #333333 91.52%);"></div>

<?php 
	footerTienda($data);
?>