<?php headerTienda($data); ?>

<br><br><br>
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

<div class="container" style="margin-top: 50pt;">
  <main class="app-content">
    <div class="app-title">
      <div></div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <?php if (empty($data['arrPedido'])) { ?>
            <p>Datos no encontrados</p>
          <?php } else {
            $cliente = $data['arrPedido']['cliente'];
            $orden = $data['arrPedido']['orden'];
            $detalle = $data['arrPedido']['detalle'];
            $transaccion = $orden['idtransaccionpaypal'] != "" ? 
                           $orden['idtransaccionpaypal'] : 
                           $orden['referenciacobro'];
          ?>
            <section id="sPedido" class="invoice">
              <div class="row mb-4">
                <div class="col-6">
                  <h2 class="page-header">
                    <img src="<?= media(); ?>/tienda/images/logo2.png" width="80">
                  </h2>
                </div>
                <div class="col-6 text-right">
                  <h5>Fecha: <?= $orden['fecha'] ?></h5>
                </div>
              </div>
              <div class="row invoice-info">
                <div class="col-4">
                  <address>
                    <strong><?= NOMBRE_EMPESA; ?></strong><br>
                    <?= DIRECCION ?><br>
                    <?= TELEMPRESA ?><br>
                    <?= EMAIL_EMPRESA ?><br>
                    <?= WEB_EMPRESA ?>
                  </address>
                </div>
                <div class="col-4">
                  <address>
                    <strong><?= $cliente['nombres'].' '.$cliente['apellidos'].' '.$cliente['identificacion']; ?></strong><br>
                    Envío: <?= $orden['direccion_envio']; ?><br>
                    Tel: <?= $cliente['telefono'] ?><br>
                    Email: <?= $cliente['email_user'] ?>
                  </address>
                </div>
                <div class="col-4 text-right">
                  <b>Orden #<?= $orden['idpedido'] ?></b><br>
                  <b>Pago: </b><?= $orden['tipopagoid'] ?><br>
                  <b>Transacción:</b> <?= $transaccion ?> <br>
                  <b>Estado:</b> <?= $orden['status'] ?> <br>
                  <b>Monto:</b> <?= SMONEY.' '. formatMoney($orden['monto']) ?>
                </div>
              </div>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Descripción</th>
                        <th class="text-right">Precio</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-right">Importe</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $subtotal = 0;
                        if (count($detalle) > 0) {
                          foreach ($detalle as $producto) {
                            $subtotal += $producto['cantidad'] * $producto['precio'];
                            $detalleProducto = "";

                            if (!empty($producto['tamano'])) { $detalleProducto .= $producto['tamano']; }
                            if (!empty($producto['tipo_tela'])) { $detalleProducto .= ' ' . $producto['tipo_tela']; }
                            if (!empty($producto['color'])) { $detalleProducto .= ' ' . $producto['color']; }
                            if (!empty($producto['altura_base'])) { $detalleProducto .= ' ' . $producto['altura_base']; }
                      ?>
                        <tr>
                          <td><?= $producto['codigo'] . " " . $producto['producto'] . ' ' . $detalleProducto; ?></td>
                          <td class="text-right"><?= SMONEY . ' ' . formatMoney($producto['precio']) ?></td>
                          <td class="text-center"><?= $producto['cantidad'] ?></td>
                          <td class="text-right"><?= SMONEY . ' ' . formatMoney($producto['cantidad'] * $producto['precio']) ?></td>
                        </tr>
                      <?php 
                          }
                        }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="3" class="text-right">Sub-Total:</th>
                        <td class="text-right"><?= SMONEY . ' ' . formatMoney($subtotal) ?></td>
                      </tr>
                      <tr>
                        <th colspan="3" class="text-right">Envío:</th>
                        <td class="text-right"><?= SMONEY . ' ' . formatMoney($orden['costo_envio']) ?></td>
                      </tr>
                      <tr>
                        <th colspan="3" class="text-right">Total:</th>
                        <td class="text-right"><?= SMONEY . ' ' . formatMoney($orden['monto']) ?></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                  <a class="btn btn-primary" href="javascript:window.print('#sPedido');">
                    <i class="fa fa-print"></i> Imprimir
                  </a>
                </div>
              </div>
            </section>
          <?php } ?>
        </div>
      </div>
    </div>
  </main>
</div>

<?php footerTienda($data); ?>
