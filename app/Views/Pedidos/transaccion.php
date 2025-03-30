<?php headerAdmin($data); ?>
<div id="divModal"></div>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-file-text-o"></i> <?= $data['page_title'] ?></h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?= base_url(); ?>/pedidos"> Pedidos</a></li>
    </ul>
  </div>


   <?php
echo "algo";

  /* FUNCION QUE OBTIENE DE TRANSBANK SEGUN LOS DATOS AGREGADOS EN PARAMETROS */
                                                function get_ws($data,$method,$type,$endpoint){
                                                $curl = curl_init();
                                               
                                                    /* AMBIENTE DE PRODUCCION */

                                                    $TbkApiKeyId='597045358953';
                                                    $TbkApiKeySecret='4db548a2-9ceb-4da1-8acb-750dce0435ec';
                                                     $url="https://webpay3g.transbank.cl".$endpoint;//Live
                                                     /* AMBIENTE DE INTEGRACIÓN 
                                                     $TbkApiKeyId='597055555532';
                                                     $TbkApiKeySecret='579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';
                                                         $url="https://webpay3gint.transbank.cl/".$endpoint;*/

                                                    
                                                
                                                curl_setopt_array($curl, array(
                                                  CURLOPT_URL => $url,
                                                  CURLOPT_RETURNTRANSFER => true,
                                                  CURLOPT_ENCODING => '',
                                                  CURLOPT_MAXREDIRS => 10,
                                                  CURLOPT_TIMEOUT => 0,
                                                  CURLOPT_FOLLOWLOCATION => true,
                                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                  CURLOPT_CUSTOMREQUEST => $method,
                                                  CURLOPT_POST => true,
                                                  CURLOPT_POSTFIELDS => $data,
                                                  CURLOPT_HTTPHEADER => array(
                                                    'Tbk-Api-Key-Id: '.$TbkApiKeyId.'',
                                                    'Tbk-Api-Key-Secret: '.$TbkApiKeySecret.'',
                                                    'Content-Type: application/json'
                                                  ),
                                                ));
                                                
                                                $response = curl_exec($curl);
                                                
                                                curl_close($curl);
                                                //echo $response;
                                                return json_decode($response);
                                            }



$baseurl = "https://" . $_SERVER['HTTP_HOST'] . "/tienda2/carrito/metododepago";
$url="https://webpay3g.transbank.cl/";//Live
//$url="https://webpay3gint.transbank.cl/";//Testing

/* ACTION INIT SE REFIERE A MODO PRODUCCION O TRANSACCION ABIERTO */
$action = 'getResult';
$message=null;
$post_array = false;

switch ($action) {

case "getResult":
        
        if (!isset($_GET["token_ws"]))
            break;

        /** Token de la transacción */
        $token = filter_input(INPUT_GET, 'token_ws');
        
        $request = array(
            "token" => filter_input(INPUT_GET, 'token_ws')
        );
        
        $data='';
    $method='GET';
    $type='sandbox';
    $endpoint='/rswebpaytransaction/api/webpay/v1.0/transactions/'.$token;
    
        $response = get_ws($data,$method,$type,$endpoint);
       
        $message.= "<pre>";
       echo   $message.= print_r($response,TRUE);
        $message.= "</pre>";
        
        $url_tbk = $baseurl."?action=refund";
        $submit='Refund!';
        break;

   }
?>


 <!-- <div class="row">
    <div class="col-md-12">
      <div class="tile">
       




        <?php
          //dep($data['objTransaccion']);
          if(empty($data['objTransaccion'])){
        ?>
        <p>Datos no encontrados</p>
        <?php }else{

            $trs = $data['objTransaccion']->purchase_units[0];
            $cl = $data['objTransaccion']->payer;
            $idTransaccion = $trs->payments->captures[0]->id;
            $fecha = $trs->payments->captures[0]->create_time;
            $estado = $trs->payments->captures[0]->status;
            $monto = $trs->payments->captures[0]->amount->value;
            $moneda = $trs->payments->captures[0]->amount->currency_code;
            //Datos del cliente
            $nombreCliente = $cl->name->given_name.' '.$cl->name->surname;
            $emailCliente = $cl->email_address;
            $telCliente = isset($cl->phone) ? $cl->phone->phone_number->national_number : "";
            $codCiudad =  $cl->address->country_code;

            $direccion1 = $trs->shipping->address->address_line_1;
            $direccion2 = $trs->shipping->address->admin_area_2;
            $direccion3 = $trs->shipping->address->admin_area_1;
            $codPostal = $trs->shipping->address->postal_code;
            //Correo Comercio
            $emailComercio = $trs->payee->email_address;
            //Detalle
            $descripcion = $trs->description;
            $montoDetalle = $trs->amount->value; 
            //Detalle montos 
            $totalCompra =  $trs->payments->captures[0]->seller_receivable_breakdown->gross_amount->value;
            $comision =  $trs->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value; 
            $importeNeto =  $trs->payments->captures[0]->seller_receivable_breakdown->net_amount->value;
            //Reembolso
            $reembolso = false;
            if(isset($trs->payments->refunds)){
                $reembolso = true;
                $importeBruto = $trs->payments->refunds[0]->seller_payable_breakdown->gross_amount->value;
                $comisionPaypal = $trs->payments->refunds[0]->seller_payable_breakdown->paypal_fee->value;
                $importeNeto = $trs->payments->refunds[0]->seller_payable_breakdown->net_amount->value;
                $fechaReembolso = $trs->payments->refunds[0]->update_time;
            }


         ?>
        <section id="sPedido" class="invoice">
          <div class="row mb-4">
            <div class="col-6">
              <h2 class="page-header"><img src="<?= media(); ?>/images/img-paypal.jpg" ></h2>
            </div>
            <?php if(!$reembolso){
                    if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['idrol'] != RCLIENTES ){
             ?>
            <div class="col-6 text-right">
              <button class="btn btn-outline-primary" onclick="fntTransaccion('<?= $idTransaccion ?>');"><i class="fa fa-reply-all" aria-hidden="true"></i> Hacer Reembolso </button>
            </div>
            <?php   }
                 } ?>
          </div>
          <div class="row invoice-info">
            <div class="col-4">
              <address><strong>Transacción: <?= $idTransaccion; ?></strong><br><br>
                <strong>Fecha: <?= $fecha; ?></strong><br>
                <strong>Estado: <?= $estado; ?></strong><br>
                <strong>Importe bruto: <?= $monto; ?></strong><br>
                <strong>Moneda: <?= $moneda; ?></strong><br>
              </address>
            </div>
            <div class="col-4">
              <address><strong>Enviado por:</strong><br><br>
                <strong>Nombre:</strong> <?= $nombreCliente ?> <br>
                <strong>Teléfono:</strong> <?= $telCliente ?> <br>
                <strong>Dirección:</strong> <?= $direccion1 ?> <br>
                <?= $direccion2.', '.$direccion3.' '.$codPostal ?> <br>
                 <?= $codCiudad ?>
               </address>
            </div>
            <div class="col-4"><strong>Enviado a:</strong> <br><br>
                <strong>Email: </strong> <?= $emailComercio ?> <br>
            </div>
          </div>
          <div class="row">
            <div class="col-12 table-responsive">
            <?php if($reembolso){ ?>
              <table class="table table-sm">
                <thead class="thead-light">
                  <tr>
                    <th>Movimiento</th>
                    <th class="text-right">Importe bruto</th>
                    <th class="text-right">Comisión</th>
                    <th class="text-right">Importe neto</th>
                  </tr>
                </thead>
                <tbody>
                <?php if( $_SESSION['userData']['idrol'] == RCLIENTES ) { ?>
                  <tr>
                    <td><?= $fechaReembolso.' Reembolso para '.$nombreCliente ?></td>
                    <td class="text-right">- <?= $importeBruto.' '.$moneda ?></td>
                    <td class="text-right">0.00 </td>
                    <td class="text-right">- <?= $importeBruto.' '.$moneda ?></td>
                  </tr>
              <?php }else{ ?>
                  <tr>
                    <td><?= $fechaReembolso.' Reembolso para '.$nombreCliente ?></td>
                    <td class="text-right">- <?= $importeBruto.' '.$moneda ?></td>
                    <td class="text-right">- <?= $comisionPaypal.' '.$moneda ?> </td>
                    <td class="text-right">- <?= $importeNeto.' '.$moneda ?></td>
                  </tr>
                  <tr>
                    <td><?= $fechaReembolso ?> Cancelación de la comisión de PayPal</td>
                    <td class="text-right"><?= $comisionPaypal.' '.$moneda ?></td>
                    <td class="text-right">0.00 <?= $moneda ?></td>
                    <td class="text-right"><?= $comisionPaypal.' '.$moneda ?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            <?php } ?>


              <table class="table table-sm">
                <thead class="thead-light">
                  <tr>
                    <th>Detalle pedido</th>
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">Precio</th>
                    <th class="text-right">Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?= $descripcion ?></td>
                    <td class="text-right">1</td>
                    <td class="text-right"><?= $monto.' '.$moneda ?></td>
                    <td class="text-right"><?= $monto.' '.$moneda ?></td>
                  </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total de la compra:</th>
                        <td class="text-right"><?= $monto.' '.$moneda ?></td>
                    </tr>
                </tfoot>
              </table>
              <?php if( $_SESSION['userData']['idrol'] != RCLIENTES ){ ?>
              <table class="table table-sm">
                  <thead class="thead-light">
                      <tr>
                        <th colspan="2">Detalles del pago</th>
                      </tr>
                  </thead>
                  <tbody>
                       <tr>
                          <td width="250"><strong>Total de la compra</strong></td>
                          <td><?= $totalCompra.' '.$moneda ?></td>
                      </tr>
                      <tr>
                          <td><strong>Comisión de PayPal</strong></td>
                          <td>- <?= $comision.' '.$moneda ?></td>
                      </tr>
                      <tr>
                          <td><strong>Importe neto</strong></td>
                          <td><?= $importeNeto.' '.$moneda ?></td>
                      </tr>
                  </tbody>
              </table>
                <?php } ?>

            </div>
          </div>
          <div class="row d-print-none mt-2">
            <div class="col-12 text-right"><a class="btn btn-primary" href="javascript:window.print('#sPedido');" ><i class="fa fa-print"></i> Imprimir</a></div>
          </div>
        </section>
        <?php } ?>
      </div>
    </div>
  </div> -->
</main>
<?php footerAdmin($data); ?>